<?php

namespace Diego\Banner\Model\ResourceModel\Banner\Grid;

class Collection
    extends \Magento\Framework\View\Element\UiComponent\DataProvider\SearchResult
{

    protected function _initSelect()
    {
        parent::_initSelect();

        return $this;
    }
}