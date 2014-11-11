<?php
App::uses('Controller', 'Controller');
class AppController extends Controller {
	public $paginate;
	public $pageTitle = '';
	
	public $uses = array('ChatUser', 'Profile');
	public $helpers = array('Html', 'Form');
	
	protected $currUser = array(), $currUserID, $profile;
	
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
		$this->profile = $this->Profile->findByUserId($this->currUserID);
		$lang = Hash::get($this->profile, 'Profile.lang');
		$lang = ($lang == 'rus') ? $lang : 'eng';
		Configure::write('Config.language', $lang);
		if (TEST_ENV) {
			fdebug($this->currUser, 'curr_user.log', false);
		}
		
		$this->set('balance', '0');
		$this->set('PU_', '$');
		$this->set('_PU', '');
		
		$this->set('currUser', $this->currUser);
		$this->set('currUserID', $this->currUserID);
		$this->set('profile', $this->profile);
		$this->set('pageTitle', $this->pageTitle);
	}
}
