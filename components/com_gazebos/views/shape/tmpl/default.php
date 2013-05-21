<?php
/**
* @version     1.0.0
* @package     com_gazebos
* @copyright   Copyright (C) 2012. All rights reserved.
* @license     GNU General Public License version 2 or later; see LICENSE.txt
* @author      Don Gilbert <don@electriceasel.com> - http://www.electriceasel.com
*/
defined('_JEXEC') or die;
$app = JFactory::getApplication();
$menu = $app->getMenu();
$body = EEHelper::getBodyClasses();

// echo '<!---'; print_r(EEHelper::getBodyClasses()); echo '-->';

echo $this->loadTemplate('sidebar');
?>
<div class="producttype">
	<?php if ((strpos($body,'pergolas') !== false) || (strpos($body,'pavilions') !== false)) {} else { ?>
		<div class="shapes-available">
			<div class="contain clr">
				<span class="title">Did You Know?</span>
				<span class="descrip">All of our handcrafted gazebos are available in the following shapes and custom sizes:</span>
				<img src="/templates/gazebos/images/shapes-also-available.png" alt="Shapes also available"/>		
			</div>
		</div>
	<?php } ?>
	<h2><?php echo $this->item->material_title . ' ' .  $this->item->title . ' ' . $this->item->type_title; ?>: <span><?php echo count($this->item->products); ?> matching products</span></h2>
	<?php if ($this->item->products !== null) : ?>
	<ul class="product_listing clr">
		<?php foreach ($this->item->products as $i => $product)
		{
			$this->loop_count = $i;
			$this->product = $product;
			echo $this->loadTemplate('product');
		} ?>
	</ul>
	<?php endif; ?>
</div>
