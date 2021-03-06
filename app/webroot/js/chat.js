var Chat = {
	
	enableLevel: 0,
	timer: null,
	Panel: null,
	
	fixPanelHeight: function() {
		console.log('fixPanelHeight');
		$('.dialog').height($(window).height() - $(".bottom").height());
	},
	
	initPanel: function (container, userID) {
		Chat.Panel = new ChatPanel(container, userID);
		Chat.Panel.init();
		if (chatUpdateTime) {
			Chat.timer = setInterval(function(){
				Chat.updateState();
			}, chatUpdateTime);
		}
	},
	
	enableUpdate: function () {
		Chat.enableLevel--;
		if (Chat.enableLevel < 0) {
			Chat.enableLevel = 0;
		}
	},
	
	disableUpdate: function () {
		Chat.enableLevel++;
	},
	
	isUpdateEnabled: function () {
		return Chat.enableLevel == 0;
	},
	
	updateState: function () {
		if (Chat.isUpdateEnabled()) {
			Chat.disableUpdate();
			// TODO: update only opened rooms
			$.post(chatURL.updateState, null, function(response){
				if (checkJson(response)) {
					Chat.Panel.update(response.data);
					Chat.enableUpdate();
				}
			}, 'json');
		}
	}
}