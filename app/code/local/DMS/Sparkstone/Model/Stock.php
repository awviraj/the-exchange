<?php
/**
 * DMS
 * Created by JetBrains PhpStorm.
 * User: Dilhan
 * Date: 2/6/14
 * Time: 9:25 PM
 * To change this template use File | Settings | File Templates.
 */

class DMS_Sparkstone_Model_Stock extends DMS_Sparkstone_Model_Abstract
{
    CONST TYPE_STOCK_LIST = 'GetXMLStockList';
    protected $_soapUrl = 'http://retailservices.sparkstone.co.uk/SparkstoneRetailStock.asmx?WSDL';
    protected $_colMap;
    protected $_mediaPrefix = 'dms/sparkstone/';
    protected $_exportPath;
    protected $_ready = false;
    protected $_colmapHasHeader = true;

    public function prepareStockFile() {
        $productXml = $this->getProductData();
        if ($productXml) {
            $this->logger('Saving response to database');
            $this->_formatProductData($productXml);
        }
    }

    public function setReady($ready) {
        $this->_ready = $ready;
    }

    public function getProductData() {
        try {
            $session = null;
            $connector = Mage::getModel('sparkstone/connector');
            $client = $connector->init();

            $this->logger('Retrieving Data Via SoapClient');

            $responseData = $client->GetXMLStockList(array('IncludeSecondHand' => true, 'IncludeNonSecondHand' => true));
            $strStockList = $responseData->GetXMLStockListResult->any;
            $this->logger('Data retrieved...');

            $xml = simplexml_load_string($strStockList);
            //Mage::log($xml);
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
        $this->logger('Formatting Data...');
        $mappingFile = Mage::helper('sparkstone')->getStoreConfig('csvmapper', 'sparkstone/api/');
        $mappingCols = Mage::helper('sparkstone/csv')->getCsvData(Mage::getBaseUrl('media').$this->_mediaPrefix.$mappingFile);
        $this->_exportPath = Mage::getBaseDir().'/'.Mage::helper('sparkstone')->getStoreConfig('importpath', 'sparkstone/api/');
        //echo  $this->_exportPath; exit;

        $colMapHeader = null;
        $csvData = array();
        $counter = 0;

        if ($this->_colmapHasHeader && empty($colMapHeader)) {
            $colMapHeader = array_shift($mappingCols);
        }

        try{
            if (!empty($xml) && !empty($mappingCols)) {
                foreach ($xml as $element) {

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
                            else{
                                $csvData[$counter][$mapped[0]] = '';
                            }
                        }
                    }
                }
                $this->logger('Finishing up formatted data');
                Mage::helper('sparkstone/csv')->putCsvData($csvData, $this->_exportPath .'import.csv');


                //echo  '***'.$this->_exportPath .'import.csv';exit;
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
            $this->logger('Start Importing Data...');
            if ($this->_ready) {
                chdir(Mage::getBaseDir().'/magmi/cli/');
                include_once('magmi_run_from_code.php');
            }
            $this->logger('Finished Importing Data');
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
        $decoder->loadMappings();
        $categoryFields = explode(',', $xml[$mapped[1]]);
        $categoryIds = $decoder->decode($categoryFields);
        return $categoryIds;
    }
}
