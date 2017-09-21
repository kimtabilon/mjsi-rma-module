<?php 
class Mjsi_Rma_Block_Adminhtml_Rma_Edit_Tab_Email
 extends Mage_Adminhtml_Block_Template
 implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
	protected $_rmadata;
	protected $_rmaemails;
	protected $_currentcustomer;
	protected $_rmaorder;
	
	protected function _prepareLayout()
    {
        //$onclick = "submitAndReloadArea($('rma_edit'), '".$this->getSubmitUrl()."')";
		//$onclick = "submit($('rma_item_container'), '".$this->getSubmitUrl()."')";
        $button = $this->getLayout()->createBlock('adminhtml/widget_button')
            ->setData(array(
                'label'   => Mage::helper('sales')->__('Send Email'),
                'class'   => 'save',
                'onclick' => "submit()",
            ));
			
        $this->setChild('submit_button', $button);
        return parent::_prepareLayout();
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
	
	public function getRmaEmails()
	{
		if (!$this->_rmadata) {
			$this->_rmadata = Mage::registry('rma_data');
		}
		$this->_rmaemails = $this->_rmadata->getEmailsCollection();
		return $this->_rmaemails;
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
	
	public function getOrder()
	{
		if (!$this->_rmadata) {
			$this->_rmadata = Mage::registry('rma_data');
		}
		$orderid = $this->_rmadata->getOrderId();
		$this->_rmaorder = Mage::getModel('sales/order')->load($orderid);
		
		return $this->_rmaorder;
	}
	
	public function getSampleHtml()
    {
        return $this->getChildHtml('sample');
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
        return Mage::helper('rma')->__('RMA Emails');
    }

    public function getTabTitle()
    {
        return Mage::helper('rma')->__('RMA Emails');
    }
	
	public function canShowTab()
    {
        if (Mage::registry('rma_data')->getId()) {
            return true;
        }
        return false;
    }

    public function isHidden()
    {
        if (Mage::registry('rma_data')->getId()) {
            return false;
        }
        return true;
    }
	
	public function getSubmitUrl()
    {
        return $this->getUrl('*/*/sendemail', array('id' => $this->getRequest()->getParam('id') ));
    }
}
