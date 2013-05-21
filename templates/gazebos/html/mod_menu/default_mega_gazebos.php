<?php defined('_JEXEC') or die;

EEComponentHelper::load('Gazebos');

$model = new GazebosModelType;
$model->getState();
// Set it to the gazebos type id.
$model->setState('type.id', 1);
$model->getItem();
$shapes = $model->getShapes();

?>
<div class="mm-col-left">
	<img class="right" src="/templates/gazebos/images/th-gazebo-wood.png" alt="Wood Gazebos"/>
	<h4><a href="<?php echo JRoute::_('index.php?option=com_gazebos&view=material&id=1'); ?>">Wood Gazebos</a></h4>
	<ul class="mega-sub">
		<?php foreach ($shapes as $s) : ?>
		<li class="wood-<?php echo strtolower($s->title); ?>"><a href="<?php echo JRoute::_('index.php?option=com_gazebos&view=shape&id=' . $s->id . '&material_id=1'); ?>">Wood <?php echo $s->title; ?> Gazebos</a></li>
		<?php endforeach; ?>
	</ul>
</div>
<div class="mm-col-mid">
	<img class="right" src="/templates/gazebos/images/th-gazebo-vinyl.png" alt="Vinyl Gazebos"/>
	<h4><a href="<?php echo JRoute::_('index.php?option=com_gazebos&view=material&id=2'); ?>">Vinyl Gazebos</a></h4>
	<ul class="mega-sub">
		<?php foreach ($shapes as $s) : if (strtolower($s->title) === 'decagon') continue; ?>
		<li class="vinyl-<?php echo strtolower($s->title); ?>"><a href="<?php echo JRoute::_('index.php?option=com_gazebos&view=shape&id=' . $s->id . '&material_id=2'); ?>">Vinyl <?php echo $s->title; ?> Gazebos</a></li>
		<?php endforeach; ?>
	</ul>
</div>
<div class="mm-col-right">
	<strong>Gazebos Overview</strong>
	<p>Simple, quiet comfort can be yours with your own handcrafted gazebo. <a href="/gazebos">Learn More &rsaquo;</a></p>
	<strong>Looking For Something A Little Different?</strong>
	<img src="/templates/gazebos/images/th-custom-gazebo.png" alt="Get a custom quote"/>
	<p>We are happy to create a custom look for you! <a href="/custom-quote/">Get Quote &rsaquo;</a></p>
</div>