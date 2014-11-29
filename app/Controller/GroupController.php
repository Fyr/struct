<?php
/**
 * TODO: 
 * - check group admin rights (beforeFilter)
 */
App::uses('AppController', 'Controller');
App::uses('SiteController', 'Controller');
class GroupController extends SiteController {
	public $name = 'Group';
	public $layout = 'profile';
	public $uses = array('Group', 'GroupMember');
	public $helpers = array('Media');
	
	public function edit($id = 0) {
		$group = $this->Group->findById($id);
		$groupAdmin = $this->GroupMember->findByGroupIdAndUserId($id, Hash::get($group, 'Group.owner_id'));
		
		if ($id && Hash::get($group, 'Group.owner_id') != $this->currUserID) {
			return $this->redirect(array('controller' => 'Group', 'action' => 'view', $id));
		}
		
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->request->data('Group.owner_id', $this->currUserID);
			$this->request->data('Group.hidden', $this->request->data('Group.hidden') && true);
			if ($this->request->data('GroupAchievement')) {
				foreach($this->request->data('GroupAchievement') as $i => $data) {
					$this->request->data('GroupAchievement.'.$i.'.url', 
						(strpos($data['url'], 'http://') === false) ? 'http://'.$data['url'] : $data['url']
					);
				}
			}
			if ($this->request->data('GroupAddress')) {
				foreach($this->request->data('GroupAddress') as $i => $data) {
					$this->request->data('GroupAddress.'.$i.'.url', 
						(strpos($data['url'], 'http://') === false) ? 'http://'.$data['url'] : $data['url']
					);
				}
			}
			$this->Group->saveAll($this->request->data);
			if (!$id) {
				$this->request->data('GroupMember.group_id', $this->Group->id);
				$this->request->data('GroupMember.user_id', $this->currUserID);
				$this->request->data('GroupMember.approved', 1);
				$this->request->data('GroupMember.sort_order', 0);
				$this->request->data('GroupMember.approve_date', date('Y-m-d'));
			}
			$this->GroupMember->save($this->request->data);
			// return $this->redirect(array('controller' => $this->name, 'action' => 'edit', $this->Group->id, '?' => array('success' => '1')));
			return $this->redirect(array('controller' => $this->name, 'action' => 'view', $this->Group->id));
		} else {
			$this->request->data = array_merge($group, $groupAdmin);
			
			if (!$id) {
				$this->request->data('GroupMember.role', __('Administrator'));
			}
		}
	}
	
	public function delete($id) {
		$this->autoRender = false;
		
		$group = $this->Group->findById($id);
		if ($id && Hash::get($group, 'Group.owner_id') != $this->currUserID) {
			return $this->redirect(array('controller' => 'Group', 'action' => 'view', $id));
		}
		
		$this->Group->delete($id);
		$this->redirect(array('controller' => 'User', 'action' => 'view'));
	}

	public function view($id) {
		$this->loadModel('Project');
		
		$group = $this->Group->findById($id);
		$this->set('group', $group);
		$this->set('isGroupAdmin', Hash::get($group, 'Group.owner_id') == $this->currUserID);
		
		$conditions = array('group_id' => $id, 'user_id' => $this->currUserID);
		$joined = $this->GroupMember->find('first', compact('conditions'));
		$this->set('joined', $joined);
		
		$aMembers = $this->GroupMember->getList($id);
		$this->set('aMembers', $aMembers);
		
		$aID = Hash::extract($aMembers, '{n}.GroupMember.user_id');// array_keys($aMembers);
		$aUsers = $this->User->getUsers($aID);
		$this->set('aUsers', $aUsers);
		
		$this->set('aProjects', $this->Project->findAllByGroupIdAndClosed($id, 0));
	}
	
	public function members($id) {
		
		$group = $this->Group->findById($id);
		$this->set('group', $group);
		$this->set('isGroupAdmin', Hash::get($group, 'Group.owner_id') == $this->currUserID);
		
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->request->data('GroupMember.approved', 1);
			$this->request->data('GroupMember.approve_date', date('Y-m-d H:i:s'));
			$this->GroupMember->save($this->request->data);
			return $this->redirect(array('action' => 'members', $id));
		}
		
		$conditions = array('GroupMember.group_id' => $id);
		$order = array('GroupMember.approved', 'GroupMember.sort_order', 'GroupMember.created');
		$aMembers = $this->GroupMember->find('all', compact('conditions', 'order'));
		$this->set('aMembers', $aMembers);
		
		$aID = Hash::extract($aMembers, '{n}.GroupMember.user_id');
		$aUsers = $this->User->getUsers($aID);
		$this->set('aUsers', $aUsers);
	}
	
	public function memberApprove($group_id, $user_id) {
		$this->autoRender = false;
		$this->GroupMember->updateAll(array('approved' => 1), compact('group_id', 'user_id'));
		$this->redirect(array('action' => 'members', $group_id));
	}
	
	public function memberRemove($group_id, $user_id) {
		$this->autoRender = false;
		$this->GroupMember->deleteAll(compact('group_id', 'user_id'));
		$this->redirect(array('action' => 'members', $group_id));
	}
	
}
