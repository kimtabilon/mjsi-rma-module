<?php
class Mjsi_Rma_Block_Adminhtml_Rma_Verify_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('rma_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('rma')->__('Item Details'));
  }

  protected function _beforeToHtml()
  {
      /*$this->addTab('form_section', array(
          'label'     => Mage::helper('rma')->__('RMA Informa'),
          'title'     => Mage::helper('rma')->__('RMA Informa'),
          'content'   => $this->getLayout()->createBlock('rma/adminhtml_rma_edit_tab_view_form')->toHtml(),
      ));*/
     
      $this->_updateActiveTab();
        Varien_Profiler::stop('rma/tabs');
        return parent::_beforeToHtml();
  }
  
  protected function _updateActiveTab()
    {
    	$tabId = $this->getRequest()->getParam('tab');
    	if( $tabId ) {
    		$tabId = preg_replace("#{$this->getId()}_#", '', $tabId);
    		if($tabId) {
    			$this->setActiveTab($tabId);
    		}
    	}
    }
}