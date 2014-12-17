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
class DMS_Productrepairs_Adminhtml_IndexController extends Mage_Adminhtml_Controller_Action
{
    /**
     * Product grid for AJAX request
     */
    public function indexAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }


    protected function _initAction()
    {
        $this->loadLayout()->_setActiveMenu('test/set_time')
            ->_addBreadcrumb('test Manager','test Manager');
        return $this;
    }

    public function editAction()
    {
        $testId = $this->getRequest()->getParam('id');
        $brand = Mage::getModel('dms_productrepairs/brand')->load($testId);
        if ($brand->getId() || $testId == 0)
        {
            Mage::register('brand', $brand);
            $this->loadLayout();
            $this->_setActiveMenu('test/set_time');
            $this->_addBreadcrumb('test Manager', 'test Manager');
            $this->_addBreadcrumb('Test Description', 'Test Description');
            $this->getLayout()->getBlock('head')
                ->setCanLoadExtJs(true);
            $this->_addContent($this->getLayout()
                ->createBlock('dms_productrepairs/adminhtml_index_edit'))
                ->_addLeft($this->getLayout()
                        ->createBlock('dms_productrepairs/adminhtml_index_edit_tabs')
                );
            $this->renderLayout();
        }
        else
        {
            Mage::getSingleton('adminhtml/session')
                ->addError('Test does not exist');
            $this->_redirect('*/*/');
        }
    }
    public function newAction()
    {
        $this->_forward('edit');
    }
    public function saveAction()
    {
        if ($this->getRequest()->getPost())
        {
            try {
                $postData = $this->getRequest()->getPost();
                $testModel = Mage::getModel('dms_productrepairs/brand');
                if( $this->getRequest()->getParam('id') <= 0 )
                    $testModel->setCreatedTime(
                        Mage::getSingleton('core/date')
                            ->gmtDate()
                    );
                $testModel
                    ->addData($postData)
                    ->setUpdateTime(
                        Mage::getSingleton('core/date')
                            ->gmtDate())
                    ->setId($this->getRequest()->getParam('id'))
                    ->save();
                Mage::getSingleton('adminhtml/session')
                    ->addSuccess('successfully saved');
                Mage::getSingleton('adminhtml/session')
                    ->settestData(false);
                $this->_redirect('*/*/');
                return;
            } catch (Exception $e){
                Mage::getSingleton('adminhtml/session')
                    ->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')
                    ->settestData($this->getRequest()
                            ->getPost()
                    );
                $this->_redirect('*/*/edit',
                    array('id' => $this->getRequest()
                        ->getParam('id')));
                return;
            }
        }
        $this->_redirect('*/*/');
    }
    public function deleteAction()
    {
        if($this->getRequest()->getParam('id') > 0)
        {
            try
            {
                $testModel = Mage::getModel('test/test');
                $testModel->setId($this->getRequest()
                    ->getParam('id'))
                    ->delete();
                Mage::getSingleton('adminhtml/session')
                    ->addSuccess('successfully deleted');
                $this->_redirect('*/*/');
            }
            catch (Exception $e)
            {
                Mage::getSingleton('adminhtml/session')
                    ->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            }
        }
        $this->_redirect('*/*/');
    }
}
