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
	<h2><?php echo $type->title; ?></h2>
	<?php if ($type->description) : ?>
	<p><?php echo EEHelper::formatText($type->description, 1000); ?>
	<?php endif; ?>
	<div class="pagination">
		<span class="search-term"><?php echo $type->title; ?></span>
		<label class="search-item" for="mat1">Wood</label><input id="mat1" class="styled" type="checkbox" name="mat1" checked="checked" />
		<label class="search-item" for="shape1">Octagon</label><input id="shape1" class="styled" type="checkbox" name="shape1" checked="checked" />
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
