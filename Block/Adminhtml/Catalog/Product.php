<?php

namespace Opengento\BetterBo\Block\Adminhtml\Catalog;

use Magento\Backend\Block\Template;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\Stdlib\CookieManagerInterface;
use Magento\Backend\Model\Auth\Session;


class Product extends Template
{
    /**
     * @param \Magento\Integration\Api\IntegrationServiceInterface $integrationService
     */
    public function __construct(
        Context $context,
        protected CookieManagerInterface $cookieManager,
        protected Session $authSession
    ) {
        parent::__construct($context);
    }

    /**
     * Get authentication session
     *
     * @return Session
     */
    public function getAuth()
    {
        return $this->authSession;
    }

     /**
     * Get data from cookie set in remote address
     *
     * @return value
     */
    public function getCookie($name)
    {
        return $this->cookieManager->getCookie($name);
    }
}
