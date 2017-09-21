<?php
class Mjsi_Rma_Block_Adminhtml_Rma_Verify_Tab_View_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
	  $dateFormatIso = Mage::app()->getLocale()->getDateFormat(
		Mage_Core_Model_Locale::FORMAT_TYPE_LONG
		);
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('rma_form', array('legend'=>Mage::helper('rma')->__('RMA Item Information')));
     
	  $fieldset->addField('shipping_date', 'date', array(
            'name'      => 'shipping_date',
            'label'     => Mage::helper('rma')->__('Date Received'),
            'image'     => $this->getSkinUrl('images/grid-cal.gif'),
            'format'    => $dateFormatIso,
            'required'  => false,
			'style'	  => 'width:150px;',
        ));
			
	  $fieldset->addField('shipping_box', 'select', array(
          'label'     => Mage::helper('rma')->__('Box Condition'),
          'name'      => 'shipping_box',
		  'style'	  => 'width:45px;',
		  'after_element_html' => Mage::helper('rma')->__('( 1 = box is destroyed ... 10 = box in new condition )'),
		  'values'    => array(
              array(
                  'value'     => '1',
                  'label'     => Mage::helper('rma')->__('1'),
              ),
			  array(
                  'value'     => '2',
                  'label'     => Mage::helper('rma')->__('2'),
              ),
			  array(
                  'value'     => '3',
                  'label'     => Mage::helper('rma')->__('3'),
              ),
			  array(
                  'value'     => '4',
                  'label'     => Mage::helper('rma')->__('4'),
              ),
			  array(
                  'value'     => '5',
                  'label'     => Mage::helper('rma')->__('5'),
              ),
			  array(
                  'value'     => '6',
                  'label'     => Mage::helper('rma')->__('6'),
              ),
			  array(
                  'value'     => '7',
                  'label'     => Mage::helper('rma')->__('7'),
              ),
			  array(
                  'value'     => '8',
                  'label'     => Mage::helper('rma')->__('8'),
              ),
			  array(
                  'value'     => '9',
                  'label'     => Mage::helper('rma')->__('9'),
              ),
			  array(
                  'value'     => '10',
                  'label'     => Mage::helper('rma')->__('10'),
              ),
             
			  
          ),
      ));
	  
	  $fieldset->addField('shipping_package', 'select', array(
          'label'     => Mage::helper('rma')->__('Package Condition'),
          'name'      => 'shipping_package',
		  'style'	  => 'width:45px;',
		  'after_element_html' => Mage::helper('rma')->__('( 1 = packaging is destroyed ... 10 = packaging in new condition )'),
		  'values'    => array(
              array(
                  'value'     => '1',
                  'label'     => Mage::helper('rma')->__('1'),
              ),
			  array(
                  'value'     => '2',
                  'label'     => Mage::helper('rma')->__('2'),
              ),
			  array(
                  'value'     => '3',
                  'label'     => Mage::helper('rma')->__('3'),
              ),
			  array(
                  'value'     => '4',
                  'label'     => Mage::helper('rma')->__('4'),
              ),
			  array(
                  'value'     => '5',
                  'label'     => Mage::helper('rma')->__('5'),
              ),
			  array(
                  'value'     => '6',
                  'label'     => Mage::helper('rma')->__('6'),
              ),
			  array(
                  'value'     => '7',
                  'label'     => Mage::helper('rma')->__('7'),
              ),
			  array(
                  'value'     => '8',
                  'label'     => Mage::helper('rma')->__('8'),
              ),
			  array(
                  'value'     => '9',
                  'label'     => Mage::helper('rma')->__('9'),
              ),
			  array(
                  'value'     => '10',
                  'label'     => Mage::helper('rma')->__('10'),
              ),
             
			  
          ),
      ));
	  
	  /*$fieldset->addField('shipping_included', 'multiselect', array(
                'name' => 'shipping_included[]' , 
                'label' => Mage::helper('rma')->__('Included in the Box') , 
                'title' => Mage::helper('rma')->__('Included in the Box') , 
				'after_element_html' => Mage::helper('rma')->__('Press and Hold CTRL key to select multiple items.'),
                //'values' => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(false, true)
				'values' => $data,
            ));
	  */
	  
	  $fieldset->addField('shipping_working', 'select', array(
          'label'     => Mage::helper('rma')->__('Working'),
          'name'      => 'shipping_working',
		  'style'	  => 'width:55px;',
		  'values'    => array(
              array(
                  'value'     => 'Yes',
                  'label'     => Mage::helper('rma')->__('Yes'),
              ),
			  array(
                  'value'     => 'No',
                  'label'     => Mage::helper('rma')->__('No'),
              ),
			  
          ),
      ));
	  
	  $fieldset->addField('shipping_complete', 'select', array(
          'label'     => Mage::helper('rma')->__('Complete'),
          'name'      => 'shipping_complete',
		  'style'	  => 'width:55px;',
		  'values'    => array(
              array(
                  'value'     => 'Yes',
                  'label'     => Mage::helper('rma')->__('Yes'),
              ),
			  array(
                  'value'     => 'No',
                  'label'     => Mage::helper('rma')->__('No'),
              ),
			  
          ),
      ));
	  
	  $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('rma')->__('Item Status'),
          'name'      => 'status',
		  'style'	  => 'width:150px;',
          'values'    => array(
              array(
                  'value'     => 'Waiting for Item',
                  'label'     => Mage::helper('rma')->__('Waiting for Item'),
              ),

              array(
                  'value'     => 'Item Received',
                  'label'     => Mage::helper('rma')->__('Item Received'),
              ),
			  
			  array(
                  'value'     => 'Unverified - Working Item',
                  'label'     => Mage::helper('rma')->__('Unverified - Working Item'),
              ),
			  
			  array(
                  'value'     => 'Unverified - Missing Parts',
                  'label'     => Mage::helper('rma')->__('Unverified - Missing Parts'),
              ),
			  
			  array(
                  'value'     => 'Verified',
                  'label'     => Mage::helper('rma')->__('Verified'),
              ),
			  
          ),
      ));
	  
	  $fieldset->addField('label', 'label', array(
            'name'      => 'label',
            'value'		=> ' ..........................................................................................................................................................',
			'style'	  => 'width:1050px;',
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