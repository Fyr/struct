var Struct = {
	fixDialogHeight: function () {
		var ordersHeight = $(window).height() - 230;
		$("#allOrders").height(ordersHeight);
		$("#allOrders").getNiceScroll().resize();
		
		$("#menuBarScroll").height($(window).height());
		$("#menuBarScroll").getNiceScroll().resize();
	},
	
	deviceListShow: function () {
		$(".userMessages").show();
		$("#allOrders").getNiceScroll().show();
		$(".menuBar div").removeClass("active");
		$(".menuBar .glyphicons.ipad").closest("div").addClass("active");
	},
	
	deviceListHide: function () {
		$(".userMessages").hide();
		$("#allOrders").getNiceScroll().hide();
		$(".menuBar .glyphicons.ipad").closest("div").removeClass("active");
	},
	
	deviceListToggle: function () {
		if ($(".userMessages").is(':visible')) {
			Struct.deviceListHide();
		} else {
			$("#allOrders").load(structURL.deviceList, null, function(){
				Struct.deviceListShow();
			});
		}
	},
	
	initPanel: function () {
		$(".userMessages").load(structURL.panel, null, function(){
			$("#allOrders").niceScroll({cursorwidth:"5px",cursorcolor:"#999999",cursorborder:"none"});
			Struct.fixDialogHeight();
		});
	}
}