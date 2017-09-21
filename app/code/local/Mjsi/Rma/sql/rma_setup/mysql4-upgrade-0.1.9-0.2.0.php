<?php

$installer = $this;
$installer->startSetup();

$this->getConnection()
     ->addColumn($this->getTable('rma'), 'customer_name',
          "varchar(250) DEFAULT NULL AFTER `customer_id`");

$this->getConnection()
     ->addColumn($this->getTable('rma'), 'customer_email',
          "varchar(250) DEFAULT NULL AFTER `customer_name`");

$this->getConnection()
     ->addColumn($this->getTable('rma'), 'store_id',
          "int(250) DEFAULT NULL AFTER `customer_email`");

$thisTableName = $this->getTable('rma/rma');

$allRMAs = Mage::getModel('rma/rma')->getCollection();
$allRMAs->load();

//$cleanRMAs = array();

foreach($allRMAs as $individualRMA)
	{
	$thisRMA_order_id = $individualRMA->getData('order_id');
	
	$thisRMA_order_model = Mage::getModel('sales/order')->load($thisRMA_order_id);
	$thisRMA_store_id = $thisRMA_order_model->getData('store_id');
	
	$thisRMA_customer_firstName = $thisRMA_order_model->getCustomerFirstname();
	$thisRMA_customer_lastName = $thisRMA_order_model->getCustomerLastname();
	$thisRMA_customer_name = $thisRMA_customer_firstName . " " . $thisRMA_customer_lastName;
	$thisRMA_customer_email = $thisRMA_order_model->getCustomerEmail();
	
	$thisRMA_customer_isguest = $thisRMA_order_model->getCustomerIsGuest();
	
	if( ($thisRMA_customer_isguest == "1") || ($thisRMA_customer_name == " ") ) {$thisRMA_customer_name = "Guest";}
	
	$installer->run("UPDATE `" . $thisTableName . "` SET `customer_name`='" . $thisRMA_customer_name . "', `customer_email`='" . $thisRMA_customer_email . "', `store_id`='" . $thisRMA_store_id . "' WHERE `order_id`='" . $thisRMA_order_id . "'");
	
	//$thisRMA_store_name = Mage::getModel('core/store_group')->load($thisRMA_store_id)->getData('name');
	//$installer->run("UPDATE `" . $thisTableName . "` SET `store_id`='" . $thisRMA_store_id . "', `store_name`='" . $thisRMA_store_name . "' WHERE `order_id`='" . $thisRMA_order_id . "'");
	}

$installer->endSetup();