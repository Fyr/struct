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
			$room['ChatRoom']['canAddMember'] = ($room['ChatRoom']['initiator_id'] == $this->currUserID);
			
			$aID = $this->ChatMember->getRoomMembers($room['ChatRoom']['id'], $this->currUserID);
			$members = $this->User->getUsers($aID);
			unset($members[$this->currUserID]);
			$events = $this->ChatEvent->getAllRoomEvents($this->currUserID, $room['ChatRoom']['id']);
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
	
}
