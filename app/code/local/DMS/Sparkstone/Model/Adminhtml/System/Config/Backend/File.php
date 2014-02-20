<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 * @category    Mage
 * @package     Mage_Adminhtml
 * @copyright   Copyright (c) 2013 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * System config file field backend model
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author     Magento Core Team <core@magentocommerce.com>
 */
class DMS_Sparkstone_Model_Adminhtml_System_Config_Backend_File extends Mage_Adminhtml_Model_System_Config_Backend_File
{

    /**
     * Save uploaded file before saving config value
     *
     * @return Mage_Adminhtml_Model_System_Config_Backend_File
     */
    protected function _beforeSave()
    {
        shell_exec('rm media/dms/sparkstone/default/*.csv');
        parent::_beforeSave();
    }
}
