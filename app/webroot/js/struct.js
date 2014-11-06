var Struct = {
	$panel: null, 
	
	fixPanelHeight: function () {
	},
	/*
	panelShow: function () {
		$(Struct.panel).show();
		$(".menuBar div").removeClass("active");
		$(".menuBar .devicePanel").closest("div").addClass("active");
	},
	
	panelHide: function () {
		$(Struct.panel).hide();
		$(".menuBar .devicePanel").closest("div").removeClass("active");
	},
	
	panelToggle: function () {
		if ($(Struct.panel).is(':visible')) {
			Struct.panelHide();
		} else {
			$(".allOrders", Struct.panel).load(structURL.deviceList, null, function(){
				Struct.panelShow();
				$('select.formstyler', Struct.panel).styler();
			});
		}
	},
	*/
	initPanel: function (container) {
		Struct.panel = container;
		$(Struct.panel).load(structURL.panel, null, function(){
			$('select.formstyler', Struct.panel).styler();
			Struct.fixPanelHeight();
		});
	}
}