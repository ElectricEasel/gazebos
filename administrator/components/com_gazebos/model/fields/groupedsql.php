<?php defined('JPATH_PLATFORM') or die;

JFormHelper::loadFieldClass('groupedlist');

class JFormFieldGroupedSql extends JFormFieldGroupedList
{	
	/**
	 * The form field type.
	 *
	 * @var    string
	 *
	 * @since  11.1
	 */
	protected $type = 'GroupedSql';

	/**
	 * Method to get the field input markup.
	 *
	 * @return  string  The field input markup.
	 *
	 * @since   11.1
	 */
	protected function getGroups()
	{
		$db = JFactory::getDbo();
		$options = array();

		$q = (string) $this->element['query'];
		$key_field = (string) $this->element['key_field'];
		$value_field = (string) $this->element['value_field'];
		$group_field = (string) $this->element['group_field'];

		$rows = (array) $db->setQuery($q)->loadObjectList();
		
		foreach ($rows as $r)
		{
			// If the group field is empty, bail.
			if (!isset($r->$group_field))
			{
				continue;
			}

			if (!isset($options[$r->$group_field]))
			{
				$options[$r->$group_field] = array();
			}

			$options[$r->$group_field][] = JHtml::_('select.option', $r->$key_field, $r->$value_field);
		}

		return $options;
	}
}
