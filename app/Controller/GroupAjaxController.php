<?php
App::uses('AppController', 'Controller');
App::uses('PAjaxController', 'Core.Controller');
class GroupAjaxController extends PAjaxController {
	public $name = 'GroupAjax';
	public $helpers = array('Media');
	
	public function beforeFilter() {
		parent::beforeFilter();
		$this->_checkAuth();
	}
	
	public function jsSettings() {
	}
	
	public function panel() {
		$this->loadModel('Group');
		$q = $this->request->data('q');
		if ($q) {
			$aGroups = $this->Group->search($this->currUserID, $q);
		} else {
			$conditions = array('Group.owner_id' => $this->currUserID);
			$order = 'Group.title';
			$aGroups = $this->Group->find('all', compact('conditions', 'order'));
		}
		$this->set('aGroups', $aGroups);
	}
	
	public function getGallery() {
		try {
			$group_id = $this->request->data('group_id');
			if (!$group_id) {
				throw new Exception('Incorrect request');
			}
			$this->loadModel('Media.Media');
			$this->loadModel('GroupVideo');
			
			$images = $this->Media->getList(array('object_type' => 'GroupGallery', 'object_id' => $group_id), array('Media.id' => 'DESC'));
			$videos = $this->GroupVideo->findAllByGroupId($group_id);
			$this->setResponse(compact('videos', 'images'));
		} catch (Exception $e) {
			$this->setError($e->getMessage());
		}
	}
	
	public function addGalleryVideo() {
		try {
			$group_id = $this->request->data('group_id');
			if (!$group_id) {
				throw new Exception('Incorrect request');
			}
			
			$url = $this->request->data('url');
			if (!$url) {
				throw new Exception('Incorrect request');
			} else if (!(strpos($url, 'youtube.com') === 0 || strpos($url, 'www.youtube.com') === 0 
					|| strpos($url, 'http://youtube.com') === 0 || strpos($url, 'http://www.youtube.com') === 0
					|| strpos($url, 'https://youtube.com') === 0 || strpos($url, 'https://www.youtube.com') === 0)) {
				throw new Exception('Only youtube.com is allowed');
			}
			
			$this->loadModel('GroupVideo');
			$this->request->data('video_id', str_replace(array('http://', 'https://', 'www.', 'youtube.com', '/watch?v='), '', $url));
			$this->GroupVideo->save($this->request->data);
			
			$this->getGallery();
		} catch (Exception $e) {
			$this->setError($e->getMessage());
		}
	}
	
	public function delGalleryVideo() {
		try {
			$group_id = $this->request->data('group_id');
			if (!$group_id) {
				throw new Exception('Incorrect request');
			}
			
			$id = $this->request->data('id');
			if (!$id) {
				throw new Exception('Incorrect request');
			}
			
			$this->loadModel('GroupVideo');
			$groupVideo = $this->GroupVideo->findById($id);
			if (!$groupVideo) {
				throw new Exception('Incorrect group video ID');
			}
			$this->GroupVideo->delete($id);
			
			$this->getGallery();
		} catch (Exception $e) {
			$this->setError($e->getMessage());
		}
	}
	
}
