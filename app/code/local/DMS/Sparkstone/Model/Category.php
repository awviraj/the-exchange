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
        $categories = null;
        $this->_magentoCategories  = Mage::getModel('catalog/category')
            ->getCollection()
            //->removeAttributeToSelect('entity_id')
            ->addAttributeToSelect('name')
            ->load()
            ->exportToArray();

        foreach($this->_magentoCategories as $category)
        {
            $namePath = $this->_createNamePath($category['path']);
            $this->_magentoLeveledCategories[$category['level']] [$namePath]= $category;
            $this->_magentoLeveledCategories[$category['level']] [$namePath]['name_path']= $namePath;
        }
        return $categories;
    }

    protected function _createNamePath($idPath){
        $idPath = explode('/',$idPath);
        foreach($idPath as $id){
            $namePath[] = $this->_magentoCategories[(int)$id]['name'];
        }
        $namePath = implode('/',$namePath);
        $namePath = str_replace(array('Root Catalog','/Default Category/','/Default Category'),'',$namePath);
        return $namePath;
    }

    /**
     * Run Category Import
     */
    protected function _importCategories($spkCategoryData) {

        $this->_prepareSpkCategoryData($spkCategoryData);
        $allStores = Mage::app()->getStores();
        foreach($this->_spkLeveledCategories as $level=>$spkLevelCategories){
            foreach($spkLevelCategories as $spkLevelCategory){
                if(!isset($this->_magentoLeveledCategories[$level+1]) || !isset($this->_magentoLeveledCategories[$level+1][$spkLevelCategory['name_path']])) {
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
                            $this->_categoryMap[$spkLevelCategory['CategoryNumber']] = $category->getEntityId();
                            unset($category);
                        } catch (Exception $e) {
                            Mage::logException($e);
                        }
                    }
                }
                else{
                    $this->_categoryMap[$spkLevelCategory['CategoryNumber']] = $this->_magentoLeveledCategories[$level+1][$spkLevelCategory['name_path']]['entity_id'];
                    continue;
                }
            }
            $level++;
            $this->_getMagentoCategoryData();
        }
        $this->_createCategoryMap();
    }

    protected function _getParentId($spkLevelCategory,$level){
        $namePath = $this->_spkLeveledCategories[$level-1][$spkLevelCategory['ParentCategory']]['name_path'];
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
                $this->_spkLeveledCategories[1][$spkCategory['CategoryNumber']]['name_path'] = $spkCategory['CategoryName'];
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
                    $this->_spkLeveledCategories[$level][$spkCategory['CategoryNumber']]['name_path'] = $this->_spkLeveledCategories[$level-1][$spkCategory['ParentCategory']]['name_path'].'/'.$spkCategory['CategoryName'];
                    unset($spkCategoryData[$key]);
                    $changes = true;
                }
            }
            $level++;
        }
    }

    protected function _createCategoryMap(){
        $insertQuery = '';
        foreach($this->_categoryMap as $magID=>$spkID)
        {
            $insertQuery.= '("'.$spkID.'","'.$magID.'"),';
        }
        if(!empty($insertQuery)){
            $insertQuery = "INSERT INTO dms_sparkstone_category_map VALUES ".$insertQuery;
            $insertQuery = trim($insertQuery,',');
            $this->_writeConnection-> query('DELETE FROM dms_sparkstone_category_map');
            $this->_writeConnection-> query($insertQuery);
        }
    }

}
