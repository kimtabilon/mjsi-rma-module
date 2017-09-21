<?php
class Mjsi_Rma_Block_Adminhtml_Rma_Edit_Tab_View_Items extends Mage_Core_Block_Template
{
	protected $_rmadata;
	protected $_rmaitems;
	protected $_rmaorder;
	
	public function getRmadata()
	{
		if (!$this->_rmadata) {
			$this->_rmadata = Mage::registry('rma_data');
		}
		return $this->_rmadata;
	}
	
	public function getRmaItems()
	{
		if (!$this->_rmadata) {
			$this->_rmadata = Mage::registry('rma_data');
		}
		$this->_rmaitems = $this->_rmadata->getItemsCollection();
		return $this->_rmaitems;
	}
	
	public function getRmaItemDetail(Mjsi_Rma_Model_Rma_Items $prodId ) 
	{
		$products = Mage::getModel ('catalog/product')->load($prodId->getItemId());
		$this->_rmaorder = Mage::getModel('sales/order')->load($this->_rmadata->getOrderId());
		$product = false;
		
		$items = $this->_rmaorder->getAllItems();
		foreach ($items as $itemId => $item)
		{
			if ($item->getProductId() == $prodId->getItemId()) {
				$product = $item;
			}
		}
		
		if ($product)
			return $product;
		else
			return 0;
	}
	
	public function getVerifyUrl(Mjsi_Rma_Model_Rma_Items $prodId) 
	{
		return Mage::helper('adminhtml')->getUrl('*/*/verify', array('id' => $this->_rmadata->getId(),'item_id' => $prodId->getRmaItemsId() )); 
	}
	
	public function __construct()
    {
        parent::__construct();
    }

    public function _beforeToHtml()
    {
	}

}