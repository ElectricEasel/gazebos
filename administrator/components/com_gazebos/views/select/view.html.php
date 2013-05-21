<?php
/**
 * @version     1.0.0
 * @package     com_gazebos
 * @copyright   Copyright (C) 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Don Gilbert <don@electriceasel.com> - http://www.electriceasel.com
 */
defined('_JEXEC') or die;

class GazebosViewSelect extends EEViewAdminItem
{
	protected $useUniversalViews = false;

	public function display($tpl = null)
	{
		$this->editView = JFactory::getApplication()->input->get->get('editView', 'product');

		parent::display($tpl);
	}
}