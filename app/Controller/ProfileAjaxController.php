<?php
App::uses('AppController', 'Controller');
App::uses('PAjaxController', 'Core.Controller');
class ProfileAjaxController extends PAjaxController {
	public $name = 'ProfileAjax';
	public $uses = array('Profile', 'ChatUser', 'Group');
	public $helpers = array('Media');
	
	private $profile;
	
	public function beforeFilter() {
		parent::beforeFilter();
		$this->_checkAuth();
		$this->set('currUserID', $this->currUserID);
		$this->profile = $this->Profile->findByUserId($this->currUserID);
		$this->set('profile', $this->profile);
	}
	
	public function jsSettings() {
	}
	
	public function panel() {
		$aUsers = array();
		$q = $this->request->data('q');
		if ($q) {
			
			$aID = array();
			$fields = 'ChatUser.id, ChatUser.username';
			$conditions = array(
				'ChatUser.id <> '.$this->currUserID,
				'AND' => array(
					'OR' => array(
						// array('ChatUserData.full_name LIKE ?' => '%'.$q.'%'),
						array('ChatUser.username LIKE ?' => '%'.$q.'%'),
						array('Profile.skills LIKE ?' => '%'.$q.'%'),
						// array('Profile.live_place LIKE ?' => '%'.$q.'%'),
						array('Group.title LIKE ?' => '%'.$q.'%'),
					)
				)
			);
			$joins = array(
				array('type' => 'left', 'table' => $this->Profile->getTableName(), 'alias' => 'Profile', 'conditions' => array('Profile.user_id = ChatUser.id')),
				array('type' => 'left', 'table' => $this->Group->getTableName(), 'alias' => 'Group', 'conditions' => array('Group.owner_id = ChatUser.id'))
			);
			$order = array('ChatUser.username');
			$aUsers = $this->ChatUser->find('all', compact('fields', 'conditions', 'order', 'joins'));
			$aID = Hash::extract($aUsers, '{n}.ChatUser.id');
			
			// get all user except current
			if ($aID) {
				$aUsers = $this->ChatUser->getUsers($aID);
			}
		}
		$this->set('aUsers', $aUsers);
	}
}
