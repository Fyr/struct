<?php
App::uses('AppController', 'Controller');
App::uses('PAjaxController', 'Core.Controller');
class SiteAjaxController extends PAjaxController {
	public $name = 'SiteAjax';
	public $uses = array('ProductType');
	public $helpers = array('Media');
	
	public function beforeFilter() {
		if (TEST_ENV) {
			$this->currUserID = $this->Session->read('currUser.id');
		} else {
			$this->loadModel('ClientProject');
			$userData = ClientProject::getUserAuthData();
			$this->currUserID = Hash::get($userData, 'user_id');
		}
		if (!$this->currUserID) {
			$this->autoRender = false;
			exit('You must be authorized');
		}
		$this->currUser = $this->ChatUser->getUser($this->currUserID);
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
