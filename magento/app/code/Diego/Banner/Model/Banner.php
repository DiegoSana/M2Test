<?php

namespace Diego\Banner\Model;


class Banner
    extends \Magento\Framework\Model\AbstractModel
    implements \Magento\Framework\DataObject\IdentityInterface
{

    const CACHE_TAG = 'diego_banner';

    protected $_cacheTag = self::CACHE_TAG;

    protected $_eventPrefix = 'diego_banner';

    protected $_helperData;

    protected $_bannerFactory;
    /**
     * @var \Magento\Framework\Filesystem
     */
    protected $filesystem;
    /**
     * @var \Magento\Framework\Filesystem\Driver\File
     */
    protected $file;

    public function __construct(
        \Diego\Banner\Helper\Data $helperData,
        BannerFactory $bannerFactory,
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Filesystem $filesystem,
        \Magento\Framework\Filesystem\Driver\File $file,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    )
    {
        $this->file = $file;
        $this->_bannerFactory = $bannerFactory;
        $this->_helperData = $helperData;
        $this->filesystem = $filesystem;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    protected function _construct()
    {
        $this->_init('Diego\Banner\Model\ResourceModel\Banner');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getDefaultValues()
    {
        $values = [];

        return $values;
    }

    public function validate()
    {
        $errors = [];

        if (!\Zend_Validate::is($this->getStoreId(), 'NotEmpty')) {
            $errors[] = __('Please enter one or more stores.');
        }

        if (!\Zend_Validate::is($this->getTitle(), 'NotEmpty')) {
            $errors[] = __('Please enter the title.');
        }

        if (empty($errors)) {
            return true;
        }

        return $errors;
    }

    public function afterSave()
    {
        $this->cleanCache();

        return parent::afterSave();
    }

    public function cleanCache()
    {
        return $this->cleanModelCache();
    }

    public function setStoreIds($stores)
    {
        if (is_array($stores)) {
            $stores = implode(',', $stores);
        }
        parent::setStoreId($stores);

    }

    public function beforeDelete()
    {
        $mediaRootDir = $this->filesystem->getDirectoryRead(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA)->getAbsolutePath();
        if ($this->getImage() && $this->file->isExists($mediaRootDir . $this->getImage())) {
            $this->file->deleteFile($mediaRootDir . $this->getImage());
        }
        if ($this->getSmallImage() && $this->file->isExists($mediaRootDir . $this->getSmallImage())) {
            $this->file->deleteFile($mediaRootDir . $this->getSmallImage());
        }

        return parent::beforeDelete();
    }

    public function getStoreId()
    {
        return explode(',', $this->getData('store_id'));
    }
}