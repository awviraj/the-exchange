<?php
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;
$installer->startSetup();


$installer->run('ALTER TABLE catalog_category_entity ADD COLUMN spk_id INT(11)');
$installer->run('ALTER TABLE catalog_category_entity ADD COLUMN spk_path VARCHAR(255)');

$installer->endSetup();