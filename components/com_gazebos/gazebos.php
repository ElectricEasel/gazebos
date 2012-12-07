<?php
/**
 * @version     1.0.0
 * @package     com_gazebos
 * @copyright   Copyright (C) 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Don Gilbert <don@electriceasel.com> - http://www.electriceasel.com
 */

defined('_JEXEC') or die;

// Include dependancies
JFactory::getLanguage()->load('com_gazebos', JPATH_ADMINISTRATOR);

JLoader::import('helpers.gazebos', JPATH_COMPONENT);

// Execute the task.
$controller	= EEController::getInstance('Gazebos');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
