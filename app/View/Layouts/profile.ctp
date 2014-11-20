<!doctype html>
<html lang="ru">
<head>
	<!--[if lt IE 8]>
		<meta http-equiv="Refresh" content="0; URL=/html/include/ie.html" />
	<![endif]-->
	<?=$this->Html->charset(); ?>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>Konstruktor: <?=__('Main page')?></title>
	
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
		'vendor/jquery/jquery.backgroundSize',
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

	<!--[if lt IE 9]>
<?=$this->Html->css('ie8')?>
<?=$this->Html->script('vendor/html5shiv.min')?>
<?=$this->Html->script('vendor/respond.min')?>
	<script>
		document.createElement('video');
	</script>
	<![endif]-->

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
	$('.textarea-auto').autosize();
	
	Search.initPanel($('.dropdown-searchPanel .dropdown-panel-wrapper').get(0));
	Chat.initPanel($('.dropdown-chatPanel .dropdown-panel-wrapper').get(0));
	Struct.initPanel($('.dropdown-ipadPanel .dropdown-panel-wrapper').get(0));
	Group.initPanel($('.dropdown-groupPanel .dropdown-panel-wrapper').get(0));
});
</script>
</head>
<body>

<?=$this->element('panel_menu')?>

<div class="wrapper-container">
    <div class="settings-page search-page group-page">
        <div class="container-fluid">
            <?=$this->fetch('content')?>
        </div>
        <!--div class="fixed-message">
            <div class="container">
                <div class="row">
                    <div class="col-md-11 col-sm-10 col-xs-8">
                        <div class="col-md-4 col-md-offset-8">
                            <div class="user-added">
                                <img src="img/temp/smallava1.jpg" alt="" />
                                Варфаламей Константинопольский добавлен в ваши друзья.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div-->
    </div>
</div>
<?=$this->element('js_templates')?>
</body>
</html>