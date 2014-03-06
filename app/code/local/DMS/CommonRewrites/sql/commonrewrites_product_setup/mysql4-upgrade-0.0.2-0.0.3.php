<?php
/**
 * @category    Mage
 * @package     Mage_Catalog
 * @copyright   Copyright (c) 2013 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
//
//$installer = $this;
/* @var $installer Mage_Catalog_Model_Entity_Setup */
//$installer = Mage::getResourceModel('catalog/setup', 'catalog_setup');
//$installer->removeAttribute('catalog_product','buying_price');
$installer = $this;
$installer->removeAttribute('catalog_product','buying_price');
$installer->installEntities();

//
//$installer = new Mage_Catalog_Model_Resource_Eav_Mysql4_Setup('core_setup');
//$installer->startSetup();
//
//if (!$installer->getAttributeId(Mage_Catalog_Model_Product::ENTITY, 'buying_price')) {
//    $installer->addAttribute(Mage_Catalog_Model_Product::ENTITY, 'buying_price', array(             // TABLE.COLUMN:                                       DESCRIPTION:
//        'label'                      => 'Buying Price',                                             // eav_attribute.frontend_label                        admin input label
//        'group'                      => 'Prices',                                                   // (not a column)                                      tab in product edit screen
//        'sort_order'                 => 20,                                                         // eav_entity_attribute.sort_order                     sort order in group
//        'type'                       => 'decimal',                                                  // eav_attribute.backend_type                          backend storage type (varchar, text etc)
//        'note'                       => 'Buying Price for the Product',                             // eav_attribute.note                                  admin input note (shows below input)
//        'default'                    => null,                                                       // eav_attribute.default_value                         admin input default value
//        'input'                      => 'text',                                                     // eav_attribute.frontend_input                        admin input type (select, text, textarea etc)
//        'source'                     => 'sourcetype/attribute_source_type',                                                       // eav_attribute.source_model                          admin input source model (for selects) (module/class_name format)
//        'user_defined'               => true,                                                      // eav_attribute.is_user_defined                       editable in admin attributes section, false for not
//        'global'                     => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,    // catalog_eav_attribute.is_global                     (products only) scope
//        'visible'                    => true,                                                       // catalog_eav_attribute.is_visible                    (products only) visible on admin
//        'visible_on_front'           => true,                                                      // catalog_eav_attribute.is_visible_on_front           (products only) visible on frontend (store) attribute table
//        'used_in_product_listing'    => true,                                                      // catalog_eav_attribute.used_in_product_listing       (products only) made available in product listing
//        'searchable'                 => true,                                                      // catalog_eav_attribute.is_searchable                 (products only) searchable via basic search
//        'visible_in_advanced_search' => true,                                                      // catalog_eav_attribute.is_visible_in_advanced_search (products only) searchable via advanced search
//        'filterable'                 => true,                                                      // catalog_eav_attribute.is_filterable                 (products only) use in layered nav
//        'filterable_in_search'       => true,                                                      // catalog_eav_attribute.is_filterable_in_search       (products only) use in search results layered nav
//        'comparable'                 => true,                                                      // catalog_eav_attribute.is_comparable                 (products only) comparable on frontend
//        'apply_to'                   => 'simple,configurable',                                      // catalog_eav_attribute.apply_to                      (products only) which product types to apply to
//        'is_configurable'            => false,                                                      // catalog_eav_attribute.is_configurable               (products only) used for configurable products or not
//        'used_for_promo_rules'       => true,                                                       // catalog_eav_attribute.is_used_for_promo_rules       (products only) available for use in promo rules
//    ));
//}
//
//$eavConfig = Mage::getSingleton('eav/config');
//$installer->cleanCache();
//$attribute = $eavConfig->getAttribute('catalog_product', 'buying_price');
//$attribute->addData(array(
//    'is_visible' => 1
//));
//$attribute->save();

$installer->endSetup();

