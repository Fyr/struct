var Group = {
	panel: null, 
	
	initPanel: function (container) {
		Group.panel = container;
		$(Group.panel).load(groupURL.panel, null, function(){
			Group.initHandlers();
		});
	},
	
	initHandlers: function() {
		$(".searchBlock .searchInput", Group.panel).click(function(){
			this.select();
		});
		$(".searchBlock .searchButton", Group.panel).click(function(){
			Group.filterContactList($(".searchBlock .searchInput", Group.panel).val());
		});
	},
	
	filterContactList: function (filter) {
		$(Group.panel).load(groupURL.panel, {data: {q: filter}}, function(){
			Group.initHandlers();
		});
		/*
		$(".simple-list-item", Group.panel).each(function(){
			if (filter) {
				var name = $(".user-list-item-name", this).html();
				if (name.substr(0, filter.length).toLowerCase() == filter.toLowerCase()) {
					$(this).show();
				} else {
					$(this).hide();
				}
			} else {
				$(this).show();
			}
		});
		*/
	},
	
	renderGalleryVideoAdmin: function(data) {
		return tmpl('group-gallery-video-admin', data);
	},
	
	renderGalleryImageAdmin: function(data) {
		return tmpl('group-gallery-image-admin', data);
	},
	
	showGalleryAdmin: function(data) {
		$('.gallery-add-list').html(Group.renderGalleryVideoAdmin(data.videos) + Group.renderGalleryImageAdmin(data.images));
		
		$('.gallery-add-list .add-video').on('click', function(){
			$(this).parent().parent().parent().parent().find('.drop-add-video').addClass('open');
		});
		$('.drop-add-video .close-block').on('click', function(){
			$(this).parent().removeClass('open');
		});
		
		$('.gallery-uploader').hide();
		if ((data.images.length + data.videos.length) < groupDef.maxImages) {
			$('.gallery-uploader').show();
		}
	},
	
	updateGalleryAdmin: function(group_id) {
		$.post(groupURL.getGallery, {data: {group_id: group_id}}, function(response){
			if (checkJson(response)) {
				Group.showGalleryAdmin(response.data);
			}
		});
	},
	
	delGalleryImage: function(group_id, id) {
		$.get(groupURL.delGalleryImage + '/' + group_id + '/'  + id + '.json', null, function(response){
			if (checkJson(response)) {
				Group.showGalleryAdmin(response.data);
			}
		});
	},
	
	addGalleryVideo: function(group_id) {
		var url = $('.gallery-add #add-new-video').val();
		if (url) {
			$('.gallery-add .drop-add-video').removeClass('open');
			$.post(groupURL.addGalleryVideo, {data: {group_id: group_id, url: url}}, function(response){
				if (checkJson(response)) {
					$('.gallery-add #add-new-video').val('');
					Group.showGalleryAdmin(response.data);
				}
			});
		}
	},
	
	delGalleryVideo: function(group_id, id) {
		$.post(groupURL.delGalleryVideo, {data: {group_id: group_id, id: id}}, function(response){
			if (checkJson(response)) {
				Group.showGalleryAdmin(response.data);
			}
		});
	}
}