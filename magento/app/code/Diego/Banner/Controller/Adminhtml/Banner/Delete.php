<?php

namespace Diego\Banner\Controller\Adminhtml\Banner;

use Diego\Banner\Controller\Adminhtml\Banner;

class Delete
    extends Banner
{
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        if ($this->getRequest()->getParam('id')) {
            $bannerIds[] = $this->getRequest()->getParam('id');
        } else {
            $bannerIds = $this->getRequest()->getParam('selected');
        }

        if ($bannerIds) {
            try {
                foreach ($bannerIds as $id) {
                    $model = $this->_bannerFactory->create();
                    $model->load($id);
                    $model->delete();
                }
                $deletedCount = count($bannerIds);
                $message = ($deletedCount > 1) ? $deletedCount . ' banners deleted' : $deletedCount . ' banner deleted';
                $this->messageManager->addSuccess($message);
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
            }
        } else {
            try {
                $collection = $this->_bannerFactory->create()->getCollection()->addFieldToSelect(['image', 'small_image']);
                $totalDeleted = $collection->getSize();
                foreach ($collection as $banner) {
                    $banner->delete();
                }
                $this->messageManager->addSuccess($totalDeleted . ' banner/s deleted');

            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
            }
        }

        return $resultRedirect->setPath('banner/banner/index');
    }


}