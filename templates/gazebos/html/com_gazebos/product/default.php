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
$lang = JFactory::getLanguage();
$lang->load('com_gazebos', JPATH_ADMINISTRATOR);

$spec_img_path = '/templates/gazebos/images/dummy-gazebo2.jpg';
$brochure_img = '/templates/gazebos/images/gazebo-brochure-th.png';
?>

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
			<?php echo EEImageHelper::getThumb('com_gazebos/gallery/products/' . $this->item->id . '/' . $this->item->gallery[0]->path, '296x242'); ?>
	 		<p><?php echo $this->item->description; ?></p>
		</div>
		
		<div id="specs" class="panel">
			<h2>Specifications</h2>
			<?php echo EEImageHelper::getThumb('com_gazebos/gallery/products/' . $this->item->id . '/' . $this->item->gallery[0]->path, '296x242'); ?>
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
	 			
	 			<input type="submit" class="green-button" value="Submit Request &gt;"/>
	 		</form>
	 		
		</div>

	<!--
    <div class="item_fields">
        
        <ul class="fields_list">

			<li><?php echo JText::_('COM_GAZEBOS_FORM_LBL_PRODUCT_ID'); ?>:
			<?php echo $this->item->id; ?></li>
			<li><?php echo JText::_('COM_GAZEBOS_FORM_LBL_PRODUCT_ORDERING'); ?>:
			<?php echo $this->item->ordering; ?></li>
			<li><?php echo JText::_('COM_GAZEBOS_FORM_LBL_PRODUCT_STATE'); ?>:
			<?php echo $this->item->state; ?></li>
			<li><?php echo JText::_('COM_GAZEBOS_FORM_LBL_PRODUCT_CHECKED_OUT'); ?>:
			<?php echo $this->item->checked_out; ?></li>
			<li><?php echo JText::_('COM_GAZEBOS_FORM_LBL_PRODUCT_CHECKED_OUT_TIME'); ?>:
			<?php echo $this->item->checked_out_time; ?></li>
			<li><?php echo JText::_('COM_GAZEBOS_FORM_LBL_PRODUCT_CREATED_BY'); ?>:
			<?php echo $this->item->created_by; ?></li>
			<li><?php echo JText::_('COM_GAZEBOS_FORM_LBL_PRODUCT_TITLE'); ?>:
			<?php echo $this->item->title; ?></li>
			<li><?php echo JText::_('COM_GAZEBOS_FORM_LBL_PRODUCT_TYPE_ID'); ?>:
			<?php echo $this->item->type_id; ?></li>
			<li><?php echo JText::_('COM_GAZEBOS_FORM_LBL_PRODUCT_STYLE_ID'); ?>:
			<?php echo $this->item->style_id; ?></li>
			<li><?php echo JText::_('COM_GAZEBOS_FORM_LBL_PRODUCT_SHAPE_ID'); ?>:
			<?php echo $this->item->shape_id; ?></li>
			<li><?php echo JText::_('COM_GAZEBOS_FORM_LBL_PRODUCT_MATERIAL_ID'); ?>:
			<?php echo $this->item->material_id; ?></li>
			<li><?php echo JText::_('COM_GAZEBOS_FORM_LBL_PRODUCT_SHORT_DESCRIPTION'); ?>:
			<?php echo $this->item->short_description; ?></li>
			<li><?php echo JText::_('COM_GAZEBOS_FORM_LBL_PRODUCT_DESCRIPTION'); ?>:
			<?php echo $this->item->description; ?></li>
			<li><?php echo JText::_('COM_GAZEBOS_FORM_LBL_PRODUCT_PRICE_MIN'); ?>:
			<?php echo $this->item->price_min; ?></li>
			<li><?php echo JText::_('COM_GAZEBOS_FORM_LBL_PRODUCT_PRICE_MAX'); ?>:
			<?php echo $this->item->price_max; ?></li>
			<li><?php echo JText::_('COM_GAZEBOS_FORM_LBL_PRODUCT_BROCHURE'); ?>:
			<?php echo $this->item->brochure; ?></li>
			<li><?php echo JText::_('COM_GAZEBOS_FORM_LBL_PRODUCT_OPTIONS'); ?>:
			<?php echo $this->item->options; ?></li>


        </ul>
        
    </div>
    -->
    
<?php else: ?>
    Could not load the item
<?php endif; ?>
</div>
