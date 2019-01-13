<?php

namespace Diego\Banner\Controller\Adminhtml;

abstract class Banner
    extends \Magento\Backend\App\Action
{
    protected $_resultPageFactory = false;
    protected $_bannerFactory;
    protected $_coreRegistry;
    protected $_session;
    protected $_resultForwardFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Diego\Banner\Model\BannerFactory $bannerFactory,
        \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory
    )
    {
        $this->_coreRegistry = $registry;
        $this->_bannerFactory = $bannerFactory;
        $this->_resultPageFactory = $resultPageFactory;
        $this->_resultForwardFactory = $resultForwardFactory;
        parent::__construct($context);
    }
}