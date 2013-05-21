<?php
/**
 * sh404SEF - SEO extension for Joomla!
 *
 * @author      Yannick Gaultier
 * @copyright   (c) Yannick Gaultier 2012
 * @package     sh404sef
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     4.1.0.1559
 * @date		2013-04-25
 */

defined('JPATH_BASE') or die;

?>

<div class="container-fluid">
<?php

foreach ($this->form->getFieldset($this->currentFieldset->name) as $field) :
?>
	<div class="control-group">
	<div class="shrules">
	<div class="controls">
		<?php
		echo $field->input;
		$element = $field->element;
		if (!empty($element['additionaltext'])): ?>
			<span class = "sh404sef-additionaltext"><?php echo (string) $element['additionaltext']; ?></span>
		<?php
		endif;?>
	</div>
	</div>
	</div>
<?php
endforeach;
?>
</div>
