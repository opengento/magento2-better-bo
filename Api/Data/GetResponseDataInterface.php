<?php


namespace Opengento\BetterBo\Api\Data;

interface GetResponseDataInterface
{
    /**
     * @return \Opengento\BetterBo\Api\Data\GetResponseConfigInterface
     */
    public function getConfig(): \Opengento\BetterBo\Api\Data\GetResponseConfigInterface;

    /**
     * @param \Opengento\BetterBo\Api\Data\GetResponseConfigInterface $config
     * @return void
     */
    public function setConfig(\Opengento\BetterBo\Api\Data\GetResponseConfigInterface $config): void;

    /**
     * @return \Opengento\BetterBo\Api\Data\GetResponseValuesInterface[]
     */
    public function getValues(): array;

    /**
     * @param \Opengento\BetterBo\Api\Data\GetResponseValuesInterface[] $values
     * @return void
     */
    public function setValues(array $values): void;
}
