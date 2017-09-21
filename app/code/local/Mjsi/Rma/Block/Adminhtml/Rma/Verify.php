<?php
class Mjsi_Rma_Block_Adminhtml_Rma_Verify extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'item_id';
        $this->_blockGroup = 'rma';
		$this->_mode = 'verify';
        $this->_controller = 'adminhtml_rma';
        
        $this->_updateButton('save', 'label', Mage::helper('rma')->__('Verify Item'));
		$this->_removeButton('delete');
		$this->_removeButton('back');
		$this->_removeButton('reset');
		
		$this->_addButton('backedit', array(
            'label'     => Mage::helper('adminhtml')->__('Back'),
			'onclick'   => 'setLocation(\'' . $this->getUrl('*/*/edit', array('id' => Mage::registry('rma_data')->getId() )) . '\')',
            'class'     => 'back',
        ), -1);
		
		$this->_addButton('resetverify', array(
            'label'     => Mage::helper('adminhtml')->__('Reset'),
			'onclick'   => 'setLocation(\'' . $this->getUrl('*/*/verify', array('id' => Mage::registry('rma_data')->getId(), 'item_id' => $this->getRequest()->getParam('item_id') )) . '\')',
            'class'     => 'reset',
        ), 0);
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Verify And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);
		
		$this->_addButton('printrmaitems', array(
            'label'     => Mage::helper('adminhtml')->__('Print Verification'),
			'onclick'   => 'setLocation(\'' . $this->getUrl('*/*/printrmaitems', array('id' => Mage::registry('rma_data')->getId(), 'item_id' => $this->getRequest()->getParam('item_id') )) . '\')',
            'class'     => 'save',
        ), -200);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('rma_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'rma_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'rma_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/verify/');
            }
        ";
		
		//$this->setBackUrl($this->getUrl('*/*/edit', array('id' => $this->getRequest()->getParam('id') )) );
		//$this->_addBackButton();
    }

    public function getHeaderText()
    {
        if( Mage::registry('rma_data') && Mage::registry('rma_data')->getId() ) {
			$item_model = Mage::registry('rma_data_item');
	  		$productId = $item_model->getItemId();
	  		$productmodel = Mage::getModel('catalog/product')->load($productId);
			return Mage::helper('rma')->__("Verify '%s' for RMA of Order#: %s", $productmodel->getName(), $this->htmlEscape(Mage::registry('rma_data')->getOrderNumber()));
        } else {
            return Mage::helper('rma')->__('Verify RMA');
        }
    }
}