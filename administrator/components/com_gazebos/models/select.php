<?php
/**
 * @version     1.0.0
 * @package     com_gazebos
 * @copyright   Copyright (C) 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Don Gilbert <don@electriceasel.com> - http://www.electriceasel.com
 */

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.modeladmin');

/**
 * Gazebos model.
 */
class GazebosModelSelect extends JModelAdmin
{
	/**
	 * @var		string	The prefix to use with controller messages.
	 * @since	1.6
	 */
	protected $text_prefix = 'COM_GAZEBOS';

	public function getItem($pk = null)
	{
		$db = $this->getDbo();

		$types = $db->setQuery('SELECT * FROM #__gazebos_types WHERE state = 1')->loadObjectList();

		if ($types !== null)
		{
			foreach ($types as $type)
			{
				$type->lines = $db->setQuery('SELECT * FROM #__gazebos_lines WHERE state = 1 AND type_id = ' . (int) $type->id)->loadObjectList();
			}
		}

		return $types;
	}

	public function getForm($data = array(), $loadData = true)
	{
		return null;
	}

	public function getTable($type = 'Option', $prefix = 'GazebosTable', $config = array())
	{
		return null;
	}

	public function getState($property = null, $default = null)
	{
		return null;
	}

}
