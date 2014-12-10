<div style="padding-top: 35px">	
	<div class="articleControls">
	<?php
		// кнопка [publish]
				if($owner) {
					echo $this->Html->link(	'Редактировать', 	
											array(	'action' => 'edit', 
											$article['Article']['id']), array( 'class' => 'btn btn-default smallBtn')
										  );
					if($article['Article']['published'] < 1) {
							echo $this->Html->link(	'<span class="glyphicons eye_close">', 	
																	array(	'action' => 'changePublish', 
																	$article['Article']['id']), array( 
																		'id' => 'publish', 
																		'class' => 'btn btn-default smallBtn', 
																		'escape' => false)
																  );
					} else {
						echo $this->Html->link(	'<span class="glyphicons eye_open">', 	
													array(	'action' => 'changePublish', 
													$article['Article']['id']), array( 
																	'id' => 'publish', 
																	'class' => 'btn btn-default smallBtn', 
																	'escape' => false)
												  );
					};
			// кнопка удаления
					/*
					echo $this->Html->link(	'<span class="glyphicons bin">', 	
												array(	'action' => 'delete', 
												$article['Article']['id']), 	
													array(	'confirm' => 'Are you sure you want remove this article?', 
															'class' => 'btn btn-default smallBtn', 'escape' => false)
											  );
					*/
				}
	?>
	</div>
	<div class="article-body" style="	width: 100%;
										color: #313131;
										font-size: 36px;
										font-family: 'Roboto';
										font-weight: 900;
										resize: none;
										height: 100px;
										line-height: 48px;
									 ">
		<?php echo $article['Article']['title']; ?>
	</div>

	<div class="article-body">
		<?php echo $article['Article']['abody']; ?>
	</div>
</div>