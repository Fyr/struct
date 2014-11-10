<?
App::uses('AppModel', 'Model');
App::uses('Media', 'Media.Model');
App::uses('GroupAddress', 'Model');
class Group extends AppModel {
	
	public $hasOne = array(
		'Media' => array(
			'className' => 'Media.Media',
			'foreignKey' => 'object_id',
			'conditions' => array('Media.object_type' => 'Group'),
			'dependent' => true
		)
	);	
	
	public $hasMany = array(
		'GroupAddress' => array(
			'dependent' => true
		),
		'GroupAchievement' => array(
			'dependent' => true
		)
	);
	
	public function search($currUserID, $q) {
		$fields = 'Group.id, Group.title';
		$conditions = array('Group.title LIKE ?' => '%'.$q.'%');
		$order = array('Group.title');
		return $this->find('all', compact('fields', 'conditions', 'order'));
	}
}
