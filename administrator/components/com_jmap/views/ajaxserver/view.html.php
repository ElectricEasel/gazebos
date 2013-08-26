<?php 
// namespace administrator\components\com_jmap\views\ajaxserver;

/**
 * @author Joomla! Extensions Store
 * @package JMAP::AJAXSERVER::administrator::components::com_jmap 
 * @subpackage views
 * @subpackage ajaxserver
 * @copyright (C)2013 Joomla! Extensions Store
 * @license GNU/GPLv2 http://www.gnu.org/licenses/gpl-2.0.html  
 */
defined ( '_JEXEC' ) or die ( 'Restricted access' );
jimport ( 'joomla.application.component.view' );

/**
 * Config view
 *
 * @package JMAP::AJAXSERVER::administrator::components::com_jmap
 * @subpackage views
 * @subpackage ajaxserver
 * @since 1.0
 */
class JMapViewAjaxserver extends JView {

	/**
	 * Effettua il rendering dei tabs di configurazione del componente
	 * @access public
	 * @param Object&
	 * @return void
	 */
	public function display($userData = null) {
		header('Content-type: application/json');
		echo json_encode($userData);  
		
		exit();
	}
}