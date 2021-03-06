<!doctype html>
<html lang="ru">
<head>
	<!--[if lt IE 9]>
		<meta http-equiv="Refresh" content="0; URL=/html/include/ie.html" />
	<![endif]-->
	<?=$this->Html->charset(); ?>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="user-scalable=no" />
	<title>Konstruktor: <?=__('Timeline')?></title>
	
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700&subset=latin,cyrillic' rel='stylesheet' type='text/css'>

<?php
	echo $this->Html->meta('icon');
	
	$vendorCss = array(
		'reset', 
		'fonts', 
		'bootstrap/bootstrap', 
		'bootstrap/bootstrap-datepicker',
		'bootstrap/bootstrap-tokenfield'
	);
	
	$css = array(
		'main-panel',
		'content',
		'user-profile'
	);
	foreach($css as &$_css) {
		$_css.= '.css?v='.Configure::read('version');
	}
	echo $this->Html->css(array_merge($vendorCss, $css));
	
	$vendorScripts = array(
		'vendor/jquery/jquery-1.10.2.min',
		'vendor/jquery/jquery.backgroundSize',
		'vendor/jquery/jquery-ui.min',
		'vendor/jquery/jquery.form.min',
		'vendor/easing.1.3',
		'vendor/formstyler',
		'vendor/bootstrap.min',
		'vendor/moment',
		'vendor/bootstrap-datetimepicker',
		'vendor/bootstrap-tokenfield',
		'vendor/meiomask',
		'vendor/tmpl.min',
	);
	
	$scripts = array(
		'/core/js/json_handler',
		'/table/js/format',
		'main-panel',
		'chat', 'chat_panel', 'chat_room',
		'struct',
		'search',
		'article', 'article_category',
		'settings-script',
		'group-script',
		'group',
		'user-profile-script',
		'timeline',
		'xdate'
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
<script>
$(function() {
	$('select.formstyler, input.filestyle').styler({
		fileBrowse: '<?=__('Upload image')?>'
	});
	$('input.clock-mask').setMask('time');
	
	Search.initPanel($('.dropdown-searchPanel .dropdown-panel-wrapper').get(0));
	Chat.initPanel($('.dropdown-chatPanel .dropdown-panel-wrapper').get(0));
	Struct.initPanel($('.dropdown-ipadPanel .dropdown-panel-wrapper').get(0));
	Group.initPanel($('.dropdown-groupPanel .dropdown-panel-wrapper').get(0));
	Article.initPanel($('.dropdown-filePanel .dropdown-panel-wrapper').get(0));
	ArticleCategory.initPanel($('.dropdown-notesPanel .dropdown-panel-wrapper').get(0));
	
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
                                <button id="showDay" type="button" class="btn btn-default save-button"><?=__('Day')?></button>
                                <button id="showWeek" type="button" class="btn btn-default"><?=__('Week')?></button>
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
<?//$this->element('sql_dump')?>
</body>
</html>