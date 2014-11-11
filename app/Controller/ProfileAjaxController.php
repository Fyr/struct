<?php
App::uses('AppController', 'Controller');
App::uses('PAjaxController', 'Core.Controller');
class ProfileAjaxController extends PAjaxController {
	public $name = 'ProfileAjax';
	public $uses = array('Profile', 'ChatUser', 'Group');
	public $helpers = array('Media');
	
	public function beforeFilter() {
		parent::beforeFilter();
		$this->_checkAuth();
	}
	
	public function jsSettings() {
	}
	
	public function panel() {
		$q = $this->request->data('q');
		if ($q) {
			$this->set('aUsers', $this->ChatUser->search($this->currUserID, $q));
			$this->set('aGroups', $this->Group->search($this->currUserID, $q));
		}
		
	}
}
