<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_search
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
?>
<form action="" method="post" name="searchForm" id="searchForm">
	<h3><?php echo modProductSearchHelper::getActiveSearch(); ?></h3>
	<div class="search<?php echo $moduleclass_sfx ?>">
		<?php echo modProductSearchHelper::getFilters(); ?>
		<input type="hidden" name="task" value="search" />
	</div>
</form>
