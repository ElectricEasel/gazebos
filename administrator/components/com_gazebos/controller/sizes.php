<?php
/**
 * @version     1.0.0
 * @package     com_gazebos
 * @copyright   Copyright (C) 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Don Gilbert <don@electriceasel.com> - http://www.electriceasel.com
 */
defined('_JEXEC') or die;

class GazebosControllerSizes extends EEControllerAdmin
{
	/**
	 * Proxy for getModel.
	 * @since	1.6
	 */
	public function getModel($name = 'Size', $prefix = 'GazebosModel')
	{
		return parent::getModel($name, $prefix, array('ignore_request' => true));
	}

	/**
	 * Run checkToken on the GET request, instead of POST
	 *
	 * @return  void
	 *
	 * @since   11.1
	 */
	public function delete()
	{
		// Check for request forgeries
		JSession::checkToken('get') or die(JText::_('JINVALID_TOKEN'));

		$app = JFactory::getApplication();
		$id  = $app->input->get->getInt('id');
		$pid = $app->input->get->getInt('product_id');

		if (empty($id))
		{
			JError::raiseWarning(500, JText::_($this->text_prefix . '_NO_ITEM_SELECTED'));
		}
		else
		{
			// Get the model.
			$model = $this->getModel();

			// Remove the items.
			if ($model->delete($id))
			{
				$this->setMessage(JText::plural($this->text_prefix . '_N_ITEMS_DELETED', 1));
			}
			else
			{
				$this->setMessage($model->getError());
			}
		}

		$this->setRedirect(JRoute::_('index.php?option=com_gazebos&view=size&layout=edit&tmpl=component&product_id=' . $pid, false));
	}

}
