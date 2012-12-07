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
	<h1><?php echo $type->title; ?></h1>
	<?php if ($type->products !== null) : ?>
	<ul class="product_list">
		<?php foreach ($type->products as $product) : ?>
		<li>
			<a href="<?php echo $product->link; ?>"><?php echo $product->title; ?></a>
			<p><?php echo $product->short_description; ?></p>
		</li>
		<?php endforeach; ?>
	</ul>
	<?php endif; ?>
</div>
<?php endif; ?>
