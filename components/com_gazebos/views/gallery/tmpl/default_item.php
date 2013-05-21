<?php defined('_JEXEC') or die;

if (file_exists(JPATH_BASE . "/media/com_gazebos/images/products/{$this->item->id}/thumbs/150x150_{$this->item->image}")) :
?>
	<li>
		<div class="overlay"><a href="<?php echo JRoute::_('index.php?option=com_gazebos&view=product&id=' . $this->item->id); ?>">View<br/>Details</a></div>
		<?php echo EEHtml::asset("products/{$this->item->id}/thumbs/150x150_{$this->item->image}"); ?>
	</li>
<?php endif; ?>