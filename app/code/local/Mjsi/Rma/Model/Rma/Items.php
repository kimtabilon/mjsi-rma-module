<?php
class Mjsi_Rma_Model_Rma_Items extends Mage_Core_Model_Abstract
{
 
    protected $rma;
    protected $order_item;
	protected $rma_item;
    
    protected function _construct()
    {
        parent::_construct(); 
        $this->_init('rma/rma_items');
    }
	
    /**
    * @return mixed
    */
    public function getRma()
    {
        return $this->rma;
    }
    
    /**
    * @param mixed
    */
    public function setRma( $rma )
    {
        $this->rma = $rma;
		return $this;
    }
	
	public function setRmaItem ( $rma_item )
	{
		$this->rma_item = $rma_item;
		return $this;
	}
	
	public function getRmaItem ()
	{
		return $this->rma_item;
	}
    
    /**
    * @return mixed
    */
    public function getOrderItem()
    {
        if( isset( $this->order_item ) )
        {
            return $this->order_item;
        }
        $this->order_item = Mage::getModel( 'sales/order_item' )->load( $this->getItemId() );
        return $this->order_item;
    }
	
	    
    /**
    * @param mixed
    */
    public function setOrderItem( $order_item )
    {
        $this->order_item = $order_item;
        return $this;
    }
    
    protected function _beforeSave()
    {
        parent::_beforeSave();

        if (!$this->getRmaId()) {
            $this->setRmaId($this->getRma()->getId());
        }

        return $this;
    }
    
    public function getPrice()
    {
        return $this->getOrderItem()->getBasePrice();
    }           
    
    public function getQtyShipped()
    {
        return $this->getOrderItem()->getQtyShipped();
    }
    
    public function getQtyRefunded()
    {
        return $this->getOrderItem()->getQtyRefunded();
    }
	
	public function getItemStatus()
    {
        return $this->getRmaItem->getData( 'status' );
    }
    
    /**
    * @param mixed
    */
    public function setItemStatus( $status )
    {
        $this->setData( 'status', $status );
        return $this;
    }
	
	public static function getItemStatuses()
	{
		return array(
			'Waiting for Item',
			'Item Received',
			'Unverified - Working Item',
			'Unverified - Missing Parts',
			'Verified'
		);
	}
	
	public static function getPackageIncludes()
	{
		return array(
			'1' => 'Supplies',
			'2' => 'Installation CD',
			'3' => 'User\'s Guide',
			'4' => 'Toner Cartridges',
			'5' => 'Ink Cartridges',
			'6' => 'Power Cord',
			'7' => 'USB Cable',
			'8' => 'Poster'
		);
	}
}