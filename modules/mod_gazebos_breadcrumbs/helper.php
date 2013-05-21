<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_breadcrumbs
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

class modGazebosBreadCrumbsHelper
{
	protected static $layoutTitleMap = array(
		'mapsearch' => 'Map Search'
	);

	public static function getList(&$params)
	{
		// Get the PathWay object from the application
		$app = JFactory::getApplication();
		$crumbs	= array();

		if ($app->input->getCmd('option') === 'com_gazebos')
		{
			$crumbs = self::getGazebosLinkList();
		}
		else
		{
			$pathway	= $app->getPathway();
			$items		= $pathway->getPathWay();
	
			$count = count($items);
			// don't use $items here as it references JPathway properties directly
	
			for ($i = 0; $i < $count; $i ++)
			{
				$crumbs[$i] = new stdClass();
				$crumbs[$i]->name = stripslashes(htmlspecialchars($items[$i]->name, ENT_COMPAT, 'UTF-8'));
				$crumbs[$i]->link = JRoute::_($items[$i]->link);
			}
		}

		if ($params->get('showHome', 1))
		{
			$item = new stdClass();
			$item->name = htmlspecialchars($params->get('homeText', JText::_('MOD_GAZEBOS_BREADCRUMBS_HOME')));
			$item->link = JRoute::_('index.php?Itemid=' . $app->getMenu()->getDefault()->id);
			array_unshift($crumbs, $item);
		}

		return $crumbs;
	}

	public static function getGazebosLinkList()
	{
		$db = JFactory::getDbo();
		$app = JFactory::getApplication();
		$id = $app->input->getInt('id');
		$material_id = $app->input->getInt('material_id');
		$view = $app->input->getWord('view');
		$layout = strtolower($app->input->getWord('layout', 'default'));
		$segments = 1;
		$crumbs = array();

		switch ($view)
		{
			case 'gallery':
				$crumbs[] = (object) array(
					'name' => 'Gallery',
					'link' => JRoute::_('index.php?option=com_gazebos&view=gallery')
				);
				break;
			case 'type':
				$q = 'SELECT a.id AS type_id, a.title AS type_title' .
					' FROM #__gazebos_types AS a' .
					' WHERE a.id = ' . (int) $id;

				$r = JFactory::getDbo()->setQuery($q)->loadObject();

				$crumbs[] = (object) array(
					'name' => $r->type_title,
					'link' => JRoute::_('index.php?option=com_gazebos&view=type&id=' . $r->type_id)
				);
				break;
			case 'material':
				$q = 'SELECT a.title AS material_title, a.id AS material_id, b.title AS type_title, b.id AS type_id' .
					' FROM #__gazebos_materials AS a' .
					' LEFT JOIN #__gazebos_types AS b ON b.id = a.type_id' .
					' WHERE a.id = ' . (int) $id;
		
				$r = JFactory::getDbo()->setQuery($q)->loadObject();

				$crumbs[] = (object) array(
					'name' => $r->type_title,
					'link' => JRoute::_('index.php?option=com_gazebos&view=type&id=' . $r->type_id)
				);

				$crumbs[] = (object) array(
					'name' => $r->material_title,
					'link' => JRoute::_('index.php?option=com_gazebos&view=material&id=' . $r->material_id)
				);
				break;
			case 'shape':
				$q = 'SELECT a.title AS shape_title, a.id AS shape_id, b.title AS type_title, b.id AS type_id, c.title AS material_title, c.id AS material_id' .
					' FROM #__gazebos_shapes AS a' .
					' LEFT JOIN #__gazebos_types AS b ON b.id = a.type_id' .
					' LEFT JOIN #__gazebos_materials AS c ON c.type_id = b.id' .
					' WHERE a.id = ' . (int) $id .
					' AND c.id = ' . (int) $material_id;
		
				$r = JFactory::getDbo()->setQuery($q)->loadObject();

				$crumbs[] = (object) array(
					'name' => $r->type_title,
					'link' => JRoute::_('index.php?option=com_gazebos&view=type&id=' . $r->type_id)
				);

				$crumbs[] = (object) array(
					'name' => $r->material_title,
					'link' => JRoute::_('index.php?option=com_gazebos&view=material&id=' . $r->material_id)
				);

				$crumbs[] = (object) array(
					'name' => $r->shape_title,
					'link' => JRoute::_('index.php?option=com_gazebos&view=shape&id=' . $r->shape_id . '&material_id=' . $r->material_id)
				);
				break;
			case 'product':
				$q = 'SELECT a.id AS product_id, b.title AS material_title, b.id AS material_id, c.title AS shape_title, c.id AS shape_id, d.title AS type_title, d.id AS type_id, e.title AS style_title' .
					' FROM #__gazebos_products AS a' .
					' LEFT JOIN #__gazebos_materials AS b ON b.id = a.material_id' .
					' LEFT JOIN #__gazebos_shapes AS c ON c.id = a.shape_id' .
					' LEFT JOIN #__gazebos_types AS d ON d.id = a.type_id' .
					' LEFT JOIN #__gazebos_styles AS e ON e.id = a.style_id' .
					' WHERE a.id = ' . (int) $id;
		
				$r = JFactory::getDbo()->setQuery($q)->loadObject();

				$crumbs[] = (object) array(
					'name' => $r->type_title,
					'link' => JRoute::_('index.php?option=com_gazebos&view=type&id=' . $r->type_id)
				);

				$crumbs[] = (object) array(
					'name' => $r->material_title,
					'link' => JRoute::_('index.php?option=com_gazebos&view=material&id=' . $r->material_id)
				);

				$crumbs[] = (object) array(
					'name' => $r->shape_title,
					'link' => JRoute::_('index.php?option=com_gazebos&view=shape&id=' . $r->shape_id . '&material_id=' . $r->material_id)
				);

				$crumbs[] = (object) array(
					'name' => $r->style_title,
					'link' => JRoute::_('index.php?option=com_gazebos&view=product&id=' . $r->product_id)
				);
				break;
			case 'size':
				$q = 'SELECT' .
					' a.size  AS size_title, a.id AS size_id,' .
					' b.title AS product_title, b.id AS product_id,' .
					' c.title AS material_title, c.id AS material_id,' .
					' d.title AS shape_title, d.id AS shape_id,' .
					' e.title AS type_title, e.id AS type_id,' .
					' f.title AS style_title, f.id AS style_id' .
					' FROM #__gazebos_sizes AS a' .
					' LEFT JOIN #__gazebos_products AS b ON b.id = a.product_id' .
					' LEFT JOIN #__gazebos_materials AS c ON c.id = b.material_id' .
					' LEFT JOIN #__gazebos_shapes AS d ON d.id = b.shape_id' .
					' LEFT JOIN #__gazebos_types AS e ON e.id = b.type_id' .
					' LEFT JOIN #__gazebos_styles AS f ON f.id = b.style_id' .
					' WHERE a.id = ' . (int) $id;
		
				$r = JFactory::getDbo()->setQuery($q)->loadObject();

				$crumbs[] = (object) array(
					'name' => $r->type_title,
					'link' => JRoute::_('index.php?option=com_gazebos&view=type&id=' . $r->type_id)
				);

				$crumbs[] = (object) array(
					'name' => $r->material_title,
					'link' => JRoute::_('index.php?option=com_gazebos&view=material&id=' . $r->material_id)
				);

				$crumbs[] = (object) array(
					'name' => $r->shape_title,
					'link' => JRoute::_('index.php?option=com_gazebos&view=shape&id=' . $r->shape_id . '&material_id=' . $r->material_id)
				);

				$crumbs[] = (object) array(
					'name' => $r->style_title,
					'link' => JRoute::_('index.php?option=com_gazebos&view=product&id=' . $r->product_id)
				);

				$crumbs[] = (object) array(
					'name' => $r->size_title,
					'link' => JRoute::_('index.php?option=com_gazebos&view=size&id=' . $r->size_id)
				);
				break;
		}

		if ($layout !== 'default')
		{
			$link = "index.php?option=com_gazebos&view={$view}&layout={$layout}";

			if (!empty($id))
			{
				$link .= '&id=' . $id;
			}

			$crumbs[] = (object) array(
				'name' => (self::$layoutTitleMap[$layout]) ? self::$layoutTitleMap[$layout] : ucfirst($layout),
				'link' => JRoute::_($link)
			);
		}

		return $crumbs;
	}

	/**
	 * Set the breadcrumbs separator for the breadcrumbs display.
	 *
	 * @param	string	$custom	Custom xhtml complient string to separate the
	 * items of the breadcrumbs
	 * @return	string	Separator string
	 * @since	1.5
	 */
	public static function setSeparator($custom = null)
	{
		$lang = JFactory::getLanguage();

		// If a custom separator has not been provided we try to load a template
		// specific one first, and if that is not present we load the default separator
		if ($custom == null) {
			if ($lang->isRTL()){
				$_separator = JHtml::_('image', 'system/arrow_rtl.png', NULL, NULL, true);
			}
			else{
				$_separator = JHtml::_('image', 'system/arrow.png', NULL, NULL, true);
			}
		} else {
			$_separator = $custom;
		}

		return $_separator;
	}
}
