<?php
/**
 * @version     1.0.0
 * @package     com_gazebos
 * @copyright   Copyright (C) 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Don Gilbert <don@electriceasel.com> - http://www.electriceasel.com
 */
defined('_JEXEC') or die;

class GazebosModelSelect extends EEModelAdmin
{
	/**
	 * @var		string	The prefix to use with controller messages.
	 * @since	1.6
	 */
	protected $text_prefix = 'COM_GAZEBOS';

	public function getItem($pk = null)
	{
		return (array) $this->getDbo()->setQuery('SELECT * FROM #__gazebos_types WHERE state = 1')->loadObjectList();
	}

	public function getForm($data = array(), $loadData = true)
	{
		return null;
	}

	public function getTable($type = '', $prefix = '', $config = array())
	{
		return null;
	}

	public function getState($property = null, $default = null)
	{
		return null;
	}

}
