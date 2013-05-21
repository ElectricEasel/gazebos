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
<div class="quote-wrap">
	<h3>Quick Quote Form</h3>
	<div id="quick-quote-widget">
		<div class="widget-wrap">
			<p>Fill out the form below and we will contact you to discuss your <?php echo strtolower($this->item->type_title);?> options and provide you with a detailed quote.</p>
			<form id="quick-quote" action="<?php echo JRoute::_('index.php?option=com_gazebos&task=size.submit'); ?>" method="post">
				<ul>
					<li>
						<?php echo $this->form->getInput('first_name'); ?>
					</li>
					<li>
						<?php echo $this->form->getInput('last_name'); ?>
					</li>
					<li>
						<?php echo $this->form->getInput('email'); ?>
					</li>
					<li>
						<?php echo $this->form->getInput('phone'); ?>
					</li>
					<li>
						<?php echo $this->form->getInput('zip'); ?>
					</li>
					<li>
						<?php echo $this->form->getInput('contact_method'); ?>
					</li>
					<li>
						<?php echo $this->form->getInput('project_timeframe'); ?>
					</li>
					<li class="clr">
						<?php
						$fieldset = strtolower(str_replace(' ', '_', $this->item->type_title));
						if (!empty($fieldset)) :
						foreach ($this->form->getFieldset($fieldset) as $field) : ?>
						<div class="radios">
							<span class="label"><?php echo (string) $field->element['label']; ?></span>
							<?php echo $field->input; ?>
						</div>
						<?php endforeach;
						endif; ?>
					</li>
					<li>
						<?php echo $this->form->getLabel('comments'), $this->form->getInput('comments'); ?>
					</li>
					<li class="submit">
						<input class="green-button" type="submit" value="Submit Request &rsaquo;"/>
					</li>
				</ul>
				<?php echo $this->form->getInput('size_id'), $this->form->getInput('size_interested_in'); ?>
			</form>
		</div>
	</div>
</div>