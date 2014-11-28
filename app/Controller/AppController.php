<?php
App::uses('Controller', 'Controller');
class AppController extends Controller {
	public $paginate;
	public $pageTitle = '';
	
	public $uses = array('User', 'Media.Media');
	public $helpers = array('Html', 'Form');
	public $components = array(
		'Session',
		'Auth' => array(
			'authorize'      => array('Controller'),
			'loginAction'    => array('controller' => 'Users', 'action' => 'login'),
			'loginRedirect'  => array('controller' => 'Profile', 'action' => 'edit'),
			'logoutRedirect' => '/',
			'authError'      => 'You must log in access that page'
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
	}
	
	protected function _initTimezone($timezone) {
		date_default_timezone_set(($timezone) ? $timezone : 'UTC');
		$this->User->query('SET `time_zone`= "'.date('P').'"');
	}
	
	protected function _initLang($lang) {
		$lang = ($lang == 'rus') ? $lang : 'eng';
		Configure::write('Config.language', $lang);
	}
	
	protected function _checkAuth() {
		if (!$this->Auth->loggedIn()) {
			fdebug('!!!');
			return $this->redirect('/');
		}
		$this->currUserID = $this->Auth->user('id');
		$this->currUser = $this->Auth->user();
		$this->_initTimezone($this->Auth->user('timezone'));
		$this->_initLang($this->Auth->user('lang'));
		
		if (TEST_ENV) {
			fdebug($this->currUser, 'curr_user.log', false);
		}
		
		$this->set('balance', '0');
		$this->set('PU_', '$');
		$this->set('_PU', '');
		
		$this->set('currUser', $this->currUser);
		$this->set('currUserID', $this->currUserID);
		$this->set('pageTitle', $this->pageTitle);
	}
}
