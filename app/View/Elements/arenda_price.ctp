<?
	if (floatval($price)) {
		echo $this->element('sum', array('sum' => $price)).'/'.__('month');
	} else {
		echo $PU_.'0.2'.$_PU.'/'.__('Page');
	}
