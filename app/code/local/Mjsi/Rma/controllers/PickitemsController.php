<?php
class Mjsi_Rma_PickitemsController extends Mage_Core_Controller_Front_Action
{
    protected $order;
	
	public function preDispatch()
    {
        parent::preDispatch();
        $action = $this->getRequest()->getActionName();
        $loginUrl = Mage::helper('customer')->getLoginUrl();

        if (!Mage::getSingleton('customer/session')->authenticate($this, $loginUrl)) {
            $this->setFlag('', self::FLAG_NO_DISPATCH, true);
        }
    }

    public function indexAction()
    {
        $order_id = $this->getRequest()->get( 'order_id' );
        $this->order = Mage::getModel( 'sales/order' )->load( $order_id );
        Mage::register( 'rma_order', $this->order ); 
        
        if( is_array( $this->getRequest()->get( 'items' ) ) )
        {
            $rma = $this->createRma();
            $this->_saveRma( $rma );
            $this->_redirect( 'rma/done' );
        }
        
        $this->loadLayout();
        $this->_initLayoutMessages('customer/session');
        $this->renderLayout();

    }
    
    protected function createRma()
    {
        $rma = Mage::getModel( 'rma/rma' ); 
        $rma->setOrder( $this->order );
        $rma->setCustomer( $customer = $this->_getSession()->getCustomer()  );
        $items = $this->getRequest()->get( 'items' );
		  
			$rma->setStoreId( Mage::app()->getStore()->getStoreId() );
			
			$order_id = $this->getRequest()->get( 'orderID' );
			$order_model = Mage::getModel('sales/order')->load($order_id);
			
			$thisRMA_customer_firstName = $order_model->getCustomerFirstname();
			$thisRMA_customer_lastName = $order_model->getCustomerLastname();
			$thisRMA_customer_name = $thisRMA_customer_firstName . " " . $thisRMA_customer_lastName;
			$thisRMA_customer_email = $order_model->getCustomerEmail();
			
			$thisRMA_customer_isguest = $order_model->getCustomerIsGuest();
			
			if( ($thisRMA_customer_isguest == "1") && ($thisRMA_customer_name == " ") ) {$thisRMA_customer_name = "Guest";}
			
			$rma->setCustomerName( $thisRMA_customer_name );
			$rma->setCustomerEmail( $thisRMA_customer_email );
			
        foreach( $items as $orderItem )
        {
		   $rmaItem = Mage::getModel( 'rma/rma_items' );
            $rmaItem->setItemId( $orderItem );
            $rmaItem->setQty( $this->getRequest()->get( 'quantity_' . $orderItem ) );
			$rmaItem->setSerialNumber( $this->getRequest()->get( 'serial_' . $orderItem ) );
			$rmaItem->setReason ( $this->getRequest()->get('reason_' . $orderItem ) );
			$rmaItem->setType ( $this->getRequest()->get('type1_' . $orderItem ) );
			$rmaItem->setStatus ( 'Waiting for Item' ) ;
			$rma->addItem( $rmaItem );
        }
        return $rma;
    }   
    
    protected function _saveRma( $rma )
    {
        $transactionSave = Mage::getModel('core/resource_transaction')
            ->addObject( $rma );
        $transactionSave->save();

        return $this;
    }
   
   /**
     * Retrieve customer session model object
     *
     * @return Mage_Customer_Model_Session
     */
    protected function _getSession()
    {
        return Mage::getSingleton('customer/session');
    }
}
?>