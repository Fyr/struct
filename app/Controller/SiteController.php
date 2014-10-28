<?php
App::uses('AppController', 'Controller');
class SiteController extends AppController {
	public $name = 'Site';
	
	protected $currUserID, $currUser;
	
	public function _beforeInit() {
		// $this->components = array_merge(array('Table.PCTableGrid'), $this->components);
	    $this->helpers = array_merge(array('Html', 'Form', 'Core.PHTime', 'Media'), $this->helpers);
	    // $this->uses = array_merge(array('Settings', 'Media.Media'), $this->uses);
	}
	
	/*
	public function _afterInit() {
		// $this->Settings->initData();
	}
	
	public function beforeFilter() {
	}
	
	*/
	public function isAuthorized($user) {
		return true;
	}
	
	public function beforeFilter() {
		$userID = Hash::get($this->request->params, 'pass.0');
		$action = Hash::get($this->request->params, 'action');
		if ($userID && $action == 'auth') {
			$this->Session->write('currUser.id', $userID);
			$this->redirect('/');
			return false;
		}
		$this->currUserID = $this->Session->read('currUser.id');
		if (!$this->currUserID) {
			$this->autoRender = false;
			exit('You must be authorized');
		}
		$this->loadModel('ChatUser');
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
}
