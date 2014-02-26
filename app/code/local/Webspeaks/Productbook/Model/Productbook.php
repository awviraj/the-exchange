<?php

class Webspeaks_Productbook_Model_Productbook extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('productbook/productbook');
    }
}