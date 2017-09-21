<?php
class Mjsi_Rma_Block_Adminhtml_Rma_Createrma extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'rma';
		$this->_mode = 'createrma';
        $this->_controller = 'adminhtml_rma';
        
        $this->_updateButton('save', 'label', Mage::helper('rma')->__('Submit RMA'));
		$this->_removeButton('delete');	
		$this->_removeButton('back');
		$this->_removeButton('reset');
		
		$this->_addButton('backcreate', array(
            'label'     => Mage::helper('adminhtml')->__('Back'),
			'onclick'   => 'history.go(-1)',
            'class'     => 'back',
        ), -1);
		
		$this->_addButton('resetcreate', array(
            'label'     => Mage::helper('adminhtml')->__('Reset'),
			'onclick'   => 'setLocation(\'' . $this->getUrl('*/*/createrma', array('order_id' => $this->getRequest()->getParam('order_id')  )) . '\')',
            'class'     => 'reset',
        ), 0);	

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('rma_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'rma_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'rma_content');
                }
            }

        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('rma_order') && Mage::registry('rma_order')->getId() ) {
			return Mage::helper('rma')->__("Create RMA for Order #: %s", $this->htmlEscape(Mage::registry('rma_order')->getIncrementId()));
        } else {
            return Mage::helper('rma')->__('Create RMA');
        }
    }
}