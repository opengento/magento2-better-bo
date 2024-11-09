<?php

/**
 * SavePayloadValue
 *
 * @copyright Copyright © 2024 Blackbird Agency. All rights reserved.
 * @author    sebastien@bird.eu
 */

declare(strict_types=1);

namespace Opengento\BetterBo\Model\Data;

use Opengento\BetterBo\Api\Data\SavePayloadValueInterface;

class SavePayloadValue implements SavePayloadValueInterface
{
    protected string $value;

    protected string $storeViewId;

    /**
     * @inheritDoc
     */
    public function setStoreViewId(string $storeViewId): void
    {
        $this->storeId = $storeViewId;
    }

    /**
     * @inheritDoc
     */
    public function getStoreViewId(): string
    {
        return $this->storeViewId;
    }

    /**
     * @inheritDoc
     */
    public function getValue(): string
    {
        return $this->value;
    }

    public function setValue(string $value): void
    {
        $this->value = $value;
    }
}
