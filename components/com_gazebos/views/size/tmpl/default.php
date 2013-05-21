<?php
/**
* @version     1.0.0
* @package     com_gazebos
* @copyright   Copyright (C) 2012. All rights reserved.
* @license     GNU General Public License version 2 or later; see LICENSE.txt
* @author      Don Gilbert <don@electriceasel.com> - http://www.electriceasel.com
*/
defined('_JEXEC') or die;

$type = GazebosHelper::getProductTypeTitle();
$galleryCount = count($this->item->gallery);
?>
<div id="product-sidebar">
	<div id="product-slideshow" class="clr">
		<div id="gallery-container">
			<ul id="cycle1" class="cycle-slideshow"
				data-cycle-timeout="0"
				data-cycle-slides="> li"
				data-cycle-prev="#gallery-carousel .gallery-prev"
				data-cycle-next="#gallery-carousel .gallery-next"
				data-cycle-fx="fade">
				<?php foreach ($this->item->gallery as $image) : ?>
				<li>
					<?php echo EEHtml::asset('products/' . $image->product_id . '/thumbs/300x300_' . $image->path); ?>
				</li>
				<?php endforeach; ?>
			</ul>
		</div>
		<?php if ($galleryCount > 1) : ?>
		<div id="gallery-carousel">
			<ul id="cycle2" class="cycle-slideshow"
			<?php if ($galleryCount > 3) : ?>
				data-cycle-timeout="0"
				data-cycle-prev="#gallery-carousel .gallery-prev"
				data-cycle-next="#gallery-carousel .gallery-next"
				data-cycle-slides="> li"
				data-cycle-carousel-fluid="true"
				data-cycle-carousel-visible="3"
				data-cycle-fx="carousel"
			<?php endif; ?>
				>
				<?php foreach ($this->item->gallery as $i => $image) : ?>
				<li>
					<?php echo EEHtml::asset('products/' . $image->product_id . '/thumbs/60x60_' . $image->path, 'com_gazebos', array('data-slideindex' => $i)); ?>
				</li>
				<?php endforeach; ?>
			</ul>
			<?php if ($galleryCount > 3) : ?>
			<a href="#" class="gallery-prev">prev</a>
			<a href="#" class="gallery-next">next</a>
			<?php endif; ?>
		</div>
		<?php endif; ?> 
	</div>
	<?php echo $this->loadTemplate('form'); ?>
</div>

<div id="product-content">
	<div class="product-top">
		<div id="price-box">
			Starting at
			<span>$<?php echo number_format($this->item->min_price,0) ?></span>
		</div>
		<h1><?php echo ($this->item->size); ?> <?php echo rtrim($this->item->type_title, 's'); ?></h1>
		<h2 class="product-title"><?php echo $this->item->title; ?></h2>
			<div id="product-description">
				<?php
				if (!empty($this->item->series))
				{
					$Itemid = (int) $this->item->series;
		
					switch ($Itemid)
					{
						case 222:
							$image = 'lake-wood.png';
							break;
						case 223:
							$image = 'cedar-cove.png';
							break;
					}
					echo '<a href="' . JRoute::_('index.php?Itemid=' . $Itemid) . '">'. EEHtml::asset($image, 'com_gazebos', array('class' => 'series-image')) . '</a>';
				}
				echo $this->item->description; ?>
			</div>
		</div>
	
	<ul id="product-tabs" class="clr">
		<?php if (count($this->item->features)) : ?>
		<li><a href="#features">Features</a></li>
		<?php endif; ?>
		<?php if (count($this->item->options)) : ?>
		<li><a href="#options">Options</a></li>
		<?php endif; ?>
		<?php if (count($this->item->colors)) : ?>
		<li><a href="#colors">Colors</a></li>
		<?php endif; ?>
		<?php if (count($this->item->roofing)) : ?>
		<li><a href="#roofing">Roofing</a></li>
		<?php endif; ?>
		<?php if (count($this->item->flooring)) : ?>
		<li><a href="#flooring">Flooring</a></li>
		<?php endif; ?>
	</ul>
	<div id="product-tab-container">
		<div class="border"></div>
		<?php if (count($this->item->features)) : ?>
		<div id="features" class="panel clr">
			<img class="left" src="/templates/gazebos/images/img-warranty-brown.png" alt=""/>
			<h4>Timeless Designs and Quality Craftsmanship</h4>
			<ul class="list">
				<li>Manufactured in the USA for over 30 years</li>
				<li>Engineered to hold up against strong winds, heavy rain and large snowfall</li>
				<li>Built by a team of craftsmen with numerous years of combined experience</li>
				<li>Craftsmanship and materials backed by a limited lifetime warranty</li>
			</ul>
			<ul class="features-list clr">
	
				<?php foreach ($this->item->features as $group => $items) : foreach ($items as $i) : ?>
				<li>
					<img width="128" height="130" src="/<?php echo $i->image; ?>" alt="<?php echo str_replace('"','', $i->title); ?>" />
					<span class="title"><?php echo $i->title; ?></span>
				</li>
				<?php endforeach; endforeach; ?>
			</ul>
		</div>
		<?php endif; ?>
		<?php if (count($this->item->options)) : ?>
		<div id="options" class="panel">
				<?php
				foreach ($this->item->options as $group => $items) : if (strtolower($group) === 'wood type') continue;
					echo '<h4>' . $group . '</h4>';
					echo '<ul class="features-list clr">';
					foreach ($items as $i) : ?>
				<li>
					<img src="/<?php echo $i->image; ?>" alt="<?php echo $i->title; ?>" />
					<span class="title"><?php echo $i->title; ?></span>
				</li>
				<?php endforeach;
				echo '</ul>';
				endforeach; ?>
		</div>
		<?php endif; ?>
		<?php if (count($this->item->colors)) : ?>
		<div id="colors" class="panel">
			<ul class="features-list clr">
				<?php
				foreach ($this->item->colors as $group => $items) :
					echo '<h4>' . $group . '</h4>';
					echo '<ul class="features-list clr">';
					foreach ($items as $i) : ?>
				<li>
					<img width="104" height="38" src="/<?php echo $i->image; ?>" alt="<?php echo $i->title; ?>" />
					<span class="title"><?php echo $i->title; ?></span>
				</li>
				<?php endforeach;
				echo '</ul>';
				endforeach; ?>
			</ul>
		</div>
		<?php endif; ?>
		<?php if (count($this->item->roofing)) : ?>
		<div id="roofing" class="panel">
				<?php
				foreach ($this->item->roofing as $group => $items) :
					echo '<h4>' . $group . '</h4>';
					echo '<ul class="features-list clr">';
					foreach ($items as $i) : ?>
				<li>
					<img width="78" height="78" src="/<?php echo $i->image; ?>" alt="<?php echo $i->title; ?>" />
					<span class="title"><?php echo $i->title; ?></span>
				</li>
				<?php endforeach;
				echo '</ul>';
				endforeach; ?>
		</div>
		<?php endif; ?>
		<?php if (count($this->item->flooring)) : ?>
		<div id="flooring" class="panel">
				<?php
				foreach ($this->item->flooring as $group => $items) :
					echo '<h4>' . $group . '</h4>';
					echo '<ul class="features-list clr">';
					foreach ($items as $i) : ?>
				<li>
					<img width="78" height="78" src="/<?php echo $i->image; ?>" alt="<?php echo $i->title; ?>" />
					<span class="title"><?php echo $i->title; ?></span>
				</li>
				<?php endforeach;
				echo '</ul>';
				endforeach; ?>
		</div>
		<?php endif; ?>
	</div>
</div>
