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
		$aID = Hash::extract($aMembers, '{n}.GroupMember.user_id');
		
		$group = $this->Group->findById($group_id);
		$aID[] = $group['Group']['owner_id'];
		
		$this->loadModel('ChatUser');
		return Hash::combine($this->ChatUser->getUsers($aID), '{n}.ChatUser.id', '{n}');
	}
	
}