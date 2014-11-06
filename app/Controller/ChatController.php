<?php
App::uses('AppController', 'Controller');
App::uses('SiteController', 'Controller');
class ChatController extends SiteController {
	public $name = 'Chat';
	
	public function index($userID = 0) {
		$this->set('chatUserID', ($userID) ?  $userID : 'null');
	}
}
