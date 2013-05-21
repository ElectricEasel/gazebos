<?php
/**
 * @version     1.0.0
 * @package     com_gazebos
 * @copyright   Copyright (C) 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Don Gilbert <don@electriceasel.com> - http://www.electriceasel.com
 */
defined('_JEXEC') or die;

/**
 * Options list controller class.
 */
class GazebosControllerOptions extends EEControllerAdmin
{
	/**
	 * Proxy for getModel.
	 * @since	1.6
	 */
	public function getModel($name = 'Option', $prefix = 'GazebosModel')
	{
		return parent::getModel($name, $prefix, array('ignore_request' => true));
	}

}
