<!doctype html>
<html lang="ru">
<head>
	<?=$this->Html->charset(); ?>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	
	<title><?=$title_for_layout; ?></title>
	
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<script>
		document.createElement('video');
	</script>
	<![endif]-->
	
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700&subset=latin,cyrillic' rel='stylesheet' type='text/css'>

<?php
	echo $this->Html->meta('icon');
	
	$css = array(
		'reset', 
		'fonts', 
		'bootstrap/bootstrap', 
		'main-panel',
		'content',
		'chat-page',
		'chat-old',
		'device-page',
		'progress-bar'
	);
	echo $this->Html->css($css);
	
	$aScripts = array(
		'vendor/jquery/jquery-1.10.2.min',
		'vendor/jquery/jquery.easing.1.3',
		'vendor/formstyler',
		'vendor/tmpl.min',
		'/core/js/json_handler',
		'main-panel',
		'chat',
		'struct',
		'search',
		'group'
	);
	
	// Files required for upload
	$aScripts[] = 'vendor/jquery/jquery.ui.widget';
	$aScripts[] = 'vendor/jquery/jquery.iframe-transport';
	$aScripts[] = 'vendor/jquery/jquery.fileupload';
	$aScripts[] = '/Table/js/format';
	$aScripts[] = 'upload';
	
	echo $this->Html->script($aScripts);

	echo $this->fetch('meta');
	echo $this->fetch('css');
	echo $this->fetch('script');
?>
	<script type="text/javascript" src="<?=$this->Html->url(array('controller' => 'ChatAjax', 'action' => 'jsSettings'))?>"></script>
	<script type="text/javascript" src="<?=$this->Html->url(array('controller' => 'DeviceAjax', 'action' => 'jsSettings'))?>"></script>
	<script type="text/javascript" src="<?=$this->Html->url(array('controller' => 'ProfileAjax', 'action' => 'jsSettings'))?>"></script>
	<script type="text/javascript" src="<?=$this->Html->url(array('controller' => 'GroupAjax', 'action' => 'jsSettings'))?>"></script>
<script type="text/javascript">
var objectType = 'Chat', objectID = null;
$(document).ready(function () {
	
	$(window).resize(function() {
		Chat.fixPanelHeight();
	});
	
	$('select.formstyler').styler();
	Search.initPanel($('.dropdown-searchPanel .dropdown-panel-wrapper').get(0));
	Chat.initPanel($(".dropdown-chatPanel .dropdown-panel-wrapper").get(0), <?=(isset($chatUserID)) ? $chatUserID : 'false'?>);
	Struct.initPanel($('.dropdown-ipadPanel .dropdown-panel-wrapper').get(0));
	Group.initPanel($('.dropdown-groupPanel .dropdown-panel-wrapper').get(0));
	
	$(".sendForm .icon_enter").bind('click', function() {
		Chat.sendMsg();
	});
	
	$(".sendForm textarea").bind('keypress', function(event) {
		if ( event.which == 13 ) {
			event.preventDefault();
			Chat.sendMsg();
		}
	});
});	
</script>
</head>
<body>

<?=$this->element('panel_menu')?>
<?
	if ($this->request->controller == 'Chat') {
?>
<div class="wrapper-container chat-page">
    <div class="usersInChat">
    	<!--
        <a href="javascript: void(0)" class="icon icon_add"></a>
        <a href="javascript: void(0)"><img src="/img/temp/2.jpg" alt="" /></a>
        <a href="javascript: void(0)"><img src="/img/temp/3.jpg" class="active" alt="" /></a>
        <a href="javascript: void(0)"><img src="/img/temp/1.jpg" alt="" /></a>
        -->
    </div>
    <div class="bottom">
        <div class="openChats clearfix">
            <?=$this->element('chat_rooms')?>
        </div>
        <?=$this->element('send_message')?>
    </div>
    <div class="dialog clearfix">
        <div class="innerDialog">
            <?=$this->fetch('content')?>
        </div>
    </div>
</div>
<?
	} else {
?>
<div class="wrapper-container">
	<div class="device-page">
        <div class="container-fluid header-device-page">
            <div class="row clearfix">
                <div class="device-page-title col-md-8 col-sm-8 col-xs-8"><?=$pageTitle?></div>
                <div class="state-of-account col-md-4 col-sm-4 col-xs-4 t-a-right clearfix">
                    <a href="<?=$this->Html->url(array('controller' => 'Device', 'action' => 'orders'))?>" class="device-my-orders"><?=__('My orders')?></a>
                    <div class="account-money">
                        <div class=""><?=__('Balance')?>: <b><?=$this->element('sum', array('sum' => $balance))?></b></div>
                        <a href="<?=$this->Html->url(array('controller' => 'Device', 'action' => 'recharge'))?>" class="replenish"><?=__('Recharge balance')?></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid device-page-wrapper">
            <?=$this->fetch('content')?>
        </div>
    </div>
</div>
<?
	}
?>
<?=$this->element('js_templates')?>
</body>
</html>