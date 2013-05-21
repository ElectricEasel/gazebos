<?php
/**
 * @version     1.0.0
 * @package     com_gazebos
 * @copyright   Copyright (C) 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Don Gilbert <don@electriceasel.com> - http://www.electriceasel.com
 */
defined('_JEXEC') or die;

$na = '<img src="/templates/gazebos/images/na.jpg" alt="'. $this->product->title .'"/>';
$image = ($this->product->image === null ? $na : $this->product->image);

?>
<li class="item<?php echo (($this->loop_count % 3) == 0) ? '-last' : ''; ?>">
	<div class="product-contain">
		<div class="image">
			<?php echo $image; ?>
		</div>
		<div class="overlay">
			<a href="<?php echo $this->product->link; ?>">
				View<br/>Details
			</a>
		</div>
		<div class="title">
			<h5><?php echo $this->product->title; ?></h5>
			<span class="price">Starting at <span>$<?php echo number_format($this->product->min_price); ?></span></span>
		</div>
	</div>
</li>