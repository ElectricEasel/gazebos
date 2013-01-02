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
class GazebosViewProductType extends JView
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
		$this->state = $this->get('State');
		$this->item = $this->get('Data');
		$this->params = EEComponentHelper::getParams('com_gazebos');
		$this->queryItems = $this->getQueryItems();

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			throw new Exception(implode("\n", $errors));
		}

		$this->_prepareDocument();

		parent::display($tpl);

		$app = JFactory::getApplication();

		if ($app->input->getBool('ajax') === true)
		{
			$app->close();
		}
	}

	/**
	 * Prepares the document
	 */
	protected function _prepareDocument()
	{
		$app = JFactory::getApplication();
		$menus = $app->getMenu();
		$title = null;

		// Because the application sets a default page title,
		// we need to get it from the menu item itself
		$menu = $menus->getActive();
		if ($menu)
		{
			$this->params->def('page_heading', $this->params->get('page_title', $menu->title));
		}
		else
		{
			$this->params->def('page_heading', JText::_('com_gazebos_DEFAULT_PAGE_TITLE'));
		}
		$title = $this->params->get('page_title', '');

		if (empty($title))
		{
			$title = $app->getCfg('sitename');
		}
		elseif ($app->getCfg('sitename_pagetitles', 0) == 1)
		{
			$title = JText::sprintf('JPAGETITLE', $app->getCfg('sitename'), $title);
		}
		elseif ($app->getCfg('sitename_pagetitles', 0) == 2)
		{
			$title = JText::sprintf('JPAGETITLE', $title, $app->getCfg('sitename'));
		}
		$this->document->setTitle($title);

		if ($this->params->get('menu-meta_description'))
		{
			$this->document->setDescription($this->params->get('menu-meta_description'));
		}

		if ($this->params->get('menu-meta_keywords'))
		{
			$this->document->setMetadata('keywords', $this->params->get('menu-meta_keywords'));
		}

		if ($this->params->get('robots'))
		{
			$this->document->setMetadata('robots', $this->params->get('robots'));
		}
	}

	private function getQueryItems()
	{
		JLoader::register('modProductSearchHelper', JPATH_SITE . '/modules/mod_product_search/helper.php');

		$type = $this->state->get('producttype.id');
		$context = 'product' . $type;

		$html = array();
		$filters = array(
			'material' => $this->state->get($context . 'filter.material', array()),
			'shape' => $this->state->get($context . 'filter.shape', array()),
			'style' => $this->state->get($context . 'filter.style', array()),
			'price' => $this->state->get($context . 'filter.price', array())
		);

		$html[] = '<ul>';

		foreach ($filters as $filter => $selected)
		{
			foreach ($selected as $item)
			{
				if ($item === '0') continue;

				$html[] = '<li class="removeFilter" title="Remove Filter" rel="#filter_';
				$html[] = $filter . $item;
				$html[] = '">';
				$html[] = '<span class="checkbox" style="background-position:0 -75px"></span>';
				$html[] = modProductSearchHelper::getFilterName($item, $filter);
				$html[] = '</li>';
			}
		}

		$html[] = '</ul>';

		return implode($html);
	}
}
