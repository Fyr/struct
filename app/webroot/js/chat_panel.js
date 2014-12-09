var ChatPanel = function(container, userID){ // static object
	var self = this;
	self.panel = container;
	self.userID = userID;
	self.rooms = {};
	self.activeRoom = null;
	
	this.init = function () {
		$.post(chatURL.contactList, null, function(response){
			self.render(response.data.aUsers);
			if (userID) {
				// Chat.openRoom(userID);
				
			}
		});
	}
	
	this.initHandlers = function() {
		$('#searchChatForm').ajaxForm({
			url: chatURL.contactList,
			dataType: 'json',
			beforeSubmit: function(){
				// Chat.disableUpdate();
			},
			success: function(response) { 
				self.render(response.data.aUsers);
				self.initHandlers(); // DOM elements were recreated
				// Chat.enableUpdate();
			}
		});
	}
	
	this.formatUnread = function(count) {
		if (count > 10) {
			count = '10+';
		} else if (!count) {
			count = '';
		}
		return count;
	}
	
	this.render = function (aUsers) {
		var count, totalCount = 0;
		unreadCount = {};
		if (aUsers && aUsers.length) {
			for(var i = 0; i < aUsers.length; i++) {
				user = aUsers[i];
				if (user.ChatContact) {
					count = parseInt(user.ChatContact.active_count);
					totalCount+= count;
					if (self.rooms[user.ChatContact.room_id]) {
						self.rooms[user.ChatContact.room_id].setUnread(self.formatUnread(count));
					}
				}
			}
		}
		$('#chatTotalUnread').html(self.formatUnread(totalCount));
		$(self.panel).html(tmpl('chat-panel', {innerCall: self.userID && true, q: $(".searchBlock .searchInput", self.panel).val(), aUsers: aUsers}));
		self.initHandlers();
	}
	
	this.removeRoom = function(contact_id, room_id) {
		// Chat.disableUpdate();
		$.post(chatURL.delContact, {data: {contact_id: contact_id}}, function(response){
			self.render(response.data.aUsers);
			self.initHandlers();
			// Chat.enableUpdate();
		});
		/*
		if ($('.openChats .item').length > 1) {
			Chat.clearUnreadEvents(room_id);
			Chat.showUnreadTotal(Chat.countUnreadTotal());
			Chat.removeRoom(room_id);
		}
		*/
	}
	
	this.createRoom = function (userID) {
		// Chat.panelHide();
		// Chat.disableUpdate();
		/*
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
				Chat.scrollTop(roomID);
				
				// Chat.enableUpdate();
			}
		}, 'json');
		*/
		console.log('ChatPanel - openRoom');
		closeMainPanel();
		var room = new ChatRoom(roomID);
		room.init();
		self.rooms[roomID] = room;
	}
	
	this.openRoom = function(roomID) {
		closeMainPanel();
		if (self.rooms[roomID]) {
			self.activateTab(roomID);
		} else {
			Chat.disableUpdate();
			$.post(chatURL.openRoom, {data: {room_id: roomID}}, function(response){
				if (checkJson(response)) {
					var roomID = response.data.room.ChatRoom.id;
					var room = new ChatRoom();
					room.init(roomID, response.data.members);
					self.rooms[roomID] = room; // add room into tabs stack
					
					self.dispatchEvents(response.data.events);
					
					if ($(".openChats .room-tab").length > 1) { // one tab
						self.enableCloseTabs();
					} else {
						self.disableCloseTabs();
					}
					self.activateTab(roomID);
					Chat.enableUpdate();
				}
			}, 'json');
		}
	}
	
	this.disableCloseTabs = function () {
		$(".room-tab").addClass('disable-remove');
	}
	
	this.enableCloseTabs = function () {
		$(".room-tab").removeClass('disable-remove');
	}
	
	this.activateTab = function(roomID) {
		if (roomID) {
			self.activeRoom = roomID;
		}
		if (self.activeRoom) {
			self.rooms[self.activeRoom].activate();
		}
	}
	
	this.closeTab = function (roomID) {
		var aRoomID = Object.keys(self.rooms);
		var nextRoom = 0;
		var prevRoom = 0;
		if (aRoomID.length > 1) { // disable to close single tab
			for(var i = 0; i < aRoomID.length; i++) {
				nextRoom = i + 1;
				prevRoom = i - 1;
				if (aRoomID[i] == roomID) {
					break;
				}
			}
			
			var newID;
			if (nextRoom < aRoomID.length) {
				newID = aRoomID[nextRoom];
			} else {
				newID = aRoomID[prevRoom];
			}
			self.rooms[roomID].close();
			delete self.rooms[roomID];
			self.activateTab(newID);
		}
	}
	
	this.dispatchEvents = function (data) {
		for(var i = 0; i < data.events.length; i++) {
			var event = data.events[i].ChatEvent;
			if (self.rooms[event.room_id]) { // tab could be async-ly closed 
				if (event.event_type == chatDef.incomingMsg || event.event_type == chatDef.outcomingMsg) {
					var msg = data.messages[event.msg_id];
					self.rooms[event.room_id].events.push({
						id: event.id,
						event_type: event.event_type,
						active: event.active,
						time: Date.fromSqlDate(event.created),
						msg: msg.message,
						user: (event.event_type == chatDef.incomingMsg) ? event.initiator_id : null
					});
				} else if (event.event_type == chatDef.fileDownloadAvail || event.event_type == chatDef.fileUploaded) {
					var file = data.files[event.file_id];
					self.rooms[event.room_id].events.push({
						id: event.id,
						event_type: event.event_type,
						active: event.active,
						time: Date.fromSqlDate(event.created),
						msg: (event.event_type == chatDef.fileDownloadAvail) ? chatLocale.fileReceived : chatLocale.fileUploaded,
						url: file.url_download,
						file_name: file.orig_fname
					});
				}
			}
		}
	}
	
	this.update = function(data) {
		self.render(data.aUsers);
		
		self.dispatchEvents(data);
		self.activateTab();
	}
}