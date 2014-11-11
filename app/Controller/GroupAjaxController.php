<?php
App::uses('AppController', 'Controller');
App::uses('PAjaxController', 'Core.Controller');
class GroupAjaxController extends PAjaxController {
	public $name = 'GroupAjax';
	public $helpers = array('Media');
	
	public function beforeFilter() {
		parent::beforeFilter();
		$this->_checkAuth();
	}
	
	public function jsSettings() {
	}
	
	public function panel() {
		$this->loadModel('Group');
		$q = $this->request->data('q');
		if ($q) {
			$aGroups = $this->Group->search($this->currUserID, $q);
		} else {
			$conditions = array('Group.owner_id' => $this->currUserID);
			$order = 'Group.title';
			$aGroups = $this->Group->find('all', compact('conditions', 'order'));
		}
		$this->set('aGroups', $aGroups);
	}
	
}
