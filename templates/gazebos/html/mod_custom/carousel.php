<?php defined('_JEXEC') or die;

EEComponentHelper::load('Gazebos');

$model = new GazebosModelFeatured;

$featured = $model->getItems();

JFactory::getDocument()
	->addScript('//ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js')
	->addScript('/templates/gazebos/js/jquery.carouFredSel-6.2.0-packed.js')
	->addScriptDeclaration('
	// <![CDATA[
	jQuery(document).ready(function ($) {
	
		var homeCarousel = $("#home-carousel");

		homeCarousel.ready(function () {
			if (homeCarousel.length > 0) {
				homeCarousel.carouFredSel({
					width: 928,
					align: false,
					height: 275,
					items: {
						visible: 4,
						minimum: 3,
						width: 232
					},
					scroll: {
						pauseOnHover: true,
						duration: 900
					},
					prev: {
						button: ".pagingarrow-left",
						key: "left"
					},
					next: {
						button: ".pagingarrow-right",
						key: "right"
					}
				});
			}
		});
	});
	// ]]>');

?>
<div id="carousel-container">
	<h2><span>Featured</span> Gazebos, Pergolas &amp; Pavilions</h2>
	<div class="carousel-wrap">
		<ul id="home-carousel" class="clr">
			<?php foreach ($featured as $f) : ?>
			<li>
				<a href="<?php echo $f->link; ?>">
					<?php echo $f->image; ?>
				</a>
				<span class="title"><?php echo $f->title; ?></span>
				<a href="<?php echo $f->type_link; ?>">View All <?php echo $f->type_title ?> &rsaquo;</a>
			</li>
			<?php endforeach; ?>
		</ul>
		<span class="pagingarrow-left"></span>
		<span class="pagingarrow-right"></span>
	</div>
</div>