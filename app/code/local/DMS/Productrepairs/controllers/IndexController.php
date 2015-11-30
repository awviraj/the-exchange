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

            $emailTemplate = Mage::getStoreConfig('dms_productrepairs/productrepairs/email-template');
            $receiverName = Mage::getStoreConfig('trans_email/ident_custom1/name');
            $receiverEmail = Mage::getStoreConfig('trans_email/ident_custom1/email');
            $data['booking_no'] = Mage::helper('dms_productrepairs')->getBookingNumber();
            $store = Mage::app()->getStore()->getId();
            Mage::getModel('core/email_template')
                ->sendTransactional($emailTemplate, array('name'=>$data['full_name'],'email'=>$data['email']), $receiverEmail, $receiverName, $data, $store);
            Mage::getSingleton( 'customer/session' )->setRepairId($data['booking_no']);
            $this->_redirect('*/*/success');
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
