<?php
App::uses('AppController', 'Controller');
App::uses('PAjaxController', 'Core.Controller');
class ArticleAjaxController extends PAjaxController {
	public $name = 'ArticleAjax';
	public $uses = array('Article', 'ArticleCategory');
	public $helpers = array('Media');
	
	public function beforeFilter() {
		parent::beforeFilter();
		$this->_checkAuth();
	}
	
	public function jsSettings() {
	}
	
	public function panel() {
		$q = $this->request->data('q');
		$type = $this->request->data('type');
		$aArticles = array();
		if ($q) {
			$aArticles = $this->Article->search($q, $this->currUserID);
		} else {
			$conditions = array('Article.owner_id' => $this->currUserID);
			$order = 'Article.title';
			$aArticles = $this->Article->find('all', compact('conditions', 'order'));
		}
		$this->set('aArticles', $aArticles);
	}
	
	public function notes() {
		$q = $this->request->data('q');
		$aArticles = array();
		$aCategories = array();
		if ($q) {
			$aArticles = $this->Article->search($q);
		} else {
			// $aCategories = $this->ArticleCategory->find('list');
			$aCategories = $this->ArticleCategory->options();
			unset($aCategories[0]);
		}
		$this->set('aArticles', $aArticles);
		$this->set('aCategories', $aCategories);
	}
}