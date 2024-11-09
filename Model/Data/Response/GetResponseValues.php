<?php

/**
 * GetResponseValue
 *
 * @copyright Copyright © 2024 Blackbird Agency. All rights reserved.
 * @author    sebastien@bird.eu
 */

declare(strict_types=1);

namespace Opengento\BetterBo\Model\Data\Response;

use Opengento\BetterBo\Api\Data\GetResponseValuesInterface;

class GetResponseValues implements GetResponseValuesInterface
{
    /**
     * @var string
     */
    protected string $storeViewId;

    /**
     * @var string
     */
    protected string $storeViewLabel;

    /**
     * @var string
     */
    protected string $value;

    /**
     * @return string
     */
    public function getStoreViewId(): string
    {
        return $this->storeViewId;
    }

    /**
     * @param string $storeViewId
     * @return void
     */
    public function setStoreViewId(string $storeViewId): void
    {
        $this->storeViewId = $storeViewId;
    }

    /**
     * @return string
     */
    public function getStoreViewLabel(): string
    {
        return $this->storeViewLabel;
    }

    /**
     * @param string $storeViewLabel
     * @return void
     */
    public function setStoreViewLabel(string $storeViewLabel): void
    {
        $this->storeViewLabel = $storeViewLabel;
    }

    /**
     * @return string
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
