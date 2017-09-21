<?php

class Mjsi_Rma_Block_Adminhtml_Rma_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'rma';
        $this->_controller = 'adminhtml_rma';
        
        $this->_updateButton('save', 'label', Mage::helper('rma')->__('Save RMA'));
        $this->_updateButton('delete', 'label', Mage::helper('rma')->__('Delete RMA'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), 10);

		$this->_addButton('printrma', array(
            'label'     => Mage::helper('adminhtml')->__('Print'),
			'onclick'   => 'setLocation(\'' . $this->getUrl('*/*/printrma', array('id' => Mage::registry('rma_data')->getId() )) . '\')',
            'class'     => 'edit',
        ), -1);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('rma_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'rma_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'rma_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('rma_data') && Mage::registry('rma_data')->getId() ) {
			return Mage::helper('rma')->__("RMA for Order #: %s", $this->htmlEscape(Mage::registry('rma_data')->getOrderNumber()));
        } else {
            return Mage::helper('rma')->__('Add RMA');
        }
    }
}