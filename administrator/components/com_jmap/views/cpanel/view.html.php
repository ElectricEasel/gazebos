<?php
// namespace administrator\components\com_jmap\views\cpanel;
/**
 * @package JMAP::CPANEL::administrator::components::com_jmap
 * @subpackage views
 * @subpackage cpanel
 * @author Joomla! Extensions Store
 * @copyright (C) 2013 - Joomla! Extensions Store
 * @license GNU/GPLv2 http://www.gnu.org/licenses/gpl-2.0.html  
 */
defined ( '_JEXEC' ) or die ( 'Restricted access' );
jimport ( 'joomla.application.component.view' );

/**
 * CPanel view
 *
 * @package JMAP::CPANEL::administrator::components::com_jmap
 * @subpackage views
 * @subpackage cpanel
 * @since 1.0
 */
class JMapViewCpanel extends JView {

	/**
	 * Renderizza l'iconset del cpanel
	 *
	 * @param $link string
	 * @param $image string
	 * @access private
	 * @return string
	 */
	private function getIcon($link, $image, $text, $target = '') {
		$mainframe = JFactory::getApplication ();
		$lang = JFactory::getLanguage ();
		?>
	<div style="float:<?php echo ($lang->isRTL()) ? 'right' : 'left'; ?>;">
		<div class="icon">
			<a <?php echo $target;?> href="<?php echo $link; ?>">
						<?php echo JHTML::_('image.site',  $image, '/components/com_jmap/images/', NULL, NULL, $text ); ?>
						<span><?php echo $text; ?></span>
			</a>
		</div>
	</div>
	<?php
		}
		
	/**
	 * Add the page title and toolbar.
	 *
	 * @since	1.6
	 */
	protected function addDisplayToolbar() {
		$doc = JFactory::getDocument();
		$doc->addStyleDeclaration('.icon-48-jmap{background-image:url("components/com_jmap/images/jmap-48x48.png")}');
		$doc->addStyleDeclaration('.icon-32-config{background-image:url("components/com_jmap/images/icon-32-config.png")}');
		JToolBarHelper::title( JText::_( 'CPANEL_TOOLBAR' ), 'jmap' );
		JToolBarHelper::custom('cpanel.display', 'config', 'config', 'CPANEL', false);
	}
	
	/**
	 * Effettua il rendering del pannello di controllo
	 * @access public
	 * @return void
	 */
	public function display($tpl = null) {
		jimport ( 'joomla.html.pane' );
		JHtml::_('behavior.tooltip');
		
		$doc = JFactory::getDocument ();
		$doc->addStylesheet ( JURI::root ( true ) . '/administrator/components/com_jmap/css/cpanel.css' );
		
		$doc->addScript ( JURI::root ( true ) . '/components/com_jmap/js/jquery.js' );
		$doc->addScript ( JURI::root ( true ) . '/administrator/components/com_jmap/js/classjquery.js' );
		$doc->addScript ( JURI::root ( true ) . '/administrator/components/com_jmap/js/cpanel.js' );
		
		$livesite =  substr_replace(JURI::root(), "", -1, 1);
		
		$user = JFactory::getUser();  
		
		$infoData = $this->get('Data');
		$lists = $this->get('Lists');
		// Buffer delle icons
		ob_start ();
		$this->getIcon ( 'index.php?option=com_jmap&task=sources.display', 'icon-48-data.png', JText::_ ( 'SITEMAP_SOURCES' ));
		$this->getIcon ( $livesite . '/index.php?option=com_jmap&view=sitemap', 'icon-48-html_sitemap.png', JText::_ ( 'SHOW_HTML_MAP' ), 'target="_blank"' );
		$this->getIcon ( $livesite . '/index.php?option=com_jmap&view=sitemap&format=xml', 'icon-48-xml_sitemap.png', JText::_ ( 'SHOW_XML_MAP' ), 'target="_blank"' );
		$this->getIcon ( $livesite . '/index.php?option=com_jmap&task=sitemap.exportxml', 'icon-48-xml_export.png', JText::_ ( 'EXPORT_XML_SITEMAP' ));
		// Access check.
		if ($user->authorise('core.admin', 'com_jmap')) {
			$this->getIcon ( 'index.php?option=com_jmap&task=config.display', 'icon-48-config.png', JText::_ ( 'CONFIG' ) );
		}
		$this->getIcon ( 'index.php?option=com_jmap&task=help.display', 'icon-48-help.png', JText::_ ( 'HELP' ) );
		$contents = ob_get_clean ();
		 
		$pane = JPane::getInstance ( 'sliders' );
		// Assign reference variables
		$this->assignRef ( 'icons', $contents );
		$this->assignRef ( 'pane', $pane ); 
		$this->assignRef ( 'livesite', $livesite );
		$this->assign ( 'componentParams', JComponentHelper::getParams('com_jmap') );
		$this->assignRef ( 'infodata', $infoData );
		$this->assignRef ( 'lists', $lists );
		
		// Aggiunta toolbar
		$this->addDisplayToolbar();
		
		// Output del template
		parent::display ();
	}
	
	/**
	 * Effettua il rendering delle suggestions nell'iframe preposto a partire da un
	 * images array di oggetti formato da immagine/nome title
	 * @access public
	 * @return void
	 */
	public function formatSuggestions() {
		$doc = JFactory::getDocument();
	
		$doc->addStylesheet ( JURI::root ( true ) . '/administrator/components/com_jmap/css/jqueryui/jquery.ui.all.css' );
	
		$doc->addScript ( JURI::root ( true ) . '/components/com_jmap/js/jquery.js' );
		$doc->addScript ( JURI::root ( true ) . '/administrator/components/com_jmap/js/jquery-ui.min.js' );
		$doc->addScriptDeclaration('jQuery(function($){$("#accordion_suggestions").accordion({collapsible: true, active: false, heightStyle: "content"});});');
		// Get model data
		$imagesArray = $this->get('ImagesArray');
	
		// Set layout
		$this->setLayout('default');
	
		// Assign reference variables
		$this->images = $imagesArray;
	
		// Format data
		parent::display ('suggestions');
	}
}