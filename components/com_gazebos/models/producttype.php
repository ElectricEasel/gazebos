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

jimport('joomla.application.component.model');
jimport('joomla.event.dispatcher');

/**
 * Gazebos model.
 */
class GazebosModelProductType extends JModel
{
	var $_item = null;

	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @since 1.6
	 */
	protected function populateState()
	{
		$app = JFactory::getApplication();

		// Get the current product type setting from the menu item request
		$this->setState('producttype.id', $app->input->getInt('producttype'));

		$this->setState('params', $app->getParams());
	}


	/**
	 * Method to get an ojbect.
	 *
	 * @param integer The id of the object to get.
	 *
	 * @return mixed Object on success, false on failure.
	 */
	public function &getData($id = null)
	{
		if ($this->_item === null)
		{
			$this->_item = false;

			if (empty($id))
			{
				$id = $this->getState('producttype.id');
			}

			// Get a level row instance.
			$table = $this->getTable();

			// Attempt to load the row.
			if ($table->load($id))
			{
				// Check published state.
				if ($published = $this->getState('filter.published'))
				{
					if ($table->state != $published)
					{
						return $this->_item;
					}
				}

				// Convert the JTable to a clean JObject.
				$properties = $table->getProperties(1);
				$this->_item = JArrayHelper::toObject($properties, 'JObject');
				$this->_item->products = $this->getProducts();
			}
			elseif ($error = $table->getError())
			{
				$this->setError($error);
			}
		}

		return $this->_item;
	}

	public function getTable($type = 'ProductType', $prefix = 'GazebosTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	/**
	 * Get products for this type
	 *
	 * @return  array  An array of product objects associated with this product type.
	 */
	public function getProducts()
	{
		$q = 'SELECT * FROM #__gazebos_products WHERE state = 1 AND type_id = ' . $this->getState('producttype.id');
		$results = $this->getDbo()->setQuery($q)->loadObjectList();

		if ($results !== null)
		{
			foreach ($results as $product)
			{
				$product->link = JRoute::_('index.php?option=com_gazebos&view=product&id=' . $product->id);
			}
		}

		return $results;
	}
}
