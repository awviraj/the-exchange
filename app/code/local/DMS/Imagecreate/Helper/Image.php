<?php
/**
 * Created by DMS Pty Ltd.
 * User: Dilhan Maduranga
 * Date: 5/21/13
 * Time: 10:58 AM
 */
class DMS_Imagecreate_Helper_Image extends Mage_Core_Helper_Abstract
{
    const IMAGECREATE_TYPE_PNG = 'png';
    protected $_fileType;

    public function __construct(){
        $this->_fileType = self::IMAGECREATE_TYPE_PNG;
    }

    public function importImage($imageData) {
        if (!empty($imageData['sku']) && !empty($imageData['image'])) {
            try {
                $fileName = $this->getFileName($imageData['sku']);
                $path = $this->saveImage($imageData['image'], $fileName);
                $this->addImageToProduct($imageData['sku'], $path);

            } catch (Exception $e) {
                Mage::logException($e);
                return $e->getMessage();
            }
        }
        return true;
    }


    public function saveImage($data, $filePath) {

        if (strpos($data, ',')) {
            $break = explode(',', $data);
            $data = $break[1];
        }
        //
        $data = base64_decode($data);
        $im = imagecreatefromstring($data);
        $content = imagepng($im, $filePath);
        return  $filePath;
    }

    public function getFileName($sku) {
        $dirPath = Mage::getBaseDir('var');
        return $dirPath.'/import/images/'.$sku.'_'.time().rand().'.'.$this->_fileType;
    }

    public  function addImageToProduct($sku, $imgPath){
        //$product = Mage::getModel('catalog/product')->load($sku, 'sku');
        $product = Mage::getModel('catalog/product')->loadByAttribute('sku', $sku);
        if (!empty($product)) {
            if (!$product->getMediaGalleryImages()) {
                $mediaAttribute = array (
                    'thumbnail',
                    'small_image',
                    'image'
                );
            } else {
                $mediaAttribute = null;
            }

            if ($mediaAttribute) {
                if ( file_exists($imgPath) ) {
                    try {
                        $product->addImageToMediaGallery($imgPath, $mediaAttribute, false);
                    } catch (Exception $e) {
                        Mage::logException($e);
                    }
                }
            }
            Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
            $product->save();
        } else {
            Mage::throwException('Invalid Product Code');
            return false;
        }
        return true;
    }
}