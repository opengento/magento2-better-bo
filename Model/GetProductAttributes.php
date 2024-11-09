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
    )
    {
    }

    /**
     * @inheritDoc
     * @throws NoSuchEntityException
     */
    public function execute(GetPayloadInterface $payload): array
    {
        return [
            'config' => $this->getAttributeConfig($payload->getAttributeCode()),
            'values' => $this->getAttributeValues($payload)
        ];
    }

    /**
     * Config and potentials options of attribute
     *
     * @param string $attributeCode
     * @return array
     * @throws NoSuchEntityException
     */
    protected function getAttributeConfig(string $attributeCode): array
    {
        $attribute = $this->attributeRepository->get(
            ProductAttributeInterface::ENTITY_TYPE_CODE,
            $attributeCode
        );

        return [
            'type' => $attribute->getFrontendInput(),
            'frontendLabel' => $attribute->getDefaultFrontendLabel(),
            'options' => array_map(
                static fn(AttributeOptionInterface $option) => [
                    'label' => $option->getLabel(),
                    'value' => (string)$option->getValue()
                ],
                $attribute->getOptions()
            ),
        ];
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
            $results[] = [
                'storeViewId' => $storeView->getId(),
                'storeViewLabel' => $this->buildStoreViewLabel($storeView),
                'value' => $product->getData($payload->getAttributeCode())
            ];
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
            return strcmp($a['storeViewLabel'], $b['storeViewLabel']);
        });
    }
}
