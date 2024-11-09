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
use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\ResourceModel\Product\Attribute\CollectionFactory;
use Magento\Eav\Api\AttributeRepositoryInterface;
use Magento\Eav\Api\Data\AttributeOptionInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\StoreManagerInterface;
use Opengento\BetterBo\Api\Data\GetPayloadInterface;
use Opengento\BetterBo\Api\GetProductAttributesInterface;
use PDepend\Util\Type;
use function array_map;

class GetProductAttributes implements GetProductAttributesInterface
{
    public function __construct(
        protected AttributeRepositoryInterface $attributeRepository,
        protected \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        protected StoreManagerInterface $storeManager,
        protected ProductRepositoryInterface $productRepository
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
            'options' => array_map(
                static fn (AttributeOptionInterface $option) => [
                    'label' => $option->getLabel(),
                    'value' => $option->getValue()
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
        $stores = $this->storeManager->getStores();
        $results = [];
        foreach ($stores as $storeView) {
            $product = $this->productRepository->getById($payload->getEntityId(), storeId: $storeView->getId());
            $results[] = [
                'storeViewId' => $storeView->getId(),
                'value' => $product->getData($payload->getAttributeCode())
            ];
        }

        return $results;
    }
}
