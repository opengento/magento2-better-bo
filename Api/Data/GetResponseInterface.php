<?php


namespace Opengento\BetterBo\Api\Data;

use Magento\Tests\NamingConvention\true\string;

interface GetResponseInterface
{
    /**
     * @return string
     */
    public function getType(): string;

    /**
     * @param string $type
     * @return void
     */
    public function setType(string $type): void;

    /**
     * @return string
     */
    public function getMessage(): string;

    /**
     * @param string $message
     * @return void
     */
    public function setMessage(string $message): void;

    /**
     * @return array
     */
    public function getData(): array;

    /**
     * @param array $data
     * @return void
     */
    public function setData(array $data): void;
}
