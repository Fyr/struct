<!doctype html>
<html lang="ru">
<head>
	<!--[if lt IE 9]>
		<meta http-equiv="Refresh" content="0; URL=/html/include/ie.html" />
	<![endif]-->
	<?=$this->Html->charset(); ?>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="user-scalable=no" />
	<title>Konstruktor.com - <?=__('Messenger')?></title>
	
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700&subset=latin,cyrillic' rel='stylesheet' type='text/css'>

<?php
	echo $this->Html->meta('icon');
	
	$vendorCss = array(
		'reset', 
		'fonts', 
		'bootstrap/bootstrap'
	);
	$css = array(
		'main-panel',
		'content',
		// 'chat-page',
		'chat-old',
		'device-page',
		'progress-bar'
	);
	foreach($css as &$_css) {
		$_css.= '.css?v='.Configure::read('version');
	}
	echo $this->Html->css(array_merge($vendorCss, $css));
	
	$scripts = array(
		'vendor/jquery/jquery-1.10.2.min',
		'vendor/jquery/jquery.easing.1.3',
		'vendor/jquery/jquery.backgroundSize',
		'vendor/jquery/jquery.form.min',
		'vendor/jquery/jquery.ui.widget',
		'vendor/jquery/jquery.iframe-transport',
		'vendor/jquery/jquery.fileupload',
		'vendor/formstyler',
		'vendor/tmpl.min',
		'/core/js/json_handler',
		'/table/js/format',
		'main-panel',
		'xdate',
		'chat', 'chat_panel', 'chat_room',
		'struct',
		'search',
		'article', 'article_category',
		'group',
		'upload'
	);
	
	foreach($scripts as &$_js) {
		$_js.= '.js?v='.Configure::read('version');
	}
	echo $this->Html->script(array_merge($vendorScripts, $scripts));

	echo $this->fetch('meta');
	echo $this->fetch('css');
	echo $this->fetch('script');
	
	$aControllers = array('ChatAjax', 'DeviceAjax', 'UserAjax', 'GroupAjax', 'ArticleAjax');
	foreach($aControllers as $_controller) {
?>
	<script src="<?=$this->Html->url(array('controller' => $_controller, 'action' => 'jsSettings'))?>?v=<?=Configure::read('version')?>"></script>
<?
	}
?>	
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
	Article.initPanel($('.dropdown-filePanel .dropdown-panel-wrapper').get(0));
	ArticleCategory.initPanel($('.dropdown-notesPanel .dropdown-panel-wrapper').get(0));
	
	$(".sendForm .icon_enter").bind('click', function() {
		Chat.Panel.rooms[Chat.Panel.activeRoom].sendMsg();
	});
	
	$(".sendForm textarea").bind('keypress', function(event) {
		if ( event.which == 13 ) {
			event.preventDefault();
			Chat.Panel.rooms[Chat.Panel.activeRoom].sendMsg();
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
    <div class="usersInChat chat-members">
		<!--a href="javascript: void(0)" class="addUser glyphicons plus text-center"></a-->
	</div>
    <div class="bottom">
        <div class="openChats chat-tabs clearfix"></div>
        <?=$this->element('/Chat/send_message')?>
    </div>
    <div class="chat-dialogs">
    	<?=$this->fetch('content')?>
	    <!--div class="dialog clearfix">
	        <div class="innerDialog">
	            
	        </div>
	    </div-->
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