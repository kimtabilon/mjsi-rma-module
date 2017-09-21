<?php
class Mjsi_Rma_Block_Adminhtml_Rma extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_rma';
    $this->_blockGroup = 'rma';
    $this->_headerText = Mage::helper('rma')->__('RMA Manager');
    $this->_addButtonLabel = Mage::helper('rma')->__('Add New RMA');
    parent::__construct();
	$this->_removeButton('add');
  }
}