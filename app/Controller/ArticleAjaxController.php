<?php
App::uses('AppController', 'Controller');
App::uses('PAjaxController', 'Core.Controller');
class ArticleAjaxController extends PAjaxController {
	public $name = 'ArticleAjax';
	public $helpers = array('Media');
	
	public function beforeFilter() {
		parent::beforeFilter();
		$this->_checkAuth();
	}
	
	public function jsSettings() {
	}
	
	public function panel() {
		$this->loadModel('Article');
		$q = $this->request->data('q');
		if ($q) {
			$aArticles = $this->Article->search($this->currUserID, $q);
		} else {
			$conditions = array('Article.owner_id' => $this->currUserID);
			$order = 'Article.title';
			$aArticles = $this->Article->find('all', compact('conditions', 'order'));
		}
		$this->set('aArticles', $aArticles);
	}
}