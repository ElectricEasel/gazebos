<?php
/**
 * @version     1.0.0
 * @package     com_gazebos
 * @copyright   Copyright (C) 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Don Gilbert <don@electriceasel.com> - http://www.electriceasel.com
 */

defined('JPATH_BASE') or die;

jimport('joomla.html.html');
jimport('joomla.form.formfield');

/**
 * Supports an HTML select list of categories
 */
class JFormFieldProductOptions extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'productoptions';

	/**
	 * Method to get the field input markup.
	 *
	 * @return	string	The field input markup.
	 * @since	1.6
	 */
	protected function getInput()
	{
		$options = $this->getOptions();
		$config = array();

		if ($this->multiple)
		{
			$config['multiple'] = $this->multiple;
		}

		return JHtml::_('select.groupedlist', $options, $this->name, $config);
	}

	protected function getOptions()
	{
		$db = JFactory::getDbo();
		$q  = $db->getQuery(true);

		$q
			->select('a.id AS option_id, a.title AS option_title, b.id AS category_id, b.title AS category_title')
			->from('FROM #__gazebos_options AS a')
			->leftJoin('LEFT JOIN #__gazebos_option_categories AS b ON a.option_category_id = b.id');

		$results = $db->setQuery($q)->loadObjectList();

		if (is_null($results)) return false;

		$options = array();
		foreach ($results as $row)
		{
			if (!isset($options[$row->category_id]))
			{
				$options[$row->category_id] = array(
					'text' => $row->category_title,
					'items' => array()
				);
			}

			$options[$row->category_id]['items'][] = array('value' => $row->option_id, 'text' => $row->option_title);
		}

		return $options;
	}
}
