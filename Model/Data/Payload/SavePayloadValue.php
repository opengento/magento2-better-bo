<?php

/**
 * SavePayloadValue
 *
 * @copyright Copyright © 2024 Blackbird Agency. All rights reserved.
 * @author    sebastien@bird.eu
 */

declare(strict_types=1);

namespace Opengento\BetterBo\Model\Data\Payload;

use Opengento\BetterBo\Api\Data\SavePayloadValueInterface;

class SavePayloadValue implements SavePayloadValueInterface
{
    /**
     * @var string
     */
    protected string $value;

    /**
     * @var string
     */
    protected string $storeViewId;

    /**
     * @inheritDoc
     */
    public function setStoreViewId(string $storeViewId): void
    {
        $this->storeViewId = $storeViewId;
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

    /**
     * @param string $value
     * @return void
     */
    public function setValue(string $value): void
    {
        $this->value = $value;
    }
}
