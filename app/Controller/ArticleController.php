<?php
App::uses('AppController', 'Controller');
class ArticleController extends AppController {
	public $name = 'Article';
	public $uses = array('Article');
	public $helpers = array('Redactor.Redactor', 'Form', 'Html');
	public $layout = 'profile';
		
	public function beforeFilter() {
		parent::beforeFilter();
		$this->_checkAuth();
	}
	
	public function edit($id = null) {
		$article = $this->Article->findById($id);
		if ($id && Hash::get($article, 'Article.owner_id') != $this->currUserID) {
			return $this->redirect(array('controller' => 'Article', 'action' => 'view', $id));
		}
		
		if ($this->request->is('post') || $this->request->is('put')){
			$this->request->data('Article.owner_id', $this->currUserID);
			$this->request->data('Article.id', $id);
			if ($this->Article->save($this->request->data)) {
				return $this->redirect(array('action' => 'view', $this->Article->id));
			}
		} else {
			$this->request->data = $article;
		}
	}
	
	public function view($id) {
		$article = $this->Article->findById($id);
		$this->set('article', $article);
		$this->set('isArticleAdmin', $article['Article']['owner_id'] == $this->currUserID);
	}
	
	public function delete($id) {
		$this->autoRender = false;
		
		$article = $this->Article->findById($id);
		if ($id && Hash::get($group, 'Article.owner_id') != $this->currUserID) {
			return $this->redirect(array('controller' => 'Article', 'action' => 'view', $id));
		}
		
		$this->Article->delete($id);
		$this->redirect(array('controller' => 'User', 'action' => 'view'));
	}
	
	public function changePublish($id) {
		$this->autoRender = false;
		
		$article = $this->Article->findById($id);
		if ($id && Hash::get($article, 'Article.owner_id') != $this->currUserID) {
			return $this->redirect(array('controller' => 'Article', 'action' => 'view', $id));
		}
		
		$this->request->data('Article.id', $id);
		$this->request->data('Article.published', !$article['Article']['published']);
		if ($this->Article->save($this->request->data)){
			return $this->redirect(array('action' => 'view', $id));
		}
	}
}