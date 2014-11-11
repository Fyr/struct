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
	
	protected $ChatEvent, $ChatRoom, $Profile, $Media, $Group;
	
	protected function _initUserData($user) {
		$user['ChatUser']['name'] = (trim($user['ChatUserData']['full_name'])) ? $user['ChatUserData']['full_name'] : $user['ChatUser']['username'];
		// $user['Avatar']['url'] = (trim($user['ChatUserData']['avatar'])) ? $user['ChatUserData']['avatar'] : '/img/no-photo.jpg';

		// $user['ChatUser']['name'] = $user['ChatUser']['username'];
		
		$this->loadModel(array('Profile', 'Media.Media'));
		$profile = $this->Profile->findByUserId($user['ChatUser']['id']);
		if ($profile) {
			$user = array_merge($user, $profile);
		}
		if ($profile && isset($profile['Media']) && Hash::get($profile, 'Media.id')) {
			$row = $profile['Media'];
			$src = $this->Media->getPHMedia()->getImageUrl($row['object_type'], $row['id'], 'thumb180x180', $row['file'].$row['ext']);
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
		$this->loadModel(array('ChatEvent', 'ChatRoom'));
		
		$aActiveRooms = $this->ChatEvent->getActiveRooms($currUserID);
		$aID = Hash::extract($aActiveRooms, '{n}.ChatEvent.initiator_id');
		$aUsers = $this->getUsers($aID);
		$aUsers = Hash::combine($aUsers, '{n}.ChatUser.id', '{n}');
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
			$fields = array('ChatUser.id', 'ChatUser.username', 'ChatUserData.full_name');
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
		$fields = 'ChatUser.id, ChatUser.username';
		$conditions = array(
			'ChatUser.id <> '.$currUserID,
			'AND' => array(
				'OR' => array(
					array('ChatUserData.full_name LIKE ?' => '%'.$q.'%'),
					array('ChatUser.username LIKE ?' => '%'.$q.'%'),
					array('Profile.skills LIKE ?' => '%'.$q.'%'),
					// array('Profile.live_place LIKE ?' => '%'.$q.'%'),
					// array('Group.title LIKE ?' => '%'.$q.'%'),
				)
			)
		);
		$joins = array(
			array('type' => 'left', 'table' => $this->Profile->getTableName(), 'alias' => 'Profile', 'conditions' => array('Profile.user_id = ChatUser.id')),
			// array('type' => 'left', 'table' => $this->Group->getTableName(), 'alias' => 'Group', 'conditions' => array('Group.owner_id = ChatUser.id'))
		);
		$order = array('ChatUser.username');
		$aUsers = $this->find('all', compact('fields', 'conditions', 'order', 'joins'));
		$aID = Hash::extract($aUsers, '{n}.ChatUser.id');
		
		// get all user except current
		$aUsers = $this->getUsers($aID);
		return $aUsers;
	}
	
	public function dashboardEvents($currUserID, $date) {
		$fields = array('ChatUser.create_time', 'ChatUser.id');
		$conditions = $this->dateRange('ChatUser.create_time', $date);
		$order = 'ChatUser.create_time';
		return $this->find('all', compact('fields', 'conditions', 'order'));
	}
}
