<?
	if (floatval($price)) {
		echo $this->element('sum', array('sum' => $price)).'/m';
	}
