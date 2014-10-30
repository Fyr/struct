<!DOCTYPE html>
<html>
<head>
	<?=$this->Html->charset(); ?>
	<title><?=$title_for_layout; ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,700&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Roboto:900,700&subset=latin,cyrillic' rel='stylesheet' type='text/css'>

<?php
	$baseURL = Configure::read('baseURL');
	
	echo $this->Html->meta('icon');
	
	$css = array(
		'bootstrap.min', 
		'glyphicons', 
		'jquery.formstyler',
		'style',
		'struct_panel',
		$baseURL['chat'].'css/msg_panel.css'
	);
	echo $this->Html->css($css);
	
	$aScripts = array(
		'vendor/jquery/jquery-1.10.2.min',
		'vendor/bootstrap.min',
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
	$(".menuBar .glyphicons.ipad").bind('click', function(event) {
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
	
	$("#menuBarScroll").niceScroll({cursorwidth:"3px",cursorcolor:"#000",cursorborder:"none"});
	$("#menuBarScroll").height($(window).height());
	$("#menuBarScroll").getNiceScroll().resize();
	
	$('select').styler();
<?
	if (!TEST_ENV) {
?>	
	// Init chat panel
	Chat.initPanel($(".userMessages.chat").get(0));
	$(".menuBar .glyphicons.chat").bind('click', function(event) {
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
    <div class="menuBar">
		<div id="menuBarScroll">
			<img class="userLogo" src="<?=$currUser['Avatar']['url']?>" alt="" style="width: 90px;" />
			<div><a href="javascript: void(0)" class="glyphicons search"></a></div>
			<div><a href="javascript: void(0)" class="glyphicons chat"><span class="badge badge-important"></span></a></div>
			<div><a href="javascript: void(0)" class="glyphicons group"></a></div>
			<div><a href="javascript: void(0)" class="glyphicons notes"></a></div>
			<div><a href="javascript: void(0)" class="glyphicons briefcase"></a></div>
			<div><a href="javascript: void(0)" class="glyphicons credit_card"><span class="badge badge-important"></span></a></div>
			<div><a href="javascript: void(0)" class="glyphicons cloud"></a></div>
			<div><a href="javascript: void(0)" class="glyphicons file"></a></div>
			<div><a href="javascript: void(0)" class="glyphicons ipad"></a></div>
			<div><a href="javascript: void(0)" class="glyphicons settings" style="margin-top: 90px"></a></div>
			<div><a href="javascript: void(0)" class="glyphicons log_out"></a></div>
			<div><a href="javascript: void(0)" class="icon icon_cube"></a></div>
		</div>
	</div>
	
	<div class="userMessages struct" style="display:none"></div>
	<div class="userMessages chat" style="display:none"></div>
	<div class="pageOrder">
		<?=$this->fetch('content')?>
	</div>
</body>
</html>