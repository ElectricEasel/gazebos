<?php
/**
 * @version     1.0.0
 * @package     com_gazebos
 * @copyright   Copyright (C) 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Don Gilbert <don@electriceasel.com> - http://www.electriceasel.com
 */
defined('_JEXEC') or die;

abstract class GazebosHelper extends EEHelper
{
	protected static $aliases = array();

	protected static $productTypes = array(
		1 => 'Gazebo',
		2 => 'Pergola',
		3 => 'Pavilion',
		4 => 'Three Season'
	);

	protected static $tableMap = array(
		'material' => '#__gazebos_materials',
		'product' => '#__gazebos_products',
		'shape' => '#__gazebos_shapes',
		'style' => '#__gazebos_styles',
		'size' => '#__gazebos_sizes',
		'type' => '#__gazebos_types'
	);

	protected static $productTypeMenuMap = array();

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

		if ($view === 'shape')
		{
			$material_id = JFactory::getApplication()->input->getInt('material_id');
			$q = "SELECT a.id FROM {$table} AS a LEFT JOIN #__gazebos_materials ON a.type_id = b.type_id WHERE a.alias = {$alias} AND b.id = {$material_id}";
		}

		$row = $db->setQuery("SELECT id FROM {$table} WHERE alias = {$alias}")->loadObject();

		return $row->id;
	}

	/**
	 * Get the menu item id for the given type.
	 * 
	 */
	public static function getProductTypeMenuItem($type)
	{
		if (!isset(self::$productTypeMenuMap[$type]))
		{
			$db = JFactory::getDbo();

			$results = $db->setQuery('SELECT id, link FROM #__menu WHERE link LIKE "%option=com_gazebos&view=type%"')->loadObjectList();

			if ($results === null) return false;

			foreach ($results as $row)
			{
				$productId = substr($row->link, (strpos($row->link, '&id=') + 4));

				if (!is_numeric($productId)) continue;

				self::$productTypeMenuMap[$productId] = $row->id;
			}
		}

		return self::$productTypeMenuMap[$type];
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
		return self::$tableMap[$view];
	}

	/**
	 * Sugar for EEComponentHelper
	 *
	 * @param   string  $name     The named parameter to retrieve.
	 * @param   string  $default  Return this if param is not found.
	 *
	 * @return  mixed  Param if found, default otherwise.
	 */
	public static function getParam($name, $default = null)
	{
		return EEComponentHelper::getParam('com_gazebos', $name, $default);
	}

	/**
	 * Get the title of the currently viewed product type.
	 * If an id is passed, use that instead.
	 *
	 * @param   integer  $id  ID of the product type to retrieve.
	 *
	 * @return  string  Product type title.
	 *
	 */
	public static function getProductTypeTitle($id = null)
	{
		if (is_null($id))
		{
			$id = self::getProductTypeId();
		}

		if (!isset(self::$productTypes[$id]))
		{
			$result = JFactory::getDbo()->setQuery('SELECT title FROM #__gazebos_producttypes WHERE id = ' . $id)->loadObject();
			self::$productTypes[$id] = $result->title;
		}

		return self::$productTypes[$id];
	}

	/**
	 * Get the id of the currently viewed product type.
	 *
	 * @return  integer  Product type id.
	 *
	 */
	public static function getProductTypeId()
	{
		$input = JFactory::getApplication()->input;

		switch ($input->getCmd('view'))
		{
			case 'product':
				$model = new GazebosModelProduct;
				$id = $model->getItem()->type_id;
				break;
			case 'producttype':
				$id = $input->getInt('id');
				break;
			default:
				return false;
				break;
		}

		return $id;
	}

	/**
	 * Load a module position.
	 *
	 * @param   string  $pos  The position to load.
	 *
	 * @return  HTML for the loaded module position.
	 *
	 */
	public static function loadPosition($pos = null)
	{
		if ($pos === null) return false;

		if (JFactory::getDocument()->countModules($pos))
		{
			return JHtml::_('content.prepare', '{loadposition ' . $pos . '}');
		}
	}
}
