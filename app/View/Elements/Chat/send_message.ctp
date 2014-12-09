<div class="sendForm clearfix" style="display: none;">
	<img class="ava" src="<?=$this->Media->imageUrl($currUser['UserMedia'], 'thumb100x100')?>" alt="" />
	<div class="text"><?=__('Send message')?></div>
	<textarea></textarea>
	<a href="javascript: void(0)" class="icon icon_enter"></a>
	<div class="clearfix"></div>
	<div class="formBottom clearfix" style="height: 32px;">
		<div class="inputFile icon icon_attach">
			<input type="file" class="fileuploader" data-object_type="Chat" />
		</div>
		<span><?=__('To send message press Enter')?></span>
		<div id="processRequest" style="padding-top: 4px; padding-left: 40px; display: none;"><img src="/img/ajax_loader.gif" alt="" /> <span style="float: none;"><?=__('Processing request...')?></span></div>
		<div id="processFile" style="padding-top: 4px; padding-left: 40px; display: none;"><img src="/img/ajax_loader.gif" alt="" /> <span style="float: none;"><?=__('Processing file...')?></span></div>
		<div id="progress-bar" style="display: none; position: absolute; width: 545px; padding-top: 12px;">
			<div id="progress-stats" style="font-size: 10px; text-align: center;">&nbsp;</div>
			<div id="progress" class="progress" style="margin-bottom 0; height: 5px;">
				<div class="progress-bar progress-bar-success"></div>
			</div>
		</div>
	</div>
</div>