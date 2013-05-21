<?php defined('_JEXEC') or die;

EEComponentHelper::load('Gazebos');

$model = new GazebosModelType;
$model->getState();
// Set it to the gazebos type id.
$model->setState('type.id', 2);
$model->getItem();
$shapes = $model->getShapes();

?>
<div class="mm-col-left">
	<img class="right" src="/templates/gazebos/images/th-pergola-wood.png" alt="Wood Pergolas"/>
	<h4><a href="<?php echo JRoute::_('index.php?option=com_gazebos&view=material&id=3'); ?>">Wood Pergolas</a></h4>
	<ul class="mega-sub">
		<?php foreach ($shapes as $s) : ?>
		<li class="wood-<?php echo strtolower($s->title); ?>"><a href="<?php echo JRoute::_('index.php?option=com_gazebos&view=shape&id=' . $s->id . '&material_id=3'); ?>">Wood <?php echo $s->title; ?> Pergolas</a></li>
		<?php endforeach; ?>
	</ul>
</div>
<div class="mm-col-mid">
	<img class="right" src="/templates/gazebos/images/th-pergola-vinyl.png" alt="Vinyl Pergolas"/>
	<h4><a href="<?php echo JRoute::_('index.php?option=com_gazebos&view=material&id=4'); ?>">Vinyl Pergolas</a></h4>
	<ul class="mega-sub">
		<?php foreach ($shapes as $s) : ?>
		<li class="vinyl-<?php echo strtolower($s->title); ?>"><a href="<?php echo JRoute::_('index.php?option=com_gazebos&view=shape&id=' . $s->id . '&material_id=4'); ?>">Vinyl <?php echo $s->title; ?> Pergolas</a></li>
		<?php endforeach; ?>
	</ul>
</div>
<div class="mm-col-right">
	<strong>Pergolas Overview</strong>
	<p>Add a touch of elegance to your backyard with a handcrafted pergola. <a href="/pergolas">Learn More &gt;</a></p>
	<strong>Looking For Something A Little Different?</strong>
	<img src="/templates/gazebos/images/th-custom-pergola.png" alt="Get a custom quote"/>
	<p>We are happy to create a custom look for you! <a href="/custom-quote">Get Quote &gt;</a></p>
</div>