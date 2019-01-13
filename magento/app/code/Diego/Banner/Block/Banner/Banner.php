<?php

namespace Diego\Banner\Block\Banner;

use Magento\Framework\View\Element\Template;
use Diego\Banner\Model\BannerFactory;

class Banner
    extends Template
{

    const ALL_STORE = 0;
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    protected $_bannerFactory;

    public function __construct(
        Template\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        BannerFactory $bannerFactory,
        array $data = []
    )
    {
        $this->_bannerFactory = $bannerFactory;
        $this->_storeManager = $storeManager;
        parent::__construct($context, $data);
    }

    public function getTitle()
    {
        return "Banner block";
    }

    public function getStoreId()
    {
        return ($this->_storeManager->getStore()->getId());
    }

    public function getBannerCollection()
    {
        $bannerCollection = $this->_bannerFactory->create()->getCollection()
            ->addFieldToFilter(
                ['store_id', 'store_id'],
                [
                    ['finset' => [self::ALL_STORE]],
                    ['finset' => [$this->getStoreId()]]
                ]
            )
            ->addFieldToFilter('is_active', ['eq' => '1']);

        return $bannerCollection;
    }

    public function getMediaImageUrl($relativePath)
    {
        return $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . $relativePath;
    }
}