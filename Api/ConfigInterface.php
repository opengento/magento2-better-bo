<?php

declare(strict_types=1);

namespace Opengento\BetterBo\Api;

interface ConfigInterface
{
    public const ATTRIBUTES_FIELDS_TYPE_PATH = 'better_bo/general/attributes_fields_type';

    /**
     * @return array
     */
    public function getAttributesFieldsType(): array;
}
