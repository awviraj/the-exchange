<?php
class DMS_Productrepairs_Model_Resource_Brand extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('dms_productrepairs/brands', 'brand_id');
    }
}