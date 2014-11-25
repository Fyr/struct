<?php
App::uses('Controller', 'Controller');
class AppController extends Controller {
	public $paginate;
	public $pageTitle = '';
	
	public $uses = array('ChatUser', 'Profile');
	public $helpers = array('Html', 'Form');
	public $components = array('Auth' => array(
			'authorize'      => array('Controller'),
			'loginAction'    => array('controller' => 'Users', 'action' => 'login'),
			'loginRedirect'  => array('controller' => 'Profile', 'action' => 'index'),
			'logoutRedirect' => '/',
			'authError'      => "You cannot access that page"
		),
	);
	
	protected $currUser = array(), $currUserID, $profile, $user;
	
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
	/* Перестает работать загрузка моделей из uses :(
	public function loadModel($models) {
		if (!is_array($models)) {
			$models = array($models);
		}
		foreach($models as $model) {
			parent::loadModel($model);
		}
	}
	*/
	
	public function isAuthorized($user) {
		return true;
	}
	
	public function beforeFilter() {
		$this->Auth->allow(array('index', 'register', 'login'));
		// fdebug($this->Auth->user(), 'auth_user.log');
		// $this->_checkAuth();
	}
	
	protected function _checkAuth() {
		/*
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
		*/
		if (!$this->Auth->loggedIn()) {
			return $this->redirect('/');
		}
		$this->currUserID = $this->Auth->user('id');
		
		$this->loadModel('ChatUser');
		$this->loadModel('Profile');
		$this->currUser = $this->ChatUser->getUser($this->currUserID);
		
		$this->profile = $this->Profile->findByUserId($this->currUserID);
		$timezone = Hash::get($this->profile, 'Profile.timezone');
		date_default_timezone_set(($timezone) ? $timezone : 'UTC');
		$this->Profile->query('SET `time_zone`= "'.date('P').'"');
		
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
