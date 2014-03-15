<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Dilhan
 * Date: 3/15/14
 * Time: 12:24 AM
 * To change this template use File | Settings | File Templates.
 */
class DMS_CommonRewrites_Block_Page_Html_Welcome extends Mage_Core_Block_Template
{
    /**
     * Get block messsage
     *
     * @return string
     */
    protected function _toHtml()
    {
        if (empty($this->_data['welcome'])) {
            if (Mage::isInstalled() && Mage::getSingleton('customer/session')->isLoggedIn()) {
                $this->_data['welcome'] = $this->__('Welcome, %s!', $this->escapeHtml(Mage::getSingleton('customer/session')->getCustomer()->getFirstname()));
            } else {
                $this->_data['welcome'] = ''; //Mage::getStoreConfig('design/header/welcome');
            }
        }

        return $this->_data['welcome'];
    }
}