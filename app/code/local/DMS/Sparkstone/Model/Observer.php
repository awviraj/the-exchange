<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Dilhan
 * Date: 3/8/14
 * Time: 8:57 PM
 * To change this template use File | Settings | File Templates.
 */
class DMS_Sparkstone_Model_Observer
{
    public function sparkstoneProductImport()
    {
        echo 'Cron Job is Starting';
        $sparkStone = Mage::getModel('sparkstone/stock');
        $sparkStone->prepareStockFile();
        echo 'Prepared XML';
        echo 'Importing';
        $sparkStone->importProducts();
        echo 'Done';
    }
}