<?php
App::uses('AppController', 'Controller');
class AdminController extends AppController {
	public $name = 'Admin';
	public $layout = 'admin';
	// public $components = array();
	public $uses = array();
	
	protected $aNavBar = array(), $aBottomLinks = array(), $currMenu = '', $currLink = '';

	public function _beforeInit() {
	    // auto-add included modules - did not included if child controller extends AdminController
	    $this->components = array_merge(array('Auth', 'Core.PCAuth', 'Table.PCTableGrid'), $this->components);
	    $this->helpers = array_merge(array('Html', 'Table.PHTableGrid', 'Form.PHForm'), $this->helpers);
	    
		$this->aNavBar = array(
			'Products' => array('label' => __('Products'), 'href' => '', 'submenu' => array(
				'Types' => array('label' => __('Product types'), 'href' => array('controller' => 'AdminProductTypes', 'action' => 'index')),
				'Products' => array('label' => __('Products'), 'href' => array('controller' => 'AdminProducts', 'action' => 'index')),
			)),
			'Contractors' => array('label' => __('Contractors'), 'href' => array('controller' => 'AdminContractors', 'action' => 'index')),
			'Orders' => array('label' => __('Orders'), 'href' => array('controller' => 'AdminOrders', 'action' => 'index')),
			'Faq' => array('label' => __('FAQ'), 'href' => array('controller' => 'AdminFaq', 'action' => 'index')),
		);
		$this->aBottomLinks = $this->aNavBar;
	}
	
	public function isAuthorized($user) {
		$this->set('currUser', $user);
		if (!Hash::get($user, 'is_admin')) {
			$this->redirect($this->Auth->loginAction);
			return false;
		}
		return true;// Hash::get($user, 'is_admin');
	}
	
	public function beforeFilter() {
	    $this->currMenu = $this->_getCurrMenu();
	    $this->currLink = $this->currMenu;
	}
	
	public function beforeRender() {
		$this->set('aNavBar', $this->aNavBar);
		$this->set('currMenu', $this->currMenu);
		$this->set('aBottomLinks', $this->aBottomLinks);
		$this->set('currLink', $this->currLink);
		$this->set('pageTitle', $this->pageTitle);
		$this->set('isAdmin', $this->isAdmin());
	}
	
	public function isAdmin() {
		return AuthComponent::user('id') == 1;
	}

	public function index() {
		$this->loadModel('User');
		$this->loadModel('Country');
		
		$fields = array('User.live_country', 'COUNT(*) AS count');
		$order = array('User.live_country');
		$group = array('User.live_country');
		$aStats = $this->User->find('all', compact('fields', 'conditions', 'order', 'group'));
		
		$conditions = $this->User->dateTimeRange('User.created', date('Y-m-d H:i:s', time() - DAY), date('Y-m-d H:i:s'));
		$aStatsToday = $this->User->find('all', compact('fields', 'conditions', 'order', 'group'));
		
		$aCountryOptions = $this->Country->options();
		$this->set(compact('aStats', 'aStatsToday', 'aCountryOptions'));
	}
	
	protected function _getCurrMenu() {
		$curr_menu = strtolower(str_ireplace('Admin', '', $this->request->controller)); // By default curr.menu is the same as controller name
		foreach($this->aNavBar as $currMenu => $item) {
			if (isset($item['submenu'])) {
				foreach($item['submenu'] as $_currMenu => $_item) {
					if (strtolower($_currMenu) === $curr_menu) {
						return $currMenu;
					}
				}
			}
		}
		return $curr_menu;
	}

	public function delete($id) {
		$this->autoRender = false;

		$model = $this->request->query('model');
		if ($model) {
			$this->loadModel($model);
			if (strpos($model, '.') !== false) {
				list($plugin, $model) = explode('.',$model);
			}
			$this->{$model}->delete($id);
		}
		if ($backURL = $this->request->query('backURL')) {
			$this->redirect($backURL);
			return;
		}
		$this->redirect(array('controller' => 'Admin', 'action' => 'index'));
	}
	
}
