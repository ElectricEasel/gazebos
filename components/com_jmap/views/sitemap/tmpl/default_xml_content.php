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
$showPageBreaks = $this->cparams->get ( 'show_pagebreaks', 1 );

if (count ( $this->source->data ) != 0) {
	require_once (JPATH_SITE . DS . 'components' . DS . 'com_content' . DS . 'helpers' . DS . 'route.php');
	foreach ( $this->source->data as $elm ) {
		// Element category empty da right join
		if(!$elm->id) {
			continue;
		}
		$seolink = JRoute::_ ( $elm->link );
		if (@$elm->slug) {
			$seolink = JRoute::_ ( ContentHelperRoute::getArticleRoute ( $elm->slug, $elm->catslug ) );
		}
		
		// Skip outputting
		if(in_array($seolink, $this->outputtedLinksBuffer)) {
			continue;
		}
		// Else store to prevent duplication
		$this->outputtedLinksBuffer[] = $seolink;
		
		$timestamp = (isset($elm->modified) && $elm->modified != FALSE && $elm->modified != -1) ? $elm->modified : time();
		$modified = gmdate('Y-m-d\TH:i:s\Z', $timestamp);
		?>
<url>
<loc><?php echo $this->liveSite . JRoute::_ ( $seolink ); ?></loc>
<lastmod><?php echo $modified; ?></lastmod>
<changefreq><?php echo $changefreq;?></changefreq>
<priority><?php echo $priority;?></priority>
</url>
<?php 
		if(!empty($elm->expandible) && $showPageBreaks) {
			foreach ($elm->expandible as $index=>$subPageBreak) {
				$seolink = JRoute::_ ( $elm->link . '&limitstart=' . ($index + 1));
				if (@$elm->slug) {
					$seolink = JRoute::_ ( ContentHelperRoute::getArticleRoute ( $elm->slug, $elm->catslug ) . '&limitstart=' . ($index + 1));
				}
				?>
<url>
<loc><?php echo $this->liveSite . JRoute::_ ( $seolink ); ?></loc>
<lastmod><?php echo $modified; ?></lastmod>
<changefreq><?php echo $changefreq;?></changefreq>
<priority><?php echo $priority;?></priority>
</url>
<?php 
			}
		}
	}
}