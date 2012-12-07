<?php defined('_JEXEC') or die;

$item = $this->item;
?>
<li class="type">
	<img class="preview" src="<?php echo $item->image; ?>" alt="<?php echo $item->title; ?>"/>
	<img class="icon" src="<?php echo $item->icon; ?>" alt=""/>
	<h3><?php echo $item->title; ?></h3>
	<h4><?php echo $item->tagline; ?></h4>
	<div class="description">
		<?php echo $item->description; ?>
	</div>
	<ul class="links">
		<li><a href="<?php echo JRoute::_('index.php?option=com_gazebos&view=producttype&id=' . (int)$item->id); ?>"><?php echo $item->title; ?> By Shape</a></li>
		<li><a href="<?php echo JRoute::_('index.php?option=com_gazebos&view=producttype&id=' . (int)$item->id); ?>"><?php echo $item->title; ?> By Material</a></li>
		<li><a href="<?php echo JRoute::_('index.php?option=com_gazebos&view=producttype&id=' . (int)$item->id); ?>"><?php echo $item->title; ?> By Style</a></li>
	</ul>
	
	
		
</li>