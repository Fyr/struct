<?php
App::uses('AppModel', 'Model');
class ChatUser extends AppModel {
	public $useDbConfig = 'users';
	public $useTable = 'clients';
	public $primaryKey = 'id';
	
	public $hasOne = array(
		'ChatUserData' => array(
			'foreignKey' => 'user_id'
		)
	);
	
	protected $ChatEvent, $Profile, $Media;
	
	protected function _initUserData($user) {
		// $user['ChatUser']['name'] = (trim($user['ChatUserData']['full_name'])) ? $user['ChatUserData']['full_name'] : $user['ChatUser']['username'];
		// $user['Avatar']['url'] = (trim($user['ChatUserData']['avatar'])) ? $user['ChatUserData']['avatar'] : '/img/no-photo.jpg';

		$user['ChatUser']['name'] = $user['ChatUser']['username'];
		
		$this->loadModel(array('Profile', 'Media.Media'));
		$profile = $this->Profile->findByUserId($user['ChatUser']['id']);
		if ($profile) {
			$user = array_merge($user, $profile);
		}
		if ($profile && isset($profile['Media']) && Hash::get($profile, 'Media.id')) {
			$row = $profile['Media'];
			$src = $this->Media->getPHMedia()->getImageUrl($row['object_type'], $row['id'], '90x', $row['file'].$row['ext']);
		} else {
			$src = '/img/no-photo.jpg';
		}
		$user['Avatar']['url'] = $src;
		return $user;
	}

	public function getUser($id) {
		$user = $this->findById($id);
		return $this->_initUserData($user);
	}
	
	public function getContactListUsers($currUserID) {
		$this->loadModel('ChatEvent');
		
		$aActiveRooms = $this->ChatEvent->getActiveRooms($currUserID);
		foreach($aActiveRooms as &$user) {
			$user = array_merge($user, $this->getUser($user['ChatEvent']['initiator_id']));
			$user['ChatEvent']['count'] = $user[0]['count'];
			unset($user[0]);
		}
		
		$aUserID = Hash::extract($aActiveRooms, '{n}.ChatUser.id');
		$conditions = array('NOT' => array($this->primaryKey => $aUserID));
		$aUsers = $this->find('all', compact('conditions'));
		foreach($aUsers as $i => &$user) {
			$userID = $user['ChatUser'][$this->primaryKey];
			if ($userID != $currUserID) {
				$user = $this->_initUserData($user);
			} else {
				unset($aUsers[$i]);
			}
		}
		return array_merge($aActiveRooms, $aUsers);
	}
	
	public function getUsers($aID = array()) {
		if ($aID) {
			$aUsers = $this->findAllById($aID);
		} else {
			$aUsers = $this->find('all');
		}
		foreach($aUsers as $i => &$user) {
			$user = $this->_initUserData($user);
		}
		return $aUsers;
	}
}
