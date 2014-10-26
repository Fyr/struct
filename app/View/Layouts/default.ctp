<!DOCTYPE html>
<html>
<head>
	<?=$this->Html->charset(); ?>
	<title><?=$title_for_layout; ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,700&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Roboto:900,700&subset=latin,cyrillic' rel='stylesheet' type='text/css'>

<?php
	echo $this->Html->meta('icon');
	
	$css = array(
		'bootstrap.min', 
		'glyphicons', 
		'jquery.formstyler',
		'style'
	);
	echo $this->Html->css($css);
	
	$aScripts = array(
		'vendor/jquery/jquery-1.10.2.min',
		'vendor/bootstrap.min',
		'vendor/jquery/jquery.nicescroll.min',
		'vendor/jquery/jquery.formstyler.min',
		'/core/js/json_handler'
	);
	echo $this->Html->script($aScripts);

	echo $this->fetch('meta');
	echo $this->fetch('css');
	echo $this->fetch('script');
?>
</head>
<body>
<script type="text/javascript">
function fixDialogHeight() {
	var messagesHeight = $(window).height() - 82;
	$("#allMessages").height(messagesHeight);
	
	var dialogHeight = $(window).height() - $(".bottom").height();
	$(".dialog").height(dialogHeight);
	
	var ordersHeight = $(window).height() - 230;
	$("#allOrders").height(ordersHeight);
	
	$("#menuBarScroll").height($(window).height());
}

function deviceListShow() {
	$("#orders").show();
	$("#allOrders").niceScroll({cursorwidth:"5px",cursorcolor:"#999999",cursorborder:"none"});
	$("#allOrders").getNiceScroll().show();
	$(".menuBar div").removeClass("active");
	$(".menuBar .glyphicons.ipad").closest("div").addClass("active");
}

function deviceListHide() {
	$("#orders").hide();
	$("#allOrders").getNiceScroll().hide();
	$(".menuBar .glyphicons.ipad").closest("div").removeClass("active");
}

function deviceListToggle() {
	if ($("#orders").is(':visible')) {
		deviceListHide();
	} else {
		$("#allOrders").load(structURL.deviceList, null, function(){
			deviceListShow();
		});
	}
}

var structURL = {
	deviceList: '<?=$this->Html->url(array('controller' => 'SiteAjax', 'action' => 'deviceList'))?>'
}

$(document).ready(function () {
	$(window).resize(function() {
		fixDialogHeight();
	});
	
	fixDialogHeight();
	
	$(".dialog").niceScroll({cursorwidth:"5px",cursorcolor:"#999999",cursorborder:"none"});
	$("#menuBarScroll").niceScroll({cursorwidth:"3px",cursorcolor:"#000",cursorborder:"none"});
	$(".sendForm textarea").niceScroll({cursorwidth:"5px",cursorcolor:"#999999",cursorborder:"none", autohidemode: "false"});
	
	$(".dialog").scrollTop($(".innerDialog").height() - $(".dialog").height() + 97);
	
	$('select').styler();  
	
	$(".menuBar .glyphicons:not(.chat,.ipad)").bind('click', function(event) {
		$(".menuBar div").removeClass("active");
		$(this).closest("div").addClass("active");
		$("#messagesBar,#orders").hide();
	});
	/*
	$(".menuBar .glyphicons.chat").bind('click', function(event) {
		$("#messagesBar").toggle();
		if ( $("#messagesBar").is(':visible') ) {
			$("#allMessages").niceScroll({cursorwidth:"5px",cursorcolor:"#999999",cursorborder:"none"});
			$("#allMessages").getNiceScroll().show();
			$(".menuBar div").removeClass("active");
			$(this).closest("div").addClass("active");
		}
		else {
			$("#allMessages").getNiceScroll().hide();
			$(this).closest("div").removeClass("active");
		}
	});
	*/
	$(".menuBar .glyphicons.ipad").bind('click', function(event) {
		deviceListToggle();
	});
});			
</script>
    <div class="menuBar">
		<div id="menuBarScroll">
			<img class="userLogo" src="<?=$currUser['Avatar']['url']?>" alt="" style="width: 90px;" />
			<div><a href="javascript: void(0)" class="glyphicons search"></a></div>
			<div><a href="javascript: void(0)" class="glyphicons chat"><span class="badge badge-important">11</span></a></div>
			<div><a href="javascript: void(0)" class="glyphicons group"></a></div>
			<div><a href="javascript: void(0)" class="glyphicons notes"></a></div>
			<div><a href="javascript: void(0)" class="glyphicons briefcase"></a></div>
			<div><a href="javascript: void(0)" class="glyphicons credit_card"><span class="badge badge-important">1</span></a></div>
			<div><a href="javascript: void(0)" class="glyphicons cloud"></a></div>
			<div><a href="javascript: void(0)" class="glyphicons file"></a></div>
			<div><a href="javascript: void(0)" class="glyphicons ipad"></a></div>
			<div><a href="javascript: void(0)" class="glyphicons settings" style="margin-top: 90px"></a></div>
			<div><a href="javascript: void(0)" class="glyphicons log_out"></a></div>
			<div><a href="javascript: void(0)" class="icon icon_cube"></a></div>
		</div>
	</div>
	
	<div class="userMessages" id="orders" style="display:none">
		<div class="searchBlock clearfix">
			<input type="text" value="Найти устройство"  />
			<a href="javascript: void(0)" class="glyphicons search"></a>
		</div>
		<div class="myOrders">
			<a href="<?=$this->Html->url(array('controller' => 'SiteOrders', 'action' => 'orders'))?>" class="btn"><?=__('My orders')?></a>
		</div>
		<div id="allOrders">
			<?=$this->element('device_list')?>
		</div>
		<div class="recharge clearfix">
			<span class="glyphicons wallet"></span>
			<div class="text">
				<div class="balance"><?=__('Balance')?>: <?=$this->element('sum', array('sum' => $balance))?></div>
				<a href="<?=$this->Html->url(array('controller' => 'SiteOrders', 'action' => 'recharge'))?>"><?=__('Recharge')?></a>
			</div>
		</div>
	</div>
	<div class="pageOrder">
		<?=$this->fetch('content')?>
	</div>
</body>
</html>