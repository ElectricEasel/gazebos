<?php
/**
 * @version     1.0.0
 * @package     com_gazebos
 * @copyright   Copyright (C) 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Don Gilbert <don@electriceasel.com> - http://www.electriceasel.com
 */

// No direct access
defined('_JEXEC') or die;

/**
 * Gazebos helper.
 */
class GazebosHelper extends EEHelper
{
	protected $component = 'com_gazebos';

	/**
	 * Configure the Linkbar.
	 */
	public static function addSubmenu($vName = '')
	{
		JSubMenuHelper::addEntry(
			JText::_('COM_GAZEBOS_TITLE_PRODUCTTYPES'),
			'index.php?option=com_gazebos&view=producttypes',
			$vName == 'producttypes'
		);
		JSubMenuHelper::addEntry(
			JText::_('COM_GAZEBOS_TITLE_PRODUCTS'),
			'index.php?option=com_gazebos&view=products',
			$vName == 'products'
		);
		JSubMenuHelper::addEntry(
			JText::_('COM_GAZEBOS_TITLE_PRODUCTSTYLES'),
			'index.php?option=com_gazebos&view=productstyles',
			$vName == 'productstyles'
		);
		JSubMenuHelper::addEntry(
			JText::_('COM_GAZEBOS_TITLE_PRODUCTSHAPES'),
			'index.php?option=com_gazebos&view=productshapes',
			$vName == 'productshapes'
		);
		JSubMenuHelper::addEntry(
			JText::_('COM_GAZEBOS_TITLE_PRODUCTMATERIALS'),
			'index.php?option=com_gazebos&view=productmaterials',
			$vName == 'productmaterials'
		);
		JSubMenuHelper::addEntry(
			JText::_('COM_GAZEBOS_TITLE_OPTIONS'),
			'index.php?option=com_gazebos&view=options',
			$vName == 'options'
		);
		JSubMenuHelper::addEntry(
			JText::_('COM_GAZEBOS_TITLE_OPTIONCATEGORIES'),
			'index.php?option=com_gazebos&view=optioncategories',
			$vName == 'optioncategories'
		);

	}
}
