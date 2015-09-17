<?php
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;
$installer->startSetup();

#$installer->run('ALTER TABLE catalog_category_entity ADD COLUMN spark_cat_id INT NULL');
#$installer->run('ALTER TABLE catalog_category_entity ADD COLUMN spark_parent_cat_id INT NULL');


$installer->run('CREATE TABLE dms_sparkstone_category_map(
spk_cat_id INT(11),
magento_cat_id INT(11)
)

');

$installer->endSetup();