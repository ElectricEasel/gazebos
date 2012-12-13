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

//Load admin language file
JFactory::getLanguage()->load('com_gazebos', JPATH_ADMINISTRATOR);
$brochure_img = '/templates/gazebos/images/gazebo-brochure-th.png';
?>
<div class="top-nav">
	<p class="left">Gazebos  &gt;  Vinyl  &gt;  Octagon  &gt;  Country Style</p>
	<p class="right"><a class="back" href="#">&laquo; back to search results</a></p>
</div>
<div id="panels">
	<ul id="tabs">
		<li><a href="#photos">Gazebo Photos</a></li>
		<li><a href="#description">Gazebo Description</a></li>
		<li><a href="#specs">Gazebo Specifications</a></li>
		<li><a href="#brochure">Download Brochure</a></li>
		<li><a href="#catalog">Request Catalog</a></li>
		<li><a href="#quote">Get A Quote</a></li>
	</ul>
	<hr/>
	<h5>Starting At</h5>
	<span class="price-range">$<?php echo $this->item->price_min; ?> - $<?php echo $this->item->price_max; ?></span>
	<hr/>
	<a href="#" class="add2fav brown-grad"><span>Add to Favorites</span></a>
</div>
<div id="panel-container">
<?php if( $this->item ) : ?>
	<div id="photos" class="panel">
	<h2><?php echo $this->item->title; ?></h2>
		<div id="product-gallery">
			<img src="templates/gazebos/images/dummy-gazebo3.jpg">
			<img src="templates/gazebos/images/dummy-gazebo3.jpg">
			<img src="templates/gazebos/images/dummy-gazebo3.jpg">
			
		</div>
		<div id="nav-container">
	 		<ul id="product-gallery-nav">
	 			<li><a href="#"><img src="templates/gazebos/images/dummy-gazebo.jpg"></a></li>
	 			<li><a href="#"><img src="templates/gazebos/images/dummy-gazebo.jpg"></a></li>
	 			<li><a href="#"><img src="templates/gazebos/images/dummy-gazebo.jpg"></a></li>
	 		</ul>
	 		<a id="prev" href="#"></a>
	 		<a id="next" href="#"></a>
		</div>
	</div>
	
	<div id="description" class="panel">
		<h2><?php echo $this->item->title; ?></h2>
		<img src="/media/com_gazebos/gallery/products/<?php echo  $this->item->id . '/thumbs/296x242_' . $this->item->gallery[0]->path ?>" />
 		<p><?php echo $this->item->description; ?></p>
	</div>
	
	<div id="specs" class="panel">
		<h2>Specifications</h2>
		<img src="/media/com_gazebos/gallery/products/<?php echo  $this->item->id . '/thumbs/296x242_' . $this->item->gallery[0]->path ?>" />
		<ul>
	 		<?php
		 	$total = count($this->item->specifications['title']);
	 		for ($i = 0; $i < $total; $i++) :
	 		?>
	 		<li>
	 			<h4><?php echo $this->item->specifications['title'][$i]; ?></h4>
	 			<p><?php echo $this->item->specifications['value'][$i];?></p>
	 		</li>
		 	<?php endfor; ?>
		</ul>
	</div>
	
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
		<h2>Get A Quote</h2>
 		<p><em>Fill out the form below and one of our representatives will contact you to discuss your gazebo options and provide you with a detailed quote.</em></p>
 		<form id="quote-form" action="" method="post">
 			<div class="field-contain">
 				<label for="q-fname">First Name</label>
 				<input type="text" id="q-fname"/>
 			</div>
 			<div class="field-contain">
 				<label for="q-lname">Last Name</label>
 				<input type="text" id="q-lname"/>
 			</div>
 			<div class="field-contain">
 				<label for="q-email">Email Address</label>
 				<input type="text" id="q-email"/>
 			</div>
 			<div class="field-contain">
 				<label for="q-phone">Phone Number</label>
 				<input type="text" id="q-phone"/>
 			</div>
 			
 			<h3><?php echo $this->item->title; ?> Options</h3>
 			
 			<div class="field-contain">
 				<label>Gazebo Size</label>
 				<select>
 					<option id="">Option 1</option>
 					<option id="">Option 2</option>
 					<option id="">Option 3</option>
 				</select>
 			</div>
 			<div class="field-contain">
 				<label>Roof Type</label>
 				<select>
 					<option id="">Option 1</option>
 					<option id="">Option 2</option>
 					<option id="">Option 3</option>
 				</select>
 			</div>
 			<div class="field-contain last">
 				<label>Gazebo Size</label>
 				<select>
 					<option id="">Option 1</option>
 					<option id="">Option 2</option>
 					<option id="">Option 3</option>
 				</select>
 			</div>
 			<br class="clear"/>
 			<div class="field-contain">
 				<span>Screen Package</span>
 				<input type="radio" name="screen" value="yes" /><label>yes</label>
 				<input type="radio" name="screen" value="no" /><label>no</label>
 			</div>
 			<div class="field-contain">
 				<span>Window Package</span>
 				<input type="radio" name="window" value="yes" /><label>yes</label>
 				<input type="radio" name="window" value="no" /><label>no</label>
 			</div>
 			<div class="field-contain last">
 				<span>Electrical Package</span>
 				<input type="radio" name="electrical" value="yes" /><label>yes</label>
 				<input type="radio" name="electrical" value="no" /><label>no</label>
 			</div>
 			
 			<input type="submit" class="green-button" value="Submit Request &gt;"/>
 		</form>
 		
	</div>

	

<?php else: ?>
Could not load the item
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
