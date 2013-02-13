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
	->addStyleSheet('//fonts.googleapis.com/css?family=Great+Vibes|Parisienne')
	->addStyleSheet('//fonts.googleapis.com/css?family=Gilda+Display|Ovo|Quattrocento:400,700|Sorts+Mill+Goudy')
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
				<div id="home-menu">
					<jdoc:include type="modules" name="top-nav" />
				</div>
				<div class="navbar">
					<jdoc:include type="modules" name="nav" />
				</div>
				<div class="top-contact">
					<span class="phone">1-888-4-gazebo</span><span class="sep">|</span><a href="#">Chat Now</a>
				</div>
			</div>
		</div>
		<div class="border"></div>
		<div id="banner">
			<div class="banner-wrap">
				<?php if ($bodyclass == 'home'): ?>
					<jdoc:include type="modules" name="home-banner" />
				<?php elseif ($bodyclass == 'gazebos'): ?>
					
				<?php endif; ?>
			</div>
		</div>
		<div class="border"></div>
		<jdoc:include type="modules" name="sub-head" />
		<div class="border"></div>
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
						<div id="spot-marketing" class="clr">
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
					<div class="module last">
						<jdoc:include type="modules" name="position-12" />
					</div>
				
					<div class="clear"></div>
				</div>
				<div id="footer-bottom">
				
				<p class="left">&copy;<?php echo date('Y')?> gazebos.com.  All Rights Reserved.</p>
				<br class="clear"/>
				</div>
			</div>
		</div>
		<jdoc:include type="modules" name="favorites" style="blank" />
		<jdoc:include type="modules" name="debug" />
	</body>
</html>
