<?php
App::uses('AppController', 'Controller');
class ArticleController extends AppController {
	public $name = 'Article';
	public $uses = array('Article', 'ArticleCategory');
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
		$aCategoryOptions = $this->ArticleCategory->options();
		unset($aCategoryOptions[0]);
		$this->set('aCategoryOptions', $aCategoryOptions);
	}
	
	public function view($id) {
		$article = $this->Article->findById($id);
		$this->set('article', $article);
		$isArticleAdmin = $article['Article']['owner_id'] == $this->currUserID;
		if (!Hash::get($article, 'Article.published') && !$isArticleAdmin) {
			return $this->redirect(array('controller' => 'User', 'action' => 'view'));
		}
		$this->set('isArticleAdmin', $isArticleAdmin);
		$this->set('aCategoryOptions', $this->ArticleCategory->options());
	}
	
	public function delete($id) {
		$this->autoRender = false;
		
		$article = $this->Article->findById($id);
		if ($id && Hash::get($article, 'Article.owner_id') != $this->currUserID) {
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
	
	public function category($id) {
		$this->set('aArticles', $this->Article->findAllByCatIdAndPublished($id, 1));
		$this->set('aCategoryOptions', $this->ArticleCategory->options());
	}
}