<?php defined('_JEXEC') or die;

EEComponentHelper::load('Gazebos');

$model = new GazebosModelType;
$model->getState();
// Set it to the gazebos type id.
$model->setState('type.id', 1);
$model->getItem();
$shapes = $model->getShapes();

?>
<div class="series-col">
	<ul class="mega-series-sub">
		<li class="lake-wood">
			<h4><a href="/lake-wood">Lake Wood Series
				<span>Starting at $8,000</span>
			</a></h4>
            <a class= "view-button" href="#">View</a>
		</li>
		<li class="cedar-cove">
			<h4><a href="/cedar-cove">Cedar Cove Series
				<span>Starting at $6,000</span>
			</a></h4>
            <a class= "view-button" href="#">View</a>
		</li>
		<li class="amish">
			<h4><a href="#">Amish Gazebos Series
				<span>Starting at $4,000</span>
			</a></h4>
            <a class= "view-button" href="#">View</a>
		</li>
		<li class="three-season">
			<h4><a href="/three-season-gazebos">Three Season Gazebos
                <span>Starting at $4,000</span>
            </a></h4>
            <a class= "view-button" href="#">View</a>
		</li>
	</ul>
</div>
<div class="mm-col-right">
	<strong>Gazebos Overview</strong>
	<p>Simple, quiet comfort can be yours with your own handcrafted gazebo. <a href="/gazebos">Learn More &rsaquo;</a></p>
	<strong>Looking For Something A Little Different?</strong>
	<img src="/templates/gazebos/images/th-custom-gazebo.png" alt="Get a custom quote"/>
	<p>We are happy to create a custom look for you! <a href="/custom-quote/">Get Quote &rsaquo;</a></p>
</div>