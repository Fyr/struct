<?
	$projectID = Hash::get($project, 'Project.id');
	$tasks = Hash::combine($aTasks, '{n}.Task.id', '{n}');
	$aTasks = Hash::combine($aTasks, '{n}.Task.id', '{n}', '{n}.Task.subproject_id');
?>
<div class="row header-project-page clearfix">
    <div class="project-page-title col-md-4 col-sm-12 col-xs-12"><?=Hash::get($project, 'Project.title')?></div>
    <div class="title-button page-menu col-md-8 col-sm-12 col-xs-12 clearfix">
    	<a href="<?=$this->Html->url(array('controller' => 'Group', 'action' => 'view', Hash::get($project, 'Project.group_id')))?>" class="btn btn-default"><?=__('Go to Group')?></a>
    	<!--
        <a class="btn btn-default" href="#"><span class="glyphicons coins"></span></a>
        <a class="btn btn-default" href="#"><span class="glyphicons pause"></span></a>
        -->
<?
	if ($isProjectAdmin) {
		echo $this->Html->link(__('Close'), array('controller' => 'Project', 'action' => 'close', $projectID), array('class' => 'btn btn-default'), __('Are you sure to close this project?'));
?>
        <!-- a class="btn btn-default" href="<?=$this->Html->url(array('controller' => 'Project', 'action' => 'close', $projectID))?>"><?=__('Close')?></a-->
        <a class="btn btn-default wrench" href="<?=$this->Html->url(array('controller' => 'Project', 'action' => 'edit', $projectID))?>"><span class="glyphicons wrench"></span></a>
<?
	}
?>
    </div>
</div>

<!--div class="row description-project-page clearfix">
    <div class="col-md-9 col-sm-9 col-xs-12 text-description">
        <p><?=Hash::get($project, 'Project.descr')?></p>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12 deadline-date">
        <div class="date">
        	<?=(Hash::get($project, 'Project.closed')) ? __('Closed') : ''?><br/>
            <span class="glyphicons anchor"></span>
            <?=__('Deadline')?><?=(Hash::get($project, 'Project.deadline')) ? ': '.Hash::get($project, 'Project.deadline') : ': - '?>
        </div>
    </div>
</div-->

<div class="row description-project-page clearfix">
    <div class="col-md-12 col-sm-12 col-xs-12 text-description">
     <div class="col-md-9 col-sm-9 col-xs-12">
         <p><?=Hash::get($project, 'Project.descr')?></p>
     </div>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12 deadline-date">
        <div class="date">
<?
	$closed = Hash::get($project, 'Project.closed');
	$deadline = Hash::get($project, 'Project.deadline');
?>
            <?=($closed) ? __('Closed') : ''?><br/>
            <span class="glyphicons anchor"></span>
            <?=__('Deadline')?>: <?=$this->LocalDate->date($deadline)?>
        </div>
    </div>
</div>
<div class="row project-timeline clearfix">
    <div class="col-md-12 col-sm-12 col-xs-12 project-timeline-list">
        <div class="title-list">
            <span class="glyphicons clock"></span>
           <?=__('Last updates')?>
        </div>
        <ul class="list-timeline">
<?
	foreach($aEvents as $event) {
		$user = $aUsers[$event['ProjectEvent']['user_id']];
		$userLink = $this->element('user_link', compact('user'));
?>
            <li class="clearfix">
                <div class="time col-md-3 col-sm-3 col-xs-12"><?=$this->LocalDate->dateTime($event['ProjectEvent']['created'])?></div>
                <div class="timeline-text col-md-9 col-sm-9 col-xs-12">
<?
		switch ($event['ProjectEvent']['event_type']) {
			case ProjectEvent::PROJECT_CREATED: echo __('%s created this project', $userLink); break;
			case ProjectEvent::SUBPROJECT_CREATED: 
				$subproject = $subprojects[$event['ProjectEvent']['subproject_id']];
				echo __('%s created subproject "%s"', $userLink, $subproject['Subproject']['title']); 
				break;
			case ProjectEvent::TASK_CREATED: 
				$task = $tasks[$event['ProjectEvent']['task_id']];
				echo __('%s created task %s', $userLink, $this->Html->link($task['Task']['title'], array('action' => 'task', $task['Task']['id']))); 
				break;
			case ProjectEvent::PROJECT_CLOSED: echo __('closed this project'); break;
			case ProjectEvent::SUBPROJECT_CLOSED: 
				$subproject = $subprojects[$event['ProjectEvent']['subproject_id']];
				echo __('%s closed subproject "%s"', $userLink, $subproject['Subproject']['title']); 
				break;
			case ProjectEvent::TASK_CLOSED: 
				$task = $tasks[$event['ProjectEvent']['task_id']];
				echo __('%s closed task %s', $userLink, $this->Html->link($task['Task']['title'], array('action' => 'task', $task['Task']['id']))); 
				break;
			case ProjectEvent::TASK_COMMENT: 
				$task = $tasks[$event['ProjectEvent']['task_id']];
				$taskLink = $this->Html->link($task['Task']['title'], array('action' => 'task', $task['Task']['id'], '#' => 'post'.$event['ProjectEvent']['id']));
				echo __('%s commented task %s', $userLink, $taskLink); 
				break;
			case ProjectEvent::FILE_ATTACHED: 
				$task = $tasks[$event['ProjectEvent']['task_id']];
				$taskLink = $this->Html->link($task['Task']['title'], array('action' => 'task', $task['Task']['id'], '#' => 'post'.$event['ProjectEvent']['id']));
				$file = $files[$event['ProjectEvent']['file_id']];
				$fileLink = $this->Html->link($file['orig_fname'], $file['url_download']);
				echo __('%s attached %s to task %s', $userLink, $fileLink, $taskLink); 
				break;
		}
?>
                </div>
            </li>
<?
	}
?>
        </ul>
    </div>
</div>
<div class="row under-project">
<?
	if ($isProjectAdmin) {
?>
    <div class="page-menu new-under-project">
        <a href="javascript:void(0)" class="btn btn-default new-under-project-btn">Новый подпроект</a>
    </div>
<?
	}
	foreach($subprojects as $subprojectID => $subproject) {
		// $subprojectID = Hash::get($subproject, 'Subproject.id')
?>
    <div class="under-project-cell clearfix">
        <div class="cell-title clearfix">
            <div class="col-md-3 col-sm-3 col-xs-12 title-under-project"><?=Hash::get($subproject, 'Subproject.title')?></div>
            <div class="col-md-9 col-sm-9 col-xs-12 sub-title">
                <div class="col-md-9 col-sm-9 col-xs-9 sub-title-label"><?=__('Assigned to')?></div>
                <div class="col-md-3 col-sm-3 col-xs-3 sub-title-label"><span class="glyphicons anchor"></span><?=__('Deadline')?></div>
            </div>
        </div>
        <ul class="cell-list">
<?
		$openTasks = 0;
		$closedTasks = 0;
		if (isset($aTasks[$subprojectID]) && ($tasks = $aTasks[$subprojectID])) {
			foreach($tasks as $taskID => $task) {
				if (!$task['Task']['closed']) {
					$user = $aUsers[$task['Task']['user_id']];
					$openTasks++;
					echo $this->element('project_tasks', compact('task', 'user'));
				} else {
					$closedTasks++;
				}
			}
		}
		if (!$openTasks) {
?>
			<li class="clearfix"><?=__('No open tasks')?></li>
<?
		}
?>
        </ul>
<?
		if ($isProjectAdmin) {
?>
        <div class="page-menu new-task">
            <a href="#" class="add-new-task-project" onclick="addNewTask(<?=$subprojectID?>)">
                <button class="btn btn-default"><span class="glyphicons plus"></span></button>
                <?=__('New task')?>
            </a>
        </div>
<?
		}
		if ($closedTasks) {
?>
        <div class="end-under-project-list">
            <div class="title-end-under-project">
                <span><?=__('Closed tasks')?></span>
            </div>
            <div class="end-under-project-block">
                <div class="under-project-cell">
                    <ul class="cell-list">
<?
			if (isset($aTasks[$subprojectID]) && ($tasks = $aTasks[$subprojectID])) {
				foreach($tasks as $taskID => $task) {
					if ($task['Task']['closed']) {
						$user = $aUsers[$task['Task']['user_id']];
						echo $this->element('project_tasks', compact('task', 'user'));
					}
				}
			}
?>
                    </ul>
                </div>
            </div>
        </div>
<?
		}
?>
    </div>
<?
	} // $aSubproject
?>
</div>

<?
	if ($isProjectAdmin) {
?>

<div class="drop-add-sub-project popup-block">
    <div class="close-block glyphicons circle_remove"></div>
    <?=$this->Form->create('Subproject', array('url' => array('controller' => 'Project', 'action' => 'addSubproject')))?>
        <!--label for="drop-add-sub-project-1">Название подпроекта</label>
        <input id="drop-add-sub-project-1" type="text"/-->
        <?=$this->Form->hidden('project_id', array('value' => $projectID))?>
        <?=$this->Form->input('title')?>
        <div class="page-menu clearfix">
            <button type="submit" class="btn btn-default"><?=__('Add subproject')?></button>
        </div>
    <?=$this->Form->end()?>
</div>

<div class="drop-add-sub-project-user popup-block">
    <div class="close-block glyphicons circle_remove"></div>
    <?=$this->Form->create('Task', array('url' => array('controller' => 'Project', 'action' => 'addTask', $projectID)))?>
    	<?=$this->Form->hidden('creator_id', array('value' => $currUserID))?>
    	<?=$this->Form->hidden('subproject_id')?>
        <?=$this->Form->input('title')?>
<?
	$dateFormat = (Hash::get($currUser, 'User.lang') == 'rus') ? 'DD.MM.YYYY' : 'MM/DD/YYYY';
?>
        <?=$this->Form->input('js_deadline', array('type' => 'text', 'class' => 'datetimepicker', 'data-date-format' => $dateFormat, 'label' => array('text' => __('Deadline'))))?>
        <?=$this->Form->hidden('deadline')?>
        <label><?=__('Manager')?></label>
        <?=$this->Form->input('manager_id', array('options' => $aMemberOptions, 'class' => 'formstyler', 'label' => false))?>
        <label><?=__('Assigned to')?></label>
        <?=$this->Form->input('user_id', array('options' => $aMemberOptions, 'class' => 'formstyler', 'label' => false))?>
        <?=$this->Form->input('descr', array('label' => array('text' => __('Description'))))?>
        <div class="page-menu clearfix">
            <button type="submit" class="btn btn-default"><?=__('Add task')?></button>
        </div>
    <?=$this->Form->end()?>
</div>

<script type="text/javascript">
function addNewTask(subprojectID) {
	$('.popup-block').hide();
	$('.drop-add-sub-project-user').show();
	$('#TaskSubprojectId').val(subprojectID);
}

$(document).ready(function(){
    $('.new-under-project-btn').on('click', function(){
        $('.popup-block').hide();
        $('.drop-add-sub-project').show();
    });
    $('.popup-block .close-block, .popup-block .close-block').on('click', function(){
        $('.popup-block').hide();
    });
    $('.datetimepicker').datetimepicker({
		pickTime: false
	});
	
	$('#TaskJsDeadline').change(function(){
		$('#TaskDeadline').val(Date.local2sql($(this).val()));
	});
});

</script>
<?
	}
?>