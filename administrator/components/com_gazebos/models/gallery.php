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
 * Trailers model.
 */
class GazebosModelGallery extends JModelAdmin
{
	/**
	 * @var  string The prefix to use with controller messages.
	 * @since 1.6
	 */
	protected $text_prefix = 'COM_GAZEBOS';

	/**
	 * Returns a reference to the a Table object, always creating it.
	 *
	 * @param type The table type to instantiate
	 * @param string A prefix for the table class name. Optional.
	 * @param array Configuration array for model. Optional.
	 * @return JTable A database object
	 * @since 1.6
	 */
	public function getTable($type = 'Gallery', $prefix = 'GazebosTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
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
		return $this->loadForm('com_gazebos.gallery', 'gallery', array('control' => 'jform', 'load_data' => $loadData));
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
		$data = $app->getUserState('com_gazebos.edit.gallery.data', array());

		if (empty($data))
		{
			$data = $this->getItem();
		}

		$product_id = $app->input->getInt('product_id');

		if ($product_id)
		{
			$data->product_id = $product_id;
		}

		return $data;
	}

	/**
	 * Prepare and sanitise the table prior to saving.
	 *
	 * @since 1.6
	 */
	protected function prepareTable(&$table)
	{
		jimport('joomla.filter.output');

		if (empty($table->id))
		{
			// Set ordering to the last item if not set
			if (@$table->ordering === '')
			{
				$db = JFactory::getDbo();
				$db->setQuery('SELECT MAX(ordering) FROM #__gazebos_gallery');
				$max = $db->loadResult();
				$table->ordering = $max+1;
			}
		}
	}
}
