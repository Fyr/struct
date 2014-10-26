<?php
App::uses('AppController', 'Controller');
App::uses('SiteController', 'Controller');
class SiteOrdersController extends SiteController {
	public $name = 'SiteOrders';
	public $uses = array('ProductType', 'Contractor', 'Order', 'OrderType');
	
	public function index() {
		
	}

	public function checkout($productTypeID) {
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->request->data('Contractor.id', $this->currUserID);
			if ($this->Contractor->save($this->request->data)) {
				// Save order
				$this->request->data('Order.contractor_id', $this->currUserID);
				$this->Order->save($this->request->data('Order'));
				
				// Save order product types
				$this->request->data('OrderType.order_id', $this->Order->id);
				$this->request->data('OrderType.product_type_id', $productTypeID);
				$this->OrderType->save($this->request->data('OrderType'));
				return $this->redirect(array('controller' => 'SiteOrders', 'action' => 'orders'));
			}
		} else {
			$contractor = $this->Contractor->findById($this->currUserID);
			if ($contractor) {
				$this->request->data('Contractor', $contractor['Contractor']);
			}
		}
		
		$this->set('productType', $this->ProductType->findById($productTypeID));
	}
	
	public function orders() {
		$aOrders = $this->Order->findAllByContractorId($this->currUserID);
		$this->set('aOrders', $aOrders);
		$this->set('aProductTypeOptions', $this->ProductType->find('list'));
	}
	
	public function recharge() {
		
	}
}
