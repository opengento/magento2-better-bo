<?php

/**
 * SaveProductAttributes
 *
 * @copyright Copyright © 2024 Blackbird Agency. All rights reserved.
 * @author    sebastien@bird.eu
 */

declare(strict_types=1);

namespace Opengento\BetterBo\Model\Service;

use Exception;
use Magento\Catalog\Model\Product\Action;
use Opengento\BetterBo\Api\Data\DeletePayloadInterface;
use Opengento\BetterBo\Api\Data\DeleteResponseInterfaceFactory;

class DeleteProductAttribute
{
    public function __construct(
        protected Action                                                      $productAction,
        protected DeleteResponseInterfaceFactory $deleteResponseValueFactory
    ) {
    }

    /**
     * @param DeletePayloadInterface $payload
     * @return \Opengento\BetterBo\Api\Data\DeleteResponseInterface
     */
    public function execute(DeletePayloadInterface $payload): \Opengento\BetterBo\Api\Data\DeleteResponseInterface
    {
        $type = 'error';
        $message = '';

        try {
            $this->productAction->updateAttributes(
                [$payload->getEntityId()],
                [$payload->getAttributeCode() => null],
                $payload->getStoreViewId()
            );
            $type = 'success';
        } catch (Exception $e) {
            $message = $e->getMessage();
        }

        return $this->getResponse($type, $message);
    }

    protected function getResponse(string $type, string $message): \Opengento\BetterBo\Api\Data\DeleteResponseInterface
    {
        /** @var \Opengento\BetterBo\Api\Data\DeleteResponseInterface $response */
        $response = $this->deleteResponseValueFactory->create();
        $response->setMessage($message);
        $response->setType($type);
        return $response;
    }
}
