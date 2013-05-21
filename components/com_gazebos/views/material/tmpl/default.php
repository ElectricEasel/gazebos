<?php
/**
* @version     1.0.0
* @package     com_gazebos
* @copyright   Copyright (C) 2012. All rights reserved.
* @license     GNU General Public License version 2 or later; see LICENSE.txt
* @author      Don Gilbert <don@electriceasel.com> - http://www.electriceasel.com
*/
defined('_JEXEC') or die;

echo $this->loadTemplate('sidebar');
?>
<div class="producttype">
	<h2><?php echo $this->item->material_title . ' ' .  $this->item->title . ' ' . $this->item->type_title; ?>: <span><?php echo count($this->item->products); ?> matching products</span></h2>
	<?php if ($this->item->products !== null) : ?>
	<ul class="product_listing clr">
		<?php foreach ($this->item->products as $product)
		{
			$this->product = $product;
			echo $this->loadTemplate('product');
		} ?>
	</ul>
	<?php endif; ?>
</div>
