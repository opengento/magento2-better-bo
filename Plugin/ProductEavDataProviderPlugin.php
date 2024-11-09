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
    /** @var StoreManagerInterface */
    private $storeManager;

    /** @var Registry */
    private $registry;

    /** @var ProductRepositoryInterface */
    private $productRepository;

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
        $storeSvg = "<svg stroke='currentColor' fill='currentColor' stroke-width='0' viewBox='0 0 616 512' height='200px' width='200px' xmlns='http://www.w3.org/2000/svg'><path d='M602 118.6L537.1 15C531.3 5.7 521 0 510 0H106C95 0 84.7 5.7 78.9 15L14 118.6c-33.5 53.5-3.8 127.9 58.8 136.4 4.5.6 9.1.9 13.7.9 29.6 0 55.8-13 73.8-33.1 18 20.1 44.3 33.1 73.8 33.1 29.6 0 55.8-13 73.8-33.1 18 20.1 44.3 33.1 73.8 33.1 29.6 0 55.8-13 73.8-33.1 18.1 20.1 44.3 33.1 73.8 33.1 4.7 0 9.2-.3 13.7-.9 62.8-8.4 92.6-82.8 59-136.4zM529.5 288c-10 0-19.9-1.5-29.5-3.8V384H116v-99.8c-9.6 2.2-19.5 3.8-29.5 3.8-6 0-12.1-.4-18-1.2-5.6-.8-11.1-2.1-16.4-3.6V480c0 17.7 14.3 32 32 32h448c17.7 0 32-14.3 32-32V283.2c-5.4 1.6-10.8 2.9-16.4 3.6-6.1.8-12.1 1.2-18.2 1.2z'></path></svg>";
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


        $adminStoreViewId = \Magento\Store\Model\Store::DEFAULT_STORE_ID;
        $currentStoreViewId = $this->storeManager->getStore()->getId();

        if ((int) $currentStoreViewId === (int) $adminStoreViewId) {
            $result['arguments']['data']['config']['storebtn'] = '<button class=\'btn-store-view\' data-attribute-code=\'' . $attributeCode . '\'>' . $storeSvg . '</button>';
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
