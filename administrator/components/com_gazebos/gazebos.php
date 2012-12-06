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

// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_gazebos')) 
{
	throw new Exception(JText::_('JERROR_ALERTNOAUTHOR'));
}

JFactory::getDocument()
	->addStylesheet('/administrator/components/com_gazebos/assets/css/gazebos.css');

$controller	= JControllerLegacy::getInstance('Gazebos');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
