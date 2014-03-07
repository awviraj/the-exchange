<?php
/**
 * @category    Mage
 * @package     Mage_Catalog
 * @copyright   Copyright (c) 2013 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
$installer = Mage::getResourceModel('catalog/setup','core_setup');
$installer->startSetup();
$installer->removeAttribute('catalog_product','buying_price');

$installer->addAttribute('catalog_product', 'buying_price', array(
    'type'              => 'decimal',
    'group'             => 'Prices',
    'input'             => 'price',
    'backend'            => 'catalog/product_attribute_backend_price',
    'frontend'          => '',
    'source'            => '',
    'label'             => 'Buying Price',
    'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_WEBSITE,
    'required'          => '0',
    'user_defined'      => '1',
    'searchable'        => '1',
    'filterable'        => '1',
    'comparable'        => '1',
    'apply_to' => implode(',',
        array(
            Mage_Catalog_Model_Product_Type::TYPE_SIMPLE,
            Mage_Catalog_Model_Product_Type::TYPE_CONFIGURABLE
        )
    ),
    'visible_on_front'  => '1',
    'visible_in_advanced_search' => '1',
    'unique'            => '0',
    'used_in_product_listing'    => '1',
));

$installer->removeAttribute('catalog_product','product_specifications');
$installer->addAttribute('catalog_product', 'product_specifications', array(
    'type'              => 'text',
    'group'             => 'General',
    'input'             => 'textarea',
    'backend'            => '',
    'frontend'          => '',
    'source'            => '',
    'label'             => 'Product Specifications',
    'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_WEBSITE,
    'required'          => '0',
    'user_defined'      => '1',
    'searchable'        => '0',
    'filterable'        => '0',
    'comparable'        => '0',
    'apply_to' => implode(',',
        array(
            Mage_Catalog_Model_Product_Type::TYPE_SIMPLE,
            Mage_Catalog_Model_Product_Type::TYPE_CONFIGURABLE
        )
    ),
    'visible_on_front'  => '1',
    'visible_in_advanced_search' => '1',
    'unique'            => '0',
    'used_in_product_listing'    => '1',
    'is_wysiwyg_enabled' => '1',
    'is_html_allowed_on_front' => '1',
    'sort_order'                 => 5
));

$installer->updateAttribute('catalog_product', 'product_specifications', 'is_wysiwyg_enabled', 1);
$installer->updateAttribute('catalog_product', 'product_specifications', 'is_html_allowed_on_front', 1);

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

