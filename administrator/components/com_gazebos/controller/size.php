<?php
/**
 * @version     1.0.0
 * @package     com_gazebos
 * @copyright   Copyright (C) 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Don Gilbert <don@electriceasel.com> - http://www.electriceasel.com
 */
defined('_JEXEC') or die;

class GazebosControllerSize extends EEControllerForm
{
	protected $view_list = 'size';

	protected function getRedirectToItemAppend($recordId = null, $urlVar = 'id')
	{
		$app    = JFactory::getApplication();
		$tmpl   = $app->input->get('tmpl');
		$layout = $app->input->get('layout', 'edit');
		$jform  = $app->input->get('jform', array(), null);
		$id     = $app->input->getInt('id');

		if ($product_id = $app->input->get->getInt('product_id'))
		{
			$jform['product_id'] = $product_id;
		}

		$append = '';

		// Setup redirect info.
		if ($tmpl)
		{
			$append .= '&tmpl=' . $tmpl;
		}

		if ($layout)
		{
			$append .= '&layout=' . $layout;
		}

		if ($recordId && ($tmpl != 'component'))
		{
			$append .= '&' . $urlVar . '=' . $recordId;
		}

		if (isset($jform['product_id']))
		{
			$append .= '&product_id=' . $jform['product_id'];
		}

		if (isset($id))
		{
			$append .= '&id=' . $id;
		}

		return $append;
	}

}
