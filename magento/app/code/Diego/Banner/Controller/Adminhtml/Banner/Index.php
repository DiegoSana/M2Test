<?php

namespace Diego\Banner\Controller\Adminhtml\Banner;


use Diego\Banner\Controller\Adminhtml\Banner;

class Index
    extends Banner
{

    public function execute()
    {
        $resultPage = $this->_resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend((__('Banners Manager')));

        return $resultPage;
    }
}