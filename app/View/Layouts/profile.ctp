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
		'bootstrap/bootstrap-datepicker',
		'bootstrap/bootstrap-tokenfield',
		'main-panel',
		'content',
		'd_custom',
		'settings-page',
		'group-page'
	);
	echo $this->Html->css($css);
	
	$aScripts = array(
		'vendor/jquery/jquery-1.10.2.min',
		// 'vendor/jquery/jquery-ui-1.10.3.custom.min',
		'vendor/jquery/jquery-ui.min',
		'vendor/easing.1.3',
		'vendor/formstyler',
		'vendor/bootstrap.min',
		'vendor/moment',
		'vendor/bootstrap-datetimepicker',
		'vendor/bootstrap-tokenfield',
		'vendor/autosize.min',
		'vendor/tmpl.min',
		'/core/js/json_handler',
		'main-panel',
		'chat',
		'struct',
		'search',
		'settings-script',
		'group-script',
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
	<script src="<?=$this->Html->url(array('controller' => 'ChatAjax', 'action' => 'jsSettings'))?>"></script>
	<script src="<?=$this->Html->url(array('controller' => 'DeviceAjax', 'action' => 'jsSettings'))?>"></script>
	<script src="<?=$this->Html->url(array('controller' => 'ProfileAjax', 'action' => 'jsSettings'))?>"></script>
	<script src="<?=$this->Html->url(array('controller' => 'GroupAjax', 'action' => 'jsSettings'))?>"></script>
<script>
$(function() {
	$(window).resize(function() {
		Chat.fixPanelHeight();
	});
	
	$('select.formstyler, input.filestyle').styler({
		fileBrowse: 'Загрузить фото'
	});
	$('.textarea-auto').autosize();
	
	Search.initPanel($('.dropdown-searchPanel .dropdown-panel-wrapper').get(0));
	Chat.initPanel($('.dropdown-chatPanel .dropdown-panel-wrapper').get(0));
	Struct.initPanel($('.dropdown-ipadPanel .dropdown-panel-wrapper').get(0));
	Group.initPanel($('.dropdown-groupPanel .dropdown-panel-wrapper').get(0));
});
</script>
</head>
<body>

<div class="main-panel">
    <div class="main-panel-dropdown">
        <?=$this->element('panels')?>
    </div>
    <div class="main-panel-block">
        <div class="main-panel-wrapper">
            <div class="user-image">
                <a href="/profile/user/"><img src="<?=$currUser['Avatar']['url']?>" alt="<?=$currUser['ChatUser']['name']?>" style="width: 90px;"/></a>
            </div>
            <?=$this->element('panel_icons')?>
        </div>
    </div>
</div>

<div class="wrapper-container">
    <div class="settings-page search-page group-page">
        <div class="container-fluid">
            <?=$this->fetch('content')?>
        </div>
    </div>
</div>
<?
	// почему то нужно для чата, когда приходит новое уведомление
?>
<?=$this->element('js_templates')?>
</body>
</html>