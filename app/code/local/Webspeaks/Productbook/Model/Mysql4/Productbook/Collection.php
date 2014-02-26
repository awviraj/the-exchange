<?php

class Webspeaks_Productbook_Model_Mysql4_Productbook_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('productbook/productbook');
    }
}