<?
App::uses('AppModel', 'Model');
class Article extends AppModel {
	public $name = 'Article';
	
	public $validate = array(
		'title' => array(
			'checkNotEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'Title field must not be empty',
			)
		)
	);
	
	public function search($currUserID, $q) {
		$conditions = array('Article.title LIKE ?' => '%'.$q.'%');
		$order = array('Article.title');
		return $this->find('all', compact('conditions', 'order'));
	}
	
	
	
}