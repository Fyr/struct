<?php
App::uses('AppModel', 'Model');
class ChatEvent extends AppModel {
	const OUTCOMING_MSG = 1;
	const INCOMING_MSG = 2;
	const ROOM_OPENED = 3;
	const USER_INCLUDED = 4;
	const USER_EXCLUDED = 5; // not used yet
	const FILE_UPLOADED = 6;
	const FILE_DOWNLOAD_AVAIL = 7;
	
	const ACTIVE = 1;
	const INACTIVE = 0;
	
	protected $ChatMessage, $ChatRoom, $Media, $ChatContact;
	
	protected function _addEvent($event_type, $user_id, $room_id, $obj_id, $initiator_id, $active = 1) {
		$data = compact('event_type', 'user_id', 'room_id', 'initiator_id', 'active');
		if (in_array($event_type, array(self::OUTCOMING_MSG, self::INCOMING_MSG))) {
			$data['msg_id'] = $obj_id;
		} elseif (in_array($event_type, array(self::ROOM_OPENED, self::USER_INCLUDED, self::USER_EXCLUDED))) {
			$data['recipient_id'] = $obj_id;
		} elseif (in_array($event_type, array(self::FILE_UPLOADED, self::FILE_DOWNLOAD_AVAIL))) {
			$data['file_id'] = $obj_id;
		}
		
		$this->clear();
		if (!$this->save($data)) {
			throw new Exception("Chat event cannot be saved\n".print_r($data, true));
		}
		return $this->id;
	}
	
	/**
	 * Returns all users in the chat room
	 *
	 * @param int $roomID
	 * @return array
	 */
	protected function _getRoomUsersID($roomID) {
		$this->loadModel('ChatMember');
		$aID = $this->ChatMember->getRoomMembers($roomID);
		return $aID;
	}
	
	public function addMessage($currUserID, $roomID, $message) {
		$this->loadModel('ChatMessage');
		$this->loadModel('ChatContact');
		
		if (!$this->ChatMessage->save(compact('message'))) {
			throw new Exception("Message cannot be saved\n".print_r($data, true));
		}
		$msgID = $this->ChatMessage->id;
		
		$aUsersID = $this->_getRoomUsersID($roomID);
		foreach($aUsersID as $userID) {
			if ($userID == $currUserID) {
				$eventID = $this->_addEvent(self::OUTCOMING_MSG, $currUserID, $roomID, $msgID, $currUserID, self::INACTIVE);
				
				// выбираем первого юзера в комнате, но не самого себя
				// нужно выбрать того, кому адресовано сообщение
				foreach($aUsersID as $anotherUserID) {
					if ($anotherUserID != $currUserID) {
						break;
					}
				}
				$this->ChatContact->updateList($currUserID, $roomID, $anotherUserID, $message, $eventID);
				$this->ChatContact->setActiveCount($currUserID, $roomID, 0);
			} else {
				$eventID = $this->_addEvent(self::INCOMING_MSG, $userID, $roomID, $msgID, $currUserID);
				// TODO: для КонтактЛиста - сохранять точное время из события
				// т.к. время сохранения КонтактЛиста и ЧатСобытия может отличаться по минутам
				// напр. ЧатСобытие записалось 03:59:59, а контактЛист - уже 04:00:00
				$this->ChatContact->updateList($userID, $roomID, $currUserID, $message, $eventID);
			}
		}
	}
	
	public function addFile($currUserID, $roomID, $mediaID) {
		$this->loadModel('ChatContact');
		
		$aUsersID = $this->_getRoomUsersID($roomID);
		foreach($aUsersID as $userID) {
			if ($userID == $currUserID) {
				$this->_addEvent(self::FILE_UPLOADED, $currUserID, $roomID, $mediaID, $currUserID, self::INACTIVE);
			} else {
				$eventID = $this->_addEvent(self::FILE_DOWNLOAD_AVAIL, $userID, $roomID, $mediaID, $currUserID);
				$this->ChatContact->updateList($userID, $roomID, $currUserID, __('You have received a file'), $eventID);
			}
		}
	}
	
	/**
	 * Открывает или создает комнату для 2х юзеров, а также чат-контакт для текущего
	 *
	 * @param int $currUserID
	 * @param int $userID
	 * @return array - данные о комнате
	 */
	public function openRoom($currUserID, $userID) {
		$this->loadModel('ChatRoom');
		$this->loadModel('ChatContact');
		
		/**
		 * Нужно проверять - открыта ли комната уже. 
		 * Может быть ситуация, когда один юзер открывает комнату с другим, а тот уже ее открыл
		 * Тогда они будут писать друг другу в разные комнаты, что недопустимо
		 */
		$room = $this->ChatRoom->getRoomWith2Users($currUserID, $userID);
		if (!$room) {
			// первичная инициализация комнаты чата
			$this->ChatRoom->clear();
			$data = array('initiator_id' => $currUserID, 'recipient_id' => $userID);
			if (!$this->ChatRoom->save($data)) {
				throw new Exception("Room cannot be opened\n".print_r($data));
			}
			$room = $this->ChatRoom->findById($this->ChatRoom->id);
			
			// Комнату для чата открывает сам юзер - нет смысла помечать это как НЕ-прочитанное
			$eventID = $this->_addEvent(self::ROOM_OPENED, $currUserID, $room['ChatRoom']['id'], $userID, $currUserID, self::INACTIVE);
			
			// Создать чат-контакт при открытии комнаты - мы ведь его по идее уже выбираем для общения
			$msg = ''; // сообщение при открытии комнаты еще никакое не пришло. Можно выставлять skills, т.к. при поиске все равно они показываются
			$this->ChatContact->updateList($currUserID, $room['ChatRoom']['id'], $userID, $msg, $eventID);
			
			// раз он сам открывает комнату - по ней не должно быть входящих
			$this->ChatContact->setActiveCount($currUserID, $room['ChatRoom']['id'], 0); 
			
			// Если реципиенту не написали - нет смысла показывать открытие комнаты как НЕпрочитанное
			// Не смысла вносить этот контакт в список пока он ничего не написал
			$this->_addEvent(self::ROOM_OPENED, $userID, $room['ChatRoom']['id'], $userID, $currUserID, self::INACTIVE);
		} else {
			// проверить есть ли такой контакт - возможно контакт был удален
			if (!$this->ChatContact->findByUserIdAndRoomId($currUserID, $room['ChatRoom']['id'])) {
				// найти событие, по которому комната была открыта для логирования
				$conditions = array('user_id' => $currUserID, 'active' => 0, 'room_id' => $room['ChatRoom']['id'], 'event_type' => self::ROOM_OPENED);
				$order = 'ChatEvent.created DESC';
				$event = $this->find('first', compact('conditions', 'order'));
				
				$msg = ''; // сообщение при открытии комнаты еще никакое не пришло. Можно выставлять skills, т.к. при поиске все равно они показываются
				$this->ChatContact->updateList($currUserID, $room['ChatRoom']['id'], $userID, $msg, $event['ChatEvent']['id']);
				$this->ChatContact->setActiveCount($currUserID, $room['ChatRoom']['id'], 0);
			}
		}
		return $room;
	}
	
	protected function _getEvents($currUserID, $conditions) {
		$this->loadModel('ChatMessage');
		$this->loadModel('User');
		$this->loadModel('Media.Media');
		
		$conditions = array_merge(array('user_id' => $currUserID), $conditions);
		$order = array('room_id', 'created');
		$events = $this->find('all', compact('conditions', 'order'));
		
		// Get info about sent messages
		$aID = Hash::extract($events, '{n}.ChatEvent.msg_id');
		$messages = $this->ChatMessage->findAllById($aID);
		$messages = Hash::combine($messages, '{n}.ChatMessage.id', '{n}.ChatMessage');
		
		// Get info about sent files
		$aID = Hash::extract($events, '{n}.ChatEvent.file_id');
		$files = $this->Media->getList(array('id' => $aID), 'Media.id');
		$files = Hash::combine($files, '{n}.Media.id', '{n}.Media');
		return compact('events', 'messages', 'authors', 'files');
	}
	
	public function getActiveEvents($currUserID) {
		return $this->_getEvents($currUserID, array('active' => 1));
	}
	
	public function getAllRoomEvents($currUserID, $room_id) {
		return $this->_getEvents($currUserID, compact('room_id'));
	}
	
	public function updateInactive($userID, $ids) {
		$this->updateAll(array('active' => self::INACTIVE), array('id' => $ids));
		
		// update contact list
		$this->loadModel('ChatContact');
		$fields = array('user_id', 'room_id', 'SUM(active) as active_count');
		$conditions = array('id' => $ids, 'user_id' => $userID);
		$order = 'ChatEvent.created DESC';
		$group = array('room_id');
		$aEvents = $this->find('all', compact('fields', 'conditions', 'order', 'group'));
		foreach($aEvents as $event) {
			$this->ChatContact->setActiveCount($userID, $event['ChatEvent']['room_id'], $event[0]['active_count']);
		}
	}
	/*
	public function getActiveRooms($userID) {
		$this->loadModel('ChatMessage', 'Media.Media');
		
		$fields = array('ChatEvent.event_type', 'ChatEvent.room_id', 'ChatEvent.created', 'ChatEvent.initiator_id', 'ChatEvent.msg_id', 'ChatEvent.file_id', 'ChatMessage.message', 'SUM(active) AS count');
		$conditions = array('ChatEvent.user_id' => $userID, 'ChatEvent.active' => 1);
		$joins = array(
			array('type' => 'left', 'table' => $this->ChatMessage->getTableName(), 'alias' => 'ChatMessage', 'conditions' => array('`ChatEvent`.msg_id = `ChatMessage`.id'))
		);
		$order = array('count DESC');
		$group = array('ChatEvent.room_id');
		return $this->find('all', compact('fields', 'conditions', 'joins', 'order', 'group'));
	}
	*/
	public function timelineEvents($currUserID, $date, $date2) {
		$conditions = array_merge(
			$this->dateRange('ChatEvent.created', $date, $date2),
			array(
				'ChatEvent.event_type' => array(self::INCOMING_MSG, self::FILE_DOWNLOAD_AVAIL),
				'ChatEvent.user_id' => $currUserID,
				'ChatEvent.active' => 1
			)
		);
		$order = 'ChatEvent.created DESC';
		$limit = 5;
		return $this->find('all', compact('conditions', 'order', 'limit'));
	}
	
	public function removeContact($currUserID, $id) {
		$this->loadModel('ChatContact');
		$contact = $this->ChatContact->findById($id);
		if ($contact) {
			// помечаем все НЕпрочитанные сообщения как прочитанные, 
			// иначе будет глюк с общей статистикой по событиям (вылазит общее кол-во на иконке чата)
			$fields = array('active' => 0);
			$conditions = array('user_id' => $currUserID, 'room_id' => $contact['ChatContact']['room_id']);
			$this->updateAll($fields, $conditions);
			$this->ChatContact->delete($id);
		}
	}
}
