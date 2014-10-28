<?php
App::uses('AppHelper', 'View/Helper');
class MediaHelper extends AppHelper {
	public $helpers = array('Html');
	
	private $MediaPath;
	
	public function __construct(View $view, $settings = array()) {
		parent::__construct($view, $settings);
		
		App::uses('MediaPath', 'Media.Vendor');
		$this->MediaPath = new MediaPath();
	}
	
	function imageUrl($mediaRow, $size) {
		if (!(isset($mediaRow['Media']) && $mediaRow['Media'] && isset($mediaRow['Media']['id']) && $mediaRow['Media']['id']) ) {
			return '';
		}
		$media = $mediaRow['Media'];
		$url = $this->MediaPath->getImageUrl($media['object_type'], $media['id'], $size, $media['file'].$media['ext']);
		$fixedUrl = $this->Html->url(array('plugin' => 'media', 'controller' => 'router', 'action' => 'index'));
		$url = str_replace('/media/router', $fixedUrl, $url);
		return $url;
	}
}
