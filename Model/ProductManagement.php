<?php

/**
 * GetProductAttributes
 *
 * @copyright Copyright © 2024 Blackbird Agency. All rights reserved.
 * @author    sebastien@bird.eu
 */

declare(strict_types=1);

namespace Opengento\BetterBo\Model;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Serialize\SerializerInterface;
use Opengento\BetterBo\Api\Data\GetPayloadInterface;
use Opengento\BetterBo\Api\Data\GetPayloadInterfaceFactory;
use Opengento\BetterBo\Api\Data\SavePayloadInterfaceFactory;
use Opengento\BetterBo\Api\Data\SavePayloadInterface;
use Opengento\BetterBo\Api\Data\SavePayloadValueInterface;
use Opengento\BetterBo\Api\Data\SaveResponseInterface;
use Opengento\BetterBo\Api\Data\SaveResponseInterfaceFactory;
use Opengento\BetterBo\Api\GetProductAttributesInterface;
use Opengento\BetterBo\Api\ProductManagementInterface;
use Opengento\BetterBo\Model\Exception\PayloadValidationException;
use function array_column;

class ProductManagement implements ProductManagementInterface
{
    public const TYPE_SUCCESS = 'success';
    public const TYPE_ERROR = 'error';

    public function __construct(
        protected GetPayloadInterfaceFactory    $getPayloadFactory,
        protected SavePayloadInterfaceFactory   $savePayloadInterfaceFactory,
        protected SerializerInterface           $serializer,
        protected GetProductAttributesInterface $getProductAttributes,
        protected SaveProductAttributes $saveProductAttributes,
        protected SaveResponseInterfaceFactory $saveResponseInterfaceFactory
    )
    {
    }

    /**
     * @param string $entityId
     * @param string $attributeCode
     * @param SavePayloadValueInterface[] $values
     * @return SaveResponseInterface
     */
    public function saveProductData(string $entityId, string $attributeCode, array $values): SaveResponseInterface
    {
        $result = $this->saveResponseInterfaceFactory->create();

        try {
            $payload = $this->initSavePayload($entityId, $attributeCode, $values);
            $response = $this->saveProductAttributes->execute(
                $payload
            );

            $result->setType(self::TYPE_SUCCESS);
            $result->setData($response);
            $result->setMessage('');
        } catch (PayloadValidationException $e) {
            $result->setType(self::TYPE_ERROR);
            $result->setMessage($e->getMessage());
        }

        return $result;
    }

    /**
     * @param string $entityId
     * @param string $attributeCode
     * @return string
     */
    public function getProductData(string $entityId, string $attributeCode): string
    {
        $result = [
            'type' => self::TYPE_ERROR,
            'message' => '',
            'data' => []
        ];

        try {
            $payload = $this->initGetPayload($entityId, $attributeCode);
            $result['data'] = $this->getProductAttributes->execute($payload);
            $result['type'] = self::TYPE_SUCCESS;
        } catch (PayloadValidationException $e) {
            $result['message'] = $e->getMessage();
        } catch (NoSuchEntityException $e) {
            $result['message'] = __('Unable to retrieve entity: %1', $e->getMessage());
        }

        return $this->serializer->serialize($result);
    }

    /**
     * @throws PayloadValidationException
     */
    protected function initGetPayload(string $entityId, string $attributeCode): GetPayloadInterface
    {
        if (empty($entityId) || empty($attributeCode)) {
            throw new PayloadValidationException(__('Invalid payload'));
        }

        /** @var GetPayloadInterface $getPayload */
        $getPayload = $this->getPayloadFactory->create();

        $getPayload->setAttributeCode($attributeCode);
        $getPayload->setEntityId((int)$entityId);

        return $getPayload;
    }

    /**
     * @throws PayloadValidationException
     */
    protected function initSavePayload(string $entityId, string $attributeCode, array $values): SavePayloadInterface
    {
        if (empty($entityId) || empty($attributeCode) || empty($values)) {
            throw new PayloadValidationException(__('Invalid SavePayload'));
        }

        /** @var SavePayloadInterface $payload */
        $payload = $this->savePayloadInterfaceFactory->create();
        $payload->setEntityId((int)$entityId);
        $payload->setValues($values);
        $payload->setAttributeCode($attributeCode);

        return $payload;
    }
}
