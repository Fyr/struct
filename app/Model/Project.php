<?
App::uses('AppModel', 'Model');
App::uses('ProjectEvent', 'Model');
class Project extends AppModel {
	
	protected $ProjectEvent;
	
	public function close($user_id, $id) {
		$this->save(array('id' => $id, 'closed' => 1));
		
		$this->loadModel('ProjectEvent');
		$this->ProjectEvent->addEvent(ProjectEvent::PROJECT_CLOSED, $id, $user_id);
	}
}
