<?php

namespace Opengento\BetterBo\Api\Data;

interface SaveResponseValueInterface
{
    /**
     * @return string[]
     */
    public function getSuccess(): array;

    /**
     * @param string[] $success
     * @return void
     */
    public function setSuccess(array $success): void;

    /**
     * @return string[]
     */
    public function getError(): array;

    /**
     * @param string[] $error
     * @return void
     */
    public function setError(array $error): void;
}
