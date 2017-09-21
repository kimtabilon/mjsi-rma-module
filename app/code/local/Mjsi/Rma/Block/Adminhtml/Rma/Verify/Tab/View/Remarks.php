<?php
class Mjsi_Rma_Block_Adminhtml_Rma_Verify_Tab_View_Remarks extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
	  $form = new Varien_Data_Form();
      $this->setForm($form);
       $fieldset = $form->addFieldset('rma_form', array('legend'=>Mage::helper('rma')->__('Remarks')));
     
	  $fieldset->addField('shipping_remarks', 'textarea', array(
          'label'     => Mage::helper('rma')->__('Remarks'),
		  'title'     => Mage::helper('rma')->__('Remarks'),
		  'style'	  => 'width:545px;',
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'shipping_remarks',
		  
      ));
	  
	  $form->addValues(Mage::registry('rma_data_item')->getData());
      
	  return parent::_prepareForm();
  }
}