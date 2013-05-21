<?php
/**
 * @version     1.0.0
 * @package     com_gazebos
 * @copyright   Copyright (C) 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Don Gilbert <don@electriceasel.com> - http://www.electriceasel.com
 */
defined('_JEXEC') or die;

class GazebosModelSize extends EEModelAdmin
{
	/**
	 * @var  string The prefix to use with controller messages.
	 * @since 1.6
	 */
	protected $text_prefix = 'COM_GAZEBOS';

	/**
	 * Get the size items for this product id.
	 *
	 * @return  array  List of product sizes
	 *
	 */
	public function getItems()
	{
		$app = JFactory::getApplication();
		$pid = $app->input->get->getInt('product_id');
		$db  = $this->getDbo();
		$q   = $db->getQuery(true);

		$q
			->select('a.*')
			->from('#__gazebos_sizes AS a')
			->where('a.product_id = ' . $pid)
			->order('a.size ASC');

		return (array) $db->setQuery($q)->loadObjectList();
	}

	/**
	 * Returns a reference to the a Table object, always creating it.
	 *
	 * @param type The table type to instantiate
	 * @param string A prefix for the table class name. Optional.
	 * @param array Configuration array for model. Optional.
	 * @return JTable A database object
	 * @since 1.6
	 */
	public function getTable($type = '', $prefix = '', $config = array())
	{
		return new GazebosTableSize;
	}

	/**
	 * Method to get the record form.
	 *
	 * @param array $data  An optional array of data for the form to interogate.
	 * @param boolean $loadData True if the form is to load its own data (default case), false if not.
	 * @return JForm A JForm object on success, false on failure
	 * @since 1.6
	 */
	public function getForm($data = array(), $loadData = true)
	{
		return $this->loadForm('com_gazebos.size', 'size', array('control' => 'jform', 'load_data' => $loadData));
	}

	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return mixed The data for the form.
	 * @since 1.6
	 */
	protected function loadFormData()
	{
		$app = JFactory::getApplication();

		// Check the session for previously entered form data.
		$data = $app->getUserState('com_gazebos.edit.size.data', array());

		if (empty($data))
		{
			$data = $this->getItem();
		}

		if ($product_id = $app->input->getInt('product_id'))
		{
			$data->product_id = $product_id;
		}

		return $data;
	}

	/**
	 * Method to get a single record.
	 *
	 * @param integer The id of the primary key.
	 *
	 * @return mixed Object on success, false on failure.
	 * @since 1.6
	 */
	public function getItem($pk = null)
	{
		if ($item = parent::getItem($pk))
		{//var_dump($item);die;
			//Do any procesing on fields here if needed
		}

		return $item;
	}

	/**
	 * Prepare and sanitise the table prior to saving.
	 *
	 * @since 1.6
	 */
	protected function prepareTable(&$table)
	{
		if (empty($table->id))
		{
			// Set ordering to the last item if not set
			if (@$table->ordering === '')
			{
				$table->ordering = $this->getDbo()->setQuery('SELECT (MAX(ordering) + 1) FROM #__gazebos_sizes')->loadResult();
			}
		}
	}
}
