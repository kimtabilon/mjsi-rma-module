<?php
class Mjsi_Rma_Block_Pickorder extends Mage_Sales_Block_Order_History
{
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('rma/pick_order.phtml');

        Mage::app()->getFrontController()->getAction()->getLayout()->getBlock('root')->setHeaderTitle(Mage::helper('rma')->__('Pick Order to Create RMA '));
    }
    
    public function getViewUrl($order)
    {
        return $this->getUrl('sales/order/view', array('order_id' => $order->getId()));
    }
}