<?php
App::uses('AppModel', 'Model');
App::uses('Media', 'Media.Model');
class User extends AppModel {
	
	public $hasOne = array(
		'Media' => array(
			'className' => 'Media.Media',
			'foreignKey' => 'object_id',
			'conditions' => array('Media.object_type' => 'User'),
			'dependent' => true
		),
		'MediaUniversity' => array(
			'className' => 'Media.Media',
			'foreignKey' => 'object_id',
			'conditions' => array('MediaUniversity.object_type' => 'UserUniversity'),
			'dependent' => true
		)
	);
	
	public $hasMany = array(
		'UserAchievement' => array(
			'order' => array('UserAchievement.id DESC'),
			'dependent' => true
		)
	);
	
	public $validate = array(
		'username' => array(
			'checkNotEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'Field is mandatory',
			),
			'checkEmail' => array(
				'rule' => 'email',
				'message' => 'Email is incorrect'
			),
			'checkIsUnique' => array(
				'rule' => 'isUnique',
				'message' => 'This email has already been used'
			)
		),
		'password' => array(
			'checkNotEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Field is mandatory'
			),
			'checkPswLen' => array(
				'rule' => array('between', 4, 15),
				'message' => 'The password must be between 4 and 15 characters'
			),
		),
	);
/*
	public function matchPassword($data){
		if($data['password'] == $this->data['User']['password_confirm']){
			return true;
		}
		$this->invalidate('password_confirm', 'Your password and its confirmation do not match');
		return false;
	}
*/
/*
	public function beforeValidate($options = array()) {
		if (Hash::get($options, 'validate')) {
			if (!Hash::get($this->data, 'User.password')) {
				fdebug('validator_remove');
				$this->validator()->remove('password');
				$this->validator()->remove('password_confirm');
			}
		}
	}
*/
	public function beforeSave($options = array()) {
		if (isset($this->data['User']['password'])) {
			$this->data['User']['password'] = AuthComponent::password($this->data['User']['password']);
		}
		return true;
	}
	
}
