<?php
class DMS_Sparkstone_Helper_Csv extends Mage_Core_Helper_Abstract {

    public function getCsvData($path)
    {
        try{
            $csvData = array();
            $fileName = $path;
            if (($handle = fopen("$fileName", "r")) !== FALSE) {
                while (($data = fgetcsv($handle, 10000, ",")) !== FALSE) {
                    $csvData[] = $data;
                }
                fclose($handle);
            }
            return $csvData;
        } catch (Exception $e) {
            Mage::logException($e);
        }

    }

    public function putCsvData($data, $path)
    {
        try{
            $fp = fopen($path, 'w');
            if (($handle = fopen($path, "w")) !== FALSE) {
                foreach ($data as $fields) {
                    fputcsv($fp, $fields);
                }
            }
        } catch (Exception $e) {
            Mage::logException($e);
        }

    }
}