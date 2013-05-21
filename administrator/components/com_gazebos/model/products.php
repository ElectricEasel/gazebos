<?php
/**
 * @version     1.0.0
 * @package     com_gazebos
 * @copyright   Copyright (C) 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Don Gilbert <don@electriceasel.com> - http://www.electriceasel.com
 */
defined('_JEXEC') or die;

class GazebosModelProducts extends EEModelList
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
        if (empty($config['filter_fields'])) {
            $config['filter_fields'] = array(
                                'id', 'a.id',
                'ordering', 'a.ordering',
                'state', 'a.state',
                'created_by', 'a.created_by',
                'title', 'a.title',
                'type_id', 'a.type_id',
                'style_id', 'a.style_id',
                'shape_id', 'a.shape_id',
                'material_id', 'a.material_id',
                'short_description', 'a.short_description',
                'description', 'a.description',
                'price_min', 'a.price_min',
                'price_max', 'a.price_max',
                'brochure', 'a.brochure',
                'options', 'a.options',

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

		//Filtering type_id
		$this->setState('filter.type_id', $app->getUserStateFromRequest($this->context.'.filter.type_id', 'filter_type_id', '', 'string'));

		//Filtering style_id
		$this->setState('filter.style_id', $app->getUserStateFromRequest($this->context.'.filter.style_id', 'filter_style_id', '', 'string'));

		//Filtering shape_id
		$this->setState('filter.shape_id', $app->getUserStateFromRequest($this->context.'.filter.shape_id', 'filter_shape_id', '', 'string'));

		//Filtering material_id
		$this->setState('filter.material_id', $app->getUserStateFromRequest($this->context.'.filter.material_id', 'filter_material_id', '', 'string'));

		// Load the parameters.
		$params = JComponentHelper::getParams('com_gazebos');
		$this->setState('params', $params);

		// List state information.
		parent::populateState('a.title', 'asc');
	}

	/**
	 * Method to get a store id based on model configuration state.
	 *
	 * This is necessary because the model is used by the component and
	 * different modules that might need different sets of data or different
	 * ordering requirements.
	 *
	 * @param	string		$id	A prefix for the store id.
	 * @return	string		A store id.
	 * @since	1.6
	 */
	protected function getStoreId($id = '')
	{
		// Compile the store id.
		$id.= ':' . $this->getState('filter.search');
		$id.= ':' . $this->getState('filter.state');

		return parent::getStoreId($id);
	}

	/**
	 * Build an SQL query to load the list data.
	 *
	 * @return	JDatabaseQuery
	 * @since	1.6
	 */
	protected function buildListQuery()
	{
		// Create a new query object.
		$db = $this->getDbo();
		$q  = $db->getQuery(true);

		// Select the required fields from the table.
		$q
			->select('a.*')
			->from('`#__gazebos_products` AS a')
			->select('uc.name AS editor')
			->leftJoin('#__users AS uc ON uc.id=a.checked_out')
			->select('created_by.name AS created_by')
			->leftJoin('#__users AS created_by ON created_by.id = a.created_by');

			// Join over the foreign key 'type_id'
			$q
				->select('b.title AS type_title')
				->leftJoin('#__gazebos_types AS b ON b.id = a.type_id');

			// Join over the foreign key 'style_id'
			$q
				->select('c.title AS style_title')
				->leftJoin('#__gazebos_styles AS c ON c.id = a.style_id');

			// Join over the foreign key 'shape_id'
			$q
				->select('d.title AS shape_title')
				->leftJoin('#__gazebos_shapes AS d ON d.id = a.shape_id');

			// Join over the foreign key 'material_id'
			$q
				->select('e.title AS material_title')
				->leftJoin('#__gazebos_materials AS e ON e.id = a.material_id');

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
				$search = $db->Quote('%'.$db->escape($search, true).'%');
                $q->where('( a.title LIKE '.$search.' )');
			}
		}

		//Filtering type_id
		$filter_type_id = (int) $this->state->get("filter.type_id");
		if ($filter_type_id)
		{
			$q->where("a.type_id = {$filter_type_id}");
		}

		//Filtering style_id
		$filter_style_id = (int) $this->state->get("filter.style_id");
		if ($filter_style_id)
		{
			$q->where("a.style_id = {$filter_style_id}");
		}

		//Filtering shape_id
		$filter_shape_id = (int) $this->state->get("filter.shape_id");
		if ($filter_shape_id)
		{
			$q->where("a.shape_id = {$filter_shape_id}");
		}

		//Filtering material_id
		$filter_material_id = (int) $this->state->get("filter.material_id");
		if ($filter_material_id)
		{
			$q->where("a.material_id = {$filter_material_id}");
		}
        
		// Add the list ordering clause.
        $orderCol	= $this->state->get('list.ordering');
        $orderDirn	= $this->state->get('list.direction');
        if ($orderCol && $orderDirn)
        {
            $q->order($db->escape($orderCol . ' ' . $orderDirn));
        }

		return $q;
	}
}
