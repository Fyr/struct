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
	
	public function timelineEvents($currUserID, $date, $date2) {
		$fields = array('Group.id', 'Group.title', 'Group.created', 'Group.descr');
		// $conditions = $this->dateRange('Group.created', $date, $date2);
		$order = 'Group.created DESC';
		$limit = 2;
		$aGroups = $this->find('all', compact('conditions', 'order', 'limit'));
		
		foreach($aGroups as &$group) {
			$group['Group']['image_url'] = '/img/group-create-pl-image.jpg';
			if (Hash::get($group, 'Media.id')) {
				$media = $group['Media'];
				$group['Group']['image_url'] = $this->Media->getPHMedia()->getImageUrl($media['object_type'], $media['id'], 'thumb50x50', $media['file'].$media['ext']);
			}
			unset($group['Media']);
			unset($group['GroupGallery']);
			unset($group['GroupVideo']);
			unset($group['GroupAddress']);
			unset($group['GroupAchievement']);
		}
		return $aGroups;
	}
}
