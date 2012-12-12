<?php
/**
 * @version     1.0.0
 * @package     com_gazebos
 * @copyright   Copyright (C) 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Don Gilbert <don@electriceasel.com> - http://www.electriceasel.com
 */


// no direct access
defined('_JEXEC') or die;

define('JIMAGE_MAX_UPLOAD_WIDTH', 600);

// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_gazebos')) 
{
	throw new Exception(JText::_('JERROR_ALERTNOAUTHOR'));
}

JFactory::getDocument()->addStylesheet('/administrator/components/com_gazebos/assets/css/gazebos.css');

// Import required classes that don't properly autoload
jimport('joomla.database.table');
jimport('joomla.application.component.view');
jimport('joomla.application.component.model');
jimport('joomla.application.component.modelform');

JLoader::import('helpers.gazebos', JPATH_COMPONENT_ADMINISTRATOR);

JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR . '/tables');

$controller	= EEController::getInstance('Gazebos');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
