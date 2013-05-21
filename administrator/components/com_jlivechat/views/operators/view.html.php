<?php
/**
 * @package JLive! Chat
 * @version 4.3.2
 * @copyright (C) Copyright 2008-2010 CMS Fruit, CMSFruit.com. All rights reserved.
 * @license GNU/LGPL http://www.gnu.org/licenses/lgpl-3.0.txt

 This program is free software; you can redistribute it and/or modify
 it under the terms of the GNU Lesser General Public License as published by
 the Free Software Foundation; either version 3 of the License, or (at your
 option) any later version.

 This program is distributed in the hope that it will be useful, but
 WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY
 or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU Lesser General Public
 License for more details.

 You should have received a copy of the GNU Lesser General Public License
 along with this program.  If not, see http://www.gnu.org/licenses/.
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.view');

class JLiveChatViewOperators extends JView
{
    function display($tpl = null)
    {
	$mainframe =& JFactory::getApplication();

	$settings =& JModel::getInstance('SettingAdmin', 'JLiveChatModel');
	$operators =& JModel::getInstance('OperatorAdmin', 'JLiveChatModel');
	$uri =& JFactory::getURI();

	$this->assignRef('settings', $settings);
	$this->assign('uri', $uri);
	$this->assign('departments', $operators->getDepartments());

	if(JRequest::getInt('operator_id', null, 'method'))
	{
	    $this->assign('operator', $operators->getOperator(JRequest::getInt('operator_id', null, 'method')));
	}

	$this->_addCss();
	$this->_addJs();

	parent::display($tpl);
    }

    function _addCss()
    {
	$document =& JFactory::getDocument();

	// Add YUI stuff
	$document->addStyleSheet('components/com_jlivechat/assets/css/fonts-min.css');
	$document->addStyleSheet('components/com_jlivechat/assets/css/paginator.css');
	$document->addStyleSheet('components/com_jlivechat/assets/css/datatable.css');
	$document->addStyleSheet('components/com_jlivechat/assets/css/tabview.css');
	$document->addStyleSheet('components/com_jlivechat/assets/css/menu.css');
	$document->addStyleSheet('components/com_jlivechat/assets/css/button.css');
	$document->addStyleSheet('components/com_jlivechat/assets/css/autocomplete.css');

	$document->addStyleSheet('components/com_jlivechat/assets/css/styles.css');
	$document->addStyleSheet('components/com_jlivechat/assets/css/operators.css');
    }

    function _addJs()
    {
	$document =& JFactory::getDocument();

	JHTML::_('behavior.mootools');
	JHTML::_('behavior.tooltip');

	// Add YUI stuff
	$document->addScript('components/com_jlivechat/js/yahoo-dom-event.js');
	$document->addScript('components/com_jlivechat/js/connection-min.js');
	$document->addScript('components/com_jlivechat/js/container_core-min.js');
	$document->addScript('components/com_jlivechat/js/json-min.js');
	$document->addScript('components/com_jlivechat/js/element-min.js');
	$document->addScript('components/com_jlivechat/js/paginator-min.js');
	$document->addScript('components/com_jlivechat/js/datasource-min.js');
	$document->addScript('components/com_jlivechat/js/datatable-min.js');
	$document->addScript('components/com_jlivechat/js/tabview-min.js');
	$document->addScript('components/com_jlivechat/js/menu-min.js');
	$document->addScript('components/com_jlivechat/js/button-min.js');
	$document->addScript('components/com_jlivechat/js/animation-min.js');
	$document->addScript('components/com_jlivechat/js/autocomplete-min.js');

	$document->addScript('components/com_jlivechat/js/jlivechat.js');
	$document->addScript('components/com_jlivechat/js/operators.js');
    }
}
