<?php
App::uses('AppController', 'Controller');
App::uses('PAjaxController', 'Core.Controller');
class ProfileAjaxController extends PAjaxController {
	public $name = 'ProfileAjax';
	public $uses = array('Profile', 'ChatUser');
	public $helpers = array('Media');
	
	private $profile;
	
	public function beforeFilter() {
		parent::beforeFilter();
		$this->_checkAuth();
		$this->set('currUserID', $this->currUserID);
		$this->profile = $this->Profile->findByUserId($this->currUserID);
		$this->set('profile', $this->profile);
	}
	
	public function jsSettings() {
	}
	
	public function panel() {
		$aUsers = array();
		$q = $this->request->data('q');
		if ($q) {
			$aUsers = $this->ChatUser->search($this->currUserID, $q);
		}
		$this->set('aUsers', $aUsers);
	}
}
