<h3>Sizes &amp; Pricing</h3>
			<table id="product-size-chart">
			<?php foreach ($this->item->sizes as $size) : ?>
				  <?php echo '<tr>';
						echo '<td class="one">'.$size->size . ' ' . $this->item->style.'</td>';
						echo '<td class="two"> Starting at $'.number_format($size->min_price).'</td>';
						$link = JRoute::_('index.php?option=com_gazebos&view=size&id=' . $size->id);
						echo '<td class="three"><a rel="fancybox"
								data-fancybox-type="iframe"
								class="green-button"
								href="'. JRoute::_('index.php?option=com_gazebos&view=size&layout=form&tmpl=component&id=' . $size->id).'">GET A QUOTE &raquo;</a></td>';
						echo '</tr>';?>
				<?php endforeach; ?>
		</table>
		<p><strong>Looking for a different size?</strong> Our products can be built to fit your specific needs.</p>
