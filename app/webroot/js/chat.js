var Chat = {
	
	enableLevel: 0,
	timer: null,
	panel: null,
	innerCall: true,
	
	zformat: function (n) {
		return (n < 10) ? '0' + n : n;
	},
	
	getCurrTime: function () {
		var date = new Date();
		return date.toSqlDateTime();// date.getHours() + ':' + Chat.zformat(date.getMinutes());
	},
	
	fixPanelHeight: function () {
		var dialogHeight = $(window).height() - $(".bottom").height();
		$(".dialog").height(dialogHeight);
	},
	
	scrollTop: function () {
		$(".dialog").scrollTop($(".innerDialog").height() - $(".dialog").height() + 97);
	},
	
	initPanel: function (container, userID) {
		Chat.panel = container;
		Chat.innerCall = userID && true;
		// load panel anyway
		$.post(chatURL.contactList, null, function(response){
			Chat.renderPanel(response.data.aUsers);
			Chat.fixPanelHeight();
			if (chatUpdateTime) {
				Chat.timer = setInterval(function(){
					Chat.updateState();
				}, chatUpdateTime);
			}
			if (userID) {
				Chat.openRoom(userID);
			}
			Chat.initHandlers();
		});
	},
	
	initHandlers: function() {
		$(".searchBlock .searchInput", Chat.panel).focus(function(){
			this.select();
			Chat.disableUpdate();
		});
		$(".searchBlock .searchInput", Chat.panel).blur(function(){
			Chat.enableUpdate();
		});
		$(".searchBlock .searchButton", Chat.panel).click(function(){
			Chat.filterContactList($(".searchBlock .searchInput", Chat.panel).val());
		});
	},
	
	renderPanel: function (aUsers) {
		return $(Chat.panel).html(tmpl('chat-panel', {innerCall: Chat.innerCall, q: $(".searchBlock .searchInput", Chat.panel).val(), aUsers: aUsers}));
	},
	/*
	panelShow: function () {
		$(Chat.panel).show();
		$(".menuBar div").removeClass("active");
		$(".menuBar .chatPanel").parent().addClass("active");
		Chat.disableUpdate();
	},
	
	panelHide: function () {
		$(Chat.panel).hide();
		$(".menuBar .chatPanel").parent().removeClass("active");
		Chat.enableUpdate();
	},
	
	panelToggle: function () {
		if ($(Chat.panel).is(':visible')) {
			Chat.panelHide();
		} else {
			$(".allMessages", Chat.panel).load(chatURL.contactList, {data: {type: (Chat.innerCall) ? '' : 'external'}}, function(){
				Chat.panelShow();
				var count = 0;
				$(".allMessages .topName span.badge").each(function(){
					count+= ($(this).html() == '10+') ? 10 : parseInt($(this).html());
				});
			});
		}
		
	},
	*/
	sendMsg: function () {
		var msg = $(".sendForm textarea").val();
		if (msg) {
			Chat.addMsg(msg);
			$(".sendForm textarea").val('');
			$.post(chatURL.sendMsg, {data: {msg: msg, roomID: Chat.getActiveRoom()}}, function(response){
				if (checkJson(response)) {
					
				}
			}, 'json');
		}

	},
	
	renderMsg: function (msg, user, time) {
		return tmpl('chat-msg', {msg: msg, user: user, time: time});
	},
	
	addMsg: function (msg, user, time, roomID) {
		if (!time) {
			time = Chat.getCurrTime();
		}
		if (!roomID) {
			roomID = Chat.getActiveRoom();
		}
		$(".dialog .innerDialog #roomChat_" + roomID).append(Chat.renderMsg(msg, user, time));
		Chat.scrollTop();
	},
	
	renderAddFile: function (msg, url, file_name) {
		return tmpl('extra-msg', {msg: msg, url: url, file_name: file_name});
	},
	
	addFile: function (msg, url, file_name, roomID) {
		if (!roomID) {
			roomID = Chat.getActiveRoom();
		}
		$(".dialog .innerDialog #roomChat_" + roomID).append(Chat.renderAddFile(msg, url, file_name));
		Chat.scrollTop();
	},
	
	sendFile: function (fileData) {
		Chat.addFile(chatLocale.fileUploaded, fileData.url_download, fileData.orig_fname);
		$.post(chatURL.sendFile, {data: {id: fileData.id, roomID: Chat.getActiveRoom()}}, function(response){
			if (checkJson(response)) {
			}
		}, 'json');
	},
	
	openRoom: function (userID) {
		// Chat.panelHide();
		Chat.disableUpdate();
		$.post(chatURL.openRoom, {data: {user_id: userID}}, function(response){
			if (checkJson(response)) {
				$(Chat.panel).html(response.data.panel);
				Chat.initHandlers();
				roomID = response.data.room.ChatRoom.id;
				if (!$(".openChats #roomTab_" + roomID).length) { 
					Chat.createRoomTab(response.data);
				}
				if (!$(".dialog .innerDialog #roomChat_" + roomID).length) { 
					$(".dialog .innerDialog").append(Chat.renderRoomChat(roomID));
				}
				Chat.dispatchEvents(response.data.events);
				Chat.activateRoom(roomID);
				Chat.scrollTop();
				closeMainPanel();
				Chat.enableUpdate();
			}
		}, 'json');
	},
	
	removeRoom: function (roomID) {
		var $nextRoom, _roomID = 0;
		if (($nextRoom = $(".openChats #roomTab_" + roomID).next()) && $nextRoom.length) {
			_roomID = $nextRoom.prop('id').replace(/roomTab_/, '');
		} else if (($nextRoom = $(".openChats #roomTab_" + roomID).prev()) && $nextRoom.length) {
			_roomID = $nextRoom.prop('id').replace(/roomTab_/, '');
		}
		
		if (_roomID) {
			$(".openChats #roomTab_" + roomID).remove();
			Chat.activateRoom(_roomID);
		} else {
			/* don't allow to close the last tab!!!
			$(".openChats .item").removeClass('active');
			$(".dialog .innerDialog .chatRoom").hide();
			$(".sendForm").hide();
			*/
		}
	},
	
	renderEvents: function (roomID, aEvents) {
		aID = new Array();
		for(var i = 0; i < aEvents.length; i++) {
			var event = aEvents[i];
			if (event.event_type == chatDef.incomingMsg || event.event_type == chatDef.outcomingMsg) {
				Chat.addMsg(event.msg, event.user, event.time, roomID);
			} else if (event.event_type == chatDef.fileDownloadAvail || event.event_type == chatDef.fileUploaded) {
				Chat.addFile(event.msg, event.url, event.file_name, roomID);
			}
			aID.push(event.id);
		}
		return aID;
	},
	
	activateRoom: function (roomID) {
		$(".openChats .item").removeClass('active');
		$(".openChats #roomTab_" + roomID).addClass('active');
		$(".sendForm").show();
		
		if ($(".openChats .item").length > 1) { // one tab
			Chat.enableCloseTabs();
		} else {
			Chat.disableCloseTabs();
		}
		
		$(".dialog .innerDialog .chatRoom").hide();
		$(".dialog .innerDialog #roomChat_" + roomID).show();
		
		var aUnreadEvents = Chat.getUnreadEvents(roomID);
		if (aUnreadEvents.length) {
			Chat.clearUnreadEvents(roomID);
			Chat.showUnreadTab(roomID);
			Chat.showUnreadTotal(Chat.countUnreadTotal());
			var readIds = Chat.renderEvents(roomID, aUnreadEvents);
			Chat.scrollTop();
			Chat.disableUpdate();
			$.post(chatURL.markRead, {data: {ids: readIds}}, function(response){
				if (checkJson(response)) {
					Chat.enableUpdate();
				}
			}, 'json');
		}
		
		Chat.fixPanelHeight();
	},
	
	renderRoomTab: function (data) {
		return tmpl('room-tab', data);
	},
	
	createRoomTab: function (data) {
		$(".openChats").append(Chat.renderRoomTab(data));
		Chat.clearUnreadEvents(data.room.ChatRoom.id);
	},
	
	disableCloseTabs: function () {
		$(".openChats .item").addClass('disable-remove');
	},
	
	enableCloseTabs: function () {
		$(".openChats .item").removeClass('disable-remove');
	},
	
	renderRoomChat: function (roomID) {
		return tmpl('room-chat', {room_id: roomID});
	},
	
	getActiveRoom: function () {
		if ($(".openChats .item.active").length) {
			return $(".openChats .item.active").prop('id').replace(/roomTab_/, '');
		}
		return false;
	},
	
	updateState: function () {
		if (Chat.isUpdateEnabled()) {
			Chat.disableUpdate();
			var data = {data: {q: $(".searchBlock .searchInput", Chat.panel).val(), type: (Chat.innerCall) ? 'internal' : ''}};
			$.post(chatURL.updateState, data, function(response){
				if (checkJson(response)) {
					Chat.renderPanel(response.data.aUsers);
					Chat.dispatchEvents(response.data);
					if (roomID = Chat.getActiveRoom()) {
						Chat.activateRoom(roomID);
					}
					Chat.initHandlers();
					Chat.enableUpdate();
				}
			}, 'json');
		}
	},

	dispatchEvents: function (data) {
		Chat.disableUpdate();
		$(".openChats .item").each(function(){
			var roomID = this.id.replace(/roomTab_/, '');
			Chat.clearUnreadEvents(roomID);
		});
		var count = 0;
		for(var i = 0; i < data.events.length; i++) {
			var event = data.events[i].ChatEvent;
			count+= event.active;
			$roomTab = $(".openChats #roomTab_" + event.room_id);
			if ($roomTab.length) {
				if (event.event_type == chatDef.incomingMsg || event.event_type == chatDef.outcomingMsg) {
					var msg = data.messages[event.msg_id];
					Chat.addUnreadEvent(event.room_id, {
						id: event.id,
						event_type: event.event_type,
						time: event.created,
						msg: msg.message,
						user: (event.event_type == chatDef.incomingMsg) ? data.authors[event.initiator_id] : null
					});
				} else if (event.event_type == chatDef.fileDownloadAvail || event.event_type == chatDef.fileUploaded) {
					var file = data.files[event.file_id];
					Chat.addUnreadEvent(event.room_id, {
						id: event.id,
						event_type: event.event_type,
						time: event.created,
						msg: (event.event_type == chatDef.fileDownloadAvail) ? chatLocale.fileReceived : chatLocale.fileUploaded,
						url: file.url_download,
						file_name: file.orig_fname
					});
				}
			}
		}
		$(".openChats .item").each(function(){
			var roomID = this.id.replace(/roomTab_/, '');
			Chat.showUnreadTab(roomID);
		});
		Chat.showUnreadTotal(count);
		Chat.enableUpdate();
	},
	
	addUnreadEvent: function (roomID, event) {
		var $roomTab = $(".openChats #roomTab_" + roomID);
		var aEvents = $roomTab.data('unread');
		aEvents.push(event);
		$roomTab.data('unread', aEvents);
		return Chat.getUnreadEvents(roomID);
	},
	
	clearUnreadEvents: function (roomID) {
		var $roomTab = $(".openChats #roomTab_" + roomID);
		$roomTab.data('unread', new Array());
	},
	
	getUnreadEvents: function (roomID) {
		return $(".openChats #roomTab_" + roomID).data('unread');
	},
	
	showUnreadTab: function (roomID) {
		count = Chat.getUnreadEvents(roomID).length;
		if (count > 10) {
			count = '10+';
		} else if (!count) {
			count = '';
		}
		$(".openChats #roomTab_" + roomID + " span.badge").html(count);
	},
	
	countUnreadTotal: function () {
		var count = 0;
		$(".openChats .item").each(function(){
			count+= Chat.getUnreadEvents(this.id.replace(/roomTab_/, '')).length;
		});
		return count;
	},
	
	showUnreadTotal: function (count) {
		if (count > 10) {
			count = '10+';
		} else if (!count) {
			count = '';
		}
		$("#chatTotalUnread").html(count);
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
	
	filterContactList: function (filter) {
		Chat.disableUpdate();
		$.post(chatURL.contactList, {data: {q: filter}}, function(response){
			Chat.renderPanel(response.data.aUsers);
			Chat.initHandlers();
			Chat.enableUpdate();
		});
	},
	
	delContact: function(contact_id, room_id) {
		Chat.disableUpdate();
		$.post(chatURL.delContact, {data: {contact_id: contact_id}}, function(response){
			Chat.renderPanel(response.data.aUsers);
			Chat.initHandlers();
			Chat.enableUpdate();
		});
		if ($('.openChats .item').length > 1) {
			Chat.clearUnreadEvents(room_id);
			Chat.showUnreadTotal(Chat.countUnreadTotal());
			Chat.removeRoom(room_id);
		}
	}
}