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
    protected $_mappings = array();
    protected $_readConnection = null;

    public function __construct(){
        $this->_readConnection = Mage::getSingleton('core/resource')->getConnection('core_read');
    }

    public function decode($spk_ids) {
        $magento_cat_ids = array();
        foreach($spk_ids as $spk_id){
            if(isset($this->_mappings[$spk_id])){
                $magento_cat_ids[] = $this->_mappings[$spk_id]['magento_cat_id'];
            }
        }
        return $magento_cat_ids;
    }

    public function loadMappings(){
        $this->_mappings = $this->_readConnection->fetchAssoc('SELECT * FROM dms_sparkstone_category_map');
    }
}