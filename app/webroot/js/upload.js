var sum_bitrate = 0, count_bitrate = 0, context;

function getProgressContext(data) {
	var progressID = $(data.fileInput).data('progress_id');
	return (progressID) ? $('#' + progressID).get(0) : document.body;
}

$(function () {
	$('.fileuploader').fileupload({
		url: mediaURL.upload,
		dataType: 'json',
		done: function (e, data) {
			var file = data.result.files[0];
			file.object_type = $(data.fileInput).data('object_type');
			file.object_id = $(data.fileInput).data('object_id');
			
			$('.inputFile').hide();
			$.post(mediaURL.move, file, function(response){
                $('#processFile', getProgressContext(data)).hide();
                $('.inputFile').show();
                $('#progress-bar', getProgressContext(data)).hide();
				$('#processFile', getProgressContext(data)).show();
                if (checkJson(response)) {
                	if (file.object_type == 'Chat') {
	                	var fileData = response.data[0].Media;
	                	Chat.sendFile(fileData);
                	} else if (file.object_type == 'GroupGallery') {
                		Group.updateGalleryAdmin($(data.fileInput).data('object_id'));
                	} else if (file.object_type == 'ProjectEvent') {
                		window.location.reload();
                	} else { // User Avatar, User University, Group Avatar
                		var imgID = $(data.fileInput).data('object_type') + $(data.fileInput).data('object_id');
                		var mediaID = $('#' + imgID).data('media_id');
                		if (mediaID) {
                			$(data.fileInput).data('id', mediaID);
                			/*
                			$.post(mediaURL.delete, {data: $(data.fileInput).data()}, function(){
                			}, 'json');
                			*/
                		}
                		$('#' + imgID).prop('src', response.data[0].Media.url_img.replace(/noresize/, $('#' + imgID).data('resize')));
                		$('#' + imgID).data('media_id', response.data[0].Media.id);
                	}
                }
            }, 'json');
		},
		add: function (e, data) {
			if (e.isDefaultPrevented()) {
				return false;
			}
			$('.inputFile').hide();
			context = getProgressContext(data);
			$('#progress .progress-bar', context).css('width', 0);
			$('#progress-bar', context).show();
			$('#progress-stats', context).html('&nbsp;');
			// $('#processFile').show();
			data.submit();
		},
		progressall: function (e, data) {
			var progress = parseInt(data.loaded / data.total * 100, 10);
			$('#progress .progress-bar', getProgressContext(data)).css('width', progress + '%');
			sum_bitrate+= data.bitrate;
			count_bitrate++;
			var avg_bitrate = sum_bitrate / count_bitrate;
			var html = Format.bitrate(avg_bitrate) + ' | ' +
				Format.time((data.total - data.loaded) * 8 / avg_bitrate) + ' | ' +
				Format.percentage(data.loaded / data.total) + ' | ' +
				Format.fileSize(data.loaded) + ' / ' + Format.fileSize(data.total);
			$('#progress-stats', context).html(chatLocale.Loading); // html
		}
	}).prop('disabled', !$.support.fileInput)
		.parent().addClass($.support.fileInput ? undefined : 'disabled');
});

