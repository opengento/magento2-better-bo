<?php

/**
 * SaveResponse
 *
 * @copyright Copyright © 2024 Blackbird Agency. All rights reserved.
 * @author    sebastien@bird.eu
 */

declare(strict_types=1);

namespace Opengento\BetterBo\Model\Data\Delete;

use Opengento\BetterBo\Api\Data\DeletePayloadInterface;

class DeletePayload implements DeletePayloadInterface
{
    protected int $entityId;
    protected int $storeViewId;
    public string $attributeCode;

    public function getEntityId(): int
    {
        return $this->entityId;
    }

    public function setEntityId(int $entityId): void
    {
        $this->entityId = $entityId;
    }

    public function getStoreViewId(): int
    {
        return $this->storeViewId;
    }

    public function setStoreViewId(int $storeViewId): void
    {
        $this->storeViewId = $storeViewId;
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
