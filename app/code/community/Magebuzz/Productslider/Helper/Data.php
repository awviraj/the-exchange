<?php

class Magebuzz_Productslider_Helper_Data extends Mage_Core_Helper_Abstract
{
	const XML_PATH_IMAGE_SLIDER_WIDTH 				=  'productslider/slider_setting/width_slider';
	const XML_PATH_IMAGE_SLIDER_HEIGHT				=  'productslider/slider_setting/height_slider';
	const XML_PATH_SLIDER_TYPE						=  'productslider/slider_setting/type_slider';
	const XML_PATH_SLIDER_POSITION 					=  'productslider/slider_setting/slider_position';
	
	const XML_PATH_PRODUCT_TYPE 					=  'productslider/product_setting/type_product';
	const XML_PATH_PRODUCT_FILTERED_CATEGORY		=  'productslider/product_setting/category_filter';
	const XML_PATH_NUMBER_PRODUCT_SHOW 				=  'productslider/product_setting/num_products';
	const XML_PATH_SHOW_PRODUCT_DESCRIPTION 		=  'productslider/product_setting/show_description';
	const XML_PATH_TITLE_PRODUCT_SLIDER 			=  'productslider/product_setting/title_of_slider';
	const XML_PATH_RELATED_ON_PRODUCTPAGE 			=  'productslider/product_setting/show_product_page';
	
	public function getImageSliderWidth(){
		return (int)Mage::getStoreConfig(self::XML_PATH_IMAGE_SLIDER_WIDTH);
	}
	
	public function isShowRelatedProduct(){
		return (int)Mage::getStoreConfig(self::XML_PATH_RELATED_ON_PRODUCTPAGE);
	}
	
	public function getImageSliderHeight(){
		return (int)Mage::getStoreConfig(self::XML_PATH_IMAGE_SLIDER_HEIGHT);
	}
	
	public function getSliderType (){
		return Mage::getStoreConfig(self::XML_PATH_SLIDER_TYPE);
	}
	
	public function getSliderPosition(){
		return Mage::getStoreConfig(self::XML_PATH_SLIDER_POSITION);
	}
	
	public function getProductTypeConfig(){
		return Mage::getStoreConfig(self::XML_PATH_PRODUCT_TYPE);
	}
	
	public function isFilteredProductCategory (){
		return Mage::getStoreConfig(self::XML_PATH_PRODUCT_FILTERED_CATEGORY);
	}
	
	public function getProductPerRow (){
		return (int)Mage::getStoreConfig(self::XML_PATH_NUMBER_PRODUCT_SHOW);
	}
	
	public function isShowProductDescription(){
		return Mage::getStoreConfig(self::XML_PATH_SHOW_PRODUCT_DESCRIPTION);
	}
	
	public function getTitleProductSlider(){
		return Mage::getStoreConfig(self::XML_PATH_TITLE_PRODUCT_SLIDER);
	}
}