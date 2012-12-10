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
?>

<?php if( $this->item ) : ?>
	<div class="panel">
    	<input type="checkbox" id="photos" />
 		<h2><?php echo $this->item->title; ?></h2>
 		<p><?php echo $this->item->description; ?>
 		</p>
	</div>
	<div id="panels">
		<ul id="tabs">
			<li><a href="">Gazebo Photos</a></li>
			<li><a href="">Gazebo Description</a></li>
			<li><a href="">Gazebo Specification</a></li>
			<li><a href="">Download Brochure</a></li>
			<li><a href="">Request Catalog</a></li>
			<li><a href="">Get A Quote</a></li>
		</ul>
		<hr/>
		<h5>Starting At</h5>
		<span class="price-range">$<?php echo $this->item->price_min; ?> - $<?php echo $this->item->price_max; ?></span>
		<hr/>
	</div> 	

<label for="asdf1">asdf</label>
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
    
<?php else: ?>
    Could not load the item
<?php endif; ?>
