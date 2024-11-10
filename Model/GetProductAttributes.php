<?php

/**
 * GetProductAttributes
 *
 * @copyright Copyright © 2024 Blackbird Agency. All rights reserved.
 * @author    sebastien@bird.eu
 */

declare(strict_types=1);

namespace Opengento\BetterBo\Model;

use Magento\Catalog\Api\Data\ProductAttributeInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\ResourceModel\Product\Attribute\CollectionFactory;
use Magento\Eav\Api\AttributeRepositoryInterface;
use Magento\Eav\Api\Data\AttributeOptionInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Api\Data\GroupInterface;
use Magento\Store\Api\Data\StoreInterface;
use Magento\Store\Api\GroupRepositoryInterface;
use Magento\Store\Model\StoreManagerInterface;
use Opengento\BetterBo\Api\Data\GetPayloadInterface;
use Opengento\BetterBo\Api\Data\GetResponseConfigInterface;
use Opengento\BetterBo\Api\Data\GetResponseConfigInterfaceFactory;
use Opengento\BetterBo\Api\Data\GetResponseConfigOptionsInterface;
use Opengento\BetterBo\Api\Data\GetResponseConfigOptionsInterfaceFactory;
use Opengento\BetterBo\Api\Data\GetResponseDataInterfaceFactory;
use Opengento\BetterBo\Api\Data\GetResponseDataInterface;
use Opengento\BetterBo\Api\Data\GetResponseValuesInterface;
use Opengento\BetterBo\Api\Data\GetResponseValuesInterfaceFactory;
use Opengento\BetterBo\Api\GetProductAttributesInterface;

class GetProductAttributes implements GetProductAttributesInterface
{
    /**
     * @var StoreInterface[]
     */
    protected array $stores = [];
    /**
     * @var GroupInterface[]
     */
    protected array $storeGroups = [];

    public function __construct(
        protected GroupRepositoryInterface                                       $groupRepository,
        protected AttributeRepositoryInterface                                   $attributeRepository,
        protected \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        protected StoreManagerInterface                                          $storeManager,
        protected ProductRepositoryInterface                                     $productRepository,
        protected GetResponseDataInterfaceFactory                                $getResponseDataInterfaceFactory,
        protected GetResponseConfigInterfaceFactory                              $getResponseConfigInterfaceFactory,
        protected GetResponseValuesInterfaceFactory                              $getResponseValuesInterfaceFactory,
        protected GetResponseConfigOptionsInterfaceFactory                       $getResponseConfigOptionsInterfaceFactory
    )
    {
    }

    /**
     * @inheritDoc
     * @throws NoSuchEntityException
     */
    public function execute(GetPayloadInterface $payload): GetResponseDataInterface
    {
        /** @var GetResponseDataInterface $response */
        $response = $this->getResponseDataInterfaceFactory->create();

        $response->setValues($this->getAttributeValues($payload));
        $response->setConfig($this->getAttributeConfig($payload->getAttributeCode()));

        return $response;
    }

    /**
     * Config and potentials options of attribute
     *
     * @param string $attributeCode
     * @return GetResponseConfigInterface
     * @throws NoSuchEntityException
     */
    protected function getAttributeConfig(string $attributeCode): GetResponseConfigInterface
    {
        /** @var GetResponseConfigInterface $result */
        $result = $this->getResponseConfigInterfaceFactory->create();

        $attribute = $this->attributeRepository->get(
            ProductAttributeInterface::ENTITY_TYPE_CODE,
            $attributeCode
        );

        $result->setType($attribute->getFrontendInput());
        $result->setFrontendLabel($attribute->getDefaultFrontendLabel());
        $formattedOptions = \array_map(
            function (AttributeOptionInterface $attributeOption)  {
                /** @var GetResponseConfigOptionsInterface $option */
                $option = $this->getResponseConfigOptionsInterfaceFactory->create();
                $option->setLabel((string) $attributeOption->getLabel());
                $option->setValue((string) $attributeOption->getValue());
                return $option;
            },
            $attribute->getOptions()
        );
        $result->setOptions($formattedOptions);

        return $result;
    }


    /**
     * @param GetPayloadInterface $payload
     * @return array
     * @throws NoSuchEntityException
     */
    protected function getAttributeValues(GetPayloadInterface $payload): array
    {
        $stores = $this->getStores();
        $results = [];

        foreach ($stores as $storeView) {
            $product = $this->productRepository->getById($payload->getEntityId(), storeId: $storeView->getId());
            /** @var GetResponseValuesInterface $result */
            $result = $this->getResponseValuesInterfaceFactory->create();
            $result->setValue($product->getData($payload->getAttributeCode()));
            $result->setStoreViewId((string)$storeView->getId());
            $result->setStoreViewLabel($this->buildStoreViewLabel($storeView));
            $results[] = $result;
        }

        $this->sortResults($results);
        return $results;
    }

    protected function getStores(): array
    {
        if (!$this->stores) {
            $this->stores = $this->storeManager->getStores();
        }
        return $this->stores;
    }

    protected function buildStoreViewLabel(StoreInterface $store): string
    {
        $group = $this->getStoreGroups()[$store->getStoreGroupId()];
        return sprintf('%s / %s', $group->getName(), $store->getName());
    }

    protected function getStoreGroups(): array
    {
        if (!$this->storeGroups) {
            $this->storeGroups = $this->groupRepository->getList();
        }
        return $this->storeGroups;
    }

    protected function sortResults(array &$results): void
    {
        usort($results, function ($a, $b) {
            return strcmp($a->getStoreViewLabel(), $b->getStoreViewLabel());
        });
    }
}
