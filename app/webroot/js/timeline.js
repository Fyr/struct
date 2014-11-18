var Timeline = {
	
	canvas: null,
	topDay: 0,
	bottomDay: 0,
	loadPeriod: 0,
	topDate: null,
	bottomDate: null,
	lEnableUpdate: true,
	timer: null,
	
	init: function(container, topDay, bottomDay, loadPeriod, data) {
		Timeline.canvas = container;
		Timeline.topDay = topDay;
		Timeline.bottomDay = bottomDay;
		Timeline.loadPeriod = loadPeriod;
		Timeline.topDate = Date.fromSqlDate(todayDate).addDays(Timeline.topDay);
		Timeline.bottomDate = Date.fromSqlDate(todayDate).addDays(Timeline.bottomDay);
		// Timeline.render(data);
		var html = Timeline.renderEvents(data);
		$(Timeline.canvas).append(html);
		Timeline.insertCurrentTime();
		Timeline.collapseEmptyCells();
		Timeline.scrollCurrentTime();
		Timeline.initHandlers();
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
			$('#' + id).before(tmpl('curr-time'));
			clearInterval(Timeline.timer);
			Timeline.timer = setInterval(function(){
				var _now = new Date();
				var time = Date.HoursMinutes(_now);
				if ($('.curr-time-value').html().indexOf(':') > -1) {
					time = time.replace(/\:/, ' ');
				}
				$('.curr-time-value').html(time);
			}, 500);
		}
	},
	
	scrollCurrentTime: function () {
		$('.curr-time-cell').get(0).scrollIntoView();
		window.scrollBy(0, -40);
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
		$('.row-day-events .time-line-list').each(function(){
			lGroup = false;
			var id = $(this).prop('id');
			$('#' + id + ' > .time-line-cell').each(function(){
				var leftBox = $('.t-a-right.event-box', this).length && $('.t-a-right.event-box', this).html().replace(/\s*/, '');
				var rightBox = $('.t-a-left.event-box', this).length && $('.t-a-left.event-box', this).html().replace(/\s*/, '');
				var centerBox = $('.t-a-left.event-box', this).length && $('.t-a-center', this).html().replace(/\s*/, '');
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
				html+= Format.tag('div', {id: $(this).prop('id'), class: 'time-line-cell clearfix'}, $(this).html());
			});
			$('.time-line-list > .cellGroup-' + i).wrapAll('<div class="toggle-dotted inactive"><div class="toggle-dotted-cells" /></div>');
			$('.time-line-list > .cellGroup-' + i).removeClass('cellGroup-' + i);
		}
		$('.toggle-dotted.inactive').append(tmpl('toggle-dotted-btn')).removeClass('inactive');;
		$('.toggle-dotted-cells').hide();
		$('.toggle-dotted-btn').show();
	},
	
	initHandlers: function() {
		$('.toggle-dotted-btn').click(function(){
			$(this).fadeOut('fast');
			$(this).parent().find('.toggle-dotted-cells').stop(true, false).slideDown();
			// $(this).parent().find('.toggle-dotted-cells').show();
		});
		
		$('.day-calendar').click(function(){
			$(this).parent().parent().find('.time-line-list').stop(true,false).slideToggle('slow');
			// $(this).parent().parent().find('.time-line-list').toggle();
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
	
	showEventPopup: function(e, sql_date, time) {
		Timeline.lEnableUpdate = false;
		$('.add-event-time').removeClass('open-plus');
		$(e).parent().find('add-event-time').addClass('open-plus');
		$('.add-event-block').removeClass('open').css({'top':$(e).offset().top}).addClass('open');
		
		$('#UserEventTimeEvent').val(time);
		$('#UserEventDateEvent').val(sql_date);
	},
	
	closeEventPopup: function() {
		$('.add-event-block .close-block').parent().removeClass('open');
		setTimeout(function(){ Timeline.lEnableUpdate = true; }, 50); // to prevent immidiate onScrollBottom event
	},
	
	addEvent: function() {
		Timeline.lEnableUpdate = false;
		$.post(profileURL.addEvent, $('.add-event-block form').serialize(), function(response){
			if (checkJson(response)) {
				var sql_date = $('#UserEventDateEvent').val();
				Timeline.topDate = Date.fromSqlDate(sql_date);
				Timeline.bottomDate = Date.fromSqlDate(sql_date);
				var html = Timeline.renderEvents(response.data);
				$('#row-day_' + sql_date).replaceWith(html);
				Timeline.collapseEmptyCells();
				Timeline.initHandlers();
			}
			Timeline.closeEventPopup();
		});
	},
	
	onScrollTop: function() {
		console.log('onScrollTop');
		Timeline.topDay+= Timeline.loadPeriod + 1;
		Timeline.topDate = Date.fromSqlDate(todayDate).addDays(Timeline.topDay);
		Timeline.bottomDate = Date.fromSqlDate(todayDate).addDays(Timeline.topDay - Timeline.loadPeriod);
		Timeline.update(true);
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
		}
	}
}

Date.timeDays = function(days) {
	return 86400 * 1000 * days;
}

Date.fromSqlDate = function(mysql_string) { 
	if(typeof mysql_string === 'string')    {
		var t = mysql_string.split(/[- :]/);
		return new Date(t[0], t[1] - 1, t[2], t[3] || 0, t[4] || 0, t[5] || 0);          
	}
	return null;   
}
Date.prototype.toSqlDate = function() { 
	return this.getFullYear() + '-' + zeroFormat(this.getMonth() + 1) + '-' + zeroFormat(this.getDate());
}
Date.HoursMinutes = function(jsdate) {
	var hours = jsdate.getHours();
	return zeroFormat((hours > 12) ? hours - 12 : hours) + ':' + zeroFormat(jsdate.getMinutes()) + ((hours > 12) ? 'pm' : 'am');
}
Date.fullDate = function(js_date) {
	return zeroFormat(js_date.getDate()) + '.' + zeroFormat(js_date.getMonth()) + '.' + js_date.getFullYear();
}
Date.prototype.addDays = function(days) {
	this.setTime(this.getTime() + Date.timeDays(days));
	return this;
}
function zeroFormat(n) {
	return (n >= 10) ? '' + n : '0' + n;
}