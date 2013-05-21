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
$cycler = ShlSystem_Cycle::getInstance('bycomponent', $step = 7, 0);
foreach ($this->form->getFieldset($this->currentFieldset->name) as $field) :
	$isNewLine = $cycler->every();
	if ($isNewLine) :
	?>
		<div class="control-group">
		<?php if (!$field->hidden) : ?>
			<div class="shlegend-label">
				<div class="control-label">
					<?php echo $field->label; ?>
				</div>
			</div>
			<div class="controls">
		<?php
		endif;
	endif;
	if (!$isNewLine) :
		// @TODO: probably a bug in jQuery tooltip js: can't have tips on each select drop downs,
		// they stay visible when one leaves the drop down
		$o = '';
		$o .= $field->input;
		$o .= '<div rel="tooltip" class="shinfo-icon-wrapper" title="' . JText::_( $field->description) . '"><i class="icon-question-sign"></div>';
		$o .= '</i>';
		echo $o;
		$element = $field->element;
		if (!empty($element['additionaltext'])) :
		?><span class = "sh404sef-additionaltext">'<?php echo (string) $element['additionaltext']; ?></span>
		<?php
		endif;
	endif;
	if ($isNewLine) :
		?>
			</div>
		</div>
	<?php
	endif;
endforeach;
?>
</div>
