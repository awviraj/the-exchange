<?php

class Webspeaks_Productbook_Block_Adminhtml_Productbook_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'productbook';
        $this->_controller = 'adminhtml_productbook';
        
        $this->_updateButton('save', 'label', Mage::helper('productbook')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('productbook')->__('Delete Item'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('productbook_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'productbook_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'productbook_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('productbook_data') && Mage::registry('productbook_data')->getId() ) {
            return Mage::helper('productbook')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('productbook_data')->getTitle()));
        } else {
            return Mage::helper('productbook')->__('Add Item');
        }
    }
}