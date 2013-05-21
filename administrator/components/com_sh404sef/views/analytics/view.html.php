<?php
/**
 * sh404SEF - SEO extension for Joomla!
 *
 * @author      Yannick Gaultier
 * @copyright   (c) Yannick Gaultier 2012
 * @package     sh404sef
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     4.1.0.1559
 * @date		2013-04-25
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC'))
	die('Direct Access to this location is not allowed.');

jimport('joomla.application.component.view');

class Sh404sefViewAnalytics extends ShlMvcView_Base
{
	public function display($tpl = null)
	{
		// version prefix
		$this->joomlaVersionPrefix = Sh404sefHelperGeneral::getJoomlaVersionPrefix();

		// prepare the view, based on request
		// do we force reading updates from server ?
		$options = Sh404sefHelperAnalytics::getRequestOptions();

		// push display options into template
		$this->assign('options', $options);

		// Get the JComponent instance of JToolBar
		$bar = JToolBar::getInstance('toolbar');

		if (version_compare(JVERSION, '3.0', 'ge'))
		{
			$document = JFactory::getDocument();

			// render submenu sidebar
			$this->sidebar = Sh404sefHelperHtml::renderSubmenu();

			// add custom css
			JHtml::styleSheet(Sh404sefHelperGeneral::getComponentUrl() . '/assets/css/' . $this->joomlaVersionPrefix . '_list.css');

			// add modal css and js
			ShlHtmlBs_helper::addBootstrapCss(JFactory::getDocument());
			ShlHtmlBs_helper::addBootstrapJs(JFactory::getDocument());

			// add title
			JToolbarHelper::title('sh404SEF: ' . JText::_('COM_SH404SEF_ANALYTICS_MANAGER'), 'sh404sef-toolbar-title');

			// needed javascript
			jimport('joomla.html.html.bootstrap');
			JHtml::_('formbehavior.chosen', 'select');

			// add Joomla calendar behavior, needed to input start and end dates
			if ($options['showFilters'] == 'yes')
			{
				JHTML::_('behavior.calendar');
			}

			// add quick control panel loader
			$js = 'jQuery(document).ready(function(){  shSetupAnalytics({report:" ' . $options['report'] . '"});});';
			$document = JFactory::getDocument();
			$document->addScriptDeclaration($js);
		}
		else
		{
			// add Joomla calendar behavior, needed to input start and end dates
			if ($options['showFilters'] == 'yes')
			{
				JHTML::_('behavior.calendar');
			}
			// add tooltips handler
			JHTML::_('behavior.tooltip');

			// add title
			$app = JFactory::getApplication();
			$title = Sh404sefHelperGeneral::makeToolbarTitle(JText::_('COM_SH404SEF_ANALYTICS_MANAGER'), $icon = 'sh404sef',
				$class = 'sh404sef-toolbar-title');
			JFactory::getApplication()->JComponentTitle = $title;

			// add quick control panel loader
			$js = 'window.addEvent(\'domready\', function(){  shSetupAnalytics({report:" ' . $options['report'] . '"});});';
			$document = JFactory::getDocument();
			$document->addScriptDeclaration($js);
		}

		// call methods to prepare display based on report type
		$method = '_makeView' . ucfirst($options['report']);
		if (is_callable(array($this, $method)))
		{
			$this->$method($tpl);
		}

		// add our javascript
		JHTML::script(Sh404sefHelperGeneral::getComponentUrl() . '/assets/js/' . $this->joomlaVersionPrefix . '_cp.js');

		// add our own css
		JHtml::styleSheet(Sh404sefHelperGeneral::getComponentUrl() . '/assets/css/' . $this->joomlaVersionPrefix . '_cp.css');

		// flag to know if we should display placeholder for ajax fillin
		$this->assign('isAjaxTemplate', true);

		parent::display($this->joomlaVersionPrefix);
	}

}
