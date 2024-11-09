<?php


namespace Opengento\BetterBo\Api\Data;

interface GetResponseConfigInterface
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
    public function getFrontendLabel(): string;

    /**
     * @param string $frontendLabel
     * @return void
     */
    public function setFrontendLabel(string $frontendLabel): void;

    /**
     * @return \Opengento\BetterBo\Api\Data\GetResponseConfigOptionsInterface[]
     */
    public function getOptions(): array;

    /**
     * @param \Opengento\BetterBo\Api\Data\GetResponseConfigOptionsInterface[] $options
     * @return void
     */
    public function setOptions(array $options): void;
}
