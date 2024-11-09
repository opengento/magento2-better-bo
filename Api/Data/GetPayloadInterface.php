<?php

namespace Opengento\BetterBo\Api\Data;

interface GetPayloadInterface
{
    public function getAttributeCode(): string;

    public function setAttributeCode(string $attribute): void;

    public function getEntityId(): int;

    public function setEntityId(int $entityId): void;
}
