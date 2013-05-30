<?php defined('_JEXEC') or die;  ?>

<div id="sizes-box">
	<div id="sizes-tabs">
		<span>Available Sizes:</span>
		<span>Pricing:</span>
	</div>
	<div class="border"></div>
	<div id="sizes-container">
		<ul>
		<?php foreach ($this->item->sizes as $size) : ?>
			<li>
				<div class="size-title"><?php echo $size->size . ' ' . $this->item->style; ?></div>
				<div class="size-price">Starting at $<?php echo number_format($size->min_price); ?></div>
				<div class="size-button">
					<a rel="fancybox" data-fancybox-type="iframe" class="green-button" href="<?php echo JRoute::_('index.php?option=com_gazebos&view=size&layout=form&tmpl=component&id=' . $size->id); ?>">GET A QUOTE &raquo;</a>
				</div>
				<div class="clear" style="display:block;"></div>
			</li>
		<?php endforeach; ?>
		</ul>
		<p><span>Looking for a different size?</span> Our products can be built to fit your specific needs.</p>
	</div>
</div>
