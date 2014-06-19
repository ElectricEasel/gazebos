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
	public function execute($task)
	{
		$app = JFactory::getApplication();
		$view = $app->input->get('view');
		$layout = $app->input->get('layout');

		if ($view === 'size' && $layout !== 'form')
		{
			$id = $app->input->getInt('id');
			$db = JFactory::getDbo();
			$query = $db->getQuery(true)
				->select('a.product_id')
				->from('#__gazebos_sizes AS a')
				->where('a.id = ' . $id);

			$product_id = $db->setQuery($query)->loadResult();

			$app->redirect(JRoute::_('index.php?option=com_gazebos&view=product&id=' . $product_id), null, null, true);
		}

		return parent::execute($task);
	}

	/**
	 * Handle the form submission from child classes
	 *
	 */
	protected function submitForm($name)
	{
		$app = JFactory::getApplication();
		$data = $app->input->get('jform', array(), 'array');

		if ($model = $this->getModel($name))
		{
			$status = $model->submitForm($data);
		}
		else
		{
			$status = EE_ERROR_UNKNOWN;
		}

		if ($status === EE_NO_ERROR)
		{
			$model->sendMailAdmin($data);
			$model->sendMailUser($data);
			$msg = 'Thank you for contacting us. We will be in touch with you soon.';
			$data['error'] = null;
			$this->setMessage($msg);
		}
		else
		{
			if ($status == EE_FORM_VALIDATION_FAILED)
			{
				$msg = $model->getError();
			}
			else
			{
				$msg = EEHelper::getErrorMsg($status);
			}
			$data['error'] = $msg;
			$this->setMessage($msg, 'error');
		}

		EEHelper::updateSessionData($data, $name);
	}
}
