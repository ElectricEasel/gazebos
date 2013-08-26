<?php 
//namespace components\com_jmap\models; 
/** 
 * @package JMAP::AJAXSERVER::components::com_jmap 
 * @subpackage models
 * @author Joomla! Extensions Store
 * @copyright (C)2013 Joomla! Extensions Store
 * @license GNU/GPLv2 http://www.gnu.org/licenses/gpl-2.0.html  
 */
defined ( '_JEXEC' ) or die ( 'Restricted access' );

/** 
 * Classe che gestisce il recupero dei dati per il POST HTTP
 * @package JMAP::components::com_jmap  
 * @subpackage models
 * @since 1.0
 */
class JMapModelAjaxserver extends JModel {   
	/**
	 * Richiede alla model di backend i fields dinamici per la tabella selezionata nella select
	 * @access private
	 * @param string $tableName
	 * @return array
	 */
	private function loadTableFields($tableName) { 
		// Fields select list
		$queryFields = "SHOW COLUMNS " .
					   "\n FROM " . $this->_db->nameQuote($tableName);
		$this->_db->setQuery($queryFields);
		$elements = $this->_db->loadResultArray();
		
		return $elements;
	}
	 
	/**
	 * Come se ci fosse una lista di entità, qui le risposte ajax, da effettuarne il load e restituire
	 * al pari di record qualunque in una tabella, si esegue il load e si restituiscono al controller o alla view
	 * @access public 
	 * @param string $id Rappresenta l'op da eseguire tra le private properties
	 * @param mixed $param Parametri da passare al private handler
	 * @param Object[]& $DIModels
	 * @return Object& $utenteSelezionato
	 */
	public function &loadEntity($id, $param, &$DIModels = null) {
		//Delega la private functions delegata dalla richiesta sulla entity
		 $response = $this->$id($param, $DIModels);
		 
		 return $response;
	} 
} 