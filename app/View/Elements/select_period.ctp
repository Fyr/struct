<?
/**
 * @param $fieldName
 */
/*
	if (!isset($options['name'])) {
		$fieldName = 'period';
	}
*/
	if (!isset($options['options'])) {
		$options['options'] = array();
		for($i = 2; $i <= 5; $i++) {
			$options['options'][$i] = $i.' '.__('years');
		}
	}
	
	if (!isset($options['label'])) {
		$options['label'] = false;
	}
	
	if (!isset($options['class'])) {
		$options['class'] = 'formstyler';
	}
	echo $this->Form->input($fieldName, $options);
?>