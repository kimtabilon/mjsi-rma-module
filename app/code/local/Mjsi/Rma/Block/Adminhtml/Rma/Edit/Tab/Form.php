<?php
class Mjsi_Rma_Block_Adminhtml_Rma_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('rma_form', array('legend'=>Mage::helper('rma')->__('RMA Information')));
     
	  $fieldset->addField('rma_number', 'text', array(
          'label'     => Mage::helper('rma')->__('RMA Number'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'rma_number',
		  
      ));
	  
	  $fieldset->addField('case_number', 'text', array(
          'label'     => Mage::helper('rma')->__('Vendor Case Number'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'case_number',
		  
      ));
	  
	  $fieldset->addField('track_number', 'text', array(
          'label'     => Mage::helper('rma')->__('Return Tracking Number'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'track_number',
		  
      ));
		
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('rma')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('rma')->__('Pending'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('rma')->__('RMA Received'),
              ),
			  
			  array(
                  'value'     => 3,
                  'label'     => Mage::helper('rma')->__('Shipment Received'),
              ),
			  
			  array(
                  'value'     => 4,
                  'label'     => Mage::helper('rma')->__('Shipment Contents Unverified'),
              ),
			  
			  array(
                  'value'     => 5,
                  'label'     => Mage::helper('rma')->__('Shipment Contents Verified'),
              ),
			  
			  array(
                  'value'     => 6,
                  'label'     => Mage::helper('rma')->__('Refund Processed'),
              ),
			  
			  array(
                  'value'     => 7,
                  'label'     => Mage::helper('rma')->__('Cancelled'),
              ),
			  
			  array(
                  'value'     => 8,
                  'label'     => Mage::helper('rma')->__('Closed'),
              ),
			  
			  array(
                  'value'     => 9,
                  'label'     => Mage::helper('rma')->__('Invalid RMA'),
              ),
			  
          ),
      ));
     
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