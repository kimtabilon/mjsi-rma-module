<?php
class Mjsi_Rma_Model_Rma extends Mage_Core_Model_Abstract
{
    protected $_items;
	protected $_emails;
    protected $order;
    protected $customer;
    
    protected function _construct()
    {
        parent::_construct(); 
        $this->_init('rma/rma');
        $this->setStatus( '1' );
	}
    
    public function addItem( Mjsi_Rma_Model_Rma_Items $item )
    {
		$item->setRma( $this );
		if( !$item->getId() )
        {
		    $this->getItemsCollection()->addItem( $item );
		}
		return $this;
    }
    
    public function getItemsCollection($filterByTypes = array(), $nonChildrenOnly = false)
    {
		if (is_null($this->_items)) {
		    $this->_items = Mage::getResourceModel('rma/rma_items_collection')
                ->setRmaFilter($this->getId());
			if ($filterByTypes) {
		        $this->_items->filterByTypes($filterByTypes);
            }
            if ($nonChildrenOnly) {
		        $this->_items->filterByParent();
            }

            if ($this->getId()) {
		        foreach ($this->_items as $item) {
                    $item->setOrder($this);
                }
            }
        }
		return $this->_items;
    }
	
	public function getEmailsCollection($filterByTypes = array(), $nonChildrenOnly = false)
    {
		if (is_null($this->_emails)) {
		    $this->_emails = Mage::getResourceModel('rma/rma_emails_collection')
                ->setRmaFilter($this->getId());
			if ($filterByTypes) {
		        $this->_emails->filterByTypes($filterByTypes);
            }
            if ($nonChildrenOnly) {
		        $this->_emails->filterByParent();
            }
        }
		return $this->_emails;
    }
    
    protected function _beforeSave()
    {
		parent::_beforeSave();
		
		if (!$this->getDateCreated()){
			$this->setDateCreated(date("c"));
		}
        if (!$this->getOrderId()) {
            $this->setOrderId($this->getOrder()->getId());//throwing an error
        }
		if (!$this->getOrderNumber()) {
			$this->setOrderNumber($this->getOrder()->getIncrementId());
		}

    }
    
    protected function _afterSave()
    {
		parent::_afterSave();
        
        $transactionSave = Mage::getModel('core/resource_transaction');
        foreach( $this->getItemsCollection() as $item )
        {
            $transactionSave->addObject( $item );
        }
        $transactionSave->save();

        return $this;
    }

    protected function _beforeDelete()
    {
        parent::_beforeDelete();
        foreach( $this->getItemsCollection() as $item )
        {
            $item->delete();
        }
    }
    
    /**
    * @return mixed
    */
    public function getOrder()
    {
        return $this->order;
    }
    
    /**
    * @param mixed
    */
    public function setOrder( $order )
    {
        $this->order = $order;
        return $this;
    }
    
    public function getCustomer()
    {
        if( isset( $this->customer ))
        {
            return $this->customer;
        }
        $this->customer = Mage::getModel( 'customer/customer' )->load( $this->getCustomerId() );
        return $this->customer;
    }       
    
    public function getCustomerInfo()
    	{
		$RMA_id = $this->getId();
		$thisRMA = Mage::getModel('rma/rma')->load($RMA_id);
		$thisOrderId = $thisRMA->getOrderId();
		$thisCustomerName = $thisRMA['customer_name'];
		$thisCustomerEmail = $thisRMA['customer_email'];
		
		if($thisCustomerName == "Guest") {$thisCustomerName = "<i>(" . $thisCustomerName . ")</i>";}
		
		$toReturn = $thisCustomerName . "<br><span style=\"font-size: 10px;\">(" . $thisCustomerEmail . ")</span>";
		return $toReturn;
   	 }
	
	public function getRMANum()
		{
		$toReturn = "<i>-not filed-</i>";
		
		if($this->getRmaNumber()) {$toReturn = $this->getRmaNumber();}
		
		return $toReturn;
		}
	
	public function getRMAFiledOn()
		{
		$toReturn = "";
		
		$unparsedDateCreated = $this->getDateCreated();
		$timeCreated = strtotime($unparsedDateCreated) - (8 * 60 * 60);
		
		$dateCreated = date("M j, Y", $timeCreated) . "<br>" . date("g:i:s a", $timeCreated);
		
		$toReturn = $dateCreated;
		return $toReturn;
		}
	
	public function getLastUpdated()
		{
		$toReturn = "";
		
		$unparsedDateCreated = $this->getDateLastupdated();
		$timeCreated = strtotime($unparsedDateCreated) - (8 * 60 * 60);
		
		$dateCreated = date("M j, Y", $timeCreated) . "<br>" . date("g:i:s a", $timeCreated);
		
		$toReturn = $dateCreated;
		return $toReturn;
		}
	
	public function getStoreName()
		{
		$toReturn = "<i>-no store name-</i>";
		
		$store_id = $this->getStoreId();
		$store_model = Mage::getModel('core/store_group')->load($store_id);
		$store_name = $store_model->getName();
		if($store_name != "")
			{
			$toReturn = $store_name;
			}
		
		return $toReturn;
		}
    
	public function getCustomerName()
	{
		return $this->getCustomer()->getFirstname() . " " . $this->getCustomer()->getLastname();
	}
    
    public function getCustomerEmail()
		{
		return $this->getCustomer()->getEmail();
		}
		
    public function setCustomer( Mage_Customer_Model_Customer $customer )
    {
        $this->setData( 'customer_id' , $customer->getId() );
        $this->customer = $customer;
    }
    
	public function getItemCount()
		{
		$itemCount = 0;
		
		$RMA_id = $this->getId();
		
		$all_rmas = Mage::getResourceModel('rma/rma_items_collection');
		$all_rmas->addFieldToFilter('rma_id', $RMA_id);
		
		$allData = $all_rmas->getData();
		
		//Mage::log($allData);
		
		foreach($allData as $thisRMA=>$theseDetails)
			{
			$itemCount += $theseDetails["qty"];
			//Mage::log("Item " . $theseDetails["item_id"] . " quantity is " . $theseDetails["qty"]);
			}
		
		if(!$itemCount){$itemCount="<span style=\"font-weight: bold; color:#f00;\">0</span>";}
		
		//$itemcount = this->getItemsCollection()->count();
		
		return $itemCount;
		}
    
    public function getTotalAmount()
    {
        $amount = 0;
        foreach( $this->getItemsCollection() as $item )
        {
            $amount += $item->getOrderItem()->getBasePrice();
        }
		
		//$toRet = '$' . number_format( $amount, 2 );
		$toRet = Mage::helper('core')->currency($amount, true, false);
        return $toRet;
    }
    
    /**
    * @return mixed
    */
    public function getStatus()
    {
		$statuses = Mage::getSingleton('rma/status')->getOptionArray();
		return $statuses[$this->getData('status')];
    }
    
    /**
    * @param mixed
    */
    public function setStatus( $status )
    {
        $this->setData( 'status', $status );
        return $this;
    }
    
    public static function getStatuses()
    {
        return array(
            'Pending',
			'RMA Received',
			'Shipping Label Emailed',
            'Shipment Received',
			'Shipment Contents Unverified',
            'Shipment Contents Verified',
            'Refund Processed',
			'Request RMA Cancellation',
			'Cancelled',
			'Closed',
            'Invalid'
        );
    }
}