<?php
class Mjsi_Rma_Block_Adminhtml_Rma_Createrma_Tab_View_Items extends Mage_Core_Block_Template
{
	protected $_rmaitems;
	protected $_rmaorder;
	
	public function getOrderdata()
	{
		if (!$this->_rmaorder){
			$this->_rmaorder = Mage::registry('rma_order');
		}
		return $this->_rmaorder;
	}
	
	public function getOrderItems()
	{
		if (!$this->_rmaorder){
			$this->_rmaorder = Mage::registry('rma_order');
		}
		$this->_rmaitems = $this->_rmaorder->getItemsCollection();
		return $this->_rmaitems;
	}
	
	public function getRmaItemDetail(Mjsi_Rma_Model_Rma_Items $prodId ) 
	{
		$product = Mage::getModel ('catalog/product')->load($prodId->getItemId());
		return $product;
	}
	
	public function __construct()
    {
        parent::__construct();
    }

    public function _beforeToHtml()
    {
	}

}