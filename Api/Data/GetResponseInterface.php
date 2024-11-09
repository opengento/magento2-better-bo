<?php

namespace Opengento\BetterBo\Api\Data;

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
     * @return \Opengento\BetterBo\Api\Data\GetResponseDataInterface
     */
    public function getData(): \Opengento\BetterBo\Api\Data\GetResponseDataInterface;

    /**
     * @param \Opengento\BetterBo\Api\Data\GetResponseDataInterface $data
     * @return void
     */
    public function setData(\Opengento\BetterBo\Api\Data\GetResponseDataInterface $data): void;
}
