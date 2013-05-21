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
</li>