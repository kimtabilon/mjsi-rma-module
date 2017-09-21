<?php 
class Mjsi_Rma_Block_Adminhtml_Rma_Createrma_Tab_View
 extends Mage_Adminhtml_Block_Template
 implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
	protected $_rmadata;
	protected $_currentcustomer;
	protected $_rmaorder;
	
	public function getOrderdata()
	{
		if (!$this->_rmaorder){
			$this->_rmaorder = Mage::registry('rma_order');
		}
		return $this->_rmaorder;
	}
	
	public function getRmadata()
	{
		if (!$this->_rmadata) {
			$this->_rmadata = Mage::registry('rma_data');
		}
		return $this->_rmadata;
	}
	
	public function getRmaCustomer()
	{
		if (!$this->_rmadata) {
			$this->_rmadata = Mage::registry('rma_data');
		}
		$customerId = $this->_rmadata->getCustomerId();
		$this->_currentcustomer = Mage::getModel('customer/customer')->load($customerId);
		
		return $this->_currentcustomer;
	}
	
	public function getCustomerViewUrl()
    {
		if (!$this->_rmadata) {
			$this->_rmadata = Mage::registry('rma_data');
		}
		$customerId = $this->_rmadata->getCustomerId();
		
        if ($this->getOrder()->getCustomerIsGuest()) {
            return false;
        }
        return $this->getUrl('*/customer/edit', array('id' => $customerId ));
    }
	
	
	public function getFormHtml()
    {
        return $this->getChildHtml('form');
    }
	
	public function getItemsHtml()
    {
        return $this->getChildHtml('items');
    }
	
	public function getRemarksHtml()
    {
        return $this->getChildHtml('remarks');
    }
	
    public function getTabLabel()
    {
        return Mage::helper('rma')->__('Order Information');
    }

    public function getTabTitle()
    {
        return Mage::helper('rma')->__('Order Information');
    }
	
	public function canShowTab()
    {
        if (Mage::registry('rma_order')->getId()) {
            return true;
        }
        return false;
    }

    public function isHidden()
    {
        if (Mage::registry('rma_order')->getId()) {
            return false;
        }
        return true;
    }
}
