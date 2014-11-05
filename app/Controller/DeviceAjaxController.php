<?php
App::uses('AppController', 'Controller');
App::uses('PAjaxController', 'Core.Controller');
class DeviceAjaxController extends PAjaxController {
	public $name = 'DeviceAjax';
	public $uses = array('ProductType');
	public $helpers = array('Media');
	
	public function beforeFilter() {
		parent::beforeFilter();
		$this->_checkAuth();
	}
	
	public function beforeRender() {
		parent::beforeRender();
		$this->set('balance', 148);
		$this->set('PU_', '$');
		$this->set('_PU', '');
		
		$this->set('currUser', $this->currUser);
		$this->set('currUserID', $this->currUserID);
	}
	
	public function jsSettings() {
	}
	
	public function deviceList() {
		$aDevices = $this->ProductType->find('all');
		$this->set('aDevices', $aDevices);
	}
	
	public function panel() {
		$this->deviceList();
	}
}
