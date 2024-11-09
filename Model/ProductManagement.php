<?php

/**
 * GetProductAttributes
 *
 * @copyright Copyright © 2024 Blackbird Agency. All rights reserved.
 * @author    sebastien@bird.eu
 */

declare(strict_types=1);

namespace Opengento\BetterBo\Model;

use Magento\Framework\Serialize\SerializerInterface;
use Opengento\BetterBo\Api\Data\GetPayloadInterface;
use Opengento\BetterBo\Api\Data\GetPayloadInterfaceFactory;
use Opengento\BetterBo\Api\GetProductAttributesInterface;
use Opengento\BetterBo\Api\ProductManagementInterface;
use Opengento\BetterBo\Model\Exception\PayloadValidationException;

class ProductManagement implements ProductManagementInterface
{
    public const TYPE_SUCCESS = 'success';

    public function saveProductData(): string
    {
        return '';
    }

    public const TYPE_ERROR = 'error';

    public function __construct(
        protected GetPayloadInterfaceFactory $payloadFactory,
        protected SerializerInterface $serializer,
        protected GetProductAttributesInterface $getProductAttributes
    ) {
    }

    /**
     * @param string $entityId
     * @param string $attributeCode
     * @return string
     */
    public function getProductData(string $entityId, string $attributeCode): string
    {
        $result = [
            'type' => self::TYPE_SUCCESS,
            'message' => '',
            'data' => []
        ];

        try {
            $payload = $this->initPayload($entityId, $attributeCode);
            $result['data'] = $this->getProductAttributes->execute($payload);
        } catch (PayloadValidationException $e) {
            $result['type'] = self::TYPE_ERROR;
            $result['message'] = $e->getMessage();
        }

        return $this->serializer->serialize($result);
    }

    /**
     * @throws PayloadValidationException
     */
    protected function initPayload(string $entityId, string $attributeCode): GetPayloadInterface
    {
        /** @var GetPayloadInterface $getPayload */
        $getPayload = $this->payloadFactory->create();

        if (empty($entityId) || empty($attributeCode)) {
            throw new PayloadValidationException(__('Invalid payload'));
        }

        $getPayload->setAttributeCode($attributeCode);
        $getPayload->setEntityId((int)$entityId);

        return $getPayload;
    }
}
