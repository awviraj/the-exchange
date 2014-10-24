<?php
class DMS_Sparkstone_Model_Connector extends  DMS_Sparkstone_Model_Abstract
{
    protected $_soapUrl = 'http://retailservices.sparkstone.co.uk/SparkstoneRetailStock.asmx?WSDL';
    protected $_sandbox = true;
    protected $_credentials = array();
    protected $_soapClient;
    protected $_useSoapClient = true;
    protected $_trace = true;

    public function init($script='Stock.asmx?WSDL') {
        $this->_sandbox = Mage::helper('sparkstone')->getStoreConfig('sandbox', 'sparkstone/api/');
        $apiUrlPrefix = $this->sandboxMode() ? 'sandboxurl' : 'apiurl';
        if ($apiUrlPrefix = Mage::helper('sparkstone')->getStoreConfig($apiUrlPrefix, 'sparkstone/api/') ) {
            $this->_soapUrl = $apiUrlPrefix.$script;
        }
        $this->_debugMode = Mage::helper('sparkstone')->getStoreConfig('debug', 'sparkstone/api/') ? true : false;

        if ($this->_useSoapClient) {
            $this->initSoapClient();
        }
        return $this->_soapClient;
    }


    public function initSoapClient() {
        $auth = array();
        if (!$this->sandboxMode()) {
            $userName = Mage::helper('sparkstone')->getStoreConfig('username', 'sparkstone/api/');
            $pass = Mage::helper('sparkstone')->getStoreConfig('password', 'sparkstone/api/');


            $auth = array(
                'userid'=>$userName,
                'password'=>$pass,
                'trace' => $this->_trace
            );
        }

        $this->_soapClient = new SoapClient($this->_soapUrl, $auth);//GetXMLStockList

        $header = new SoapHeader('http://exchange.services.sparkstone.co.uk/', 'UserCredentials',$auth,false);
        $this->_soapClient->__setSoapHeaders($header);
    }




    public function logger($msg) {
        echo $msg."\r\n";
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