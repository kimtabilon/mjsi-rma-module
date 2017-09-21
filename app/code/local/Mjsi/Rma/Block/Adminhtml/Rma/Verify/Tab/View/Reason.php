<?php
class Mjsi_Rma_Block_Adminhtml_Rma_Verify_Tab_View_Reason extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
	  $dateFormatIso = Mage::app()->getLocale()->getDateFormat(
	  Mage_Core_Model_Locale::FORMAT_TYPE_LONG
	  );
	  $item_model = Mage::registry('rma_data_item');
	  $productId = $item_model->getItemId();
	  $productmodel = Mage::getModel('catalog/product')->load($productId);
	  
      $form = new Varien_Data_Form();
      $this->setForm($form);
       $fieldset = $form->addFieldset('rma_form', array('legend'=>Mage::helper('rma')->__('Return Type  &  Reason for Return')));
     
	  $fieldset->addField('type', 'select', array(
            'name'      => 'type',
            'label'     => Mage::helper('rma')->__('Type of Return'),
			'style'		=> 'width:150px;',
			'values'	=> array(
				array(
					'value'		=> 'Replacement',
					'label'		=> 'Replacement',
				),
				array(
					'value'		=> 'Refund',
					'label'		=> 'Refund',
				),
			),
        ));
	  
	  $fieldset->addField('reason', 'textarea', array(
          'label'     => Mage::helper('rma')->__('Reason for Return'),
		  'title'     => Mage::helper('rma')->__('Reason for Return'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'reason',
		  'style'	  => 'width:200px; height:72px;',
		  
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