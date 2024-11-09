<?php

namespace Opengento\BetterBo\Api;

use Opengento\BetterBo\Api\Data\GetPayloadInterface;

interface GetProductAttributesInterface
{
    /**
     * @param GetPayloadInterface $payload
     * @return string
     */
    public function execute(GetPayloadInterface $payload): array;
}
