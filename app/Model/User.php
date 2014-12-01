<?php
App::uses('AppModel', 'Model');
App::uses('Media', 'Media.Model');
App::uses('UserAchievement', 'Model');
class User extends AppModel {
	
	public $hasOne = array(
		'UserMedia' => array(
			'className' => 'Media.Media',
			'foreignKey' => 'object_id',
			'conditions' => array('UserMedia.object_type' => 'User'),
			'dependent' => true
		),
		'UniversityMedia' => array(
			'className' => 'Media.Media',
			'foreignKey' => 'object_id',
			'conditions' => array('UniversityMedia.object_type' => 'UserUniversity'),
			'dependent' => true
		)
	);
	
	public $hasMany = array(
		'UserAchievement' => array(
			'order' => array('UserAchievement.id DESC'),
			'dependent' => true
		)
	);
	
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
	
	protected $ChatEvent, $ChatRoom, $Group;
/*
	public function matchPassword($data){
		if($data['password'] == $this->data['User']['password_confirm']){
			return true;
		}
		$this->invalidate('password_confirm', 'Your password and its confirmation do not match');
		return false;
	}
*/
/*
	public function beforeValidate($options = array()) {
		if (Hash::get($options, 'validate')) {
			if (!Hash::get($this->data, 'User.password')) {
				fdebug('validator_remove');
				$this->validator()->remove('password');
				$this->validator()->remove('password_confirm');
			}
		}
	}
*/
	public function afterFind($results, $primary = false) {
		foreach($results as &$_row) {
			if (isset($_row[$this->alias])) {
	    		$row = $_row[$this->alias];
	    		if (isset($row['username']) && isset($row['full_name'])) {
	    			if (empty($row['full_name'])) {
	    				$_row[$this->alias]['full_name'] = $row['username'];
	    			}
	    		}
			}
    	}
    	return $results;
	}
	
	public function beforeSave($options = array()) {
		if (isset($this->data['User']['password'])) {
			$this->data['User']['password'] = AuthComponent::password($this->data['User']['password']);
		}
		return true;
	}
	
	public function getUser($id) {
		return $this->findById($id);
	}
	
	public function getUsers($aID = array()) {
		$aUsers = $this->findAllById($aID);
		return Hash::combine($aUsers, '{n}.User.id', '{n}');
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
	
	public function search($currUserID, $q) {
		$fields = 'User.id, User.username, User.full_name, User.skills, UserMedia.*';
		$conditions = array(
			'User.id <> '.$currUserID,
			'AND' => array(
				'OR' => array(
					array('User.full_name LIKE ?' => '%'.$q.'%'),
					array('User.username LIKE ?' => '%'.$q.'%'),
					array('User.skills LIKE ?' => '%'.$q.'%'),
					// array('User.live_place LIKE ?' => '%'.$q.'%'),
					// array('Group.title LIKE ?' => '%'.$q.'%'),
				)
			)
		);
		$order = array('User.username');
		$aUsers = $this->find('all', compact('fields', 'conditions', 'order'));
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
	
	public function getTimeline($currUserID, $date = '', $date2 = '') {
		if (!$date) {
			$date = date('Y-m-d');
		}
		if (strtotime($date) < strtotime(Configure::read('Konstructor.created'))) {
			$date = Configure::read('Konstructor.created');
		}
		if (!$date2) {
			$date2 = date('Y-m-d', strtotime($date) + DAY * Configure::read('timeline.loadPeriod'));
		}
		// fdebug(array($date, $date2), 'tmp.log', false);
		
		$aModels = array(
			'User' => 'last_users', 
			'Group' => 'last_groups', 
			'ChatEvent' => 'unread_msgs', 
			'UserEvent' => 'user_events',
			'GroupMember' => 'group_member',
			'ProjectEvent' => 'project_events'
		);
		$data = array();
		foreach($aModels as $model => $key) {
			$this->loadModel($model);
			$data[$key] = $this->{$model}->timelineEvents($currUserID, $date, $date2);
			// $data[$key] = array();
		}
		
		// Get users data ("vocabluary" array(ID => data))
		$aID = array_merge(
			Hash::extract($data['last_users'], '{n}.User.id'),
			Hash::extract($data['unread_msgs'], '{n}.ChatEvent.initiator_id'),
			Hash::extract($data['group_member']['request'], '{n}.GroupMember.user_id'),
			Hash::extract($data['project_events'], '{n}.ProjectEvent.user_id')
		);
		$data['users'] = $this->User->getUsers($aID);
		$data['users'] = Hash::combine($data['users'], '{n}.User.id', '{n}');
		
		// Get messages data
		$this->loadModel('ChatMessage');
		$aID = array_merge(
			Hash::extract($data['unread_msgs'], '{n}.ChatEvent.msg_id'),
			Hash::extract($data['project_events'], '{n}.ProjectEvent.msg_id')
		);
		$data['messages'] = $this->ChatMessage->findAllById($aID);
		$data['messages'] = Hash::combine($data['messages'], '{n}.ChatMessage.id', '{n}.ChatMessage');
		
		// Get Media data
		$this->loadModel('Media.Media');
		$aID = array_merge(
			Hash::extract($data['unread_msgs'], '{n}.ChatEvent.file_id'),
			Hash::extract($data['project_events'], '{n}.ProjectEvent.file_id')
		);
		$data['files'] = $this->Media->getList(array('id' => $aID), 'Media.id');
		$data['files'] = Hash::combine($data['files'], '{n}.Media.id', '{n}.Media');
		
		// Get joined groups data
		$aID = array_merge(
			Hash::extract($data['last_groups'], '{n}.Group.id'),
			Hash::extract($this->GroupMember->getUserGroups($currUserID), '{n}.GroupMember.group_id')
		);
		$data['groups'] = Hash::combine($this->Group->findAllById($aID), '{n}.Group.id', '{n}');
		$data['group_members'] = array();
		foreach($data['groups'] as $group) {
			$group_id = $group['Group']['id'];
			$data['group_members'][$group_id] = Hash::extract($this->GroupMember->getList($group_id), '{n}.GroupMember.user_id');
		}
		
		// Sort all sortable events by time creation
		$data['unread_msgs'] = Hash::combine($data['unread_msgs'], '{n}.ChatEvent.created', '{n}');
		$data['user_events'] = Hash::combine($data['user_events'], '{n}.UserEvent.event_time', '{n}');
		$data['joined_groups'] = Hash::combine($data['group_member']['joined'], '{n}.GroupMember.approve_date', '{n}');
		// $data['join_request'] = Hash::combine($data['group_member']['request'], '{n}.GroupMember.created', '{n}');
		$data['events'] = Hash::merge($data['unread_msgs'], $data['user_events'], $data['joined_groups']);
		
		// remove already unused data
		unset($data['unread_msgs']);
		unset($data['user_events']);
		unset($data['group_member']);
		
		// -= Special events =-
		// Self-registration
		$conditions = array_merge(
			array('User.id' => $currUserID),
			$this->dateRange('User.created', $date, $date2)
		);
		$user = $this->User->find('first', compact('conditions'));
		if ($user) {
			$created = $user['User']['created'];
			$data['events'][$created]['SelfRegistration'] = array(
				'created' => $created,
			);
		}
		
		$created = Configure::read('Konstructor.created');
		if (strtotime($date) <= strtotime($created) && strtotime($created) <= strtotime($date2)) {
			$data['events'][$created]['KonstructorCreation'] = array(
				'created' => $created,
			);
		}
		krsort($data['events']);
		
		// Group events by day
		$data['days'] = array();
		foreach($data['events'] as $datetime => $event) {
			$_date = strtotime($datetime);
			$data['days'][date('Y-m-d', $_date)][date('H', $_date)][] = $datetime;
		}
		// fdebug($data, 'tmp.log');
		return $data;
	}
}
