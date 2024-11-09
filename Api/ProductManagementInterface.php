<?php


namespace Opengento\BetterBo\Api;

use Opengento\BetterBo\Api\Data\SavePayloadValueInterface;

interface ProductManagementInterface
{
    /**
     * @param string $entityId
     * @param string $attributeCode
     * @return string
     */
    public function getProductData(string $entityId, string $attributeCode): string;

    /**
     * @param string $entityId
     * @param string $attributeCode
     * @param SavePayloadValueInterface[] $values
     * @return string
     */
    public function saveProductData(string $entityId, string $attributeCode, array $values): string;
}
