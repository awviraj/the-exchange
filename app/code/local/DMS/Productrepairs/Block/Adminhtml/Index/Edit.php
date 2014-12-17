<?php
class DMS_Productrepairs_Block_Adminhtml_Index_Edit extends Mage_Adminhtml_Block_Widget_Form_Container{
    public function __construct()
    {
        parent::__construct();
        $this->_objectId = 'id';
        //vwe assign the same blockGroup as the Grid Container
        $this->_blockGroup = 'dms_productrepairs';
        //and the same controller
        $this->_controller = 'adminhtml_index';
        //define the label for the save and delete button
        $this->_updateButton('save', 'label','Save Brand');
        $this->_updateButton('delete', 'label', 'Delete Brand');
    }
    /* Here, we're looking if we have transmitted a form object,
       to update the good text in the header of the page (edit or add) */
    public function getHeaderText()
    {
        if( Mage::registry('brand')&&Mage::registry('brand')->getId())
        {
            return 'Editer la reference '.$this->htmlEscape(
                Mage::registry('brand')->getTitle()).'<br />';
        }
        else
        {
            return 'Add a contact';
        }
    }
}