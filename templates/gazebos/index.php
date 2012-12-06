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

// $this JDocument
$this
	// Add Stylesheets
	->addStyleSheet('/templates/system/css/system.css')
	->addStyleSheet($template . '/css/normalize.css')
	->addStyleSheet($template . '/css/style.css')
	->addStyleSheet($template . '/css/print.css', $type = 'text/css', $media = 'print')
	// Add Scripts
	->addScript('//ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js')
	->addScript($template . '/js/site.js')
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
				<div class="navbar">
					<jdoc:include type="modules" name="nav" />
				</div>
			</div>
		</div>
		<div id="hero">
			<div class="wrap">
			</div>
		</div>
		<div id="main">
			<div class="wrap">
				<jdoc:include type="message" />
				<?php if ($this->countModules('position-7') || $this->countModules('position-4') || $this->countModules('position-5')) : ?>
				<div id="sidebar">
					<jdoc:include type="modules" name="position-7" />
					<jdoc:include type="modules" name="position-4" />
					<jdoc:include type="modules" name="position-5" />
				</div>
				<?php endif; ?>
				<div id="content">
					<jdoc:include type="component" />
				</div>
			</div>
		</div>
		<div id="footer">
			<div class="wrap">
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
				</div>
			</div>
		</div>
		<jdoc:include type="modules" name="debug" />
	</body>
</html>
