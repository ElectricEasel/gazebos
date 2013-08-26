<?php
// namespace components\com_jmap\controller;
/**
 * @package JMAP::SITEMAP::components::com_jmap
 * @subpackage controller
 * @author Joomla! Extensions Store
 * @copyright (C) 2013 - Joomla! Extensions Store
 * @license GNU/GPLv2 http://www.gnu.org/licenses/gpl-2.0.html
 */
defined ( '_JEXEC' ) or die ( 'Restricted access' );
jimport('joomla.application.component.controller');

/**
 * Main controller class
 *
 * @package JMAP::SITEMAP::components::com_jmap
 * @subpackage controller
 * @since 1.0
 */
class JMapControllerSitemap extends JMapController {
	/**
	 * Display the Sitemap
	 * @access public
	 * @return void
	 */
	public function display($cachable = false, $urlparams = false) {
		// load the model
		parent::display ();
	}
	
	/**
	 * Export XML sitemap file
	 * @access public
	 * @return void
	 */
	public function exportXML() {   
		// Get sitemap model and view core
		$sitemapView = $this->getView('Sitemap', 'xml');
		$sitemapModel = $this->getModel('Sitemap');
		$sitemapView->setModel($sitemapModel, true);
	 
		// Start XML buffer
		ob_start();
		$sitemapView->display('xml', true);
		$xmlSitemap = ob_get_contents();
		ob_end_clean();
	 
		if(!$sitemapModel->exportXMLSitemap($xmlSitemap)) {
			$msg = 'ERROR_EXPORTING_SITEMAP';
			$option = JRequest::getVar('option');
			$this->setRedirect ( "index.php?option=$option&task=sitemap.display", JTEXT::_($msg));
		}
	}
	
	/**
	 * Class Constructor
	 * @access public
	 * @return Object&
	 */
	public function __construct($config = array()) {
		parent::__construct ( $config );
		$this->registerTask ( 'view', 'display' );
	}
}