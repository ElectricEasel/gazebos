<?php
/**
 * @version     1.0.0
 * @package     com_gazebos
 * @copyright   Copyright (C) 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Don Gilbert <don@electriceasel.com> - http://www.electriceasel.com
 */
defined('_JEXEC') or die;

class GazebosModelOptioncategories extends EEModelList
{
	/**
	 * Constructor.
	 *
	 * @param    array    An optional associative array of configuration settings.
	 * @see        JController
	 * @since    1.6
	 */
	public function __construct($config = array())
	{
		if (empty($config['filter_fields']))
		{
			$config['filter_fields'] = array(
				'id', 'a.id',
				'ordering', 'a.ordering',
				'state', 'a.state',
				'created_by', 'a.created_by',
				'title', 'a.title',
			);
		}

		parent::__construct($config);
	}


	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 */
	protected function populateState($ordering = null, $direction = null)
	{
		// Initialise variables.
		$app = JFactory::getApplication('administrator');

		// Load the filter state.
		$search = $app->getUserStateFromRequest($this->context.'.filter.search', 'filter_search');
		$this->setState('filter.search', $search);

		$published = $app->getUserStateFromRequest($this->context.'.filter.state', 'filter_published', '', 'string');
		$this->setState('filter.state', $published);

		$type = $app->getUserStateFromRequest($this->context.'.filter.type_id', 'filter_type_id', null, 'int');
		$this->setState('filter.type_id', $type);

		$option_type = $app->getUserStateFromRequest($this->context.'.filter.option_type', 'filter_option_type', null, 'int');
		$this->setState('filter.option_type', $option_type);

		// Load the parameters.
		$params = JComponentHelper::getParams('com_gazebos');
		$this->setState('params', $params);

		// List state information.
		parent::populateState('a.title', 'asc');
	}

	/**
	 * Build an SQL query to load the list data.
	 *
	 * @return JDatabaseQuery
	 * @since 1.6
	 */
	protected function buildListQuery()
	{
		// Create a new query object.
		$db = $this->getDbo();
		$q  = $db->getQuery(true);

		$q
			->select('a.*')
			->from('#__gazebos_option_categories AS a')
			->select('b.title AS type_title')
			->leftJoin('#__gazebos_types AS b ON b.id = a.type_id');

		// Filter by published state
		$published = $this->getState('filter.state');

		if (is_numeric($published))
		{
			$q->where('a.state = '.(int) $published);
		}
		elseif ($published === '')
		{
			$q->where('(a.state IN (0, 1))');
		}

		$type_id = (int) $this->getState('filter.type_id');

		if (!empty($type_id))
		{
			$q->where('a.type_id = ' . $type_id);
		}

		$option_type = (int) $this->getState('filter.option_type');

		if (!empty($option_type))
		{
			$q->where('a.option_type = ' . $option_type);
		}


		// Filter by search in title
		$search = $this->getState('filter.search');

		if (!empty($search))
		{
			if (stripos($search, 'id:') === 0)
			{
				$q->where('a.id = '.(int) substr($search, 3));
			}
			else
			{
				$search = $db->Quote('%' . $db->escape($search, true) . '%');
				$q->where('( a.title LIKE ' . $search . ' )');
			}
		}

		// Add the list ordering clause.
		$orderCol = $this->state->get('list.ordering');
		$orderDirn = $this->state->get('list.direction');

		if ($orderCol && $orderDirn)
		{
			$q->order($db->escape($orderCol . ' ' . $orderDirn));
		}

		return $q;
	}
}
