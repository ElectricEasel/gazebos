<?php
/**
 * @version     1.0.0
 * @package     com_gazebos
 * @copyright   Copyright (C) 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Don Gilbert <don@electriceasel.com> - http://www.electriceasel.com
 */
defined('_JEXEC') or die;

class GazebosModelType extends EEModelItem
{
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
		$type = $app->input->getInt('id');
		$this->setState('type.id', $type);

		$context = 'product' . $type;

		$filter_material = $app->getUserStateFromRequest($context . 'filter.material', 'filter_material', array(), 'array');
		$this->setState($context . 'filter.material', $filter_material);

		$filter_shape = $app->getUserStateFromRequest($context . 'filter.shape', 'filter_shape', array(), 'array');
		$this->setState($context . 'filter.shape', $filter_shape);

		$filter_style = $app->getUserStateFromRequest($context . 'filter.style', 'filter_style', array(), 'array');
		$this->setState($context . 'filter.style', $filter_style);

		$filter_price = $app->getUserStateFromRequest($context . 'filter.price', 'filter_price', array(), 'array');
		$this->setState($context . 'filter.price', $filter_price);

		$this->setState('params', $app->getParams());
	}


	/**
	 * Method to get an ojbect.
	 *
	 * @param integer The id of the object to get.
	 *
	 * @return mixed Object on success, false on failure.
	 */
	public function getItem($id = null)
	{
		if (!isset($this->item))
		{
			$this->item = parent::getItem();

			if (empty($this->item))
			{
				JFactory::getApplication()->setError('Product type not found.');
			}
			else
			{
				$this->item->shapes = $this->getShapes();
				$this->item->materials = $this->getMaterials();
				$this->item->products = $this->getProducts();
			}
		}

		return $this->item;
	}

	public function buildQuery()
	{
		return $this
			->getDbo()
			->getQuery(true)
			->select('a.*')
			->from('#__gazebos_types AS a')
			->where('a.id = ' . (int) $this->getState('type.id'));
	}

	public function getMaterials()
	{
		$q = $this
			->getDbo()
			->getQuery(true)
			->select('a.*')
			->from('#__gazebos_materials AS a')
			->where('a.type_id = ' . $this->item->id)
			->order('a.ordering ASC');

		return (array) $this->getDbo()->setQuery($q)->loadObjectList();
	}

	public function getShapes()
	{
		$q = $this
			->getDbo()
			->getQuery(true)
			->select('a.*')
			->from('#__gazebos_shapes AS a')
			->where('a.type_id = ' . $this->item->id)
			->order('a.ordering ASC');

		return (array) $this->getDbo()->setQuery($q)->loadObjectList();
	}

	/**
	 * Get products for this type
	 *
	 * @return  array  An array of product objects associated with this product type.
	 */
	public function getProducts()
	{
		$context = 'product' . $type;

		$q = 'SELECT a.*, (SELECT b.path FROM #__gazebos_gallery AS b WHERE b.product_id = a.id ' .
			' ORDER BY b.ordering ASC LIMIT 1) AS image FROM #__gazebos_products AS a' .
			' WHERE a.state = 1 AND a.type_id = ' . $this->item->id;

		$filter_material = $this->getState($context . 'filter.material');
		if (is_array($filter_material) && !empty($filter_material) && !empty($filter_material[0]))
		{
			$q .= ' AND a.material_id IN (' . implode(',', $filter_material) . ')';
		}

		$filter_shape = $this->getState($context . 'filter.shape');
		if (is_array($filter_shape) && !empty($filter_shape) && !empty($filter_shape[0]))
		{
			$q .= ' AND a.shape_id IN (' . implode(',', $filter_shape) . ')';
		}

		$filter_style = $this->getState($context . 'filter.style');
		if (is_array($filter_style) && !empty($filter_style) && !empty($filter_style[0]))
		{
			$q .= ' AND a.style_id IN (' . implode(',', $filter_style) . ')';
		}

		$results = $this->getDbo()->setQuery($q)->loadObjectList('id');

		if ($results !== null)
		{
			foreach ($results as $product)
			{
				$Itemid = GazebosHelper::getProductTypeMenuItem($type);
				$product->link = JRoute::_('index.php?option=com_gazebos&view=product&id=' . $product->id . '&Itemid=' . $Itemid);

				if (!empty($product->image))
				{
					$product->image = EEHtml::asset("products/{$product->id}/thumbs/199x160_{$product->image}", 'com_gazebos');
				}
			}
		}

		return $results;
	}
}
