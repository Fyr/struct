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
		$this->set('aTimeline', $this->Profile->getTimeLine($this->currUserID));
	}
}
