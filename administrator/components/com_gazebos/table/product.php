<?php

/**
 * @version     1.0.0
 * @package     com_gazebos
 * @copyright   Copyright (C) 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Don Gilbert <don@electriceasel.com> - http://www.electriceasel.com
 */
defined('_JEXEC') or die;

class GazebosTableProduct extends EETable
{
	protected $_tbl = '#__gazebos_products';

	public function bind($array, $ignore = '')
	{
		$fields = array(
			'options',
			'colors',
			'features',
			'roofing',
			'flooring'
		);

		foreach ($fields as $field)
		{
			if (isset($array[$field]) && is_array($array[$field]))
			{
	
				foreach ($array[$field] as $key => $opts)
				{
					foreach ($opts as $k => $v)
					{
						if (empty($v))
						{
							unset($array[$field][$key][$k]);
						}
					}
				}
	
				$array[$field] = (string) new JRegistry($array[$field]);
			}
		}

		$array['title'] = $this->buildProductTitle($array);

		if (isset($array['specifications']) && is_array($array['specifications']))
		{
			foreach ($array['specifications']['title'] as $key => $value)
			{
				if (empty($value))
				{
					unset($array['specifications']['title'][$key]);
					unset($array['specifications']['value'][$key]);
				}
			}

			$array['specifications'] = (string) new JRegistry($array['specifications']);
		}

		return parent::bind($array, $ignore);
	}

	/**
	 * Build the product title based on selected options.
	 *
	 * @param   array  $data  Array of form data.
	 *
	 * @return  string
	 */
	public function buildProductTitle($data)
	{
		$material_id = (int) $data['material_id'];
		$shape_id    = (int) $data['shape_id'];
		$style_id    = (int) $data['style_id'];
		$type_id     = (int) $data['type_id'];
		
		$q = 'SELECT a.title AS title' .
			' FROM #__gazebos_styles AS a' .
			' WHERE a.id = ' . $style_id .
			' UNION SELECT b.title AS title' .
			' FROM #__gazebos_materials AS b' .
			' WHERE b.id = ' . $material_id .
			' UNION SELECT c.title AS title' .
			' FROM #__gazebos_shapes AS c' .
			' WHERE c.id = ' . $shape_id .
			' UNION SELECT d.title AS title' .
			' FROM #__gazebos_types AS d' .
			' WHERE d.id = ' . $type_id;

		return rtrim(implode(' ', array_keys($this->_db->setQuery($q)->loadAssocList('title'))), 's');
	}
}
