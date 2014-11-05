<?php
Router::parseExtensions('html', 'json');
Router::connect('/', array('controller' => 'SiteOrders', 'action' => 'index'));

CakePlugin::routes();

require CAKE.'Config'.DS.'routes.php';
