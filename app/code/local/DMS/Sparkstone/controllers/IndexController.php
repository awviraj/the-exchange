<?php
/**
 * DMS
 * Created by JetBrains PhpStorm.
 * User: Dilhan
 * Date: 2/6/14
 * Time: 9:25 PM
 * To change this template use File | Settings | File Templates.
 */

class DMS_Sparkstone_IndexController extends Mage_Core_Controller_Front_Action {

    public function indexAction() {
        $sparkStone = Mage::getModel('sparkstone/stock');
        $sparkStone->getStockData();
    }
}