<?php
/**
 * @package     Joomla.Site
 * @subpackage	Templates.gazebos
 * @copyright   Copyright (C) 2012 Electric Easel, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

JHtml::_('behavior.framework', true);

// get params
$app = JFactory::getApplication();
$menu = $app->getMenu();
$config = JFactory::getConfig();
$template = $this->baseurl . '/templates/' . $this->template;

// $this JDocument
$this
	// Add Stylesheets
	->addStyleSheet('//fonts.googleapis.com/css?family=Quattrocento:400,700|Parisienne|PT+Sans:400,700italic,700,400italic')
	->addStyleSheet('/media/system/css/system.css')
/*
	->addStyleSheet($template . '/css/normalize.css')
	->addStyleSheet($template . '/css/style.css')
	->addStyleSheet($template . '/css/chosen.css')
	->addStyleSheet($template . '/css/jquery.fancybox.css')
*/
	
	->addStyleSheet($template . '/css/site.min.css')
	->addStyleSheet($template . '/css/print.min.css', $type = 'text/css', $media = 'print')
	// Add Scripts
	->addScript('//ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js')
	
	->addScript($template . '/js/custom-form-elements.js')
	->addScript($template . '/js/chosen.jquery.min.js')
	->addScript($template . '/js/jquery.placeheld.min.js')
	->addScript($template . '/js/jquery.fancybox.pack.js')
	
	//->addScript($template . '/js/js.min.js')
	->addScript($template . '/js/site.js')
	->addScriptDeclaration('
	// <![CDATA[
	jQuery(document).ready(function ($) {
		$("[rel^=fancybox]").each(function () {
			var base = $(this);

			base.fancybox({
				width: 720,
				height:780,
				padding:0,
				autoSize:false
			});
		});
	});
	// ]]>')
	// Other Settings
	->setTab("\t")
	->setBase(null)
	->setGenerator('Electric Easel, Inc. www.electriceasel.com');

// remove the content-type meta tag, we are setting it in http headers
unset($this->_metaTags['http-equiv']);

// Extract the scripts so we can push them to the bottom of the page.
$javascript = EEHtml::extractScripts($this);

?><!DOCTYPE html>
<html lang="en">
	<head>
	<jdoc:include type="head" />
	<meta name="geo.region" content="US-IL" />
	<meta name="geo.placename" content="Kingston" />
	<meta name="geo.position" content="42.099166;-88.768368" />
	<meta name="ICBM" content="42.099166, -88.768368" />
	<meta name="DC.publisher" content="Gazebos.com / Leisure Woods" />
	<meta name="DC.title" content="Gazebos.com - buy a Gazebo, Pergola, Pavilion or Three Season Gazebo" />
	<meta name="DC.identifier" content="http://gazebos.com/" />
	<meta name="DC.language" content="en-US" scheme="rfc1766" /> 
	<meta name="DC.subject" content="Gazebos, Pergolas, Pavilions, Three Season Gazebos" />
	<meta name="msvalidate.01" content="48AC44AD79AC77CDC34AE15F8F64FB13" />
	<script type="text/javascript">
	var _gaq = _gaq || [];
	_gaq.push(['_setAccount', 'UA-2424066-3']);
	_gaq.push(['_trackPageview']);
	(function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	})();
	</script>
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
					<a class="header-chat" href="javascript:void(0);" onclick="requestLiveChat('/index.php?option=com_jlivechat&view=popup&tmpl=component&popup_mode=popup','popup');"><img src="/templates/gazebos/images/live-chat-button.png" alt="Live Chat"/></a>
					<span class="phone">1-888-4-gazebo</span>
				</div>
			</div>
		</div>
		<div class="border"></div>
		<div id="banner">
			<div class="banner-wrap">
				<?php if ($menu->getDefault() == $menu->getActive()) : ?>
					<jdoc:include type="modules" name="home-banner" />
				<?php else : ?>
					<jdoc:include type="modules" name="page-banner" />
				<?php endif; ?>
			</div>
		</div>
		<div class="border"></div>
		<jdoc:include type="modules" name="sub-head" />
<?php if ($menu->getDefault() !== $menu->getActive()) : ?>
		<div id="breadcrumbs">
			<jdoc:include type="modules" name="breadcrumbs" />
		</div>
<?php endif; ?>
		<div id="main">
			<div class="wrap<?php echo (!$this->countModules('position-7 + position-5 + position-4')) ? ' fullwidth' : ''; ?>">

				<jdoc:include type="message" />
<?php if (JRequest::getCmd('view') !== 'product' && ($this->countModules('position-7') || $this->countModules('position-4') || $this->countModules('position-5'))) : ?>
				<div id="sidebar">
					<jdoc:include type="modules" name="position-7" style="sidebar" />
					<jdoc:include type="modules" name="position-4" style="sidebar" />
					<jdoc:include type="modules" name="position-5" style="sidebar" />
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
				
				<p class="left">&copy;<?php echo date('Y')?> gazebos.com.  All Rights Reserved. | <a href="/privacy-policy">Privacy Policy</a></p>
				<p class="right"><a href="http://www.electriceasel.com/" id="ee" target="_blank">digital marketing by electric easel</a></p>
				<br class="clear"/>
				</div>
			</div>
		</div>
		<jdoc:include type="modules" name="favorites" style="blank" />
		<jdoc:include type="modules" name="debug" />
<?php echo $javascript; ?>
	</body>
</html>