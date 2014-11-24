<?
App::uses('AppModel', 'Model');
App::uses('Group', 'Model');
class GroupMember extends AppModel {
	
	public $belongsTo = array('Group');
	
	protected $ChatUser;
	
	function timelineEvents($currUserID, $date, $date2) {
		$conditions = array_merge(
			$this->dateRange('GroupMember.approve_date', $date, $date2),
			array('GroupMember.user_id' => $currUserID, 'GroupMember.approved' => 1)
		);
		$order = array('GroupMember.approve_date', 'GroupMember.created');
		$data['joined'] = $this->find('all', compact('conditions', 'order'));
		
		$conditions = array_merge(
			$this->dateRange('GroupMember.created', $date, $date2),
			array('Group.owner_id' => $currUserID, 'GroupMember.approved' => 0)
		);
		$order = array('GroupMember.created');
		$data['request'] = $this->find('all', compact('conditions', 'order'));
		return $data;
	}
	
	public function getList($group_id) {
		$aMembers = $this->findAllByGroupIdAndApproved($group_id, 1);
		$aMembers = Hash::combine($aMembers, '{n}.GroupMember.user_id', '{n}');
		// $aID = Hash::extract($aMembers, '{n}.GroupMember.user_id');
		$aID = array_keys($aMembers);
		
		$group = $this->Group->findById($group_id);
		$aID = array_merge(array($group['Group']['owner_id']), $aID);
		
		$this->loadModel('ChatUser');
		$aUsers = $this->ChatUser->getUsers($aID);
		$members = array();
		foreach($aUsers as $user) {
			$user_id = $user['ChatUser']['id'];
			$members[$user_id] = $user;
			if (isset($aMembers[$user_id])) {
				$members[$user_id] = array_merge($members[$user_id], $aMembers[$user_id]);
			}
		}
		/*
		$aMembers = Hash::combine($this->ChatUser->getUsers($aID), '{n}.ChatUser.id', '{n}');
		$aMembers = array_merge(
			Hash::combine($this->ChatUser->getUsers($aID), '{n}.ChatUser.id', '{n}'),
			Hash::combine($aMembers, '{n}.GroupMember.user_id', '{n}')
		);
		$aMembers = Hash::combine($aMembers, '{n}.ChatUser.id', '{n}');
		return $aMembers;
		*/
		return $members;
	}
	
	public function getUserGroups($user_id) {
		$member = $this->findAllByUserIdAndApproved($user_id, 1);
		$member = Hash::combine($member, '{n}.GroupMember.group_id', '{n}');
		
		$conditions = array('OR' => array(
			array('Group.owner_id' => $user_id),
			array('Group.id' => array_keys($member))
		));
		$groups = $this->Group->find('all', compact('conditions'));
		foreach($groups as &$group) {
			$group_id = $group['Group']['id'];
			if (isset($member[$group_id])) {
				$group['GroupMember'] = $member[$group_id]['GroupMember'];
			}
		}
		return Hash::combine($groups, '{n}.Group.id', '{n}');
	}
	
}