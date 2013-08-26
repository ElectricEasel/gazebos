<?php
// namespace administrator\components\com_jmap\models;
/**
 * @package JMAP::SOURCES::administrator::components::com_jmap
 * @subpackage models
 * @author Joomla! Extensions Store
 * @copyright (C) 2013 - Joomla! Extensions Store
 * @license GNU/GPLv2 http://www.gnu.org/licenses/gpl-2.0.html
 */
defined ( '_JEXEC' ) or die ( 'Restricted access' );
jimport ( 'joomla.application.component.model' );

/**
 * Sources model responsibilities
 *
 * @package JMAP::SOURCES::administrator::components::com_jmap
 * @subpackage models
 * @since 1.0
 */
interface ISourcesModel {
	/**
	 * Main get data method
	 *
	 * @access public
	 * @return Object[]
	 */
	public function getData();
	
	/**
	 * Counter result set
	 *
	 * @access public
	 * @return int
	 */
	public function getTotal();
	
	/**
	 * Restituisce le select list usate per i listEntities filters
	 *
	 * @access public
	 * @return array
	 */
	public function getFilters();
	
	/**
	 * Restituisce le select list usate dalla view per l'interfaccia
	 *
	 * @access public
	 * @param Object& $record
	 * @return array
	 */
	public function getLists(&$record);
	
	/**
	 * Effettua il load dell'entity singola da orm table
	 * @access public
	 * @param int $id
	 * @return Object&
	 */
	public function loadEntity($id);
	
	/**
	 * Storing record tramite $table
	 * @access public
	 * @return mixed
	 */
	public function storeEntity($forceRegenerate = false);
	
	/**
	 * Cancel editing entity
	 *
	 * @param int $id
	 * @access public
	 * @return boolean
	 */
	public function cancelEntity($id);
	
	/**
	 * Delete entity
	 *
	 * @param array $ids
	 * @access public
	 * @return boolean
	 */
	public function deleteEntity($ids);
	
	/**
	 * Copy existing entity
	 *
	 * @param int $id
	 * @access public
	 * @return boolean
	 */
	public function copyEntity($ids);
	 
	/**
	 * Method to move
	 *
	 * @access public
	 * @param int $idEntity        	
	 * @param string $state        	
	 * @return boolean
	 */
	public function changeOrder($idEntity, $direction);
	
	/**
	 * Method to move and reorder
	 *
	 * @access public
	 * @return boolean on success
	 * @since 1.5
	 */
	function saveorder($cid = array(), $order); 
	
	/**
	 * Inserisce o elimina il record nella #__fbchat_agents
	 *
	 * @access public
	 * @param int $idEntity
	 * @param string $state
	 * @return boolean
	 */
	public function publishEntities($idEntity, $state);
	
	/**
	 * Inserisce o elimina il record nella #__fbchat_agents
	 *
	 * @access public
	 * @param int $idEntity
	 * @param string $state
	 * @return boolean
	 */
	public function regenerateRawSqlQuery();
}

/**
 * Sources model concrete implementation
 *
 * @package JMAP::SOURCES::administrator::components::com_jmap
 * @subpackage models
 * @since 1.0
 */
class JMapModelSources extends JModel implements ISourcesModel {
	/**
	 * Records query result set
	 *
	 * @access private
	 * @var Object[]
	 */
	private $records;
	
	/**
	 * Building della raw query a partire dai chunks query managed
	 *
	 * @access private
	 * @param string $chunksString
	 * @param Object& $tableObject
	 * @return boolean
	 */
	private function buildRawQuery($chunksString, &$tableObject) {
		if($chunksString) {
			$chunks = json_decode($chunksString);
		}
		
		if(is_object($chunks) && count($chunks)) {
			// Required fields 
			$asTitleField = $chunks->titlefield_as ? " AS " . $this->_db->nameQuote($chunks->titlefield_as) : null;
			$titleField = "\n " . $this->_db->nameQuote($chunks->titlefield) . $asTitleField;
			
			$asIdField = $chunks->idfield_as ? " AS " . $this->_db->nameQuote($chunks->idfield_as) : null;
			$idField = ", \n " . $this->_db->nameQuote($chunks->id) . $asIdField;
			
			// Optional fields
			if($chunks->catid) {
				$asCatidField = $chunks->catidfield_as ? " AS " . $this->_db->nameQuote($chunks->catidfield_as) : null;
				$catidField = ", \n " . $this->_db->nameQuote($chunks->catid) . $asCatidField;
			}
			
			// Additional fields conversion
			$additionalFields = null;
			if($chunks->additionalparams) {
				$additionalParams = explode(PHP_EOL, $chunks->additionalparams);
				foreach ($additionalParams as $param) {
					$subCkunks = explode(" ", preg_replace('!\s+!', ' ', $param));
					// Case with AS
					if (count($subCkunks) > 1) {
						$firstSubChunk = $this->_db->nameQuote($subCkunks[0]);
						$secondSubChunk = $this->_db->nameQuote($subCkunks[2]);
						$asAdditionalParam = $subCkunks[2] && $subCkunks[1] === 'AS' ? ' ' . $subCkunks[1] . ' ' . $this->_db->nameQuote($subCkunks[2]) : null;
						$additionalFields .= ", \n " .  $firstSubChunk . $asAdditionalParam;
					} else { // Case without AS si prende solo in considerazione il 1° subchunk
						$firstSubChunk = $this->_db->nameQuote($subCkunks[0]);
						$additionalFields .= ", \n " .  $firstSubChunk;
					}
				}
			}
			
			// Auto where injected fields
			$columnsQuery = "SHOW COLUMNS FROM " . $this->_db->nameQuote($chunks->table);
			$this->_db->setQuery($columnsQuery);
			if(!$tableFields = $this->_db->loadResultArray()) {
				return false;
			}
			if(is_array($tableFields) && count($tableFields)) {
				$whereConditions = array();
				// Published field supported
				if(in_array('published', $tableFields)) {
					$whereConditions[] =   $this->_db->nameQuote('published') . ' = 1';
				}
				
				// Access field supported
				if(in_array('access', $tableFields)) {
					$whereConditions[] =   $this->_db->nameQuote('access') . ' IN {aid}';
				}
				
				// Language field supported
				if(in_array('language', $tableFields)) {
					$whereConditions[] =  ' (' . $this->_db->nameQuote('language') . ' = ' . $this->_db->Quote('*') . ' OR ' . $this->_db->nameQuote('language')  . ' =  {langtag}) ';
				}
			}
			
			// Append WHERE se non nulla
			if(is_array($whereConditions) && count($whereConditions)) {
				$whereString = "\n WHERE " . implode(' AND ', $whereConditions);
			}
			
			// Build final query string
			$finalQueryString = "SELECT " . $titleField . $idField;
			
			if(isset($catidField)) {
				$finalQueryString .= $catidField;
			}
			
			$finalQueryString .= $additionalFields;
			
			$finalQueryString .= "\n FROM " . $this->_db->nameQuote($chunks->table);
			
			if(isset($whereString)) {
				$finalQueryString .= $whereString;
			}
			
		}
		
		// All well done
		$tableObject->sqlquery = $finalQueryString;
		return true;
	}
	
	/**
	 * Costruzione list entities query
	 *
	 * @access private
	 * @return string
	 */
	private function buildListQuery() {
		// WHERE
		$where = array ();
		$whereString = null;
		$orderString = null;
		// STATE FILTER
		if ($filter_state = $this->state->get ( 'state' )) {
			if ($filter_state == 'P') {
				$where [] = 's.published = 1';
			} else if ($filter_state == 'U') {
				$where [] = 's.published = 0';
			}
		}
		
		// TEXT FILTER
		if ($this->state->get ( 'searchword' )) {
			$where [] = "s.name LIKE '%" . $this->state->get ( 'searchword' ) . "%'";
		}
		
		if (count ( $where )) {
			$whereString = "\n WHERE " . implode ( "\n AND ", $where );
		}
		
		// ORDERBY
		if ($this->state->get ( 'order' )) {
			$orderString = "\n ORDER BY " . $this->state->get ( 'order' ) . " ";
		}
		
		// ORDERDIR
		if ($this->state->get ( 'order_dir' )) {
			$orderString .= $this->state->get ( 'order_dir' );
		}
		
		$query = "SELECT s.*" . "\n FROM #__jmap AS s" . $whereString . $orderString;
		return $query;
	}
	
	/**
	 * Main get data method
	 *
	 * @access public
	 * @return Object[]
	 */
	public function getData() {
		// Build query
		$query = $this->buildListQuery ();
		$this->_db->setQuery ( $query, $this->getState ( 'limitstart' ), $this->getState ( 'limit' ) );
		$result = $this->_db->loadObjectList ();
		
		return $result;
	}
	
	/**
	 * Counter result set
	 *
	 * @access public
	 * @return int
	 */
	public function getTotal() {
		// Build query
		$query = $this->buildListQuery ();
		$this->_db->setQuery ( $query );
		$result = count ( $this->_db->loadResultArray () );
		
		return $result;
	}
	
	/**
	 * Restituisce le select list usate per i listEntities filters
	 *
	 * @access public 
	 * @return array
	 */
	public function getFilters() {
		$filters ['state'] = JHTML::_ ( 'grid.state', $this->getState ( 'state' ) );
		
		return $filters;
	}
	
	/**
	 * Restituisce le select list usate dalla view per l'interfaccia
	 *
	 * @access public
	 * @param Object& $record
	 * @return array
	 */
	public function getLists(&$record) {
		$lists = array ();
		// Grid states
		$lists ['published'] = JHTML::_ ( 'select.booleanlist', 'published', null, $record->published );
		
		// Components select list
		$queryComponent = "SELECT DISTINCT " . $this->_db->nameQuote('element') . " AS value, SUBSTRING(" . $this->_db->nameQuote('element') . ", 5) AS text" .
						  "\n FROM #__extensions" .
						  "\n WHERE " . $this->_db->nameQuote('protected') . " = 0" .
		 				  "\n AND ". $this->_db->nameQuote('type') . " = " . $this->_db->quote('component');
		$this->_db->setQuery($queryComponent);
		if(!$elements = $this->_db->loadObjectList()) {
			JError::raiseNotice(100, $this->_db->getErrorMsg());
		}
		array_unshift($elements, JHTML::_('select.option', null, JText::_('SELECTCOMPONENT')));
		$lists ['components'] = JHTML::_ ( 'select.genericlist', $elements, 'sqlquery_managed[option]', 'style="width:200px"; data-validation="required"', 'value', 'text', @$record->sqlquery_managed->option);
		
		
		// Tables select list
		$queryTables = "SHOW TABLES";
		$this->_db->setQuery($queryTables);
		if(!$elements = $this->_db->loadResultArray()) {
			JError::raiseNotice(100, $this->_db->getErrorMsg());
		}
		if(is_array($elements) && count($elements)) {
			$options = array();
			$options[] = JHTML::_('select.option', null, JText::_('SELECTTABLE'));
			foreach ($elements as $element) {
				$options[] = JHTML::_('select.option', $element, $element);
			}
		}
		$lists ['tables'] = JHTML::_ ( 'select.genericlist', $options, 'sqlquery_managed[table]', 'style="width:200px"; data-validation="required"', 'value', 'text', @$record->sqlquery_managed->table);
		
		// Fields select list
		$options = array();
		$options[] = JHTML::_('select.option', null, JText::_('SELECTFIELD'));
		if(isset($record->sqlquery_managed->table) && $record->sqlquery_managed->table) {
			$queryFields = "SHOW COLUMNS " .
						   "\n FROM " . $this->_db->nameQuote($record->sqlquery_managed->table);
			$this->_db->setQuery($queryFields);
			if(!$elements = $this->_db->loadResultArray()) {
				JError::raiseNotice(100, $this->_db->getErrorMsg());
			}
			
			if(is_array($elements) && count($elements)) {
				foreach ($elements as $element) {
					$options[] = JHTML::_('select.option', $element, $element);
				}
			} 
		}
		$lists ['fieldsTitle'] = JHTML::_ ( 'select.genericlist', $options, 'sqlquery_managed[titlefield]', 'style="width:200px"; data-role="tablefield"; data-validation="required"', 'value', 'text', @$record->sqlquery_managed->titlefield);
		$lists ['fieldsID'] = JHTML::_ ( 'select.genericlist', $options, 'sqlquery_managed[id]', 'style="width:200px" data-role="tablefield"; data-validation="required"', 'value', 'text', @$record->sqlquery_managed->id);
		$lists ['fieldsCatid'] = JHTML::_ ( 'select.genericlist', $options, 'sqlquery_managed[catid]', 'style="width:200px"; data-role="tablefield"', 'value', 'text', @$record->sqlquery_managed->catid);
				
		
		// Priority select list
		$options = array();
		$options[] = JHTML::_('select.option', null, JText::_('SELECTPRIORITY')); 
		$arrayPriority = array ('0.0', '0.1', '0.2', '0.3', '0.4', '0.5', '0.6', '0.7', '0.8', '0.9', '1.0');
		foreach ($arrayPriority as $priority) {
			$options[] = JHTML::_('select.option', $priority, $priority);
		}
		$lists ['priority'] = JHTML::_ ( 'select.genericlist', $options, 'params[priority]', 'style="width:200px";', 'value', 'text', $record->params->getValue('priority', '0.5'));
		
		// Change frequency select list
		$options = array();
		$options[] = JHTML::_('select.option', null, JText::_('SELECTCHANGEFREQ'));
		$arrayPriority = array ('always', 'hourly', 'daily', 'weekly', 'monthly', 'yearly', 'never');
		foreach ($arrayPriority as $priority) {
			$options[] = JHTML::_('select.option', $priority, $priority);
		}
		$lists ['changefreq'] = JHTML::_ ( 'select.genericlist', $options, 'params[changefreq]', 'style="width:200px";', 'value', 'text', $record->params->getValue('changefreq', 'daily'));
		
		// Lazy Loading dependency - Use JElement simbolic override for menu multiselect generation specific to single data source menu
		if($record->type == 'menu') {
			include_once JPATH_COMPONENT . '/elements/menu.php';
			$selections = JMapHTMLMenu::getMenuItems($record->name);
			$lists['exclusion']	= JHTML::_('select.genericlist',   $selections, 'params[exclusion][]', 'class="inputbox" size="15" multiple="multiple"', 'value', 'text', $record->params->getValue('exclusion', array()), 'exclusion' );
		}
		
		// Lazy Loading dependency - Use JElement simbolic override for menu multiselect generation specific to single data source menu
		if($record->type == 'content') {
			include_once JPATH_COMPONENT . '/elements/categories.php';
			$categoryOptions = JMapHTMLCategories::getCategories();
			$lists['catexclusion']	= JHTML::_('select.genericlist',   $categoryOptions, 'params[catexclusion][]', 'class="inputbox" size="15" multiple="multiple"', 'value', 'text', $record->params->getValue('catexclusion', array()), 'catexclusion' );
		}
		
		return $lists;
	}
	
	/**
	 * Effettua il load dell'entity singola da orm table
	 * @access public
	 * @param int $id
	 * @return Object&
	 */
	public function loadEntity($id) {
		// load table record
		$table = $this->getTable();
		$table->load($id);
		 
		if(!$table){
			JError::raiseNotice ( 400, $this->_db->getErrorMsg () );
			return false;
		}
		return $table;
	}
	
	/**
	 * Storing record tramite $table
	 * @access public
	 * @return mixed
	 */
	public function storeEntity($forceRegenerate = false) {
		$table = &$this->getTable();
		try {
			if (! $table->bind ($_POST, true)) {
				throw new Exception($table->getError ());
			}
	
			if (! $table->check ( )) {
				throw new Exception($table->getError ());
			}
	
			// Delegate creazione raw query se type=user e new
			if(($table->type == 'user' && !$table->id) || $forceRegenerate) {
				if(!$this->buildRawQuery($table->sqlquery_managed, $table)) {
					throw new Exception(JText::_('ERROR_BUILDING_QUERY'));
				}
			}
			
			if (! $table->store (false)) {
				throw new Exception($table->getError ());
			} 
			$table->reorder(); 
		} catch(Exception $e) {
			switch ($e->getCode()) {
				default:
					JError::raiseNotice(100, $e->getMessage());
			}
			return false;
		}
			
		return $table;
	}
	
	/**
	 * Cancel editing entity
	 *
	 * @param int $id
	 * @access public
	 * @return boolean
	 */
	public function cancelEntity($id) {
		// New record - do null e return true subito
		if(!$id) {
			return true;
		}
		
		$table = $this->getTable();
		try {
			if (! $table->load($id)) {
				throw new Exception($table->getError ());
			}
			if (! $table->checkin()) {
				throw new Exception($table->getError ());
			}
		} catch(Exception $e) {
			switch ($e->getCode()) {
				default:
					JError::raiseNotice(100, $e->getMessage());
			}
			return false;
		}
			
		return true;
	}
	 
	/**
	 * Delete entity
	 *
	 * @param array $ids
	 * @access public
	 * @return boolean
	 */
	public function deleteEntity($ids) {
		$table = $this->getTable();
		
		// Ciclo su ogni entity da cancellare
		foreach ($ids as $id) {
			try {
				if (! $table->delete($id)) {
					throw new Exception($table->getError ());
				} 
			} catch(Exception $e) {
				switch ($e->getCode()) {
					default:
						JError::raiseNotice(100, $e->getMessage());
				}
				return false;
			} 
		}
		$table->reorder();
		return true;
	}
 
	/**
	 * Copy existing entity
	 *
	 * @param int $id
	 * @access public
	 * @return boolean
	 */
	public function copyEntity($ids) { 
		if(is_array($ids) && count($ids)) {
			$table = $this->getTable();
			try {
				foreach ( $ids as $id ) {
					if ($table->load ( ( int ) $id )) {
						$table->id = 0;
						$table->name = 'Copy of ' . $table->name;
						$table->published = 0;
						$table->sqlquery_managed = json_encode($table->sqlquery_managed);
						$table->params = $table->params->toString();
						if (! $table->store ()) {
							throw new Exception($table->getError ());
						} 
					} else {
						throw new Exception($table->getError ());
					}
				}	
				$table->reorder();
			} catch(Exception $e) {
				switch ($e->getCode()) {
					default:
						JError::raiseNotice(100, $e->getMessage());
				}
				return false;
			}
		}
		return true;
	}
	
	/**
	 * Inserisce o elimina il record nella #__fbchat_agents
	 *
	 * @access public
	 * @param int $idEntity        	
	 * @param string $state        	
	 * @return boolean
	 */
	public function changeOrder($idEntity, $direction) {
		if (isset ( $idEntity )) {
			try {
				$table = & $this->getTable ();
				$table->load ( ( int ) $idEntity );
				if (! $table->move ( $direction )) {
					throw new Exception ( $table->getError () );
				}
			} catch ( Exception $e ) {
				switch ($e->getCode ()) {
					default :
						JError::raiseNotice ( 100, $e->getMessage () );
				}
				return false;
			}
		}
		return true;
	}
	
	/**
	 * Method to move and reorder
	 *
	 * @access public
	 * @param array $cid        	
	 * @param array $order  
	 * @return boolean on success
	 * @since 1.5
	 */
	public function saveOrder($cid = array(), $order) {
		if (is_array ( $cid ) && count ( $cid )) {
			try {
				$table = & $this->getTable ();
				// update ordering values
				for($i = 0; $i < count ( $cid ); $i ++) {
					$table->load ( ( int ) $cid [$i] );
					if ($table->ordering != $order [$i]) {
						$table->ordering = $order [$i];
						if (! $table->store ()) {
							throw new Exception ( $table->getError () );
						}
					}
				}
			} catch ( Exception $e ) {
				switch ($e->getCode ()) {
					default :
						JError::raiseNotice ( 100, $e->getMessage () );
				}
				return false;
			}
			// All went well
			$table->reorder ();
		}
		return true;
	}
	
	/**
	 * Inserisce o elimina il record nella #__fbchat_agents
	 *
	 * @access public
	 * @param int $idEntity        	
	 * @param string $state        	
	 * @return boolean
	 */
	public function publishEntities($idEntity, $state) {
		// Table load
		$table = $this->getTable ();
		if (isset ( $idEntity )) {
			try {
				$table->load ( $idEntity );
				switch ($state) {
					case 'unpublish' :
						$table->published = null;
						break;
					
					case 'publish' :
						$table->published = 1;
						break;
				}
				
				if (! $table->store ( true )) {
					throw new Exception ( $table->getError () );
				}
			} catch ( Exception $e ) {
				switch ($e->getCode ()) {
					default :
						JError::raiseNotice ( 100, $e->getMessage () );
				}
				return false;
			}
		}
		return true;
	}
 
	/**
	 * Force sql query regeneration
	 *
	 * @access public
	 * @return mixed
	 */
	public function regenerateRawSqlQuery() {
		return $this->storeEntity(true);
	}
}