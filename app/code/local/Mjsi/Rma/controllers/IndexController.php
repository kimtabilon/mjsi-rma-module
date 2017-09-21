<?php
class Mjsi_Rma_IndexController extends Mage_Core_Controller_Front_Action
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
    	
    	/*
    	 * Load an object by id 
    	 * Request looking like:
    	 * http://site.com/rma?id=15 
    	 *  or
    	 * http://site.com/rma/id/15 	
    	 */
    	/* 
		$rma_id = $this->getRequest()->getParam('id');

  		if($rma_id != null && $rma_id != '')	{
			$rma = Mage::getModel('rma/rma')->load($rma_id)->getData();
		} else {
			$rma = null;
		}	
		*/
		
		 /*
    	 * If no param we load a the last created item
    	 */ 
    	
    	/*if($rma == null) {
			$resource = Mage::getSingleton('core/resource');
			$read= $resource->getConnection('core_read');
			$rmaTable = $resource->getTableName('rma');
			
			$select = $read->select()
			   ->from($rmaTable,array('rma_number','remarks','status'))
			   //->where('status',1)
			   ->order('date_created DESC') ;
			   
			$rma = $read->fetchRow($select);
		}
		Mage::register('rma', $rma);
		*/		

			
		$this->loadLayout();     
		$this->renderLayout();
    }
}