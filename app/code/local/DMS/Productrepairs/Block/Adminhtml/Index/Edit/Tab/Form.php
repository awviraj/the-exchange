<?php
class DMS_Productrepairs_Block_Adminhtml_Index_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('brand_form',
            array('legend'=>'Brand Information'));
        $fieldset->addField('brand_id', 'text',
            array(
                'label' => 'Brand Id',
                'class' => 'required-entry',
                'required' => true,
                'name' => 'brand_id',
            ));
        $fieldset->addField('name', 'text',
            array(
                'label' => 'Name',
                'class' => 'required-entry',
                'required' => true,
                'name' => 'name',
            ));
        $fieldset->addField('type', 'text',
            array(
                'label' => 'Type',
                'class' => 'required-entry',
                'required' => true,
                'name' => 'type',
            ));
        $fieldset->addField('sort_order', 'text',
            array(
                'label' => 'Sort Order',
                'class' => 'required-entry',
                'required' => true,
                'name' => 'sort_order',
            ));



        if ( Mage::registry('brand') )
        {
            $form->setValues(Mage::registry('brand')->getData());
        }
        return parent::_prepareForm();
    }
}