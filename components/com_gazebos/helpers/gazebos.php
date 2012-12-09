<?php
/**
 * @version     1.0.0
 * @package     com_gazebos
 * @copyright   Copyright (C) 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Don Gilbert <don@electriceasel.com> - http://www.electriceasel.com
 */

defined('_JEXEC') or die;

abstract class GazebosHelper
{
	protected static $aliases = array();

	/**
	 * Get the alias for the specifed id
	 * associated with the given view.
	 *
	 * @param   integer  $id    The id for which to find the alias.
	 * @param   string   $view  The view this id is associated with.
	 *
	 * @return  string  The alias that matched the given params.
	 *
	 */
	public static function getAliasFromId($id, $view)
	{
		$db = JFactory::getDbo();
		$table = $db->qn(self::getTable($view));

		isset(self::$aliases[$table]) or self::$aliases[$table] = array();
		
		if (!isset(self::$aliases[$table][$id]))
		{
			$row = $db->setQuery("SELECT alias FROM {$table} WHERE id = " . (int) $id)->loadObject();
			self::$aliases[$table][$id] = $row->alias;
		}

		return self::$aliases[$table][$id];
	}

	/**
	 * Get the alias for the specifed id
	 * associated with the given view.
	 *
	 * @param   integer  $alias  The alias for which to find the id.
	 * @param   string   $view   The view this id is associated with.
	 *
	 * @return  string  The id that matched the given params.
	 *
	 */
	public static function getIdFromAlias($alias, $view)
	{
		$db = JFactory::getDbo();
		$alias = $db->q($db->escape(str_replace(':', '-', $alias)));
		$table = $db->qn(self::getTable($view));

		$row = $db->setQuery("SELECT id FROM {$table} WHERE alias = {$alias}")->loadObject();

		return $row->id;
	}

	/**
	 * Get the table for specified view.
	 *
	 * @param   string  $view  The view for which to find the table.
	 *
	 * @return  string  The specified table.
	 *
	 */
	public static function getTable($view)
	{
		$map = array(
			'producttypes' => '#__gazebos_types',
			'producttype' => '#__gazebos_types',
			'product' => '#__gazebos_products',
			'style' => '#__gazebos_styles',
			'type' => '#__gazebos_types',
			'material' => '#__gazebos_materials',
			'shape' => '#__gazebos_shapes',
		);

		return $map[$view];
	}
}

