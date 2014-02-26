<?php

class Webspeaks_Productbook_Model_Mysql4_Productbook extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the productbook_id refers to the key field in your database table.
        $this->_init('productbook/productbook', 'productbook_id');
    }
}