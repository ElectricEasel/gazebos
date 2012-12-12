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

JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');

?>
<form action="<?php echo JRoute::_('index.php?option=com_gazebos&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="gallery-form" class="form-validate" enctype="multipart/form-data">
	<?php if (JRequest::getVar('tmpl') === 'component') : ?>
	<fieldset>
		<div class="fltlft">
			<label>Add New Gallery Photo</label>
		</div>
		<div class="fltrt">
			<button type="button" onclick="Joomla.submitbutton('gallery.apply');">Add Photo</button>
			<button type="button" onclick="window.parent.SqueezeBox.close();">Close</button>
		</div>
	</fieldset>
	<input type="hidden" name="tmpl" value="component" />
	<?php endif; ?>
	<div class="width-100 fltlft">
		<fieldset class="adminform">
			<ul class="adminformlist">
				<li<?php echo (JRequest::getInt('product_id')) ? ' style="display:none"' : ''; ?>>
					<?php echo $this->form->getLabel('product_id'), $this->form->getInput('product_id'); ?>
				</li>
				<li><?php echo $this->form->getLabel('path'), $this->form->getInput('path'); ?></li>
            </ul>
		</fieldset>
		<fieldset class="adminform">
			<legend>Gallery</legend>
			<ul class="adminformlist" id="sortable">
			<?php foreach($this->getGallery() as $photo) {
				$img = '/media/com_gazebos/gallery/products/' . JRequest::getInt('product_id') . '/thumbs/' . $photo->path;
				$img = EEImageHelper::getThumbPath($img, '150x150');
				if (is_file(JPATH_SITE . $img))
				{
					echo '
					<li data-pk="'.$photo->id.'" id="deleteImage'.$photo->id.'">
						<span title="Delete this image." onclick="delImage('.$photo->id.')">
							Delete
						</span>
						<img src="' . $img . '" />
					</li>';
				}
			} ?>
			</ul>
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
						url: 'index.php?option=com_gazebos&tmpl=component&task=gallery.reorderphotos',
						method: 'get'
					});
					xhr.send('new_order=' + order.join(','));
				}
			});
		});
		Joomla.submitbutton = function(task)
		{
			if (task == 'gallery.cancel' || document.formvalidator.isValid(document.id('gallery-form'))) {
				Joomla.submitform(task, document.getElementById('gallery-form'));
			}
			else {
				alert('{$helptext}');
			}
		}
		function delImage(photo_id)
		{
			if (confirm('Are you sure you want to delete this image?')) {
				var xhr = new Request({
					url: 'index.php?option=com_gazebos&tmpl=component&task=gallery.delete',
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