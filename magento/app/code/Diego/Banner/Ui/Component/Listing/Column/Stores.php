<?php

namespace Diego\Banner\Ui\Component\Listing\Column;

use Magento\Framework\Escaper;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Store\Model\System\Store as SystemStore;
use Diego\Banner\Model\BannerFactory;

class Stores
    extends \Magento\Store\Ui\Component\Listing\Column\Store
{
    protected $_bannerFactory;

    /**
     * Store constructor.
     *
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param SystemStore $systemStore
     * @param Escaper $escaper
     * @param BannerFactory $bannerFactory
     * @param array|null $components
     * @param array|null $data
     * @param string $storeKey
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        SystemStore $systemStore,
        Escaper $escaper,
        BannerFactory $bannerFactory,
        array $components = null,
        array $data = null,
        $storeKey = 'store_id'
    )
    {
        $this->_bannerFactory = $bannerFactory;
        parent::__construct($context, $uiComponentFactory, $systemStore, $escaper, $components, $data, $storeKey);
    }

    /**
     * Get data
     *
     * @param array $item
     *
     * @return string
     */
    protected function prepareItem(array $item)
    {

        $content = '';
        $banner = $this->_bannerFactory->create()->load($item['id']);
        $origStores = $banner->getStoreId();
        $data = $this->systemStore->getStoresStructure(false, $origStores);

        if (in_array(0, $banner->getStoreId())) {
            $content .= '<b>All websites</b><br/>';
        }
        foreach ($data as $website) {
            // Descomentar si se quiere ver toda la estructura de website
            //$content .= $website['label'] . "<br/>";
            foreach ($website['children'] as $group) {
                // Descomentar si se quiere ver toda la estructura de website
                //$content .= str_repeat('&nbsp;', 3) . $this->escaper->escapeHtml($group['label']) . "<br/>";
                foreach ($group['children'] as $store) {
                    $content .= '<b>' . str_repeat('&nbsp;', 6) . $this->escaper->escapeHtml($store['label']) . "</b><br/>";
                }
            }
        }

        return $content;
    }
}