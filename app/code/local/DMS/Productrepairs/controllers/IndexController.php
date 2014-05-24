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
}
