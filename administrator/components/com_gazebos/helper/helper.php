<?php
/**
 * @version     1.0.0
 * @package     com_gazebos
 * @copyright   Copyright (C) 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Don Gilbert <don@electriceasel.com> - http://www.electriceasel.com
 */
defined('_JEXEC') or die;

class GazebosHelper extends EEHelper
{
	protected static $component = 'com_gazebos';

	protected static $productTypes;

	/**
	 * Configure the Linkbar.
	 */
	public static function addSubmenu($vName = '')
	{
		JSubMenuHelper::addEntry(
			JText::_('COM_GAZEBOS_TITLE_PRODUCTS'),
			'index.php?option=com_gazebos&view=products',
			$vName == 'products'
		);
		JSubMenuHelper::addEntry(
			JText::_('COM_GAZEBOS_TITLE_TYPES'),
			'index.php?option=com_gazebos&view=types',
			$vName == 'types'
		);
		JSubMenuHelper::addEntry(
			JText::_('COM_GAZEBOS_TITLE_STYLES'),
			'index.php?option=com_gazebos&view=styles',
			$vName == 'styles'
		);
		JSubMenuHelper::addEntry(
			JText::_('COM_GAZEBOS_TITLE_SHAPES'),
			'index.php?option=com_gazebos&view=shapes',
			$vName == 'shapes'
		);
		JSubMenuHelper::addEntry(
			JText::_('COM_GAZEBOS_TITLE_MATERIALS'),
			'index.php?option=com_gazebos&view=materials',
			$vName == 'materials'
		);
		JSubMenuHelper::addEntry(
			JText::_('COM_GAZEBOS_TITLE_OPTIONCATEGORIES'),
			'index.php?option=com_gazebos&view=optioncategories',
			$vName == 'optioncategories'
		);
		JSubMenuHelper::addEntry(
			JText::_('COM_GAZEBOS_TITLE_OPTIONS'),
			'index.php?option=com_gazebos&view=options',
			$vName == 'options'
		);
	}

}
