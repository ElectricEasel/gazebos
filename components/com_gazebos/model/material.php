<?php
/**
 * @version     1.0.0
 * @package     com_gazebos
 * @copyright   Copyright (C) 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Don Gilbert <don@electriceasel.com> - http://www.electriceasel.com
 */
defined('_JEXEC') or die;

class GazebosModelMaterial extends EEModelItem
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
		parent::populateState();

		$app = JFactory::getApplication();

		$material_id = $app->input->getInt('id');
		$this->setState('material.id', $material_id);
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
			->select('a.*, b.title AS type_title')
			->from('#__gazebos_materials AS a')
			->leftJoin('#__gazebos_types AS b ON b.id = a.type_id')
			->where('a.id = ' . (int) $this->getState('material.id'));
	}

	/**
	 * Get products for this type
	 *
	 * @return  array  An array of product objects associated with this product type.
	 */
	public function getProducts()
	{
		$db = $this->getDbo();
		$q  = $db->getQuery(true);

		$q
			->select('a.*')
			->select('(SELECT b.path FROM #__gazebos_gallery AS b WHERE b.product_id = a.id ORDER BY b.ordering ASC LIMIT 1) AS image')
			->select('(SELECT c.min_price FROM #__gazebos_sizes AS c WHERE c.product_id = a.id ORDER BY c.min_price ASC LIMIT 1) AS min_price')
			->from('#__gazebos_products AS a')
			->where('a.state = 1')
			->where('a.material_id = ' . $this->item->id);

		$wood_type = (int) $this->getState('filter.wood_type');
		if (!empty($wood_type))
		{
			$q->where("a.options LIKE '%\"{$wood_type}\"%'");
		}

		$q->order('a.ordering ASC');

		$results = (array) $this->getDbo()->setQuery($q)->loadObjectList('id');

		foreach ($results as $product)
		{
			$Itemid = GazebosHelper::getProductTypeMenuItem($product->type_id);
			$product->link = JRoute::_('index.php?option=com_gazebos&view=product&id=' . $product->id . '&Itemid=' . $Itemid);

			if (!empty($product->image))
			{
				$base = JPATH_BASE . "/media/com_gazebos/images/products/{$product->id}/";
				if (!file_exists($base . "thumbs/200x200_{$product->image}"))
				{
					EEImageHelper::setThumbSizes(array(
						JImage::CROP_RESIZE => array(
							'600x600',
							'300x300',
							'200x200',
							'150x150',
							'60x60'
						)
					));

					EEImageHelper::resizeImage($base, $product->image);
				}
				$product->image = EEHtml::asset("products/{$product->id}/thumbs/200x200_{$product->image}", 'com_gazebos');
			}
		}

		return $results;
	}

	public function getWoodTypes()
	{
		
	}

	public function getShapes()
	{
		$db = $this->getDbo();
		$q  = $db->getQuery(true);

		$q
			->select('a.*')
			->from('#__gazebos_shapes AS a')
			->where('a.type_id = ' . $this->item->type_id);

		return (array) $db->setQuery($q)->loadObjectList();
	}
}
