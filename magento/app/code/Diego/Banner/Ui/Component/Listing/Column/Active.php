<?php

namespace Diego\Banner\Ui\Component\Listing\Column;

class Active implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [['value' => 1, 'label' => __('Active')], ['value' => 0, 'label' => __('Inactive')]];
    }
}