<?php
require_once 'Zend/Pdf/Color/Rgb.php'; 
class Mjsi_Rma_Model_Rma_Pdf_Rmaitems
{
	//y = 792
	//x = 612 
	protected $x = 612;
	protected $y = 765;
	protected $_rmaitem;
	protected $_product;
	
    public function getPdf( $item )
    {
       	// Create new PDF 
		$pdf = new Zend_Pdf(); 
		$this->_rmaitem = $item;
		$this->_product = Mage::getModel ('catalog/product')->load($this->_rmaitem->getItemId());
		
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
		$page->drawText(Mage::helper('rma')->__('RMA RECEIVED FORM'), 180, $this->y, 'UTF-8');
		$this->y -= 6;
		
		$this->_getProductInfo($page, $this->y);
		$this->y -= 175;
		$this->_getRMAItemInfo($page, $this->y);
		$this->y -= 100;
		$this->_getIncludedBox($page, $this->y);
		
		$this->_getRemarksInfo($page);
		// Draw text 
		//$page->drawText('Thank you so much Lord!', 100, 510); 


        return $pdf;
    }
	
	protected function _getProductInfo(Zend_Pdf_Page $page, $y_axis)
	{
		$page->setFillColor(new Zend_Pdf_Color_RGB(1, 1, 1)); 
		$page->setLineColor(new Zend_Pdf_Color_GrayScale(0.2)); 
		$page->drawRectangle(42, $y_axis, 570, $y_axis - 175);
		
		$page->setFillColor(new Zend_Pdf_Color_GrayScale(0.9)); 
		$page->setLineColor(new Zend_Pdf_Color_GrayScale(0.2)); 
		$page->drawRectangle(42, $y_axis, 570, $y_axis - 25); 
		
		$y_axis -= 18;
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD ), 12); 
		$page->setFillColor(new Zend_Pdf_Color_RGB(0, 0, 0));
		$page->drawText(Mage::helper('rma')->__('Product Information'), 52, $y_axis, 'UTF-8');
		
		$y_axis -= 28;
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA ), 12); 
		$page->setFillColor(new Zend_Pdf_Color_RGB(0, 0, 0));
		$page->drawText(Mage::helper('rma')->__('Name:'), 52, $y_axis, 'UTF-8');
		
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD ), 12); 
		$page->setFillColor(new Zend_Pdf_Color_RGB(0, 0, 0));
		$page->drawText($this->_product->getName(), 100, $y_axis, 'UTF-8');
		
		$y_axis -= 16;
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA ), 12); 
		$page->setFillColor(new Zend_Pdf_Color_RGB(0, 0, 0));
		$page->drawText(Mage::helper('rma')->__('SKU:'), 52, $y_axis, 'UTF-8');
		
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD ), 12); 
		$page->setFillColor(new Zend_Pdf_Color_RGB(0, 0, 0));
		$page->drawText($this->_product->getSku(), 100, $y_axis, 'UTF-8');
		
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA ), 12); 
		$page->setFillColor(new Zend_Pdf_Color_RGB(0, 0, 0));
		$page->drawText(Mage::helper('rma')->__('Serial #:'), 316, $y_axis, 'UTF-8');
		
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD ), 12); 
		$page->setFillColor(new Zend_Pdf_Color_RGB(0, 0, 0));
		$page->drawText($this->_rmaitem->getSerialNumber(), 365, $y_axis, 'UTF-8');
		
		$y_axis -= 16;
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA ), 12); 
		$page->setFillColor(new Zend_Pdf_Color_RGB(0, 0, 0));
		$page->drawText(Mage::helper('rma')->__('Qty:'), 52, $y_axis, 'UTF-8');
		
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD ), 12); 
		$page->setFillColor(new Zend_Pdf_Color_RGB(0, 0, 0));
		$page->drawText($this->_rmaitem->getQty(), 100, $y_axis, 'UTF-8');
		
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA ), 12); 
		$page->setFillColor(new Zend_Pdf_Color_RGB(0, 0, 0));
		$page->drawText(Mage::helper('rma')->__('Type:'), 316, $y_axis, 'UTF-8');
		
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD ), 12); 
		$page->setFillColor(new Zend_Pdf_Color_RGB(0, 0, 0));
		$page->drawText($this->_rmaitem->getType(), 365, $y_axis, 'UTF-8');
		
		if($this->_rmaitem->getReason()) {
			$y_axis -= 16;
			$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_ITALIC), 10); 
			$page->setFillColor(new Zend_Pdf_Color_RGB(0, 0, 0));
			$page->drawText(Mage::helper('rma')->__('Reason for return:'), 52, $y_axis, 'UTF-8');
			
			$y_axis -= 14;
			$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), 10); 
			$page->setFillColor(new Zend_Pdf_Color_RGB(0, 0, 0));
			$text = wordwrap($this->_rmaitem->getReason(), 115, "\n", false);
			$text = rtrim($text, "\n");
			$token = strtok($text, "\n");
			while ($token != false) {
				$page->drawText($token, 52, $y_axis, 'UTF-8');
				$y_axis-=14;
				$token = strtok("\n");
			}
		}
	}
	
	protected function _getRMAItemInfo(Zend_Pdf_Page $page, $y_axis)
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
		$page->drawText(Mage::helper('rma')->__('RMA Item Details'), 52, $y_axis, 'UTF-8');
		
		$y_axis -= 28;
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA ), 12); 
		$page->setFillColor(new Zend_Pdf_Color_RGB(0, 0, 0));
		$page->drawText(Mage::helper('rma')->__('Date Received:'), 52, $y_axis, 'UTF-8');
		
		if($this->_rmaitem->getShippingDate()) {
			$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD ), 12); 
			$page->setFillColor(new Zend_Pdf_Color_RGB(0, 0, 0));
			$page->drawText(Mage::helper('core')->formatDate($this->_rmaitem->getShippingDate(), 'long', false), 140, $y_axis, 'UTF-8');
		}
		
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA ), 12); 
		$page->setFillColor(new Zend_Pdf_Color_RGB(0, 0, 0));
		$page->drawText(Mage::helper('rma')->__('Is Working?'), 326, $y_axis, 'UTF-8');
		
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD ), 12); 
		$page->setFillColor(new Zend_Pdf_Color_RGB(0, 0, 0));
		$page->drawText($this->_rmaitem->getShippingWorking(), 410, $y_axis, 'UTF-8');
		
		$y_axis -= 16;
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA ), 12); 
		$page->setFillColor(new Zend_Pdf_Color_RGB(0, 0, 0));
		$page->drawText(Mage::helper('rma')->__('Box Condition:'), 52, $y_axis, 'UTF-8');
		
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD ), 12); 
		$page->setFillColor(new Zend_Pdf_Color_RGB(0, 0, 0));
		$page->drawText($this->_rmaitem->getShippingBox(), 170, $y_axis, 'UTF-8');
		
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_ITALIC ), 8); 
		$page->setFillColor(new Zend_Pdf_Color_RGB(0, 0, 0));
		$page->drawText(Mage::helper('rma')->__('(1 = Lowest ... 10 = Highest)'), 190, $y_axis, 'UTF-8');
		
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA ), 12); 
		$page->setFillColor(new Zend_Pdf_Color_RGB(0, 0, 0));
		$page->drawText(Mage::helper('rma')->__('Is Complete?'), 326, $y_axis, 'UTF-8');
		
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD ), 12); 
		$page->setFillColor(new Zend_Pdf_Color_RGB(0, 0, 0));
		$page->drawText($this->_rmaitem->getShippingComplete(), 410, $y_axis, 'UTF-8');
		
		$y_axis -= 16;
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA ), 12); 
		$page->setFillColor(new Zend_Pdf_Color_RGB(0, 0, 0));
		$page->drawText(Mage::helper('rma')->__('Package Condition:'), 52, $y_axis, 'UTF-8');
		
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD ), 12); 
		$page->setFillColor(new Zend_Pdf_Color_RGB(0, 0, 0));
		$page->drawText($this->_rmaitem->getShippingPackage(), 170, $y_axis, 'UTF-8');
		
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_ITALIC ), 8); 
		$page->setFillColor(new Zend_Pdf_Color_RGB(0, 0, 0));
		$page->drawText(Mage::helper('rma')->__('(1 = Lowest ... 10 = Highest)'), 190, $y_axis, 'UTF-8');
		
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA ), 12); 
		$page->setFillColor(new Zend_Pdf_Color_RGB(0, 0, 0));
		$page->drawText(Mage::helper('rma')->__('Item Status:'), 326, $y_axis, 'UTF-8');
		
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD ), 12); 
		$page->setFillColor(new Zend_Pdf_Color_RGB(0, 0, 0));
		$page->drawText($this->_rmaitem->getStatus(), 410, $y_axis, 'UTF-8');
	}
	
	protected function _getIncludedBox(Zend_Pdf_Page $page, $y_axis)
	{
		if(strlen(trim($this->_rmaitem->getShippingIncluded())) > 0)
		{
			$array1 = explode("|", $this->_rmaitem->getShippingIncluded());
			$included_array = array();
			foreach($array1 as $arr)
			{
				$arr2 = explode(":", $arr);
				$included_array[$arr2[0]] = $arr2[1];
			}
		}
		
		$page->setFillColor(new Zend_Pdf_Color_GrayScale(0.9)); 
		$page->setLineColor(new Zend_Pdf_Color_GrayScale(0.2)); 
		$page->drawRectangle(42, $y_axis, 570, $y_axis - 25); 
		
		$y_axis -= 18;
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD ), 12); 
		$page->setFillColor(new Zend_Pdf_Color_RGB(0, 0, 0));
		$page->drawText(Mage::helper('rma')->__('Included in the Box'), 52, $y_axis, 'UTF-8');
		
		$y_axis -= 28;
		if (isset($included_array))
		{
			$xme = 52; 
			$yme = $y_axis;
			foreach($included_array as $key => $value)
			{
				$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA ), 12); 
				$page->setFillColor(new Zend_Pdf_Color_RGB(0, 0, 0));
				$page->drawText(' - '. trim($key) . ' (' . $value . ') ' , $xme, $yme, 'UTF-8');
				$yme -= 18;
				if ($yme <= 190) {
					$xme += 150;
					$yme = $y_axis;
				}
			}
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
		
		$text = wordwrap($this->_rmaitem->getShippingRemarks(), 85, "\n", false);
		$token = strtok($text, "\n");
		while ($token != false) {
			$page->drawText($token, 52, $y_axis, 'UTF-8');
			$y_axis-=15;
			$token = strtok("\n");
		}
	}
    
}