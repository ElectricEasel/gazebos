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
echo "<?xml version='1.0' encoding='UTF-8'?>" . PHP_EOL;
?>
<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
<?php
foreach ( $this->data as $source ) {	
	// Strategy pattern source type template visualization
	if ($source->type) {
		$this->source = &$source;
		$this->sourceparams = &$source->params;
		if($this->sourceparams->get('xmlinclude', 1)) {
			$subTemplateName = $this->_layout . '_xml_' . $source->type . '.php';
			if (file_exists ( JPATH_COMPONENT_SITE . '/views/sitemap/tmpl/' . $subTemplateName )) {
				echo $this->loadTemplate ( 'xml_' . $source->type );
			}
		}
	}
}
?>
</urlset>