var Timeline = {
	
	canvas: null,
	
	init: function(container) {
		Timeline.canvas = container;
	},
	
	updateTimeline: function() {
		$.get(profileURL.dashboardEvents, null, function(response){
			if (checkJson(response)) {
				Timeline.render(response.data);
			}
		});
	},
	
	render: function(data) {
		for(var sql_date in data.days) {
			$(Timeline.canvas).append(tmpl('row-day-event', {globalData: data, sql_date: sql_date, data: data.days[sql_date]}));
		}
	},
	
}

Date.sqlDate = function(mysql_string) { 
	if(typeof mysql_string === 'string')    {
		var t = mysql_string.split(/[- :]/);
		return new Date(t[0], t[1] - 1, t[2], t[3] || 0, t[4] || 0, t[5] || 0);          
	}
	return null;   
}
Date.HoursMinutes = function(js_date) {
	return zeroFormat(js_date.getHours()) + ':' + zeroFormat(js_date.getMinutes());
}
Date.fullDate = function(js_date) {
	return zeroFormat(js_date.getDate()) + '.' + zeroFormat(js_date.getMonth()) + '.' + js_date.getFullYear();
}
function zeroFormat(n) {
	return (n >= 10) ? '' + n : '0' + n;
}