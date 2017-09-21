<?php
class Mjsi_Rma_Block_Adminhtml_Rma_Edit_Tab_View_Remarks extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('rma_form', array('legend'=>Mage::helper('rma')->__('RMA Remarks')));
     
	  $fieldset->addField('remarks', 'editor', array(
          'name'      => 'remarks',
          'label'     => Mage::helper('rma')->__('Remarks'),
          'title'     => Mage::helper('rma')->__('Remarks'),
          'style'     => 'width:700px; height:200px;',
          'wysiwyg'   => false,
          'required'  => false,
      ));
     
      if ( Mage::getSingleton('adminhtml/session')->getRmaData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getRmaData());
          Mage::getSingleton('adminhtml/session')->setRmaData(null);
      } elseif ( Mage::registry('rma_data') ) {
          $form->setValues(Mage::registry('rma_data')->getData());
      }
      return parent::_prepareForm();
  }
}