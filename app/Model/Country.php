<?
App::uses('AppModel', 'Model');
class Country extends AppModel {
	
	public function options() {
		$fields = array('country_code', 'country_name');
		$order = 'country_name';
		return $this->find('list', compact('fields', 'order'));
	}
}
