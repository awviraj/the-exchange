<?php
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;
$installer->startSetup();

//deprecated
$installer->run('CREATE TABLE dms_sparkstone_category_map(
spk_cat_id INT(11),
magento_cat_id INT(11)
)

');

$installer->endSetup();