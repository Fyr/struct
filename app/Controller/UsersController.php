<?php
App::uses('AppController', 'Controller');
class UsersController extends AppController {
	public $name = 'Users';
	public $layout = 'home';
	public $uses = array('User', 'ChatUser', 'Profile');
	
	public function register() {
		if ($this->request->is('put') || $this->request->is('post')) {
			$this->request->data('ChatUser.user_group_id', 2);
			if ( !(isset($_COOKIE['tzo']) && isset($_COOKIE['tzd'])) ) {
				exit('Sorry, your browser must support Cookies and Javascript');
			}
			if ($this->ChatUser->save($this->request->data('ChatUser'))) {
				$timezone = timezone_name_from_abbr('', -$_COOKIE['tzo'] * 60, $_COOKIE['tzd']);
				$this->Profile->save(array('user_id' => $this->ChatUser->id, 'timezone' => $timezone));
				$user = $this->ChatUser->findById($this->ChatUser->id);
				$this->Auth->login($user['ChatUser']);
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
				$user = $this->ChatUser->findByUsername($this->request->data('User.username'));
				$profile = $this->Profile->findByUserId($user['ChatUser']['id']);
				$this->Profile->save(array('id' => Hash::get($profile, 'Profile.id'), 'user_id' => $user['ChatUser']['id'], 'timezone' => $timezone));
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
