<?php

namespace Opengento\BetterBo\Model\Data\Get;

use Opengento\BetterBo\Api\Data\GetPayloadInterface;

class GetPayload implements GetPayloadInterface
{
    protected string $attributeCode;
    protected string $entityId;

    public function getAttributeCode(): string
    {
        return $this->attributeCode;
    }

    public function setAttributeCode(string $attribute): void
    {
        $this->attributeCode = $attribute;
    }

    public function getEntityId(): int
    {
        return $this->entityId;
    }

    public function setEntityId(int $entityId): void
    {
        $this->entityId = $entityId;
    }
}
