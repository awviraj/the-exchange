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
    protected $_soapUrl;
    protected $_colMap;
    protected $_mediaPrefix = 'dms/sparkstone/';
    protected $_exportPath = 'var/import/';
    protected $_ready = false;
    protected $_colmapHasHeader = true;


    public function init() {
        $this->_soapUrl = 'http://retailservices.sparkstone.co.uk/SparkstoneRetailStock.asmx?WSDL';
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
        $client = new SoapClient($this->_soapUrl);//GetXMLStockList
        $strStockList = $client->GetXMLStockList()->GetXMLStockListResult->any;
        try {
            $xml = simplexml_load_string($strStockList);
            if ($xml) {
                return $xml;
            }
        }
        catch(Exception $ex) {
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

                foreach ($xml as $key => $element) {
                    $element = (array) $element;
                    $counter++;

                    foreach ($mappingCols as $key => $mapped) {

                        if (!empty($mapped[0])) {
                            $value = !empty($element[$mapped[1]]) ? $element[$mapped[1]] : $mapped[2];
                            $csvData[0][$key] = $mapped[0];
                            $csvData[$counter][$mapped[0]] = strVal($value);

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

    public function importProducts() {
        if ($this->_ready) {
            chdir('magmi/cli/');
            include_once('magmi_run_from_code.php');
        }
    }
}