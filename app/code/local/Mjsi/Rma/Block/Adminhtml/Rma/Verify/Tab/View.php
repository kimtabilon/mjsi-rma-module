<?php 
class Mjsi_Rma_Block_Adminhtml_Rma_Verify_Tab_View
 extends Mage_Adminhtml_Block_Template
 implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
   
	protected $_rmadata;
	protected $_rmaitem;
	protected $_currentcustomer;
	protected $_rmaorder;
	
	public function getRmadata()
	{
		if (!$this->_rmadata) {
			$this->_rmadata = Mage::registry('rma_data');
		}
		return $this->_rmadata;
	}
	
	public function getRmaitem()
	{
		if (!$this->_rmaitem) {
			$this->_rmaitem = Mage::registry('rma_data_item');
		}
		return $this->_rmaitem;
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
	
	public function getInfoHtml()
    {
        return $this->getChildHtml('info');
    }
	
	public function getReasonHtml()
    {
        return $this->getChildHtml('reason');
    }
	
	public function getRemarksHtml()
    {
        return $this->getChildHtml('remarks');
    }
	
    public function getTabLabel()
    {
        return Mage::helper('rma')->__('Product Information');
    }

    public function getTabTitle()
    {
        return Mage::helper('rma')->__('Product Information');
    }
	
	public function canShowTab()
    {
        if (Mage::registry('rma_data_item')->getId()) {
            return true;
        }
        return false;
    }

    public function isHidden()
    {
        if (Mage::registry('rma_data_item')->getId()) {
            return false;
        }
        return true;
    }
}