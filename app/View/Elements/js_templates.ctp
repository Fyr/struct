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

<script type="text/x-tmpl" id="chat-msg">
{%
	var locale = '<?=Hash::get($currUser, 'User.lang')?>';
	var js_date = (o.time) ? o.time : new Date();
	var time = Date.fullDate(js_date, locale) + ' ' + Date.HoursMinutes(js_date, locale);
%}
<div class="{%=((o.user) ? 'leftMessage' : 'rightMessage')%} clearfix">
{% if (o.user) { %}
	<img class="ava" src="{%=o.user.UserMedia.url_img.replace(/noresize/, 'thumb100x100')%}" alt="{%=o.user.User.full_name%}" style="width: 50px" />
{% } %}
	<div class="time">{%=time%}</div>
	<div class="text">{%=o.msg%}</div>
</div>
<div class="clearfix"></div>
</script>

<script type="text/x-tmpl" id="extra-msg">
<div class="date">{%=o.msg%}: <a href="{%=o.url%}" target="_blank">{%=o.file_name%}</a></div>
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
		var user, user_id, name, message, time, count, media;
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
				var onclick = (room_id) ? 'Chat.Panel.openRoom(' + room_id + ')' : 'Chat.Panel.createRoom(' + user_id + ')';
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
%}

                <figure class="messages-user rate-10"><img class="ava" src="{%=src%}" alt="{%=name%}" style="width: 50px; height: auto;"/></figure>
                <div class="text">
                    <div class="name">{%=name%}</div>
                    <div class="message clearfix">
                        <p>{%=message%}</p>
                    </div>
                </div>
                <div class="aside-block">
{%
			if (user.ChatContact) {
%}
	
                	<div class="close-block glyphicons circle_remove" onclick="var e = arguments[0] || window.event; if ($(e.target).hasClass('circle_remove')) { e.stopPropagation(); Chat.Panel.removeContact({%=user.ChatContact.id%}, {%=user.ChatContact.room_id%}) }"></div>
{%
			}
%}
					<div class="add-plus glyphicons circle_plus" onclick="var e = arguments[0] || window.event; if ($(e.target).hasClass('circle_plus')) { e.stopPropagation(); Chat.Panel.addMember({%=user.ChatContact.id%}, {%=user.ChatContact.room_id%}) }"></div>
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
