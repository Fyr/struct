<?php
App::uses('AppModel', 'Model');
class User extends AppModel {
	// public $useDbConfig = 'users';
	public $useTable = 'clients';
	// public $primaryKey = 'id';
	
	public $hasOne = array(
		'UserData' => array(
			'foreignKey' => 'user_id'
		)
	);
	/*
	public $validate = array(
		'username' => array(
			'checkNotEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'Field is mandatory',
			),
			'checkEmail' => array(
				'rule' => 'email',
				'message' => 'Email is incorrect'
			),
			'checkIsUnique' => array(
				'rule' => 'isUnique',
				'message' => 'This email has already been used'
			)
		),
		'password' => array(
			'checkNotEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Field is mandatory'
			),
			'checkPswLen' => array(
				'rule' => array('between', 4, 15),
				'message' => 'The password must be between 4 and 15 characters'
			),
		),
	);
	*/
	protected $ChatEvent, $ChatRoom, $Profile, $Media, $Group;
	
	/*
	public function beforeValidate($options = array()) {
		if (Hash::get($options, 'validate')) {
			if (!Hash::get($this->data, 'User.password')) {
				$this->validator()->remove('password');
				$this->validator()->remove('password_confirm');
			}
		}
	}

	public function beforeSave($options = array()) {
		if (isset($this->data['User']['password'])) {
			$this->data['User']['password'] = AuthComponent::password($this->data['User']['password']);
		}
		return true;
	}
	*/
	protected function _initUserData($user) {
		$user['User']['full_name'] = (trim($user['UserData']['full_name'])) ? $user['UserData']['full_name'] : $user['User']['username'];
		// $user['Media']['url_img'] = (trim($user['UserData']['avatar'])) ? $user['UserData']['avatar'] : '/img/no-photo.jpg';

		// $user['User']['full_name'] = $user['User']['username'];
		
		$this->loadModel(array('Profile', 'Media.Media'));
		$profile = $this->Profile->findByUserId($user['User']['id']);
		if ($profile) {
			$user = array_merge($user, $profile);
		}
		if ($profile && isset($profile['Media']) && Hash::get($profile, 'Media.id')) {
			$row = $profile['Media'];
			$src = $this->Media->getPHMedia()->getImageUrl($row['object_type'], $row['id'], 'thumb180x180', $row['file'].$row['ext']);
		} else {
			$src = '/img/no-photo.jpg';
		}
		$user['Media']['url_img'] = $src;
		return $user;
	}

	public function getUser($id) {
		$user = $this->findById($id);
		return $this->_initUserData($user);
	}
	
	public function getContactListUsers($currUserID) {
		$this->loadModel(array('ChatEvent', 'ChatRoom'));
		
		$aActiveRooms = $this->ChatEvent->getActiveRooms($currUserID);
		$aID = Hash::extract($aActiveRooms, '{n}.ChatEvent.initiator_id');
		$aUsers = $this->getUsers($aID);
		$aUsers = Hash::combine($aUsers, '{n}.User.id', '{n}');
		foreach($aActiveRooms as &$user) {
			$user_id = Hash::get($user, 'ChatEvent.initiator_id');
			$user = array_merge($user, $aUsers[$user_id]);
			$user['ChatEvent']['count'] = $user[0]['count'];
			unset($user[0]);
		}
		
		// get also inactive rooms for panel
		$rooms = $this->ChatRoom->getRoomsWithUser($currUserID);
		$aID2 = array();
		foreach($rooms as $room) {
			$user_id = $room['ChatRoom']['initiator_id'];
			if ($user_id != $currUserID && !in_array($user_id, $aID)) {
				$aID2[] = $user_id;
			}
			$user_id = $room['ChatRoom']['recipient_id'];
			if ($user_id != $currUserID && !in_array($user_id, $aID)) {
				$aID2[] = $user_id;
			}
		}
		
		return array_merge($aActiveRooms, $this->getUsers($aID2));
	}
	
	public function getUsers($aID = array()) {
		$aUsers = array();
		if ($aID) {
			$fields = array('User.id', 'User.username', 'UserData.full_name');
			$conditions = array('id' => $aID);
			$aUsers = $this->find('all', compact('fields', 'conditions'));
		}
		foreach($aUsers as $i => &$user) {
			$user = $this->_initUserData($user);
		}
		return $aUsers;
	}
	
	public function search($currUserID, $q) {
		$this->loadModel('Profile');
		$fields = 'User.id, User.username';
		$conditions = array(
			'User.id <> '.$currUserID,
			'AND' => array(
				'OR' => array(
					array('UserData.full_name LIKE ?' => '%'.$q.'%'),
					array('User.username LIKE ?' => '%'.$q.'%'),
					array('Profile.skills LIKE ?' => '%'.$q.'%'),
					// array('Profile.live_place LIKE ?' => '%'.$q.'%'),
					// array('Group.title LIKE ?' => '%'.$q.'%'),
				)
			)
		);
		$joins = array(
			array('type' => 'left', 'table' => $this->Profile->getTableName(), 'alias' => 'Profile', 'conditions' => array('Profile.user_id = User.id')),
			// array('type' => 'left', 'table' => $this->Group->getTableName(), 'alias' => 'Group', 'conditions' => array('Group.owner_id = User.id'))
		);
		$order = array('User.username');
		$aUsers = $this->find('all', compact('fields', 'conditions', 'order', 'joins'));
		$aID = Hash::extract($aUsers, '{n}.User.id');
		
		// get all user except current
		$aUsers = $this->getUsers($aID);
		return $aUsers;
	}
	
	public function timelineEvents($currUserID, $date, $date2) {
		$fields = array('User.created', 'User.id');
		// $conditions = $this->dateRange('User.created', $date, $date2);
		$order = 'User.created DESC';
		$limit = 5;
		$recursive = -1;
		return $this->find('all', compact('fields', 'conditions', 'order', 'limit', 'recursive'));
	}
}
