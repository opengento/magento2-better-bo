<?php

namespace Opengento\BetterBo\Api\Data;

interface SavePayloadInterface
{
    /**
     * @return SavePayloadInterface[]
     */
    public function getValues(): array;

    /**
     * @param SavePayloadInterface[] $values
     * @return void
     */
    public function setValues(array $values): void;

    /**
     * @return int
     */
    public function getEntityId(): int;

    /**
     * @param int $entityId
     * @return void
     */
    public function setEntityId(int $entityId): void;

    /**
     * @return string
     */
    public function getAttributeCode(): string;

    /**
     * @param string $attributeCode
     * @return void
     */
    public function setAttributeCode(string $attributeCode): void;
}
