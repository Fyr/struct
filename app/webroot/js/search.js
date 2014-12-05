var Search = {
	panel: null, 
	
	initPanel: function (container) {
		Search.panel = container;
		$(Search.panel).load(profileURL.panel, null, function(){
			Search.initHandlers();
		});
	},
	
	initHandlers: function() {
		$('#searchUserForm').ajaxForm({
			url: profileURL.panel,
			target: Search.panel,
			success: function() { Search.initHandlers(); }
		});
	}
}