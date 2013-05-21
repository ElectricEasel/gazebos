#!/usr/bin/env php
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

// Set flag that this is a parent file
if(isset($_SERVER['REQUEST_METHOD']) || isset($_SERVER['HTTP_HOST'])) die('Access Denied');

ini_set('error_reporting', E_ALL & ~E_NOTICE);
ini_set('memory_limit', '100M');

set_time_limit(0);

define( '_JEXEC', 1 );

define( 'DS', DIRECTORY_SEPARATOR );

define('JPATH_BASE', realpath(dirname(__FILE__).DS.'..'.DS.'..'.DS) );

require_once JPATH_BASE .DS.'includes'.DS.'defines.php';
require_once JPATH_BASE .DS.'includes'.DS.'framework.php';

JDEBUG ? $_PROFILER->mark( 'afterLoad' ) : null;

/**
 * CREATE THE APPLICATION
 *
 * NOTE :
 */
$mainframe =& JFactory::getApplication('site');

/**
 * INITIALISE THE APPLICATION
 *
 * NOTE :
 */
// set the language
$mainframe->initialise();

jimport('joomla.application.component.model');

JModel::addIncludePath(JPATH_BASE.DS.'components'.DS.'com_jlivechat'.DS.'models');

$syncObj =& JModel::getInstance('Sync', 'JLiveChatModel');

$syncObj->startSyncPusher();
