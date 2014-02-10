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

    public function init() {
        $this->_soapUrl = 'http://retailservices.sparkstone.co.uk/SparkstoneRetailStock.asmx?WSDL';
    }

    public function getStockData() {
        $client = new SoapClient($this->_soapUrl);//GetXMLStockList
        $strStockList = $client->GetXMLStockList()->GetXMLStockListResult->any;
        try {
            $xml = simplexml_load_string($strStockList);
            $this->saveResponse($strStockList);

            if ($xml) {
                foreach ($xml as $key => $product) {
                    $this->saveProduct($product);
                }
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

    public function saveProduct($objProduct) {
        $product = Mage::getModel('catalog/product');
        $simple = 'simple';
        $product->setAttributeSetId(4);
        $product->setSku($objProduct->StockCode);
        $product->setName($objProduct->ShortName);
        $product->setTypeId($simple);
        $product->setPrice($objProduct->NetSellPrice);
        $product->setValue($objProduct->CostPrice);
        $product->setDescription($objProduct->LongDescription);
        $product->setShortDescription($objProduct->LongDescription);
        $product->setWeight(100);
        $product->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_NOT_VISIBLE);
        $product->setStatus(Mage_Catalog_Model_Product_Status::STATUS_ENABLED);
        $product->setTaxClassId(2);
        $product->setStockData(array(
            'is_in_stock' => 1,
            'qty' => $objProduct->QuantityInStock
        ));

        try {
            $product->save();
        }
        catch (Exception $ex) {
            Mage::logException($ex);
        }
    }
}