<?php
/**
 * @package		Gazebos.Modules
 * @subpackage	com_gazebos
 * @copyright	Copyright (C) 2012 Electric Easel, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

JLoader::import('components.com_gazebos.helpers.gazebos', JPATH_SITE);

/**
 * @package		Gazebos.Modules
 * @subpackage	mod_product_search
 * @since		1.00
 */
abstract class modProductSearchHelper
{
	/**
	 * Holds the options as fetched from the DB
	 */
	protected static $optionCache = array();

	/**
	 * Get the text for the filter option
	 *
	 * @param   integer  $id    The id of the option to retrieve
	 * @param   string   $type  The filter type
	 *
	 * @return  string  Name of specified option
	 */
	public static function getFilterName($id, $type)
	{
		if (!isset(self::$optionCache[$type]))
		{
			self::$optionCache[$type] = self::getOptions($type);
		}

		return self::$optionCache[$type][$id]->text;
	}

	/**
	 * Get the filter types  and the options for the module
	 *
	 * @return  string
	 *
	 */
	public static function getFilters()
	{
		$html = array();
		$filters = array('material', 'shape', 'style');

		foreach ($filters as $type)
		{
			$label = '<h5>' . GazebosHelper::getProductTypeTitle() . ' By ' . ucfirst($type) . '</h5>';
			$select = self::getFilter($type);

			$html[] = $label . $select;
		}

		return implode($html);
	}

	public static function getFilter($type)
	{
		$html = array();
		$app = JFactory::getApplication();
		$options = self::getOptions($type);

		$html[] = '<ul class="filter-menu">';
		foreach ($options as $i => $option)
		{
			$checked = in_array((string) $option->value, (array) $app->getUserState('filter.' . $type)) ? ' checked="checked"' : '';

			$html[] = '<li>';
			$html[] = '<input type="checkbox" id="filter_' . $type . $option->value . '" name="filter_' . $type . '[]"' . ' value="';
			$html[] = $option->value . '"' . $checked . '/>';
			$html[] = '<label for="filter_' . $type . $option->value . '">' . JText::_($option->text) . '</label>';
			$html[] = '</li>';
		}

		$html[] = '</ul>';
		$html[] = '<input type="hidden" name="filter_' . $type . '[]" value="0" checked="checked" />';

		return implode($html);
	}

	public static function getOptions($type)
	{
		if (!isset(self::$optionCache[$type]))
		{
			$db = JFactory::getDbo();
			$table = $db->qn(GazebosHelper::getTable($type));
	
			$q =
				'SELECT a.id, a.title ' .//, COUNT(b.id) AS count ' .
				"FROM {$table} AS a ";// .
	//			"LEFT JOIN #__gazebos_products AS b ON b.{$type}_id = a.id " .
	//			'WHERE a.state = 1 ' .
	//			'AND (b.id IS NULL OR b.id != NULL)';
	
			$results = $db->setQuery($q)->loadObjectList('id');
	
			if ($results === null) return false;
			
			$options = array();
	
			foreach ($results as $row)
			{
				$text = $row->title;// . ' (' . $row->count . ')';
				$options[$row->id] = JHtml::_('select.option', $row->id, $text);
			}
	
			self::$optionCache[$type] = $options;
		}

		return self::$optionCache[$type];
	}
}
