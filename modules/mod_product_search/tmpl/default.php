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
<div class="search-filter">
	<form action="" method="post" name="searchForm" id="searchForm">
		<h4><?php echo GazebosHelper::getProductTypeTitle(); ?></h4>
		<div class="search">
			<?php echo modProductSearchHelper::getFilters(); ?>
			<input type="hidden" name="task" value="search" />
		</div>
		<input type="hidden" id="producttype" value="<?php echo GazebosHelper::getProductTypeId(); ?>" />
	</form>
</div>