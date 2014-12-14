var sum_bitrate = 0, count_bitrate = 0, context, resizeAspect, jcrop_api, jcrop_data = [];

function getProgressContext(data) {
	var progressID = $(data.fileInput).data('progress_id');
	return (progressID) ? $('#' + progressID).get(0) : document.body;
}

function saveJcropData(c) {
	jcrop_data = [Math.floor(c.x / resizeAspect), Math.floor(c.y / resizeAspect), Math.floor(c.w / resizeAspect), Math.floor(c.h / resizeAspect)];
};

function jcropInit(data) {
	var oFReader = new FileReader();
	oFReader.readAsDataURL(data.files[0]);

	oFReader.onload = function (oFREvent) {
		if (jcrop_api) {
			jcrop_api.destroy();
		}
		$('.avatar-img img#tempAvatar').remove();
		$('.avatar-img').append('<img id="tempAvatar" src="" alt="" />');
		
		var img = $('img#tempAvatar').get(0);
   		$(img).hide().prop('src', oFREvent.target.result);
   		
   		var count = 0;
   		var timer = setInterval(function(){
   			var iW = img.width, iH = img.height;
   			console.log(count);
   			if (count > 50) {
   				alert('Your photo is too large. Please upload another one');
   			}
   			if (iW < 5) {
   				count++;
   				return;
   			}
   			clearInterval(timer);
   			
   			$('#userAvatarUpload').show();
   			$(img).show();
   		
	   		resizeAspect = 200 / iW;
	   		$(img).prop('width', 200);
	   		$(img).prop('height', iH * resizeAspect);
	   		
	   		var min = Math.min(iW, iH);
	   		// console.log(['Orig size', iW, iH, 'Current', img.width, img.height, 'Select', min]);
	   		// alert(['Orig size', iW, iH, 'Current', img.width, img.height, 'Select', min].join());
			$('#tempAvatar').Jcrop({
				aspectRatio: 1 / 1,
				bgOpacity: 0.5,
				setSelect: [ 0, 0, min, min],
				onSelect: saveJcropData,
        		onChange: saveJcropData
			}, function(){
			    jcrop_api = this;
			});
   		}, 100);
	}
}

$(function () {
	$('.fileuploader').fileupload({
		url: mediaURL.upload,
		dataType: 'json',
		done: function (e, data) {
			var file = data.result.files[0];
			file.object_type = $(data.fileInput).data('object_type');
			file.object_id = $(data.fileInput).data('object_id');
			file.crop = jcrop_data;
			
			$('.inputFile').hide();
			$('#processFile', getProgressContext(data)).show();
			$.post(mediaURL.move, file, function(response){
                $('#processFile', getProgressContext(data)).hide();
                $('.inputFile').show();
                $('#progress-bar', getProgressContext(data)).hide();
                if (checkJson(response)) {
                	if (file.object_type == 'Chat') {
	                	var fileData = response.data[0].Media;
	                	Chat.Panel.rooms[Chat.Panel.activeRoom].sendFile(fileData);
                	} else if (file.object_type == 'GroupGallery') {
                		Group.updateGalleryAdmin($(data.fileInput).data('object_id'));
                	} else if (file.object_type == 'ProjectEvent') {
                		window.location.reload();
                	} else { // User Avatar, User University, Group Avatar
                		var imgID = $(data.fileInput).data('object_type') + $(data.fileInput).data('object_id');
                		var mediaID = $('#' + imgID).data('media_id');
                		if (mediaID) {
                			$(data.fileInput).data('id', mediaID);
                		}
                		$('#' + imgID).prop('src', response.data[0].Media.url_img.replace(/noresize/, $('#' + imgID).data('resize')));
                		$('#' + imgID).data('media_id', response.data[0].Media.id);
                		if ($(data.fileInput).prop('id') == 'userAvatarChoose') {
                			if (jcrop_api) {
								jcrop_api.destroy();
								jcrop_api = null;
							}
							$('#' + imgID).show();
							$('#tempAvatar').remove();
							$('#userAvatarUpload').hide();
                		}
                	}
                }
            }, 'json');
		},
		add: function (e, data) {
			if (e.isDefaultPrevented()) {
				return false;
			}
			
			context = getProgressContext(data);
			$('#progress .progress-bar', context).css('width', 0);
			$('#progress-bar', context).show();
			$('#progress-stats', context).html('&nbsp;');
			// $('#processFile').show();
			var clickedButton = data.fileInput[0];
			if ($(clickedButton).prop('id') == 'userAvatarChoose') {
				// $('#userAvatarUpload').data(data);
				$('img#' + $(clickedButton).data('object_type') + $(clickedButton).data('object_id')).hide();
				$('#userAvatarUpload').data(data);
				jcropInit(data);
				return;
			}
			$('.inputFile').hide();
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

