<?php

namespace Opengento\BetterBo\Api;

use Magento\Framework\Exception\AuthenticationException;

interface AuthenticatorInterface
{
    /**
     * @return string
     * @throws AuthenticationException
     */
    public function authenticate(): string;
}
