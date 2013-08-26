<?php
// namespace administrator\components\com_jmap\elements;
/**  
 * @package JMAP::administrator::components::com_jmap
 * @subpackage elements
 * @author Joomla! Extensions Store
 * @copyright (C) 2013 - Joomla! Extensions Store
 * @license GNU/GPLv2 http://www.gnu.org/licenses/gpl-2.0.html  
 */
defined ( '_JEXEC' ) or die ( 'Restricted access' );
jimport('joomla.language.helper');
/**
 * Menu Items element class
 *
 * @package JMAP::administrator::components::com_jmap
 * @subpackage elements
 *        
 */
class JMapHTMLLanguages extends JObject {
	/**
	 * Build the multiple select list for Menu Links/Pages
	 * 
	 * @access public
	 * @return array
	 */
	public static function getAvailableLanguageOptions() {
		$knownLangs = JLanguageHelper::getLanguages();
		 
		$langs[] = JHTML::_('select.option',  '', '- '. JText::_( 'DEFAULT_SITE_LANG' ) .' -' );
		
		// Create found languages options
		foreach ($knownLangs as $langObject) {
			// Extract tag lang
			$langs[] = JHTML::_('select.option',  $langObject->sef, $langObject->title );
		}
		 
		return $langs;
	}
}