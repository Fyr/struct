<?php
App::uses('AppController', 'Controller');
class UsersController extends AppController {
	public $name = 'Users';
	public $layout = 'home';
	
	public function register() {
		if ($this->request->is('put') || $this->request->is('post')) {
			$this->request->data('ChatUser.user_group_id', 2);
			if ( !(isset($_COOKIE['tzo']) && isset($_COOKIE['tzd'])) ) {
				exit('Sorry, your browser must support Cookies and Javascript');
			}
			$timezone = timezone_name_from_abbr('', -$_COOKIE['tzo'] * 60, $_COOKIE['tzd']);
			$this->request->data('User.timezone', $timezone);
			if ($this->User->save($this->request->data('User'))) {
				$this->Auth->login();
				return $this->redirect($this->Auth->redirect());
			}
		}
	}
	
	public function login() {
		if ($this->request->is('post')) {
			if ($this->Auth->login()) {
				if ( !(isset($_COOKIE['tzo']) && isset($_COOKIE['tzd'])) ) {
					exit('Sorry, your browser must support Cookies and Javascript');
				}
				$timezone = timezone_name_from_abbr('', -$_COOKIE['tzo'] * 60, $_COOKIE['tzd']);
				$this->User->save(array('id' => $this->Auth->user('id'), 'timezone' => $timezone));
				return $this->redirect($this->Auth->redirect());
			} else {
				$this->Session->setFlash(AUTH_ERROR, null, null, 'auth');
			}
		}
	}
	
	public function logout() {
		$this->redirect($this->Auth->logout());
	}

}
