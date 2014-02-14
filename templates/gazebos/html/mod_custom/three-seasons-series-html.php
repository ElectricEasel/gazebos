<?php defined('_JEXEC') or die;

EEComponentHelper::load('Gazebos');

$model = new GazebosModelGallery(array('ignore_request' => true));
$model->setState('filter.type_id', 4);


$gallery = $model->getItems();

?>
<div class="series-container clr">

	<div id="sidebar" class="series">
		<div class="module side-menu">
			<div class="sidebar-heading-wrap">
				<h3>
					<span>Three Season <span>Series</span></span>
				</h3>
			</div>
			<div class="menu-wrap">
				<div class="module-content">
					<ul class="menu">
						<li class="active"><a href="#series-overview">Overview</a></li>
						<li><a href="#features">Features</a></li>
						<li><a href="#shapes">Shapes &amp; Sizes</a></li>
						<li><a href="#valance">Valance &amp; Baluster</a></li>
						<li><a href="#colors">Colors &amp; Stains</a></li>
						<li><a href="#roof-styles">Roof Styles</a></li>
						<li><a href="#roof-options">Roof Options</a></li>
						<li><a href="#construction">Construction</a></li>
						<li><a href="#options">Custom Options</a></li>
						<li><a href="#fireplace">Fireplace Options</a></li>
						<li><a href="#gallery">Photo Gallery</a></li>
					</ul>
				</div>
				
			</div>
		</div>
		
		<div class="widget-contain">
			<div class="widget" id="help">
				<div><h5>Need Help?</h5></div>
				<span>1-888-4-GAZEBO</span>
			</div>
		</div>
		<div class="widget-contain">
			<div class="widget" id="why-us" style="display:block" onclick="document.location = '/about-us/the-gazebos-difference'">
				<h5>Why Buy<br>From Us?</h5>
				<a href="/about-us/the-gazebos-difference">See the Difference</a>
			</div>
		</div>
		<div class="widget-contain">
			<div class="widget" id="warranty-widget" style="display:block" onclick="document.location = '/about-us/lifetime-warranty'">
				<a href="/about-us/lifetime-warranty">
					<span class="icon"></span><span class="text">Limited Lifetime<span class="upper">Warranty</span></span>
				</a>
			</div>
		</div>
	</div>
	<div id="series-content">
		<div id="series-overview" class="panel clr">
			<p class="intro">Lake Wood Series Gazebos are uniquely designed to compliment both the residential and commercial environment. They are available in a variety of sizes, shapes and styles, and range from 10’ to 28’. The Baluster, Valance and Roof styles are all interchangeable for style and versatility that creates a custom look.</p>
			<p class="intro">Whether it’s a town square, an extension for a deck or patio, a gateway for a residential or commercial complex, a lake side retreat, or an employee break area, a Lake Wood Gazebo becomes the focal point that sets an impressive tone!</p>
			<div class="two-col">
				<h4>Lorem Ipsum Dolor Sit Amet</h4>
				<p>Phasellus iaculis velit vel diam dapibus, eget laoreet sem rutrum. Integer bibendum at lacus dapibus condimentum. Pellentesque orci lectus, adipiscing quis massa id, sodales aliquet enim. Vivamus felis erat, mollis et tellus.</p>
				<h4>Lorem Ipsum Dolor Sit Amet</h4>
				<p>Phasellus iaculis velit vel diam dapibus, eget laoreet sem rutrum. Integer bibendum at lacus dapibus condimentum. Pellentesque orci lectus, adipiscing quis massa id, sodales aliquet enim. Vivamus felis erat, mollis et tellus.</p>
				<h4>Lorem Ipsum Dolor Sit Amet</h4>
				<p>Phasellus iaculis velit vel diam dapibus, eget laoreet sem rutrum. Integer bibendum at lacus dapibus condimentum. Pellentesque orci lectus, adipiscing quis massa id, sodales aliquet enim. Vivamus felis erat, mollis et tellus.</p>
				<h4>Lorem Ipsum Dolor Sit Amet</h4>
				<p>Phasellus iaculis velit vel diam dapibus, eget laoreet sem rutrum. Integer bibendum at lacus dapibus condimentum. Pellentesque orci lectus, adipiscing quis massa id, sodales aliquet enim. Vivamus felis erat, mollis et tellus.</p>
				<h4>Lorem Ipsum Dolor Sit Amet</h4>
				<p>Phasellus iaculis velit vel diam dapibus, eget laoreet sem rutrum. Integer bibendum at lacus dapibus condimentum. Pellentesque orci lectus, adipiscing quis massa id, sodales aliquet enim. Vivamus felis erat, mollis et tellus.</p>
				<h4>Lorem Ipsum Dolor Sit Amet</h4>
				<p>Phasellus iaculis velit vel diam dapibus, eget laoreet sem rutrum. Integer bibendum at lacus dapibus condimentum. Pellentesque orci lectus, adipiscing quis massa id, sodales aliquet enim. Vivamus felis erat, mollis et tellus.</p>
			</div>
		</div>
		<div class="panel clr" id="features" style="display:none">
			<img alt="" src="/templates/gazebos/images/img-warranty-brown.png" class="left">
			<h4>Timeless Designs and Quality Craftsmanship</h4>
			<ul class="list">
				<li>Manufactured in the USA for over 30 years</li>
				<li>Engineered to hold up against strong winds, heavy rain and large snowfall</li>
				<li>Built by a team of craftsmen with numerous years of combined experience</li>
				<li>Craftsmanship and materials backed by a limited lifetime warranty</li>
			</ul>
			<ul class="features-list main clr">
				<li>
					<img width="128" height="130" alt="4&quot;x4&quot; Interlocking Post" src="/images/com_gazebos/features/4x4interlocking-post.jpg">
					<span class="title">4"x4" Interlocking Post</span>
				</li>
				<li>
					<img width="128" height="130" alt="Full 2&quot;x2&quot; Rails" src="/images/com_gazebos/features/full2x2-rails.jpg">
					<span class="title">Full 2"x2" Rails</span>
				</li>
				<li>
					<img width="128" height="130" alt="Select Tight Knot, Kiln Dried Western Red Cedar" src="/images/com_gazebos/features/western-red-cedar.jpg">
					<span class="title">Select Tight Knot, Kiln Dried Western Red Cedar</span>
				</li>
				<li>
					<img width="128" height="130" alt="Double 2&quot;x6&quot; Rafters" src="/images/com_gazebos/features/Double2x6RaftersW.gif">
					<span class="title">Double 2"x6" Rafters</span>
				</li>
				<li>
					<img width="128" height="130" alt="2&quot;x6&quot; Fascia &amp; Compression Ring" src="/images/com_gazebos/features/2x6-fascia.jpg">
					<span class="title">2"x6" Fascia &amp; Compression Ring</span>
				</li>
				<li>
					<img width="128" height="130" alt="Full 1&quot; Tongue &amp; Groove Roof Interior" src="/images/com_gazebos/features/1in-tongue-roof-int.jpg">
					<span class="title">Full 1" Tongue &amp; Groove Roof Interior</span>
				</li>
				<li>
					<img width="128" height="130" alt="Exclusive Drip Edge For Double Roof" src="/images/com_gazebos/features/drip-edge.jpg">
					<span class="title">Exclusive Drip Edge For Double Roof</span>
				</li>
				<li>
					<img width="128" height="130" alt="Exclusive Heavy Duty Aluminum Windows" src="/images/com_gazebos/features/heavy-duty-windows.jpg">
					<span class="title">Exclusive Heavy Duty Aluminum Windows</span>
				</li>
			</ul>
		</div>
		<div id="shapes" class="panel clr" style="display:none">
			<ul class="shapes-list">
				<li>
					<div class="shape octagon">
						<span>10',12',14'</span>
					</div>
					<p class="shape-title">Octagon</p>
				</li>
				<li>
					<div class="shape oblong">
						<span>10'x14'<br/>12'x16'</span>
					</div>
					<p class="shape-title">Oblong</p>
				</li>
				<li>
					<div class="shape decagon">
						<span>14',16'</span>
					</div>
					<p class="shape-title">Decagon</p>
				</li>
				<li>
					<div class="shape dodecagon">
						<span>18',20',<br/>23',26',28'</span>
					</div>
					<p class="shape-title">Dodecagon</p>
				</li>
				<li>
					<div class="shape square">
						<span>10'x10'<br/>
							12'x12'
						</span>
					</div>
					<p class="shape-title">Square</p>
				</li>
				<li>
					<div class="shape rectangle">
						<span>10'x15'<br/>
							12'x16'
						</span>
					</div>
					<p class="shape-title">Rectangle</p>
				</li>
			</ul>
		</div>
		<div id="valance" class="panel clr" style="display:none">
		</div>
		<div id="colors" class="panel clr" style="display:none">
		</div>
		<div id="roof-styles" class="panel clr" style="display:none">
			<ul class="features-list clr roof-style">
				<li>
					<img alt="Straight" src="/images/com_gazebos/roof-styles/straight.png">
					<span class="title">Straight</span>
				</li>
				<li>
					<img alt="Double Straight" src="/images/com_gazebos/roof-styles/double-straight.png">
					<span class="title">Double Straight</span>
				</li>
				<li>
					<img alt="Double Straight" src="/images/com_gazebos/roof-styles/single-curved.png">
					<span class="title">Single Curved (Octagon &amp; Decagon Only)</span>
				</li>
				<li>
					<img alt="Double Straight" src="/images/com_gazebos/roof-styles/double-curved.png">
					<span class="title">Double Curved (Octagon &amp; Decagon Only)</span>
				</li>
			</ul>
		</div>
		<div id="roof-options" class="panel clr" style="display:none">
		</div>
		<div class="panel clr" id="roofing" style="display:none">
			<h4>Asphalt Shingles</h4>
			<ul class="features-list clr asphalt-shingles">			<li>
				<img width="78" height="78" alt="Aged Redwood" src="/images/com_gazebos/shingles/r-aged-redwood.jpg">
				<span class="title">Aged Redwood</span>
			</li>
			<li>
				<img width="78" height="78" alt="Charcoal Gray" src="/images/com_gazebos/shingles/r-charcoal-gray.jpg">
				<span class="title">Charcoal Gray</span>
			</li>
			<li>
				<img width="78" height="78" alt="Driftwood" src="/images/com_gazebos/shingles/r-driftwood.jpg">
				<span class="title">Driftwood</span>
			</li>
			<li>
				<img width="78" height="78" alt="Dual Black" src="/images/com_gazebos/shingles/r-dual-black.jpg">
				<span class="title">Dual Black</span>
			</li>
			<li>
				<img width="78" height="78" alt="Dual Brown" src="/images/com_gazebos/shingles/r-dual-brown.jpg">
				<span class="title">Dual Brown</span>
			</li>
			<li>
				<img width="78" height="78" alt="Dual Gray" src="/images/com_gazebos/shingles/r-dual-gray.jpg">
				<span class="title">Dual Gray</span>
			</li>
			<li>
				<img width="78" height="78" alt="Earthtone Cedar" src="/images/com_gazebos/shingles/r-earthtone-cedar.jpg">
				<span class="title">Earthtone Cedar</span>
			</li>
			<li>
				<img width="78" height="78" alt="Forest Green" src="/images/com_gazebos/shingles/r-forest-green.jpg">
				<span class="title">Forest Green</span>
			</li>
			<li>
				<img width="78" height="78" alt="Harvard Slate" src="/images/com_gazebos/shingles/r-harvard-slate.jpg">
				<span class="title">Harvard Slate</span>
			</li>
			<li>
				<img width="78" height="78" alt="National Blue" src="/images/com_gazebos/shingles/r-national-blue.jpg">
				<span class="title">National Blue</span>
			</li>
			<li>
				<img width="78" height="78" alt="Weather Wood" src="/images/com_gazebos/shingles/r-weather-wood.jpg">
				<span class="title">Weather Wood</span>
			</li>
			</ul>
			<h4>Optional Roofing</h4>
			<ul class="features-list clr optional-roofing">
				<li>
					<img width="78" height="78" alt="Cedar Shake Shingles" src="/images/com_gazebos/BSdXEu5elxFETbamkFUjug3x-JqK2ap_bc3QvS6Hr_Q.jpeg">
					<span class="title">Cedar Shake Shingles</span>
				</li>
			</ul>
			<h4>Metal Roofing</h4>
			<ul class="features-list clr metal-roofing">
				<li>
					<img width="78" height="78" alt="Charcoal" src="/images/com_gazebos/charcoal.jpg">
					<span class="title">Charcoal</span>
				</li>
				<li>
					<img width="78" height="78" alt="Autumn Red" src="/images/com_gazebos/autumn-Red.jpg">
					<span class="title">Autumn Red</span>
				</li>
				<li>
					<img width="78" height="78" alt="Evergreen" src="/images/com_gazebos/evergreen.jpg">
					<span class="title">Evergreen</span>
				</li>
				<li>
					<img width="78" height="78" alt="Roman Blue" src="/images/com_gazebos/Roman-blue.jpg">
					<span class="title">Roman Blue</span>
				</li>
				<li>
					<img width="78" height="78" alt="Tudor Brown" src="/images/com_gazebos/tudor-brown.jpg">
					<span class="title">Tudor Brown</span>
				</li>
			</ul>
			<h4>Vinyl Shingles</h4>
			<ul class="features-list clr vinyl-shingles">			<li>
				<img width="78" height="78" alt="Seneca Red" src="/images/com_gazebos/seneca-red-sm.jpg">
				<span class="title">Seneca Red</span>
			</li>
						<li>
				<img width="78" height="78" alt="Seneca Plum" src="/images/com_gazebos/seneca-plum-sm.jpg">
				<span class="title">Seneca Plum</span>
			</li>
						<li>
				<img width="78" height="78" alt="Seneca Chestnut" src="/images/com_gazebos/seneca-chestnut-sm.jpg">
				<span class="title">Seneca Chestnut</span>
			</li>
						<li>
				<img width="78" height="78" alt="Seneca Cedar" src="/images/com_gazebos/seneca-cedar-sm.jpg">
				<span class="title">Seneca Cedar</span>
			</li>
						<li>
				<img width="78" height="78" alt="Seneca Smoke" src="/images/com_gazebos/seneca-smoke-sm.jpg">
				<span class="title">Seneca Smoke</span>
			</li>
						<li>
				<img width="78" height="78" alt="Seneca Federal" src="/images/com_gazebos/seneca-federal-sm.jpg">
				<span class="title">Seneca Federal</span>
			</li>
						<li>
				<img width="78" height="78" alt="Seneca Midnight" src="/images/com_gazebos/seneca-midnight-sm.jpg">
				<span class="title">Seneca Midnight</span>
			</li>
						<li>
				<img width="78" height="78" alt="Seneca Black" src="/images/com_gazebos/seneca-black-sm.jpg">
				<span class="title">Seneca Black</span>
			</li>
						<li>
				<img width="78" height="78" alt="Seneca Green" src="/images/com_gazebos/seneca-green-sm.jpg">
				<span class="title">Seneca Green</span>
			</li>
			</ul>
		</div>
		<div class="panel clr" id="construction" style="display:none">
			<img class="image-center" src="/templates/gazebos/images/series/three-season-construction.png" alt=""/>
		</div>
		<div class="panel clr" id="options" style="display:none">			
			<h4>Gazebo Options</h4>
			<ul class="features-list clr gazebo-options">
				<li>
					<img alt="Bench-Package" src="/images/com_gazebos/bench_package.gif">
					<span class="title">Bench-Package</span>
				</li>
				<li>
					<img alt="Screen-Package" src="/images/com_gazebos/screen_package.gif">
					<span class="title">Screen-Package</span>
				</li>
			</ul>
		</div>
		<div class="panel clr" id="fireplace" style="display:none">

		</div>
		<div class="panel clr" id="gallery" style="display:none">
			<ul id="gallery-list">
				<?php foreach ($gallery as $item) : ?>
				<li>
					<div class="overlay"><a href="<?php echo JRoute::_('index.php?option=com_gazebos&view=product&id=' . $item->id); ?>">View<br>Details</a></div>
					<?php echo EEHtml::asset("products/{$item->id}/thumbs/150x150_{$item->image}", 'com_gazebos'); ?>
				</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
	
</div>
