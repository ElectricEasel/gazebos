<?php
/** 
 * @package JMAP::SITEMAP::components::com_jmap
 * @subpackage views
 * @subpackage sitemap
 * @subpackage tmpl
 * @author Joomla! Extensions Store
 * @copyright (C) 2013 - Joomla! Extensions Store
 * @license GNU/GPLv2 http://www.gnu.org/licenses/gpl-2.0.html
 */
defined ( '_JEXEC' ) or die ( 'Restricted access' );

$classdiv = $this->cparams->get ( 'classdiv', '' );
echo $classdiv ? '<div id="jmap_sitemap" class="' . $classdiv . '">' : '<div>';

// title
$cshowtitle = $this->cparams->get ( 'show_title', 1 );
$headerlevel = $this->cparams->get ( 'headerlevel', $this->cparams->get ( 'headerlevel', 1 ) );

if ($cshowtitle) {
	$title = $this->cparams->get ( 'maintitle', $this->cparams->get ( 'defaulttitle', null ) );
	if(!$title) {
		$title = $this->menuname;
	}
	echo '<h' . $headerlevel . '>' . $title . '</h' . $headerlevel . '>';
} 

$section_headerlevel = $categorie_headerlevel = $headerlevel + 2;
$title_headerlevel = $headerlevel + 3;

// views

foreach ( $this->data as $source ) {	
	// Strategy pattern source type template visualization
	if ($source->type) {
		$this->source = &$source;
		$this->sourceparams = &$source->params;
		$subTemplateName = $this->_layout . '_' . $source->type . '.php';
		if (file_exists ( JPATH_COMPONENT . '/views/sitemap/tmpl/' . $subTemplateName )) {
			echo $this->loadTemplate ( $source->type );
		}
	}
}
echo '</div>';