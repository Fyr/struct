<?php
App::uses('AppModel', 'Model');
class ChatRoom extends AppModel {

	protected $ChatMember;
	
	public function getUsersID($roomID) {
		$this->loadModel('ChatMember');

		$aRows = $this->ChatMember->findAllByRoomId($roomID);
		return Hash::extract($aRows, '{n}.ChatMember.user_id');
	}
	
	public function getRoomWith2Users($user_id, $user2_id) {
		$conditions = array('OR' => array(
			array('initiator_id' => $user_id, 'recipient_id' => $user2_id),
			array('initiator_id' => $user2_id, 'recipient_id' => $user_id),
		));
		$order = 'initiator_id';
		return $this->find('first', compact('conditions', 'order'));
	}
	
	public function getRoomsWithUser($user_id) {
		$conditions = array('OR' => array(
			array('initiator_id' => $user_id),
			array('recipient_id' => $user_id)
		));
		$order = 'initiator_id';
		return $this->find('all', compact('conditions', 'order'));
	}
}
