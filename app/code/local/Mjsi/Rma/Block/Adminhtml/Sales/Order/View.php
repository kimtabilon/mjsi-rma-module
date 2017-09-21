<?php
class Mjsi_Rma_Block_Adminhtml_Sales_Order_View extends Mage_Adminhtml_Block_Sales_Order_View {
	
	public function __construct() {
		parent::__construct();
		$this->_addButton('create_rma', array(
					'label'     => Mage::helper('sales')->__('Create RMA'),
					'onclick'   => 'setLocation(\'' . $this->getUrl('rma/adminhtml_rma/createrma') . '\')',
					'class'     => 'add', // originally 'delete' -- possible: 'delete'/'cancel', 'edit', 'save', 'add', 'back'
            ), -200);
	}
}