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

// no direct access
defined('_JEXEC') or die('Restricted access');

// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_sh404sef'))
{
	return '';
}

// check in case sh404sef system plugin has been disabled
if (!class_exists('Sh404sefHelperUpdates'))
{
	return '';
}

// define path to sh404SEF front and backend dirs
require_once JPATH_ROOT . '/administrator/components/com_sh404sef/defines.php';

if (version_compare(JVERSION, '3.0', 'ge'))
{
	$joomlaVersionPrefix = 'j3';
}
else
{
	$joomlaVersionPrefix = 'j2';
}
require JModuleHelper::getLayoutPath('mod_sh404sef_cpicon', 'default_' . $joomlaVersionPrefix);
