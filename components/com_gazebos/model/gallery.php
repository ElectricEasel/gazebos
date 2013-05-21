<?php
/**
 * @version     1.0.0
 * @package     com_gazebos
 * @copyright   Copyright (C) 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Don Gilbert <don@electriceasel.com> - http://www.electriceasel.com
 */
defined('_JEXEC') or die;

class GazebosModelGallery extends EEModelList
{
	protected function populateState()
	{
		parent::populateState();

		$app = JFactory::getApplication();

		$this->setState('filter.type_id', $app->input->getInt('filter_type_id', 0));

		$this->setState('list.limit', 500);
	}

	public function getItems()
	{
		if (!isset($this->items))
		{
			$this->items = parent::getItems();

			if (empty($this->items) || !is_array($this->items))
			{
				JFactory::getApplication()->setError('No gallery images found');
			}
			else
			{
				foreach ($this->items as $i => $item)
				{
					if (empty($item->image))
					{
						unset($this->items[$i]);
					}
				}
			}
		}

		return (array) $this->items;
	}

	public function getTypeSelect()
	{
		$db = $this->getDbo();
		$q  = $db->getQuery(true);

		$q
			->select('a.title, a.id')
			->from('#__gazebos_types AS a')
			->where('a.state = 1');

		$results = (array) $db->setQuery($q)->loadObjectList();

		array_unshift($results, (object) array('id' => '', 'title' => 'View All'));

		return JHtml::_('select.genericlist', $results, 'filter_type_id', array('class' => 'chosen', 'onchange' => 'this.form.submit();'), 'id', 'title', $this->getState('filter.type_id'), 'filter_type_id');
	}

	/**
	 * Build an SQL query to load the list data.
	 *
	 * @return JDatabaseQuery
	 * @since 1.6
	 */
	protected function buildListQuery()
	{
		$db = $this->getDbo();
		$q  = $db->getQuery(true);

		$q
			->select('a.*')
			->select('(SELECT b.path FROM #__gazebos_gallery AS b WHERE b.product_id = a.id  ORDER BY b.ordering ASC LIMIT 1) AS image')
			->from('#__gazebos_products AS a')
			->where('a.state = 1')
			->order('RAND()');

		$type_id = (int) $this->getState('filter.type_id');

		if (!empty($type_id))
		{
			$q->where('a.type_id = ' . $type_id);
		}

		$series = (int) $this->getState('filter.series');

		if (!empty($series))
		{
			$q->where('a.series = ' . $series);
		}

		return $q;
	}

}
