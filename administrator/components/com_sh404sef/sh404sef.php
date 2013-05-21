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

// sometimes users disable our plugin
if (!defined('SH404SEF_AUTOLOADER_LOADED'))
{
	echo 'sh404SEF system plugin has been disabled or has failed initializing. Please enable it again to use sh404SEF, with Joomla! <a href="index.php?option=com_plugins">plugin manager</a>';
	return;
}

// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_sh404sef'))
{
	return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
}

// load base class file (functions, not autolaoded
if (!defined('SH404SEF_BASE_CLASS_LOADED'))
{
	$baseClassFile = JPATH_ADMINISTRATOR . '/components/com_sh404sef/sh404sef.class.php';
	if (is_readable($baseClassFile))
	{
		require_once($baseClassFile);
	}
	else
	{
		JError::RaiseError(500, JText::_('COM_SH404SEF_NOREAD') . "( $baseClassFile )<br />" . JText::_('COM_SH404SEF_CHK_PERMS'));
	}
}

// Ensure the behavior is loaded
JHtml::_('behavior.framework');
if (version_compare(JVERSION, '3.0', 'ge'))
{
	JHtml::_('bootstrap.framework');
}

// find about specific controller requested
$cName = JFactory::getApplication()->input->getCmd('c');

// get controller from factory
$controller = Sh404sefFactory::getController($cName);

Sh404sefHelperHtml::addSubmenu(JFactory::getApplication()->input);
// read and execute task
$controller->execute(JFactory::getApplication()->input->getCmd('task'));
$controller->redirect();
