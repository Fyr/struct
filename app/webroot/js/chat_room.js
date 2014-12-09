var ChatRoom = function() {
	var self = this;
	self.ChatRoom = null;
	self.roomID = null;
	self.members = {};
	self.events = [];
	self.dialog = null;
	self.unread = [];
	self.lFirstRun = true;
	// self.firstEvent = 0;
	
	this.init = function(room, members) {
		self.ChatRoom = room.ChatRoom;
		self.roomID = room.ChatRoom.id;
		self.members = members;
		self.render();
		
		$(".sendForm").show();
		Chat.fixPanelHeight();
	}

	this.scrollBottom = function () {
		if ($('.clearfix:last', self.dialog).length) { // there can be no events in dialog 
			console.log('scrollBottom');
			$('.clearfix:last', self.dialog).get(0).scrollIntoView(false);
		}
	}

	this.close = function() {
		$('#roomTab_' + self.roomID).remove();
		$('#roomChat_' + self.roomID).remove();
		$('#chatMembers_' + self.roomID).remove();
	}
	
	this.render = function() {
		// render room container
		$('.chat-dialogs').append(tmpl('room-chat', {room_id: self.roomID}));
		self.dialog = $('.chat-dialogs #roomChat_' + self.roomID + ' .innerDialog').get(0);
		
		// render room tab
		$('.chat-tabs').append(tmpl('room-tab', {roomID: self.roomID, members: self.members, msg_count: 0}));
		
		$('.chat-members').append(tmpl('chat-members', {roomID: self.roomID, members: self.members}));
	}
	
	this.renderEvents = function(aEvents) {
		var html = '', event;
		// self.firstEvent = (aEvents[0]) ? aEvents[0].id : 0;
		for(var i = 0; i < aEvents.length; i++) {
			var event = aEvents[i];
			if (event.active) {
				self.unread.push(event.id);
			}
			html+= tmpl('chat-event', {event: event, members: self.members});
		}
		return html;
	},
	
	this.activate = function() {
		// activate tab
		$('.room-tab').removeClass('active');
		$('#roomTab_' + self.roomID).addClass('active');
		
		// activate dialog
		$('.room-chat').hide();
		$('#roomChat_' + self.roomID).show();
		
		// activate users
		$('.chat-members').hide();
		$('#chatMembers_' + self.roomID).show();
		
		if (self.events) {
			$(self.dialog).append(self.renderEvents(self.events));
			self.events = [];
			if (self.unread.length) {
				self.setUnread(Chat.Panel.formatUnread(self.unread.length));
				Chat.disableUpdate();
				$.post(chatURL.markRead, {data: {ids: self.unread}}, function(response){
					if (checkJson(response)) {
						self.unread = [];
						self.scrollBottom();
						Chat.enableUpdate();
					}
				}, 'json');
			} else if (self.lFirstRun) {
				self.lFirstRun = false;
				self.scrollBottom();
			}
		}
	}
	
	this.sendMsg = function () {
		var msg = $('.sendForm textarea').val();
		if (msg) {
			$('.sendForm textarea').val('');
			$('#processRequest').show();
			$.post(chatURL.sendMsg, {data: {msg: msg, roomID: self.roomID}}, function(response){
				if (checkJson(response)) {
					$(self.dialog).append(tmpl('chat-msg', {msg: msg}));
					self.scrollBottom();
					$('#processRequest').hide();
				}
			}, 'json');
		}

	}
	
	this.sendFile = function (fileData) {
		$.post(chatURL.sendFile, {data: {id: fileData.id, roomID: self.roomID}}, function(response){
			if (checkJson(response)) {
				var event = {
					event_type: chatDef.fileUploaded,
					url: fileData.url_download,
					file_name: fileData.orig_fname
				};
				$(self.dialog).append(tmpl('extra-msg', {event: event}));
				self.scrollBottom();
			}
		}, 'json');
	}
	
	this.setUnread = function(count) {
		$('#roomTab_' + self.roomID + ' span.badge').html(count);
	}
	
	this.updateMembers = function(members) {
		self.members = members;
		$('#roomTab_' + self.roomID).replaceWith(tmpl('room-tab', {roomID: self.roomID, members: self.members, msg_count: 0}));
		Chat.Panel.updateTabs();
	}
	
	this.addMember = function(userID) {
		Chat.disableUpdate();
		$('#processRequest').show();
		$.post(chatURL.addMember, {data: {room_id: self.roomID, user_id: userID}}, function(response){
			if (checkJson(response)) {
				if (response.data.newRoom) {
					Chat.enableUpdate();
					$('#processRequest').hide();
					Chat.Panel.openRoom(response.data.newRoom.ChatRoom.id);
					return;
				}
				self.updateMembers(response.data.members);
				
				// update dialog
				var event = {
					event_type: chatDef.invitedUser,
					recipient_id: userID
				};
				$(self.dialog).append(tmpl('extra-msg', {event: event, members: self.members}));
				$('#processRequest').hide();
				self.scrollBottom();
				
			}
		}, 'json');
	}
	
	this.loadMoreEvents = function() {
		console.log('loadMoreEvents');
		Chat.disableUpdate();
		$('#processRequest').show();
		$.post(chatURL.loadMoreEvents, {data: {room_id: self.roomID, event_id: self.firstEvent}}, function(response){
			if (checkJson(response)) {
				if (response.data.events) {
					Chat.Panel.dispatchEvents(response.data);
				}
				$('#processRequest').hide();
				Chat.Panel.activateTab();
			}
		}, 'json');
	}
}