<?php
class Mjsi_Rma_Model_Mysql4_Rma_Emails_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        //parent::__construct();
        $this->_init('rma/rma_emails');
    }
    
    /**
     * Set filter by rma id
     *
     * @param   mixed $rma
     */
    public function setRmaFilter($rma)
    {
        if ($rma instanceof Mjsi_Rma_Model_Rma) {
            $rmaId = $rma->getId();
        }
        else {
            $rmaId = $rma;
        }
        $this->addFieldToFilter('rma_id', $rmaId);
        return $this;
    }
}