<?php
/**
* @version     1.0.0
* @package     com_gazebos
* @copyright   Copyright (C) 2012. All rights reserved.
* @license     GNU General Public License version 2 or later; see LICENSE.txt
* @author      Don Gilbert <don@electriceasel.com> - http://www.electriceasel.com
*/

// no direct access
defined('_JEXEC') or die;

$type = $this->item;

if($type) : ?>
<div class="producttype">
	<h2><?php echo $type->title; ?>: <span><?php echo count($type->products); ?> matching products</span></h2>
	<div class="pagination">
		<span class="search-term">Your Selections:&nbsp;</span>
		<?php echo $this->queryItems; ?>
	</div>
	<?php if ($type->products !== null) : ?>
	<ul class="product_listing">
		<?php foreach ($type->products as $product)
		{
			$this->product = $product;
			echo $this->loadTemplate('product');
		} ?>
	</ul>
	<?php endif; ?>
</div>
<?php endif; ?>
