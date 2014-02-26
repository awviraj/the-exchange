<?php

class Webspeaks_Productbook_Block_Adminhtml_Productbook_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('productbook_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('productbook')->__('Item Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('productbook')->__('Item Information'),
          'title'     => Mage::helper('productbook')->__('Item Information'),
          'content'   => $this->getLayout()->createBlock('productbook/adminhtml_productbook_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}