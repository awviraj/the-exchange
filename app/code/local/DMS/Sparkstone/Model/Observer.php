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
        echo "Cron Job is Starting (product)\r\n";
        $sparkStone = Mage::getModel('sparkstone/stock');
        $sparkStone->prepareStockFile();
        $sparkStone->importProducts();
        echo "Done\r\n";
    }

    public function sparkstoneCategoryImport()
    {
        echo "Cron Job is Starting (category)\r\n";
        $sparkStone = Mage::getModel('sparkstone/category');
        $sparkStone->importCategories();
        echo "Done\r\n";
    }
}