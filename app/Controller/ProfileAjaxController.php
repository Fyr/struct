<?php
App::uses('AppController', 'Controller');
App::uses('PAjaxController', 'Core.Controller');
class ProfileAjaxController extends PAjaxController {
	public $name = 'ProfileAjax';
	public $uses = array();
	public $helpers = array('Media');
	
	public function beforeFilter() {
		parent::beforeFilter();
		$this->_checkAuth();
	}
	
	public function jsSettings() {
	}
	
	public function panel() {
		$this->loadModel('ChatUser');
		$this->loadModel('Group');
		$q = $this->request->data('q');
		if ($q) {
			$this->set('aUsers', $this->ChatUser->search($this->currUserID, $q));
			$this->set('aGroups', $this->Group->search($this->currUserID, $q));
		}
	}
	
	public function timelineEvents() {
		$this->loadModel('Profile');
		try {
			$data = $this->Profile->getTimeline($this->currUserID, $this->request->data('date'), $this->request->data('date2'));
			return $this->setResponse($data);
		} catch (Exception $e) {
			$this->setError($e->getMessage());
		}
	}
	
	public function addEvent() {
		$this->loadModel('UserEvent');
		try {
			
			$this->request->data('UserEvent.user_id', $this->currUserID);
			$this->request->data('UserEvent.event_time', $this->request->data('UserEvent.date_event').' '.$this->request->data('UserEvent.time_event'));
			$this->UserEvent->save($this->request->data);
			$this->timelineEvents();
		} catch (Exception $e) {
			$this->setError($e->getMessage());
		}
	}
}
