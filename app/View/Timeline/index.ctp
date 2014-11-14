<style type="text/css">
.time-line-list .time-get-start .title-time {
	left: 45px;
}
</style>
<div class="row"></div>
<script type="text/javascript">
var timeline = <?=json_encode($aTimeline)?>;
var aMonths = <?=json_encode(array(__('Jan'), __('Feb'), __('Mar'), __('Apr'), __('May'), __('Jul'), __('Jun'), __('Aug'), __('Sep'), __('Oct'), __('Nov'), __('Dec')))?>;
var aDays = <?=json_encode(array(__('Sun'), __('Mon'), __('Tue'), __('Wen'), __('Thu'), __('Fri'), __('Sat')))?>;
var todayDate = '<?=date('Y-m-d')?>';
var timelineURL = {
	addEvent: '<?=$this->Html->url(array('controller' => 'ProfileAjax', 'action' => 'addEvent'))?>.json'
}
$(document).ready(function(){
	Timeline.init($('.user-page-wrapp .row').get(0));
	Timeline.render(timeline);
	
	$('.add-event-block .save-button').off();
	$('.add-event-block .save-button').click(function(){
		if ($('#UserEventTitle').val() && $('#UserEventTimeEvent').val && $('#UserEventDateEvent').val()) {
			$('.add-event-block').removeClass('open');
			Timeline.addEvent();
		}
	});
	
	$('#showWeek').click(function() {
		$('.time-line-list').hide();
		$('#showWeek').removeClass('btn-default');
		$('#showWeek').addClass('btn-default');
		$('#showDay').removeClass('btn-default');
	});
	$('#showDay').click(function() {
		$('.time-line-list').show();
		$('#showDay').removeClass('btn-default');
		$('#showDay').addClass('btn-default');
		$('#showWeek').removeClass('btn-default');
	});
});
</script>

<div class="add-event-block">
    <div class="close-block glyphicons circle_remove"></div>
    <?=$this->Form->create('UserEvent')?>
        <div class="fieldset-block">
<?
	echo $this->Form->input('title', array(
		'label' => array('text' => __('Event title')),
		'class' => 'default-input'
	));
?>
        </div>
        <div class="fieldset-block select-event-date clearfix">
            <div class="select-day-event-block">
                <span class="glyphicons clock"></span>
<?
	echo $this->Form->input('time_event', array('label' => false, 'class' => 'input-tyme clock-mask'));
?>
            </div>
            <div class="input-date-block">
                <span class="glyphicons calendar"></span>
<?
	echo $this->Form->input('date_event', array('label' => false, 'class' => 'datetimepicker select-data-for-event', 'data-date-format' => "YYYY-MM-DD"));
?>
            </div>
        </div>
        <div class="fieldset-block">
<?
	echo $this->Form->input('descr', array(
		'type' => 'text',
		'label' => array('text' => __('Event description')),
		'class' => 'default-input'
	));
?>
        </div>
        <div class="fieldset-block">
            <button type="button" class="btn btn-default save-button" onclick="Timeline.addEvent(); return false;"><?=__('Save')?></button>
        </div>
    <?=$this->Form->end()?>
</div>

<script type="text/x-tmpl" id="row-day-event">
<div class="row-day-events">
{%
	var js_date = Date.sqlDate(o.sql_date);
	var firstHour = Object.keys(o.data)[0];
	var firstEvent = o.globalData.events[o.data[firstHour][0]];
	if (firstEvent.KonstructorCreation) {
		include('konstructor-creation', {event: firstEvent.KonstructorCreation});
	} else {
%}
    <div class="col-md-12 col-sm-12 col-xs-12 {%=(o.sql_date == todayDate) ? 'end-day-data' : 'start-day-data'%} t-a-center">
        <div class="day-calendar">
            <div class="data">{%=js_date.getDate()%}</div>
            <div class="day">{%=aDays[js_date.getDay()]%}</div>
            <div class="month">{%=aMonths[js_date.getMonth()]%}</div>
        </div>
    </div>
    <div id="time-list{%=o.sql_date%}" class="col-md-12 col-sm-12 col-xs-12 time-line-list">
{% 
	// console.log('begin date');
	// console.log({startHour: 23, endHour: parseInt(firstHour), sql_date: o.sql_date});
	include('empty-events', {startHour: 23, endHour: parseInt(firstHour), sql_date: o.sql_date});
	for(var hour in o.data) {
		// console.log({hour: hour, sql_date: o.sql_date});
		include('time-line-cell', {globalData: o.globalData, hour: hour, sql_date: o.sql_date, data: o.data[hour]});
	}
	// console.log({startHour: parseInt(hour), endHour: 0, sql_date: o.sql_date});
	include('empty-events', {startHour: parseInt(hour), endHour: 0, sql_date: o.sql_date});
	// console.log('end date');
%}
    </div>
{%
	}
%}
</div>
</script>

<script type="text/x-tmpl" id="empty-events">
{%
	if (o.startHour > (o.endHour + 2)) {
%}
	<div class="toggle-dotted-cont">
{% 
		for(var hour = o.startHour; hour > o.endHour; hour--) {
			include('time-line-cell', {sql_date: o.sql_date, hour: hour, data: []});
		}
%}
	</div>
	<div class="time-line-cell clearfix toggle-dotted-btn">
	    <div class="col-md-12 col-sm-12 col-xs-12 t-a-center time"><span id="dotted{%=o.sql_date%}" class="toggle-dotted-line">...</span></div>
	</div>
{%
	} else {
		for(var hour = o.startHour; hour > o.endHour; hour--) {
			include('time-line-cell', {sql_date: o.sql_date, hour: hour, data: []});
		}
	}
%}
</script>

<script type="text/x-tmpl" id="time-line-cell">
{%
	var js_date = Date.sqlDate(o.sql_date);
	js_date.setHours(o.hour);
	js_date.setMinutes(0);
	var id = 'timeline' + o.sql_date + '_' + zeroFormat(js_date.getHours()) + zeroFormat(js_date.getMinutes());
	var event = null;
	for(var i = 0; i < o.data.length; i++) {
		event = o.globalData.events[o.data[i]];
		if (event.SelfRegistration) {
			break;
		}
	}
%}
<div id="{%=id%}" class="time-line-cell clearfix">
    <div class="col-md-12 col-sm-12 col-xs-12 t-a-center {%=(event && event.SelfRegistration) ? 'time-get-start' : 'time'%}" onclick="Timeline.showEventPopup(this, '{%=o.sql_date%}', '{%=Date.HoursMinutes(js_date)%}')">
{%
	
	if (event && event.SelfRegistration) {
%}
		<span class="title-registration"> {%=Date.HoursMinutes(Date.sqlDate(event.SelfRegistration.created))%}
			<div class="title-time"><?=__('I registered on this site')?></div>
		</span>
{%
	} else {
		console.log([js_date, o.hour]);
%}
        <span>{%=Date.HoursMinutes(js_date)%}
            <span class="add-event-time"><i class="glyphicon glyphicons circle_plus"></i></span>
        </span>

{%
	}
%}
    </div>
    <div class="col-md-5 col-sm-5 col-xs-12 t-a-right event-box">
{%
	for(var i = 0; i < o.data.length; i++) {
		event = o.globalData.events[o.data[i]];
		if (event.UserEvent) {
			include('user-event', {globalData: o.globalData, event: event.UserEvent});
		} else if (event.ChatEvent && event.ChatEvent.file_id) {
			include('chat-event-file', {globalData: o.globalData, event: event.ChatEvent});
		} else if (event.SelfRegistration) {
			include('last_groups', {globalData: o.globalData});
		}
	}
%}
    </div>
    <div class="col-md-2 col-sm-2 col-xs-12 t-a-right"></div>
    <div class="col-md-5 col-sm-5 col-xs-12 t-a-left event-box">
{%
	for(var i = 0; i < o.data.length; i++) {
		event = o.globalData.events[o.data[i]];
		if (event.ChatEvent && event.ChatEvent.msg_id) {
			include('chat-event-msg', {globalData: o.globalData, event: event.ChatEvent});
		} else if (event.SelfRegistration) {
			// include('self-registered', {globalData: o.globalData, event: event.SelfRegistration});
			include('last-registered', {globalData: o.globalData});
		}
	}
%}
    </div>
</div>
</script>

<script type="text/x-tmpl" id="user-event">
{%
	var js_date = Date.sqlDate(o.event.event_time);
%}
<div class="event-box-cell clearfix">
    <div class="time-event col-md-1 col-sm-1 col-xs-12">{%=Date.HoursMinutes(js_date)%}</div>
    <div class="user-page-event meeting col-md-11 col-sm-11 col-xs-12">
        <div class="icon glyphicons calendar"></div>
        {%=o.event.title%}
    </div>
</div>
</script>

<script type="text/x-tmpl" id="chat-event-msg">
{%
	var js_date = Date.sqlDate(o.event.created);
	var user = o.globalData.users[o.event.initiator_id];
	var url = '<?=$this->Html->url(array('controller' => 'Chat', 'action' => 'index', '~user_id'))?>';
%}
<div class="event-box-cell clearfix">
    <div class="time-event col-md-1 col-sm-1 col-xs-12">{%=(Date.HoursMinutes(js_date))%}</div>
    <div class="user-page-event col-md-11 col-sm-11 col-xs-12">
        <div class="massage-post clearfix">
            <figure>
            	<a href="{%=url.replace(/~user_id/, o.event.user_id)%}">
            		<img alt="{%=user.ChatUser.name%}" src="{%=user.Avatar.url%}" style="width: 50px">
            	</a>
            </figure>
            		
            <div class="massage-chat">
                <p>{%=o.globalData.messages[o.event.msg_id].message%}</p>
            </div>
        </div>
    </div>
</div>
</script>

<script type="text/x-tmpl" id="chat-event-file">
{%
	var js_date = Date.sqlDate(o.event.created);
	var file = o.globalData.files[o.event.file_id];
%}
<div class="event-box-cell clearfix">
    <div class="time-event col-md-1 col-sm-1 col-xs-12">{%=(Date.HoursMinutes(js_date))%}</div>
    <div class="user-page-event documents col-md-11 col-sm-11 col-xs-12">
        <div>
            <a class="documents-lin" href="{%=file.url_download%}">
                <span class="icon filetype {%=file.ext.replace(/\./, '')%}"></span> {%=file.orig_fname%}
            </a>
        </div>
        <div class="sub-text">{%=chatLocale.fileReceived%}</div>
    </div>
</div>
</script>

<script type="text/x-tmpl" id="last_groups">
<?=__('Last created groups')?>
{%
	for(var i = 0; i < o.globalData.last_groups.length; i++) {
		var group = o.globalData.last_groups[i].Group;
		var url = '<?=$this->Html->url(array('controller' =>'Group', 'action' => 'view', '~group_id'))?>';
%}
<div class="news-article group-type progect-type">
    <a href="{%=url.replace(/~group_id/g, group.id)%}">
        <div class="news-article-title"></div>
        <div class="news-article-title subtitle clearfix">
            <div class="subtitle-image">
                <img alt="{%=group.title%}" src="{%=group.image_url%}" style="width: 50px;">
            </div>
            <div class="subtitle-body">
                {%=group.title%}
                <div class="subtitle-body-info">
                    <!--11 участников -->
                </div>
            </div>
        </div>
        <div class="news-article-pubdate">{%=group.descr%}</div>
    </a>
</div>
{%
	}
%}
</script>

<script type="text/x-tmpl" id="konstructor-creation">
{%
	var js_date = Date.sqlDate(o.event.created);
%}
<div class="col-md-12 col-sm-12 col-xs-12 start-day-data t-a-center">
    <div class="day-calendar konstructor">
        <div class="konstructor-logo"><img alt="This site was created during long sleepless nights!" src="img/user-profile/t_logo2.png"></div>
        <div class="day">{%=aDays[js_date.getDay()]%}</div>
        <div class="month">{%=Date.fullDate(js_date)%}</div>
        <div class="start-project"><?=__('Launching Kostruktor')?></div>
    </div>
</div>
</script>

<script type="text/x-tmpl" id="self-registered">
{%
	var js_date = Date.sqlDate(o.event.created);
%}
<div class="event-box-cell clearfix">
    <div class="event-text">
        <div class="h2-title">{%=Date.fullDate(js_date)%} {%=Date.HoursMinutes(js_date)%}</div>
        <p>{%=o.event.msg%}</p>
    </div>
</div>
</script>

<script type="text/x-tmpl" id="last-registered">
<div class="event-box-cell clearfix">
    <div class="user-page-event user-visited">
<?=__('Last registered users')?>
        <ul class="user-visited-list clearfix">
{%
	for(var i = 0; i < o.globalData.last_users.length; i++) {
		var user = o.globalData.users[o.globalData.last_users[i].ChatUser.id];
		var url = '<?=$this->Html->url(array('controller' => 'Profile', 'action' => 'view', '~user_id'))?>';
%}
            <li class="good"><a href="{%=url.replace(/~user_id/g, user.ChatUser.id)%}"><img alt="{%=user.ChatUser.name%}" src="{%=user.Avatar.url%}" style="width: 50px;"></a></li>
{%
	}
%}
        </ul>
    </div>
</div>
</script>