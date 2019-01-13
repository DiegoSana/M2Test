<?php

namespace Diego\Banner\Controller\Adminhtml\Banner;

use Diego\Banner\Controller\Adminhtml\Banner;

class Edit
    extends Banner
{
    public function execute()
    {
        $bannerId = $this->getRequest()->getParam('id');
        /** @var \Diego\Banner\Model\Banner $model */
        $model = $this->_bannerFactory->create();

        if ($bannerId) {
            $model->load($bannerId);
            if (!$model->getId()) {
                $this->messageManager->addError(__('This banner no longer exists.'));
                $this->_redirect('*/*/');

                return;
            }
        }

        $data = $this->_session->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }
        $this->_coreRegistry->register('banner', $model);

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->_resultPageFactory->create();
        $resultPage->setActiveMenu('Diego_Banner::banner');
        $resultPage->getConfig()->getTitle()->prepend(__('Banners manager'));

        return $resultPage;
    }
}