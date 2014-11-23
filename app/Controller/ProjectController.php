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
	public $uses = array('Project', 'ProjectEvent', 'Subproject', 'Task', 'GroupMember', 'ChatUser', 'Group', 'Media.Media', 'ChatMessage');
	public $helpers = array('Media');
	
	public function edit($id = 0) {
		$Project = $this->Project->findById($id);
		if ($id && Hash::get($Project, 'Project.owner_id') != $this->currUserID) {
			return $this->redirect(array('controller' => 'Project', 'action' => 'view', $id));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->request->data('Project.group_id', $this->request->named['Project.group_id']);
			$this->request->data('Project.owner_id', $this->currUserID);
			$this->request->data('Project.hidden', $this->request->data('Project.hidden') && true);
			$this->Project->save($this->request->data);
			
			if (!$id) { 
				$this->ProjectEvent->addEvent(ProjectEvent::PROJECT_CREATED, $this->Project->id, $this->currUserID);
			}
			return $this->redirect(array('controller' => $this->name, 'action' => 'edit', $this->Project->id, '?' => array('success' => '1')));
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
		$this->redirect(array('controller' => 'Profile', 'action' => 'view'));
	}
	*/
	public function view($id) {
		$project = $this->Project->findById($id);
		$this->set('project', $project);
		$this->set('isProjectAdmin', Hash::get($project, 'Project.owner_id') == $this->currUserID);
		
		$subprojects = $this->Subproject->findAllByProjectId($id);
		$subprojects = Hash::combine($subprojects, '{n}.Subproject.id', '{n}');

		$aID = array_keys($subprojects);
		$aTasks = $this->Task->findAllBySubprojectId($aID);

		$members = $this->GroupMember->getList($project['Project']['group_id']);
		$this->set('aUsers', $members);
		
		$this->set('aMemberOptions', Hash::combine($members, '{n}.ChatUser.id', '{n}.ChatUser.name'));
		
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
		$aUsers = $this->ChatUser->getUsers(array($task['Task']['manager_id'], $task['Task']['user_id']));
		$this->set('aUsers', Hash::combine($aUsers, '{n}.ChatUser.id', '{n}'));
		$subproject = $this->Subproject->findById($task['Task']['subproject_id']);
		$project_id = $subproject['Subproject']['project_id'];
		$project = $this->Project->findById($project_id);
		$group = $this->Group->findById($project['Project']['group_id']);
		
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
		
		$members = $this->GroupMember->getList($project['Project']['group_id']);
		// $members = $this->ChatUser->getUsers($members);
		/*
		$group_id = $project['Project']['group_id'];
		$aMembers = $this->GroupMember->findAllByGroupIdAndApproved($group_id, 1);
		$aID = Hash::extract($aMembers, '{n}.GroupMember.user_id');
		
		
		$group = $this->Group->findById($group_id);
		$aID[] = $group['Group']['owner_id'];
		$members = $this->ChatUser->getUsers($aID);
		*/
		$this->set(compact('task', 'subproject', 'project', 'group', 'messages', 'files', 'members', 'aEvents'));
	}
	
	public function addSubproject() {
		$autoRender = false;
		$this->Subproject->save($this->request->data);
		$project_id = $this->request->data('Subproject.project_id');
		$this->ProjectEvent->addEvent(ProjectEvent::SUBPROJECT_CREATED, $project_id, $this->currUserID, $this->Subproject->id);
		$this->redirect(array('action' => 'view', $project_id));
	}
	
	public function addTask($project_id) {
		$autoRender = false;
		$this->Task->save($this->request->data);
		$this->ProjectEvent->addEvent(ProjectEvent::SUBPROJECT_CREATED, $project_id, $this->currUserID, $this->Task->id);
		$this->redirect(array('action' => 'view', $project_id));
	}
	
	public function closeTask($id) {
		$autoRender = false;
		$this->Task->save(array('id' => $id, 'closed' => 1));
		$task = $this->Task->findById($id);
		$subproject = $this->Subproject->findById($task['Task']['subproject_id']);
		$this->ProjectEvent->addEvent(ProjectEvent::SUBPROJECT_CREATED, $subproject['Subproject']['project_id'], $this->currUserID, $this->Task->id);
		$this->redirect(array('action' => 'task', $id));
	}
	
}
