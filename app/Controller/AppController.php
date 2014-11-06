<?php
App::uses('Controller', 'Controller');
class AppController extends Controller {
	public $paginate;
	public $pageTitle = '';
	
	public $uses = array('ChatUser');
	public $helpers = array('Html', 'Form');
	
	protected $currUser = array(), $currUserID;
	
	public function __construct($request = null, $response = null) {
		$this->_beforeInit();
		parent::__construct($request, $response);
		$this->_afterInit();
	}
	
	protected function _beforeInit() {
	    // Add here components, models, helpers etc that will be also loaded while extending child class
	}

	protected function _afterInit() {
	    // after construct actions here
	}
	
	public function isAuthorized($user) {
    	$this->set('currUser', $user);
		return Hash::get($user, 'active');
	}
	
	public function beforeRender() {
		$this->set('balance', '0');
		$this->set('PU_', '$');
		$this->set('_PU', '');
		
		$this->set('currUser', $this->currUser);
		$this->set('currUserID', $this->currUserID);
		
		$this->set('pageTitle', $this->pageTitle);
	}
	
	protected function _checkAuth() {
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
}
