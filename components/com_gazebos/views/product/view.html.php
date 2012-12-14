<?php

/**
 * @version     1.0.0
 * @package     com_gazebos
 * @copyright   Copyright (C) 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Don Gilbert <don@electriceasel.com> - http://www.electriceasel.com
 */
// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * View to edit
 */
class GazebosViewProduct extends JView
{
	protected $state;
	protected $item;
	protected $form;
	protected $params;

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
		$app = JFactory::getApplication();
		$user  = JFactory::getUser();

		$this->state = $this->get('State');
		$this->item = $this->get('Data');
		$this->params = $app->getParams('com_gazebos');

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			throw new Exception(implode("\n", $errors));
		}

		$this->prepareDocument();
		parent::display($tpl);
	}

	/**
	 * Prepares the document
	 */
	protected function prepareDocument()
	{
		$title = !empty($this->item->seo_title) ? $this->item->seo_title : $this->item->title;
		$this->document->setTitle($title);
		$this->document->setDescription($this->item->seo_description);
	}

}
