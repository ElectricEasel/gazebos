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

$tip = empty($displayData->tip) ? '' : ' title="' . htmlspecialchars($displayData->label . '::' . $displayData->tip, ENT_COMPAT, 'UTF-8') . '"';
?>

<div class="control-group">
	<?php if (empty($displayData->hidden)): ?>
		<div<?php echo $tip; ?> class="control-label<?php echo empty($displayData->tip) ? '' : ' hasTip'?>">
			<label for="<?php echo $displayData->name; ?>">
			<?php echo $displayData->label; ?>
			</label>
		</div>
	<?php endif; ?>
	<div class="controls">
		<?php echo $displayData->input; ?>
	</div>
</div>