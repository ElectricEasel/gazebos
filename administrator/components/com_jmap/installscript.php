<?php
//namespace administrator\components\com_jmap;
/**  
 * @package JMAP::administrator::components::com_jmap 
 * @author Joomla! Extensions Store
 * @copyright (C) 2013 - Joomla! Extensions Store
 * @license GNU/GPLv2 http://www.gnu.org/licenses/gpl-2.0.html   
 */
defined ( '_JEXEC' ) or die ( 'Restricted access' ); 
  
/** 
 * Script per i processi di install/update/uninstall del componente. Segue una convenzione di classe
 * @package JMAP::administrator::components::com_jmap  
 */
class com_jmapInstallerScript {
	/*
	 * The release value to be displayed and checked against throughout this file.
	 */
	private $release = '1.0';
	
	/*
	* Find mimimum required joomla version for this extension. It will be read from the version attribute (install tag) in the manifest file
	*/
	private $minimum_joomla_release = '1.6.0';
	
	/*
	 * $parent is the class calling this method.
	 * $type is the type of change (install, update or discover_install, not uninstall).
	 * preflight runs before anything else and while the extracted files are in the uploaded temp folder.
	 * If preflight returns false, Joomla will abort the update and undo everything already done.
	 */
	function preflight($type, $parent) {
	
	}
	
	/*
	 * $parent is the class calling this method.
	 * install runs after the database scripts are executed.
	 * If the extension is new, the install method is run.
	 * If install returns false, Joomla will abort the install and undo everything already done.
	 */
	function install($parent) {
		$database = JFactory::getDBO ();
		$lang = JFactory::getLanguage ();
		$lang->load ( 'com_jmap' );
		
		echo (JText::_('INSTALL_SUCCESS'));
		
		// Processing completo
		return true;
	}
	
	/*
	 * $parent is the class calling this method.
	 * update runs after the database scripts are executed.
	 * If the extension exists, then the update method is run.
	 * If this returns false, Joomla will abort the update and undo everything already done.
	 */
	function update($parent) {
		// Indifferentemente gestionamo l'installazione del plugin
		$this->install($parent);
	}
	
	/*
	 * $parent is the class calling this method.
	 * $type is the type of change (install, update or discover_install, not uninstall).
	 * postflight is run after the extension is registered in the database.
	 */
	function postflight($type, $parent) { 
		// define the following parameters only if it is an original install
		if ($type == 'install') {  
			
			// Preferences
			$params ['show_title'] = '1';
			$params ['headerlevel'] = '1';
			$params ['classdiv'] = 'sitemap';
			$params ['show_pagebreaks'] = '1';
			$params ['includejquery'] = '1'; 
 			$params ['opentarget'] = '_self';
			$params ['include_external_links'] = '1';
			
			// Sitemap aspect
			$params ['show_expanded'] = '0';
			$params ['expand_location'] = 'location';
			
			$this->setParams ( $params );   
		} 
	}
	
	/*
	 * $parent is the class calling this method
	 * uninstall runs before any other action is taken (file removal or database processing).
	 */
	function uninstall($parent) {
		$database = JFactory::getDBO ();
		$lang = JFactory::getLanguage();
		$lang->load('com_jmap');
		 
		echo JText::_ ( 'UNINSTALL_SUCCESS' );
		
		// Processing completo
		return true;
	}
	
	/*
	 * get a variable from the manifest file (actually, from the manifest cache).
	 */
	function getParam($name) {
		$db = JFactory::getDbo ();
		$db->setQuery ( 'SELECT manifest_cache FROM #__extensions WHERE name = "jmap"' );
		$manifest = json_decode ( $db->loadResult (), true );
		return $manifest [$name];
	}
	
	/*
	 * sets parameter values in the component's row of the extension table
	 */
	function setParams($param_array) {
		if (count ( $param_array ) > 0) { 
			$db = JFactory::getDbo (); 
			// store the combined new and existing values back as a JSON string
			$paramsString = json_encode ( $param_array );
			$db->setQuery ( 'UPDATE #__extensions SET params = ' . $db->quote ( $paramsString ) . ' WHERE name = "jmap"' );
			$db->query ();
		}
	}
}