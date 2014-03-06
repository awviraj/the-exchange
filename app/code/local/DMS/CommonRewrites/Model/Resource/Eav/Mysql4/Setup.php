<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Dilhan
 * Date: 3/6/14
 * Time: 10:41 PM
 * To change this template use File | Settings | File Templates.
 */

class DMS_CommonRewrites_Model_Resource_Eav_Mysql4_Setup extends Mage_Eav_Model_Entity_Setup
{

    /**
     * @return array
     */
    public function getDefaultEntities()
    {
        return array(
            'catalog_product' => array(
                'entity_model'      => 'catalog/product',
                'attribute_model'   => 'catalog/resource_eav_attribute',
                'table'             => 'catalog/product',
                'additional_attribute_table' => 'catalog/eav_attribute',
                'entity_attribute_collection' => 'catalog/product_attribute_collection',
                'attributes'        => array(
                    'buying_price' => array(
                        'group'             => 'Prices',
                        'label'             => 'Buying Price',
                        'type'              => 'dec',
                        'input'             => 'text',
                        'default'           => '0',
                        'class'             => '',
                        'backend'           => '',
                        'frontend'          => '',
                        'source'            => '',
                        'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
                        'visible'           => true,
                        'required'          => false,
                        'user_defined'      => true,
                        'searchable'        => true,
                        'filterable'        => true,
                        'comparable'        => true,
                        'visible_on_front'  => true,
                        'visible_in_advanced_search' => true,
                        'unique'            => false,
                        'used_in_product_listing'    => true,                                                      // catalog_eav_attribute.used_in_product_listing       (products only) made available in product listing
                    ),
               )
        )
      );
    }
}