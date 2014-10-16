<?
App::uses('AppModel', 'Model');
App::uses('ProductType', 'Model');
App::uses('Media', 'Media.Model');
class Product extends AppModel {
	
	public $belongsTo = array(
		'ProductType' => array(
			'foreignKey' => 'product_type_id',
			'dependent' => true
		),
	);
	public $hasOne = array(
		'Media' => array(
			'foreignKey' => 'object_id',
			'conditions' => array('Media.object_type' => 'Product', 'Media.main' => 1),
			'dependent' => true
		)
	);
	
	public $validate = array(
		'serial' => 'notempty'
	);
	
}
