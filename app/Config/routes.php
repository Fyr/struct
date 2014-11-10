<?php
Router::parseExtensions('html', 'json');
Router::connect('/', array('controller' => 'Profile', 'action' => 'edit'));

CakePlugin::routes();

require CAKE.'Config'.DS.'routes.php';
