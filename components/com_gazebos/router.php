<?php
/**
 * @version     1.0.0
 * @package     com_gazebos
 * @copyright   Copyright (C) 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Don Gilbert <don@electriceasel.com> - http://www.electriceasel.com
 */
defined('_JEXEC') or die;

JLoader::registerPrefix('Gazebos', dirname(__FILE__));

/**
 * @param array A named array
 * @return array
 */
function GazebosBuildRoute(&$query)
{
	$segments = array();

	if (isset($query['view']))
	{
		$segments[] = $query['view'];
	}

	if (isset($query['id']))
	{
		$segments[] = GazebosHelper::getAliasFromId($query['id'], $query['view']);
	}

	unset($query['id']);
	unset($query['view']);

	return $segments;
}

/**
 * @param array A named array
 * @param array
 *
 * Formats:
 *
 * index.php?/gazebos/task/id/Itemid
 *
 * index.php?/gazebos/id/Itemid
 */
function GazebosParseRoute($segments)
{
	$vars = array();

	// view is always the first element of the array
	$count = count($segments);

	if ($count)
	{
		$count--;
		$view = array_shift($segments);
		$vars['view'] = $view;
	}

	if ($count)
	{
		$count--;
		$alias = array_shift($segments) ;
		$vars['id'] = GazebosHelper::getIdFromAlias($alias, $view);
	}

	return $vars;
}
