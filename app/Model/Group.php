<?
App::uses('AppModel', 'Model');
App::uses('Media', 'Media.Model');
App::uses('GroupAddress', 'Model');
App::uses('GroupAchievement', 'Model');
App::uses('GroupVideo', 'Model');
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
		),
		'GroupGallery' => array(
			'className' => 'Media.Media',
			'foreignKey' => 'object_id',
			'conditions' => array('GroupGallery.object_type' => 'GroupGallery'),
			'dependent' => true,
			'order' => array('GroupGallery.id' => 'DESC')
		),
		'GroupVideo' => array(
			'dependent' => true
		)
	);
	
	public function search($currUserID, $q) {
		$conditions = array('Group.title LIKE ?' => '%'.$q.'%');
		$order = array('Group.title');
		return $this->find('all', compact('conditions', 'order'));
	}
	
	public function dashboardEvents($currUserID, $date) {
		// $conditions = $this->dateRange('Group.created', $date);
		$order = 'Group.created';
		return $this->find('all', compact('conditions', 'order'));
	}
}
