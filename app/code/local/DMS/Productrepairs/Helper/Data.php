<?php
/**
* Onepage controller for checkout - Overridden
*
* @category    DMS
* @package     DMS_Productrepairs
* @author      admaduranga@gmail.com
*/
class DMS_Productrepairs_Helper_Data extends Mage_Core_Helper_Abstract
{
    protected $_prefix = 'EX';
    protected $_lastBookId;

    public function getBookingNumber($repairId) {
        $this->_lastBookId = $this->_prefix.$repairId;
        return $this->_prefix.$repairId;
    }

    public function getLastBookingNumber() {
        $this->_lastBookId;
    }
}