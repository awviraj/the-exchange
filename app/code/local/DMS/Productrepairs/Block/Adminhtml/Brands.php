<?php
class DMS_Productrepairs_Block_Adminhtml_Brands extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        //where is the controller
        $this->_controller = 'adminhtml_index';
        $this->_blockGroup = 'dms_productrepairs';
        //text in the admin header
        $this->_headerText = 'Brands';
        //value of the add button
        $this->_addButtonLabel = 'Add Brand';
        parent::__construct();
    }
}