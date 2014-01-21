<?php
/**
 * @version     1.0.0
 * @package     com_gazebos
 * @copyright   Copyright (C) 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Don Gilbert <don@electriceasel.com> - http://www.electriceasel.com
 */
defined('_JEXEC') or die;

class GazebosModelSize extends EEModelItem
{
	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @since 1.6
	 */
	protected function populateState()
	{
		parent::populateState();

		$app = JFactory::getApplication();

		$size = $app->input->getInt('id');
		$this->setState('size.id', $size);
	}

	/**
	 * Method to get an ojbect.
	 *
	 * @param integer The id of the object to get.
	 *
	 * @return mixed Object on success, false on failure.
	 */
	public function getItem($id = null)
	{
		if (!isset($this->item))
		{
			$this->item = parent::getItem();

			if (empty($this->item))
			{
				JFactory::getApplication()->setError('Product type not found.');
			}
			else
			{
				$model = new GazebosModelProduct;

				// Get the product attributes from the product,
				// model, instead of duplicating code.
				$model->getAttributes($this->item);
				$this->item->gallery = $model->getGallery($this->item);
			}
		}

		return $this->item;
	}

	public function buildQuery()
	{
		return $this
			->getDbo()
			->getQuery(true)
			->select('a.*, b.*, c.title AS type_title')
			->from('#__gazebos_sizes AS a')
			->leftJoin('#__gazebos_products AS b ON b.id = a.product_id')
			->leftJoin('#__gazebos_types AS c ON c.id = b.type_id')
			->where('a.id = ' . (int) $this->getState('size.id'));
	}

	public function getForm()
	{
		JForm::addFormPath(JPATH_COMPONENT . '/model/forms');
		JForm::addFieldPath(JPATH_COMPONENT . '/model/fields');
		$form = JForm::getInstance('com_gazebos.sizequote', 'sizequote', array('control' => 'jform', 'loadData' => true));
		$data = $this->getItem();

		$this->preprocessForm($form, $data);

		$form->bind($data);

		return $form;
	}

	public function getTable()
	{
		return new GazebosTableLeads;
	}

	/**
	 * Handle frontend submissions.
	 *
	 * @return  integer  Success or failure level
	 */
	public function submitForm($data = array())
	{
		$table	= $this->getTable();

		if ($this->validate($this->getForm(), $data))
		{
			$table->bind($data);
		
			if ($table->store(false))
			{
				return EE_NO_ERROR;
			}

			return EE_TABLE_ERROR;
		}

		return EE_FORM_VALIDATION_FAILED;
	}

	public function preprocessForm(JForm $form, &$data)
	{
		$app = JFactory::getApplication();

		if (is_object($data))
		{
			$data->size_interested_in = $data->size;
			$data->size_id = $app->input->getInt('id');
			$data->comments = sprintf('I am interested in the %s, and would like some additional information.', $data->title);
		}
	}

	/**
	 * Method to validate the form data.
	 *
	 * @param   JForm   $form   The form to validate against.
	 * @param   array   $data   The data to validate.
	 * @param   string  $group  The name of the field group to validate.
	 *
	 * @return  mixed  Array of filtered data if valid, false otherwise.
	 *
	 * @see     JFormRule
	 * @see     JFilterInput
	 * @since   11.1
	 */
	public function validate($form, $data, $group = null)
	{
		// Filter and validate the form data.
		$data = $form->filter($data);
		$return = $form->validate($data, $group);

		// Check for an error.
		if ($return instanceof Exception)
		{
			$this->setError($return->getMessage());
			return false;
		}

		// Check the validation results.
		if ($return === false)
		{
			// Get the validation messages from the form.
			foreach ($form->getErrors() as $message)
			{
				$this->setError(JText::_($message));
			}

			return false;
		}

		return $data;
	}

	public function sendMailAdmin($data = array())
	{
		$mailer = JFactory::getMailer();

		$mailer
			->setSender($data['email'])
			->addRecipient(GazebosHelper::getParam('contact_email', 'info@gazebos.com'))
			->addBcc('gazebos@electriceasel.com')
			->setSubject('Gazebos.com Quote Form')
			->setBody(GazebosHelper::formatDataForEmail($data, $this->getForm()))
			->IsHTML(true);

		return $mailer->Send();
	}

	public function sendMailUser($data = array())
	{
		$mailer = JFactory::getMailer();
		$view = new EEViewEmail(array('layout' => 'reply'));

		$mailer
			->addRecipient($data['email'])
			->addAttachment(JPATH_BASE . '/media/pdf/GazebosInfoPacket.pdf')
			->setSubject('Thanks for contacting Gazebos.com!')
			->setBody($view->render())
			->IsHTML(true);

		return $mailer->Send();
	}
}
