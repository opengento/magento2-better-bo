<?php


namespace Opengento\BetterBo\Api\Data;

interface SavePayloadValueInterface
{
    /**
     * @param string $storeId
     * @return void
     */
    public function setStoreViewId(string $storeId): void;

    /**
     * @return string
     */
    public function getStoreViewId(): string;

    /**
     * @return string
     */
    public function getValue(): string;

    /**
     * @param string $value
     * @return void
     */
    public function setValue(string $value): void;
}
