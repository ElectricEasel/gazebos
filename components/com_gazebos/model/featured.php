<?php
/**
 * @version     1.0.0
 * @package     com_gazebos
 * @copyright   Copyright (C) 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Don Gilbert <don@electriceasel.com> - http://www.electriceasel.com
 */
defined('_JEXEC') or die;

class GazebosModelFeatured extends EEModelList
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

		$this->setState('list.limit', 20);
	}

	/**
	 * Method to get an ojbect.
	 *
	 * @param integer The id of the object to get.
	 *
	 * @return mixed Object on success, false on failure.
	 */
	public function getItems()
	{
		if (!isset($this->items))
		{
			$this->items = parent::getItems();

			if (empty($this->items))
			{
				JFactory::getApplication()->setError('Product not found.');
			}
			else
			{
				foreach ($this->items as $product)
				{
					$Itemid = GazebosHelper::getProductTypeMenuItem($product->type_id);
					$product->link = JRoute::_('index.php?option=com_gazebos&view=product&id=' . $product->id . '&Itemid=' . $Itemid);
					$product->type_link = JRoute::_('index.php?Itemid=' . $Itemid);
		
					if (!empty($product->image))
					{
						$product->image = EEHtml::asset("products/{$product->id}/thumbs/200x200_{$product->image}", 'com_gazebos', array('alt' => $product->title));
					}
				}
			}
		}

		return (array) $this->items;
	}

	protected function buildListQuery()
	{
		return $this
			->getDbo()
			->getQuery(true)
			->select('a.*, c.title AS type_title')
			->select('(SELECT b.path FROM #__gazebos_gallery AS b WHERE b.product_id = a.id ORDER BY b.ordering ASC LIMIT 1) AS image')
			->from('#__gazebos_products AS a')
			->leftJoin('#__gazebos_types AS c ON c.id = a.type_id')
			->where('a.state = 1')
			->where('a.featured = "1"');
	}
}
