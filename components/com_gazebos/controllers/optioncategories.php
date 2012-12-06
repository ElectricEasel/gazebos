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

require_once JPATH_COMPONENT.'/controller.php';

/**
 * Optioncategories list controller class.
 */
class GazebosControllerOptioncategories extends GazebosController
{
	/**
	 * Proxy for getModel.
	 * @since	1.6
	 */
	public function &getModel($name = 'Optioncategories', $prefix = 'GazebosModel')
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));
		return $model;
	}
}