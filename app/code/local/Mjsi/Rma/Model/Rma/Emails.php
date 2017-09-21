<?php
class Mjsi_Rma_Model_Rma_Emails extends Mage_Core_Model_Abstract
{
 
    protected $rma;
    protected $order_item;
	protected $rma_item;
    
    protected function _construct()
    {
        parent::_construct(); 
        $this->_init('rma/rma_emails');
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

    protected function _beforeSave()
    {
        parent::_beforeSave();

        if (!$this->getRmaId()) {
            $this->setRmaId($this->getRma()->getId());
        }

        return $this;
    }
    
    
}