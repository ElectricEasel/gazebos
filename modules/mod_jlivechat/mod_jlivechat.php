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
defined('_JEXEC') or die('Restricted access');

// Include the syndicate functions only once
require_once dirname(__FILE__).DS.'helper.php';

jimport('joomla.application.helper');
jimport('joomla.application.module.helper');
jimport('joomla.application.component.model');

$comPath = JApplicationHelper::getPath('front', 'com_jlivechat');

if(file_exists($comPath))
{
    JModel::addIncludePath(dirname($comPath).DS.'models');

    require JModuleHelper::getLayoutPath('mod_jlivechat');
}