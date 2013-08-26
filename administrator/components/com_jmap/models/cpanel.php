<?php
// namespace administrator\components\com_jmap\models;
/**
 * @package JMAP::CPANEL::administrator::components::com_jmap
 * @subpackage models
 * @author Joomla! Extensions Store
 * @copyright (C) 2013 - Joomla! Extensions Store
 * @license GNU/GPLv2 http://www.gnu.org/licenses/gpl-2.0.html  
 */
defined ( '_JEXEC' ) or die ( 'Restricted access' );
jimport ( 'joomla.application.component.model' );

/**
 * CPanel autorefresh menu responsibility
 *
 * @package JMAP::CPANEL::administrator::components::com_jmap
 * @subpackage models
 * @since 1.0
 */
interface ICPanelModel {
	/**
	 * Main get data method
	 *
	 * @access public
	 * @return array
	 */
	public function getData();
	
	/**
	 * Restituisce le select list usate dalla view per l'interfaccia
	 *
	 * @access public
	 * @param Object& $record
	 * @return array
	 */
	public function getLists();
	
	/**
	 * Recupera le images delle suggestions parsando il nome file
	 * e creando un array con nome/immagine da formattare direttamente nella view
	 * @access public
	 * @return Object[]
	*/
	public function getImagesArray();
}

/**
 * CPanel autorefresh menu responsibility
 *
 * @package JMAP::CPANEL::administrator::components::com_jmap
 * @subpackage models
 * @since 1.0
 */
interface ISyncMenu {
	/**
	 * Aggiorna i nuovi menu sources aggiunti in menu se non presenti come
	 * risorse sources in #__map
	 * 
	 * @access public
	 * @return boolean
	 */
	public function syncMenuSources();
}
 
/**
 * CPanel model concrete implementation
 *
 * @package JMAP::CPANEL::administrator::components::com_jmap
 * @subpackage models
 * @since 1.0
 */
class JMapModelCpanel extends JModel implements ISyncMenu {	  
	/**
	 * Costruzione list entities query
	 *
	 * @access private
	 * @param string $field
	 * @param string $value
	 * @return string
	 */
	private function buildListQuery($field, $value, $condition = ' = ') {
		//Dyna query
		$query = "SELECT COUNT(*)" . 
				 "\n FROM #__jmap AS s" . 
				 "\n WHERE " . $this->_db->nameQuote($field) . $condition . $this->_db->Quote($value);
		return $query;
	}

	/**
	 * Main get data method
	 *
	 * @access public
	 * @return array
	 */
	public function getData() {
		$result = array();
		// Build query
		$query = $this->buildListQuery ('published', 1);
		$this->_db->setQuery ( $query );
		$result['publishedDataSource'] = $this->_db->loadResult ();
		
		$query = $this->buildListQuery ('id', 0, ' > ');
		$this->_db->setQuery ( $query );
		$result['totalDataSource'] = $this->_db->loadResult ();
		
		$query = $this->buildListQuery ('type', 'menu');
		$this->_db->setQuery ( $query );
		$result['menuDataSource'] = $this->_db->loadResult ();
		
		$query = $this->buildListQuery ('type', 'user');
		$this->_db->setQuery ( $query );
		$result['userDataSource'] = $this->_db->loadResult ();
	
		return $result;
	}
	
	/**
	 * Restituisce le select list usate dalla view per l'interfaccia
	 *
	 * @access public
	 * @param Object& $record
	 * @return array
	 */
	public function getLists() {
		$lists = array();
	
		include_once JPATH_COMPONENT . '/elements/languages.php';
		$lists['languages'] = null;
		$languageOptions = JMapHTMLLanguages::getAvailableLanguageOptions();
	
		// Detect Joomla Language Filter plugin enabled
		$query = "SELECT " . $this->_db->nameQuote('enabled') .
				"\n FROM #__extensions" .
				"\n WHERE " . $this->_db->nameQuote('element') . " = " . $this->_db->Quote('languagefilter').
				 "\n OR " . $this->_db->nameQuote('element') . " = " . $this->_db->Quote('jfdatabase');
		$this->_db->setQuery($query);
		$languageFilterPluginEnabled = $this->_db->loadResult();
		if(count($languageOptions) > 2 && $languageFilterPluginEnabled) {
			$lists['languages']	= JHTML::_('select.genericlist',   $languageOptions, 'language_option', 'class="inputbox"', 'value', 'text', null, 'language_option' );
		}
	
		return $lists;
	}
	
	/**
	 * Recupera le images delle suggestions parsando il nome file
	 * e creando un array con nome/immagine da formattare direttamente nella view
	 * @access public
	 * @return Object[]
	 */
	public function getImagesArray() {
		$path = JPATH_COMPONENT_ADMINISTRATOR . '/images/suggestions';
		$images = array();
	
		$iterator = new DirectoryIterator ( $path );
		foreach ( $iterator as $fileEntity ) {
			$imageFileName = $fileEntity->getFilename();
			$imageName = current(explode('.', $imageFileName));
			// Processing underscore and upper case
			$imageName = ucfirst(str_replace('_', ' ', $imageName));
			if (! $fileEntity->isDot () && ! $fileEntity->isDir () && $imageFileName !== 'index.html') {
				$images[$imageName] = JURI::root() . 'administrator/components/com_jmap/images/suggestions/' . $imageFileName;
			}
		}
		ksort($images);
		return $images;
	}
		
	/**
	 * Aggiorna i nuovi menu sources aggiunti in menu se non presenti come
	 * risorse sources in #__map e elimina quelli in stato stale
	 * 
	 * @access public
	 * @return boolean
	 */
	public function syncMenuSources() {
		// 1) Seleziona i menu items in #__menu_types
		$query = "SELECT *" .
		 		  "\n FROM #__menu_types";
		$this->_db->setQuery($query);
		$currentMenus = $this->_db->loadObjectList('title');
		$numCurrentMenus = count($currentMenus); 
		 
		// 2) Seleziona tutte le sources di type=menu in #__jmap
		$query = "SELECT id, name" .
 				 "\n FROM #__jmap" .
		 		 "\n WHERE " .  $this->_db->NameQuote('type') . ' = ' . $this->_db->Quote('menu');
		$this->_db->setQuery($query);
		$currentMenuSources = $this->_db->loadObjectList('name');
		$numCurrentMenuSources = count($currentMenuSources);
		 
		try {
			// 3) Per differenze determina le sources mancanti o non più presenti
		 	if($numCurrentMenus > $numCurrentMenuSources) { // Sources da inserire
		 		// Se non esiste un array key con il name presente in #__menu_types
		 		$chunksQuery = array();
		 		foreach ($currentMenus as $key=>$menu) {
		 			if(!array_key_exists($menu->title, $currentMenuSources)) {
		 				$chunksQuery[] = "(" .
		 						$this->_db->Quote('menu') . ","  .
		 						$this->_db->Quote($menu->title) . ","  .
		 						$this->_db->Quote($menu->description) . ", 0, 1)";
		 	
		 			}
		 		}
		 		$sql = "INSERT INTO #__jmap (" .
		 				$this->_db->nameQuote('type') . ", " .
		 				$this->_db->nameQuote('name') . ", " .
		 				$this->_db->nameQuote('description') . ", " .
		 				$this->_db->nameQuote('published') . ", " .
		 				$this->_db->nameQuote('ordering') .
		 				") VALUES " . implode(",\n", $chunksQuery) .
		 				"\n ON DUPLICATE KEY UPDATE " .$this->_db->nameQuote('type') . " = " . $this->_db->Quote('menu');;
		 	
		 		$this->_db->setQuery($sql);
		 		if(!$this->_db->query()) {
		 			throw new Exception(JText::_('ERRORSYNC_INSERT'));
		 		}
					
					// Reorder post insert
				JTable::addIncludePath ( JPATH_ADMINISTRATOR . '/components/com_jmap/tables' );
				$table = &JTable::getInstance ( 'Sources', 'Table' );
				if (! $table->reorder ()) {
					throw new Exception (JText::_('ERRORSYNC_REORDER'));
				}
			} elseif($numCurrentMenus < $numCurrentMenuSources) { // Sources stale
				$implodedValidMenuSources = "'" . implode("','", array_keys($currentMenus)) . "'";
				$sql = "DELETE FROM #__jmap" .
					   "\n WHERE " .  $this->_db->NameQuote('type') . ' = ' . $this->_db->Quote('menu') .
					   "\n AND " .  $this->_db->NameQuote('name') . " NOT IN (" . $implodedValidMenuSources . ")";
				$this->_db->setQuery($sql);
				if(!$this->_db->query()) {
					throw new Exception(JText::_('ERRORSYNC_DELETE'));
				}
			} else { // Synced resources, controllo solo se il title/name unique p.key è cambiato
				$currentMenuKeys = @asort(array_keys($currentMenus), SORT_STRING);
				$currentMenuSourcesKeys = @asort(array_keys($currentMenuSources), SORT_STRING);
				// P.key variata, si necessita un update per il sync mantain 
				if($currentMenuKeys !== $currentMenuSourcesKeys) {
					$implodedValidMenuSources = "'" . implode("','", array_keys($currentMenus)) . "'";
					$sql = "DELETE FROM #__jmap" .
							"\n WHERE " .  $this->_db->NameQuote('type') . ' = ' . $this->_db->Quote('menu') .
							"\n AND " .  $this->_db->NameQuote('name') . " NOT IN (" . $implodedValidMenuSources . ")";
					$this->_db->setQuery($sql);
					if(!$this->_db->query()) {
						throw new Exception(JText::_('ERRORSYNC_DELETE'));
					}
					
					// Se non esiste un array key con il name presente in #__menu_types
					$chunksQuery = array();
					foreach ($currentMenus as $key=>$menu) {
						if(!array_key_exists($menu->title, $currentMenuSources)) {
							$chunksQuery[] = "(" .
									$this->_db->Quote('menu') . ","  .
									$this->_db->Quote($menu->title) . ","  .
									$this->_db->Quote($menu->description) . ", 0, 1)";
					
						}
					}
					$sql = "INSERT INTO #__jmap (" .
							$this->_db->nameQuote('type') . ", " .
							$this->_db->nameQuote('name') . ", " .
							$this->_db->nameQuote('description') . ", " .
							$this->_db->nameQuote('published') . ", " .
							$this->_db->nameQuote('ordering') .
							") VALUES " . implode(",\n", $chunksQuery) .
							"\n ON DUPLICATE KEY UPDATE " .$this->_db->nameQuote('type') . " = " . $this->_db->Quote('menu');;
					
					$this->_db->setQuery($sql);
					if(!$this->_db->query()) {
						throw new Exception(JText::_('ERRORSYNC_INSERT'));
					}
						
					// Reorder post insert
					JTable::addIncludePath ( JPATH_ADMINISTRATOR . '/components/com_jmap/tables' );
					$table = &JTable::getInstance ( 'Sources', 'Table' );
					if (! $table->reorder ()) {
						throw new Exception (JText::_('ERRORSYNC_REORDER'));
					}
				}
			}
		} catch ( Exception $e ) {
			switch ($e->getCode()) {
				default:
					JError::raiseNotice(100, $e->getMessage());
			}
			return false;
		}
		 
		return true;
	}	
}