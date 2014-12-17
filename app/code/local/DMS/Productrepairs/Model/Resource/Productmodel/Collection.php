<?php
class DMS_Productrepairs_Model_Resource_Productmodel_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    public function _construct()
    {
        $this->_init('dms_productrepairs/productmodel');
    }
}