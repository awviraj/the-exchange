<?php

class Webspeaks_Productbook_Block_Adminhtml_Productbook_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('productbookGrid');
      $this->setDefaultSort('productbook_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('productbook/productbook')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('productbook_id', array(
          'header'    => Mage::helper('productbook')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'productbook_id',
      ));

      $this->addColumn('title', array(
          'header'    => Mage::helper('productbook')->__('Title'),
          'align'     =>'left',
          'index'     => 'title',
      ));

	  /*
      $this->addColumn('content', array(
			'header'    => Mage::helper('productbook')->__('Item Content'),
			'width'     => '150px',
			'index'     => 'content',
      ));
	  */

      $this->addColumn('status', array(
          'header'    => Mage::helper('productbook')->__('Status'),
          'align'     => 'left',
          'width'     => '80px',
          'index'     => 'status',
          'type'      => 'options',
          'options'   => array(
              1 => 'Enabled',
              2 => 'Disabled',
          ),
      ));
	  
        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('productbook')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('productbook')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));
		
		$this->addExportType('*/*/exportCsv', Mage::helper('productbook')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('productbook')->__('XML'));
	  
      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('productbook_id');
        $this->getMassactionBlock()->setFormFieldName('productbook');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('productbook')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('productbook')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('productbook/status')->getOptionArray();

        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
             'label'=> Mage::helper('productbook')->__('Change status'),
             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('productbook')->__('Status'),
                         'values' => $statuses
                     )
             )
        ));
        return $this;
    }

  public function getRowUrl($row)
  {
      return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }

}