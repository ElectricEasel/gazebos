<?php
/**
 * @version     1.0.0
 * @package     com_gazebos
 * @copyright   Copyright (C) 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Don Gilbert <don@electriceasel.com> - http://www.electriceasel.com
 */
defined('_JEXEC') or die;

JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');

$product_id = $this->form->getValue('product_id');

?>
<form action="<?php echo JRoute::_('index.php?option=com_gazebos&layout=edit&id='.(int) $this->form->getValue('id')); ?>" method="post" name="adminForm" id="size-form" class="form-validate" enctype="multipart/form-data">
	<?php if (JRequest::getVar('tmpl') === 'component') : ?>
	<fieldset>
		<div class="fltlft">
			<label>Add New Size / Price Range</label>
		</div>
		<div class="fltrt">
			<button type="button" onclick="Joomla.submitbutton('size.apply');">Save</button>
		</div>
	</fieldset>
	<input type="hidden" name="tmpl" value="component" />
	<?php endif; ?>
	<div class="width-100 fltlft">
		<fieldset class="adminform">
			<ul class="adminformlist">
				<li<?php echo (!empty($product_id)) ? ' style="display:none"' : ''; ?>>
					<?php echo $this->form->getLabel('product_id'), $this->form->getInput('product_id'); ?>
				</li>
				<li><?php echo $this->form->getLabel('size'), $this->form->getInput('size'); ?></li>
				<li><?php echo $this->form->getLabel('min_price'), $this->form->getInput('min_price'); ?></li>
				<li><?php echo $this->form->getLabel('max_price'), $this->form->getInput('max_price'); ?></li>
            </ul>
		</fieldset>
		<fieldset class="adminform">
			<legend>Sizes</legend>
			<table class="adminlist" style="width:500px">
				<thead>
					<tr>
						<th>Size</th>
						<th>Min Price</th>
						<th>Max Price</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
				<?php

				$token = JSession::getFormToken();

				foreach($this->items as $item): ?>
					<tr>
						<td class="center">
							<?php echo $item->size; ?>
						</td>
						<td class="center">
							<?php echo $item->min_price; ?>
						</td>
						<td class="center">
							<?php echo $item->max_price; ?>
						</td>
						<td class="center">
							<a href="index.php?option=com_gazebos&task=sizes.delete&tmpl=component&id=<?php echo $item->id; ?>&product_id=<?php echo $product_id; ?>&<?php echo $token; ?>=1">Delete</a>
							&nbsp;&nbsp;
							<a href="index.php?option=com_gazebos&view=size&layout=edit&tmpl=component&id=<?php echo $item->id; ?>&product_id=<?php echo $product_id; ?>">Edit</a>
						</td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
			<input type="hidden" name="new_ordering" value="" />
		</fieldset>
	</div>

	<input type="hidden" name="task" value="" />
	<?php echo JHtml::_('form.token'); ?>
	<div class="clr"></div>
</form>
<?php
$helptext = JText::_('JGLOBAL_VALIDATION_FORM_FAILED');
JFactory::getDocument()
	->addScript('//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js')
	->addScript('//ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js')
	->addScriptDeclaration("
	// <![CDATA[
		jQuery.noConflict();
		jQuery(document).ready(function($){
			$('#sortable').sortable({
				stop:	function(event, ui)
				{
					var order		= [];
					$('#sortable').find('li').each(function(){
						var base	= $(this);
						var pk		= base.attr('data-pk');
						order.push(pk);
					});
					var xhr = new Request({
						url: 'index.php?option=com_gazebos&tmpl=component&task=size.reorderphotos',
						method: 'get'
					});
					xhr.send('new_order=' + order.join(','));
				}
			});
		});
		Joomla.submitbutton = function(task)
		{
			if (task == 'size.cancel' || document.formvalidator.isValid(document.id('size-form'))) {
				Joomla.submitform(task, document.getElementById('size-form'));
			}
			else {
				alert('{$helptext}');
			}
		}
		function delImage(photo_id)
		{
			if (confirm('Are you sure you want to delete this image?')) {
				var xhr = new Request({
					url: 'index.php?option=com_gazebos&tmpl=component&task=size.delete',
					method: 'get',
					onSuccess: function() {
						el = document.getElementById('deleteImage' + photo_id);
						el.parentNode.removeChild(el);
					},
					onFailure: function() {
						alert('There was an error deleting your image, please refresh the page and try again.');
					}
				});
				xhr.send('id=' + photo_id);
			}
		}
	// ]]>
	")
	->addStyleDeclaration("
        .adminformlist li {
            clear: both;
        }
		#sortable li {
			position: relative;
			float:left;
			clear:none;
		}
		#sortable li span {
			position:absolute;
			top:5px;
			left:0;
			background:red;
			display:block;
			padding:2px 4px;
			cursor:pointer;
			color:#FFF;
		}
	");
