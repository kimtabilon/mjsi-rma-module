<?php

$installer = $this;

$installer->startSetup();

$installer->run("
DROP TABLE IF EXISTS {$this->getTable('rma')};
CREATE TABLE {$this->getTable('rma')} (
  `rma_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rma_number` varchar(100) DEFAULT NULL,
  `invoice_number` varchar(100) DEFAULT NULL,
  `case_number` varchar(100) DEFAULT NULL,
  `order_id` int(250) DEFAULT NULL,
  `order_number` int(250) DEFAULT NULL,
  `customer_id` int(50) NOT NULL,
  `status` varchar(100) DEFAULT 1 NOT NULL,
  `date_created` datetime NULL,
  `date_lastupdated` datetime NULL,
  `track_number` varchar(100) DEFAULT NULL,
  `remarks` text (8000) DEFAULT NULL,
  `contact` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`rma_id`),
  KEY `customer_id` (`customer_id`)
) ENGINE=InnoDB;
");
  
$installer->run("
DROP TABLE IF EXISTS {$this->getTable('rma_items')};
CREATE TABLE {$this->getTable('rma_items')} (
  `rma_items_id` int(50) NOT NULL AUTO_INCREMENT,
  `rma_id` int(100) NOT NULL,
  `item_id` int(100) NOT NULL,
  `qty` int(100) NOT NULL,
  `serial_number` varchar(100) DEFAULT NULL,
  `reason` text(8000) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `shipping_date` varchar(100) DEFAULT NULL,
  `shipping_box` int(10) DEFAULT NULL,
  `shipping_package` int(10) DEFAULT NULL,
  `shipping_working` varchar(10) DEFAULT NULL,
  `shipping_complete` varchar(10) DEFAULT NULL,
  `shipping_remarks` text(8000) DEFAULT NULL,
  `shipping_included` text(8000) DEFAULT NULL,
  PRIMARY KEY (`rma_items_id`),
  KEY `rma_id` (`rma_id`)
) ENGINE=InnoDB;
");

$installer->run("
DROP TABLE IF EXISTS {$this->getTable('rma_emails')};
CREATE TABLE {$this->getTable('rma_emails')} (
  `rma_emails_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rma_id` int(100) NOT NULL,
  `subject` varchar(250) DEFAULT NULL,
  `email_body` text(10000) DEFAULT NULL,
  `date_sent` datetime NULL,
  PRIMARY KEY (`rma_emails_id`),
  KEY `rma_id` (`rma_id`)
) ENGINE=InnoDB;
");

$installer->endSetup(); 