<?php
// namespace administrator\components\com_jmap\tables;
/**
 *
 * @package JMAP::administrator::components::com_jmap
 * @subpackage tables
 * @author Joomla! Extensions Store
 * @copyright (C) 2013 - Joomla! Extensions Store
 * @license GNU/GPLv2 http://www.gnu.org/licenses/gpl-2.0.html
 */
// no direct access
defined ( '_JEXEC' ) or die ( 'Restricted access' );

/**
 * ORM Table for sitemap sources
 *
 * @package JMAP::administrator::components::com_jmap
 * @subpackage tables
 */
class TableSources extends JTable {
	/**
	 * @var int
	 */
	var $id = null;
	
	/**
	 * @var string
	 */
	var $type = 'user';
	
	/**
	 * @var string
	 */
	var $name = '';
	
	/**
	 * @var string
	 */
	var $description = '';
	
	/**
	 * @var int
	 */
	var $checked_out = 0;
	
	/**
	 * @var date
	 */
	var $checked_out_time = 0;
	
	/**
	 * @var int
	 */
	var $published = 1;
	
	/**
	 * @var int
	 */
	var $ordering = null;
	
	/**
	 * @var string
	 */
	var $sqlquery = '';
	
	/**
	 * @var string
	 */
	var $sqlquery_managed = '{"option":"","table":"","titlefield":"","titlefield_as":"","id":"","idfield_as":"","catid":"","catidfield_as":"","view":"","additionalparams":""}';
	
	/**
	 * @var string
	 */
	var $params = null;
	public function __construct(&$_db) {
		parent::__construct ( '#__jmap', 'id', $_db );
	}
	
	/**
	 * Bind Table override
	 * @override
	 * 
	 * @see JTable::bind()
	 */
	public function bind($fromArray, $saveTask = false) {
		parent::bind ( $fromArray );
		
		if ($saveTask) {
			$params = JRequest::getVar ( 'params', array (), 'POST', 'array' );
			$registry = new JRegistry ();
			$registry->loadArray ( $params );
			$this->params = $registry->toString ();
			
			$sqlquery_managed_chunks = JRequest::getVar ( 'sqlquery_managed', array (), 'POST', 'array' );
			if (is_array ( $sqlquery_managed_chunks )) {
				$this->sqlquery_managed = json_encode ( $sqlquery_managed_chunks );
			}
		}
		
		return true;
	}
	
	/**
	 * Load Table override
	 * @override
	 * 
	 * @see JTable::load()
	 */
	public function load($idEntity = null, $reset = true) {
		parent::load ( $idEntity );
		
		$registry = new JRegistry ();
		$registry->loadJSON ( $this->params );
		$this->params = $registry;
		
		if ($this->sqlquery_managed) {
			$this->sqlquery_managed = json_decode ( $this->sqlquery_managed );
		}
		
		return true;
	}
	
	/**
	 * Check Table override
	 * @override
	 * 
	 * @see JTable::check()
	 */
	public function check() {
		// Name required
		if (! $this->name) {
			$this->setError ( JTEXT::_ ( 'VALIDATION_ERROR' ) );
			return false;
		}
		
		// Validate sql query managed chunks
		if($this->type == 'user') {
			if(isset($this->sqlquery_managed)) {
				$sqlQuerymanagedObject = json_decode($this->sqlquery_managed);
				if(	!($sqlQuerymanagedObject->option) || 
					!($sqlQuerymanagedObject->table) || 
					!($sqlQuerymanagedObject->titlefield) || 
					!($sqlQuerymanagedObject->id)) {
						$this->setError ( JTEXT::_ ( 'SQLQUERYMANAGED_VALIDATION_ERROR' ) );
						return false;
				}
			}
		}
		return true;
	}
}
?>