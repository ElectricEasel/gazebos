<?php
/**
* @version 1.3.0
* @package RSform!Pro 1.3.0
* @copyright (C) 2007-2010 www.rsjoomla.com
* @license GPL, http://www.gnu.org/copyleft/gpl.html
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

// Check if the helper exists
jimport('joomla.filesystem.file');
$helper = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_rsform'.DS.'helpers'.DS.'rsform.php';
if (!JFile::exists($helper))
	return;

// Load Helper functions
require_once($helper);

// Params
$formId			 = (int) $params->def('formId', 1);
$moduleclass_sfx = $params->def('moduleclass_sfx', '');

$lang = JFactory::getLanguage();
$lang->load('com_rsform', JPATH_SITE);

// Display template
require(JModuleHelper::getLayoutPath('mod_rsform'));