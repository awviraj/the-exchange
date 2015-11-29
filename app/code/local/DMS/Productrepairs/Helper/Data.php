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

    public function getBookingNumber() {
        $repairId = Mage::getModel('core/variable')->loadByCode('repair_id')->getPlainValue();
        $repairId = $this->_prefix.str_pad(intval(str_replace('EX','',$repairId)) + 1,8,'0',STR_PAD_LEFT);
        Mage::getModel('core/variable')->loadByCode('repair_id')->setPlainValue($repairId)->save();
        return $repairId;
    }

    public function getLastBookingNumber() {
        $this->_lastBookId;
    }
}