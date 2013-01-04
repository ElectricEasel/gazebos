<?php
/**
 * @package     Joomla.Site
 * @subpackage	Templates.gazebos
 * @copyright   Copyright (C) 2012 Electric Easel, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

JHtml::_('behavior.framework', true);

// get params
$app = JFactory::getApplication();
$menu = $app->getMenu();
$config = JFactory::getConfig();
$template = $this->baseurl . '/templates/' . $this->template;
$bodyclass = EEHelper::getBodyClasses();

// $this JDocument
$this
	// Add Stylesheets
	->addStyleSheet('/templates/system/css/system.css')
	->addStyleSheet($template . '/css/normalize.css')
	->addStyleSheet($template . '/css/fullwidth.css')
	->addStyleSheet($template . '/css/style.css')
	->addStyleSheet($template . '/css/print.css', $type = 'text/css', $media = 'print')
	// Add Scripts
	->addScript('//ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js')
	->addScript('//cdnjs.cloudflare.com/ajax/libs/jquery.cycle/2.9999.8/jquery.cycle.all.min.js ')
	->addScript($template . '/js/jquery.pikachoose.js')
	->addScript($template . '/js/site.js')
	->addScript($template . '/js/custom-form-elements.js')
	// Other Settings
	->setTab("\t")
	->setBase(null)
	->setGenerator('Electric Easel, Inc. www.electriceasel.com');

?><!DOCTYPE html>
<html lang="en">
	<head>
	<jdoc:include type="head" />
	</head>
	<body class="<?php echo EEHelper::getBodyClasses(); ?>">
		<div id="header">
			<div class="wrap">
				<a href="/" id="logo"><?php echo $config->get('sitename'); ?></a>
				<a href="/" id="bbb"></a>
				<span id="tagline">Quality Gazebos Since 1982</span>
				<div class="navbar">
					<jdoc:include type="modules" name="nav" />
				</div>
			</div>
		</div>
		<div id="subhead">
			<div id="image-banner">
				<?php if ($menu->getDefault() == $menu->getActive()) : ?>
				<div id="fullwidth">
					<ul id="fullwidth_slider">
						<li>
							<a href="javascript:void(0)">
								<img src="/templates/gazebos/images/banners/home.jpg" />
								<span><span>Gazebos.com<span>The Best Prices for Fine Quality</span></span></span>
							</a>
						</li>
						<li>
							<a href="/gazebos">
								<img src="/templates/gazebos/images/banners/gazebo.jpg" />
								<span><span>Gazebos<span>The Heart of American Charm</span></span></span>
							</a>
						</li>
						<li>
							<a href="/pergolas">
								<img src="/templates/gazebos/images/banners/pergola.jpg" />
								<span><span>Pergolas<span>Your Dream Getaway</span></span></span>
							</a>
						</li>
						<li>
							<a href="/pavilions">
								<img src="/templates/gazebos/images/banners/pavilion.jpg" />
								<span><span>Pavilions<span>Outdoor Living at it's Best</span></span></span>
							</a>
						</li>
						<li>
							<a href="/three-season-gazebos">
								<img src="/templates/gazebos/images/banners/threeseasongazebo.jpg" />
								<span><span>Three Season<span>The Perfect Place to Get Away</span></span></span>
							</a>
						</li>
					</ul>
				</div>
				<?php endif; ?>
			</div>
			<div id="green-banner">
				<div class="subhead-wrap">
					<div class="wrap">
						<?php if ($bodyclass == 'home'): ?>
							<h2>Building <span>quality gazebos</span> in the U.S.A. for over 30 years</h2>
						<?php elseif ($bodyclass == 'gazebos'): ?>
							<h2><span>"Wood Gazebos"</span> we found <span>200</span> items!</h2>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
		<div id="main">
			<div class="wrap">
				<jdoc:include type="message" />
				<?php if (JRequest::getCmd('view') !== 'product' && ($this->countModules('position-7') || $this->countModules('position-4') || $this->countModules('position-5'))) : ?>
				<div id="sidebar">
					<jdoc:include type="modules" name="position-7" style="basic" />
					<jdoc:include type="modules" name="position-4" style="basic" />
					<jdoc:include type="modules" name="position-5" style="basic" />
				</div>
				<?php endif; ?>
				<div id="content">
					<jdoc:include type="component" />
					<?php if ($this->countModules('home-spot-marketing')): ?>
						<div id="spot-marketing">
							<jdoc:include type="modules" name="home-spot-marketing"   />
						</div>
						<div class="clear"></div>
				<?php endif; ?>
				</div>
				<div class="clear"></div>
			</div>
		</div>
		<div id="footer">
			<div class="wrap">
				<div id="footer-quote">
					<jdoc:include type="modules" name="footer-quote" />
				</div>
				<div id="footer-widgets">
					<div class="module">
						<jdoc:include type="modules" name="position-10" />
					</div>
					<div class="module">
						<jdoc:include type="modules" name="position-11" />
					</div>
					<div class="module">
						<jdoc:include type="modules" name="position-12" />
					</div>
					<div class="module">
						<a href="/" id="footerlogo"><?php echo $config->get('sitename'); ?></a>
						<h6>Liesure Woods, Inc.</h6>
						<span id="address">710 W. Railroad St. Kingston, IL 60145</span>
					</div>
					<div class="clear"></div>
				</div>
				<div id="footer-bottom">
				<p class="left"><a href="#">Home</a><span>/</span><a href="#">FAQs</a><span>/</span><a href="#">Blog</a><span>/</span><a href="#">About Us</a><span>/</span><a href="#">Contact Us</a></p>
				<p class="right">&copy;<?php echo date('Y')?> gazebos.com.  All Rights Reserved.</p>
				<br class="clear"/>
				</div>
			</div>
		</div>
		<jdoc:include type="modules" name="favorites" style="basic" />
		<jdoc:include type="modules" name="debug" />
	</body>
</html>
