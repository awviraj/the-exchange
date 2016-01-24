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
        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getParams();
            $emailTemplateForAdmin = Mage::getStoreConfig('dms_productrepairs/productrepairs/email-template-for-admin');
            $emailTemplateForCustomer = Mage::getStoreConfig('dms_productrepairs/productrepairs/email-template-for-customer');
            $receiverName = Mage::getStoreConfig('trans_email/ident_custom1/name');
            $receiverEmail = Mage::getStoreConfig('trans_email/ident_custom1/email');
            $customerSupportName = Mage::getStoreConfig('trans_email/ident_support/name');
            $customerSupportEmail = Mage::getStoreConfig('trans_email/ident_support/email');
            $data['booking_no'] = Mage::helper('dms_productrepairs')->getBookingNumber();
            $store = Mage::app()->getStore()->getId();
            try{
                Mage::getModel('core/email_template')
                    ->sendTransactional($emailTemplateForAdmin, array('name'=>$data['full_name'],'email'=>$data['email']), $receiverEmail, $receiverName, $data, $store);
                Mage::getModel('core/email_template')
                    ->sendTransactional($emailTemplateForCustomer, array('name'=>$customerSupportName,'email'=>$customerSupportEmail), $data['email'], $data['full_name'], $data, $store);
            }
            catch(Exception $e){
                Mage::logException($e);
            }

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
