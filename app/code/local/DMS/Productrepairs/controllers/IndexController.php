<?php
/**
 * @category    DMS
 * @package     DMS_Productrepairs
 * @copyright   admaduranga@gmail.com
 * @license     admaduranga@gmail.com
 */

/**
 * Catalog product controller
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author     Magento Core Team <core@magentocommerce.com>
 */
class DMS_Productrepairs_IndexController extends Mage_Core_Controller_Front_Action
{
    /**
     * Product grid for AJAX request
     */
    public function indexAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    public function bookAction() {
        $email = null;
        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getParams();
            if ($brand = $this->getRequest()->getParam('brand')) {

                $attribute = Mage::getSingleton('eav/config')->getAttribute('catalog_product', 'brand');
                if ($attribute->usesSource()) {
                    $brandLabel = $attribute->getSource()->getOptionText($brand);
                }
                $data['brand'] = $brandLabel;
            }

            $repairId = Mage::getStoreConfig('dms_productrepairs/productrepairs/repair-id');
            Mage::getModel('core/config')->saveConfig('dms_productrepairs/productrepairs/repair-id', $repairId);

            $data['booking_no'] = Mage::helper('productrepairs')->getBookingNumber($repairId);

            $store = Mage::app()->getStore()->getId();
            $email = Mage::getModel('core/email_template')
                ->sendTransactional(1, 'admaduranga@gmail.com', 'admaduranga@gmail.com', 'John Doe', $data, $store);

            $this->_forward('*/*/success');
        }
    }

    public function ajaxloadAction() {
        if ($this->getRequest()->isPost()) {
            $html = $this->getLayout()->createBlock('dms_productrepairs/form')
                ->setTemplate('productrepairs/ajax_select.phtml')
                ->toHtml();
            $this->getResponse()->setBody($html);
        } else {
            $this->_forward('*/*/index');
        }
    }

    public function successAction() {
        $this->loadLayout();
        $this->renderLayout();
    }
}
