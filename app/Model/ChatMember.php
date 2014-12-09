<?php
App::uses('AppModel', 'Model');
class ChatMember extends AppModel {
	
	public function getRoomMembers($room_id) {
		$aRows = $this->findAllByRoomId($room_id);
		return Hash::extract($aRows, '{n}.ChatMember.user_id');
	}
}
