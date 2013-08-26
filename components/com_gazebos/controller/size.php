<?php
/**
 * @version     1.0.0
 * @package     com_gazebos
 * @copyright   Copyright (C) 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Don Gilbert <don@electriceasel.com> - http://www.electriceasel.com
 */
defined('_JEXEC') or die;

class GazebosControllerSize extends GazebosController
{
	/**
	 * Handle the form submission
	 *
	 */
	public function submit()
	{
		$app = JFactory::getApplication();
		$jform = $app->input->get('jform', array(), null);

		parent::submitForm('Size');
		
		$this->setRedirect('index.php?option=com_gazebos&view=size&layout=form&tmpl=component&id=' . $jform['size_id']);
	}
}
