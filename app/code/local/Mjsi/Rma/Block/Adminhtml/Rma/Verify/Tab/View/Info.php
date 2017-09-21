<?php
class Mjsi_Rma_Block_Adminhtml_Rma_Verify_Tab_View_Info extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
	  $dateFormatIso = Mage::app()->getLocale()->getDateFormat(
	  Mage_Core_Model_Locale::FORMAT_TYPE_LONG
	  );
	  $rma_model = Mage::registry('rma_data');
	  $item_model = Mage::registry('rma_data_item');
	  $productId = $item_model->getItemId();
	  $productmodel = false;
	  $productmodel = Mage::getModel('catalog/product')->load($productId);
	  
	  $rmaorder = Mage::getModel('sales/order')->load($rma_model->getOrderId());
	  
	  $items = $rmaorder->getAllItems();
		foreach ($items as $itemId => $item)
		{
			if ($item->getProductId() == $productId) {
				$productmodel = $item;
			}
		}
	  
      $form = new Varien_Data_Form();
      $this->setForm($form);
       $fieldset = $form->addFieldset('rma_form', array('legend'=>Mage::helper('rma')->__('Product Information')));
     
	  $fieldset->addField('product_name', 'label', array(
          'label'     => Mage::helper('rma')->__('Product Name'),
		  'title'     => Mage::helper('rma')->__('Product Name'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'product_name',
		  'value'	  => $productmodel->getName(),
      ));
	  
	  $fieldset->addField('product_sku', 'label', array(
          'label'     => Mage::helper('rma')->__('Product SKU'),
		  'title'     => Mage::helper('rma')->__('Product SKU'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'product_sku',
		  'value'	  => $productmodel->getSku(),
      ));
	 
	  $fieldset->addField('serial_number', 'text', array(
          'label'     => Mage::helper('rma')->__('Serial Number'),
		  'title'     => Mage::helper('rma')->__('Serial Number'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'serial_number',
		  'style'	  => 'width:150px;',
		  
      ));
	  
	  $fieldset->addField('qty', 'text', array(
          'label'     => Mage::helper('rma')->__('Qty to Return'),
		  'title'     => Mage::helper('rma')->__('Qty to Return'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'qty',
		  'style'	  => 'width:25px;',
	  ));
	  
	  $form->addValues(Mage::registry('rma_data_item')->getData());
      
      
     
      /*if ( Mage::getSingleton('adminhtml/session')->getRmaData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getRmaData());
          Mage::getSingleton('adminhtml/session')->setRmaData(null);
      } elseif ( Mage::registry('rma_data') ) {
          $form->setValues(Mage::registry('rma_data')->getData());
      }*/
      return parent::_prepareForm();
  }
}