<?php defined('_JEXEC') or die;

$wood_id = $vinyl_id = 0;

switch ($this->item->type_id)
{
	case 1: // Gazebos
		$wood_id = 1;
		$vinyl_id = 2;
		break;
	case 2: // Pergolas
		$wood_id = 3;
		$vinyl_id = 4;
		break;
	case 3: // Pavilions
		$wood_id = 5;
		$vinyl_id = 6;
		break;
	case 4: // 3 Seasons
		$wood_id = 7;
		$vinyl_id = 8;
		break;
	
}
$image = rtrim(($this->item->type_title), 's');
$image = str_replace(" ", "-", strtolower($image));

$app = JFactory::getApplication();
$active_view = $app->input->get('view');
$active_shape = $app->input->getInt('id');
$active_material = $app->input->getInt('material_id');
?>
<div id="types-sidebar">
	<div class="types-contain">
		<div class="types-module">
			<form id="wood-type-sort" style="display:none" action="<?php echo JRoute::_('index.php?option=com_gazebos&view=shape&id=' . $this->item->id . '&material_id=' . $this->state->get('material.id')); ?>" method="post">
				<div class="checkboxes">
					<?php // echo $this->woodTypes; ?>
					<input class="styled" type="radio" name="filter_wood_type" value="109" id="filter_wood_type_cedar" onclick="this.form.submit();" /><label for="filter_wood_type_cedar">Cedar</label>
					<input class="styled" type="radio" name="filter_wood_type" value="110" id="filter_wood_type_pine" onclick="this.form.submit();" /><label for="filter_wood_type_pine">Pine</label>
				</div>
			</form>
			<h3><?php echo $this->item->type_title; ?></h3>
			<ul class="types-menu clear">
				<li class="title<?php echo ($active_view == 'material' && $active_shape == $wood_id) ? ' active': ''; ?>">
					<img alt="" src="/templates/gazebos/images/th-<?php echo $image; ?>-wood.png" class="wood <?php echo rtrim(strtolower($this->item->type_title), 's'); ?>" />
					<a href="<?php echo JRoute::_('index.php?option=com_gazebos&view=material&id=' . $wood_id); ?>">All Wood <?php echo $this->item->type_title; ?></a>
				</li>
				<?php foreach ($this->item->shapes as $s) : ?>
				<li class="wood-<?php echo $s->alias; echo ($active_shape == $s->id && $active_material == $wood_id) ? ' active': ''; ?>">
					<a href="<?php echo JRoute::_('index.php?option=com_gazebos&view=shape&id=' . $s->id . '&material_id=' . $wood_id); ?>">Wood <?php echo $s->title; ?></a>
				</li>
				<?php endforeach; ?>
			</ul>
			<hr/>
			<ul class="types-menu">
				<li class="title<?php echo ($active_view == 'material' && $active_shape == $vinyl_id) ? ' active': ''; ?>">
					<img alt="" src="/templates/gazebos/images/th-<?php echo $image; ?>-vinyl.png" class="vinyl <?php echo rtrim(strtolower($this->item->type_title), 's'); ?>" />
					<a href="<?php echo JRoute::_('index.php?option=com_gazebos&view=material&id=' . $vinyl_id); ?>">All Vinyl <?php echo $this->item->type_title; ?></a>
				</li>
				<?php foreach ($this->item->shapes as $s) : if ($s->alias === 'decagon') continue; ?>
					<li class="vinyl-<?php echo $s->alias; echo ($active_shape == $s->id && $active_material == $vinyl_id) ? ' active': ''; ?>">
						<a href="<?php echo JRoute::_('index.php?option=com_gazebos&view=shape&id=' . $s->id . '&material_id=' . $vinyl_id); ?>">Vinyl <?php echo $s->title; ?></a>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>

	<div class="widget-contain">
		<div id="help" class="widget">
			<div><h5>Need Help?</h5></div>
			<span>1-888-4-GAZEBO</span>
		</div>
	</div>

	<div class="widget-contain">
		<div onclick="document.location = '/about-us/the-gazebos-difference'" style="display:block" id="why-us" class="widget">
			<h5>Why Buy<br/>From Us?</h5>
			<a href="/about-us/the-gazebos-difference">See the Difference</a>
		</div>
	</div>

	<div class="widget-contain">
		<div onclick="document.location = '/about-us/lifetime-warranty'" style="display:block" id="warranty-widget" class="widget">
			<a href="/about-us/lifetime-warranty"><span class="icon"></span><span class="text">Limited Lifetime<span class="upper">Warranty</span></span></a>
		</div>
	</div>
</div>
