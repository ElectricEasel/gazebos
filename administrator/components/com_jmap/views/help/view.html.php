<?php
// namespace administrator\components\com_jmap\views\help;
/**
 *
 * @package JMAP::HELP::administrator::components::com_jmap
 * @subpackage views
 * @subpackage help
 * @author Joomla! Extensions Store
 * @copyright (C) 2013 - Joomla! Extensions Store
 * @license GNU/GPLv2 http://www.gnu.org/licenses/gpl-2.0.html  
 */
defined ( '_JEXEC' ) or die ( 'Restricted access' );
jimport ( 'joomla.application.component.view' );

/**
 * CPanel view
 *
 * @package JMAP::HELP::administrator::components::com_jmap
 * @subpackage views
 * @subpackage help
 * @since 1.0
 */
class JMapViewHelp extends JView {
	/**
	 * Add the page title and toolbar.
	 *
	 * @since	1.6
	 */
	protected function addDisplayToolbar() {
		$doc = JFactory::getDocument();
		$doc->addStyleDeclaration('.icon-48-jmap{background-image:url("components/com_jmap/images/icon-48-help.png")}');
		$doc->addStyleDeclaration('.icon-32-config{background-image:url("components/com_jmap/images/icon-32-config.png")}');
		JToolBarHelper::title( JText::_( 'HELP' ), 'jmap' );
		JToolBarHelper::custom('cpanel.display', 'config', 'config', 'CPANEL', false);
	}
	
	/**
	 * Effettua il rendering del pannello di controllo
	 * @access public
	 * @return void
	 */
	public function display($tpl = null) {
		jimport ( 'joomla.html.pane' );
		$doc = JFactory::getDocument ();
		$doc->addStylesheet ( JURI::root ( true ) . '/administrator/components/com_jmap/css/help.css' );
	 
		$pane = JPane::getInstance ( 'sliders' );
		// Assign reference variables
		$this->assignRef ( 'pane', $pane ); 
		
		// Aggiunta toolbar
		$this->addDisplayToolbar();
		
		// Output del template
		parent::display ();
	}  
}