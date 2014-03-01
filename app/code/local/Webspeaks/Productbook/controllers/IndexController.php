<?php
class Webspeaks_Productbook_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        $productId = Mage::app()->getRequest()->getParam('id');
        if (!empty($productId)) {
            $product = Mage::getModel('catalog/product')->load($productId);
            Mage::register('product', $product);
        } else {
            $this->_forward('defaultNoRoute');
        }
        $this->loadLayout();
        $html =  $this->getLayout()->getBlock('content')->toHtml();//->setTemplate('productbook/productbook.phtml')->toHtml();
        $this->getResponse()->setBody($html);
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