<?php

declare(strict_types=1);

namespace Opengento\BetterBo\Model;

use Opengento\BetterBo\Api\ConfigInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;

class Config implements ConfigInterface
{
    public function __construct(
        protected ScopeConfigInterface $scopeConfig
    ) {
    }

    /**
     * @inheritdoc
     */
    public function getAttributesFieldsType(): array
    {
        return \explode(',', $this->scopeConfig->getValue(self::ATTRIBUTES_FIELDS_TYPE_PATH) ?: '');
    }
}
