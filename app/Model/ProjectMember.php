<?
App::uses('AppModel', 'Model');
App::uses('User', 'Model');
class ProjectMember extends AppModel {
	
	public $belongsTo = array('Project');
	// public $hasOne = array('User');
	
	protected $User;
	/*
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
	*/
	public function getList($project_id) {
		$conditions = array('ProjectMember.project_id' => $project_id);
		$order = array('ProjectMember.sort_order', 'ProjectMember.created');
		$aMembers = $this->find('all', compact('conditions', 'order'));
		// $aMembers = Hash::combine($aMembers, '{n}.GroupMember.user_id', '{n}');
		return $aMembers;
	}
	/*
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
	*/
}