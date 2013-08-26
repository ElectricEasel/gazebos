<?php
// namespace components\com_jmap;
/**
 * Entrypoint dell'application di backend
 *
 * @package JMAP::components::com_jmap
 * @author Joomla! Extensions Store
 * @copyright (C) 2013 - Joomla! Extensions Store
 * @license GNU/GPLv2 http://www.gnu.org/licenses/gpl-2.0.html  
 */
defined ( '_JEXEC' ) or die ( 'Restricted access' );
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 0);
ini_set('pcre.backtrack_limit', -1);
ini_set('display_errors', 0);
ini_set('error_reporting', E_ERROR);

/*
 * Tutta la logica è basata su controller.task core MVC execute
 * Si effettua l'override sul funzionamento errato Joomla nativa 
 * view base anzichè task based
 */
$controller_command = JRequest::getCmd ( 'task', 'sitemap.display' );
list ( $controller_name, $controller_task ) = explode ( '.', $controller_command );

// Defaults
if (! $controller_name) {
	$controller_name = 'cpanel';
}
if (! $controller_task) {
	$controller_task = 'display';
}

$basepath = JPATH_COMPONENT_ADMINISTRATOR . DS . 'controllers' . DS . 'jmapcontroller.php';
require_once $basepath;
$path = JPATH_COMPONENT . DS . 'controllers' . DS . strtolower($controller_name) . '.php';
if (file_exists ( $path )) {
	require_once $path;
} else {
	JError::raiseWarning ( 500, JText::_('ERROR_NO_CONTROLLER_FILE') );
}

// Create the controller
$classname = 'JMapController' . ucfirst ( $controller_name );
if (class_exists ( $classname )) {
	$controller = new $classname ();
	// Perform the Request task
	$controller->execute ( $controller_task );
	
	// Redirect if set by the controller
	$controller->redirect ();
} else {
	JError::raiseWarning ( 500, JText::_('ERROR_NO_CONTROLLER') );
} 