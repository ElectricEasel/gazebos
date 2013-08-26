<?php
// namespace components\com_jmap\views;
/**
 * @package JMAP::SITEMAP::components::com_jmap
 * @subpackage views
 * @author Joomla! Extensions Store
 * @copyright (C) 2013 - Joomla! Extensions Store
 * @license GNU/GPLv2 http://www.gnu.org/licenses/gpl-2.0.html
 */
defined ( '_JEXEC' ) or die ( 'Restricted access' );
jimport ( 'joomla.application.component.view' );

/**
 * Main view class
 *
 * @package JMAP::SITEMAP::components::com_jmap
 * @subpackage views
 */
class JMapViewSitemap extends JView {
	/**
	 * Display the XML sitemap
	 * @access public
	 * @return void
	 */
	function display($tpl = null, $backend = false) {
		$document = JFactory::getDocument ();
		$document->setMimeEncoding('application/xml');
		
		$uriInstance = JURI::getInstance();
		$this->liveSite = rtrim($uriInstance->getScheme() . '://' . $uriInstance->getHost(), '/');
				 
		$this->data = &$this->get ( 'SitemapData' );
		$this->cparams = &$this->getModel ()->getState ( 'cparams' );
		$this->outputtedLinksBuffer = array();
		$this->setLayout('default');
		parent::display ('xml');
	}
}