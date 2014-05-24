<?php
/**
 * Created by DMS Pty Ltd.
 * User: Dilhan Maduranga
 * Date: 5/21/13
 * Time: 11:36 AM
 */
class DMS_Productrepairs_Block_Form extends Mage_Core_Block_Template
{
    public function getBrands() {
        return array('Apple', 'Nokia');
    }

    public function getModels() {
        return array('Galaxy s4', 'iPhone 5s');
    }

    public function getPageDescription() {
        return $this->helper('commonrewrites')->getStoreConfig('page-description', 'dms_productrepairs/productrepairs/');
    }
}
