<?php
class Mjsi_Rma_Block_Rma extends Mage_Core_Block_Template
{
	public function __construct()
    {
        parent::__construct();
        $this->setTemplate('rma/rma.phtml');

        Mage::app()->getFrontController()->getAction()->getLayout()->getBlock('root')->setHeaderTitle(Mage::helper('sales')->__('My RMA'));
    }
	
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
	
     public function getRma()     
     { 
        if (!$this->hasData('rma')) {
            $this->setData('rma', Mage::registry('rma'));
        }
        return $this->getData('rma');
        
    }
	
	public function getRmas()
    {
        $model = Mage::getModel('rma/rma');
        $collection = $model
                ->getCollection()
				->addFieldToFilter('customer_id', Mage::getSingleton('customer/session')->getCustomer()->getId())
				->addFieldToFilter('store_id', Mage::app()->getStore()->getStoreId())
                ->load();
 
        return $collection;
    }
	
	public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }
	
}