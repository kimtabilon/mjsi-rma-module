<?php
require_once 'Zend/Pdf/Color/Rgb.php'; 
class Mjsi_Rma_Model_Rma_Pdf_Rma
{
	//y = 792
	//x = 612 
	protected $x = 612;
	protected $y = 765;
	protected $_rma;
	protected $_order;
	protected $_rmaitems;
	
    public function getPdf( $rmadetails )
    {
       	// Create new PDF 
		$pdf = new Zend_Pdf(); 
		$this->_rma = $rmadetails; 
		$this->_order = Mage::getModel('sales/order')->load($this->_rma->getOrderId());
		$this->_rmaitems = $this->_rma->getItemsCollection();
		
		// Add new page to the document 
		$page = $pdf->newPage(Zend_Pdf_Page::SIZE_LETTER);
		$pdf->pages[] = $page; 
		
		// Set font 
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD ), 20); 
		
		//Background Rectangle
		$page->setLineWidth(0.5);
		$page->setFillColor(new Zend_Pdf_Color_RGB(1, 1, 1)); 
		$page->setLineColor(new Zend_Pdf_Color_GrayScale(0.2)); 
		$page->drawRectangle(42, $this->y, 570, $this->y - 738); 
		
		//Top Rectangle
		$page->setLineWidth(0.5);
		$page->setFillColor(new Zend_Pdf_Color_GrayScale(0.8)); 
		$page->setLineColor(new Zend_Pdf_Color_GrayScale(0.2)); 
		$page->drawRectangle(42, $this->y, 570, $this->y -28); 
		$this->y -= 22;
		
		$page->setFillColor(new Zend_Pdf_Color_RGB(0, 0, 0));
		$page->drawText(Mage::helper('rma')->__('RMA CUSTOMER FORM'), 180, $this->y, 'UTF-8');
		$this->y -= 6;
		
		$this->_getOrderInfo($page, $this->y);
		$this->_getCustomerInfo($page, $this->y);
		$this->y -= 90;
		$this->_getRMAInfo($page, $this->y);
		$this->y -= 100;
		$this->_getItemsInfo($page, $this->y);
		
		$this->_getRemarksInfo($page);
		// Draw text 
		//$page->drawText('Thank you so much Lord!', 100, 510); 


        return $pdf;
    }
	
	protected function _getOrderInfo(Zend_Pdf_Page $page, $y_axis)
	{
		$page->setFillColor(new Zend_Pdf_Color_RGB(1, 1, 1)); 
		$page->setLineColor(new Zend_Pdf_Color_GrayScale(0.2)); 
		$page->drawRectangle(42, $y_axis, 306, $y_axis - 90);
		
		$page->setFillColor(new Zend_Pdf_Color_GrayScale(0.9)); 
		$page->setLineColor(new Zend_Pdf_Color_GrayScale(0.2)); 
		$page->drawRectangle(42, $y_axis, 306, $y_axis - 25); 
		
		$y_axis -= 18;
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD ), 12); 
		$page->setFillColor(new Zend_Pdf_Color_RGB(0, 0, 0));
		$page->drawText(Mage::helper('rma')->__('Order Information'), 52, $y_axis, 'UTF-8');
		
		$y_axis -= 28;
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA ), 12); 
		$page->setFillColor(new Zend_Pdf_Color_RGB(0, 0, 0));
		$page->drawText(Mage::helper('rma')->__('Order #:'), 52, $y_axis, 'UTF-8');
		
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD ), 12); 
		$page->setFillColor(new Zend_Pdf_Color_RGB(0, 0, 0));
		$page->drawText($this->_rma->getOrderNumber(), 132, $y_axis, 'UTF-8');
		
		$y_axis -= 25;
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA ), 12); 
		$page->setFillColor(new Zend_Pdf_Color_RGB(0, 0, 0));
		$page->drawText(Mage::helper('rma')->__('Date Filed #:'), 52, $y_axis, 'UTF-8');
		
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD ), 12); 
		$page->setFillColor(new Zend_Pdf_Color_RGB(0, 0, 0));
		$page->drawText(Mage::helper('core')->formatDate($this->_rma->getDateCreated(), 'long', false), 132, $y_axis, 'UTF-8');
	}
	
	protected function _getCustomerInfo(Zend_Pdf_Page $page, $y_axis)
	{
		$page->setFillColor(new Zend_Pdf_Color_RGB(1, 1, 1)); 
		$page->setLineColor(new Zend_Pdf_Color_GrayScale(0.2)); 
		$page->drawRectangle(306, $y_axis, 570, $y_axis - 90);
		
		$page->setFillColor(new Zend_Pdf_Color_GrayScale(0.9)); 
		$page->setLineColor(new Zend_Pdf_Color_GrayScale(0.2)); 
		$page->drawRectangle(306, $y_axis, 570, $y_axis - 25); 
		
		$y_axis -= 18;
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD ), 12); 
		$page->setFillColor(new Zend_Pdf_Color_RGB(0, 0, 0));
		$page->drawText(Mage::helper('rma')->__('Customer Information'), 316, $y_axis, 'UTF-8');
		
		$y_axis -= 25;
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA ), 12); 
		$page->setFillColor(new Zend_Pdf_Color_RGB(0, 0, 0));
		$page->drawText(Mage::helper('rma')->__('Name:'), 316, $y_axis, 'UTF-8');
		
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD ), 12); 
		$page->setFillColor(new Zend_Pdf_Color_RGB(0, 0, 0));
		$page->drawText($this->_order->getCustomerFirstname() . ' ' . $this->_order->getCustomerLastname(), 358, $y_axis, 'UTF-8');
		
		$y_axis -= 20;
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA ), 12); 
		$page->setFillColor(new Zend_Pdf_Color_RGB(0, 0, 0));
		$page->drawText(Mage::helper('rma')->__('Email:'), 316, $y_axis, 'UTF-8');
		
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD ), 12); 
		$page->setFillColor(new Zend_Pdf_Color_RGB(0, 0, 0));
		$page->drawText($this->_order->getCustomerEmail(), 358, $y_axis, 'UTF-8');
		
		$y_axis -= 20;
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA ), 12); 
		$page->setFillColor(new Zend_Pdf_Color_RGB(0, 0, 0));
		$page->drawText(Mage::helper('rma')->__('Tel:'), 316, $y_axis, 'UTF-8');
		
		if ($this->_rma->getContact()) 
		{
			$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD ), 12); 
			$page->setFillColor(new Zend_Pdf_Color_RGB(0, 0, 0));
			$page->drawText($this->_rma->getContact(), 358, $y_axis, 'UTF-8');
		}
		else
		{
			/*if (!$this->_order->getCustomerIsGuest()) 
			{
				$customerId = $this->_order->getCustomerId();
				$customer_model = Mage::getModel('customer/customer')->load($customerId);
				Mage::log($customer_model);
			}
			else
			{*/
				$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD ), 12); 
				$page->setFillColor(new Zend_Pdf_Color_RGB(0, 0, 0));
				$page->drawText(Mage::helper('rma')->__('N/A'), 358, $y_axis, 'UTF-8');
			//}
		}
		//Mage::log($this->_order);
	}
	
	protected function _getRMAInfo(Zend_Pdf_Page $page, $y_axis)
	{
		$page->setFillColor(new Zend_Pdf_Color_RGB(1, 1, 1)); 
		$page->setLineColor(new Zend_Pdf_Color_GrayScale(0.2)); 
		$page->drawRectangle(42, $y_axis, 570, $y_axis - 100);
		
		$page->setFillColor(new Zend_Pdf_Color_GrayScale(0.9)); 
		$page->setLineColor(new Zend_Pdf_Color_GrayScale(0.2)); 
		$page->drawRectangle(42, $y_axis, 570, $y_axis - 25); 
		
		$y_axis -= 18;
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD ), 12); 
		$page->setFillColor(new Zend_Pdf_Color_RGB(0, 0, 0));
		$page->drawText(Mage::helper('rma')->__('RMA Details'), 52, $y_axis, 'UTF-8');
		
		$y_axis -= 28;
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA ), 12); 
		$page->setFillColor(new Zend_Pdf_Color_RGB(0, 0, 0));
		$page->drawText(Mage::helper('rma')->__('Issued RMA #:'), 52, $y_axis, 'UTF-8');
		
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD ), 12); 
		$page->setFillColor(new Zend_Pdf_Color_RGB(0, 0, 0));
		$page->drawText($this->_rma->getRmaNumber(), 137, $y_axis, 'UTF-8');
		
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA ), 12); 
		$page->setFillColor(new Zend_Pdf_Color_RGB(0, 0, 0));
		$page->drawText(Mage::helper('rma')->__('Case #:'), 316, $y_axis, 'UTF-8');
	
		if ($this->_rma->getCaseNumber()) 
		{
			$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD ), 12); 
			$page->setFillColor(new Zend_Pdf_Color_RGB(0, 0, 0));
			$page->drawText($this->_rma->getCaseNumber(), 388, $y_axis, 'UTF-8');
		}
		
		$y_axis -= 20;
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA ), 12); 
		$page->setFillColor(new Zend_Pdf_Color_RGB(0, 0, 0));
		$page->drawText(Mage::helper('rma')->__('Invoice #:'), 52, $y_axis, 'UTF-8');
		
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD ), 12); 
		$page->setFillColor(new Zend_Pdf_Color_RGB(0, 0, 0));
		$page->drawText($this->_rma->getInvoiceNumber(), 137, $y_axis, 'UTF-8');
		
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA ), 12); 
		$page->setFillColor(new Zend_Pdf_Color_RGB(0, 0, 0));
		$page->drawText(Mage::helper('rma')->__('Tracking #:'), 316, $y_axis, 'UTF-8');

		if($this->_rma->getTrackNumber())
		{
			$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD ), 12); 
			$page->setFillColor(new Zend_Pdf_Color_RGB(0, 0, 0));
			$page->drawText($this->_rma->getTrackNumber(), 388, $y_axis, 'UTF-8');
		}
		
		$y_axis -= 20;
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA ), 12); 
		$page->setFillColor(new Zend_Pdf_Color_RGB(0, 0, 0));
		$page->drawText(Mage::helper('rma')->__('Status:'), 52, $y_axis, 'UTF-8');
		
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD ), 14); 
		$page->setFillColor(new Zend_Pdf_Color_RGB(0, 0, 0));
		$page->drawText($this->_rma->getStatus(), 137, $y_axis, 'UTF-8');
		
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA ), 12); 
	}
	
	protected function _getItemsInfo(Zend_Pdf_Page $page, $y_axis)
	{
		/*$page->setFillColor(new Zend_Pdf_Color_RGB(1, 1, 1)); 
		$page->setLineColor(new Zend_Pdf_Color_GrayScale(0.2)); 
		$page->drawRectangle(42, $y_axis, 570, $y_axis - 100);*/
		
		$page->setFillColor(new Zend_Pdf_Color_GrayScale(0.9)); 
		$page->setLineColor(new Zend_Pdf_Color_GrayScale(0.2)); 
		$page->drawRectangle(42, $y_axis, 570, $y_axis - 25); 
		
		$y_axis -= 18;
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD ), 12); 
		$page->setFillColor(new Zend_Pdf_Color_RGB(0, 0, 0));
		$page->drawText(Mage::helper('rma')->__('Item(s) to Return'), 52, $y_axis, 'UTF-8');
		
		$y_axis -= 8;
		$page->setFillColor(new Zend_Pdf_Color_GrayScale(0.9)); 
		$page->setLineColor(new Zend_Pdf_Color_GrayScale(0.9)); 
		$page->drawRectangle(43, $y_axis, 569, $y_axis - 15); 
		
		$y_axis -= 10;
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), 10); 
		$page->setFillColor(new Zend_Pdf_Color_RGB(0, 0, 0));
		$page->drawText(Mage::helper('rma')->__('Product Details'), 52, $y_axis, 'UTF-8');
		
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), 10); 
		$page->setFillColor(new Zend_Pdf_Color_RGB(0, 0, 0));
		$page->drawText(Mage::helper('rma')->__('Qty'), 420, $y_axis, 'UTF-8');
		
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), 10); 
		$page->setFillColor(new Zend_Pdf_Color_RGB(0, 0, 0));
		$page->drawText(Mage::helper('rma')->__('Status'), 470, $y_axis, 'UTF-8');
		
		$y_axis -= 23;
		foreach ($this->_rmaitems as $item)
		{
			$product = Mage::getModel ('catalog/product')->load($item->getItemId());
			$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD ), 10); 
			$page->setFillColor(new Zend_Pdf_Color_RGB(0, 0, 0));
			$page->drawText($product->getName(). ' (' . $product->getSku() . ')' , 52, $y_axis, 'UTF-8');
			
			$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA ), 10); 
			$page->setFillColor(new Zend_Pdf_Color_RGB(0, 0, 0));
			$page->drawText($item->getQty() , 425, $y_axis, 'UTF-8');
			
			$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA ), 10); 
			$page->setFillColor(new Zend_Pdf_Color_RGB(0, 0, 0));
			$page->drawText($item->getStatus() , 450, $y_axis, 'UTF-8');
			
			if ($item->getSerialNumber()) {
				$y_axis -= 14;
				$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), 10); 
				$page->setFillColor(new Zend_Pdf_Color_RGB(0, 0, 0));
				$page->drawText(Mage::helper('rma')->__('Serial:'), 52, $y_axis, 'UTF-8');
				
				$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), 10); 
				$page->setFillColor(new Zend_Pdf_Color_RGB(0, 0, 0));
				$page->drawText($item->getSerialNumber(), 85, $y_axis, 'UTF-8');
			}
			
			$y_axis -= 14;
			$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), 10); 
			$page->setFillColor(new Zend_Pdf_Color_RGB(0, 0, 0));
			$page->drawText(Mage::helper('rma')->__('Type:'), 52, $y_axis, 'UTF-8');
			
			$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_ITALIC), 10); 
			$page->setFillColor(new Zend_Pdf_Color_RGB(0, 0, 0));
			$page->drawText($item->getType(), 85, $y_axis, 'UTF-8');
			
			if($item->getReason()) {
				$y_axis -= 14;
				$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), 10); 
				$page->setFillColor(new Zend_Pdf_Color_RGB(0, 0, 0));
				$page->drawText(Mage::helper('rma')->__('Reason for return:'), 52, $y_axis, 'UTF-8');
				
				$y_axis -= 14;
				$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), 10); 
				$page->setFillColor(new Zend_Pdf_Color_RGB(0, 0, 0));
				$text = wordwrap($item->getReason(), 115, "\n", false);
				$text = rtrim($text, "\n");
				$token = strtok($text, "\n");
				while ($token != false) {
					$page->drawText($token, 52, $y_axis, 'UTF-8');
					$y_axis-=14;
					$token = strtok("\n");
				}
			}
			
			$y_axis -= 3;
			$page->setLineColor(new Zend_Pdf_Color_RGB(0, 0, 0));
			$page->setLineDashingPattern(array(3, 2, 3, 4), 1.6); 
			$page->drawLine(43, $y_axis, 569, $y_axis); 
			
			$y_axis -= 20;
		}
	}
	
	protected function _getRemarksInfo(Zend_Pdf_Page $page)
	{
		$y_axis = 185;
		$page->setLineDashingPattern(Zend_Pdf_Page::LINE_DASHING_SOLID); 
		$page->setFillColor(new Zend_Pdf_Color_GrayScale(0.9)); 
		$page->setLineColor(new Zend_Pdf_Color_GrayScale(0.2)); 
		$page->drawRectangle(42, $y_axis, 570, $y_axis - 25); 
		
		$y_axis -= 18;
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD ), 12); 
		$page->setFillColor(new Zend_Pdf_Color_RGB(0, 0, 0));
		$page->drawText(Mage::helper('rma')->__('Remarks'), 52, $y_axis, 'UTF-8');
		
		$y_axis -= 28;
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA ), 12); 
		$page->setFillColor(new Zend_Pdf_Color_RGB(0, 0, 0));
		
		$text = wordwrap($this->_rma->getRemarks(), 85, "\n", false);
		$token = strtok($text, "\n");
		while ($token != false) {
			$page->drawText($token, 52, $y_axis, 'UTF-8');
			$y_axis-=15;
			$token = strtok("\n");
		}
	}
    
}