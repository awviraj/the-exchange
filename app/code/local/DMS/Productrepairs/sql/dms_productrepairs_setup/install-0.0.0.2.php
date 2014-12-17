<?php
$installer = $this;
$installer->startSetup();
$table = $installer->getConnection()
    ->newTable($installer->getTable('dms_productrepairs/brands'))
    ->addColumn('brand_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
    ), 'Brand Id')
    ->addColumn('name', Varien_Db_Ddl_Table::TYPE_VARCHAR, null, array(
        'nullable'  => false,
    ), 'Name')
    ->addColumn('type', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
        'nullable'  => false,
    ), 'Type')
    ->addColumn('sort_order', Varien_Db_Ddl_Table::TYPE_INTEGER, 0, array(
        'nullable'  => false,
    ), 'Sort Order')
    ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, 0, array(
        'nullable'  => false,
        'default'   => Varien_Db_Ddl_Table::TIMESTAMP_UPDATE
    ), 'Sort Order');
$installer->getConnection()->createTable($table);

$table = $installer->getConnection()
    ->newTable($installer->getTable('dms_productrepairs/models'))
    ->addColumn('model_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
    ), 'Model Id')
    ->addColumn('brand_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => false,
    ), 'Brand Id')
    ->addColumn('name', Varien_Db_Ddl_Table::TYPE_VARCHAR, null, array(
        'nullable'  => false,
    ), 'Name')
    ->addColumn('sort_order', Varien_Db_Ddl_Table::TYPE_INTEGER, 0, array(
        'nullable'  => false,
    ), 'Sort Order')
    ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, 0, array(
        'nullable'  => false,
        'default'   => Varien_Db_Ddl_Table::TIMESTAMP_UPDATE
    ), 'Sort Order');

$installer->getConnection()->createTable($table);
$installer->getConnection()->addKey($installer->getTable('dms_productrepairs/models'), 'brand_id', array('brand_id'), 'index');



$installer->endSetup();