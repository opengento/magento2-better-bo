<?php

/**
 * SaveProductAttributes
 *
 * @copyright Copyright © 2024 Blackbird Agency. All rights reserved.
 * @author    sebastien@bird.eu
 */

declare(strict_types=1);

namespace Opengento\BetterBo\Model;

use Magento\Catalog\Model\Product\Action;
use Opengento\BetterBo\Api\Data\SavePayloadInterface;
use Opengento\BetterBo\Api\Data\SavePayloadValueInterface;
use Opengento\BetterBo\Api\Data\SaveResponseValueInterfaceFactory;

class SaveProductAttributes
{
    public function __construct(
        protected Action $productAction,
        protected SaveResponseValueInterfaceFactory $saveResponseValueFactory
    )
    {
    }

    /**
     * @param SavePayloadInterface $payload
     * @return \Opengento\BetterBo\Api\Data\SaveResponseValueInterface
     */
    public function execute(SavePayloadInterface $payload): \Opengento\BetterBo\Api\Data\SaveResponseValueInterface
    {
        $success = $error = [];

        $dataByStoreId = array_reduce(
            $payload->getValues(),
            static function ($r, SavePayloadValueInterface $value) use ($payload) {
                $r[$value->getStoreViewId()] = [
                    $payload->getAttributeCode() => $value->getValue()
                ];
                return $r;
            },
            []
        );

        foreach ($dataByStoreId as $storeId => $data) {
            try {
                $this->productAction->updateAttributes([$payload->getEntityId()], $data, $storeId);
                $success[] = $storeId;
            } catch (\Exception) {
                $error[] = $storeId;
            }
        }

        return $this->getResponse($success, $error);
    }

    protected function getResponse(array $success, array $error): \Opengento\BetterBo\Api\Data\SaveResponseValueInterface
    {
        /** @var \Opengento\BetterBo\Api\Data\SaveResponseValueInterface $response */
        $response = $this->saveResponseValueFactory->create();
        $response->setSuccess($success);
        $response->setError($error);

        return $response;
    }
}
