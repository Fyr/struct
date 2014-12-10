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
	protected $User, $ChatRoom;
	
	/**
	 * Добавить к счетчику входящих по юзеру и комнате. Создает или обновляет чат-контакт
	 *
	 * @param int $user_id
	 * @param int $room_id
	 * @param int $initiator_id - инициатор события
	 * @param str $msg
	 * @param int $chat_event_id - ID события для логирования
	 */
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
	
	/**
	 * Установить значение счетчика входящих
	 *
	 * @param int $user_id
	 * @param int $room_id
	 * @param int $active_count
	 */
	public function setActiveCount($user_id, $room_id, $active_count) {
		$row = $this->findByUserIdAndRoomId($user_id, $room_id);
		$id = Hash::get($row, 'ChatContact.id');
		$this->save(compact('id', 'user_id', 'room_id', 'active_count'));
	}
	
	/**
	 * Получить список контактов юзера или поиск по контактам и юзерам
	 *
	 * @param int $user_id
	 * @param str $q
	 * @return array
	 */
	public function getList($user_id, $q = '') {
		$this->loadModel('User');
		$conditions = array('ChatContact.user_id' => $user_id);
		$order = array('ChatContact.modified DESC');
		$aContacts = $this->find('all', compact('conditions', 'order', 'recursive'));
		
		// добавлять в комнату других юзеров  может только иницитор открытия комнаты или его изначальный оппонент
		$aID = Hash::extract($aContacts, '{n}.ChatContact.room_id');
		$this->loadModel('ChatMember');
		
		foreach($aContacts as &$_row) {
			$roomID = $_row['ChatContact']['room_id'];
			$members = $this->ChatMember->getRoomMembers($roomID); // ($user_id == $rooms[$roomID]['ChatRoom']['initiator_id']);
			$members = array_combine($members, $members);
			unset($members[$user_id]);
			$_row['ChatContact']['members'] = array_values($members);
		}
		
		$aID = Hash::extract($aContacts, '{n}.ChatContact.initiator_id');
		$aResult = array();
		if ($q) {
			$aUsers = $this->User->search($user_id, $q);
			$aContacts = Hash::combine($aContacts, '{n}.ChatContact.initiator_id', '{n}');
			
			// показываем чат-контакты только тех юзеров, кот. есть в списке найденных
			// в порядке очередности поиска
			foreach($aUsers as $row) {
				$user_id = $row['User']['id'];
				if (isset($aContacts[$user_id])) {
					$row = array_merge($row, $aContacts[$user_id]);
				}
				$aResult[] = $row;
			}
		} else {
			// Просто показываем весь контакт лист в привязке к оппоненту, который писал в комнату
			$aUsers = $this->User->getUsers($aID);
			foreach($aContacts as $row) {
				$aResult[] = array_merge($row, $aUsers[$row['ChatContact']['initiator_id']]);
			}
		}
		return $aResult;
	}
	
}
