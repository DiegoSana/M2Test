<?php

namespace Diego\Banner\Controller\Adminhtml\Banner;

use Diego\Banner\Controller\Adminhtml\Banner;

class Add
    extends Banner
{

    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Forward $resultForward */
        $resultForward = $this->_resultForwardFactory->create();

        return $resultForward->forward('edit');
    }
}