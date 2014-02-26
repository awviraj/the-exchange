<?php
class Webspeaks_Productbook_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	
    	/*
    	 * Load an object by id 
    	 * Request looking like:
    	 * http://site.com/productbook?id=15 
    	 *  or
    	 * http://site.com/productbook/id/15 	
    	 */
    	/* 
		$productbook_id = $this->getRequest()->getParam('id');

  		if($productbook_id != null && $productbook_id != '')	{
			$productbook = Mage::getModel('productbook/productbook')->load($productbook_id)->getData();
		} else {
			$productbook = null;
		}	
		*/
		
		 /*
    	 * If no param we load a the last created item
    	 */ 
    	/*
    	if($productbook == null) {
			$resource = Mage::getSingleton('core/resource');
			$read= $resource->getConnection('core_read');
			$productbookTable = $resource->getTableName('productbook');
			
			$select = $read->select()
			   ->from($productbookTable,array('productbook_id','title','content','status'))
			   ->where('status',1)
			   ->order('created_time DESC') ;
			   
			$productbook = $read->fetchRow($select);
		}
		Mage::register('productbook', $productbook);
		*/

		echo $this->getLayout()->createBlock('productbook/productbook')->setTemplate('productbook/productbook.phtml')->toHtml();  
		
		// $this->loadLayout();     
		// $this->renderLayout();
    }
	
	public function cartinfoAction()
	{
		if(Mage::getSingleton('customer/session')->isLoggedIn())
		{
			$quote = Mage::getModel('checkout/session')->getQuote();
			$total = $quote->getGrandTotal();
			// print_r(get_class_methods(Mage::helper('checkout/cart')->getCart()));
			echo 'Items in cart: <b>'. Mage::helper('checkout/cart')->getCart()->getSummaryQty().'</b>&nbsp;&nbsp;&nbsp;&nbsp;<br />Cart total: <b>'.Mage::helper('checkout')->formatPrice($total).'</b>';
		}
		else
		{
			echo "Please login to view cart details.";
		}
	}
}