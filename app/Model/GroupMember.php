<?
App::uses('AppModel', 'Model');
class GroupMember extends AppModel {
	
	public $belongsTo = array('Group');
	
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
}