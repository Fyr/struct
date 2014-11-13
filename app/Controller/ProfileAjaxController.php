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
	
	public function dashboardEvents() {
		$this->loadModel('Profile');
		try {
			$date = $this->request->data('date');
			if (!$date) {
				$date = date('Y-m-d');
			}
			
			$data = $this->Profile->getTimeline($this->currUserID, $date);
			// fdebug($data, 'tmp.log', false);
			return $this->setResponse($data);
		} catch (Exception $e) {
			$this->setError($e->getMessage());
		}
	}
	
	public function addEvent() {
		$this->loadModel('UserEvent');
		try {
			$this->UserEvent->save($this->request->data('Event'));
		} catch (Exception $e) {
			$this->setError($e->getMessage());
		}
	}
}
