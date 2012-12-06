<?php
/**
 * @version     1.0.0
 * @package     com_gazebos
 * @copyright   Copyright (C) 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Don Gilbert <don@electriceasel.com> - http://www.electriceasel.com
 */

defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');

/**
 * Methods supporting a list of Gazebos records.
 */
class GazebosModelproducts extends JModelList
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
	protected function getListQuery()
	{
		// Create a new query object.
		$db		= $this->getDbo();
		$query	= $db->getQuery(true);

		// Select the required fields from the table.
		$query->select(
			$this->getState(
				'list.select',
				'a.*'
			)
		);
		$query->from('`#__gazebos_products` AS a');


    // Join over the users for the checked out user.
    $query->select('uc.name AS editor');
    $query->join('LEFT', '#__users AS uc ON uc.id=a.checked_out');
    
		// Join over the user field 'created_by'
		$query->select('created_by.name AS created_by');
		$query->join('LEFT', '#__users AS created_by ON created_by.id = a.created_by');
		// Join over the foreign key 'type_id'
		$query->select('#__gazebos_types_310197.title AS producttypes_title_310197');
		$query->join('LEFT', '#__gazebos_types AS #__gazebos_types_310197 ON #__gazebos_types_310197.id = a.type_id');
		// Join over the foreign key 'style_id'
		$query->select('#__gazebos_styles_310216.title AS productstyles_title_310216');
		$query->join('LEFT', '#__gazebos_styles AS #__gazebos_styles_310216 ON #__gazebos_styles_310216.id = a.style_id');
		// Join over the foreign key 'shape_id'
		$query->select('#__gazebos_shapes_310225.title AS productshapes_title_310225');
		$query->join('LEFT', '#__gazebos_shapes AS #__gazebos_shapes_310225 ON #__gazebos_shapes_310225.id = a.shape_id');
		// Join over the foreign key 'material_id'
		$query->select('#__gazebos_materials_310224.title AS productmaterials_title_310224');
		$query->join('LEFT', '#__gazebos_materials AS #__gazebos_materials_310224 ON #__gazebos_materials_310224.id = a.material_id');


    // Filter by published state
    $published = $this->getState('filter.state');
    if (is_numeric($published)) {
        $query->where('a.state = '.(int) $published);
    } else if ($published === '') {
        $query->where('(a.state IN (0, 1))');
    }
    

		// Filter by search in title
		$search = $this->getState('filter.search');
		if (!empty($search)) {
			if (stripos($search, 'id:') === 0) {
				$query->where('a.id = '.(int) substr($search, 3));
			} else {
				$search = $db->Quote('%'.$db->escape($search, true).'%');
                $query->where('( a.title LIKE '.$search.' )');
			}
		}
        


		//Filtering type_id
		$filter_type_id = $this->state->get("filter.type_id");
		if ($filter_type_id) {
			$query->where("a.type_id = '".$filter_type_id."'");
		}

		//Filtering style_id
		$filter_style_id = $this->state->get("filter.style_id");
		if ($filter_style_id) {
			$query->where("a.style_id = '".$filter_style_id."'");
		}

		//Filtering shape_id
		$filter_shape_id = $this->state->get("filter.shape_id");
		if ($filter_shape_id) {
			$query->where("a.shape_id = '".$filter_shape_id."'");
		}

		//Filtering material_id
		$filter_material_id = $this->state->get("filter.material_id");
		if ($filter_material_id) {
			$query->where("a.material_id = '".$filter_material_id."'");
		}        
        
        
		// Add the list ordering clause.
        $orderCol	= $this->state->get('list.ordering');
        $orderDirn	= $this->state->get('list.direction');
        if ($orderCol && $orderDirn) {
            $query->order($db->escape($orderCol.' '.$orderDirn));
        }

		return $query;
	}
}
