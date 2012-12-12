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

$spec = (object) array(
	'title' => 'Double 2 X 4 Rafters',
	'desc' => 'Give the roof of your gazebo a heavy-duty load capacity and help prevent beam warping.'
);
$spec1 = (object) array(
	'title' => 'Reinforced Connecting Plates (Stainless Steel)',
	'desc' => 'These brackets give your gazebo a greater snow load capacity and higher wind resistance.'
);

$this->item->specs = array($spec,$spec1,$spec,$spec1,$spec,$spec1,$spec,$spec1,$spec,$spec1);
$spec_img_path = '/templates/gazebos/images/dummy-gazebo2.jpg';
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
	 		<p><?php echo $this->item->description; ?></p>
		</div>
		
		<div id="specs" class="panel">
			<img src="<?php echo $spec_img_path; ?>" alt=""/>
			<ul>
		 		<?php foreach ($this->item->specs as $spec) :?>
		 		<li>
		 			<h4><?php echo $spec->title; ?></h4>
		 			<p><?php echo $spec->desc;?></p>
		 		</li>
			 	<?php endforeach; ?>
			</ul>
		</div>
		
		<div id="brochure" class="panel">
			<h2><?php echo $this->item->title; ?></h2>
	 		<p><?php echo $this->item->description; ?></p>
		</div>
		
		<div id="catalog" class="panel">
			<h2><?php echo $this->item->title; ?></h2>
	 		<p><?php echo $this->item->description; ?></p>
		</div>
		
		<div id="quote" class="panel">
			<h2><?php echo $this->item->title; ?></h2>
	 		<p><?php echo $this->item->description; ?></p>
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
