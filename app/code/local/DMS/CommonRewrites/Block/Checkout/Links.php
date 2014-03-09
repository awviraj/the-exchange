<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Dilhan
 * Date: 3/9/14
 * Time: 10:34 PM
 * To change this template use File | Settings | File Templates.
 */
class DMS_CommonRewrites_Block_Checkout_Links extends Mage_Checkout_Block_Links
{
    public function addCartLink () {
        $parentBlock = $this->getParentBlock();
        if ($parentBlock && Mage::helper('core')->isModuleOutputEnabled('Mage_Checkout')) {
            $count = $this->getSummaryQty() ? $this->getSummaryQty()
                : $this->helper('checkout/cart')->getSummaryCount();
            if ($count == 1) {
                $text = $this->__("<span class='cart-count'>%s</span>", $count);
            } elseif ($count > 0) {
                $text = $this->__("<span class='cart-count'>%s</span>", $count);
            } else {
                $text = $this->__("<span class='cart-count'>0</span>");
            }

            $parentBlock->removeLinkByUrl($this->getUrl('checkout/cart'));
            $parentBlock->addLink($text, 'checkout/cart', 'My Cart', true, array(), 50, null, 'class="top-link-cart"');
        }
        return $this;
    }
}