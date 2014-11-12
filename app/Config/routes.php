<?php
Router::parseExtensions('html', 'json');
Router::connect('/', array('controller' => 'Users', 'action' => 'login'));

CakePlugin::routes();

require CAKE.'Config'.DS.'routes.php';
