<?php
/**
* @version     1.0.0
* @package     com_gazebos
* @copyright   Copyright (C) 2012. All rights reserved.
* @license     GNU General Public License version 2 or later; see LICENSE.txt
* @author      Don Gilbert <don@electriceasel.com> - http://www.electriceasel.com
*/
defined('_JEXEC') or die;

echo '<!--';
print_r($this->item->alias);
echo '-->';

?>
<div class="fancy-heading">
	<h2><span><?php echo $this->item->title; ?></span> <?php echo $this->item->tagline; ?></h2>
</div>
<?php echo EEHelper::nl2p($this->item->description); ?>
<ul id="product-overview">
	<?php foreach ($this->item->materials as $i => $material) : ?>
	<li<?php echo ($i === 1) ? ' class="middle"' : null; ?>>
		<div class="contain">
			<img src="/templates/gazebos/images/products/overview-<?php echo str_replace(' ', '-', strtolower($this->item->title)); ?>-<?php echo strtolower($material->title); ?>.jpg"/>
			<h4><span><?php echo $material->title; ?> <?php echo $this->item->title; ?></span></h4>
			<?php echo EEHelper::nl2p($material->description); ?>
			<h5><?php echo $material->title; ?> <?php echo rtrim($this->item->title, 's'); ?> Shapes</h5>
			<ul class="model-types clr <?php echo strtolower($material->title); ?>">
				<?php foreach ($this->item->shapes as $i => $shape) :
					if (strtolower($material->title) === 'vinyl' && strtolower($shape->title) === 'decagon' && strtolower($this->item->title) === 'gazebos') continue;
				?>
				<li class="<?php echo strtolower($shape->title); ?>">
					<div class="img-contain">
						<a href="<?php echo JRoute::_('index.php?option=com_gazebos&view=shape&id=' . $shape->id . '&material_id=' . $material->id); ?>">
							<img src="/templates/gazebos/images/products/th-<?php echo str_replace(' ', '-', strtolower($this->item->title)); ?>-<?php echo strtolower($material->title); ?>-<?php echo strtolower($shape->title); ?>.png"/>
						</a>
					</div>
					<a href="<?php echo JRoute::_('index.php?option=com_gazebos&view=shape&id=' . $shape->id . '&material_id=' . $material->id); ?>">
						<?php echo $shape->title; ?> <?php echo $this->item->title; ?>
					</a>
				</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</li>
	<?php endforeach; ?>
	<li>
		<div class="contain">
			<img src="/templates/gazebos/images/products/overview-<?php echo str_replace(' ', '-', strtolower($this->item->title)); ?>-custom.jpg"/>
			<h4><span>Custom <?php echo $this->item->title ?></span></h4>
			<p>Looking for something a little different? At Gazebos.com, we recognize the special needs and unique styles of each of our customers. That’s why we are more than happy to create a custom look just for you - and have the space to do so! If your project requires designs, shapes or sizes that are not available on our website, give us a call! We are excited to help you create the <?php echo rtrim(strtolower($this->item->title), 's'); ?> that will perfectly complement your property. </p>
			<?php if ($this->item->alias === 'gazebos') : ?>
			<p><a href="/gazebo-options">&raquo; View all of our custom gazebo options</a></p>
			<?php endif; ?>
			<span class="call2action">Our friendly, professional and knowledgable staff is here to help you. Please call us at 1-888-4-GAZEBO to get started on planning your custom gazebo or click the button below:</span>
			<a href="/custom-quote" class="green-button">Start Quote &rsaquo;</a>
		</div>
	</li>
</ul>