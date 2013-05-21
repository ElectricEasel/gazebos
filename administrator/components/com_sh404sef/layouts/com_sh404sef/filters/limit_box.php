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

/**
 * Displays a drop-down select list with values for numer of items per page
 */
?>
<div class="btn-group pull-right hidden-phone">
	<label for="limit" class="element-invisible"><?php echo JText::_('JFIELD_PLG_SEARCH_SEARCHLIMIT_DESC'); ?></label>
	<?php echo $displayData->getLimitBox(); ?>
</div>