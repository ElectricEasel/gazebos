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

	public static function getOptions($type)
	{
		$db = JFactory::getDbo();
		$table = $db->qn(GazebosHelper::getTable($type));

		$q =
			'SELECT a.id, a.title ' .//, COUNT(b.id) AS count ' .
			"FROM {$table} AS a ";// .
//			"LEFT JOIN #__gazebos_products AS b ON b.{$type}_id = a.id " .
//			'WHERE a.state = 1 ' .
//			'AND (b.id IS NULL OR b.id != NULL)';

		$results = $db->setQuery($q)->loadObjectList();

		if ($results === null) return false;
		
		$options = array();

		foreach ($results as $row)
		{
			$text = $row->title;// . ' (' . $row->count . ')';
			$options[] = JHtml::_('select.option', $row->id, $text);
		}

		return $options;
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
			$html[] = '<input type="checkbox" id="filter_' . $type . $i . '" name="filter_' . $type . '[]"' . ' value="';
			$html[] = htmlspecialchars($option->value, ENT_COMPAT, 'UTF-8') . '"' . $checked . '/>';
			$html[] = '<label for="filter_' . $type . $i . '">' . JText::_($option->text) . '</label>';
			$html[] = '</li>';
		}

		$html[] = '</ul>';
		$html[] = '<input type="hidden" name="filter_' . $type . '[]" value="0" checked="checked" />';

		return implode($html);
	}
}
