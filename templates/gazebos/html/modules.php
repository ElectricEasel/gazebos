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
function modChrome_sidebar($module, &$params, &$attribs)
{
	$pathway = JFactory::getApplication()->getPathway();
	$list = $pathway->getPathWay();
	$count = count($list);
	
	if ($count !== 0)
	{
		$parentmenu = $list[0]->name;
	}
	else
	{
		$parentmenu = 'Menu';
	}

	if($module->content)
	{ ?>
	<div class="module<?php echo $params->get('moduleclass_sfx'); ?>">
		<div class="menu-wrap">
			<?php if($module->showtitle) : ?>
			<h4><?php echo $parentmenu ?></h4>
			<?php endif; ?>
			<div class="module-content">
				<?php echo $module->content; ?>
			</div>
		</div>
	</div>

<?php }

}


function modChrome_basic( $module, &$params, &$attribs )
{ ?>
	<div class="module<?php echo $params->get('moduleclass_sfx'); ?>">
		<div class="menu-wrap">
			<?php if($module->showtitle) : ?>
			<h4><?php echo $module->title; ?></h4>
			<?php endif; ?>
			<div class="module-content">
				<?php echo $module->content; ?>
			</div>
		</div>
	</div>

<?php }

function modChrome_blank($module, &$params, &$attribs)
{
	return $module->content;
}