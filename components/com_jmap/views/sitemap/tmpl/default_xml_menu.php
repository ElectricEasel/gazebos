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

$priority =  $this->sourceparams->get ( 'priority', '0.5' );
$changefreq = $this->sourceparams->get ( 'changefreq', 'daily' );
$includeExternalLinks =  $this->sourceparams->get ( 'include_external_links', 1 );

// Get menus object
$menusArray =& JSite::getMenu()->get('_items');
// Avoid XML sitemap duplicated links

if (count ( $this->source->data )) {
	foreach ( $this->source->data as $elm ) { 
		// Skip menu external links
		if($elm->type == 'url' && !$includeExternalLinks) {
			continue;
		}
		$link = $elm->link;
		if (isset ( $elm->id )) {
			switch (@$elm->type) {
				case 'separator' :
					break;
				case 'url' :
					if (preg_match ( "#^/?index\.php\?#", $link )) {
						if (strpos ( $link, 'Itemid=' ) === FALSE) {
							if (strpos ( $link, '?' ) === FALSE) {
								$link .= '?Itemid=' . $elm->id;
							} else {
								$link .= '&amp;Itemid=' . $elm->id;
							}
						}
					}
					break;
				default :
					if (strpos ( $link, 'Itemid=' ) === FALSE) {
						$link .= '&amp;Itemid=' . $elm->id;
					}
					break;
			}
		}
		
		if (strcasecmp ( substr ( $link, 0, 9 ), 'index.php' ) === 0) {
			$link = JRoute::_ ( $link );
		}
		
		if (($elm->link == 'index.php') or strpos ( $elm->link, 'view=frontpage' )) { // HOME
			$link = '';
		}
		
		// SEF patch for better match uri con $link override
		if ($elm->type == 'component' && array_key_exists($elm->id, $menusArray)) {
			$link = 'index.php?Itemid=' . $elm->id;
			$link = JRoute::_ ( $link );
		}
		
		// Skip outputting
		if(in_array($link, $this->outputtedLinksBuffer)) {
			continue;
		}
		// Else store to prevent duplication
		$this->outputtedLinksBuffer[] = $link;
		
		$link = htmlentities($link, null, null, false);
		?>
<url>
<loc><?php echo preg_match('/http/i', $link) ? $link : $this->liveSite . $link ; ?></loc>
<changefreq><?php echo $changefreq;?></changefreq>
<priority><?php echo $priority;?></priority>
</url>
<?php 
	} 
}
	

