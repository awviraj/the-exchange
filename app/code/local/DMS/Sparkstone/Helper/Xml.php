<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Dilhan
 * Date: 3/25/14
 * Time: 10:18 PM
 * To change this template use File | Settings | File Templates.
 */
class DMS_Sparkstone_Helper_Xml extends Mage_Core_Helper_Abstract
{
    protected $_rootTag = 'SalesOrders';

    protected function arrayToXml($student_info, &$xml_student_info) {
        foreach($student_info as $key => $value) {
            if(is_array($value)) {
                if(!is_numeric($key)){
                    $subnode = $xml_student_info->addChild("$key");
                    $this->arrayToXml($value, $subnode);
                }
                else{
                    $subnode = $xml_student_info->addChild("item$key");
                    $this->arrayToXml($value, $subnode);
                }
            }
            else {
                $xml_student_info->addChild("$key",htmlspecialchars("$value"));
            }
        }
    }

    public function convertArrayToXml($data) {
        // creating object of SimpleXMLElement
        $xmlStudentInfo = new SimpleXMLElement("<?xml version=\"1.0\"?><".$this->_rootTag."></".$this->_rootTag.">");
        // function call to convert array to xml
        $this->arrayToXml($data,$xmlStudentInfo);
        //saving generated xml file
        //Mage::log($xmlStudentInfo->);
        $xmlStudentInfo->asXML('file path and name');
    }
}