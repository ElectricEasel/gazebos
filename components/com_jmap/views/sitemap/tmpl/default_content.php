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

$ul = '<ul>';
$catsave = null;
$close = '';
$showPageBreaks = $this->cparams->get ( 'show_pagebreaks', 1 );
$openTarget =  $this->sourceparams->get ( 'opentarget', $this->cparams->get ('opentarget') );

if (count ( $this->source->data ) != 0) {
	require_once (JPATH_BASE . DS . 'components' . DS . 'com_content' . DS . 'helpers' . DS . 'route.php');
	$first = true;
	
	foreach ( $this->source->data as $elm ) {
		// Set for empty category root nodes that should not be clickable
		$noExpandableNode = $elm->id ? '' : ' noexpandable';
		if ($elm->catid != $catsave && ! $first) {
			echo '</ul></li></ul>';
			echo '<ul class="jmap_filetree" style="margin-left:' . (15 * ($elm->level - 1)) . 'px"><li class="' . $noExpandableNode . '"><span class="folder">' . $elm->category . '</span>';
			echo $ul;
			$catsave = $elm->catid;
		} else {
			if ($first) {
				echo '<ul class="jmap_filetree" style="margin-left:' . (15 * ($elm->level - 1)) . 'px"><li class="' . $noExpandableNode . '"><span class="folder">' . $elm->category . '</span>';
				echo $ul;
				$first = false;
				$catsave = $elm->catid;
			}
		}
		
		$seolink = JRoute::_ ( $elm->link );
		if (@$elm->slug) {
			$seolink = JRoute::_ ( ContentHelperRoute::getArticleRoute ( $elm->slug, $elm->catslug ) );
		}
		echo '<li>' . '<a target="' . $openTarget . '" href="' . $seolink . '" >' . $elm->title . '</a>';
		
		if(!empty($elm->expandible) && $showPageBreaks) {
			echo '<ul>';
			foreach ($elm->expandible as $index=>$subPageBreak) {
				$seolink = JRoute::_ ( $elm->link . '&limitstart=' . ($index + 1));
				if (@$elm->slug) {
					$seolink = JRoute::_ ( ContentHelperRoute::getArticleRoute ( $elm->slug, $elm->catslug ) . '&limitstart=' . ($index + 1));
				}
				echo '<li>' . '<a target="' . $openTarget . '" href="' . $seolink . '" >' . $subPageBreak . '</a></li>';
			}
			echo '</ul>';
		}
		echo '</li>';
	}
	
	echo '</ul></li></ul>';
}