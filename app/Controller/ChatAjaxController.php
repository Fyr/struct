<?php
App::uses('AppController', 'Controller');
App::uses('PAjaxController', 'Core.Controller');
class ChatAjaxController extends PAjaxController {
	public $name = 'ChatAjax';
	public $uses = array('User', 'ChatMessage', 'ChatEvent', 'ChatContact', 'ChatRoom', 'ChatMember');

	public function beforeFilter() {
		parent::beforeFilter();
		$this->_checkAuth();
	}
	
	public function jsSettings() {
		$this->response->type(array('type' => 'text/javascript'));
	}
	
	public function contactList() {
		try {
			$aUsers = array();
			$q = $this->request->data('q');
			$aUsers = $this->ChatContact->getList($this->currUserID, $q);
			$this->setResponse(compact('aUsers'));
		} catch (Exception $e) {
			$this->setError($e->getMessage());
		}
	}
	
	public function openRoom() {
		$userID = $this->request->data('user_id');
		$roomID = $this->request->data('room_id');
		try {
			if ($roomID) {
				$room = $this->ChatRoom->findById($roomID);
			} elseif ($userID) {
				$room = $this->ChatEvent->openRoom($this->currUserID, $userID);
			} else {
				throw new Exception('Incorrect request');
			}
			
			if (!$room) {
				throw new Exception('Room does not exists');
			}
			$room['ChatRoom']['canAddMember'] = in_array($this->currUserID, array($room['ChatRoom']['initiator_id'], $room['ChatRoom']['recipient_id']));
			
			$aID = $this->ChatMember->getRoomMembers($room['ChatRoom']['id'], $this->currUserID);
			$members = $this->User->getUsers($aID);
			unset($members[$this->currUserID]);
			$events = $this->ChatEvent->getInitialEvents($this->currUserID, $room['ChatRoom']['id']);
			return $this->setResponse(compact('room', 'members', 'events'));
		} catch (Exception $e) {
			$this->setError($e->getMessage());
		}
	}
	
	public function sendMsg() {
		$roomID = $this->request->data('roomID');
		$msg = $this->request->data('msg');
		try {
			if (!($msg && $roomID)) {
				throw new Exception('Incorrect request');
			}
			
			$this->ChatEvent->addMessage($this->currUserID, $roomID, $msg);
			
			return $this->setResponse(true);
		} catch (Exception $e) {
			$this->setError($e->getMessage());
		}
	}
	
	public function sendFile() {
		$roomID = $this->request->data('roomID');
		$mediaID = $this->request->data('id');
		try {
			if (!($mediaID && $roomID)) {
				throw new Exception('Incorrect request');
			}
			
			$this->ChatEvent->addFile($this->currUserID, $roomID, $mediaID);
			
			return $this->setResponse(true);
		} catch (Exception $e) {
			$this->setError($e->getMessage());
		}
	}
	
	public function updateState() {
		try {
			$data = $this->ChatEvent->getActiveEvents($this->currUserID);
			$data['aUsers'] = $this->ChatContact->getList($this->currUserID);
			$this->setResponse($data);
		} catch (Exception $e) {
			$this->setError($e->getMessage());
		}
		
	}
	
	public function markRead() {
		try {
			$ids = $this->request->data('ids');
			if (!$ids || !is_array($ids)) {
				throw new Exception('Incorrect request');
			}
			$this->ChatEvent->updateInactive($this->currUserID, $ids);
			$this->setResponse(true);
		} catch (Exception $e) {
			$this->setError($e->getMessage());
		}
	}
	
	public function delContact() {
		try {
			$id = $this->request->data('contact_id');
			$this->ChatEvent->removeContact($this->currUserID, $id);
			$data['aUsers'] = $this->ChatContact->getList($this->currUserID);
			$this->setResponse($data);
		} catch (Exception $e) {
			$this->setError($e->getMessage());
		}
	}
	
	public function addMember() {
		try {
			$userID = $this->request->data('user_id');
			$roomID = $this->request->data('room_id');
			$members = $this->ChatMember->getRoomMembers($roomID);
			if (count($members) == 2) {
				// create a new room for a group chat
				$newRoom = $this->ChatEvent->createRoom($members[0], $members[1]);
				if ($userID != $members[0] && $userID !== $members[1]) {
					// $this->ChatMember->save(array('room_id' => $newRoom['ChatRoom']['id'], 'user_id' => $userID));
					$this->ChatEvent->addMember($this->currUserID, $newRoom['ChatRoom']['id'], $userID);
				}
				$this->setResponse(compact('newRoom'));
				return;
			}
			if ($roomID && $userID) {
				$this->ChatEvent->addMember($this->currUserID, $roomID, $userID);
			} else {
				throw new Exception('Incorrect request');
			}
			
			$aID = $this->ChatMember->getRoomMembers($roomID, $this->currUserID);
			$members = $this->User->getUsers($aID);
			unset($members[$this->currUserID]);
			
			$this->setResponse(compact('members'));
		} catch (Exception $e) {
			$this->setError($e->getMessage());
		}
	}
	
	public function loadMore() {
		try {
			$id = $this->request->data('id');
			$room_id = $this->request->data('room_id');
			
			if (!$id || !$room_id) {
				throw new Exception('Incorrect request');
			}
			
			$data = $this->ChatEvent->loadEvents($this->currUserID, $room_id, $id);
			$this->setResponse($data);
		} catch (Exception $e) {
			$this->setError($e->getMessage());
		}
	}
}
