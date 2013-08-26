<?php
// namespace administrator\components\com_jmap\views;
/**
 * @package JMAP::SOURCES::administrator::components::com_jmap
 * @subpackage views
 * @subpackage sources
 * @author Joomla! Extensions Store
 * @copyright (C) 2013 - Joomla! Extensions Store
 * @license GNU/GPLv2 http://www.gnu.org/licenses/gpl-2.0.html  
 */
defined ( '_JEXEC' ) or die ( 'Restricted access' );
jimport ( 'joomla.application.component.view' );
jimport ( 'joomla.html.pagination' );
 
/**
 * @package JMAP::SOURCES::administrator::components::com_jmap
 * @subpackage views
 * @subpackage sources
 */
class JMapViewSources extends JView {
	/**
	 * Inietta le costanti lingua nel JS Domain con il solito name mapping
	 * @access protected
	 * @param $translations Object&
	 * @param $document Object&
	 * @return void
	 */
	protected function injectJsTranslations(&$translations, &$document) {
		$jsInject = null;
 		// Do translations
		foreach ( $translations as $translation ) {
			$jsTranslation = strtoupper ( $translation );
			$translated = JText::_( $jsTranslation );
			$jsInject .= <<<JS
				jmap$translation = '{$translated}'; 
JS;
		}
		$document->addScriptDeclaration($jsInject);
	}
	
	/**
	 * Add the page title and toolbar.
	 *
	 * @since	1.6
	 */
	protected function addEditEntityToolbar() {
		$user		= JFactory::getUser();
		$userId		= $user->get('id');
		$isNew		= ($this->record->id == 0);
		$checkedOut	= !($this->record->checked_out == 0 || $this->record->checked_out == $userId);
		
		$doc = JFactory::getDocument();
		$doc->addStyleDeclaration('.icon-48-jmap{background-image:url("components/com_jmap/images/jmap-48x48.png")}');
		JToolBarHelper::title( JText::_( 'SITEMAP_DATA_EDIT' ), 'jmap' );
		
		if ($isNew)  {
			// For new records, check the create permission.
			if ($isNew && ($user->authorise('core.create', 'com_jmap'))) {
				JToolBarHelper::apply( 'sources.applyEntity', 'JAPPLY');
				JToolBarHelper::save( 'sources.saveEntity', 'JSAVE');
			}
		} else {
			// Can't save the record if it's checked out.
			if (!$checkedOut) {
				// Since it's an existing record, check the edit permission, or fall back to edit own if the owner.
				if ($user->authorise('core.edit', 'com_jmap')) {
					JToolBarHelper::apply( 'sources.applyEntity', 'JAPPLY');
					JToolBarHelper::save( 'sources.saveEntity', 'JSAVE');
				}
			}
		}
		 
		JToolBarHelper::custom('sources.cancelEntity', 'cancel', 'cancel', 'JCANCEL', false);
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
		
		$user = JFactory::getUser();
		JToolBarHelper::title( JText::_( 'SITEMAP_DATA' ), 'jmap' );
		// Access check.
		if ($user->authorise('core.create', 'com_jmap')) {
			JToolBarHelper::addNew('sources.editentity', 'NEW_SOURCE');
		} 
		
		if ($user->authorise('core.edit', 'com_jmap')) {
			JToolBarHelper::editListX('sources.editentity', 'EDIT_SOURCE');
		}
		
		JToolBarHelper::customX( 'sources.copyEntity', 'copy.png', 'copy_f2.png', 'Duplicate' );
		
		if ($user->authorise('core.delete', 'com_jmap') && $user->authorise('core.edit', 'com_jmap')) {
			JToolBarHelper::deleteListX(JText::_('DELETE_SOURCE'), 'sources.deleteentity');
		}
		 
		JToolBarHelper::custom('cpanel.display', 'config', 'config', 'CPANEL', false);
	}
	
	/**
	 * Default display listEntities
	 *        	
	 * @return void
	 *
	 */
	function display($tpl = null) {
		// Get main records
		$rows = $this->get ( 'Data' );
		$lists = $this->get ( 'Filters' );
		$total = $this->get ( 'Total' );
		
		$doc = JFactory::getDocument();
		$doc->addScript ( JURI::root ( true ) . '/components/com_jmap/js/jquery.js' );
		$doc->addScriptDeclaration("function checkAll(n) {
				var form = jQuery('#adminForm');
				var checkItems = jQuery('input[type=checkbox][data-enabled!=false][name!=toggle]', form);
				if(!jQuery('input[type=checkbox][name=toggle]').prop('checked')) {
					jQuery(checkItems).prop('checked', false);
					jQuery('input[name=boxchecked]', form).val(0);
				} else {
					jQuery(checkItems).prop('checked', true);
					if(checkItems.length) {jQuery('input[name=boxchecked]', form).val(checkItems.length)};
				}
				
		}");
		
		$orders = array ();
		$orders ['order'] = $this->getModel ()->getState ( 'order' );
		$orders ['order_Dir'] = $this->getModel ()->getState ( 'order_dir' );
		// Pagination view object model state populated
		$pagination = new JPagination ( $total, $this->getModel ()->getState ( 'limitstart' ), $this->getModel ()->getState ( 'limit' ) );
		
		$this->assign ( 'user', JFactory::getUser () );
		$this->assignRef ( 'pagination', $pagination );
		$this->assign ( 'searchword', $this->getModel ()->getState ( 'searchword' ) );
		$this->assignRef ( 'lists', $lists );
		$this->assignRef ( 'orders', $orders );
		$this->assignRef ( 'items', $rows );
		$this->assign( 'option', $this->getModel ()->getState ( 'option' ) );

		// Aggiunta toolbar
		$this->addDisplayToolbar();
		
		parent::display ( 'list' );
	}
	
	/**
	 * Edit screen for a view or .
	 * ..
	 *
	 * @param
	 *        	object the item to edit
	 * @param
	 *        	array select lists, radio button, ...
	 * @param
	 *        	object parameters for the item
	 *        	
	 * @return void
	 */
	function editEntity(&$row) {
		JHTML::_ ( 'behavior.tooltip' );
		$doc = JFactory::getDocument();
		
		// Inject js translations
		$translations = array('selectfield');
		$this->injectJsTranslations($translations, $doc);
		
		$doc->addStylesheet ( JURI::root ( true ) . '/administrator/components/com_jmap/css/generic.css' );
		$doc->addStylesheet ( JURI::root ( true ) . '/administrator/components/com_jmap/css/simplevalidation.css' );
		$doc->addStylesheet ( JURI::root ( true ) . '/administrator/components/com_jmap/css/jqueryui/jquery.ui.all.css' );
		
		$doc->addScript ( JURI::root ( true ) . '/components/com_jmap/js/jquery.js' );
		$doc->addScript ( JURI::root ( true ) . '/administrator/components/com_jmap/js/classjquery.js' );
		$doc->addScript ( JURI::root ( true ) . '/administrator/components/com_jmap/js/jquery-ui.min.js' );
		$doc->addScript ( JURI::root ( true ) . '/administrator/components/com_jmap/js/jquery.simplevalidation.js' );
		$doc->addScript ( JURI::root ( true ) . '/administrator/components/com_jmap/js/editsources.js' );
		$doc->addScriptDeclaration("
					jQuery(function(){
						jQuery('#adminForm').validation();
					});
					Joomla.submitbutton = function(pressbutton) {
						if (pressbutton == 'sources.cancelEntity') {	
							Joomla.submitform( pressbutton );
							return true;
						}
						
						if(jQuery('#adminForm').validate()) {
							Joomla.submitform( pressbutton );
							return true;
						}
						return false;
					}
				");
		
		$lists = $this->getModel()->getLists($row);
		$this->assign ( 'option', $this->getModel ()->getState ( 'option' ) );
		$this->assignRef ( 'record', $row );
		$this->assignRef ( 'lists', $lists );
		$this->assign ( 'user', JFactory::getUser());
		
		// Aggiunta toolbar
		$this->addEditEntityToolbar();
		
		parent::display ( 'edit' );
	}
}