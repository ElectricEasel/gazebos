<?php
/**
 * @package		Joomla.Site
 * @subpackage	Templates.beez_20
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

/**
 * beezDivision chrome.
 *
 * @since	1.6
 */
function modChrome_basic($module, &$params, &$attribs)
{
	$headerLevel = isset($attribs['headerLevel']) ? (int) $attribs['headerLevel'] : 4;
	if (!empty ($module->content)) { ?>
<div class="module <?php echo htmlspecialchars($params->get('moduleclass_sfx')); ?>">
<?php if ($module->showtitle) { ?> <h<?php echo $headerLevel; ?>><?php echo $module->title; ?></h<?php echo $headerLevel; ?>>
<?php }; ?> <?php echo $module->content; ?></div>
<?php };
}