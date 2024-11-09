<?php

namespace Opengento\BetterBo\Api;

use Opengento\BetterBo\Api\Data\GetPayloadInterface;
use Opengento\BetterBo\Api\Data\GetResponseDataInterface;

interface GetProductAttributesInterface
{
    /**
     * @param GetPayloadInterface $payload
     * @return GetResponseDataInterface
     */
    public function execute(GetPayloadInterface $payload): GetResponseDataInterface;
}
