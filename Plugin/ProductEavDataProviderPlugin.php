<?php

namespace Opengento\BetterBo\Plugin;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\Eav;
use Magento\Framework\Registry;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Catalog\Model\Attribute\ScopeOverriddenValue;

class ProductEavDataProviderPlugin
{
    /** @var StoreManagerInterface */
    private $storeManager;

    /** @var Registry */
    private $registry;

    /** @var ProductRepositoryInterface */
    private $productRepository;

    /** @var array */
    private $stores;

    /**
     * ProductEavDataProviderPlugin constructor.
     *
     * @param StoreManagerInterface $storeManager
     * @param Registry $registry
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(
        StoreManagerInterface $storeManager,
        Registry $registry,
        ProductRepositoryInterface $productRepository
    ) {
        $this->storeManager = $storeManager;
        $this->registry = $registry;
        $this->productRepository = $productRepository;
    }

    /**
     * @param Eav $subject
     * @param $result
     * @return mixed
     */
    public function afterSetupAttributeMeta(Eav $subject, $result)
    {
        if (!isset($result['arguments']['data']['config']['code'])
            || $result['arguments']['data']['config']['globalScope']
            || !in_array($result['arguments']['data']['config']['dataType'], ['text', 'select'])
        ) {
            return $result;
        }

        $attributeCode = $result['arguments']['data']['config']['code'];
        $storeViews = $this->getStores();
        $product = $this->registry->registry('current_product');

        $productId = $product->getId();
        if ($product === null || $productId === null) {
            return $result;
        }

        foreach ($storeViews as $storeView) {
            $productByStoreCode = $this->getProductInStoreView($productId, $storeView->getId());
            $currentScopeValueForCode = $value = $productByStoreCode->getData($attributeCode);

            if ($result['arguments']['data']['config']['dataType'] == 'select'
                && !is_array($currentScopeValueForCode)
            ) {
                $value = $productByStoreCode->getResource()->getAttribute($attributeCode)->getSource()->getOptionText($currentScopeValueForCode);
            }

            $valueAsString = null;
            try {
                $valueAsString = (string) $value;
            } catch (\Throwable $ex) {
                $valueAsString = json_encode($value);
                if ($valueAsString === false) {
                    $valueAsString = null;
                }
            }

            if (true) { // edit 
                $result['arguments']['data']['config']['storebtn'] = "<button class='btn-store-view' data-attribute-code='{$attributeCode}'>" . __('See store values') . "</button>";
            }
        }

        return $result;
    }

    /**
     * @param int $productId
     * @param int $storeViewId
     * @return mixed
     */
    private function getProductInStoreView($productId, $storeViewId)
    {
        return $this->productRepository->getById($productId, false, $storeViewId);
    }

    /**
     * @return array
     */
    private function getStores()
    {
        if (!$this->stores) {
            $this->stores = $this->storeManager->getStores();
        }

        return $this->stores;
    }
}