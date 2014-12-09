var Struct = {
	$panel: null, 
	
	initPanel: function (container) {
		Struct.panel = container;
		$(Struct.panel).load(structURL.panel, null, function(){
			$('select.formstyler', Struct.panel).styler();
		});
	}
}