<?
App::uses('AppModel', 'Model');
class UserEvent extends AppModel {
	
	public function dashboardEvents($currUserID, $date) {
		$conditions = array('user_id' => $currUserID);
		$order = array('event_time', 'created');
		$aEvents = $this->find('all', compact('conditions', 'order'));
		// for unique event time
		$eventTime = hash::get($aEvents, '{0}.UserEvent.event_time');
		$count = 0;
		foreach($aEvents as &$event) {
			if ($event['UserEvent']['event_time'] == $eventTime) {
				$count++;
				$event['UserEvent']['event_time'] = date('Y-m-d H:i', strtotime($eventTime)).':0'.$count;
			} else {
				$eventTime = $event['UserEvent']['event_time'];
				$count = 0;
			}
		}
		return array_reverse($aEvents);
	}
}
