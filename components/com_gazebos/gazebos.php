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

EEHelper::registerViewClasses(array('product', 'type', 'shape'), 'Trailers');
JLoader::registerPrefix('Gazebos', dirname(__FILE__));
JLoader::register('GazebosTableLeads', JPATH_SITE . '/administrator/components/com_gazebos/table/leads.php');

EEController::getInstance('Gazebos')->run();
