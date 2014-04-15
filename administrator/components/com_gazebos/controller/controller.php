<?php
/**
 * @version     1.0.0
 * @package     com_gazebos
 * @copyright   Copyright (C) 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Don Gilbert <don@electriceasel.com> - http://www.electriceasel.com
 */
defined('_JEXEC') or die;

class GazebosController extends EEController
{
    /**
     * @var array Material Type Category ID's
     */
    protected $categories;

    protected $types;

	/**
	 * Method to display a view.
	 *
	 * @param	boolean			$cachable	If true, the view output will be cached
	 * @param	array			$urlparams	An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
	 *
	 * @return	JController		This object to support chaining.
	 * @since	1.5
	 */
	public function display($cachable = false, $urlparams = false)
	{
		$app  = JFactory::getApplication();
		$view = $app->input->getCmd('view', 'products');
        $app->input->set('view', $view);

		parent::display($cachable, $urlparams);

		return $this;
	}

    public function salesforceExport()
    {
        $db = JFactory::getDbo();

        $query = $db->getQuery(true)
            ->select(array(
                    'f.title AS "Line"',
                    'e.title AS "Material"',
                    'd.title AS "Model"',
                    'a.size AS "Size"',
                    'c.title AS "Shape"',
                    '"" AS "Option"',
                    'a.min_price AS "MinPrice"',
                    'a.max_price AS "MaxPrice"',
                    'b.options'
                ))
            ->from('#__gazebos_sizes AS a')
            ->leftJoin('#__gazebos_products AS b ON b.id = a.product_id')
            ->leftJoin('#__gazebos_shapes AS c ON c.id = b.shape_id')
            ->leftJoin('#__gazebos_styles AS d ON d.id = b.style_id')
            ->leftJoin('#__gazebos_materials AS e ON e.id = b.material_id')
            ->leftJoin('#__menu AS f ON f.id = b.series');

        $rows = $db->setQuery($query)->loadObjectList();

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment;filename=SalesForceData-' . date('m-d-Y') . '.csv');
        $output = fopen('php://output', 'w');

        $headers = array('Line', 'Material', 'Model', 'Size', 'Shape', 'Option', 'Min Price', 'Max Price');

        fputcsv($output, $headers);

        foreach ($rows as $row)
        {
            $materialType = ($row->Material === 'Wood') ? $this->getMaterialType($row) : $row->Material;

            $entry = array(
                $row->Line,
                $materialType,
                $row->Model,
                $row->Size,
                $row->Shape,
                $row->Option,
                $row->MinPrice,
                $row->MaxPrice
            );

            fputcsv($output, $entry);
        }

        fclose($output);

        exit();
    }

    protected function getMaterialType($row)
    {
        if (is_null($this->types))
        {
            $db = JFactory::getDbo();
            $query = $db->getQuery(true)
                ->select('a.id')
                ->from('#__gazebos_option_categories AS a')
                ->where('a.title = "Wood Type"');

            $this->categories = $db->setQuery($query)->loadColumn();

            $query = $db->getQuery(true)
                ->select('a.id, a.title')
                ->from('#__gazebos_options AS a')
                ->where('a.option_category_id IN (' . implode(',', $this->categories) . ')');

            $this->types = $db->setQuery($query)->loadAssocList('id');
        }

        $options = @json_decode($row->options);

        foreach ($this->categories as $id)
        {
            if (isset($options->$id))
            {
                $idArray = $options->$id;
                return $this->types[(int)$idArray[0]]['title'];
            }
        }

        return false;
    }
}
