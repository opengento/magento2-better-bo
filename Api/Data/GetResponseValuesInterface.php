<?php


namespace Opengento\BetterBo\Api\Data;

interface GetResponseValuesInterface
{
    /**
     * @return string
     */
    public function getStoreViewId(): string;

    /**
     * @param string $storeViewId
     * @return void
     */
    public function setStoreViewId(string $storeViewId): void;

    /**
     * @return string
     */
    public function getStoreViewLabel(): string;

    /**
     * @param string $storeViewLabel
     * @return void
     */
    public function setStoreViewLabel(string $storeViewLabel): void;

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
