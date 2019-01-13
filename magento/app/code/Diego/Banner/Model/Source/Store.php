<?php

namespace Diego\Banner\Model\Source;


class Store
{
    protected $_storeCollectionFactory;

    public function __construct(
        \Magento\Store\Model\ResourceModel\Store\CollectionFactory $storeCollectionFactory
    )
    {
        $this->_storeCollectionFactory = $storeCollectionFactory;
    }

    public function getOptionArray()
    {
        $options = ['' => '--Select--'];
        $storeCollection = $this->_storeCollectionFactory->create()->addFieldToSelect('*');
        foreach ($storeCollection as $store) {
            $options[$store->getId()] = $store->getName();
        }

        return $options;
    }
}