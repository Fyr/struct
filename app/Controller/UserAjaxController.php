<?php
App::uses('AppController', 'Controller');
App::uses('PAjaxController', 'Core.Controller');
class UserAjaxController extends PAjaxController {
	public $name = 'UserAjax';
	public $uses = array();
	public $helpers = array('Media');
	
	public function beforeFilter() {
		parent::beforeFilter();
		$this->_checkAuth();
	}
	
	public function jsSettings() {
	}
	
	public function panel() {
		$this->loadModel('User');
		$this->loadModel('Group');
		$q = $this->request->data('q');
		if ($q) {
			$this->set('aUsers', $this->User->search($this->currUserID, $q));
			$this->set('aGroups', $this->Group->search($this->currUserID, $q));
		}
	}
	
	public function timelineEvents() {
		$this->loadModel('User');
		try {
			$data = $this->User->getTimeline($this->currUserID, $this->request->data('date'), $this->request->data('date2'));
			$this->setResponse($data);
		} catch (Exception $e) {
			$this->setError($e->getMessage());
		}
	}
	
	public function updateEvent() {
		$this->loadModel('UserEvent');
		try {
			$this->request->data('UserEvent.user_id', $this->currUserID);
			list($hours, $mins) = explode(':', $this->request->data('UserEvent.time_event'));
			$mins = intval(str_replace(array('am', 'pm'), '', $mins));
			if (strpos($this->request->data('UserEvent.time_event'), 'pm') !== false && $hours < 12) {
				$hours+= 12;
			}

			$event_time = $this->request->data('UserEvent.date_event').' '.$hours.':'.$mins;
			$this->request->data('UserEvent.event_time', $event_time);
			$this->UserEvent->save($this->request->data);
			
			$data = $this->User->getTimeline($this->currUserID, $event_time, $event_time);
			$this->setResponse($data);
		} catch (Exception $e) {
			$this->setError($e->getMessage());
		}
	}
	
	public function deleteEvent() {
		$this->loadModel('UserEvent');
		try {
			$id = $this->request->data('UserEvent.id');
			$data['event'] = $this->UserEvent->findById($id);
			if (!$data['event']) {
				throw new Exception(__('Incorrect event ID'));
			}
			
			$this->UserEvent->delete($id);
			$event_time = Hash::get($data, 'event.UserEvent.event_time');
			
			$data['timeline'] = $this->User->getTimeline($this->currUserID, $event_time, $event_time);
			$this->setResponse($data);
		} catch (Exception $e) {
			$this->setError($e->getMessage());
		}
	}
}
