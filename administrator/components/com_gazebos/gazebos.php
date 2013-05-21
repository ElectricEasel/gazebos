<?php
/**
 * @version     1.0.0
 * @package     com_gazebos
 * @copyright   Copyright (C) 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Don Gilbert <don@electriceasel.com> - http://www.electriceasel.com
 */
defined('_JEXEC') or die;

define('JIMAGE_MAX_UPLOAD_WIDTH', 600);

// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_gazebos')) 
{
	throw new Exception(JText::_('JERROR_ALERTNOAUTHOR'));
}
JFactory::getLanguage()->load('com_gazebos', JPATH_ADMINISTRATOR);
JFactory::getDocument()->addStylesheet('/administrator/components/com_gazebos/assets/css/gazebos.css');

JLoader::registerPrefix('Gazebos', JPATH_COMPONENT_ADMINISTRATOR);

EEController::getInstance('Gazebos')->run();