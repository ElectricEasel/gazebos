<?php
/**
* @version     1.0.0
* @package     com_gazebos
* @copyright   Copyright (C) 2012. All rights reserved.
* @license     GNU General Public License version 2 or later; see LICENSE.txt
* @author      Don Gilbert <don@electriceasel.com> - http://www.electriceasel.com
*/
defined('_JEXEC') or die;

?>
<div style="padding:10px;background:url(/templates/gazebos/images/bg_darkpattern.png) repeat 0 0 scroll transparent;">
	<div class="quote-wrap">
		<img src="/templates/gazebos/images/quote_logo.png" />
		<div style="padding:0 20px">
			<h3>GET A QUOTE</h3>
			<div id="quick-quote-widget">
				<div class="widget-wrap">
					<p>Please fill out the form below and a Gazebos.com consultant will contact you.</p>
					<form id="custom-quote" action="<?php echo JRoute::_('index.php?option=com_gazebos&task=product.submit'); ?>" method="post">
						<ul>
							<li class="half">
								<?php echo $this->form->getInput('first_name'); ?>
							</li>
							<li class="half">
								<?php echo $this->form->getInput('last_name'); ?>
							</li>
							<li class="half">
								<?php echo $this->form->getInput('email'); ?>
							</li>
							<li class="half">
								<?php echo $this->form->getInput('phone'); ?>
							</li>
							<li class="full" style="clear:both;">
								<?php echo $this->form->getInput('zip'); ?>
							</li>
							<li class="half">
								<?php echo $this->form->getInput('contact_method'); ?>
							</li>
							<li class="half">
								<?php echo $this->form->getInput('project_timeframe'); ?>
							</li>
							<li class="full">
								<?php echo $this->form->getLabel('comments'), $this->form->getInput('comments'); ?>
							</li>
							<li class="submit">
								<input id="submit" class="green-button" type="submit" value="Submit Request &rsaquo;"/>
							</li>
						</ul>
						<?php echo $this->form->getInput('product_id'); ?>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
