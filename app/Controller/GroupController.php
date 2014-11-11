<?php
App::uses('AppController', 'Controller');
App::uses('SiteController', 'Controller');
class GroupController extends SiteController {
	public $name = 'Group';
	public $layout = 'profile';
	public $uses = array('Group');
	public $helpers = array('Media');
	
	public function edit($id = 0) {
		$group = $this->Group->findById($id);
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->request->data('Group.owner_id', $this->currUserID);
			$this->request->data('Group.hidden', $this->request->data('Group.hidden') && true);
			$this->Group->saveAll($this->request->data);
			return $this->redirect(array('controller' => $this->name, 'action' => 'edit', $this->Group->id, '?' => array('success' => '1')));
		} else {
			$this->request->data = $group;
		}
	}

	public function view($id) {
		$this->set('group', $this->Group->findById($id));
	}
	
	public function delete($id) {
		$this->Group->delete($id);
		$this->redirect(array('controller' => 'Profile', 'action' => 'view'));
	}
	
}
