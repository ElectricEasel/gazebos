<?php defined('_JEXEC') or die;

EEComponentHelper::load('Gazebos');

$model = new GazebosModelType;
$model->getState();
// Set it to the gazebos type id.
$model->setState('type.id', 3);
$model->getItem();
$shapes = $model->getShapes();

?>
<div id="pavilion-mega">
	<div class="mm-col-right">
		<strong>Pavilions Overview</strong>
		<p>Create your very own oasis by adding a pavilion to your outdoor space. <a href="/pavilions">Learn More &gt;</a></p>
		<strong>Looking For Something A Little Different?</strong>
		<img src="/templates/gazebos/images/th-custom-pavilion.png" alt="Get a custom quote"/>
		<p>We are happy to create a custom look for you! <a href="/custom-quote">Get Quote &gt;</a></p>
	</div>
	<div class="mm-col-mid">
		<img class="right" src="/templates/gazebos/images/th-pavilion-vinyl.png" alt="Vinyl Pavilion"/>
		<h4><a href="<?php echo JRoute::_('index.php?option=com_gazebos&view=material&id=6'); ?>">Vinyl<br/>Pavilions</a></h4>
		<ul class="mega-sub">
			<?php foreach ($shapes as $s) : if (strtolower($s->title) === 'decagon') continue; ?>
			<li class="vinyl-<?php echo strtolower($s->title); ?>"><a href="<?php echo JRoute::_('index.php?option=com_gazebos&view=shape&id=' . $s->id . '&material_id=6'); ?>">Vinyl <?php echo $s->title; ?> Pavilions</a></li>
			<?php endforeach; ?>
		</ul>
	</div>
	<div class="mm-col-left">
		<img class="right" src="/templates/gazebos/images/th-pavilion-wood.png" alt="Wood Pavilion"/>
		<h4><a href="<?php echo JRoute::_('index.php?option=com_gazebos&view=material&id=5'); ?>">Wood<br/>Pavilions</a></h4>
		<ul class="mega-sub">
			<?php foreach ($shapes as $s) : ?>
			<li class="wood-<?php echo strtolower($s->title); ?>"><a href="<?php echo JRoute::_('index.php?option=com_gazebos&view=shape&id=' . $s->id . '&material_id=5'); ?>">Wood <?php echo $s->title; ?> Pavilions</a></li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>