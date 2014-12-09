var ChatRoom = function() {
	var self = this;
	self.roomID = null;
	self.members = {};
	self.events = [];
	self.dialog = null;
	self.unread = [];
	self.lFirstRun = true;
	
	this.init = function(roomID, members) {
		self.roomID = roomID;
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
		$('.chat-tabs').append(tmpl('room-tab', {roomID: self.roomID, members: self.members, msg_count: 0, removable: false}));
		
		$('.chat-members').append(tmpl('chat-members', {roomID: self.roomID, members: self.members}));
	}
	
	this.renderTab = function(roomID, members, msg_count, removable) {
		return tmpl('room-tab', {roomID: roomID, members: members, msg_count: msg_count, removable: removable});
	}
	
	this.renderEvents = function(aEvents) {
		var html = '';
		for(var i = 0; i < aEvents.length; i++) {
			var event = aEvents[i];
			if (event.active) {
				self.unread.push(event.id);
			}
			if (event.event_type == chatDef.incomingMsg || event.event_type == chatDef.outcomingMsg) {
				html+= self.renderMsg(event.msg, (event.user) ? self.members[event.user] : null, event.time);
			} else if (event.event_type == chatDef.fileDownloadAvail || event.event_type == chatDef.fileUploaded) {
				html+= self.renderFile(event.msg, event.url, event.file_name);
			}
		}
		return html;
	},
	
	this.renderMsg = function (msg, user, js_datetime) {
		return tmpl('chat-msg', {msg: msg, user: user, time: js_datetime});
	},
	
	this.renderFile = function (msg, url, file_name) {
		return tmpl('extra-msg', {msg: msg, url: url, file_name: file_name});
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
			$('#processMsg').show();
			$.post(chatURL.sendMsg, {data: {msg: msg, roomID: self.roomID}}, function(response){
				if (checkJson(response)) {
					$(self.dialog).append(self.renderMsg(msg));
					self.scrollBottom();
					$('#processMsg').hide();
				}
			}, 'json');
		}

	}
	
	this.sendFile = function (fileData) {
		$.post(chatURL.sendFile, {data: {id: fileData.id, roomID: self.roomID}}, function(response){
			if (checkJson(response)) {
				$(self.dialog).append(self.renderFile(chatLocale.fileUploaded, fileData.url_download, fileData.orig_fname));
				self.scrollBottom();
			}
		}, 'json');
	}
	
	this.setUnread = function(count) {
		$('#roomTab_' + self.roomID + ' span.badge').html(count);
	}
}