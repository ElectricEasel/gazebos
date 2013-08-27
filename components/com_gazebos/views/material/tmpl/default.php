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
	<?php if ($this->item->title === 'Wood' && $this->item->wood_types) : ?>
	<div id="wood_type_filter">
		<form action="" method="post" name="filter_type_form">
			<span>Filter By:</span>&nbsp;&nbsp;
			<?php
			$options = array(
				(object) array('value' => 'both', 'text' => 'Show all wood types')
			);
			
			foreach ($this->item->wood_types as $type)
			{
				$options[] = (object) array('value' => $type->id, 'text' => $type->title);
			}
			
			$attribs = array('onchange' => 'this.form.submit()');
			
			echo EEHtmlSelect::radiolist($options, 'filter_wood_type', $attribs, 'value', 'text', $this->state->get('filter.wood_type', 'both'));
			?>
		</form>
		<div class="clear"></div>
	</div>
	<?php endif; ?>
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
