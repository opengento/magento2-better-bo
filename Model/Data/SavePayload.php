<?php

/**
 * SavePayload
 *
 * @copyright Copyright © 2024 Blackbird Agency. All rights reserved.
 * @author    sebastien@bird.eu
 */

declare(strict_types=1);

namespace Opengento\BetterBo\Model\Data;

use Opengento\BetterBo\Api\Data\SavePayloadInterface;

class SavePayload implements SavePayloadInterface
{
    protected ?array $values;

    protected ?string $attributeCode = '';

    protected ?int $entityId;

    public function getValues(): array
    {
        return $this->values;
    }

    public function setValues(array $values): void
    {
        $this->values = $values;
    }

    public function getEntityId(): int
    {
        return $this->entityId;
    }

    public function setEntityId(int $entityId): void
    {
        $this->entityId = $entityId;
    }

    public function getAttributeCode(): string
    {
        return $this->attributeCode;
    }

    public function setAttributeCode(string $attributeCode): void
    {
        $this->attributeCode = $attributeCode;
    }
}
