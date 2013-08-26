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

/**
 * Menu Items element class
 *
 * @package JMAP::administrator::components::com_jmap
 * @subpackage elements
 *        
 */
class JMapHTMLCategories extends JObject {
	/**
	 * Build the multiple select list for Menu Links/Pages
	 * 
	 * @access public
	 * @return array
	 */
	public static function getCategories() {
		$categories = array();
		$categories[] = JHtml::_('select.option', '0', JText::_('NOCATS'), 'value', 'text');
		$categories = array_merge($categories, JHtml::_('category.options', 'com_content'));
		
		return $categories;
	}
}