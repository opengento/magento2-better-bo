<?php

declare(strict_types=1);

namespace Opengento\BetterBo\Plugin;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\Eav;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Registry;
use Magento\Store\Api\Data\StoreInterface;
use Magento\Store\Model\StoreManagerInterface;
use Opengento\BetterBo\Model\Config;
use Psr\Log\LoggerInterface;
use Magento\Store\Model\Store;

/**
 * @property StoreInterface[] $stores
 */
class ProductEavDataProviderPlugin
{
    /**
     * ProductEavDataProviderPlugin constructor.
     *
     * @param StoreManagerInterface $storeManager
     * @param Registry $registry
     * @param ProductRepositoryInterface $productRepository
     * @param Config $betterBoConfig
     * @param LoggerInterface $logger
     */
    public function __construct(
        protected StoreManagerInterface $storeManager,
        protected Registry $registry,
        protected ProductRepositoryInterface $productRepository,
        protected Config $betterBoConfig,
        protected LoggerInterface $logger,
    ) {
    }

    /**
     * @param Eav $subject
     * @param array $result
     * @return array
     */
    public function afterSetupAttributeMeta(Eav $subject, array $result): array
    {
        if (!isset($result['arguments']['data']['config']['code'])
            || $result['arguments']['data']['config']['globalScope']
            || !\in_array($result['arguments']['data']['config']['dataType'],
                $this->betterBoConfig->getAttributesFieldsType(), true)
        ) {
            return $result;
        }

        $attributeCode = $result['arguments']['data']['config']['code'];
        $product = $this->registry->registry('current_product');

        if (!$product || !$product->getId()) {
            return $result;
        }

        try {
            $currentStoreViewId = (int)$this->storeManager->getStore()->getId();

            if ($currentStoreViewId === Store::DEFAULT_STORE_ID) {
                $result['arguments']['data']['config']['storebtn']
                    = "<button class='btn-store-view' data-attribute-code='{$attributeCode}'>"
                    . __('See store values')
                    . "</button>";
            }
        } catch (NoSuchEntityException $exception) {
            $this->logger->error($exception);
        }

        return $result;
    }

    /*
     * @param int $productId
     * @param int $storeViewId
     * @return mixed
     */
    private function getProductInStoreView(int $productId, int $storeViewId): ?ProductInterface
    {
        try {
            return $this->productRepository->getById($productId, false, $storeViewId);
        } catch (NoSuchEntityException $exception) {
            $this->logger->error($exception);
            return null;
        }
    }

    /**
     * @return array
     */
    private function getStores(): array
    {
        if (!$this->stores) {
            $this->stores = $this->storeManager->getStores();
        }

        return $this->stores;
    }
}
