<?php defined('_JEXEC') or die;

EEComponentHelper::load('Gazebos');

$model = new GazebosModelGallery(array('ignore_request' => true));
$model->setState('filter.series', 223);

$gallery = $model->getItems();

?>
<div class="fancy-heading alt">
	<h2><span>Cedar Cove</span> Series</h2>
</div>

<div class="series-container clr">
	<div class="border"></div>
	<div id="series-sidebar">
		<ul class="menu">
			<li class="active"><a href="#series-overview">Overview</a></li>
			<li><a href="#gallery">Gallery</a></li>
			<li><a href="#features">Features</a></li>
			<li><a href="#options">Options</a></li>
			<li><a href="#roofing">Roofing</a></li>
			<li><a href="#flooring">Flooring</a></li>
		</ul>
		<div class="sidebar-widget quote">
			<a href="<?php echo JRoute::_('index.php?option=com_gazebos&view=series&layout=form&tmpl=component'); ?>" data-fancybox-type="iframe" rel="fancybox" class="brown-button">Request Quote &gt;</a>
		</div>
		<div class="sidebar-widget warranty">
			<span>Limited Lifetime <span>Warranty</span></span>
		</div>
		<div class="sidebar-widget why" onclick="document.location='/about-us/the-gazebos-difference'">
			<h5>Why Buy<br>From Us?</h5>
			<a href="/about-us/the-gazebos-difference">See the Difference</a>
		</div>
		<div class="sidebar-widget call">
			<div>
				<h5>Need Help?</h5>
			</div>
			<span>1-888-4-GAZEBO</span>
		</div>
	</div>
	<div id="series-content">
		<div id="series-overview" class="panel clr">
			<img class="" src="/templates/gazebos/images/styles-cedar-cove.jpg" alt=""/>
			<p><strong>Cedar Cove Gazebos</strong> are a "Great Gazebo at a Great Price" <sup>TM</sup></p>
			<p>Available in a variety of sizes, shapes and styles, the Cedar Cove Gazebo caters to each individual customer. With so many options, the Cedar Cove series is truly unmatched.</p>
			<p>Perfect for both experienced handymen and beginners, unique and convenient features make for a quick and easy assembly. Additionally, the Cedar Cove Gazebo offers a unique roof construction that creates a strong, yet attractive interior - and floor, window, screen, bench and roof packages provide the opportunity to build a structure that is one of a kind! With a Cedar Cove Series Gazebo, customers can enjoy the beauty of quality materials, appealing designs, for one great looking gazebo.</p>
			<p>Cedar Cove Series Gazebos Feature:</p>
			<ul>
				<li>Each piece of cedar is surfaced to a smooth finish, and all exposed edges are beveled.</li>
				<li>For a quick and easy assembly, the wall divs are preassembled and predrilled and fit together with 4” x 4” corner posts.</li>
				<li>The roof panels are preassembled and preshingled.</li>
				<li>The roof rafters and remaining trim parts are precut.</li>
				<li>All fastening hardware is included, as well as complete assembly instructions.</li>
				<li>Designed to attach to an existing deck, brick, or cement patio.</li>
				<li>Available in a variety of sizes, styles, and shapes and have many options available.</li>
				<li>Gazebo kits are constructed with D-select and select tight knot Western Red Cedar, galvanized fasteners, and solid brass hardware.</li>
				<li>The roof is constructed with #2 grade cedar shingles, is completely raintight, and is finished on top with a handmade copper rainguard.*</li>
				<li>Steel roofs are constructed with 29 gauge, painted corrugated steel.</li>
			</ul>
			<p class="disclaimer">* not available on all sizes and shapes.</p>
		</div>
		<div class="panel clr" id="gallery">
				<ul id="gallery-list">
					<?php foreach ($gallery as $item) : ?>
					<li>
						<div class="overlay"><a href="<?php echo JRoute::_('index.php?option=com_gazebos&view=product&id=' . $item->id); ?>">View<br>Details</a></div>
						<?php echo EEHtml::asset("products/{$item->id}/thumbs/150x150_{$item->image}", 'com_gazebos'); ?>
					</li>
					<?php endforeach; ?>
				</ul>
		</div>
		<div class="panel clr" id="features">
			<img alt="" src="/templates/gazebos/images/img-warranty-brown.png" class="left">
			<h4>Timeless Designs and Quality Craftsmanship</h4>
			<ul class="list">
				<li>Manufactured in the USA for over 30 years</li>
				<li>Engineered to hold up against strong winds, heavy rain and large snowfall</li>
				<li>Built by a team of craftsmen with numerous years of combined experience</li>
				<li>Craftsmanship and materials backed by a limited lifetime warranty</li>
			</ul>
			<ul class="features-list clr">
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
					<img width="128" height="130" alt="Exclusive Strength &amp; Stability Bracket" src="/images/com_gazebos/features/stability-bracket.jpg">
					<span class="title">Exclusive Strength &amp; Stability Bracket</span>
				</li>
							<li>
					<img width="128" height="130" alt="2&quot;x6&quot; Fascia &amp; Compression Ring" src="/images/com_gazebos/features/2x6-fascia.jpg">
					<span class="title">2"x6" Fascia &amp; Compression Ring</span>
				</li>
							<li>
					<img width="128" height="130" alt="Full 1&quot; Tongue &amp; Groove Roof Interior" src="/images/com_gazebos/features/1in-tongue-roof-int.jpg">
					<span class="title">Full 1" Tongue &amp; Groove Roof Interior</span>
				</li>
			</ul>
		</div>
		<div class="panel" id="options">
				<h4>Roof Style</h4>
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
				<h4>Available Shapes in Wood</h4>
				<ul class="features-list clr available-shapes-in-wood">
					<li>
						<img alt="Octagon" src="/images/com_gazebos/wood_octagon.png">
						<span class="title">Octagon</span>
					</li>
								<li>
						<img alt="Rectangle" src="/images/com_gazebos/wood_rectangle.png">
						<span class="title">Rectangle</span>
					</li>
								<li>
						<img alt="Oblong" src="/images/com_gazebos/wood_oblong.png">
						<span class="title">Oblong</span>
					</li>
								<li>
						<img alt="Decagon" src="/images/com_gazebos/wood_decagon.png">
						<span class="title">Decagon</span>
					</li>
								<li>
						<img alt="Dodecagon" src="/images/com_gazebos/wood_dodecagon.png">
						<span class="title">Dodecagon</span>
					</li>
								<li>
						<img alt="Square" src="/images/com_gazebos/wood_square.png">
						<span class="title">Square</span>
					</li>
				</ul>
			</div>
			<div class="panel clr" id="roofing">
				<h4>Asphalt Shingles</h4><ul class="features-list clr asphalt-shingles">			<li>
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
		<div class="panel clr" id="flooring">
				<h4>Flooring Packages</h4><ul class="features-list clr flooring-packages">			<li>
					<img width="78" height="78" alt="Standard Floor Package" src="/images/com_gazebos/standard-1.gif">
					<span class="title">Standard Floor Package</span>
				</li>
							<li>
					<img width="78" height="78" alt="Tri-Floor Package" src="/images/com_gazebos/tri_floor-1.gif">
					<span class="title">Tri-Floor Package (Octagon &amp; Decagon Only</span>
				</li>
				</ul>
			</div>
	</div>
</div>