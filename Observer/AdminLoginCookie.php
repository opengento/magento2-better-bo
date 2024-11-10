<?php

/**
 * AdminLoginCookie
 *
 * @copyright Copyright © 2024 Blackbird Agency. All rights reserved.
 * @author    sebastien@bird.eu
 */

declare(strict_types=1);

namespace Opengento\BetterBo\Observer;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Integration\Model\CustomUserContext;
use Magento\Integration\Model\UserToken\UserTokenParametersFactory;
use Magento\User\Model\ResourceModel\User;

class AdminLoginCookie implements ObserverInterface
{
    public function __construct(
        protected ScopeConfigInterface $scopeConfig,
        protected \Magento\Framework\Stdlib\CookieManagerInterface $customCookieManager,
        protected \Magento\Framework\Stdlib\Cookie\CookieMetadataFactory $customCookieMetadataFactory,
        protected \Magento\Integration\Api\UserTokenIssuerInterface $tokenIssuer,
        protected UserTokenParametersFactory $tokenParametersFactory,
        protected User $userResource,  // Add this line
    ) {}

    /**
     * @inheritDoc
     */
    public function execute(Observer $observer)
    {
        $event = $observer->getEvent();
        $user = $event->getUser();

        $context = new CustomUserContext(
            (int) $user->getId(),
            CustomUserContext::USER_TYPE_ADMIN
        );
        $params = $this->tokenParametersFactory->create();
        $token = $this->tokenIssuer->create($context, $params);

        // Create token
        $this->createAdminCookie($token);
        
        // Add these lines to save token in extra_data
        $this->saveTokenInDB($user, $token);
    }

    /**
     * Save token in extra_data
     * 
     * @param User $user
     * @param string $token
     * 
     * @return void
     */
    protected function saveTokenInDB(User $user, string $token): void
    {
        $extraData = json_decode($user->getExtra(), true) ?: [];
        $extraData['betterbo_token'] = $token;
        $user->setExtra(json_encode($extraData));
        $this->userResource->save($user);
    }

    /**
     * Create admin cookie
     * 
     * @deprecated
     * 
     * @param string $token
     * 
     * @return void
     */
    protected function createAdminCookie(string $token): void
    {
        $ttl = $this->scopeConfig->getValue('admin/security/session_lifetime');
        $customCookieMetadata = $this->customCookieMetadataFactory->createPublicCookieMetadata();
        $customCookieMetadata->setDuration($ttl);
        // $customCookieMetadata->setPath('/admin');
        // $customCookieMetadata->setHttpOnly(false);

        $this->customCookieManager->setPublicCookie(
            'betterbo_token',
            $token,
            $customCookieMetadata
        );
    }
}
