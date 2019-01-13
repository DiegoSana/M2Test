<?php

namespace Diego\Banner\Model\ResourceModel\Banner;

use \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection
    extends AbstractCollection
{
    /**
     * Initialize resource collection
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init('Diego\Banner\Model\Banner', 'Diego\Banner\Model\ResourceModel\Banner');
    }
}
