<?php


namespace Opengento\BetterBo\Api;

interface ProductManagementInterface
{
    /**
     * @param string $entityId
     * @param string $attributeCode
     * @return string
     */
    public function getProductData(string $entityId, string $attributeCode): string;

    /**
     * @return string
     */
    public function saveProductData(): string;
}
