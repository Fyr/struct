var Timeline = {
	
	canvas: null,
	
	init: function(container) {
		Timeline.canvas = container;
		// Timeline.initHandlers();
	},
	
	updateTimeline: function() {
		$.get(profileURL.dashboardEvents, null, function(response){
			if (checkJson(response)) {
				Timeline.render(response.data);
			}
		});
	},
	
	render: function(data) {
		$(Timeline.canvas).html('');
		for(var sql_date in data.days) {
			$(Timeline.canvas).append(tmpl('row-day-event', {globalData: data, sql_date: sql_date, data: data.days[sql_date]}));
		}
		Timeline.initHandlers();
	},
	
	initHandlers: function() {
			/*
		$('.datetimepicker').datetimepicker({
        	pickTime: false
   		});

	    $('.toggle-dotted-line').on('click', function(){
	        $('.toggle-dotted-btn').fadeOut('fast');
	        $(this).parent().parent().parent().find('.toggle-dotted-cont').stop(true, false).slideDown();
	    });
	

	    $('.time span').on('touchstart click', function(event){
	        $('.add-event-time').removeClass('open-plus');
	        $(this).parent().find('add-event-time').addClass('open-plus');
	        $('.add-event-block').removeClass('open').css({'top':$(this).offset().top}).addClass('open');
	
	        //$(window).on('touchstart click', function(event){
	        //    if ($(event.target).closest($('.add-event-block, .time span')).length) return true;
	        //        $('.add-event-block').removeClass('open');
	        //    event.stopPropagation();
	        //});
	    });
	    
	    $('.add-event-block .close-block').on('touchstart click', function(){
	        $(this).parent().removeClass('open');
	    });
	
	    $('.row-day-events .day-calendar').on('click', function(){
	       $(this).parent().parent().find('.time-line-list').stop(true,false).slideToggle('slow');
	    });
	    */
		$('.toggle-dotted-line').on('click', function(){
			var id = this.id.replace(/dotted/, '');
			
			$('#time-list' + id + ' .toggle-dotted-btn').fadeOut('fast');
			$('#time-list' + id + ' .toggle-dotted-cont').stop(true, false).slideDown();
		});
	},
	
	showEventPopup: function(e, sql_date, time) {
		$('.add-event-time').removeClass('open-plus');
		$(e).parent().find('add-event-time').addClass('open-plus');
		$('.add-event-block').removeClass('open').css({'top':$(e).offset().top}).addClass('open');
		
		$('#UserEventTimeEvent').val(time);
		$('#UserEventDateEvent').val(sql_date);
	},
	
	addEvent: function() {
		/*
		$('#UserEventTimeEvent').val();
		$('#UserEventDateEvent').val();
		$timeline = $('#' + $('#UserEventDateEvent').val() + '')
		*/
		$.post(timelineURL.addEvent, $('.add-event-block form').serialize(), function(response){
			if (checkJson(response)) {
				Timeline.render(response.data);
			}
		});
	}
}

Date.sqlDate = function(mysql_string) { 
	if(typeof mysql_string === 'string')    {
		var t = mysql_string.split(/[- :]/);
		return new Date(t[0], t[1] - 1, t[2], t[3] || 0, t[4] || 0, t[5] || 0);          
	}
	return null;   
}
Date.HoursMinutes = function(jsdate) {
	var hours = jsdate.getHours();
	return zeroFormat((hours > 12) ? hours - 12 : hours) + ':' + zeroFormat(jsdate.getMinutes()) + ((hours > 12) ? ' pm' : ' am');
}
Date.fullDate = function(js_date) {
	return zeroFormat(js_date.getDate()) + '.' + zeroFormat(js_date.getMonth()) + '.' + js_date.getFullYear();
}
function zeroFormat(n) {
	return (n >= 10) ? '' + n : '0' + n;
}