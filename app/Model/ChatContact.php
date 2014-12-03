<?
App::uses('AppModel', 'Model');
class ChatContact extends AppModel {
/*	
	public $belongsTo = array(
		'User' => array(
			'foreignKey' => 'initiator_id'
		)
	);
	при recursive=1 не выдает UserMedia, а при 2 пихает его как элемент на уровень ниже в [User] :(
*/
	protected $User;
	
	public function updateList($user_id, $room_id, $initiator_id, $msg, $chat_event_id) {
		$conditions = compact('user_id', 'room_id');
		$row = $this->find('first', compact('conditions'));
		$id = Hash::get($row, 'ChatContact.id');
		$active_count = intval(Hash::get($row, 'ChatContact.active_count')) + 1;
		
		/*
		$data = compact('id', 'user_id', 'room_id', 'msg', 'chat_event_id');
		if ($initiator_id) {
			$data['initiator_id'] = $initiator_id;
		}
		$this->save($data);
		*/
		$this->save(compact('id', 'user_id', 'room_id', 'initiator_id', 'msg', 'active_count', 'chat_event_id'));
	}
	
	public function setActiveCount($user_id, $room_id, $active_count) {
		$row = $this->findByUserIdAndRoomId($user_id, $room_id);
		$id = Hash::get($row, 'ChatContact.id');
		$this->save(compact('id', 'user_id', 'room_id', 'active_count'));
	}
	
	public function getList($user_id, $q = '') {
		$this->loadModel('User');
		$conditions = array('ChatContact.user_id' => $user_id);
		$order = array('ChatContact.modified DESC');
		$aContacts = $this->find('all', compact('conditions', 'order', 'recursive'));
		$aID = Hash::extract($aContacts, '{n}.ChatContact.initiator_id');
		if ($q) {
			$aUsers = $this->User->search($user_id, $q);
			$aContacts = Hash::combine($aContacts, '{n}.ChatContact.initiator_id', '{n}');
			$aResult = array();
			// показываем чат-контакты только тех юзеров, кот. есть в списке найденных
			foreach($aUsers as $row) {
				$user_id = $row['User']['id'];
				if (isset($aContacts[$user_id])) {
					$row = array_merge($row, $aContacts[$user_id]);
				}
				$aResult[] = $row;
			}
		} else {
			// Просто показываем весь контакт лист в привязке к юзерам
			$aUsers = $this->User->getUsers($aID);
			$aResult = array();
			foreach($aContacts as $row) {
				$aResult[] = array_merge($row, $aUsers[$row['ChatContact']['initiator_id']]);
			}
		}
		return $aResult;
	}
	
}
