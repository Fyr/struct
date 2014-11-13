<script type="text/javascript">
var timeline = <?=json_encode($aTimeline)?>;
var aMonths = <?=json_encode(array(__('Jan'), __('Feb'), __('Mar'), __('Apr'), __('May'), __('Jul'), __('Jun'), __('Aug'), __('Sep'), __('Oct'), __('Nov'), __('Dec')))?>;
var aDays = <?=json_encode(array(__('Sun'), __('Mon'), __('Tue'), __('Wen'), __('Thu'), __('Fri'), __('Sat')))?>;

$(document).ready(function(){
	Timeline.init($('.user-page-wrapp .row').get(0));
	Timeline.render(timeline);
});
</script>

<div class="add-event-block">
    <div class="close-block glyphicons circle_remove"></div>
    <form action="#">
        <div class="fieldset-block">
            <label for="name-for-event">Название события</label> <br/>
            <input id="name-for-event" class="default-input" value="" type="text"/>
        </div>
        <div class="fieldset-block select-event-date clearfix">
            <div class="select-day-event-block">
                <span class="glyphicons clock"></span>
                <input class="input-tyme clock-mask" id="select-day-for-event" type="text"/>
            </div>
            <div class="input-date-block">
                <span class="glyphicons calendar"></span>
                <input id="datetimepicker" class="datetimepicker select-data-for-event" type="text"/>
            </div>
        </div>
        <div class="fieldset-block">
            <label for="users-for-event"><?=__('Description')?></label>
            <input id="users-for-event" class="default-input" value="" type="text"/>
        </div>
        <div class="fieldset-block">
            <button class="btn btn-default save-button" type="submit">Сохранить</button>
        </div>
    </form>
</div>

<script type="text/x-tmpl" id="row-day-event">
<div class="row-day-events">
{%
	var js_date = Date.sqlDate(o.sql_date);
	var firstEvent = o.globalData.events[o.data[Object.keys(o.data)[0]][0]];
	if (firstEvent.KonstructorCreation) {
		include('konstructor-creation', {event: firstEvent.KonstructorCreation});
	} else {
%}
    <div class="col-md-12 col-sm-12 col-xs-12 start-day-data t-a-center">
        <div class="day-calendar">
            <div class="data">{%=js_date.getDate()%}</div>
            <div class="day">{%=aDays[js_date.getDay()]%}</div>
            <div class="month">{%=aMonths[js_date.getMonth()]%}</div>
        </div>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12 time-line-list">
{% 
	for(var hour in o.data) {
		include('time-line-cell', {globalData: o.globalData, hour: hour, data: o.data[hour]});
	}
%}
    </div>
{%
	}
%}
</div>
</script>

<script type="text/x-tmpl" id="time-line-cell">
<div class="time-line-cell clearfix">
    <div class="col-md-12 col-sm-12 col-xs-12 t-a-center time">
{%
		var js_date = new Date();
		js_date.setHours(o.hour);
		js_date.setMinutes(0);
%}
        <span>{%=(Date.HoursMinutes(js_date))%}
            <span class="add-event-time"><i class="glyphicon glyphicons circle_plus"></i></span>
        </span>
    </div>
    <div class="col-md-5 col-sm-5 col-xs-12 t-a-right event-box">
{%
		for(var i = 0; i < o.data.length; i++) {
			event = o.globalData.events[o.data[i]];
			if (event.UserEvent) {
				include('user-event', {globalData: o.globalData, event: event.UserEvent});
			} else if (event.ChatEvent && event.ChatEvent.file_id) {
				include('chat-event-file', {globalData: o.globalData, event: event.ChatEvent});
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
				include('self-registered', {globalData: o.globalData, event: event.SelfRegistration});
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
%}
<div class="event-box-cell clearfix">
    <div class="time-event col-md-1 col-sm-1 col-xs-12">{%=(Date.HoursMinutes(js_date))%}</div>
    <div class="user-page-event col-md-11 col-sm-11 col-xs-12">
        <div class="massage-post clearfix">
            <figure><img alt="{%=user.ChatUser.name%}" src="{%=user.Avatar.url%}" style="width: 50px"></figure>
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

<script type="text/x-tmpl" id="last_project">
<div class="news-article group-type progect-type">
    <a href="#">
        <div class="news-article-title"></div>
        <div class="news-article-title subtitle clearfix">
            <div class="subtitle-image">
                <img alt="" src="/img/user-profile/t_logo2.png">
            </div>
            <div class="subtitle-body">
                KONSTRUKTOR
                <div class="subtitle-body-info ">
                    11 участников
                </div>
            </div>
        </div>
        <div class="news-article-pubdate">
            Креативная среда
        </div>
    </a>
</div>
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
        <div class="start-project">{%=o.event.msg%}</div>
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
