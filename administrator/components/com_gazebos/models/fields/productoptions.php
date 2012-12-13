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
		$registry = new JRegistry($this->value);
		$selected = $registry->toArray();

		$options = $this->getOptions();
		$attribs = array();
		$html = array();

		if ($this->multiple)
		{
			$attribs['multiple'] = 'multiple';
		}

		$html[] = '<p>To apply options, click into the field and select from the options in the dropdown. To remove an option, click the x next to the option text.</p>';

		foreach ($options as $id => $keys)
		{
			$attribs['data-placeholder'] = "Select {$keys['text']} Options";
			$html[] = '<div class="option_container" style="margin-bottom:20px;">';
			$html[] = '<label>' . $keys['text'] . '</label>';
			$html[] = JHtml::_('select.genericlist', $keys['items'], $this->getName($id), $attribs, 'value', 'text', $selected[$id]);
			$html[] = '<input type="hidden" name="' . $this->getName($id) . '" value="0" />';
			$html[] = '</div>';
		}

		return implode($html);
	}

	protected function getOptions()
	{
		$db = JFactory::getDbo();
		$q  = $db->getQuery(true);

		$q
			->select('a.id AS option_id, a.title AS option_title, b.id AS category_id, b.title AS category_title')
			->from('#__gazebos_options AS a')
			->leftJoin('#__gazebos_option_categories AS b ON a.option_category_id = b.id');

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

	/**
	 * Method to get the name used for the field input tag.
	 * The main difference between this and the parent method is that
	 * this method can set the group and uses the default $fieldname
	 * property. Since we are pulling in multiple items and groups
	 * from other tables, it's how it had to be done.
	 *
	 * @param   string  $fieldName  The field element name.
	 *
	 * @return  string  The name to be used for the field input tag.
	 *
	 * @see     parent::getName
	 * @since   11.1
	 */
	protected function getName($group, $fieldName = null)
	{
		$this->group = $group;

		if (is_null($fieldName))
		{
			$fieldName = $this->fieldname;
		}

		// Initialise variables.
		$name = '';

		// If there is a form control set for the attached form add it first.
		if ($this->formControl)
		{
			$name .= $this->formControl;
		}

		// If we already have a name segment add the field name as another level.
		if ($name)
		{
			$name .= '[' . $fieldName . ']';
		}
		else
		{
			$name .= $fieldName;
		}

		// If the field is in a group add the group control to the field name.
		if ($this->group)
		{
			// If we already have a name segment add the group control as another level.
			$groups = explode('.', $this->group);
			if ($name)
			{
				foreach ($groups as $group)
				{
					$name .= '[' . $group . ']';
				}
			}
			else
			{
				$name .= array_shift($groups);
				foreach ($groups as $group)
				{
					$name .= '[' . $group . ']';
				}
			}
		}

		// If the field should support multiple values add the final array segment.
		if ($this->multiple)
		{
			$name .= '[]';
		}

		return $name;
	}
}
