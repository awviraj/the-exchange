<?php
class DMS_Sparkstone_Model_Abstract extends  Mage_Core_Model_Abstract
{
    protected $_soapUrl = 'http://retailservices.sparkstone.co.uk/SparkstoneRetailStock.asmx?WSDL';
    protected $_logFile = 'sparkstone.log';

    public function logger($msg) {
        echo $msg."\r\n";
        Mage::log($msg, false, $this->_logFile);
    }

    public function debugMode() {
        return $this->_debugMode;
    }

    public function sandboxMode() {
        return $this->_sandbox;
    }

    public function setReady($ready) {
        $this->_ready = $ready;
    }
}