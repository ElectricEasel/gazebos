<?php
// namespace components\com_jmap\models;
/**
 * @package JMAP::SITEMAP::components::com_jmap
 * @subpackage models
 * @author Joomla! Extensions Store
 * @copyright (C) 2013 - Joomla! Extensions Store
 * @license GNU/GPLv2 http://www.gnu.org/licenses/gpl-2.0.html
 */
defined ( '_JEXEC' ) or die ( 'Restricted access' );
jimport('joomla.application.component.model');

/**
 * Main sitemap model public responsibilities interface
 *
 * @package JMAP::SITEMAP::components::com_jmap
 * @subpackage models
 */
interface ISitemapModel {
	/**
	 * Get the Data
	 * @access public
	 * @return array
	 */
	public function getSitemapData(); 
}

/**
 * CPanel export XML sitemap responsibility
 *
 * @package JMAP::CPANEL::administrator::components::com_jmap
 * @subpackage models
 * @since 1.0
 */
interface IExportable {
	/**
	 * Aggiorna i nuovi menu sources aggiunti in menu se non presenti come
	 * risorse sources in #__map
	 *
	 * @access public
	 * @param string $contents
	 * @return boolean
	 */
	public function exportXMLSitemap($contents);
}

/**
 * Main sitemap model class
 *
 * @package JMAP::SITEMAP::components::com_jmap
 * @subpackage model
 */
class JMapModelSitemap extends JModel implements ISitemapModel, IExportable {  
	/**
	 * Language tag
	 * @access private
	 * @var string
	 */
	private $langTag;

	/**
	 * Main data structure
	 * @access private
	 * @var array
	 */
	private $data; 
	
	/**
	 * Sources array
	 * @access private
	 * @var array
	 */
	private $sources; 
	
	/**
	 * E' responsabile del download del documento
	 * @access public
	 * @param String $contents
	 * @param String $filename Nome del file esportato
	 * @return boolean
	 */
	private function sendAsBinary($contents, $filename) {
		$fsize = JString::strlen($contents);
	
		// required for IE, otherwise Content-disposition is ignored
		if (ini_get ( 'zlib.output_compression' )) {
			ini_set ( 'zlib.output_compression', 'Off' );
		}
		header ( "Pragma: public" );
		header ( "Cache-Control: must-revalidate, post-check=0, pre-check=0" );
		header ( "Expires: 0" );
		header ( "Content-Transfer-Encoding: binary" );
		header ( 'Content-Disposition: attachment;' . ' filename="' . $filename . '";' . ' size=' . $fsize . ';' ); //RFC2183
		header ( "Content-Type: application/xml"); // MIME type
		header ( "Content-Length: " . $fsize );
		if (! ini_get ( 'safe_mode' )) { // set_time_limit doesn't work in safe mode
			@set_time_limit ( 0 );
		}
	
		echo $contents;
	
		exit();
	}
	
	/**
	 * Pagebreaks detection
	 * 
	 * @access private
	 * @param Object& $article
	 * @return boolean
	 */
	private function addPagebreaks(&$article) {
		$matches = array ();
		if (preg_match_all ( '/<hr\s*[^>]*?(?:(?:\s*alt="(?P<alt>[^"]+)")|(?:\s*title="(?P<title>[^"]+)"))+[^>]*>/i', $article->completetext, $matches, PREG_SET_ORDER )) {
			foreach ( $matches as $match ) {
				if (strpos ( $match [0], 'class="system-pagebreak"' ) !== FALSE) {
					if (@$match ['alt']) {
						$title = stripslashes ( $match ['alt'] );
					} elseif (@$match ['title']) {
						$title = stripslashes ( $match ['title'] );
					} else {
						$title = JText::sprintf ( 'Page #', $i );
					}
					$article->expandible[] = $title;
				}
			}
			return true;
		}
		return false;
	}
	
	/**
	 * sort a menu view
	 *
	 * @param
	 *        	array the menu
	 * @return array the sorted menu
	 */
	private function sortMenu($m, &$sourceParams) {
		$rootlevel = array ();
		$sublevels = array ();
		$r = 0;
		$s = 0;
		foreach ( $m as $item ) {
			if ($item->parent == 1) {
				// rootlevel
				$item->ebene = 0;
				$rootlevel [$r] = $item;
				$r ++;
			} else {
				// sublevel
				$item->ebene = 1;
				$sublevels [$s] = $item;
				$s ++;
			}
		}
		$maxlevels = $sourceParams->get ( 'maxlevels', '5' );
		$z = 0;
		if ($s != 0 and $maxlevels != 0) {
			foreach ( $rootlevel as $elm ) {
				$newmenuitems [$z] = $elm;
				$z ++;
				$this->sortMenuRecursive ( $z, $elm->id, $sublevels, 1, $maxlevels, $newmenuitems );
			}
		} else {
			$newmenuitems = $rootlevel;
		}
		return $newmenuitems;
	}
	
	/**
	 * sort a menu view Recursive through the tree
	 *
	 * @param
	 *        	int element number to work with
	 * @param
	 *        	int the parent id
	 * @param
	 *        	array the sublevels
	 * @param
	 *        	int the level
	 * @param
	 *        	int the maximun depth for the search
	 * @param
	 *        	array new menu
	 */
	private function sortMenuRecursive(&$z, $id, $sl, $ebene, $maxlevels, &$nm) {
		if ($ebene > $maxlevels) {
			return true;
		}
		foreach ( $sl as $selm ) {
			if ($selm->parent == $id) {
				$selm->ebene = $ebene;
				$nm [$z] = $selm;
				$z ++;
				$nebene = $ebene + 1;
				$this->sortMenuRecursive ( $z, $selm->id, $sl, $nebene, $maxlevels, $nm );
			}
		}
		return true;
	}
	 
	/**
	 * Get the Data for a view
	 * 
	 * @access private
	 *
	 * @param
	 *        	object the view sql source
	 * @return object the view plus additional data
	 */
	private function getSourceData($source, $accessLevels) {
		// Create di un nuovo result source object popolato delle properties necessarie alla view e degli items recuperati da DB
		$resultSourceObject = new stdClass ();
		$resultSourceObject->name = $source->name;
		$resultSourceObject->type = $source->type;
		if($source->sqlquery_managed) {
			$resultSourceObject->chunks = json_decode($source->sqlquery_managed);
		}
		
		// Component specific level params no override
		$component = JComponentHelper::getComponent( 'com_jmap' );
		$resultSourceObject->params = new JRegistry($component->params);
		// Component -> menu view specific level params override
		//$resultSourceObject->params = JComponentHelper::getParams('com_jmap');
		// Item specific level params override
		$resultSourceObject->params->merge(new JRegistry($source->params ));

		$sourceItems = array();
		switch ($source->type) {
			case 'user':
				$query = $source->sqlquery; 
				// Se la raw query è stata impostata
				if($query) {
					$query = str_replace('{aid}', '(' . implode(',', $accessLevels) . ')', $query);
					$query = str_replace('{langtag}', $this->_db->quote($this->langTag), $query);
					$this->_db->setQuery ( $query );
					$sourceItems = $this->_db->loadObjectList ();
					$debugMode = $resultSourceObject->params->get('debug_mode', 0);
					if ($this->_db->getErrorNum () && $debugMode) {
						JError::raiseWarning ( 500, $this->_db->getErrorMsg () . '<br /><br />' .
													JText::_ ( 'SQLQUERY_EXPLAINED' ) . '<br /><br />' .
													$this->_db->getQuery () . '<br /><br />' .
													JText::_ ( 'SQLQUERY_EXPLAINED_END' ) );
					} 
				}
				break;
				
			case 'menu':
				$originalSourceItems = array();
				// Unpublished items
				$doUnpublishedItems = $resultSourceObject->params->get('dounpublished', 0);
				// Exclusion menu
				$subQueryExclusion = null;
				$exclusionMenuItems = $resultSourceObject->params->get('exclusion', array());
				if($exclusionMenuItems && !is_array($exclusionMenuItems)) {
					$exclusionMenuItems = array($exclusionMenuItems);
				}
				if(count($exclusionMenuItems)) {
					$subQueryExclusion = "\n AND menuitems.id NOT IN (" . implode(',', $exclusionMenuItems) . ")";
				}
				$queryChunk = null;
				if(!$doUnpublishedItems) {
					$queryChunk = "\n AND menuitems.published = 1";
				}
				
				$menuQueryItems = "SELECT menuitems.*, menuitems.parent_id AS parent, menuitems.level AS sublevel, menuitems.title AS name FROM #__menu as menuitems" .
								  "\n INNER JOIN #__menu_types AS menutypes" .
								  "\n ON menuitems.menutype = menutypes.menutype" .
								  "\n WHERE	menuitems.published >= 0" . $queryChunk .
								  "\n AND menuitems.access IN ( " . implode(',', $accessLevels) . " )" .
								  "\n AND menutypes.title = " . $this->_db->Quote($source->name) .
								  "\n AND ( menuitems.language = " . $this->_db->Quote('*') . " OR menuitems.language = " . $this->_db->Quote($this->langTag) . " ) " .
								  $subQueryExclusion .
								  "\n ORDER BY menuitems.menutype, menuitems.parent_id, menuitems.level, menuitems.lft";
				$this->_db->setQuery ( $menuQueryItems );
				$originalSourceItems = $this->_db->loadObjectList ();
				if ($this->_db->getErrorNum ()) {
					JError::raiseWarning ( 500, JText::_ ( 'ERROR_RETRIEVING_DATA' ) );
				}		
				$sourceItems = $this->sortMenu ( $originalSourceItems, $resultSourceObject->params);
				break;
				
			case 'content':
				$now = date('Y-m-d H:i:s', time());
				$access = "\n AND c.access IN ( " . implode(',', $accessLevels) . " )";
				$catAccess = "\n AND cat.access IN ( " . implode(',', $accessLevels) . " )";
				
				// Exclusion categories
				$subQueryCatExclusion = null;
				$subQueryCategoryExclusion = null;
				$exclusionCategories = $resultSourceObject->params->get('catexclusion', array());
				if($exclusionCategories && !is_array($exclusionCategories)) {
					$exclusionCategories = array($exclusionCategories);
				}
				
				// Exclusion children categories da table orm nested set model
				if(count($exclusionCategories)) {
					JTable::addIncludePath(JPATH_LIBRARIES . '/joomla/database/table');
					$categoriesTableNested = JTable::getInstance('Category'); 
					$children = array();
					foreach ($exclusionCategories as $topCatID) {
						// Load Children categories se presenti
						$categoriesTableNested->load($topCatID);
						$tempChildren = $categoriesTableNested->getTree();
						if(is_array($tempChildren) && count($tempChildren)) {
							foreach ($tempChildren as $child) {
								if(!in_array($child->id, $children) && !in_array($child->id, $exclusionCategories)) {
									$exclusionCategories[] = $child->id;
								}
							} 
						}
					}
					 
					$subQueryCatExclusion = "\n AND c.catid NOT IN (" . implode(',', $exclusionCategories) . ")";
					$subQueryCategoryExclusion = "\n AND cat.id NOT IN (" . implode(',', $exclusionCategories) . ")";
				}
				
				$contentQueryItems = "SELECT c.*, c.title as title, cat.id AS catid, cat.title as category, cat.level, UNIX_TIMESTAMP(modified) as modified," .
									 "\n CONCAT('index.php?option=com_content&view=article&id=', c.id)  as link , c.catid as catslug," .
									 "\n CASE WHEN CHAR_LENGTH(c.alias) THEN CONCAT_WS(':', c.id, c.alias) ELSE c.id END as slug," .
									 "\n CONCAT(c.introtext, c.fulltext) AS completetext" .
									 "\n FROM #__content as c" .
									 "\n RIGHT JOIN #__categories AS cat ON cat.id = c.catid" .
									 "\n AND c.state = '1'".
									 "\n AND ( c.publish_up = '0000-00-00 00:00:00' OR c.publish_up <= '$now' )" .
									 "\n AND ( c.publish_down = '0000-00-00 00:00:00' OR c.publish_down >= '$now' )" .
									 $access .
									 "\n AND ( c.language = " . $this->_db->Quote('*') . " OR c.language = " . $this->_db->Quote($this->langTag) . " ) " .
									 $subQueryCatExclusion .
									 "\n WHERE cat.published = '1'" .
									 $catAccess .
									 "\n AND cat.extension = " . $this->_db->Quote('com_content') .
									 "\n AND ( cat.language = " . $this->_db->Quote('*') . " OR cat.language = " . $this->_db->Quote($this->langTag) . " ) " .
									 $subQueryCategoryExclusion .
									 "\n ORDER BY cat.lft, c.ordering";
				$this->_db->setQuery ( $contentQueryItems );
				$sourceItems = $this->_db->loadObjectList ();
				if ($this->_db->getErrorNum ()) {
					JError::raiseWarning ( 500, JText::_ ( 'ERROR_RETRIEVING_DATA' ) );
				}
				
				// Sub article pagebreaks processing
				foreach ($sourceItems as $article) {
					$this->addPagebreaks($article);
				}
				break;
		}
		 
		// Final assignment
		$resultSourceObject->data = $sourceItems;
	 
		return $resultSourceObject;
	}
	
	/**
	 * Get available sitemap source
	 * @access private
	 * @return array
	 */
	private function getSources() { 
		$query = "SELECT v.*" .
				 "\n FROM #__jmap AS v" .
				 "\n WHERE v.published = 1" .
				 "\n ORDER BY v.ordering asc";
		$this->_db->setQuery ( $query );
		
		$this->sources = $this->_db->loadObjectList ();
		
		return $this->sources;
	}
	  
	/**
	 * Get the Data
	 * @access public
	 * @return array
	 */
	public function getSitemapData() {
		// get the view
		$this->sources = $this->getSources ();
		$data = array ();
		$user = JFactory::getUser();
		// Getting degli access levels associati all'utente in base ai gruppi di appartenenza
		$accessLevels = $user->getAuthorisedViewLevels();
		// get data for a view
		foreach ( $this->sources as $source ) {
			$data [] = $this->getSourceData ( $source, $accessLevels);
		}
		$this->data = $data;
		
		return $data;
	}
	
	/**
	 * Aggiorna i nuovi menu sources aggiunti in menu se non presenti come
	 * risorse sources in #__map
	 *
	 * @access public
	 * @param string $contents
	 * @return boolean
	 */
	public function exportXMLSitemap($contents) {
		if($contents) {
			$this->sendAsBinary($contents, 'sitemap.xml');
		}
	
		return false;
	}
	 
	/**
	 * Class Constructor
	 * @access public
	 * @return Object&
	 */
	function __construct() {
		parent::__construct ();
		$this->setState('cparams', JComponentHelper::getParams('com_jmap')); 
		$this->data = array();
		$this->sources = array();
		
		// Set language tag
		$language = JFactory::getLanguage();
		$this->langTag = $language->getTag();
	}
}