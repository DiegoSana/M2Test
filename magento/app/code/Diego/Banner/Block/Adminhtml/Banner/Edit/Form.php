<?php

namespace Diego\Banner\Block\Adminhtml\Banner\Edit;


class Form
    extends \Magento\Backend\Block\Widget\Form\Generic
{
    /**
     * @var \Magento\Cms\Model\Wysiwyg\Config
     */
    protected $_wysiwygConfig;
    /**
     * @var \Magento\Store\Model\System\Store
     */
    protected $_store;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Store\Model\System\Store $systemStore,
        \Magento\Cms\Model\Wysiwyg\Config $wysiwygConfig,
        array $data = []
    )
    {
        $this->_wysiwygConfig = $wysiwygConfig;
        $this->_store = $systemStore;
        parent::__construct($context, $registry, $formFactory, $data);
        $this->setId('diego_banner_form');
        $this->setTitle(__('Banner Form'));
    }

    protected function _prepareForm()
    {
        $model = $this->_coreRegistry->registry('banner');

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create(
            [
                'data' => [
                    'id' => 'edit_form',
                    'action' => $this->getData('action'),
                    'method' => 'post',
                    'enctype' => 'multipart/form-data',
                ]
            ]
        );

        $form->setHtmlIdPrefix('banner');
        $form->setFieldNameSuffix('banner');

        $fieldset = $form->addFieldset(
            'base_fieldset',
            [
                'legend' => __('Banners'),
                'class' => 'fieldset-wide'
            ]
        );

        if ($model->getId()) {
            $fieldset->addField(
                'id',
                'hidden',
                ['name' => 'id']
            );
        }
        $fieldset->addField(
            'title',
            'text',
            [
                'name' => 'title',
                'label' => __('Title'),
                'required' => true,
            ]
        );
        $fieldset->addField(
            'text',
            'editor',
            [
                'name' => 'text',
                'label' => __('Text'),
                'title' => __('Text'),
                'rows' => '5',
                'cols' => '30',
                'wysiwyg' => true,
                'config' => $this->_wysiwygConfig->getConfig()
            ]
        );
        $fieldset->addField(
            'is_active',
            'select',
            [
                'name' => 'is_active',
                'label' => __('Status'),
                'required' => true,
                'options' => [1 => __('Active'), 0 => __('Inactive')]
            ]
        );
        $fieldset->addField(
            'store_id',
            'multiselect',
            [
                'name' => 'store_ids[]',
                'label' => __('Store Views'),
                'title' => __('Store Views'),
                'required' => true,
                'values' => $this->_store->getStoreValuesForForm(false, true),
            ]
        );
        $fieldset->addField(
            'image',
            'image',
            [
                'title' => __('Image'),
                'label' => __('Image'),
                'name' => 'image',
                'note' => 'Allow image type: jpg, jpeg, gif, png',
                'required' => true,
            ]
        );
        $fieldset->addField(
            'small_image',
            'image',
            [
                'title' => __('Small Image'),
                'label' => __('Small Image'),
                'name' => 'small_image',
                'note' => 'Allow image type: jpg, jpeg, gif, png',
                'required' => true,
            ]
        );

        $form->setValues($model);
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}