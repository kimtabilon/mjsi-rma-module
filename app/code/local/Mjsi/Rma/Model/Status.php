<?php

class Mjsi_Rma_Model_Status extends Varien_Object
{
    const STATUS_PENDING			= 1;
    const STATUS_RMA_RECEIVED		= 2;
	const STATUS_SHIP_RECEIVED		= 3;
	const STATUS_SHIP_UNVERIFIED	= 4;
	const STATUS_SHIP_VERIFIED		= 5;
	const STATUS_REFUNDED			= 6;
	const STATUS_CANCELLED			= 7;
	const STATUS_CLOSED				= 8;
	const STATUS_INVALID			= 9;				
	
    static public function getOptionArray()
    {
        return array(
            self::STATUS_PENDING   => Mage::helper('rma')->__('Pending'),
            self::STATUS_RMA_RECEIVED   => Mage::helper('rma')->__('RMA Received'),
			self::STATUS_SHIP_RECEIVED	=> Mage::helper('rma')->__('Shipment Received'),
			self::STATUS_SHIP_UNVERIFIED	=> Mage::helper('rma')->__('Shipment Contents Unverified'),
			self::STATUS_SHIP_VERIFIED	=> Mage::helper('rma')->__('Shipment Contents Verified'),
			self::STATUS_REFUNDED	=> Mage::helper('rma')->__('Refund Processed'),
			self::STATUS_CANCELLED	=> Mage::helper('rma')->__('Cancelled'),
			self::STATUS_CLOSED	=> Mage::helper('rma')->__('Closed'),
			self::STATUS_INVALID	=> Mage::helper('rma')->__('Invalid RMA')
        );
    }
}