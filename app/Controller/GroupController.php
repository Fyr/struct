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
		if ($id && Hash::get($group, 'Group.owner_id') != $this->currUserID) {
			return $this->redirect(array('controller' => 'Group', 'action' => 'view', $id));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->request->data('Group.owner_id', $this->currUserID);
			$this->request->data('Group.hidden', $this->request->data('Group.hidden') && true);
			foreach($this->request->data('GroupAchievement') as $i => $data) {
				$this->request->data('GroupAchievement.'.$i.'.url', 
					(strpos($data['url'], 'http://') === false) ? 'http://'.$data['url'] : $data['url']
				);
			}
			$this->Group->saveAll($this->request->data);
			return $this->redirect(array('controller' => $this->name, 'action' => 'edit', $this->Group->id, '?' => array('success' => '1')));
		} else {
			$this->request->data = $group;
		}
	}

	public function view($id) {
		$this->loadModel('Media.Media');
		
		$group = $this->Group->findById($id);
		$this->set('group', $group);
		$this->set('canEdit', Hash::get($group, 'Group.owner_id') == $this->currUserID);
	}
	
	public function delete($id) {
		$this->autoRender = false;
		
		$group = $this->Group->findById($id);
		if ($id && Hash::get($group, 'Group.owner_id') != $this->currUserID) {
			return $this->redirect(array('controller' => 'Group', 'action' => 'view', $id));
		}
		
		$this->Group->delete($id);
		$this->redirect(array('controller' => 'Profile', 'action' => 'view'));
	}
	
}
