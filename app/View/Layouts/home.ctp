<!DOCTYPE html>
<html lang="en">
<head>
	<!--[if lt IE 9]>
		<meta http-equiv="Refresh" content="0; URL=/html/include/ie.html" />
	<![endif]-->
    <?=$this->Html->charset(); ?>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Konstruktor: <?=__('Main page')?></title>
    <meta name="description" content="">
    <meta name="author" content="">

    <link href="img/favicon/apple-touch-icon-144x144-precomposed.png" rel="apple-touch-icon-precomposed" sizes="144x144" />
    <link href="img/favicon/apple-touch-icon-114x114-precomposed.png" rel="apple-touch-icon-precomposed" sizes="114x114" />
    <link href="img/favicon/apple-touch-icon-72x72-precomposed.png" rel="apple-touch-icon-precomposed" sizes="72x72" />
    <link href="img/favicon/apple-touch-icon-57x57-precomposed.png" rel="apple-touch-icon-precomposed" />

<?
	echo $this->Html->meta('icon');
	
	$css = array(
		'reset', 
		'fonts', 
		'bootstrap/bootstrap', 
		'main-panel',
		'content',
		'index-page'
	);
	echo $this->Html->css($css);
	
	$aScripts = array(
		'vendor/jquery/jquery-1.10.2.min',
		'vendor/easing.1.3',
		'vendor/bootstrap.min',
		'index-page'
	);
	echo $this->Html->script($aScripts);

	echo $this->fetch('meta');
	echo $this->fetch('css');
	echo $this->fetch('script');
?>

	<!--[if lt IE 9]>
<?=$this->Html->script('vendor/html5shiv.min')?>
<?=$this->Html->script('vendor/respond.min')?>
	<script>
		document.createElement('video');
	</script>

<?//$this->Html->css('ie8-index')?>
	<![endif]-->
	
</head>
<body>
<script type="text/javascript">
    /*<![CDATA[*/
    switchIndexForms = function () {
        $("#login_form_block").toggle(300);
        $("#register_form_block").toggle(300);
    };
    /*]]>*/
</script>

<div class="index-wrapper">
    <div class="container">
		<?=$this->fetch('content')?>
    </div>
</div>
<div class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-sm-8 col-xs-8">
                <div class="copyright-wrap">
                    <div class="copyright">
                        © KONSRTRUKTOR US lab LLC
                        <div class="copyright-year">2002-2014</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-4 taright footer-menu-block">
                <div class="footer-menu">
                    <ul>
                        <!--<li><a href="#">О проекте</a></li>-->
                        <li><a href="/policy.pdf" target="_blank">Privacy Policy</a></li>
                        <!--<li><a href="#">Помощь</a></li>-->
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>