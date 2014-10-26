<?php
App::uses('Controller', 'Controller');
class AppController extends Controller {
    public $paginate;
	public $pageTitle = '';
    
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
	}
}