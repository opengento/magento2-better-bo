<?php

namespace Opengento\BetterBo\Block\Adminhtml\Catalog;

use Magento\Backend\Block\Template;
use Magento\Backend\Block\Template\Context;
use Magento\Integration\Api\IntegrationServiceInterface;
use Magento\Integration\Api\Data\IntegrationInterface;


class Product extends Template
{
    /**
     * @param \Magento\Integration\Api\IntegrationServiceInterface $integrationService
     */
    public function __construct(
        Context $context,
        protected IntegrationServiceInterface $_integrationService,
    ) {
        parent::__construct($context);
    }

    /**
     * Get integration by name
     * 
     * @param string $name
     * @return \Magento\Integration\Api\IntegrationInterface|null
     */
    public function getIntegration(string $name)
    {
        try {
            return $this->_integrationService->findByName($name);
        } catch (\Exception $e) {
            return null;
        }
    }
}
