<?php
Configure::write('Dispatcher.filters', array(
	'AssetDispatcher',
	'CacheDispatcher'
));

App::uses('CakeLog', 'Log');
CakeLog::config('debug', array(
	'engine' => 'File',
	'types' => array('notice', 'info', 'debug'),
	'file' => 'debug',
));
CakeLog::config('error', array(
	'engine' => 'File',
	'types' => array('warning', 'error', 'critical', 'alert', 'emergency'),
	'file' => 'error',
));

CakePlugin::loadAll();

define('DOMAIN_NAME', 'struct.dev');
define('DOMAIN_TITLE', 'Struct.DEV');

define('AUTH_ERROR', 'Invalid username or password, try again');
define('TEST_ENV', $_SERVER['SERVER_ADDR'] == '192.168.1.22');

define('EMAIL_ADMIN', 'fyr.work@gmail.com');
define('EMAIL_ADMIN_CC', 'fyr.work@gmail.com');

define('PATH_FILES_UPLOAD', $_SERVER['DOCUMENT_ROOT'].'/files/');

Configure::write('version', '1.2');

Configure::write('chat', array(
	'updateTime' => 0, // in msec, 0 - do not update
	'initialEvents' => 3,
	'loadMore' => 2
));
Configure::write('groupMaxImages', 4);
Configure::write('Konstructor', array(
	'created' => '2014-11-12 00:00:00',
	'groupID' => 7
));

Configure::write('baseURL', array(
	// 'media' => '/device'
));

Configure::write('timeline', array(
	'initialPeriod' => array(0, 3), // days before today, days after today
	'loadPeriod' => 3,
	'updateTime' => 000
));

function fdebug($data, $logFile = 'tmp.log', $lAppend = true) {
	file_put_contents($logFile, mb_convert_encoding(print_r($data, true), 'cp1251', 'utf8'), ($lAppend) ? FILE_APPEND : null);
	return $data;
}