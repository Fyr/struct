<?
App::uses('AppModel', 'Model');
class ProjectEvent extends AppModel {
	const PROJECT_CREATED = 1;
	const SUBPROJECT_CREATED = 2;
	const TASK_CREATED = 3;
	const PROJECT_CLOSED = 4;
	const SUBPROJECT_CLOSED = 5;
	const TASK_CLOSED = 6;
	const TASK_COMMENT = 7;
	const FILE_ATTACHED = 8;
	
	protected $ChatMessage, $Task, $Subproject, $Project;
	
	public function addEvent($event_type, $project_id, $user_id, $object_id = 0) {
		$data = compact('event_type', 'project_id', 'user_id');
		if ($event_type == self::SUBPROJECT_CREATED || $event_type == self::SUBPROJECT_CLOSED) {
			$data['subproject_id'] = $object_id;
		} elseif ($event_type == self::TASK_CREATED || $event_type == self::TASK_CLOSED) {
			$data['task_id'] = $object_id;
		} elseif ($event_type == self::TASK_COMMENT || $event_type == self::FILE_ATTACHED) {
			$data = array_merge($data, $object_id);
		}
		
		$this->clear();
		if (!$this->save($data)) {
			throw new Exception("Chat event cannot be saved\n".print_r($data, true));
		}
	}
	
	public function addTaskComment($user_id, $message, $task_id, $project_id) {
		$this->loadModel('ChatMessage');
		
		if (!$this->ChatMessage->save(compact('message'))) {
			throw new Exception("Message cannot be saved\n".print_r($data, true));
		}
		$msg_id = $this->ChatMessage->id;
		$this->addEvent(self::TASK_COMMENT, $project_id, $user_id, compact('task_id', 'msg_id'));
	}
	
	public function addTaskFile($user_id, $task_id, $file_id) {
		$this->loadModel('Task');
		$this->loadModel('Subproject');
		$this->loadModel('Project');
		
		fdebug(array($user_id, $task_id, $file_id));
		
		$task = $this->Task->findById($task_id);
		$subproject = $this->Subproject->findById($task['Task']['subproject_id']);
		$project_id = $subproject['Subproject']['project_id'];
		$project = $this->Project->findById($project_id);
		$this->addEvent(self::FILE_ATTACHED, $project_id, $user_id, compact('task_id', 'file_id'));
	}
}
