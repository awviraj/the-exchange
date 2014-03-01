<?php
class Webspeaks_Productbook_Block_Productbook extends Mage_Catalog_Block_Product_View
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getProductbook()     
     { 
        if (!$this->hasData('productbook')) {
            $this->setData('productbook', Mage::registry('productbook'));
        }
        return $this->getData('productbook');
        
    }
}