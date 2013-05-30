<?php defined('_JEXEC') or die;  ?>

<div id="sizes-box">
	<div id="sizes-tabs">
		<div>Available Sizes:</div>
		<div>Pricing:</div>
	</div>
	<div id="sizes-container">
		<ul>
		<?php foreach ($this->item->sizes as $size) : ?>
			<li>
				<div class="size-title"><?php echo $size->size; ?></div>
				<div class="size-price">Starting at $<?php echo number_format($size->min_price); ?></div>
				<div class="size-button">
					<a class="fancybox green-button" href="<?php echo JRoute::_('index.php'); ?>">GET A QUOTE &raquo;</a>
				</div>
				<div class="clear" style="display:block;"></div>
			</li>
		<?php endforeach; ?>
		</ul>
	</div>
</div>
