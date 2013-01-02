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

/**
 * Gazebos model.
 */
class GazebosModelProduct extends JModel
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

		$this->setState('product.id', $app->input->getInt('id'));
		
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
				$id = $this->getState('product.id');
			}

			$q =
				'SELECT a.*, b.title AS type, c.title AS style, d.title AS shape, e.title AS material ' .
				'FROM #__gazebos_products AS a ' .
				'LEFT JOIN #__gazebos_types AS b ON b.id = a.type_id ' .
				'LEFT JOIN #__gazebos_styles AS c ON c.id = a.style_id ' .
				'LEFT JOIN #__gazebos_shapes AS d ON d.id = a.shape_id ' .
				'LEFT JOIN #__gazebos_materials AS e ON e.id = a.material_id ' .
				'WHERE a.state = 1 AND a.id = ' . $id;

			$result = $this->getDbo()->setQuery($q)->loadObject();

			if ($result !== null)
			{
				$registry = new JRegistry($result->specifications);
				$result->specifications = $registry->toArray();
				$result->gallery = $this->getGallery($id);
				$result->features = $this->getFeatures($result);
				$result->price_min = number_format($result->price_min);
				$result->price_max = number_format($result->price_max);

				$this->_item = $result;
			}
			else
			{
				JFactory::getApplication()->setError('Product not found.');
			}
		}

		return $this->_item;
	}

	/**
	 * Get gallery images for the product.
	 *
	 * @param   integer  $id  The id of the product for which to retrieve the gallery.
	 *
	 * @return  array  An array of image objects for the product gallery.
	 */
	public function getGallery($id = null)
	{
		settype($id, 'int');

		if (empty($id))
		{
			$id = $this->getState('product.id');
		}

		$q = 'SELECT * FROM #__gazebos_gallery WHERE product_id = ' . $id . ' ORDER BY ordering ASC';

		return $this->getDbo()->setQuery($q)->loadObjectList();
	}

	/**
	 * Get features for current item
	 *
	 * @param   object  $item  The product for which to get the features.
	 *
	 * @return  array  An array of features for current product.
	 */
	public function getFeatures($item)
	{
		$type_id = (int) $item->type_id;
		$line_id = (int) $item->line_id;

		$q = "SELECT * FROM #__gazebos_features WHERE type_id = {$type_id} AND line_id = {$line_id}";

		return $this->getDbo()->setQuery($q)->loadObjectList();
	}
}
