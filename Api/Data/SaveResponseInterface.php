<?php

namespace Opengento\BetterBo\Api\Data;

interface SaveResponseInterface
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
     * @return \Opengento\BetterBo\Api\Data\SaveResponseValueInterface|null
     */
    public function getData(): ?\Opengento\BetterBo\Api\Data\SaveResponseValueInterface;

    /**
     * @param \Opengento\BetterBo\Api\Data\SaveResponseValueInterface $data
     * @return void
     */
    public function setData(\Opengento\BetterBo\Api\Data\SaveResponseValueInterface $data): void;
}
