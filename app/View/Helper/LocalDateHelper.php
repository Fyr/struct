<?php
App::uses('AppHelper', 'View/Helper');
class LocalDateHelper extends AppHelper {

	public function date($date) {
		if (!$date || !strtotime($date)) {
			return '-';
		}
		if ($this->viewVar('currUser.User.lang') == 'rus') {
			return date('d.m.Y', strtotime($date));
		}
		return date('m/d/Y', strtotime($date));
	}
	
	public function dateTime($date) {
		if (!$date || !strtotime($date)) {
			return '-';
		}
		if ($this->viewVar('currUser.User.lang') == 'rus') {
			return date('d.m.Y H:i', strtotime($date));
		}
		return date('m/d/Y h:ia', strtotime($date));
	}
}
