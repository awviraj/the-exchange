<?php
/**
 * DMS
 * Created by JetBrains PhpStorm.
 * User: Dilhan admaduranga@gmail.com
 * Date: 2/6/14
 * Time: 9:25 PM
 * To change this template use File | Settings | File Templates.
 */

class DMS_Sparkstone_Model_CategoryDecoder extends Mage_Core_Model_Abstract
{
    protected $_categorIds = array();

    public function decode($name) {
        if (empty($this->_categorIds[$name])) {
            $category = Mage::getModel('catalog/category')->load($name, 'name');
            if ($category->getId()) {
                $this->_categorIds[$name] = $category->getId();
            }
        }
        return !empty($this->_categorIds[$name]) ? $this->_categorIds[$name] : null;
    }
}