<?php

/**
 * Authenticator
 *
 * @copyright Copyright © 2024 Blackbird Agency. All rights reserved.
 * @author    sebastien@bird.eu
 */

declare(strict_types=1);

namespace Opengento\BetterBo\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Data\Form\FormKey\Validator;
use Magento\Framework\Exception\AuthorizationException;
use Magento\Framework\Webapi\Request;
use Opengento\BetterBo\Api\AuthenticatorInterface;

class Authenticator implements AuthenticatorInterface
{
    public function __construct(
        protected Validator $validator,
        protected Request $request,
        protected ScopeConfigInterface $scopeConfig
    ) {
    }

    /**
     * @throws AuthorizationException
     */
    public function authenticate(): string
    {
        if (!$this->validator->validate($this->request)) {
            throw new AuthorizationException(
                __(
                    "The consumer isn't authorized to access %resources.",
                    ['resources' => '']
                )
            );
        }

        return $this->getAppToken();
    }

    private function getAppToken(): string
    {
        return $this->scopeConfig->getValue('better_bo/integration/token');
    }
}
