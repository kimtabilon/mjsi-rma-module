<?php
class Mjsi_Rma_Model_Mysql4_Rma_Items extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init('rma/rma_items', 'rma_items_id');
    }
}