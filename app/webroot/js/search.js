var Search = {
	panel: null, 
	
	initPanel: function (container) {
		Search.panel = container;
		$(Search.panel).load(profileURL.panel, null, function(){
			Search.initHandlers();
		});
	},
	
	initHandlers: function() {
		$(".searchBlock input", Search.panel).click(function(){
			this.select();
		});
		$(".searchBlock .searchButton", Search.panel).click(function(){
			Search.filterContactList($(".searchBlock input", Search.panel).val());
		});
	},
	
	filterContactList: function (filter) {
		$(Search.panel).load(profileURL.panel, {data: {q: filter}}, function(){
			Search.initHandlers();
		});
		/*
		$(".simple-list-item", Search.panel).each(function(){
			if (filter) {
				var name = $(".user-list-item-name", this).html();
				if (name.substr(0, filter.length).toLowerCase() == filter.toLowerCase()) {
					$(this).show();
				} else {
					$(this).hide();
				}
			} else {
				$(this).hide();
			}
		});
		*/
	}
}