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

$type = GazebosHelper::getProductTypeTitle();
$brochure_img = '/templates/gazebos/images/gazebo-brochure-th.png';
?>
<div class="top-nav">
	<p class="right"><a class="back" href="#">&laquo; back to search results</a></p>
</div>
<div id="panels">
	<ul id="tabs">
		<li><a href="#photos"><?php echo JText::_($type . ' Photos'); ?></a></li>
		<li><a href="#description"><?php echo JText::_($type . ' Description'); ?></a></li>
		<li><a href="#features"><?php echo JText::_($type . ' Features'); ?></a></li>
		<li><a href="#brochure"><?php echo JText::_('Download Brochure'); ?></a></li>
		<li><a href="#catalog"><?php echo JText::_('Request Catalog'); ?></a></li>
		<li><a href="#quote"><?php echo JText::_('Get A Quote'); ?></a></li>
	</ul>
	<hr/>
	<h5>Starting At</h5>
	<span class="price-range">$<?php echo $this->item->price_min; ?> - $<?php echo $this->item->price_max; ?></span>
	<hr/>
	<a href="#" id="add-<?php echo $this->item->id; ?>" class="add2fav brown-grad"><span>Add to Favorites</span></a>
</div>
<div id="panel-container">
<?php if( $this->item ) : ?>
	<div id="photos" class="panel">
		<h2><?php echo $this->item->title; ?></h2>
		<p><?php echo nl2br($this->item->short_description); ?></p>
	    <div id="slides">
	    	<?php foreach ($this->item->gallery as $photo)
	    	{
	    		echo EEHtml::asset("products/{$this->item->id}/thumbs/660x450_{$photo->path}");
	    	} ?>
	    </div>
        <div id="carousel-container">
	        <ul id="carousel">
	    	<?php $i=0; foreach ($this->item->gallery as $photo)
	    	{
	    		$html = array();
	    		$html[] = '<li data-slide="' . $i . '">';
	    		$html[] = EEHtml::asset("products/{$this->item->id}/thumbs/165x130_{$photo->path}");
	    		$html[] = '</li>';

	    		echo implode($html);
		    	$i++;
	    	} ?>
			</ul>
        </div>
	</div>
	<div id="description" class="panel">
		<h2><?php echo $this->item->title; ?></h2>
		<?php if (count($this->item->gallery) > 0) EEHtml::asset("products/{$this->item->id}/thumbs/296x242_{$this->item->gallery[0]->path}"); ?>
 		<p><?php echo nl2br($this->item->description); ?></p>
	</div>
	<?php if (count($this->item->features) > 0) : ?>
	<div id="features" class="panel">
		<h2>Features</h2>
 		<?php
 		foreach ($this->item->features as $feature) :
 		?>
 		<div class="feature">
 			<img src="/<?php echo $feature->image; ?>" alt="<?php echo $this->item->title . ': ' . $feature->title; ?>" />
 			<h4><?php echo $feature->title; ?></h4>
 		</div>
	 	<?php endforeach; ?>
	</div>
	<?php endif; ?>
	<div id="brochure" class="panel">
		<img id="brochure-img" src="<?php echo $brochure_img; ?>"/>
		<h2>Download Brochure</h2>
 		<p><em>Submit your name and email address to download our gazebo brochure.</em></p>
 		<form id="brochure-download" action="" method="post">
 			<label for="b-name">Name</label>
 			<input type="text" id="b-name"/>
 			<label for="b-email">Email Address</label>
 			<input type="text" id="b-email"/>
 			<input type="submit" class="green-button" value="Download &gt;"/>
 		</form>
	</div>
	
	<div id="catalog" class="panel">
		<img id="brochure-img" src="<?php echo $brochure_img; ?>"/>
		<h2>Request Catalog</h2>
 		<p><em>Submit your name and email address to receive our gazebo catalog.</em></p>
 		<form id="catalog-request" action="" method="post">
 			<label for="c-name">Name</label>
 			<input type="text" id="c-name"/>
 			<label for="c-email">Email Address</label>
 			<input type="text" id="c-email"/>
 			<input type="submit" class="green-button" value="Submit Request &gt;"/>
 		</form>
	</div>
	
	<div id="quote" class="panel">
 		<?php echo $this->loadTemplate('form'); ?>
	</div>
<?php endif; ?>
</div>
<br class="clear"/>

<div id="related-products">
	<h3>You May Also Like</h3>
	<ul class="product_listing">
		<li><a href="#"><img src="/templates/gazebos/images/dummy-gazebo.jpg"></a>
			<h5>Cedar Octagon Colonial Style Gazebo</h5>
			<span class="price">starting at $1,800</span>
		</li>
		<li><a href="#"><img src="/templates/gazebos/images/dummy-gazebo.jpg"></a>
			<h5>Cedar Octagon Colonial Style Gazebo</h5>
			<span class="price">starting at $1,800</span>
		</li>
		<li><a href="#"><img src="/templates/gazebos/images/dummy-gazebo.jpg"></a>
			<h5>Cedar Octagon Colonial Style Gazebo</h5>
			<span class="price">starting at $1,800</span>
		</li>
		<li><a href="#"><img src="/templates/gazebos/images/dummy-gazebo.jpg"></a>
			<h5>Cedar Octagon Colonial Style Gazebo</h5>
			<span class="price">starting at $1,800</span>
		</li>
		<li><a href="#"><img src="/templates/gazebos/images/dummy-gazebo.jpg"></a>
			<h5>Cedar Octagon Colonial Style Gazebo</h5>
			<span class="price">starting at $1,800</span>
		</li>
		
	</ul>
</div>
