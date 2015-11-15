<?php
/**
 * DMS
 * Created by JetBrains PhpStorm.
 * User: Vishwa
 * Date: 12/8/15
 * Time: 9:4 P5M
 * To change this template use File | Settings | File Templates.
 */

class DMS_Sparkstone_Model_Category extends DMS_Sparkstone_Model_Abstract
{
    protected $_magentoCategories = array();
    protected $_magentoLeveledCategories = array();
    protected $_magentoActiveCategories = array();
    protected $_spkLeveledCategories = array();
    protected $_categoryMap = array();
    protected $_writeConnection = null;

    public function __construct(){
        $this->_getMagentoCategoryData();
        $this->_writeConnection = Mage::getSingleton('core/resource')->getConnection('core_write');
    }

    public function importCategories() {
        $categoryData = $this->getCategoryData();
        if ($categoryData) {
            $this->logger('Saving category data');
            $this->_importCategories($categoryData);
            $this->logger('Save complete');
            $this->logger('Disabling Categories');
            $this->_disableCategories();
            $this->logger('Disable complete');
        }
    }

    public function getCategoryData() {
        try {
            $connector = Mage::getModel('sparkstone/connector');
            $client = $connector->init();

            $this->logger('Retrieving Category Data Via SoapClient');

            $responseData = $client->GetCategories();
            $strStockList = $responseData->GetCategoriesResult->any;
            $this->logger('Data retrieved...');

            $xml = simplexml_load_string($strStockList);
            if ($xml) {
                return $xml;
            }
        }
        catch(Exception $ex) {
            Mage::logException($ex);
            echo "Unable to process xml file because of the following error<br /><br /> $ex";
            exit;
        }
    }


    protected function _getMagentoCategoryData(){
        Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
        $this->_magentoCategories = Mage::getModel('catalog/category')
            ->getCollection()
            ->addAttributeToSelect('name')
            ->addAttributeToFilter('name',array('nin'=>array('Root Catalog','Default Category')))
            ->load()
            ->exportToArray();

        foreach($this->_magentoCategories as $category)
        {
            if(!empty($category['spk_path'])){
                $this->_magentoLeveledCategories[$category['level']] [$category['spk_path']]= $category;
                $this->_magentoLeveledCategories[$category['level']] [$category['spk_path']]['id_path']= $category['spk_path'];
            }
        }
    }

    /**
     * Run Category Import
     */
    protected function _importCategories($spkCategoryData) {

        $this->_prepareSpkCategoryData($spkCategoryData);
        $allStores = Mage::app()->getStores();
        foreach($this->_spkLeveledCategories as $level=>$spkLevelCategories){
            foreach($spkLevelCategories as $spkLevelCategory){
                if(!isset($this->_magentoLeveledCategories[$level+1]) || !isset($this->_magentoLeveledCategories[$level+1][$spkLevelCategory['id_path']])) {
                    foreach ($allStores as $store) {
                        try {
                            $category = Mage::getModel('catalog/category');
                            $category->setName($spkLevelCategory['CategoryName']);
                            $category->setUrlKey(preg_replace('/\\s+/', '-', $spkLevelCategory['CategoryName']));
                            $category->setIsActive(1);
                            $category->setDisplayMode('PRODUCTS');
                            $category->setIsAnchor(1);
                            $category->setAttributeSetId($category->getDefaultAttributeSetId());
                            $category->setStoreId($store->getStoreId());
                            $parentId = $level==1?'2':$this->_getParentId($spkLevelCategory,$level);
                            $parentCategory = Mage::getModel('catalog/category')->load($parentId);
                            $category->setPath($parentCategory->getPath());
                            $category->save();
                            $this->_categoryMap[$category->getEntityId()]['spk_id'] = $spkLevelCategory['CategoryNumber'];
                            $this->_categoryMap[$category->getEntityId()]['spk_path'] = $spkLevelCategory['id_path'];
                            $this->_magentoActiveCategories[$category->getEntityId()] = $category->getEntityId();
                            unset($category);
                        } catch (Exception $e) {
                            Mage::logException($e);
                        }
                    }
                }
                else{
                    foreach ($allStores as $store){
                        if(isset($this->_magentoLeveledCategories[$level+1]) || isset($this->_magentoLeveledCategories[$level+1][$spkLevelCategory['id_path']]))
                        {
                            try {
                                $category = Mage::getModel('catalog/category')->setStoreId($store->getStoreId())->load($this->_magentoLeveledCategories[$level+1][$spkLevelCategory['id_path']]['entity_id']);
                                if($category->getName() != $spkLevelCategory['CategoryName'] || !$category->getIsActive()){
                                    $category->setIsActive(1);
                                    $category->setName($spkLevelCategory['CategoryName']);
                                    $category->setStoreId($store->getStoreId());
                                    $category->save();
                                }
                                $this->_magentoActiveCategories[$category->getEntityId()] = $category->getEntityId();
                                unset($category);
                            } catch (Exception $e) {
                                Mage::logException($e);
                            }
                        }
                        $this->_categoryMap[$this->_magentoLeveledCategories[$level+1][$spkLevelCategory['id_path']]['entity_id']]['spk_id']  = $spkLevelCategory['CategoryNumber'];
                        $this->_categoryMap[$this->_magentoLeveledCategories[$level+1][$spkLevelCategory['id_path']]['entity_id']]['spk_path']  = $spkLevelCategory['id_path'];
                    }
                    //continue;
                }
            }
            $this->_createCategoryMap();
            $level++;
            $this->_getMagentoCategoryData();
        }

    }

    protected function _getParentId($spkLevelCategory,$level){
        $namePath = $this->_spkLeveledCategories[$level-1][$spkLevelCategory['ParentCategory']]['id_path'];
        $id = $this->_magentoLeveledCategories[$level][$namePath]['entity_id'];
        return $id;
    }

    protected function _prepareSpkCategoryData($spkCategoryData){
        $spkCategoryData = json_decode(json_encode((array)$spkCategoryData), TRUE);
        $spkCategoryData = $spkCategoryData['SparkstoneCategory'];
        $changes = true;
        $parentIds = null;

        //get level 1 categories
        foreach($spkCategoryData as $key=>$spkCategory){
            if($spkCategory['ParentCategory']=='0'){
                $this->_spkLeveledCategories[1][$spkCategory['CategoryNumber']] = $spkCategory;
                $this->_spkLeveledCategories[1][$spkCategory['CategoryNumber']]['id_path'] = $spkCategory['CategoryNumber'];
                unset($spkCategoryData[$key]);
            }
        }

        //go through the other levels
        $level = 2;
        while($changes && !empty($spkCategoryData)) {
            $changes = false;
            foreach($spkCategoryData as $key=>$spkCategory){
                if(array_key_exists($spkCategory['ParentCategory'],$this->_spkLeveledCategories[$level-1])){
                    $this->_spkLeveledCategories[$level][$spkCategory['CategoryNumber']] =  $spkCategory;
                    $this->_spkLeveledCategories[$level][$spkCategory['CategoryNumber']]['id_path'] = $this->_spkLeveledCategories[$level-1][$spkCategory['ParentCategory']]['id_path'].'/'.$spkCategory['CategoryNumber'];
                    unset($spkCategoryData[$key]);
                    $changes = true;
                }
            }
            $level++;
        }
    }

    protected function _createCategoryMap(){
        $insertQuery = '';
        foreach($this->_categoryMap as $magID=>$spk)
        {
            $insertQuery.= '("'.$magID.'","'.$spk['spk_id'].'","'.$spk['spk_path'].'"),';
        }
        if(!empty($insertQuery)){
            $insertQuery = "INSERT INTO catalog_category_entity (entity_id,spk_id,spk_path) VALUES ".trim($insertQuery,',').
                " ON DUPLICATE KEY UPDATE spk_id=VALUES(spk_id),spk_path=VALUES(spk_path);";
            $this->_writeConnection-> query($insertQuery);
        }
        $this->_categoryMap = array();
    }

    protected function _disableCategories(){
        //not configured for stores.
        $cats_to_disable = Mage::helper('sparkstone')->getStoreConfig('spk_cats_to_disable', 'sparkstone/api/');
        $cats_to_disable = explode(",",$cats_to_disable);
        $cats_to_disable = array_map('trim',$cats_to_disable);
        foreach($this->_magentoCategories as $category)
        {
            if(in_array($category['spk_id'],$cats_to_disable) || (!empty($category['spk_path']) && !in_array($category['entity_id'],$this->_magentoActiveCategories))){
                try{
                    $cat = Mage::getModel('catalog/category')->load($category['entity_id']);
                    if($cat->getIsActive()){
                        $cat->setIsActive(0);
                        $cat->save();
                    }
                } catch (Exception $e) {
                    Mage::logException($e);
                }
            }
        }
    }

}
