<?php
class DMS_Sparkstone_Helper_Data extends Mage_Core_Helper_Abstract {

    public function getStoreConfig($config="phone", $scope='general/store_information/') {
        $storePhone = '';
        if ($config) {
            $storePhone = Mage::getStoreConfig($scope . $config);
        }
        return $storePhone ? $storePhone : '';
    }
}