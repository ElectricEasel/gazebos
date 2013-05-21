<?php
/**
 * @version     1.0.0
 * @package     com_gazebos
 * @copyright   Copyright (C) 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Don Gilbert <don@electriceasel.com> - http://www.electriceasel.com
 */
defined('_JEXEC') or die;

class GazebosViewStyles extends EEViewAdminList
{
	protected $singleItemView = 'style';
	protected $useUniversalViews = false;

	/**
	 * Add the page title and toolbar.
	 *
	 * @since 1.6
	 */
	protected function addToolbar()
	{
		$state = $this->get('State');
		$canDo = EEHelper::getActions($this->componentName);

		JToolBarHelper::title(JText::_($this->componentName . '_TITLE_' . $this->_name), 'optioncategories.png');

		//Check if the form exists before showing the add/edit buttons
		$formPath = JPATH_COMPONENT_ADMINISTRATOR . '/views/' . $this->singleItemView;

		if (file_exists($formPath))
		{
			if ($canDo->get('core.create'))
			{
				$addnew = 'index.php?option=com_gazebos&amp;view=select&amp;tmpl=component&amp;editView=' . $this->singleItemView;
				//JToolBarHelper::addNew($this->singleItemView . '.add', 'JTOOLBAR_NEW');
				JToolBar::getInstance('toolbar')->appendButton('Popup', 'new', 'JTOOLBAR_NEW', $addnew, 500, 300);
			}

			if ($canDo->get('core.edit') && isset($this->items[0]))
			{
				JToolBarHelper::editList($this->singleItemView . '.edit', 'JTOOLBAR_EDIT');
			}

		}

		if ($canDo->get('core.edit.state'))
		{
			if (isset($this->items[0]->state))
			{
				JToolBarHelper::divider();
				JToolBarHelper::custom($this->_name . '.publish', 'publish.png', 'publish_f2.png', 'JTOOLBAR_PUBLISH', true);
				JToolBarHelper::custom($this->_name . '.unpublish', 'unpublish.png', 'unpublish_f2.png', 'JTOOLBAR_UNPUBLISH', true);
			}
			elseif (isset($this->items[0]))
			{
				// If this component does not use state then show a direct delete button as we can not trash
				JToolBarHelper::deleteList('', $this->_name . '.delete', 'JTOOLBAR_DELETE');
			}

			if (isset($this->items[0]->state))
			{
				JToolBarHelper::divider();
				JToolBarHelper::archiveList($this->_name . '.archive', 'JTOOLBAR_ARCHIVE');
			}

			if (isset($this->items[0]->checked_out))
			{
				JToolBarHelper::custom($this->_name . '.checkin', 'checkin.png', 'checkin_f2.png', 'JTOOLBAR_CHECKIN', true);
			}
		}

		//Show trash and delete for components that uses the state field
		if (isset($this->items[0]->state))
		{
			if ($state->get('filter.state') == -2 && $canDo->get('core.delete'))
			{
				JToolBarHelper::deleteList('', $this->_name . '.delete', 'JTOOLBAR_EMPTY_TRASH');
				JToolBarHelper::divider();
			}
			elseif ($canDo->get('core.edit.state'))
			{
				JToolBarHelper::trash($this->_name . '.trash', 'JTOOLBAR_TRASH');
				JToolBarHelper::divider();
			}
		}

		if ($canDo->get('core.admin'))
		{
			JToolBarHelper::preferences($this->componentName);
		}
	}
}
