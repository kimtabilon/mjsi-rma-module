<?php
class Mjsi_Rma_Block_View extends Mage_Core_Block_Template
{
	public function __construct()
    {
        parent::__construct();
        $this->setTemplate('rma/view.phtml');

        Mage::app()->getFrontController()->getAction()->getLayout()->getBlock('root')->setHeaderTitle(Mage::helper('rma')->__('View RMAs'));
    }
	
	public function getViewUrl($rma)
    {
        return $this->getUrl('rma/view', array('id' => $rma->getId()));
    }
	
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
	
    public function getRma()
    {
        if (!$this->hasData('rmaview')) {
            $this->setData('rmaview', Mage::registry('rmaview'));
        }
        return $this->getData('rmaview');
    }

    public function setRma( $Rma )
    {
        $this->Rma = $Rma;
        return $this;
    }
	
	public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }
	
}