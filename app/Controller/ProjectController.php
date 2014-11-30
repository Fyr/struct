<?php
/**
 * TODO: 
 * - check Project admin rights (beforeFilter)
 */
App::uses('AppController', 'Controller');
App::uses('SiteController', 'Controller');
class ProjectController extends SiteController {
	public $name = 'Project';
	public $layout = 'profile';
	public $uses = array('Project', 'ProjectEvent', 'Subproject', 'Task', 'GroupMember', 'User', 'Group', 'Media.Media', 'ChatMessage', 'ProjectMember');
	public $helpers = array('Media', 'LocalDate');
	
	public function edit($id = 0) {
		$Project = $this->Project->findById($id);
		if ($id && Hash::get($Project, 'Project.owner_id') != $this->currUserID) {
			return $this->redirect(array('controller' => 'Project', 'action' => 'view', $id));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if (!$id) {
				$this->request->data('Project.group_id', $this->request->named['Project.group_id']);
				$this->request->data('Project.owner_id', $this->currUserID);
				$this->request->data('Project.hidden', $this->request->data('Project.hidden') && true);
			}
			$this->Project->save($this->request->data);
			
			if (!$id) { 
				$this->ProjectEvent->addEvent(ProjectEvent::PROJECT_CREATED, $this->Project->id, $this->currUserID);
				$this->ProjectMember->save(array('project_id' => $this->Project->id, 'user_id' => $this->currUserID, 'sort_order' => '0'));
			}
			// return $this->redirect(array('controller' => $this->name, 'action' => 'edit', $this->Project->id, '?' => array('success' => '1')));
			return $this->redirect(array('controller' => $this->name, 'action' => 'view', $this->Project->id));
		} else {
			$this->request->data = $Project;
		}
	}
	/*
	public function delete($id) {
		$this->autoRender = false;
		
		$Project = $this->Project->findById($id);
		if ($id && Hash::get($Project, 'Project.owner_id') != $this->currUserID) {
			return $this->redirect(array('controller' => 'Project', 'action' => 'view', $id));
		}
		
		$this->Project->delete($id);
		$this->redirect(array('controller' => 'User', 'action' => 'view'));
	}
	*/
	public function view($id) {
		$project = $this->Project->findById($id);
		$this->set('project', $project);
		$this->set('isProjectAdmin', Hash::get($project, 'Project.owner_id') == $this->currUserID);
		
		$aMembers = $this->ProjectMember->getList($id);
		$aID = Hash::extract($aMembers, '{n}.ProjectMember.user_id');
		if (!in_array($this->currUserID, $aID)) {
			return $this->redirect(array('controller' => 'Group', 'action' => 'view', $project['Project']['group_id']));
		}
		$this->set('aProjectMembers', $aMembers);
		
		$aMembers = $this->GroupMember->getList($project['Project']['group_id']);
		$aMembers = Hash::combine($aMembers, '{n}.GroupMember.user_id', '{n}');
		$this->set('aMembers', $aMembers);
		
		$aID = array_keys($aMembers);
		$aUsers = $this->User->getUsers($aID);
		$this->set('aUsers', $aUsers);
		
		$this->set('aMemberOptions', Hash::combine($aUsers, '{n}.User.id', '{n}.User.full_name'));
		
		$subprojects = $this->Subproject->findAllByProjectId($id);
		$subprojects = Hash::combine($subprojects, '{n}.Subproject.id', '{n}');

		$aID = array_keys($subprojects);
		$aTasks = $this->Task->findAllBySubprojectId($aID);

		$conditions = array('ProjectEvent.project_id' => $id);
		$order = 'ProjectEvent.created DESC';
		$limit = 10;
		$aEvents = $this->ProjectEvent->find('all', compact('conditions', 'order', 'limit'));
		
		$aID = Hash::extract($aEvents, '{n}.ProjectEvent.file_id');
		$files = $this->Media->getList(array('id' => $aID), 'Media.id');
		$files = Hash::combine($files, '{n}.Media.id', '{n}.Media');
		
		$this->set(compact('subprojects', 'aEvents', 'aTasks', 'files'));
	}
	
	public function task($id) {
		$task = $this->Task->findById($id);
		$aUsers = $this->User->getUsers(array($task['Task']['manager_id'], $task['Task']['user_id']));
		$this->set('aUsers', Hash::combine($aUsers, '{n}.User.id', '{n}'));
		$subproject = $this->Subproject->findById($task['Task']['subproject_id']);
		$project_id = $subproject['Subproject']['project_id'];
		$project = $this->Project->findById($project_id);
		$group = $this->Group->findById($project['Project']['group_id']);
		
		$members = $this->GroupMember->getList($project['Project']['group_id']);
		$aID = Hash::extract($members, '{n}.GroupMember.user_id');
		if (!in_array($this->currUserID, $aID)) {
			return $this->redirect(array('controller' => 'Group', 'action' => 'view', $project['Project']['group_id']));
		}
		$aUsers = $this->User->getUsers($aID);
		$this->set('aUsers', $aUsers);
		
		if ($this->request->is('put') || $this->request->is('post')) {
			$this->ProjectEvent->addTaskComment(
				$this->currUserID, 
				$this->request->data('message'),
				$id, 
				$project_id
			);
			return $this->redirect(array('action' => 'task', $id));
		}
		$conditions = array('ProjectEvent.project_id' => $project_id, 'ProjectEvent.task_id' => $id);
		$order = 'ProjectEvent.created DESC';
		$aEvents = $this->ProjectEvent->find('all', compact('conditions', 'order'));
		
		$aID = Hash::extract($aEvents, '{n}.ProjectEvent.msg_id');
		$messages = $this->ChatMessage->findAllById($aID);
		$messages = Hash::combine($messages, '{n}.ChatMessage.id', '{n}.ChatMessage');
		
		$aID = Hash::extract($aEvents, '{n}.ProjectEvent.file_id');
		$files = $this->Media->getList(array('id' => $aID), 'Media.id');
		$files = Hash::combine($files, '{n}.Media.id', '{n}.Media');
		
		$this->set(compact('task', 'subproject', 'project', 'group', 'messages', 'files', 'members', 'aEvents'));
	}
	
	public function addSubproject() {
		$this->Subproject->save($this->request->data);
		$project_id = $this->request->data('Subproject.project_id');
		$this->ProjectEvent->addEvent(ProjectEvent::SUBPROJECT_CREATED, $project_id, $this->currUserID, $this->Subproject->id);
		$this->redirect(array('action' => 'view', $project_id));
	}
	
	public function addTask($project_id) {
		$this->Task->save($this->request->data);
		$this->ProjectEvent->addEvent(ProjectEvent::TASK_CREATED, $project_id, $this->currUserID, $this->Task->id);
		$this->redirect(array('action' => 'view', $project_id));
	}
	
	public function closeTask($id) {
		$this->Task->save(array('id' => $id, 'closed' => 1));
		$task = $this->Task->findById($id);
		$subproject = $this->Subproject->findById($task['Task']['subproject_id']);
		$this->ProjectEvent->addEvent(ProjectEvent::TASK_CLOSED, $subproject['Subproject']['project_id'], $this->currUserID, $this->Task->id);
		$this->redirect(array('action' => 'task', $id));
	}
	
	public function close($id) {
		$project = $this->Project->findById($id);
		$this->Project->close($this->currUserID, $id);
		$this->redirect(array('controller' => 'Group', 'action' => 'view', $project['Project']['group_id']));
	}
	
	public function addMember($project_id) {
		$this->ProjectMember->save($this->request->data);
		// $this->ProjectEvent->addEvent(ProjectEvent::TASK_CREATED, $project_id, $this->currUserID, $this->Task->id);
		$this->redirect(array('action' => 'view', $project_id));
	}
}
