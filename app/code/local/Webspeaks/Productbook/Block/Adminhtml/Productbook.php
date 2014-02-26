<?php
class Webspeaks_Productbook_Block_Adminhtml_Productbook extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_productbook';
    $this->_blockGroup = 'productbook';
    $this->_headerText = Mage::helper('productbook')->__('Item Manager');
    $this->_addButtonLabel = Mage::helper('productbook')->__('Add Item');
    parent::__construct();
  }
}