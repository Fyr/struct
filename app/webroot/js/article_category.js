var ArticleCategory = {
	panel: null, 
	
	initPanel: function (container) {
		ArticleCategory.panel = container;
		$(ArticleCategory.panel).load(articleURL.notes, null, function(){
			ArticleCategory.initHandlers();
		});
	},
	
	initHandlers: function() {
		$('#searchArticleCatForm').ajaxForm({
			url: articleURL.notes,
			target: ArticleCategory.panel,
			success: function() { ArticleCategory.initHandlers(); }
		});
	}
}