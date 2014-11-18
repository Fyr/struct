<?php
/**
 * Отдельный контроллер потому что отдельный layout!!!
 */
App::uses('AppController', 'Controller');
App::uses('SiteController', 'Controller');
class TimelineController extends SiteController {
	public $name = 'Timeline';
	public $layout = 'timeline';
	public $uses = array('Profile');
	public $helpers = array('Media');
	
	public function index() {
		$topDay = Configure::read('timeline.initialPeriod.1');
		$bottomDay = Configure::read('timeline.initialPeriod.0');
		$this->set('topDay', $topDay);
		$this->set('bottomDay', $bottomDay);
		
		$today = time();
		$date = $today + DAY * $bottomDay;
		$date2 = $today + DAY * $topDay;
		$this->set('aTimeline', $this->Profile->getTimeLine($this->currUserID, date('Y-m-d', $date), date('Y-m-d', $date2)));
	}
}
