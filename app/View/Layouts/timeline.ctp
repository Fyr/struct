<!doctype html>
<html lang="ru">
<head>
	<?=$this->Html->charset(); ?>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name = "format-detection" content = "telephone=no">
	<title>Konstruktor: <?=__('Timeline')?></title>
	
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
		'user-profile'
	);
	echo $this->Html->css($css);
	
	$aScripts = array(
		'vendor/jquery/jquery-1.10.2.min',
		'vendor/jquery/jquery-ui.min',
		'vendor/easing.1.3',
		'vendor/formstyler',
		'vendor/bootstrap.min',
		'vendor/moment',
		'vendor/bootstrap-datetimepicker',
		'vendor/bootstrap-tokenfield',
		'vendor/meiomask',
		'vendor/tmpl.min',
		'/core/js/json_handler',
		'main-panel',
		'chat',
		'struct',
		'search',
		'settings-script',
		'group-script',
		'group',
		'user-profile-script',
		'timeline'
	);
	
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
		fileBrowse: '<?=__('Upload image')?>'
	});
	$('input.clock-mask').setMask('time');
	
	Search.initPanel($('.dropdown-searchPanel .dropdown-panel-wrapper').get(0));
	Chat.initPanel($('.dropdown-chatPanel .dropdown-panel-wrapper').get(0));
	Struct.initPanel($('.dropdown-ipadPanel .dropdown-panel-wrapper').get(0));
	Group.initPanel($('.dropdown-groupPanel .dropdown-panel-wrapper').get(0));
});
</script>
</head>
<body>

<?=$this->element('panel_menu')?>

<div class="wrapper-container time-line-bg">
    <div class="settings-page">
        <div class="container-fluid user-page-header">
            <div class="row user-page-header-inner">
                <div class="col-md-12 col-sm-12 col-xs-12 ">
                    <div class="col-md-6 col-sm-6 col-xs-6">
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <div class="group-menu page-menu t-a-right">
                            <div class="btn-group btn-group-sm">
                                <button id="showDay" type="button" class="btn btn-default"><?=__('Day')?></button>
                                <button id="showWeek" type="button" class="btn"><?=__('Week')?></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid user-page-wrapp">
			<?=$this->fetch('content')?>
        </div>
    </div>
</div>

<?=$this->element('js_templates')?>
</body>
</html>