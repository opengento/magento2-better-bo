<?php

namespace Opengento\BetterBo\Plugin;

use Magento\Store\Model\StoreManagerInterface;

class CategoryEavDataProviderPlugin
{
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;

    /**
     * CategoryEavDataProviderPlugin constructor.
     *
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        StoreManagerInterface $storeManager
    ) {
        $this->storeManager = $storeManager;
    }

    /**
     * @param \Magento\Catalog\Model\Category\DataProvider $subject
     * @param array $result
     * @param array $fieldsMap
     * @param array $fieldsMeta
     * @return array
     */
    public function afterPrepareFieldsMeta(
        \Magento\Catalog\Model\Category\DataProvider $subject,
        array $result,
        array $fieldsMap,
        array $fieldsMeta
    ) {
        $adminStoreViewId = \Magento\Store\Model\Store::DEFAULT_STORE_ID;
        $currentStoreViewId = $this->storeManager->getStore()->getId();
        foreach ($fieldsMap as $fieldSet => $fields) {
            foreach ($fields as $field) {
                // if (isset($result[$fieldSet]['children'][$field]['arguments']['data']['config']) && (int) $currentStoreViewId === (int) $adminStoreViewId) {
                    $result[$fieldSet]['children'][$field]['arguments']['data']['config']['storebtn'] = "<button class='btn-store-view'>" . __('See store values') . "</button>";
                // }
            }
        }
        return $result;
    }
}
