<?php
class Mjsi_Rma_Adminhtml_RmaController extends Mage_Adminhtml_Controller_action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('rma/items')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('RMA Manager'), Mage::helper('adminhtml')->__('RMA Manager'));
		
		return $this;
	}   
 
	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}

	public function editAction() {
		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('rma/rma')->load($id);

		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}

			Mage::register('rma_data', $model);

			$this->loadLayout();
			$this->_setActiveMenu('rma/items');

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('RMA Manager'), Mage::helper('adminhtml')->__('RMA Manager'));
			
			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			//$this->_addContent($this->getLayout()->createBlock('rma/adminhtml_rma_edit'))
			//	->_addLeft($this->getLayout()->createBlock('rma/adminhtml_rma_edit_tabs'));

			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('rma')->__('RMA does not exist'));
			$this->_redirect('*/*/');
		}
	}
 
	public function newAction() {
		$this->_forward('edit');
	}
	
	public function verifyAction() 
	{
		$id     = $this->getRequest()->getParam('id');
		$item_id = $this->getRequest()->getParam('item_id');
		$model  = Mage::getModel('rma/rma')->load($id);
		$item_model = Mage::getModel('rma/rma_items')->load($item_id);
		
		if ($model->getId() || $id == 0) {
			//$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			//if (!empty($data)) {
			//	$model->setData($data);
			//}

			Mage::register('rma_data', $model);
			Mage::register('rma_data_item', $item_model);
			$this->loadLayout();
			$this->_setActiveMenu('rma/items');
	
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('RMA Manager'), Mage::helper('adminhtml')->__('Verify RMA Item'));
			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
			
			$this->renderLayout();
		}
		
	}
	
	public function creatermaAction()
	{
		$order_id = $this->getRequest()->getParam('order_id');
		$order_model = Mage::getModel('sales/order')->load($order_id);
		Mage::register( 'rma_order', $order_model ); 
		
		$this->loadLayout();
        $this->renderLayout();
		
	}
	
	public function savenewAction() 
	{
		$order_id = $this->getRequest()->getParam('order_id');	
		$order_model = Mage::getModel('sales/order')->load($order_id);
		
		$model = Mage::getModel( 'rma/rma' ); 
      $model->setOrder( $order_model );
		$model->setContact( $this->getRequest()->get('contact') );
		$model->setStoreId( $order_model->getStoreId() );
		
		$thisRMA_customer_firstName = $order_model->getCustomerFirstname();
		$thisRMA_customer_lastName = $order_model->getCustomerLastname();
		$thisRMA_customer_name = $thisRMA_customer_firstName . " " . $thisRMA_customer_lastName;
		$thisRMA_customer_email = $order_model->getCustomerEmail();
		
		$thisRMA_customer_isguest = $order_model->getCustomerIsGuest();
		
		if( ($thisRMA_customer_isguest == "1") && ($thisRMA_customer_name == " ") ) {$thisRMA_customer_name = "Guest";}
		
		$model->setCustomerName( $thisRMA_customer_name );
		$model->setCustomerEmail( $thisRMA_customer_email );
		
		$items = $this->getRequest()->get( 'items' );
		foreach( $items as $orderItem )
        {
			$rmaItem = Mage::getModel( 'rma/rma_items' );
			$rmaItem->setItemId( $orderItem );
			$rmaItem->setQty( $this->getRequest()->get( 'quantity_' . $orderItem ) );
			$rmaItem->setSerialNumber( $this->getRequest()->get( 'serial_' . $orderItem ) );
			$rmaItem->setReason ( $this->getRequest()->get('reason_' . $orderItem ) );
			$rmaItem->setType ( $this->getRequest()->get('type1_' . $orderItem ) );
			$rmaItem->setStatus ( 'Waiting for Item' ) ;
			$model->addItem( $rmaItem );
        }
		try {
			if ($model->getDateCreated() == NULL || $model->getDateLastupdated() == NULL) {
				$model->setDateCreated(now())
					->setDateLastupdated(now());
			} else {
				$model->setDateLastupdated(now());
			}	
			
			$model->save();
			Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('rma')->__('RMA was successfully saved'));
			Mage::getSingleton('adminhtml/session')->setFormData(false);

			$this->_redirect('*/*/');
			return;
		} catch (Exception $e) {
			Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			Mage::getSingleton('adminhtml/session')->setFormData($data);
			$this->_redirect('*/*/');
			return;
		}
	}
	
	public function sendemailAction() {
		$rmaId = $this->getRequest()->getParam('id');
		$rmamodel = Mage::getModel('rma/rma')->load($rmaId);
		
		if ($data = $this->getRequest()->getPost()) {
			$model = Mage::getModel('rma/rma_emails');
			$model->setRmaId( $rmaId );
			$model->setSubject( $this->getRequest()->get('email_subject') );
			$model->setEmailBody( $this->getRequest()->get('email_body') );
			$model->setDateSent( now() );
			
			$order_model = Mage::getModel('sales/order')->load($rmamodel->getOrderId());
			
			$company_email_name_row = Mage::getSingleton('core/resource')->getConnection('core_read')->fetchAll("SELECT `value` FROM `core_config_data` WHERE `scope`='stores' AND `scope_id`='" . $rmamodel->getStoreId() . "' AND `path`='rma/rma/emailname'");
			if(empty($company_email_name_row))
				{
				$company_email_name_row = Mage::getSingleton('core/resource')->getConnection('core_read')->fetchAll("SELECT `value` FROM `core_config_data` WHERE `scope`='default' AND `scope_id`='0' AND `path`='rma/rma/emailname'");
				}
			$company_email_name = $company_email_name_row[0]['value'];
			
			$company_email_address_row = Mage::getSingleton('core/resource')->getConnection('core_read')->fetchAll("SELECT `value` FROM `core_config_data` WHERE `scope`='stores' AND `scope_id`='" . $rmamodel->getStoreId() . "' AND `path`='rma/rma/emailaddress'");
			if(empty($company_email_address_row))
				{
				$company_email_address_row = Mage::getSingleton('core/resource')->getConnection('core_read')->fetchAll("SELECT `value` FROM `core_config_data` WHERE `scope`='default' AND `scope_id`='0' AND `path`='rma/rma/emailaddress'");
				}
			$company_email_address = $company_email_address_row[0]['value'];
			
			if($rmamodel->getCustomerId() == 0)
				{
				$thisOrderId = $rmamodel->getOrderId();
				$thisOrder = Mage::getModel('sales/order')->load($thisOrderId);
				$customer_email = $thisOrder->getCustomerEmail();
				}
			else
				{
				$customer_model = Mage::getModel('customer/customer')->load($rmamodel->getCustomerId());
				$customer_email = $customer_model->getEmail();
				}
			
			
			$email_subject = $this->getRequest()->get('email_subject');
			$email_body = $this->getRequest()->get('email_body');
			
			$mail = new Zend_Mail();
			$mail->setBodyText($email_body);
			$mail->setFrom($company_email_address, $company_email_name);
			//$mail->setFrom(Mage::getStoreConfig('rma/rma/emailaddress'), Mage::getStoreConfig('rma/rma/emailname'));
			$mail->addTo($customer_email, ' ');
			$mail->setSubject($email_subject);
			
			try {
				if($this->getRequest()->get('send_check')) {
					$mail->send(); 
				}
				$model->save();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('rma')->__('Email Sent to Customer'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
				return;
			}        
			catch(Exception $ex) {
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('rma')->__('Failed to send email to Customer'));
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
				return;
	 		}
		}
		else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('rma')->__('Failed to send email to Customer'));
			$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			return;
		}
		
		$this->loadLayout();
        $this->renderLayout();		
	}
	
	public function saveitemAction() {
		if ($data = $this->getRequest()->getPost()) {
	  			
			$model = Mage::getModel('rma/rma_items');		
			$rmaId = $this->getRequest()->getParam('id');
			$rmaItemId = $this->getRequest()->getParam('item_id');
			$model = Mage::getModel('rma/rma_items')->load($rmaItemId)->addData($data);
			$rmamodel = Mage::getModel('rma/rma')->load($rmaId);
			
			try {
				if ($rmamodel->getDateCreated() == NULL || $rmamodel->getDateLastupdated() == NULL) {
					$rmamodel->setDateCreated(now())
						->setDateLastupdated(now());
				} else {
					$rmamodel->setDateLastupdated(now());
				}	
				
				$model->setShippingIncluded($this->_getIncluded());
				
				$rmamodel->save();
				$model->save();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('rma')->__('Item was successfully verified.'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);

				if ($this->getRequest()->getParam('back')) {
					$this->_redirect('*/*/verify', array('id' => $rmaId, 'item_id' => $rmaItemId));
					return;
				}
				$this->_redirect('*/*/edit', array('id' => $rmaId));
				return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('rma')->__('Unable to find RMA to save'));
        $this->_redirect('*/*/');
	}
	
	public function saveAction() {
		if ($data = $this->getRequest()->getPost()) {
	  			
			$model = Mage::getModel('rma/rma');		
			//$model->setData($data)
			//	->setId($this->getRequest()->getParam('id'));
			$rmaId = $this->getRequest()->getParam('id');
			$model = Mage::getModel('rma/rma')->load($rmaId)->addData($data);
			
			try {
				if ($model->getDateCreated() == NULL || $model->getDateLastupdated() == NULL) {
					$model->setDateCreated(now())
						->setDateLastupdated(now());
				} else {
					$model->setDateLastupdated(now());
				}	
				
				$model->save();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('rma')->__('RMA was successfully saved'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);

				if ($this->getRequest()->getParam('back')) {
					$this->_redirect('*/*/edit', array('id' => $model->getId()));
					return;
				}
				$this->_redirect('*/*/');
				return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('rma')->__('Unable to find RMA to save'));
        $this->_redirect('*/*/');
	}
	
	public function printrmaAction() {
		$rmaId = $this->getRequest()->getParam('id');
		$model = Mage::getModel('rma/rma')->load($rmaId);
		$ordermodel = Mage::getModel('sales/order')->load($model->getOrderId());
		
		$pdf = Mage::getModel('rma/rma_pdf_rma')->getPdf($model);
         return $this->_prepareDownloadResponse('rma_'.Mage::getSingleton('core/date')->date('Y-m-d_H-i-s').'.pdf', $pdf->render(), 'application/pdf');
	}
	
	public function printrmaitemsAction() {
		$rmaId = $this->getRequest()->getParam('id');
		$model = Mage::getModel('rma/rma')->load($rmaId);
		$rmaitemid = $this->getRequest()->getParam('item_id');
		$itemmodel = Mage::getModel('rma/rma_items')->load($rmaitemid);
		
		$pdf = Mage::getModel('rma/rma_pdf_rmaitems')->getPdf($itemmodel);
         return $this->_prepareDownloadResponse('rmareceived_'.Mage::getSingleton('core/date')->date('Y-m-d_H-i-s').'.pdf', $pdf->render(), 'application/pdf');
	}
	
	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('rma/rma');
				 
				$model->setId($this->getRequest()->getParam('id'))
					->delete();
					 
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('RMA was successfully deleted'));
				$this->_redirect('*/*/');
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
		}
		$this->_redirect('*/*/');
	}

    public function massDeleteAction() {
        $rmaIds = $this->getRequest()->getParam('rma');
        if(!is_array($rmaIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select RMA(s)'));
        } else {
            try {
                foreach ($rmaIds as $rmaId) {
                    $rma = Mage::getModel('rma/rma')->load($rmaId);
                    $rma->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($rmaIds)
                    )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
	
    public function massStatusAction()
    {
        $rmaIds = $this->getRequest()->getParam('rma');
        if(!is_array($rmaIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select RMA(s)'));
        } else {
            try {
                foreach ($rmaIds as $rmaId) {
                    $rma = Mage::getSingleton('rma/rma')
                        ->load($rmaId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($rmaIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
  
    public function exportCsvAction()
    {
        $fileName   = 'rma.csv';
        $content    = $this->getLayout()->createBlock('rma/adminhtml_rma_grid')
            ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = 'rma.xml';
        $content    = $this->getLayout()->createBlock('rma/adminhtml_rma_grid')
            ->getXml();

        $this->_sendUploadResponse($fileName, $content);
    }

    protected function _sendUploadResponse($fileName, $content, $contentType='application/octet-stream')
    {
        $response = $this->getResponse();
        $response->setHeader('HTTP/1.1 200 OK','');
        $response->setHeader('Pragma', 'public', true);
        $response->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true);
        $response->setHeader('Content-Disposition', 'attachment; filename='.$fileName);
        $response->setHeader('Last-Modified', date('r'));
        $response->setHeader('Accept-Ranges', 'bytes');
        $response->setHeader('Content-Length', strlen($content));
        $response->setHeader('Content-type', $contentType);
        $response->setBody($content);
        $response->sendResponse();
        die;
    }
	
	protected function _getIncluded()
    {
		$included_string = "";
		
		$rmaId = $this->getRequest()->getParam('id');
		$rmamodel = Mage::getModel('rma/rma')->load($rmaId);
		$storeID = $rmamodel->getStoreId();	
		//Mage::log("Store ID is " . $storeID);
		
		$included_row = Mage::getSingleton('core/resource')->getConnection('core_read')->fetchAll("SELECT `value` FROM `core_config_data` WHERE `scope`='stores' AND `scope_id`='" . $storeID . "' AND `path`='rma/rmaarma2/includedbox'");
		if(empty($included_row))
			{
			$included_row = Mage::getSingleton('core/resource')->getConnection('core_read')->fetchAll("SELECT `value` FROM `core_config_data` WHERE `scope`='default' AND `scope_id`='0' AND `path`='rma/rma2/includedbox'");
			}
		$included = $included_row[0]['value'];
		
		$included_array = array();
		
		if(strlen(trim($included)) > 0)
		{
			$included_array = explode(",", $included);
		}
		
		foreach ($included_array as $key => $incl)
		{
			if ($this->getRequest()->get( 'check_'.$key ))
			{
				$included_string .=  $incl . ":" . $this->getRequest()->get( 'radio_'.$key ). "|";
			}
		}
		$included_string = rtrim($included_string, "|");
		
		return $included_string;
	}
	
	
}