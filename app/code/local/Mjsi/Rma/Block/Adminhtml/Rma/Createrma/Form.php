<?php
class Mjsi_Rma_Block_Adminhtml_Rma_Createrma_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form(array(
                                      'id' => 'edit_form',
                                      'action' => $this->getUrl('*/*/savenew', array('order_id' => $this->getRequest()->getParam('order_id'))),
                                      'method' => 'post',
        							  'enctype' => 'multipart/form-data'
                                   )
      );
      $form->setUseContainer(true);
      $this->setForm($form);
      return parent::_prepareForm();
  }
}