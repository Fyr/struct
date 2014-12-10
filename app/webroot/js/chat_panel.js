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
				self.openRoom(null, userID);
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
		
		//var canAddMember = (self.activeRoom && self.rooms[self.activeRoom].ChatRoom.initiator_id);
		$(self.panel).html(tmpl('chat-panel', {innerCall: self.userID && true, q: $(".searchBlock .searchInput", self.panel).val(), aUsers: aUsers}));
		self.updateAddMembers();
		self.initHandlers();
	}
	
	this.removeContact = function(contact_id, roomID) {
		Chat.disableUpdate();
		self.closeTab(roomID);
		$.post(chatURL.delContact, {data: {contact_id: contact_id}}, function(response){
			self.render(response.data.aUsers);
			self.initHandlers();
			Chat.enableUpdate();
		});
	}

	this.openRoom = function(roomID, userID) {
		closeMainPanel();
		if (self.rooms[roomID]) {
			self.activateTab(roomID);
		} else {
			Chat.disableUpdate();
			$.post(chatURL.openRoom, {data: {room_id: roomID, user_id: userID}}, function(response){
				if (checkJson(response)) {
					var roomID = response.data.room.ChatRoom.id;
					var room = new ChatRoom();
					
					room.init(response.data.room, response.data.members);
					self.rooms[roomID] = room; // add room into tabs stack
					
					self.dispatchEvents(response.data.events);
					
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
	
	this.checkMember = function(members) {
		var activeRoom = self.rooms[Chat.Panel.activeRoom];
		console.log([members, activeRoom.members]);
		if (members && members.split(',').length) {
			members = members.split(',');
			if (members.length > 1) {
				return false;
			}
			var memberID = members[0];
			var activeRoom = self.rooms[Chat.Panel.activeRoom];
			for(var id in activeRoom.members) {
				if (id == memberID) { // already in this room
					return false;
				}
			}
		}
		return true;
	}
	
	this.updateAddMembers = function() {
		if (self.activeRoom) {
			if (Chat.Panel.rooms[Chat.Panel.activeRoom].ChatRoom.canAddMember) {
				$('.add-member').each(function(){
					if (self.checkMember($(this).data('members').toString())) {
						$(this).show();
					}
				});
			}
		}
	}
	
	this.updateTabs = function() {
		if ($(".openChats .room-tab").length > 1) { // single tab must be not closed
			self.enableCloseTabs();
		} else {
			self.disableCloseTabs();
		}
	}
	
	this.activateTab = function(roomID) {
		self.updateTabs();
		if (roomID) {
			self.activeRoom = roomID;
		}
		$('.add-member').hide();
		if (self.activeRoom) {
			self.updateAddMembers();
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
		var msg, user, file;
		for(var roomID in data.updateRooms) {
			if (self.rooms[roomID]) {
				self.rooms[roomID].updateMembers(data.updateRooms[roomID]);
			}
		}
		for(var i = 0; i < data.events.length; i++) {
			var event = data.events[i].ChatEvent;
			if (self.rooms[event.room_id]) { // tab could be async-ly closed 
				if (event.event_type == chatDef.incomingMsg || event.event_type == chatDef.outcomingMsg) {
					msg = data.messages[event.msg_id];
					event.msg = msg.message;
				} else if (event.event_type == chatDef.fileDownloadAvail || event.event_type == chatDef.fileUploaded) {
					file = data.files[event.file_id];
					event.url = file.url_download;
					event.file_name = file.orig_fname;
				}
				self.rooms[event.room_id].events.push(event);
			}
		}
	}
	
	this.update = function(data) {
		self.render(data.aUsers);
		self.dispatchEvents(data);
		self.activateTab();
	}
	
	this.addMember = function(userID) {
		closeMainPanel();
		self.rooms[self.activeRoom].addMember(userID);
	}
	
	this.onScrollTop = function() {
		// self.rooms[self.activeRoom].loadMoreEvents();
	}
	
	this.onScrollBottom = function() {
		
	}
}