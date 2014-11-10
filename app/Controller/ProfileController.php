<?php
App::uses('AppController', 'Controller');
App::uses('SiteController', 'Controller');
class ProfileController extends SiteController {
	public $name = 'Profile';
	public $layout = 'profile';
	public $uses = array('Profile', 'ChatUserData');
	public $helpers = array('Media');
	
	private $profile;
	
	public function beforeFilter() {
		parent::beforeFilter();
		$this->profile = $this->Profile->findByUserId($this->currUserID);
		$this->set('profile', $this->profile);
	}
	
	public function edit() {
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->request->data('Profile.user_id', $this->currUserID);
			$this->Profile->save($this->request->data);
			
			$this->request->data('ChatUserData.user_id', $this->currUserID);
			$this->request->data('ChatUserData.full_name', $this->request->data('Profile.full_name'));
			$this->ChatUserData->save($this->request->data);
			return $this->redirect(array('controller' => $this->name, 'action' => 'edit', '?' => array('success' => '1')));
		} else {
			$this->request->data = $this->profile;
		}
	}

	public function view($id = 0) {
		if (!$id) {
			$id = $this->currUserID;
		}
		$this->set('user', $this->ChatUser->getUser($id));
	}
	
}
