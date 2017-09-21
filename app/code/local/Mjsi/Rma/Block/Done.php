<?php
class Mjsi_Rma_Block_Done extends Mage_Core_Block_Template
{
	public function __construct()
    {
        parent::__construct();
        $this->setTemplate('rma/done.phtml');

        Mage::app()->getFrontController()->getAction()->getLayout()->getBlock('root')->setHeaderTitle(Mage::helper('rma')->__('Your RMA has been successfully submitted. '));
    }
	
}