<?php
App::uses('AppController', 'Controller');
App::uses('SiteController', 'Controller');
class ProfileController extends SiteController {
	public $name = 'Profile';
	public $layout = 'profile';
	public $uses = array('Profile', 'ChatUserData');
	public $helpers = array('Media');
	
	private $profile;
	
	public function beforeFilter() {
		parent::beforeFilter();
		$this->profile = $this->Profile->findByUserId($this->currUserID);
		$this->set('profile', $this->profile);
	}
	
	public function edit() {
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->request->data('Profile.user_id', $this->currUserID);
			$this->Profile->save($this->request->data);
			
			$this->request->data('ChatUserData.user_id', $this->currUserID);
			$this->request->data('ChatUserData.full_name', $this->request->data('Profile.full_name'));
			$this->ChatUserData->save($this->request->data);
			return $this->redirect(array('controller' => $this->name, 'action' => 'edit', '?' => array('success' => '1')));
		} else {
			$this->request->data = $this->profile;
		}
	}

	public function view($id = 0) {
		if (!$id) {
			$id = $this->currUserID;
		}
		$this->set('user', $this->ChatUser->getUser($id));
	}
	
	public function getAvatar() {
		$this->autoRender = false;
		$id = Hash::get($this->profile, 'Media.id');
		if (!$id) {
			header('Content-type: image/jpg');
			echo file_get_contents('/var/www/html/img/no-photo.jpg');
			exit;
		}
		
		$this->loadModel('Media.Media');
		
		$this->PHMedia = $this->Media->getPHMedia();
		$media = Hash::get($this->profile, 'Media');
		$type = $media['object_type'];
		$size = 'thumb90x90';
		$filename = $media['file'].$media['ext'];
		
		$media['ext'] = str_replace('.', '', $media['ext']);
		
		$fname = $this->PHMedia->getFileName($type, $id, $size, $filename);
		if (file_exists($fname)) {
			header('Content-type: image/'.$media['ext']);
			echo file_get_contents($fname);
			exit;
		}
		
		App::uses('Image', 'Media.Vendor');
		$image = new Image();
		$image->load($this->PHMedia->getFileName($type, $id, null, $media['file'].'.'.$media['ext']));
		$image->thumb(90, 90);
		
		if ($media['ext'] == 'jpg') {
			$image->outputJpg($fname);
			$image->outputJpg();
		} elseif ($media['ext'] == 'png') {
			$image->outputPng($fname);
			$image->outputPng();
		} else {
			$image->outputGif($fname);
			$image->outputGif();
		}
		exit;
	}
}
