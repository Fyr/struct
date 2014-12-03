<script type="text/x-tmpl" id="room-tab">
<div id="roomTab_{%=o.room.ChatRoom.id%}" class="item" onclick="var e = arguments[0] || window.event; if ($(e.target).hasClass('circle_remove') ) { Chat.removeRoom({%=o.room.ChatRoom.id%}); } else { Chat.activateRoom({%=o.room.ChatRoom.id%}); }">
	<span class="badge badge-important">{%=o.msg_count%}</span>
	<img class="ava" src="{%=o.user.UserMedia.url_img.replace(/noresize/, 'thumb100x100')%}" alt="{%=o.user.User.full_name%}" />
	<div class="remove"><a class="glyphicons circle_remove" href="javascript: void(0)"></a></div>
	<div class="name">{%=o.user.User.full_name%}</div>
</div>
</script>

<script type="text/x-tmpl" id="room-chat">
<div id="roomChat_{%=o.room_id%}" class="chatRoom"></div>
</script>

<script type="text/x-tmpl" id="chat-msg">
{%
	// console.log(o.time);
	var locale = '<?=Hash::get($currUser, 'User.lang')?>';
	var js_date = Date.fromSqlDate(o.time);
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
</script>

<script type="text/x-tmpl" id="chat-panel">
<div class="searchBlock clearfix">
        <input class="searchInput" type="text" value="{%=o.q%}" placeholder="<?=__('Find user...')?>">
        <button type="button" class="searchButton"><span class="glyphicons search"></span></button>
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
			
			count = (user.ChatContact) ? parseInt(user.ChatContact.active_count) : 0;
			if (count > 10) {
				count = '10+';
			} else if (!count) {
				count = '';
			}
			
			if (o.q) {
				message = user.User.skills; <?// потому что поиск идет еще и по скилам?>
			}
			if (o.innerCall) {
%}
            <li class="messages-new clearfix" onclick="Chat.openRoom({%=user_id%})">
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
	
                	<div class="close-block glyphicons circle_remove" onclick="var e = arguments[0] || window.event; if ($(e.target).hasClass('circle_remove')) { e.stopPropagation(); Chat.delContact({%=user.ChatContact.id%}, {%=user.ChatContact.room_id%}) }"></div>
{%
			}
%}
                    <div class="time">{%=(time) ? Date.HoursMinutes(Date.fromSqlDate(time)) : ''%}</div>
                    <div class="count-b">
                        <span class="count">{%=count%}</span>
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
