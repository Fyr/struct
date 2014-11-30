<style type="text/css">
.time-line-list .time-get-start .title-time {
	left: 45px;
}
</style>
<div class="row"></div>
<script type="text/javascript">
var aMonths = <?=json_encode(array(__('Jan'), __('Feb'), __('Mar'), __('Apr'), __('May'), __('Jul'), __('Jun'), __('Aug'), __('Sep'), __('Oct'), __('Nov'), __('Dec')))?>;
var aDays = <?=json_encode(array(__('Sun'), __('Mon'), __('Tue'), __('Wen'), __('Thu'), __('Fri'), __('Sat')))?>;
var todayDate, now;
var startDay, locale;
$(document).ready(function(){
	locale = '<?=Hash::get($currUser, 'User.lang')?>';
	todayDate = new Date;
	todayDate = todayDate.toSqlDate(); // 
	todayDate = '<?=date('Y-m-d')?>';
	now = new Date(); // 
	now = now.toSqlDate();
	now = Date.fromSqlDate('<?=date('Y-m-d H:i:s')?>');
	startDay = <?=-floor((time() - strtotime(Configure::read('Konstructor.created'))) / DAY)?>;
	
	var timelineData = <?=json_encode($aTimeline)?>;
	Timeline.init({
		canvas: $('.user-page-wrapp .row').get(0), 
		topDay: <?=$topDay?>, 
		bottomDay: <?=$bottomDay?>, 
		loadPeriod: <?=Configure::read('timeline.loadPeriod')?>,
		updateTime: <?=Configure::read('timeline.updateTime')?>,
	}, timelineData);
	// Timeline.render(timeline);
	// Timeline.insertCurrentTime();
	
	// $('.add-event-block .save-button').off();
	$('.add-event-block .fieldset-block .save-button').click(function(){
		Timeline.updateEvent();
	});
	$('.add-event-block .fieldset-block .delete-button').click(function(){
		Timeline.deleteEvent();
	});
	
	$('.add-event-block .close-block').on('touchstart click', function(){
		Timeline.closeEventPopup();
	});
	
	$('#showWeek').click(function() {
		$('.time-line-list').hide();
		$('#showWeek').removeClass('save-button');
		$('#showWeek').addClass('save-button');
		$('#showDay').removeClass('save-button');
	});
	$('#showDay').click(function() {
		$('.time-line-list').show();
		$('#showDay').removeClass('save-button');
		$('#showDay').addClass('save-button');
		$('#showWeek').removeClass('save-button');
		Timeline.scrollCurrentTime();
	});
	
	$('.datetimepicker').datetimepicker({
		pickTime: false
	});
	
	$('#UserEventJsDateEvent').change(function(){
		$('#UserEventDateEvent').val(Date.local2sql($(this).val()));
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
	echo $this->Form->input('time_event', array('label' => false, 'class' => 'input-tyme'));
?>
            </div>
            <div class="input-date-block">
                <span class="glyphicons calendar"></span>
<?
	$dateFormat = (Hash::get($currUser, 'User.lang') == 'rus') ? 'DD.MM.YYYY' : 'MM/DD/YYYY';
	echo $this->Form->input('js_date_event', array('label' => false, 'class' => 'select-data-for-event datetimepicker', 'data-date-format' => $dateFormat)); // 
	echo $this->Form->hidden('date_event');
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
        <div class="fieldset-block create-event">
            <a class="btn btn-default save-button" href="javascript:void(0)"><?=__('Create')?></a>
        </div>
        <div class="fieldset-block edit-event" style="display: none">
            <a class="btn btn-default save-button" href="javascript:void(0)"><?=__('Save')?></a>
            <a class="btn btn-default delete-button" href="javascript:void(0)"><?=__('Delete')?></a>
        </div>
        <?=$this->Form->hidden('id');?>
		<?=$this->Form->end()?>
</div>

<script type="text/x-tmpl" id="row-day-event">
{%
	var js_date = Date.fromSqlDate(o.sql_date);
%}
<div id="row-day_{%=o.sql_date%}" class="row-day-events">
    <div id="time-list{%=o.sql_date%}" class="col-md-12 col-sm-12 col-xs-12 time-line-list events-expanded">
{% 
	for(hour = 23; hour >= 0; hour--) {
		include('time-line-cell', {
			globalData: o.globalData, 
			hour: hour, 
			sql_date: o.sql_date, 
			data: (o.data && o.data[zeroFormat(hour)]) ? o.data[zeroFormat(hour)] : {} 
		});
	}
%}
    </div>
{%
	var event = null;
	if (o.data) {
		var firstHour = Object.keys(o.data)[0];
		if (firstHour) {
			var firstEvent = o.globalData.events[o.data[firstHour][0]];
			if (firstEvent.KonstructorCreation) {
				event = firstEvent.KonstructorCreation;
			}
		}
	}
	if (event) {
		include('konstructor-creation', {event: event});
	} else {
		var red_day = (js_date.getDay() == 0 || js_date.getDay() == 6) ? 'red-day' : '';
%}
    <div id="day{%=o.sql_date%}" class="col-md-12 col-sm-12 col-xs-12 day-data {%=red_day%} t-a-center">
        <div class="day-calendar">
            <div class="data">{%=js_date.getDate()%}</div>
            <div class="day">{%=aDays[js_date.getDay()]%}</div>
            <div class="month">{%=aMonths[js_date.getMonth()]%}</div>
        </div>
    </div>
{%
	}
%}
</div>
</script>

<script type="text/x-tmpl" id="toggle-dotted-btn">
<div class="time-line-cell clearfix toggle-dotted-btn">
    <div class="col-md-12 col-sm-12 col-xs-12 t-a-center time"><span class="toggle-dotted-line">...</span></div>
</div>
</script>

<script type="text/x-tmpl" id="curr-time">
<div class="time-line-cell clearfix curr-time-cell">
	<div class="col-md-5 col-sm-5 col-xs-12 t-a-right event-box">&nbsp;</div>
    <div class="col-md-12 col-sm-12 col-xs-12 t-a-center time-get-start">
        <span class="title-registration curr-time-value">{%=o.time%}</span>
    </div>
</div>
</script>

<script type="text/x-tmpl" id="time-line-cell">
{%
	var js_date = Date.fromSqlDate(o.sql_date);
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
    <div class="col-md-5 col-sm-5 col-xs-12 t-a-right event-box">
{%
	for(var i = 0; i < o.data.length; i++) {
		event = o.globalData.events[o.data[i]];
		if (event.UserEvent) {
			include('user-event', {globalData: o.globalData, event: event.UserEvent});
		} else if (event.ChatEvent && event.ChatEvent.file_id) {
			include('chat-event-file', {globalData: o.globalData, event: event.ChatEvent});
		} else if (event.GroupMember) {
			include('joined-group', {globalData: o.globalData, event: event.GroupMember});
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
    <div class="col-md-12 col-sm-12 col-xs-12 t-a-center {%=(event && event.SelfRegistration) ? 'time-get-start' : 'time'%}">
{%
	
	if (event && event.SelfRegistration) {
%}
		<span class="title-registration"> {%=Date.HoursMinutes(Date.fromSqlDate(event.SelfRegistration.created))%}
			<div class="title-time"><?=__('I registered on this site')?></div>
		</span>
{%
	} else if (js_date.getHours() > 0) {
%}
        <span onclick="Timeline.addEventPopup('{%=o.sql_date%}', '{%=zeroFormat(js_date.getHours())%}')">{%=Date.HoursMinutes(js_date)%}
            <span class="add-event-time"><i class="glyphicon glyphicons circle_plus"></i></span>
        </span>

{%
	}
%}
    </div>
</div>
</script>

<script type="text/x-tmpl" id="user-event">
{%
	var js_date = Date.fromSqlDate(o.event.event_time);
	var time = zeroFormat(js_date.getHours()) + ':' + zeroFormat(js_date.getMinutes());
%}
<div id="user-event_{%=o.event.id%}" class="event-box-cell clearfix" onclick="Timeline.editEventPopup('{%=js_date.toSqlDate()%}', '{%=time%}', {%=o.event.id%})" style="cursor: pointer">
    <div class="time-event col-md-1 col-sm-1 col-xs-12">{%=Date.HoursMinutes(js_date)%}</div>
    <div class="user-page-event meeting col-md-11 col-sm-11 col-xs-12">
        <div class="icon glyphicons calendar"></div>
        <span class="user-event-title">{%=o.event.title%}</span>
        <span class="user-event-descr hide">{%=o.event.descr%}</span>
    </div>
</div>
</script>

<script type="text/x-tmpl" id="chat-event-msg">
{%
	var js_date = Date.fromSqlDate(o.event.created);
	var user = o.globalData.users[o.event.initiator_id];
	var url = '<?=$this->Html->url(array('controller' => 'Chat', 'action' => 'index', '~user_id'))?>';
	url = url.replace(/~user_id/, o.event.initiator_id);
%}
<div class="event-box-cell clearfix">
    <div class="time-event col-md-1 col-sm-1 col-xs-12">{%=(Date.HoursMinutes(js_date))%}</div>
    <div class="user-page-event col-md-11 col-sm-11 col-xs-12">
        <div class="massage-post clearfix">
            <figure>
            	<a href="{%=url%}">
            		<img alt="{%=user.User.full_name%}" src="{%=user.UserMedia.url_img.replace(/noresize/, 'thumb100x100')%}" style="width: 50px">
            	</a>
            </figure>
            		
            <div class="massage-chat" onclick="window.location.href='{%=url%}'" style="cursor: pointer;">
                <p>{%=o.globalData.messages[o.event.msg_id].message%}</p>
            </div>
        </div>
    </div>
</div>
</script>

<script type="text/x-tmpl" id="chat-event-file">
{%
	var js_date = Date.fromSqlDate(o.event.created);
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
		var group = o.globalData.last_groups[i];
		var url = '<?=$this->Html->url(array('controller' =>'Group', 'action' => 'view', '~group_id'))?>';
		var members = o.globalData.group_members[group.Group.id];
%}
<div class="news-article group-type progect-type">
    <a href="{%=url.replace(/~group_id/g, group.Group.id)%}">
        <div class="news-article-title"></div>
        <div class="news-article-title subtitle clearfix">
            <div class="subtitle-image">
                <img alt="{%=group.Group.title%}" src="{%=group.GroupMedia.url_img.replace(/noresize/, 'thumb50x50')%}" style="width: 50px;">
            </div>
            <div class="subtitle-body">
                {%=group.Group.title%}
                <div class="subtitle-body-info">
                    {%=members.length%} <?=__('member(s)')?>
                </div>
            </div>
        </div>
        <div class="news-article-pubdate">{%=group.Group.descr%}</div>
    </a>
</div>
{%
	}
%}
</script>

<script type="text/x-tmpl" id="joined-group">
{%
	var group = o.globalData.groups[o.event.group_id];
	var url = '<?=$this->Html->url(array('controller' =>'Group', 'action' => 'view', '~group_id'))?>';
	var members = o.globalData.group_members[o.event.group_id];
%}
<?=__('You joined this group as ')?>{%=o.event.role%}
<div class="news-article group-type progect-type">
    <a href="{%=url.replace(/~group_id/g, group.Group.id)%}">
        <div class="news-article-title"></div>
        <div class="news-article-title subtitle clearfix">
            <div class="subtitle-image">
                <img alt="{%=group.Group.title%}" src="{%=group.GroupMedia.url_img.replace(/noresize/, 'thumb50x50')%}" style="width: 50px;">
            </div>
            <div class="subtitle-body">
                {%=group.Group.title%}
                <div class="subtitle-body-info">
                	{%=members.length%} <?=__('member(s)')?>
                </div>
            </div>
        </div>
        <div class="news-article-pubdate">{%=group.Group.descr%}</div>
    </a>
</div>
</script>

<script type="text/x-tmpl" id="join-group-request">
<div class="user-page-event user-visited">
    <?=__('You received a request to join your group')?>
    <ul class="user-visited-list clearfix">
        <li class="good"><a href="#"><img alt="" src="img/user-profile/massage-user-1.png"></a></li>
        <li class="bad"><a href="#"><img alt="" src="img/user-profile/massage-user-4.png"></a></li>
        <li class="good"><a href="#"><img alt="" src="img/user-profile/massage-user-5.png"></a></li>
    </ul>
</div>
</script>

<script type="text/x-tmpl" id="konstructor-creation">
{%
	var js_date = Date.fromSqlDate(o.event.created);
%}
<div class="col-md-12 col-sm-12 col-xs-12 day-data t-a-center">
    <div class="day-calendar konstructor">
    	<div class="data">{%=js_date.getDate()%}</div>
        <div class="day">{%=aDays[js_date.getDay()]%}</div>
        <div class="month">{%=aMonths[js_date.getMonth()]%} {%=js_date.getFullYear()%}</div>
        <div class="start-project">
        	<img src="/img/user-profile/t_logo2.png" alt="This site was created during long sleepless nights..." />
        	<?=__('Updated site began to work')?>
        </div>
    </div>
</div>
</script>

<script type="text/x-tmpl" id="self-registered">
{%
	var js_date = Date.fromSqlDate(o.event.created);
%}
<div class="event-box-cell clearfix">
    <div class="event-text">
        <div class="h2-title">{%=Date.fullDate(js_date)%} {%=Date.HoursMinutes(js_date)%}</div>
        <p>{%=o.event.msg%}</p>
    </div>
</div>
</script>

<!--script type="text/x-tmpl" id="timer">
<div class="event-box-cell clearfix">
    <div class="event-text">
        <div class="h2-title">{%=Date.fullDate(js_date)%} {%=Date.HoursMinutes(js_date)%}</div>
        <p>{%=o.event.msg%}</p>
    </div>
</div>
</script-->

<script type="text/x-tmpl" id="last-registered">
<div class="event-box-cell clearfix">
    <div class="user-page-event user-visited">
<?=__('Last registered users')?>
        <ul class="user-visited-list clearfix">
{%
	for(var i = 0; i < o.globalData.last_users.length; i++) {
		var user = o.globalData.users[o.globalData.last_users[i].User.id];
		var url = '<?=$this->Html->url(array('controller' => 'User', 'action' => 'view', '~user_id'))?>';
%}
            <li class="good"><a href="{%=url.replace(/~user_id/g, user.User.id)%}"><img alt="{%=user.User.full_name%}" src="{%=user.UserMedia.url_img.replace(/noresize/, 'thumb100x100')%}" style="width: 50px;"></a></li>
{%
	}
%}
        </ul>
    </div>
</div>
</script>