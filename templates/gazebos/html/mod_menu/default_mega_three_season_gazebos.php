<?php defined('_JEXEC') or die;

EEComponentHelper::load('Gazebos');

$model = new GazebosModelType;
$model->getState();
// Set it to the gazebos type id.
$model->setState('type.id', 4);
$model->getItem();
$shapes = $model->getShapes();

?>
<div class="mm-col-left">
	<img class="right nopad" src="/templates/gazebos/images/th-three-season-gazebo-wood.png" alt="Wood Three Season Gazebos"/>
	<h4><a href="<?php echo JRoute::_('index.php?option=com_gazebos&view=material&id=7'); ?>">Wood Three <br/>Season Gazebos</a></h4>
	<ul class="mega-sub">
		<?php foreach ($shapes as $s) : ?>
		<li class="wood-<?php echo strtolower($s->title); ?>"><a href="<?php echo JRoute::_('index.php?option=com_gazebos&view=shape&id=' . $s->id . '&material_id=7'); ?>">Wood <?php echo $s->title; ?> 3 Season</a></li>
		<?php endforeach; ?>
	</ul>
</div>
<div class="mm-col-mid">
	<img class="right" src="/templates/gazebos/images/th-three-season-gazebo-vinyl.png" alt="Vinyl Three Season Gazebos"/>
	<h4><a href="<?php echo JRoute::_('index.php?option=com_gazebos&view=material&id=8'); ?>">Vinyl Three <br/> Season Gazebos</a></h4>
	<ul class="mega-sub">
		<?php foreach ($shapes as $s) : if (strtolower($s->title) === 'decagon') continue; ?>
		<li class="vinyl-<?php echo strtolower($s->title); ?>"><a href="<?php echo JRoute::_('index.php?option=com_gazebos&view=shape&id=' . $s->id . '&material_id=8'); ?>">Vinyl <?php echo $s->title; ?> 3 Season</a></li>
		<?php endforeach; ?>
	</ul>
</div>
<div class="mm-col-right">
	<strong>3 Season Overview</strong>
	<p>Our three season gazebos offer a beautiful interior outside of your home. <a href="/three-season-gazebos">Learn More &gt;</a></p>
	<strong>Looking For Something A Little Different?</strong>
	<img src="/templates/gazebos/images/th-custom-3season.png" alt="Get a custom quote"/>
	<p>We are happy to create a custom look for you! <a href="/custom-quote">Get Quote &gt;</a></p>
</div>