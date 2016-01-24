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
//        $attribute = Mage::getSingleton('eav/config')->getAttribute('catalog_product', 'brand');
//        if ($attribute->usesSource()) {
//            $options = $attribute->getSource()->getAllOptions(false);
//            array_unshift($options, array('label' => $this->__('(Please select the brand)'), 'value' => ''));
//        }
        $options = Mage::getModel('dms_productrepairs/brand')->getCollection();
        return $options;
        //return $options ? $options array('' => '(Please Select)');
    }

    public function getModels() {
        return array('Galaxy s4', 'iPhone 5s');
    }

    public function getPageDescription() {
        return $this->helper('commonrewrites')->getStoreConfig('page-description', 'dms_productrepairs/productrepairs/');
    }

    public function getProductModelsFromBrand() {
        $selectedBrand = $this->getRequest()->getParam('selected_brand');
        $optionsArray = array();

        if ($selectedBrand) {
            $collection = Mage::getModel('catalog/product')->getCollection()
                ->addFieldToFilter('brand', $selectedBrand)
                ->addAttributeToSort('name', 'ASC');
            $collection->getSelect()->columns('name');

            if ($collection->getSize()) {
                foreach ($collection  as $product) {
                    $optionsArray[$product->getName()] = $product->getName();
                }
            }

            Mage::log($collection->getSelect()->assemble());
        } else {
            $optionsArray[] = $this->__('(Please select the brand)');
        }

        return $optionsArray;
    }

    public function getRepairId()
    {
        return Mage::getSingleton( 'customer/session' )->getRepairId();
    }
}
