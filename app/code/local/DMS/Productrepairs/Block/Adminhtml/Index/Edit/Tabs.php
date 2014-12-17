<?php
class DMS_Productrepairs_Block_Adminhtml_Index_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('brand_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle('Brand Information');
    }
    protected function _beforeToHtml()
    {
        $this->addTab('form_section', array(
            'label' => 'Brand Information',
            'title' => 'Brand Information',
            'content' => $this->getLayout()
                ->createBlock('dms_productrepairs/adminhtml_index_edit_tab_form')
                ->toHtml()
        ));
        return parent::_beforeToHtml();
    }
}