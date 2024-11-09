<?php


namespace Opengento\BetterBo\Api;

use Opengento\BetterBo\Api\Data\GetResponseInterface;
use Opengento\BetterBo\Api\Data\SavePayloadValueInterface;
use Opengento\BetterBo\Api\Data\SaveResponseInterface;

interface ProductManagementInterface
{
    /**
     * @param string $entityId
     * @param string $attributeCode
     * @return GetResponseInterface
     */
    public function getProductData(string $entityId, string $attributeCode): GetResponseInterface;

    /**
     * @param string $entityId
     * @param string $attributeCode
     * @param SavePayloadValueInterface[] $values
     * @return SaveResponseInterface
     */
    public function saveProductData(string $entityId, string $attributeCode, array $values): SaveResponseInterface;
}
