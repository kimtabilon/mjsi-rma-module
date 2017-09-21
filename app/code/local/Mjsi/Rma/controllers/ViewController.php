<?php
class Mjsi_Rma_ViewController extends Mage_Core_Controller_Front_Action
{
	
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
		$rma_id = $this->getRequest()->getParam( 'id' );
        $rma = Mage::getModel( 'rma/rma' )->load( $rma_id );
		Mage::register( 'rmaview', $rma ); 
		
		$this->loadLayout();
        $this->_initLayoutMessages('customer/session');
		$this->renderLayout();
		
    }  
}