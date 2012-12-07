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
	public static function getActiveSearch()
	{
		
	}

	public static function getFilters()
	{
		$html = array();
		$filters = array('material', 'shape', 'style', 'price');

		foreach ($filters as $type)
		{
			$label = ucfirst($type);
			$select = self::getFilter($type);

			$html[] = $label . $select;
		}

		return implode($html);
	}

	public static function getOptions($type)
	{
		$db = JFactory::getDbo();
		$table = $db->qn(GazebosHelper::getTable($type));

		$q = "SELECT id, title FROM {$table} WHERE state = 1";
		$results = $db->setQuery($q)->loadObjectList();

		if ($results === null) return false;
		
		$options = array();

		foreach ($results as $row)
		{
			$options[] = JHtml::_('select.option', $row->id, $row->title);
		}

		return $options;
	}

	public static function getFilter($type)
	{
		$html = array();
		$app = JFactory::getApplication();
		$options = self::getOptions($type);

		foreach ($options as $i => $option)
		{
			// Initialize some option attributes.
			$checked = (in_array((string) $option->value, (array) $app->getUserState('filter.' . $type)) ? ' checked="checked"' : '');
			$class = !empty($option->class) ? ' class="' . $option->class . '"' : '';
			$disabled = !empty($option->disable) ? ' disabled="disabled"' : '';

			// Initialize some JavaScript option attributes.
			$onclick = ' onclick="this.form.submit();"';//!empty($option->onclick) ? ' onclick="' . $option->onclick . '"' : '';

			$html[] = '<li>';
			$html[] = '<input type="checkbox" id="filter_' . $type . $i . '" name="filter_' . $type . '[]"' . ' value="';
			$html[] = htmlspecialchars($option->value, ENT_COMPAT, 'UTF-8') . '"' . $checked . $class . $onclick . $disabled . '/>';
			$html[] = '<label for="filter_' . $type . $i . '"' . $class . '>' . JText::_($option->text) . '</label>';
			$html[] = '</li>';
		}

		$html[] = '<input type="hidden" name="filter_' . $type . '[]" value="0" />';

		return implode($html);
	}
}
