<?php

class Mjsi_Rma_Block_Adminhtml_Rma_Grid extends Mage_Adminhtml_Block_Widget_Grid
	{
	
	public function __construct()
		{
		parent::__construct();
		$this->setId('rmaGrid');
		$this->setDefaultSort('date_created');
		$this->setDefaultDir('DESC');
		}
	
	protected function _prepareCollection()
		{
		$collection = Mage::getModel('rma/rma')->getCollection();
		$this->setCollection($collection);
		return parent::_prepareCollection();
		}
  
	protected function _prepareColumns()
		{
		$this->addColumn('order_number', array(
			'header'        => Mage::helper('rma')->__('Order #'),
			'align'         => 'left',
			'index'         => 'order_number',
			'type'          => 'text',
			'escape'        => false,
		));
		
		$this->addColumn('rma_number', array(
			'header'        => Mage::helper('rma')->__('RMA #'),
			'align'         => 'left',
			'index'         => 'rma_number',
			'type'          => 'text',
			'escape'        => false,
			'getter'        => 'getRMANum',
		));
		
		$this->addColumn('date_created', array(
			'header'        => Mage::helper('rma')->__('RMA Created'),
			'align'         => 'left',
			'index'         => 'date_created',
			'type' 			 => 'datetime',
			'escape'        => false,
		));
		
		if (!Mage::app()->isSingleStoreMode()) {
			$this->addColumn('store_id', array(
				'header'     => Mage::helper('rma')->__('Purchased From'),
				'align'      => 'left',
				'index'      => 'store_id',
				'type'       => 'store',
				'store_view' => true,
				'display_deleted' => false,
			));
		}
		
		$this->addColumn('customer_email', array(
			'header'        => Mage::helper('rma')->__('Customer Email'),
			'align'         => 'left',
			'index'         => 'customer_email',
			'type'          => 'text',
			'escape'        => false,
			'sortable'   	 => false,
			'getter'        => 'getCustomerInfo',
		));
		
		$this->addColumn('itemcount', array(
			'header'        => Mage::helper('rma')->__('# of RMA\'d Items'),
			'width'         => '1px', 
			'align'         => 'center',
			'index'         => 'rma_id',
			'sortable'   	 => false,
			'filter'    	 => false,
			'type'          => 'text',
			'getter'        => 'getItemCount',
		));
		
		$this->addColumn('totalamount', array(
			'header'        => Mage::helper('rma')->__('Total Amount'),
			'align'         => 'left',
			'index'         => 'totalamount',
			'type'			 => 'text',
			'filter'    	 => false,
			'getter'        => 'getTotalAmount'
		));
		
		$statuses = Mage::getSingleton('rma/status')->getOptionArray();
		
		$this->addColumn('status', array(
			'header'        => Mage::helper('rma')->__('RMA Status'),
			'align'         => 'left',
			'index'			 => 'status',
			'type'			 => 'options',
			'options'   => array(
				1 => 'Pending',
				2 => 'RMA Received',
				3 => 'Shipment Received',
				4 => 'Shipment Contents Unverified',
				5 => 'Shipment Contents Verified',
				6 => 'Refund Processed',
				7 => 'Cancelled',
				8 => 'Closed',
				9 => 'Invalid RMA',
				),
		));
		
		$this->addColumn('date_lastupdated', array(
			'header'        => Mage::helper('rma')->__('Last Updated'),
			'align'         => 'left',
			'index'         => 'date_lastupdated',
			'type' 			 => 'datetime',
		));
		
		$this->addColumn('action', array(
			'header'    =>  Mage::helper('rma')->__('Action'),
			'type'      => 'action',
			'getter'    => 'getId',
			'actions'   => array(array(
				'caption'   => Mage::helper('rma')->__('Edit'),
				'url'       => array('base'=> '*/*/edit'),
				'field'     => 'id'
			)),
			'filter'    => false,
			'sortable'  => false,
			'index'     => 'stores',
			'is_system' => true,
		));
		
		/*
		$this->addColumn('rma_id', array(
			'header'        => Mage::helper('rma')->__('ID'),
			'align'         => 'right',
			'width'         => '50px',
			//'filter_index'  => 'dt.rma_id',
			'index'         => 'rma_id',
		));
		
		$this->addColumn('order_id', array(
			'header'        => Mage::helper('rma')->__('Order ID'),
			'align'         => 'left',
			//'filter_index'  => 'dt.order_id',
			'index'         => 'order_id',
			'type'          => 'text',
			'escape'        => false,
		));
		*/
		
		$this->addExportType('*/*/exportCsv', Mage::helper('rma')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('rma')->__('XML'));
		
		return parent::_prepareColumns();
		}
	
	protected function _prepareMassaction()
		{
		$this->setMassactionIdField('rma_id');
		$this->getMassactionBlock()->setFormFieldName('rma');
		
		$this->getMassactionBlock()->addItem('delete', array(
		'label'    => Mage::helper('rma')->__('Delete'),
		'url'      => $this->getUrl('*/*/massDelete'),
		'confirm'  => Mage::helper('rma')->__('Are you sure you want to delete one or more RMAs? WARNING: This cannot be undone!')
		));
		
		$statuses = Mage::getSingleton('rma/status')->getOptionArray();
		
		array_unshift($statuses, array('label'=>'', 'value'=>''));
		$this->getMassactionBlock()->addItem('status', array(
			'label'=> Mage::helper('rma')->__('Change status'),
			'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
			'additional' => array(
				'visibility' => array(
					'name' => 'status',
					'type' => 'select',
					'class' => 'required-entry',
					'label' => Mage::helper('rma')->__('Status'),
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