<?php

class Mjsi_Rma_Model_Mysql4_Rma extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the rma_id refers to the key field in your database table.
        $this->_init('rma/rma', 'rma_id');
    }
}