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
use Opengento\BetterBo\Model\Exception\SaveException;

class SaveProductAttributes
{
    public function __construct(
        protected Action $productAction,
    )
    {
    }

    /**
     * @throws SaveException
     */
    public function execute(SavePayloadInterface $payload): void
    {
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

        try {
            foreach ($dataByStoreId as $storeId => $data) {
                $this->productAction->updateAttributes([$payload->getEntityId()], $data, $storeId);
            }
        } catch (\Exception $e) {
            throw new SaveException(__('Unable to save entity: %1', $e->getMessage()));
        }
    }
}
