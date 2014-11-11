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
		$aModels = array('ChatUser', 'Group', 'ChatEvent');
		try {
			$date = $this->request->data('date');
			if (!$date) {
				$date = date('Y-m-d');
			}
			
			$data = array();
			foreach($aModels as $model) {
				$this->loadModel($model);
				$data[Inflector::tableize($model)] = $this->{$model}->dashboardEvents($this->currUserID, $date);
			}
			
			$aID = array_merge(
				Hash::extract($data[Inflector::tableize('ChatUser')], '{n}.ChatUser.id'),
				Hash::extract($data[Inflector::tableize('ChatEvent')], '{n}.ChatEvent.initiator_id')
			);
			$data['users'] = $this->ChatUser->getUsers($aID);
			$data['users'] = Hash::combine($data['users'], '{n}.ChatUser.id', '{n}');
			
			$this->loadModel('ChatMessage');
			$aID = Hash::extract($data[Inflector::tableize('ChatEvent')], '{n}.ChatEvent.msg_id');
			$data['messages'] = $this->ChatMessage->findAllById($aID);
			$data['messages'] = Hash::combine($data['messages'], '{n}.ChatMessage.id', '{n}.ChatMessage');
			
			$this->loadModel('Media.Media');
			$aID = Hash::extract($data[Inflector::tableize('ChatEvent')], '{n}.ChatEvent.file_id');
			$data['files'] = $this->Media->getList(array('id' => $aID), 'Media.id');
			$data['files'] = Hash::combine($data['files'], '{n}.Media.id', '{n}.Media');
			return $this->setResponse($data);
		} catch (Exception $e) {
			$this->setError($e->getMessage());
		}
	}
}
