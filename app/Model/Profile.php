<?
App::uses('AppModel', 'Model');
App::uses('Media', 'Media.Model');
App::uses('ProfileAchievement', 'Model');
class Profile extends AppModel {
	
	public $hasOne = array(
		'Media' => array(
			'className' => 'Media.Media',
			'foreignKey' => 'object_id',
			'conditions' => array('Media.object_type' => 'Profile'),
			'dependent' => true
		),
		'MediaUniversity' => array(
			'className' => 'Media.Media',
			'foreignKey' => 'object_id',
			'conditions' => array('MediaUniversity.object_type' => 'ProfileUniversity'),
			'dependent' => true
		)
	);
	
	public $hasMany = array(
		'ProfileAchievement' => array(
			'order' => array('ProfileAchievement.id DESC'),
			'dependent' => true
		)
	);
	
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
		// $aID = Hash::extract($data['group_member']['joined'], '{n}.GroupMember.group_id');
		// $data['groups'] = $this->Group->findAllById($aID);
		$data['groups'] = $this->GroupMember->getUserGroups($currUserID);
		foreach($data['groups'] as &$group) {
			$media = $group['Media'];
			$group['Group']['image_url'] = $this->Media->getPHMedia()->getImageUrl($media['object_type'], $media['id'], 'thumb50x50', $media['file'].$media['ext']);
		}
		// $data['groups'] = Hash::combine($data['groups'], '{n}.Group.id', '{n}');
		
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
			array('id' => $currUserID),
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
