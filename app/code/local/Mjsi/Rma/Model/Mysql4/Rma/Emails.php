<?php
class Mjsi_Rma_Model_Mysql4_Rma_Emails extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init('rma/rma_emails', 'rma_emails_id');
    }
}