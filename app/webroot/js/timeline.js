var Timeline = {
	
	canvas: null,
	topDay: 0,
	bottomDay: 0,
	loadPeriod: 0,
	topDate: null,
	bottomDate: null,
	lEnableUpdate: true,
	clockTimer: null,
	updateTimer: null,
	updateTime: null,
	
	init: function(options, data) {
		Timeline = $.extend(Timeline, options);
		
		Timeline.topDate = Date.fromSqlDate(todayDate).addDays(Timeline.topDay);
		Timeline.bottomDate = Date.fromSqlDate(todayDate).addDays(Timeline.bottomDay);
		var html = Timeline.renderEvents(data);
		$(Timeline.canvas).append(html);
		Timeline.insertCurrentTime();
		Timeline.collapseEmptyCells();
		Timeline.scrollCurrentTime();
		Timeline.initHandlers();
		
		if (Timeline.updateTime) {
			Timeline.updateTimer = setInterval(function(){
				// Timeline.updateState();
				//clearInterval(Timeline.updateTimer);
			}, Timeline.updateTime);
		}
	},
	
	update: function(lPrepend) {
		Timeline.lEnableUpdate = false;
		$.post(profileURL.timelineEvents, {data: {date: this.bottomDate.toSqlDate(), date2: this.topDate.toSqlDate()}}, function(response){
			if (checkJson(response)) {
				Timeline.render(response.data, lPrepend);
			}
			Timeline.lEnableUpdate = true;
		});
	},
	
	insertCurrentTime: function() {
		if (!$('.curr-time-cell').length) {
			var _now = new Date();
			var id = 'timeline' + _now.toSqlDate() + '_' + zeroFormat(_now.getHours()) + '00';
			$('#' + id).before(tmpl('curr-time', {time: Date.HoursMinutes(_now)}));
			clearInterval(Timeline.clockTimer);
			Timeline.clockTimer = setInterval(function(){
				var _now = new Date();
				var time = Date.HoursMinutes(_now);
				if ($('.curr-time-value').length) {
					if ($('.curr-time-value').html().indexOf(':') > -1) {
						time = time.replace(/\:/, ' ');
					}
					$('.curr-time-value').html(time);
				}
			}, 500);
		}
	},
	
	scrollCurrentTime: function () {
		if ($('.curr-time-cell').length) {
			$('.curr-time-cell').get(0).scrollIntoView();
			window.scrollBy(0, -40);
		}
	},
	
	renderEvents: function(data) {
		var jsDate = Date.fromSqlDate(todayDate), html = '';
		for(var time = Timeline.topDate.getTime(); time >= Timeline.bottomDate.getTime(); time-= Date.timeDays(1)) {
			jsDate.setTime(time);
			html+= tmpl('row-day-event', {
				globalData: data, 
				sql_date: jsDate.toSqlDate(), 
				data: (data.days && data.days[jsDate.toSqlDate()]) ? data.days[jsDate.toSqlDate()] : {}
			});
		}
		if (jsDate.toSqlDate() == startDate) {
			html+= tmpl('timeline-bottom', {});
		}
		return html;
	},
	
	render: function(data, lPrepend) {
		var html = Timeline.renderEvents(data);
		if (lPrepend) {
			$(Timeline.canvas).prepend(html);
		} else {
			$(Timeline.canvas).append(html);
		}
		// Timeline.insertCurrentTime();
		Timeline.collapseEmptyCells();
		// Timeline.scrollCurrentTime();
		Timeline.initHandlers();
	},
	
	collapseEmptyCells: function() {
		var lGroup = false, groupID = 0, html = '';
		$('.row-day-events.events-collapsible .time-line-list').each(function(){
			lGroup = false;
			var id = $(this).prop('id');
			$('#' + id + ' > .time-line-cell').each(function(){
				var leftBox = $('.t-a-right.event-box', this).length && $('.t-a-right.event-box', this).html().replace(/\s*/, '');
				var rightBox = $('.t-a-left.event-box', this).length && $('.t-a-left.event-box', this).html().replace(/\s*/, '');
				// var centerBox = $('.t-a-center.time', this).length && $('.t-a-center.time', this).html().replace(/\s*/, '');
				var html = '';
				if (!leftBox && !rightBox) {
					$(this).addClass('empty-cell');
					if (!lGroup) {
						groupID++;
						lGroup = true;
					}
					$(this).addClass('cellGroup-' + groupID);
				} else {
					lGroup = false;
					$(this).addClass('event-cell');
				}
			});
		});
		for(var i = 1; i <= groupID; i++) {
			html = '';
			$('.time-line-list > .empty-cell.cellGroup-' + i).each(function(){
				html+= Format.tag('div', {'id': $(this).prop('id'), 'class': 'time-line-cell clearfix'}, $(this).html());
			});
			$('.time-line-list > .cellGroup-' + i).wrapAll('<div class="toggle-dotted inactive"><div class="toggle-dotted-cells" /></div>');
			$('.time-line-list > .cellGroup-' + i).removeClass('cellGroup-' + i);
		}
		$('.toggle-dotted.inactive').append(tmpl('toggle-dotted-btn')).removeClass('inactive');;
		$('.toggle-dotted-cells').hide();
		$('.toggle-dotted-btn').show();
		// $('.row-day-events .time-line-list.events-expanded').removeClass('events-expanded').addClass('events-collapsed');
	},
	
	initHandlers: function() {
		$('.events-collapsible .toggle-dotted-btn').click(function(){
			$(this).fadeOut('fast');
			// $(this).parent().find('.toggle-dotted-cells').stop(true, false).slideDown();
			$(this).parent().find('.toggle-dotted-cells').show();
			if (Timeline.updateTime) {
				clearInterval(Timeline.updateTimer);
				Timeline.updateTimer = setInterval(function(){
					Timeline.updateState();
					//clearInterval(Timeline.updateTimer);
				}, Timeline.updateTime);
			}
		});
		
		$('.events-collapsible .day-calendar').click(function(){
			// $(this).parent().parent().find('.time-line-list').stop(true,false).slideToggle('slow');
			$(this).parent().parent().find('.time-line-list').toggle();
		});
		
		$(window).off('scroll');
		$(window).scroll(function(event){
			event.stopPropagation();
			if (Timeline.lEnableUpdate) {
				var scrolled = window.pageYOffset || document.documentElement.scrollTop;
				if (!scrolled) {
					Timeline.onScrollTop();
				} else if (scrolled >= ($(document).height() - $(window).height())) {
					Timeline.onScrollBottom();
				}
			}
		});
	},
	
	showEventPopup: function(sql_date, hours, event_id) {
		Timeline.lEnableUpdate = false;
		var id = 'timeline' + sql_date + '_' + zeroFormat(hours) + '00';
		var $e = $('#' + id + ' .t-a-center > span');
		if (event_id) {
			$('.fieldset-block.create-event').hide();
			$('.fieldset-block.edit-event').show();
		} else {
			$('.fieldset-block.create-event').show();
			$('.fieldset-block.edit-event').hide();
		}
		$('.add-event-block').css({'top':$e.offset().top}).removeClass('open').addClass('open');
	},
	
	closeEventPopup: function() {
		$('.add-event-block').removeClass('open');
		setTimeout(function(){ Timeline.lEnableUpdate = true; }, 50); // to prevent immidiate onScrollBottom event
	},
	
	addEventPopup: function(sql_date, hours)  {
		$('.add-event-block input').val('');
		var js_date = Date.fromSqlDate(sql_date);
		js_date.setHours(hours);
		$('#UserEventTimeEvent').val(Date.HoursMinutes(js_date));
		$('#UserEventDateEvent').val(sql_date);
		$('#UserEventJsDateEvent').val(Date.fullDate(js_date, locale));
		Timeline.showEventPopup(sql_date, hours, 0);
	}, 
	
	editEventPopup: function(sql_date, time, event_id) {
		var aHoursMinutes = time.split(':');
		var hours = aHoursMinutes[0];
		var js_date = Date.fromSqlDate(sql_date);
		js_date.setHours(parseInt(hours));
		var e = $('#user-event_' + event_id).get(0);
		
		$('#UserEventId').val(event_id);
		$('#UserEventTimeEvent').val(Date.HoursMinutes(js_date));
		$('#UserEventDateEvent').val(sql_date);
		$('#UserEventJsDateEvent').val(Date.fullDate(js_date, locale));
		$('#UserEventTitle').val($('.user-event-title', e).html());
		$('#UserEventDescr').val($('.user-event-descr', e).html());
		Timeline.showEventPopup(sql_date, hours, event_id);
	},
	
	eventIsValid: function() {
		return $('#UserEventTitle').val() && $('#UserEventTimeEvent').val() && $('#UserEventDateEvent').val();
	},
	
	updateEvent: function() {
		if (Timeline.eventIsValid()) {
			Timeline.lEnableUpdate = false;
			$.post(profileURL.updateEvent, $('.add-event-block form').serialize(), function(response){
				if (checkJson(response)) {
					Timeline.updateDay($('#UserEventDateEvent').val(), response.data);
				}
				Timeline.closeEventPopup();
			});
		}
	},
	
	deleteEvent: function() {
		Timeline.lEnableUpdate = false;
		if (Timeline.eventIsValid()) {
			$.post(profileURL.deleteEvent, $('.add-event-block form').serialize(), function(response){
				if (checkJson(response)) {
					var js_date = Date.fromSqlDate(response.data.event.UserEvent.event_time);
					js_date.setHours(0);
					Timeline.updateDay(js_date.toSqlDate(), response.data.timeline);
				}
				Timeline.closeEventPopup();
			});
		}
	},
	
	updateState: function() {
		if (Timeline.lEnableUpdate) {
			Timeline.lEnableUpdate = false;
			$.post(profileURL.timelineEvents, {data: {date: todayDate, date2: todayDate}}, function(response){
				if (checkJson(response)) {
					Timeline.updateDay(todayDate, response.data);
				}
				Timeline.lEnableUpdate = true;
			});
		}
	},
	
	updateDay: function(sql_date, data) {
		Timeline.topDate = Date.fromSqlDate(sql_date);
		Timeline.bottomDate = Date.fromSqlDate(sql_date);
		var html = Timeline.renderEvents(data);
		$('#row-day_' + sql_date).replaceWith(html);
		if (sql_date == todayDate) {
			Timeline.insertCurrentTime();
		}
		Timeline.collapseEmptyCells();
		Timeline.initHandlers();
	},
	
	onScrollTop: function() {
		console.log('onScrollTop');
		Timeline.topDay+= Timeline.loadPeriod + 1;
		Timeline.topDate = Date.fromSqlDate(todayDate).addDays(Timeline.topDay);
		Timeline.bottomDate = Date.fromSqlDate(todayDate).addDays(Timeline.topDay - Timeline.loadPeriod);
		Timeline.update(true);
		window.scrollBy(0, 10);
	},
	
	onScrollBottom: function() {
		console.log('onScrollBottom');
		Timeline.topDate = Date.fromSqlDate(todayDate).addDays(Timeline.bottomDay - 1);
		Timeline.bottomDay -= Timeline.loadPeriod;
		
		if (Timeline.bottomDay < startDay) {
			Timeline.bottomDay = startDay;
		}
		Timeline.bottomDate = Date.fromSqlDate(todayDate).addDays(Timeline.bottomDay);
		
		if (Timeline.topDate.getTime() >= Timeline.bottomDate.getTime()) {
			Timeline.update();
			window.scrollBy(0, -10);
		}
	}
}

