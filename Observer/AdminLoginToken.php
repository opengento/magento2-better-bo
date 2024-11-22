<?php

/**
 * AdminLoginCookie
 *
 * @copyright Copyright © 2024 Blackbird Agency. All rights reserved.
 * @author    sebastien@bird.eu
 */

declare(strict_types=1);

namespace Opengento\BetterBo\Observer;

use Magento\Authorization\Model\UserContextInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Integration\Api\UserTokenIssuerInterface;
use Magento\Integration\Model\CustomUserContext;
use Magento\Integration\Model\UserToken\UserTokenParametersFactory;
use Magento\User\Model\ResourceModel\User;

class AdminLoginToken implements ObserverInterface
{
    private const BETTERBO_TOKEN_KEY = 'betterbo_token';

    public function __construct(
        protected ScopeConfigInterface $scopeConfig,
        protected UserTokenIssuerInterface $tokenIssuer,
        protected UserTokenParametersFactory $tokenParametersFactory,
        protected User $userResource
    ) {}

    /**
     * @inheritDoc
     */
    public function execute(Observer $observer)
    {
        try {
            $event = $observer->getEvent();
            $user = $event->getUser();

            $context = new CustomUserContext(
                (int) $user->getId(),
                UserContextInterface::USER_TYPE_ADMIN
            );
            $params = $this->tokenParametersFactory->create();

            $token = $this->tokenIssuer->create($context, $params);

            $this->saveTokenInDB($user, $token);
        } catch (LocalizedException) {
            return;
        }
    }

    /**
     * Save token in extra_data
     *
     * @param \Magento\AdminAdobeIms\Model\User $user
     * @param string $token
     *
     * @return void
     * @throws AlreadyExistsException
     */
    protected function saveTokenInDB(\Magento\AdminAdobeIms\Model\User $user, string $token): void
    {
        $extraData = $user->getExtra() ?: [];
        $extraData[self::BETTERBO_TOKEN_KEY] = $token;
        $user->setExtra($extraData);

        $this->userResource->save($user);
    }
}
