var Group = {
	panel: null, 
	
	initPanel: function (container) {
		Group.panel = container;
		$(Group.panel).load(groupURL.panel, null, function(){
			$(".searchBlock input", Group.panel).click(function(){
				$(this).val('');
			});
			$(".searchBlock input", Group.panel).change(function(){
				Group.filterContactList($(".searchBlock input", Group.panel).val());
			});
		});
	},
	
	filterContactList: function (filter) {
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
	},
	
	renderGalleryAdmin: function(data) {
		return tmpl('group-gallery-admin', data);
	},
	
	showGalleryAdmin: function(data) {
		$('.gallery-add-list').html(Group.renderGalleryAdmin(data));
		
		$('.gallery-add-list .add-video').on('click', function(){
			$(this).parent().parent().parent().parent().find('.drop-add-video').addClass('open');
		});
		$('.drop-add-video .close-block').on('click', function(){
			$(this).parent().removeClass('open');
		});
		
		$('.gallery-uploader').hide();
		if (data.length < groupDef.maxImages) {
			$('.gallery-uploader').show();
		}
	},
	
	updateGalleryAdmin: function(group_id) {
		$.get(groupURL.getGallery + '/' + group_id + '.json', null, function(response){
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
	}
}