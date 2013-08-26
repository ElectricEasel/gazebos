<?php
// namespace components\com_jmap\views\sitemap;
/**
 * @package JMAP::SITEMAP::components::com_jmap
 * @subpackage views
 * @subpackage sitemap
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
 * @subpackage sitemap
 */
class JMapViewSitemap extends JView {
	/**
	 * Display the sitemap
	 * @access public
	 * @return void
	 */
	public function display($tpl = null) {
		$app = JFactory::getApplication();
		$menu = $app->getMenu ();
		$document = JFactory::getDocument ();
		$this->menuname = $menu->getActive ();
		if (isset ( $this->menuname )) {
			$this->menuname = $this->menuname->title;
		}
		
		// Accordion della sitemap
		if($this->getModel ()->getState ( 'cparams' )->getValue('includejquery', 1)) {
			$document->addScript ( JURI::root(true) . '/components/com_jmap/js/jquery.js' );
		}
		$document->addScript ( JURI::root(true) . '/components/com_jmap/js/jquery.treeview.js' );
		$document->addStyleSheet ( JURI::root(true) . '/components/com_jmap/js/jquery.treeview.css' );
		
		// Inject JS domain vars
		$document->addScriptDeclaration("
					var jmapExpandAllTree = " . $this->getModel ()->getState ( 'cparams' )->getValue('show_expanded', 0) . ";
					var jmapExpandLocation = '" . $this->getModel ()->getState ( 'cparams' )->getValue('expand_location', 'location') . "';
				");
		$this->data = $this->get ( 'SitemapData' );
		$this->cparams = $this->getModel ()->getState ( 'cparams' );
		$uriInstance = JURI::getInstance();
		$this->liveSite = rtrim($uriInstance->getScheme() . '://' . $uriInstance->getHost(), '/');
	
		// Add meta info
		$this->_prepareDocument();

		parent::display($tpl);
	}

	/**
	 * Prepares the document
	 */
	protected function _prepareDocument() {
		$app = JFactory::getApplication();
		$document = JFactory::getDocument();
		$menus = $app->getMenu();
		$title = null;

		// Because the application sets a default page title,
		// we need to get it from the menu item itself
		$menu = $menus->getActive();
		if(is_null($menu)) {
			return;
		}
		
		$this->params = new JRegistry;
		$this->params->loadString($menu->params);

		$title = $this->params->get('page_title', 'Sitemap');
		$document->setTitle($title);

		if ($this->params->get('menu-meta_description')) {
			$document->setDescription($this->params->get('menu-meta_description'));
		}

		if ($this->params->get('menu-meta_keywords')) {
			$document->setMetadata('keywords', $this->params->get('menu-meta_keywords'));
		}

		if ($this->params->get('robots')) {
			$document->setMetadata('robots', $this->params->get('robots'));
		}
	}
}