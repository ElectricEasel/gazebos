<?php
/**
 * @version     1.0.0
 * @package     com_gazebos
 * @copyright   Copyright (C) 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Don Gilbert <don@electriceasel.com> - http://www.electriceasel.com
 */

// no direct access
defined('_JEXEC') or die; ?>
<li>
	<a href="<?php echo $this->product->link; ?>">
		<img src="templates/gazebos/images/dummy-gazebo.jpg" border="0" />
	</a>
	<h5><?php echo $this->product->title; ?></h5>
	<span class="price">Starting at $<?php echo number_format($this->product->price_min); ?></span>
</li>