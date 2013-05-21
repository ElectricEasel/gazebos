<?php
/**
 * @version     1.0.0
 * @package     com_gazebos
 * @copyright   Copyright (C) 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Don Gilbert <don@electriceasel.com> - http://www.electriceasel.com
 */
defined('_JEXEC') or die;

class GazebosModelSeries extends EEModelItem
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
	}

	/**
	 * Method to get an ojbect.
	 *
	 * @param integer The id of the object to get.
	 *
	 * @return mixed Object on success, false on failure.
	 */
	public function getItem()
	{
		if (!isset($this->item))
		{
			$this->item->gallery = $this->getGallery();
		}

		return $this->item;
	}

	protected function buildQuery()
	{
		return;
	}

	/**
	 * Get gallery images for the product.
	 *
	 * @param   integer  $id  The id of the product for which to retrieve the gallery.
	 *
	 * @return  array  An array of image objects for the product gallery.
	 */
	public function getGallery($item = null)
	{
		if ($item === null)
		{
			$item = $this->item;
		}

		$q = 'SELECT * FROM #__gazebos_gallery WHERE product_id = ' . $item->id . ' ORDER BY ordering ASC';

		$results = (array) $this->getDbo()->setQuery($q)->loadObjectList();

		foreach  ($results as $image)
		{
			$base = JPATH_BASE . "/media/com_gazebos/images/products/{$image->product_id}/";
			if (!file_exists($base . "thumbs/300x300_{$image->path}"))
			{
				EEImageHelper::setThumbSizes(array(
					JImage::CROP_RESIZE => array(
						'600x600',
						'300x300',
						'200x200',
						'150x150',
						'60x60'
					)
				));

				EEImageHelper::resizeImage($base, $image->path);
			}
		}

		return $results;
	}

	/**
	 * The remaining methods deal with form stuff.
	 */

	public function getForm()
	{
		JForm::addFormPath(JPATH_COMPONENT . '/model/forms');
		JForm::addFieldPath(JPATH_COMPONENT . '/model/fields');
		$form = JForm::getInstance('com_gazebos.seriesquote', 'seriesquote', array('control' => 'jform', 'loadData' => true));
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
			$data->comments = 'I am interested in some additional information.';
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
			->addRecipient(GazebosHelper::getParam('contact_email', 'gazebos@electriceasel.com'))
			->setSubject('Gazebos.com Series Quote Form')
			->setBody(EEHelper::formatDataForEmail($data, $this->getForm()))
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
