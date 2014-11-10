<?
App::uses('AppModel', 'Model');
App::uses('Media', 'Media.Model');
class Profile extends AppModel {
	
	public $hasOne = array(
		'Media' => array(
			'className' => 'Media.Media',
			'foreignKey' => 'object_id',
			'conditions' => array('Media.object_type' => 'Profile'),
			'dependent' => true
		)
	);
}
