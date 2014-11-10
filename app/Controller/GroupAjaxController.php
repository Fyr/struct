<?php
App::uses('AppController', 'Controller');
App::uses('PAjaxController', 'Core.Controller');
class GroupAjaxController extends PAjaxController {
	public $name = 'GroupAjax';
	public $uses = array('Profile', 'Group');
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
		// Exclude current user from list
		$aGroups = $this->Group->find('all');
		$this->set('aGroups', $aGroups);
	}
	
}
