<!DOCTYPE html>
<html>
<head>
	<?=$this->Html->charset(); ?>
	<title><?=$pageTitle; ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,700&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Roboto:900,700&subset=latin,cyrillic' rel='stylesheet' type='text/css'>

<?php
	$baseURL = Configure::read('baseURL');
	
	echo $this->Html->meta('icon');
	
	/*
	$css = array(
		'bootstrap.min', 
		'glyphicons', 
		'jquery.formstyler',
		'style',
		'struct_panel',
		$baseURL['chat'].'css/msg_panel.css'
	);
	*/
	$css = array(
		'fonts',
		'bootstrap', 
		'glyphicons', 
		'custom',
		'user-inner',
		'device',
		$baseURL['chat'].'css/msg_panel.css'
		/*
		'jquery.formstyler',
		*/
	);
	
	echo $this->Html->css($css);
	
	/*
	$aScripts = array(
		'vendor/jquery/jquery-1.10.2.min',
		'vendor/bootstrap.min',
		'vendor/jquery/jquery.nicescroll.min',
		'vendor/jquery/jquery.formstyler.min',
		'/core/js/json_handler',
		'struct',
		$this->Html->url(array('controller' => 'SiteAjax', 'action' => 'jsSettings'), true)
	);
	*/
	$aScripts = array(
		'vendor/jquery/jquery-1.10.2.min',
		'new/bootstrap',
		'new/bootstrap-filestyle',
		'vendor/jquery/jquery.nicescroll.min',
		'vendor/jquery/jquery.formstyler.min',
		'/core/js/json_handler',
		'struct',
		$this->Html->url(array('controller' => 'SiteAjax', 'action' => 'jsSettings'), true)
	);
	if (!TEST_ENV) {
		$aScripts[] = $baseURL['chat'].'ChatAjax/jsSettings';
		$aScripts[] = $baseURL['chat'].'js/chat.js';
	}
	echo $this->Html->script($aScripts);

	echo $this->fetch('meta');
	echo $this->fetch('css');
	echo $this->fetch('script');
?>
</head>
<body>
<script type="text/javascript">
$(document).ready(function () {
	$(window).resize(function() {
		$("#menuBarScroll").height($(window).height());
		$("#menuBarScroll").getNiceScroll().resize();
		
		Struct.fixPanelHeight();
<?
	if (!TEST_ENV) {
?>		
		Chat.fixPanelHeight();
<?
	}
?>
	});
	
	Struct.initPanel($(".userMessages.struct").get(0));
	$(".menuBar .devicePanel").bind('click', function(event) {
<?
	if (!TEST_ENV) {
?>
		if ($(".userMessages.chat").is(':visible')) {
			Chat.panelHide();
		}
<?
	}
?>
		Struct.panelToggle();
	});
	
	$("#menuBarScroll").niceScroll({cursorwidth:"0px",cursorcolor:"#000",cursorborder:"none"});
	$("#menuBarScroll").height($(window).height());
	$("#menuBarScroll").getNiceScroll().resize();
	
	$('select.formstyler').styler();
<?
	if (!TEST_ENV) {
?>	
	// Init chat panel
	Chat.initPanel($(".userMessages.chat").get(0));
	$(".menuBar .chatPanel").bind('click', function(event) {
		if ($(".userMessages.struct").is(':visible')) {
			Struct.panelHide();
		}
		Chat.panelToggle();
	});
<?
	}
?>	
});			
</script>
	<div class="userMessages struct" style="display:none"></div>
	<div class="userMessages chat" style="display:none"></div>
	<div class="device-page">
        <div class="container-fluid header-device-page">
            <div class="row clearfix">
                <div class="device-page-title col-md-8 col-sm-8 col-xs-8"><?=$pageTitle?></div>
                <div class="state-of-account col-md-4 col-sm-4 col-xs-4 t-a-right clearfix">
                    <a onclick="return false;" href="<?=$this->Html->url(array('controller' => 'SiteOrders', 'action' => 'orders'))?>" class="device-my-orders"><?=__('My orders')?></a>
                    <div class="account-money">
                        <div class=""><?=__('Balance')?>: <b><?=$this->element('sum', array('sum' => $balance))?></b></div>
                        <a href="<?=$this->Html->url(array('controller' => 'SiteOrders', 'action' => 'recharge'))?>" class="replenish"><?=__('Recharge')?></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid device-page-wrapper">
            <?=$this->fetch('content')?>
        </div>
    </div>
	<div class="side-menu-bg"></div>
	<div class="side-menu-wrap-wrap menuBar">
	    <div id="menuBarScroll" class="side-menu-wrap">
	        <div class="avatar-box">
				<img src="<?=$currUser['Avatar']['url']?>" alt="<?=$currUser['ChatUser']['name']?>" style="width: 90px;" />
	        </div>
	        <div class="side-menu">
	            <?=$this->element('panel_icons')?>
	        </div>
	    </div>
	</div>
</body>
</html>