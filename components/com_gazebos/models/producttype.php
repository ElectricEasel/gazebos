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

		$filter_material = $app->getUserStateFromRequest('filter.material', 'filter_material', array(), 'array');
		$this->setState('filter.material', $filter_material);

		$filter_shape = $app->getUserStateFromRequest('filter.shape', 'filter_shape', array(), 'array');
		$this->setState('filter.shape', $filter_shape);

		$filter_style = $app->getUserStateFromRequest('filter.style', 'filter_style', array(), 'array');
		$this->setState('filter.style', $filter_style);

		$filter_price = $app->getUserStateFromRequest('filter.price', 'filter_price', array(), 'array');
		$this->setState('filter.price', $filter_price);

		// Get the current product type setting from the menu item request
		$this->setState('producttype.id', $app->input->getInt('id'));

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
		$q  = 'SELECT a.*, (SELECT b.path FROM #__gazebos_gallery AS b WHERE b.product_id = a.id';
		$q .= ' ORDER BY b.ordering ASC LIMIT 1) AS image FROM #__gazebos_products AS a';
		$q .= ' WHERE a.state = 1 AND a.type_id = ' . $this->getState('producttype.id');

		$filter_material = $this->getState('filter.material');
		if (is_array($filter_material) && !empty($filter_material) && !empty($filter_material[0]))
		{
			$q .= ' AND a.material_id IN (' . implode(',', $filter_material) . ')';
		}

		$filter_price = $this->getState('filter.price');
		if (is_array($filter_price) && !empty($filter_price) && !empty($filter_price[0]))
		{
			$q .= ' AND a.price_id IN (' . implode(',', $filter_price) . ')';
		}

		$filter_shape = $this->getState('filter.shape');
		if (is_array($filter_shape) && !empty($filter_shape) && !empty($filter_shape[0]))
		{
			$q .= ' AND a.shape_id IN (' . implode(',', $filter_shape) . ')';
		}

		$filter_style = $this->getState('filter.style');
		if (is_array($filter_style) && !empty($filter_style) && !empty($filter_style[0]))
		{
			$q .= ' AND a.style_id IN (' . implode(',', $filter_style) . ')';
		}

		$results = $this->getDbo()->setQuery($q)->loadObjectList('id');

		if ($results !== null)
		{
			foreach ($results as $product)
			{
				$Itemid = GazebosHelper::getProductTypeMenuItem($this->getState('producttype.id'));
				$product->link = JRoute::_('index.php?option=com_gazebos&view=product&id=' . $product->id . '&Itemid=' . $Itemid);

				if (!empty($product->image))
				{
					$product->image = '/media/com_gazebos/gallery/products/' . $product->id . '/thumbs/199x160_' . $product->image;
				}
			}
		}

		return $results;
	}
}
