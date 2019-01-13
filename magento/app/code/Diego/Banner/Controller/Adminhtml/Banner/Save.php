<?php

namespace Diego\Banner\Controller\Adminhtml\Banner;

use Diego\Banner\Controller\Adminhtml\Banner;

class Save
    extends Banner
{
    /**
     * @var \Magento\Framework\Image\AdapterFactory
     */
    protected $adapterFactory;
    /**
     * @var \Magento\MediaStorage\Model\File\UploaderFactory
     */
    protected $uploader;
    /**
     * @var \Magento\Framework\Filesystem
     */
    protected $filesystem;
    /**
     * @var \Magento\Framework\Filesystem\Driver\File
     */
    protected $file;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Diego\Banner\Model\BannerFactory $bannerFactory,
        \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory,
        \Magento\Framework\Image\AdapterFactory $adapterFactory,
        \Magento\MediaStorage\Model\File\UploaderFactory $uploader,
        \Magento\Framework\Filesystem $filesystem,
        \Magento\Framework\Filesystem\Driver\File $file
    )
    {
        $this->file = $file;
        $this->adapterFactory = $adapterFactory;
        $this->uploader = $uploader;
        $this->filesystem = $filesystem;
        parent::__construct($context, $registry, $resultPageFactory, $bannerFactory, $resultForwardFactory);
    }

    /**
     * @return void
     */
    public function execute()
    {
        $isPost = $this->getRequest()->getPost();

        if ($isPost) {
            $formData = $this->getRequest()->getParam('banner');

            $bannerModel = $this->_bannerFactory->create();
            $bannerId = isset($formData['id']) && $formData['id'] ? $formData['id'] : null;

            if ($bannerId) {
                $bannerModel->load($bannerId);
            }

            $bannerModel->setData($formData);
            $bannerModel->setStoreIds($formData['store_ids']);
            $validate = $bannerModel->validate();
            if ($validate === true) {
                try {

                    $formData = $this->_processImage($formData, 'image');
                    $formData = $this->_processImage($formData, 'small_image');
                    $bannerModel->setData($formData);
                    $bannerModel->setStoreIds($formData['store_ids']);

                    $bannerModel->save();
                    $this->messageManager->addSuccess(__('The banner has been saved.'));
                    if ($this->getRequest()->getParam('back')) {
                        $this->_redirect('*/*/edit', ['id' => $bannerModel->getId(), '_current' => true]);

                        return;
                    }
                    $this->_redirect('*/*/');

                    return;
                } catch (\Exception $e) {
                    $this->messageManager->addError($e->getMessage());
                }
            } else {
                if (is_array($validate)) {
                    foreach ($validate as $error) {
                        $this->messageManager->addError($error->getText());
                    }
                } else {
                    $this->messageManager->addError(__('Sorry, we can\'t load your banner'));
                }
            }

            $formData['store_id'] = $bannerModel->getStoreId();
            $formData['image'] = isset($formData['image']['value']) ? $formData['image']['value'] : null;
            $formData['small_image'] = isset($formData['small_image']['value']) ? $formData['small_image']['value'] : null;
            $this->_session->setFormData($formData);
            if ($bannerId) {
                $this->_redirect('*/*/edit', ['id' => $bannerId, '_current' => true]);
            } else {
                $this->_redirect('*/*/add');
            }

            return;
        }
    }

    protected function _processImage(array $formData, $fieldName)
    {
        if (isset($_FILES[$fieldName]) && isset($_FILES[$fieldName]['name']) && strlen($_FILES[$fieldName]['name'])) {
            $base_media_path = 'diego/banner/images';
            $uploader = $this->uploader->create(
                ['fileId' => $fieldName]
            );
            $uploader->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png']);
            $imageAdapter = $this->adapterFactory->create();
            $uploader->addValidateCallback($fieldName, $imageAdapter, 'validateUploadFile');
            $uploader->setAllowRenameFiles(true);
            $uploader->setFilesDispersion(true);
            $mediaDirectory = $this->filesystem->getDirectoryRead(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA);
            $result = $uploader->save($mediaDirectory->getAbsolutePath($base_media_path));
            $formData[$fieldName] = $base_media_path . $result['file'];
        } else {
            if (isset($formData[$fieldName]) && isset($formData[$fieldName]['value'])) {
                if (isset($formData[$fieldName]['delete'])) {
                    $mediaRootDir = $this->filesystem->getDirectoryRead(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA)->getAbsolutePath();
                    if ($this->file->isExists($mediaRootDir . $formData[$fieldName]['value'])) {
                        $this->file->deleteFile($mediaRootDir . $formData[$fieldName]['value']);
                    }
                    $formData[$fieldName] = null;
                } elseif (isset($formData[$fieldName]['value'])) {
                    $formData[$fieldName] = $formData[$fieldName]['value'];
                } else {
                    $formData[$fieldName] = null;
                }
            }
        }

        return $formData;
    }
}