<?php
class DMS_Productrepairs_Block_Adminhtml_Index_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('brandsGrid');
        $this->setDefaultSort('brand_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
    }
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('dms_productrepairs/brand')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
    protected function _prepareColumns()
    {
        $this->addColumn('brand_id',
            array(
                'header' => 'ID',
                'align' =>'right',
                'width' => '50px',
                'index' => 'brand_id',
            ));
        $this->addColumn('name',
            array(
                'header' => 'Name',
                'align' =>'left',
                'index' => 'name',
            ));
        $this->addColumn('type', array(
            'header' => 'Type',
            'align' =>'left',
            'index' => 'type',
        ));
        $this->addColumn('sort_order', array(
            'header' => 'Sort Order',
            'align' =>'left',
            'index' => 'sort_order',
        ));
        return parent::_prepareColumns();
    }
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }
}