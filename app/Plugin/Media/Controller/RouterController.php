<?
App::uses('AppController', 'Controller');
class RouterController extends AppController {
	var $name = 'Router';
	var $layout = false;
	var $uses = false;
	var $autoRender = false;
	
	public function beforeFilter() {
	}
	
	public function beforeRender() {
	}
	
	public function index($type, $id, $size, $filename) {
		App::uses('MediaPath', 'Media.Vendor');
		$this->PHMedia = new MediaPath();
		
		$fname = $this->PHMedia->getFileName($type, $id, $size, $filename);
		$aFName = $this->PHMedia->getFileInfo($filename);
		
		if (file_exists($fname)) {
			header('Content-type: image/'.$aFName['ext']);
			echo file_get_contents($fname);
			exit;
		}
		
		App::uses('Image', 'Media.Vendor');
		$image = new Image();
		
		$aSize = $this->PHMedia->getSizeInfo($size);
		
		$image->load($this->PHMedia->getFileName($type, $id, null, $aFName['fname'].'.'.$aFName['orig_ext']));
		if ($aSize) {
			$method = $this->PHMedia->getResizeMethod($size);
			$image->{$method}($aSize['w'], $aSize['h']);
		}
		if ($aFName['ext'] == 'jpg') {
			$image->outputJpg($fname);
			$image->outputJpg();
		} elseif ($aFName['ext'] == 'png') {
			$image->outputPng($fname);
			$image->outputPng();
		} else {
			$image->outputGif($fname);
			$image->outputGif();
		}
		exit;
	}
	
}
