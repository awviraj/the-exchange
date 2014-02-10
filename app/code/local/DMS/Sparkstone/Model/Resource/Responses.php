<?php
class DMS_Sparkstone_Model_Resource_Responses extends Mage_Core_Model_Resource_Db_Abstract{
    protected function _construct()
    {
        $this->_init('sparkstone/responses', 'entity_id');
    }
}