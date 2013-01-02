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

	protected static $filters = array('material', 'shape', 'style', 'price');

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

		foreach (self::$filters as $type)
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

		$context = 'product' . JFactory::getApplication()->input->getInt('id');

		$html[] = '<ul class="filter-menu">';
		foreach ($options as $i => $option)
		{
			$checked = in_array((string) $option->value, (array) $app->getUserState($context . 'filter.' . $type)) ? ' checked="checked"' : '';

			$html[] = '<li>';
			$html[] = '<input type="checkbox" id="filter_' . $type . $option->value . '" name="filter_' . $type . '[]"' . ' value="';
			$html[] = $option->value . '"' . $checked . '/>';
			$html[] = '<label for="filter_' . $type . $option->value . '">' . JText::_($option->text) . '</label>';
			$html[] = '</li>';
		}

		$html[] = '</ul>';
		// Add a hidden field with same name with 0 value
		$html[] = '<input type="hidden" name="filter_' . $type . '[]" value="0" />';

		return implode($html);
	}

	public static function getOptions($type)
	{
		if (!isset(self::$optionCache[$type]))
		{
			switch ($type)
			{
				case 'price':
					$results = self::getAvailablePrices();
					break;
				default:
					$results = self::getAvailableOptions($type);
					break;
			}

			if ($results === null) return false;
			
			$options = array();
	
			foreach ($results as $row)
			{
				$text = htmlspecialchars($row->title);// . ' (' . $row->count . ')';
				$options[$row->id] = JHtml::_('select.option', $row->id, $text);
			}
	
			self::$optionCache[$type] = $options;
		}

		return self::$optionCache[$type];
	}

	public static function getAvailablePrices()
	{
		return array(
			(object) array('title' => '$4,000 & under', 'id' => '4000'),
			(object) array('title' => '$8,000 & under', 'id' => '8000'),
			(object) array('title' => '$10,000 & under', 'id' => '10000'),
			(object) array('title' => '$15,000 & under', 'id' => '15000'),
			(object) array('title' => '$15,001 & over', 'id' => '15001')
		);
	}

	public static function getAvailableOptions($type)
	{
		$db = JFactory::getDbo();
		$id = JFactory::getApplication()->input->getInt('id');
		$table = $db->qn(GazebosHelper::getTable($type));

		$q =
			'SELECT a.id, a.title ' .
			"FROM {$table} AS a " . 
			'WHERE a.type_id = ' . $id;

		return $db->setQuery($q)->loadObjectList('id');
	}
}
