<?php

namespace Diego\Banner\Helper;


use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\ScopeInterface;

class Data
    extends AbstractHelper
{
    const XML_PATH = 'diego_banner/';

    protected $_customerSession;

    public function __construct(
        Context $context
    )
    {
        parent::__construct($context);
    }

    public function getConfigValue($field, $storeId = null)
    {
        return $this->scopeConfig->getValue(
            $field, ScopeInterface::SCOPE_STORE, $storeId
        );
    }

    public function getGeneralConfig($code, $storeId = null)
    {
        return $this->getConfigValue(self::XML_PATH . 'general/' . $code, $storeId);
    }

}