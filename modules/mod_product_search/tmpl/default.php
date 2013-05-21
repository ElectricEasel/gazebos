<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_search
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
JFactory::getDocument()->addStyleDeclaration('
#loading {
	display:none;
	position:absolute;
	top:0;
	left:0;
	background:rgba(181, 163, 145, 0.7);
	width:240px;
	height:100%
}
.module.search-filter{
	position:relative;
}
#content .producttype .pagination .search-term {
	float:left;
}
#content .producttype .pagination ul {
	float:left;
	list-style:none;
	margin:0 0 10px 0;
	padding:0;
	width:580px;
}
#content .producttype .pagination ul li {
	float:left;
	margin-right:10px;
	padding:5px;
	background:rgba(118, 94, 79, 0.8);
	color:#FFF;
	margin-bottom:10px;
	cursor:pointer;
	border-radius:3px;
}
#content .producttype h2 {
	margin-top:0;
}
#content .producttype .pagination ul li:hover {
	background:rgba(118, 94, 79, 1);
}
#content .producttype .pagination ul li .checkbox {
	margin:0;
}
');
?>
<div class="search-filter">
	<div id="loading"></div>
	<form action="" method="post" name="searchForm" id="searchForm">
		<h4><?php echo GazebosHelper::getProductTypeTitle(); ?></h4>
		<div class="search">
			<?php echo modProductSearchHelper::getFilters(); ?>
			<input type="hidden" name="task" value="search" />
		</div>
		<input type="hidden" name="producttype" id="producttype" value="<?php echo GazebosHelper::getProductTypeId(); ?>" />
	</form>
</div>