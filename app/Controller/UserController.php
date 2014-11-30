<?php
App::uses('AppController', 'Controller');
class UserController extends AppController {
	public $name = 'User';
	public $layout = 'profile';
	public $uses = array('Timezone', 'Country');
	
	public function register() {
		$this->layout = 'home';
		if ($this->request->is('put') || $this->request->is('post')) {
			$this->request->data('User.user_group_id', 2);
			if ( !(isset($_COOKIE['tzo']) && isset($_COOKIE['tzd'])) ) {
				exit('Sorry, your browser must support Cookies and Javascript');
			}
			$timezone = timezone_name_from_abbr('', -$_COOKIE['tzo'] * 60, $_COOKIE['tzd']);
			$this->request->data('User.timezone', $timezone);
			// $this->request->data('User.full_name', $this->request->data('User.username'));
			if ($this->User->save($this->request->data('User'))) {
				$this->Auth->login();
				return $this->redirect($this->Auth->redirect());
			}
		}
	}
	
	public function login() {
		$this->layout = 'home';
		if ($this->request->is('post')) {
			if ($this->Auth->login()) {
				return $this->redirect($this->Auth->redirect());
			} else {
				$this->Session->setFlash(AUTH_ERROR, null, null, 'auth');
			}
		}
	}
	
	public function logout() {
		$this->redirect($this->Auth->logout());
	}

	public function index() {
		return $this->redirect(array('controller' => 'Timeline', 'action' => 'index'));
	}
	
	public function edit() {
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->request->data('User.user_id', $this->currUserID);
			if ($this->request->data('UserAchievement')) {
				foreach($this->request->data('UserAchievement') as $i => $data) {
					$this->request->data('UserAchievement.'.$i.'.url', 
						(strpos($data['url'], 'http://') !== false) ? 'http://'.$data['url'] : $data['url']
					);
				}
			}
			$this->User->saveAll($this->request->data);
			return $this->redirect(array('controller' => $this->name, 'action' => 'edit', '?' => array('success' => '1')));
		} else {
			$this->request->data = $this->currUser;
		}
		
		$this->set('aTimezoneOptions', $this->Timezone->options());
		$this->set('aCountryOptions', $this->Country->options());
	}

	public function view($id = 0) {
		$this->loadModel('GroupMember');
		if (!$id) {
			$id = $this->currUserID;
		}
		$this->set('user', $this->User->getUser($id));
		$this->set('aGroups', $this->GroupMember->getUserGroups($id));
		$this->set('aCountryOptions', $this->Country->options());
	}
}
