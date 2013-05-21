<?php defined('_JEXEC') or die; ?>
<form id="gallery-control" action="<?php echo JRoute::_('index.php?option=com_gazebos&view=gallery'); ?>" method="post">
	<label style="position:absolute;top:44px;left:630px;font-size:16px;color:#355A06">View By Type:</label>
	<?php echo $this->typeSelect; ?>
</form>
<h2 class="bottom-border" style="margin-top:0"><img src="/templates/gazebos/images/icon-photos.png" alt="" />Photo Gallery</h2>
<ul id="gallery-list">
	<?php foreach ($this->items as $item)
	{
		$this->item = $item;
		echo $this->loadTemplate('item');
	}
	?>
</ul>