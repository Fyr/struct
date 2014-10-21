<?php
App::uses('AppController', 'Controller');
class AdminController extends AppController {
	public $name = 'Admin';
	public $layout = 'admin';
	// public $components = array();
	public $uses = array();

	public function _beforeInit() {
	    // auto-add included modules - did not included if child controller extends AdminController
	    $this->components = array_merge(array('Auth', 'Core.PCAuth', 'Table.PCTableGrid'), $this->components);
	    $this->helpers = array_merge(array('Html', 'Table.PHTableGrid', 'Form.PHForm'), $this->helpers);
	    
		$this->aNavBar = array(
			// 'Page' => array('label' => __('Static Pages'), 'href' => array('controller' => 'AdminContent', 'action' => 'index', 'Page')),
			// 'News' => array('label' => __('News'), 'href' => array('controller' => 'AdminContent', 'action' => 'index', 'News')),
			'Products' => array('label' => __('Products'), 'href' => '', 'submenu' => array(
				'Types' => array('label' => __('Product types'), 'href' => array('controller' => 'AdminProductTypes', 'action' => 'index')),
				'Products' => array('label' => __('Products'), 'href' => array('controller' => 'AdminProducts', 'action' => 'index')),
			)),
			'Contractors' => array('label' => __('Contractors'), 'href' => array('controller' => 'AdminContractors', 'action' => 'index')),
			'Orders' => array('label' => __('Orders'), 'href' => array('controller' => 'AdminOrders', 'action' => 'index')),
			'Faq' => array('label' => __('FAQ'), 'href' => array('controller' => 'AdminFaq', 'action' => 'index')),
			// 'slider' => array('label' => __('Slider'), 'href' => array('controller' => 'AdminSlider', 'action' => 'index')),
			// 'settings' => array('label' => __('Settings'), 'href' => array('controller' => 'AdminSettings', 'action' => 'index'))
		);
		$this->aBottomLinks = $this->aNavBar;
	}
	
	public function beforeFilter() {
	    $this->currMenu = $this->_getCurrMenu();
	    $this->currLink = $this->currMenu;
	}
	
	public function beforeRender() {
		parent::beforeRender();
		$this->set('isAdmin', $this->isAdmin());
	}
	
	public function isAdmin() {
		return AuthComponent::user('id') == 1;
	}

	public function index() {
		// $this->redirect(array('controller' => 'AdminProducts'));
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
