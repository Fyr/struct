<?php
App::uses('AppController', 'Controller');
App::uses('PAjaxController', 'Core.Controller');
class SiteAjaxController extends PAjaxController {
	public $name = 'SiteAjax';
	public $uses = array('ProductType');
	public $helpers = array('Media');
	
	public function beforeRender() {
		parent::beforeRender();
		$this->set('PU_', '$');
		$this->set('_PU', '');
	}
	
	public function deviceList() {
		$aDevices = $this->ProductType->find('all');
		$this->set('aDevices', $aDevices);
	}
}
