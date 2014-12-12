var Article = {
	panel: null, 
	
	initPanel: function (container) {
		Article.panel = container;
		$(Article.panel).load(articleURL.panel, {data: {type: 'notes'}}, function(){
			Article.initHandlers();
		});
	},
	
	initHandlers: function() {
		$('#searchArticleForm').ajaxForm({
			url: articleURL.panel,
			target: Article.panel,
			success: function() { Article.initHandlers(); }
		});
	}
}