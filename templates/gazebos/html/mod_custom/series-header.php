<?php defined('_JEXEC') or die;
	
	$sfx = $params->get( 'moduleclass_sfx' );
	
?>
<div id="series-header" class="<?php echo $sfx; ?>">
	<div class="wrap">
		<?php echo $module->content; ?>
	</div>
</div>