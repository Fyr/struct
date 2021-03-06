<script type="text/x-tmpl" id="room-tab">
{%
	var count = Chat.Panel.formatUnread(o.msg_count);
	
%}
<div id="roomTab_{%=o.roomID%}" class="room-tab item" onclick="Chat.Panel.activateTab({%=o.roomID%})">
	<span class="badge badge-important">{%=count%}</span>
{%
	count = 0;
	var user;
	for(var id in o.members) {
		count++;
		user = o.members[id];
%}
	<img class="ava" src="{%=user.UserMedia.url_img.replace(/noresize/, 'thumb50x50')%}" alt="" />
{%
	}
%}
	<div class="remove"><a class="glyphicons circle_remove" href="javascript: void(0)" onclick="var e = arguments[0] || window.event; if ($(e.target).hasClass('circle_remove') ) { e.stopPropagation(); Chat.Panel.closeTab({%=o.roomID%}); }"></a></div>
{%
	if (count <= 1) {
%}
	<div class="name">{%=user.User.full_name%}</div>
{%
	}
%}
</div>
</script>

<script type="text/x-tmpl" id="room-chat">
<div id="roomChat_{%=o.room_id%}" class="dialog clearfix room-chat">
	<div class="innerDialog"></div>
</div>
</script>

<script type="text/x-tmpl" id="chat-members">
<span id="chatMembers_{%=o.roomID%}" class="chat-members">
{%
	if (Object.keys(o.members).legnth > 1) {
		var user;
		for(var id in o.members) {
			user = o.members[id];
%}
	<a href="javascript: void(0)">
		<img src="{%=user.UserMedia.url_img.replace(/noresize/, 'thumb50x50')%}" alt="" />
		<span class="shadow glyphicons circle_remove"></span>
	</a>
{%
		}
	}
%}
</span>
</script>

<script type="text/x-tmpl" id="chat-event">
{%
	var time = Date.fromSqlDate(o.event.created);
	var user;
	if (o.event.event_type == chatDef.incomingMsg || o.event.event_type == chatDef.outcomingMsg) {
		user = (o.event.event_type == chatDef.incomingMsg) ? o.members[o.event.initiator_id] : null;
		include('chat-msg', {time: time, user: user, msg: o.event.msg});
	} else {
		include('extra-msg', {event: o.event, members: o.members});
	}
%}
</script>

<script type="text/x-tmpl" id="chat-event-first">
{%
	if (o.event.event_type != chatDef.roomOpened) {
%}
<div id="firstEvent_{%=o.event.room_id%}" class="date" style="margin-top: 10px;"><a href="javascript:void(0)" onclick="Chat.Panel.rooms[{%=o.event.room_id%}].loadMore({%=o.event.id%})"><?=__('Load more...')?></a></div>
{%
	}
%}
</script>

<script type="text/x-tmpl" id="chat-msg">
{%
	var locale = '<?=Hash::get($currUser, 'User.lang')?>';
	var js_date = (o.time) ? o.time : new Date();
	var time = Date.fullDate(js_date, locale) + ' ' + Date.HoursMinutes(js_date, locale);
%}
<div class="{%=((o.user) ? 'leftMessage' : 'rightMessage')%} clearfix">
{% 
	if (o.user) { 
%}
	<img class="ava" src="{%=o.user.UserMedia.url_img.replace(/noresize/, 'thumb100x100')%}" alt="{%=o.user.User.full_name%}" style="width: 50px" />
{% 
	}
%}
	<div class="time">{%=time%}</div>
	<div class="text">{%=o.msg%}</div>
</div>
<div class="clearfix"></div>
</script>

<script type="text/x-tmpl" id="extra-msg">
{%
	if (o.event.event_type == chatDef.fileDownloadAvail) {
%}
	<div class="date"><?=__('File has been uploaded')?>: <a href="{%=o.event.url%}" target="_blank">{%=o.event.file_name%}</a></div>
{%		
	} else if (o.event.event_type == chatDef.fileUploaded) {
%}
	<div class="date"><?=__('You received a file')?>: <a href="{%=o.event.url%}" target="_blank">{%=o.event.file_name%}</a></div>
{%
	} else if (o.event.event_type == chatDef.invitedUser) {
		var msg = '<?=__('You invited user "%s" in this room', '~user_name')?>';
		msg = msg.replace(/~user_name/, o.members[o.event.recipient_id].User.full_name);
%}
	<div class="date">{%=msg%}</div>
{%
	} else if (o.event.event_type == chatDef.wasInvited) {
		var msg = '<?=__('You was invited into this room')?>';
%}
	<div class="date">{%=msg%}</div>
{%
	} else if (o.event.event_type == chatDef.joinedRoom) {
		var msg = '<?=__('User "%s" joined this room', '~user_name')?>';
		msg = msg.replace(/~user_name/, o.members[o.event.recipient_id].User.full_name);
%}
	<div class="date">{%=msg%}</div>
{%
	}
%}

<div class="clearfix"></div>
</script>

<script type="text/x-tmpl" id="chat-panel">
<div class="searchBlock clearfix">
	<form id="searchChatForm" action="" method="post">
        <input class="searchInput" type="text" name="data[q]" value="{%=o.q%}" placeholder="<?=__('Find user...')?>">
        <button type="submit" class="searchButton"><span class="glyphicons search"></span></button>
    </form>
</div>
<div class="dropdown-panel-scroll">
    <div class="messages-list allMessages">
    
<ul>
{%
	if (o.aUsers && o.aUsers.length) {
		var user, user_id, name, message, time, count, media, members;
		for(var i = 0; i < o.aUsers.length; i++) {
			user = o.aUsers[i];
			user_id = user.User.id;
			room_id = (user.ChatContact) ? user.ChatContact.room_id : 0;
			name = user.User.full_name;
			message = (user.ChatContact) ? user.ChatContact.msg : '';
			
			time = (user.ChatContact) ? user.ChatContact.modified : '';
			// TODO: format time to local
			
			if (o.q && !message) {
				message = user.User.skills; <?// потому что поиск идет еще и по скилам?>
			}
			if (o.innerCall) {
				var onclick = (room_id) ? 'Chat.Panel.openRoom(' + room_id + ')' : 'Chat.Panel.openRoom(null, ' + user_id + ')';
%}
            <li class="messages-new clearfix" onclick="{%=onclick%}">
{%
			} else {
				var url = '<?=$this->Html->url(array('controller' => 'Chat', 'action' => 'index', '~user_id'))?>';
				url = url.replace(/~user_id/g, user_id);
%}
            <li class="messages-new clearfix" onclick="window.location.href='{%=url%}'">
{%
			}
			src = user.UserMedia.url_img.replace(/noresize/, 'thumb100x100');
			members = (user.ChatContact && user.ChatContact.members.length > 2) ? ' (+' + (user.ChatContact.members.length - 2) + ')' : '';
%}

                <figure class="messages-user rate-10"><img class="ava" src="{%=src%}" alt="{%=name%}" style="width: 50px; height: auto;"/></figure>
                <div class="text">
                    <div class="name">{%=name%}{%=members%}</div>
                    <div class="message clearfix">
                        <p>{%=message%}</p>
                    </div>
                </div>
                <div class="aside-block">
{%
			members = '';
			if (user.ChatContact) {
				members = user.ChatContact.members.join(',');
%}
	
                	<div class="close-block glyphicons circle_remove" onclick="var e = arguments[0] || window.event; if ($(e.target).hasClass('circle_remove')) { e.stopPropagation(); Chat.Panel.removeContact({%=user.ChatContact.id%}, {%=user.ChatContact.room_id%}) }"></div>
{%
			}
			/*
			if (Chat.Panel.activeRoom) {
				var activeRoom = Chat.Panel.rooms[Chat.Panel.activeRoom];
				if (activeRoom.ChatRoom.canAddMember && !activeRoom.members[user_id]) {
				*/
%}
					<div class="add-plus glyphicons circle_plus add-member" data-members="{%=members%}" onclick="var e = arguments[0] || window.event; if ($(e.target).hasClass('circle_plus')) { e.stopPropagation(); Chat.Panel.addMember({%=user_id%}) }" style="display: none;"></div>
{%
/*
				}
			}
			*/
%}
                    <div class="time">{%=(time) ? Date.HoursMinutes(Date.fromSqlDate(time)) : ''%}</div>
                    <div class="count-b">
{%
			if (user.ChatContact) {
				count = Chat.Panel.formatUnread(parseInt(user.ChatContact.active_count));
%}
                        <span id="roomUnread_{%=room_id%}" class="count">{%=count%}</span>
{%
			}
%}
                    </div>
                </div>
            </li>
{%
		}
	} else {
%}
		<li class="messages-new clearfix">
			<?=__('No user found')?>
		</li>
{%
	}
%}
</ul>

    </div>
</div>
</script>
