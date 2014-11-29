<?
	$taskID = Hash::get($task, 'Task.id');
	$closed = Hash::get($task, 'Task.closed');
?>
<div class="row header-project-page clearfix">
    <div class="project-page-title col-md-8 col-sm-8 col-xs-12"><?=Hash::get($task, 'Task.title')?></div>
    <div class="title-button page-menu col-md-4 col-sm-4 col-xs-12 clearfix">
        <a href="<?=$this->Html->url(array('controller' => 'Group', 'action' => 'view', Hash::get($group, 'Group.id')))?>" class="btn btn-default"><span class="glyphicons parents"></span></a>
<?
	if (!$closed) {
		echo $this->Html->link(
        	__('Close'), 
        	array('controller' => 'Project', 'action' => 'closeTask', $taskID),
        	array('class' => 'btn btn-default'),
        	__('Are you sure to close this task?')
        );
	}
?>
    </div>
</div>
<div class="descution-project-page">
    <div class="row clearfix">
        <div class="col-md-12 col-sm-12 col-xs-12 deadline-date">
            <div class="date">
                <span class="glyphicons anchor"></span>
                <?=__('Deadline')?>: <?=(Hash::get($task, 'Task.deadline')) ? Hash::get($task, 'Task.deadline') : ' - '?> <?=($closed) ? __('(Сlosed)') : ''?>
            </div>
           &nbsp;&nbsp; <?=__('Project')?>: <a href="<?=$this->Html->url(array('controller' => 'Project', 'action' => 'view', Hash::get($project, 'Project.id')))?>"><?=Hash::get($project, 'Project.title')?></a>
        </div>
    </div>
    <div class="row descution-users clearfix">
        <ul class="descution-users-list col-md-12 col-sm-12 col-xs-12">
            <li class="clearfix">
                <div class="user-rights col-md-3 col-sm-3 col-xs-12"><?=__('Manager')?></div>
                <div class="user-name col-md-9 col-sm-9 col-xs-12">
<?
	$user = $aUsers[Hash::get($task, 'Task.manager_id')];
?>
                    <a class="clearfix" href="<?=$this->Html->url(array('controller' => 'Profile', 'action' => 'view', $user['User']['id']))?>">
                        <div class="user-avatar">
                            <span class="user-avatar rate-10"><img src="<?=$user['Media']['url_img']?>" alt="<?=$user['User']['full_name']?>"/></span>
                        </div> <?=$user['User']['full_name']?>
                    </a>
                </div>
            </li>
            <li class="clearfix">
                <div class="user-rights col-md-3 col-sm-3 col-xs-12"><?=__('Assigned to')?></div>
                <div class="user-name col-md-9 col-sm-9 col-xs-12">
<?
	$user = $aUsers[Hash::get($task, 'Task.user_id')];
?>
                    <a class="clearfix" href="<?=$this->Html->url(array('controller' => 'Profile', 'action' => 'view', $user['User']['id']))?>">
                        <div class="user-avatar">
                            <span class="user-avatar rate-10"><img src="<?=$user['Media']['url_img']?>" alt="<?=$user['User']['full_name']?>"/></span>
                        </div> <?=$user['User']['full_name']?>
                    </a>
                </div>
            </li>
        </ul>
    </div>
    <div class="row new-descution col-md-12 col-sm-12 col-xs-12">
        <figure class="user-avatar-box col-md-2 col-sm-2 col-xs-2">
            <div class="user-avatar rate-10">
                <img src="<?=$currUser['Media']['url_img']?>" alt="<?=$currUser['User']['full_name']?>"/>
            </div>
        </figure>
        <div class="user-new-descution-text col-md-10 col-sm-10 col-xs-10">
            <?=$this->Form->create('ProjectEvent')?>
                <fieldset>
                    <label for="message-title"><?=__('Send message')?></label>
                    <textarea id="message-title" name="data[message]"></textarea>
                    <input type="submit" class="message-submit" value="" />
                </fieldset>
                <fieldset class="bottom-textarea clearfix">
                    <div class="upload-box-button page-menu">
                        <input id="filestyle-0" type="file" class="fileuploader" data-object_type="ProjectEvent" data-object_id="<?=$taskID?>" data-iconname="halflings uni-paperclip" data-buttontext="" data-input="false" style="position: absolute; clip: rect(0px, 0px, 0px, 0px);" tabindex="-1">
                        <div class="bootstrap-filestyle input-group">
                            <span class="group-span-filestyle" tabindex="0">
                                <label class="btn btn-default" for="filestyle-0"><span class="halflings uni-paperclip"></span></label>
                            </span>
                        </div>
		                <div id="progress-bar">
			            	<div id="progress-stats"></div>
			            </div>
                    </div>
                    <div class="enter-massage-label">
                        <?=__('To send message press Enter')?>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
    <div class="row descution-massages col-md-12 col-sm-12 col-xs-12">
        <div class="descution-massages-title"><?=__('Discussion')?></div>
        <div class="descution-massages-list">
<?
	foreach($aEvents as $event) {
		$user = $members[$event['ProjectEvent']['user_id']];
		if (in_array($event['ProjectEvent']['event_type'], array(ProjectEvent::TASK_CREATED, ProjectEvent::TASK_CLOSED, ProjectEvent::TASK_COMMENT, ProjectEvent::FILE_ATTACHED))) {
?>
            <div class="descution-massages-cell col-md-12 col-sm-12 col-xs-12">
                <div class="user-avatar col-md-1 col-sm-1 col-xs-2">
                    <a href="<?=$this->Html->url(array('controller' => 'Profile', 'action' => 'view', $user['User']['id']))?>" class="rate-0"><img src="<?=$user['Media']['url_img']?>" alt="<?=$user['User']['full_name']?>" /></a>
                </div>
                <div class="massages-cont col-md-11 col-sm-11 col-xs-10">
                    <div class="massages-cont-text col-md-9 col-sm-9 col-xs-12">
                        <div class="massage-user">
                        	<a name="post<?=$event['ProjectEvent']['id']?>"></a>
<?
			switch ($event['ProjectEvent']['event_type']) {
				case ProjectEvent::TASK_CREATED: 
					echo __('Task was created');
					break;
					
				case ProjectEvent::TASK_CLOSED: 
					echo __('Task was closed');
					break;
					
				case ProjectEvent::TASK_COMMENT: 
					$msg_id = $event['ProjectEvent']['msg_id'];
?>
							<p><?=$messages[$msg_id]['message']?></p>
<?
					break;
					
				case ProjectEvent::FILE_ATTACHED: 
					$file = $files[$event['ProjectEvent']['file_id']];
?>
                            <a href="<?=$file['url_download']?>">
                                <figure>
                                    <span style="font-size:2em" class="filetype <?=str_replace('.', '', $file['ext'])?>"></span> <span><?=$file['orig_fname']?></span>
                                </figure>
                            </a>
<?
					break;
			}
?>
                        </div>
                    </div>
                    <div class="massages-cont-files col-md-3 col-sm-3 col-xs-12"></div>
                    <div class="massage-date col-md-10 col-sm-10 col-xs-10">
                        <div class="massage-date-cont"><?=$event['ProjectEvent']['created']?></div>
                    </div>
                </div>
            </div>
<?
		}
	}
?>
        </div>
    </div>
    
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('#ProjectEventTaskForm textarea').bind('keypress', function(event) {
		if (event.which == 13) {
			event.preventDefault();
			$('#ProjectEventTaskForm').submit();
		}
	});
});
</script>