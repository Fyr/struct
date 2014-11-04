<?php
App::uses('AppController', 'Controller');
App::uses('SiteController', 'Controller');
class SiteOrdersController extends SiteController {
	public $name = 'SiteOrders';
	public $uses = array('ProductType', 'Contractor', 'Order', 'OrderType');
	
	public function index() {
		
	}

	public function checkout($productTypeID = 1) {
		
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->request->data('Contractor')) {
				$this->request->data('Contractor.id', $this->currUserID);
				if ($this->Contractor->save($this->request->data('Contractor'))) {
					// Save order
					$_data = $this->request->data;
					unset($_data['Contractor']);
					$orderID = 0;
					foreach($_data as $i => $data) {
						$data['Order']['contractor_id'] = $this->currUserID;
						if ($orderID) {
							$data['Order']['parent_order_id'] = $orderID;
						}
						$this->Order->clear();
						$this->Order->save($data['Order']);
						if (!$orderID) {
							$orderID = $this->Order->id;
						}
						
						// Save order product types
						$data['OrderType']['order_id'] = $this->Order->id;
						$this->OrderType->clear();
						$this->OrderType->save($data['OrderType']);
					}
					
					return $this->redirect(array('controller' => 'SiteOrders', 'action' => 'orders'));
				}
			} else { // get data prom panel
				
			}
		}
		
		if (!$this->request->data('Contractor')) {
			$contractor = $this->Contractor->findById($this->currUserID);
			if ($contractor) {
				$this->request->data('Contractor', $contractor['Contractor']);
			}
		}
		
		$this->set('aProductTypes', $this->ProductType->find('all'));
		$this->pageTitle = __('New order');
	}
	
	public function orders() {
		$aOrders = $this->Order->findAllByContractorId($this->currUserID);
		$this->set('aOrders', $aOrders);
		$aProductTypeOptions = $this->ProductType->find('all');
		$this->set('aProductTypeOptions', Hash::combine($aProductTypeOptions, '{n}.ProductType.id', '{n}'));
		$this->pageTitle = __('My orders');
	}
	
	public function recharge() {
		$this->pageTitle = __('Recharge balance');
	}
}
