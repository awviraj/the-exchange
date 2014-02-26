<?php

class Webspeaks_Productbook_Block_Adminhtml_Productbook_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('productbook_form', array('legend'=>Mage::helper('productbook')->__('Item information')));
     
      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('productbook')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));

      $fieldset->addField('filename', 'file', array(
          'label'     => Mage::helper('productbook')->__('File'),
          'required'  => false,
          'name'      => 'filename',
	  ));
		
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('productbook')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('productbook')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('productbook')->__('Disabled'),
              ),
          ),
      ));
     
      $fieldset->addField('content', 'editor', array(
          'name'      => 'content',
          'label'     => Mage::helper('productbook')->__('Content'),
          'title'     => Mage::helper('productbook')->__('Content'),
          'style'     => 'width:700px; height:500px;',
          'wysiwyg'   => false,
          'required'  => true,
      ));
     
      if ( Mage::getSingleton('adminhtml/session')->getProductbookData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getProductbookData());
          Mage::getSingleton('adminhtml/session')->setProductbookData(null);
      } elseif ( Mage::registry('productbook_data') ) {
          $form->setValues(Mage::registry('productbook_data')->getData());
      }
      return parent::_prepareForm();
  }
}