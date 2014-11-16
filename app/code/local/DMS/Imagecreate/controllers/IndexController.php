<?php
/**
 * DMS
 * Created by JetBrains PhpStorm.
 * User: Dilhan
 * Date: 2/6/14
 * Time: 9:25 PM
 * To change this template use File | Settings | File Templates.
 */

class DMS_Imagecreate_IndexController extends Mage_Core_Controller_Front_Action {

    public function indexAction() {
        if ($this->getRequest()->isPost()) {
            $imageData = $this->getRequest()->getParam('imagedata');

            if (!empty($imageData)) {
                $success = Mage::helper('dms_imagecreate/image')->importImage($imageData);
                if ($success === true) {
                    //echo 'complete!';
                    $result = array('status' => 200, 'message' => 'file uploaded');
                } else {
                    $result = array('status' => 400, 'message' => $success);
                }
            }
        }
        $this->getResponse()->setBody(json_encode($result));
    }
}