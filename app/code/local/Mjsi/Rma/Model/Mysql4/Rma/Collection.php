<?php
class Mjsi_Rma_Model_Mysql4_Rma_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        //parent::__construct();
        $this->_init('rma/rma');
    }
}