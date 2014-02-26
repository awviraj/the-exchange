<?php
class Webspeaks_Productbook_Block_Productbook extends Mage_Core_Block_Template
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