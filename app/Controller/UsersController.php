<?php
App::uses('AppController', 'Controller');
class UsersController extends AppController {
	public $name = 'Users';
	public $layout = 'home';
	public $uses = array('User', 'ChatUser');
	
	public function register() {
		if ($this->request->is('put') || $this->request->is('post')) {
			$this->request->data('ChatUser.user_group_id', 2);
			if ($this->ChatUser->save($this->request->data('ChatUser'))) {
				$user = $this->ChatUser->findById($this->ChatUser->id);
				$this->Auth->login($user['ChatUser']);
				return $this->redirect($this->Auth->redirect());
			}
		}
	}
	
	public function login() {
		if ($this->request->is('post')) {
			if ($this->Auth->login()) {
				return $this->redirect($this->Auth->redirect());
			} else {
				$this->set('authError', AUTH_ERROR);
			}
		}
	}
	
	public function logout() {
		$this->redirect($this->Auth->logout());
	}

}
