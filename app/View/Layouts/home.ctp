<!DOCTYPE html>
<html lang="en">
<head>
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

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <script>
        document.createElement('video');
    </script>
    <![endif]-->
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

<div class="index-block">
    <div class="index-block-bg"></div>
</div>
<div class="index-wrapper">
    <div class="container">
		<?=$this->fetch('content')?>
    </div>
    <div class="footer_placeholder"></div>
    <div class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <div class="copyright-wrap">
                        <div class="copyright">
                            © KONSRTRUKTOR US lab LLC
                            <div class="copyright-year">2002-2014</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4 col-md-offset-2 col-sm-offset-2 taright">
                </div>
            </div>
        </div>
    </div>


</div>
</body>
</html>