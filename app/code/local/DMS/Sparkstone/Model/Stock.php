<?php
/**
 * DMS
 * Created by JetBrains PhpStorm.
 * User: Dilhan
 * Date: 2/6/14
 * Time: 9:25 PM
 * To change this template use File | Settings | File Templates.
 */

class DMS_Sparkstone_Model_Stock extends Mage_Core_Model_Abstract
{
    CONST TYPE_STOCK_LIST = 'GetXMLStockList';
    protected $_soapUrl = 'http://retailservices.sparkstone.co.uk/SparkstoneRetailStock.asmx?WSDL';
    protected $_colMap;
    protected $_mediaPrefix = 'dms/sparkstone/';
    protected $_exportPath = 'var/import/';
    protected $_ready = false;
    protected $_colmapHasHeader = true;
    protected $_debugMode;
    protected $_logFile = 'sparkstone.log';
    protected $_sandbox = true;


    public function init() {
        $this->_sandbox = Mage::helper('sparkstone')->getStoreConfig('sandbox', 'sparkstone/api/');
        $apiUrlPrefix = $this->sandboxMode() ? 'sandboxurl' : 'apiurl';
        if ($apiUrlPrefix = Mage::helper('sparkstone')->getStoreConfig($apiUrlPrefix, 'sparkstone/api/') ) {
            $this->_soapUrl = $apiUrlPrefix;
        }
        $this->_debugMode = Mage::helper('sparkstone')->getStoreConfig('debug', 'sparkstone/api/') ? true : false;
    }

    public function debugMode() {
        return $this->_debugMode;
    }

    public function sandboxMode() {
        return $this->_sandbox;
    }
    public function prepareStockFile() {
        $this->init();
        $productXml = $this->getProductData();
        if ($productXml) {
            $this->saveResponse($productXml);
            $this->_formatProductData($productXml);
        }
    }

    public function setReady($ready) {
        $this->_ready = $ready;
    }

    public function getProductData() {
        try {
            $session = null;
            $client = new SoapClient($this->_soapUrl);//GetXMLStockList
            if ($this->debugMode()) {
                $functions = $client->__getFunctions ();
                Mage::log($functions, null, $this->_logFile);
                Mage::log($this->_soapUrl, null, $this->_logFile);
            }

            if (!$this->sandboxMode()) {
                $userName = Mage::helper('sparkstone')->getStoreConfig('username', 'sparkstone/api/');
                $pass = Mage::helper('sparkstone')->getStoreConfig('password', 'sparkstone/api/');
                $session = $client->login( $userName, $pass );
            }

            $strStockList = $client->GetXMLStockList()->GetXMLStockListResult->any;

            if ($this->debugMode()) {
                Mage::log($strStockList, null, $this->_logFile);
            }

            $xml = simplexml_load_string($strStockList);
            if ($xml) {
                return $xml;
            }
        }
        catch(Exception $ex) {
            Mage::logException($ex);
            echo "Unable to process xml file because of the following error<br /><br /> $ex";
            exit;
        }
    }

    /**
     * @param $xml
     * @return $this DMS_Sparkstone_Model_Stock
     */
    public function saveResponse($xml) {
        if ($xml) {
            try{
                $resp = Mage::getModel('sparkstone/responses');
                $resp->setType(self::TYPE_STOCK_LIST);
                $resp->setResponse($xml);
                $resp->save();
            } catch(Exception $e) {
                Mage::logException($e);
            }
        }
        return $this;
    }


    /**
     * @param $xml
     * Format Data
     */
    protected function _formatProductData($xml)
    {
        $mappingFile = Mage::helper('sparkstone')->getStoreConfig('csvmapper', 'sparkstone/api/');
        $mappingCols = Mage::helper('sparkstone/csv')->getCsvData(Mage::getBaseUrl('media').$this->_mediaPrefix.$mappingFile);
        $colMapHeader = null;
        $csvData = array();
        $csvHeader = array();
        $counter = 0;

        if ($this->_colmapHasHeader && empty($colMapHeader)) {
            $colMapHeader = array_shift($mappingCols);
        }

        try{
            if (!empty($xml) && !empty($mappingCols)) {
                foreach ($xml as $baseKey => $element) {

                    $element = (array) $element;
                    $counter++;

                    foreach ($mappingCols as $key => $mapped) {
                        if (!empty($mapped[0])) {
                            $value = !empty($element[$mapped[1]]) ? $element[$mapped[1]] : $mapped[2];
                            $csvData[0][$key] = $mapped[0];
                            $csvData[$counter][$mapped[0]] = strVal($value);

                        }

                        if ($mapped[0] == 'category_ids') {
                            $categoryIds = $this->fetchCategoryIds($element, $mapped);
                            if ($categoryIds) {
                                $csvData[$counter][$mapped[0]] = implode(',', $categoryIds);
                            }
                        }
                    }
                }
                Mage::helper('sparkstone/csv')->putCsvData($csvData, $this->_exportPath .'import.csv');
                $this->setReady(true);
            }
        } catch (Exception $e) {
            Mage::logException($e);
        }

    }

    /**
     * Run Magmi Import
     */
    public function importProducts() {
        try{
            if ($this->_ready) {
                chdir('magmi/cli/');
                include_once('magmi_run_from_code.php');
            }
        } catch (Exception $e) {
            Mage::logException($e);
        }

    }

    /**
     * @param $xml
     * @param $mapped
     * @return array
     */
    public function fetchCategoryIds($xml, $mapped) {
        $categoryIds = array();
        $decoder = Mage::getSingleton('sparkstone/categoryDecoder');
        $categoryFields = explode(',', $mapped[1]);
        if (is_array($categoryFields)) {
            foreach ($categoryFields as $label) {
                $label = trim($label);
                if (!empty($xml[$label])) {
                    $categoryIds[] = $decoder->decode($xml[$label]);
                }

            }
        }
        return $categoryIds;
    }
}