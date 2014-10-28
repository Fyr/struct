var Struct = {
	$panel: null, 
	
	fixPanelHeight: function () {
		var ordersHeight = $(window).height() - 230;
		$(".allOrders", Struct.panel).height(ordersHeight);
		$(".allOrders", Struct.panel).getNiceScroll().resize();
	},
	
	panelShow: function () {
		$(Struct.panel).show();
		$(".allOrders", Struct.panel).getNiceScroll().show();
		$(".menuBar div").removeClass("active");
		$(".menuBar .glyphicons.ipad").closest("div").addClass("active");
	},
	
	panelHide: function () {
		$(Struct.panel).hide();
		$(".allOrders", Struct.panel).getNiceScroll().hide();
		$(".menuBar .glyphicons.ipad").closest("div").removeClass("active");
	},
	
	panelToggle: function () {
		if ($(Struct.panel).is(':visible')) {
			Struct.panelHide();
		} else {
			$(".allOrders", Struct.panel).load(structURL.deviceList, null, function(){
				Struct.panelShow();
			});
		}
	},
	
	initPanel: function (container) {
		Struct.panel = container;
		$(Struct.panel).load(structURL.panel, null, function(){
			$(".allOrders", Struct.panel).niceScroll({cursorwidth:"5px",cursorcolor:"#999999",cursorborder:"none"});
			Struct.fixPanelHeight();
		});
	}
}