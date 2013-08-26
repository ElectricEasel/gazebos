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
$sourceTitle = $this->sourceparams->get ( 'title', $this->source->name );
$showtitle =  $this->sourceparams->get ( 'showtitle', 1 );
$openTarget =  $this->sourceparams->get ( 'opentarget', $this->cparams->get ('opentarget') );
$includeExternalLinks =  $this->sourceparams->get ( 'include_external_links', 1 );

if (! $showtitle) {
	$sourceTitle = '&nbsp;';
}
// Get menus object
$menusArray =& JSite::getMenu()->get('_items');

if (count ( $this->source->data )) {
	echo "\n";
	echo '<ul class="jmap_filetree"><li><span class="folder">' . $sourceTitle . '</span>';
	$lastlevel = 1;
	$actlevel = 1;
	echo $ul;
	$close = '</ul>';
	$liclose = '';
	 
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
		
		// Final subdesc to get always absolute url
		$link = preg_match('/http/i', $link) ? $link : $this->liveSite . $link ;
		// Final sanitize security safe
		$link = htmlentities($link, null, null, false);
		
		$actlevel = $elm->sublevel;
		if ($lastlevel == $actlevel) {
			echo $liclose;
			echo '<li>' . '<a target="' . $openTarget . '" href="' . $link . '" >' . $elm->name . '</a>';
			$liclose = '</li>';
		} else {
			if ($lastlevel < $actlevel) {
				echo "<ul>\n";
				echo '<li>' . '<a target="' . $openTarget . '" href="' . $link . '" >' . $elm->name . '</a>';
				$liclose = '</li>';
			} else {
				$diff = $lastlevel - $actlevel;
				for($i = 1; $i <= $diff; $i ++) {
					echo "</li></ul>\n";
				}
				echo $liclose;
				echo '<li>' . '<a target="' . $openTarget . '" href="' . $link . '" >' . $elm->name . '</a>';
				$liclose = '</li>';
			}
		}
		$lastlevel = $elm->sublevel;
		echo "\n";
	}
	if ($lastlevel == 0) {
		echo $liclose;
		echo $close;
		echo $liclose;
		echo $close;
	} else {
		for($i = 0; $i <= $lastlevel; $i ++) {
			echo "</li> </ul>\n";
		}
	}
}
	

