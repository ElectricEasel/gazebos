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

    <div class="item_fields">
        
        <ul class="fields_list">

			<li><?php echo JText::_('COM_GAZEBOS_FORM_LBL_PRODUCTTYPE_ID'); ?>:
			<?php echo $this->item->id; ?></li>
			<li><?php echo JText::_('COM_GAZEBOS_FORM_LBL_PRODUCTTYPE_ORDERING'); ?>:
			<?php echo $this->item->ordering; ?></li>
			<li><?php echo JText::_('COM_GAZEBOS_FORM_LBL_PRODUCTTYPE_STATE'); ?>:
			<?php echo $this->item->state; ?></li>
			<li><?php echo JText::_('COM_GAZEBOS_FORM_LBL_PRODUCTTYPE_CHECKED_OUT'); ?>:
			<?php echo $this->item->checked_out; ?></li>
			<li><?php echo JText::_('COM_GAZEBOS_FORM_LBL_PRODUCTTYPE_CHECKED_OUT_TIME'); ?>:
			<?php echo $this->item->checked_out_time; ?></li>
			<li><?php echo JText::_('COM_GAZEBOS_FORM_LBL_PRODUCTTYPE_CREATED_BY'); ?>:
			<?php echo $this->item->created_by; ?></li>
			<li><?php echo JText::_('COM_GAZEBOS_FORM_LBL_PRODUCTTYPE_TITLE'); ?>:
			<?php echo $this->item->title; ?></li>
			<li><?php echo JText::_('COM_GAZEBOS_FORM_LBL_PRODUCTTYPE_ICON'); ?>:
			<?php echo $this->item->icon; ?></li>
			<li><?php echo JText::_('COM_GAZEBOS_FORM_LBL_PRODUCTTYPE_IMAGE'); ?>:
			<?php echo $this->item->image; ?></li>
			<li><?php echo JText::_('COM_GAZEBOS_FORM_LBL_PRODUCTTYPE_TAGLINE'); ?>:
			<?php echo $this->item->tagline; ?></li>
			<li><?php echo JText::_('COM_GAZEBOS_FORM_LBL_PRODUCTTYPE_DESCRIPTION'); ?>:
			<?php echo $this->item->description; ?></li>


        </ul>
        
    </div>
    
<?php else: ?>
    Could not load the item
<?php endif; ?>
