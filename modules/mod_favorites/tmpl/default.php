<?php
// no direct access
defined('_JEXEC') or die;

?>
<div id="favorites" class="favorites module<?php echo $moduleclass_sfx ?>">
	<span class="toggle brown-grad"><span>Favorites</span></span>
	<div class="container">
		<div class="wrap">
			<h3><span><span>My Favorites</span></span></h3>
			<div class="contents">
				<?php foreach ($items as $item) echo $item->html; ?>
			</div>
		</div>
	</div>
</div>