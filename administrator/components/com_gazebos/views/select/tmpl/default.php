<?php
/**
 * @version     1.0.0
 * @package     com_gazebos
 * @copyright   Copyright (C) 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Don Gilbert <don@electriceasel.com> - http://www.electriceasel.com
 */

// No direct access
defined('_JEXEC') or die;

JFactory::getDocument()
	->addScript('//ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js')
	->addStyleDeclaration('ul#new-modules-list li{width:100%}');

$types = $this->item;
?>
<h2 class="modal-title">Select Product Type and Line</h2>

<ul id="new-modules-list">
<?php foreach ($types as $type) : ?>
	<li>
		<span class="editlinktip">
			<a href="#" onclick="jQuery('#expand<?php echo $type->id; ?>').toggle();">
				<?php echo $this->escape($type->title); ?>
			</a>
		</span>
		<?php if (!empty($type->lines)) : ?>
		<ul id="expand<?php echo $type->id; ?>" style="display:none;">
			<?php foreach ($type->lines as $line) :
			$link = 'index.php?option=com_gazebos&view=' . $this->editView . '&layout=edit&type_id=' . $type->id . '&line_id=' . $line->id;
			?>
			<li>
				<span class="editlinktip">
					<a href="<?php echo JRoute::_($link); ?>" target="_top">
						<?php echo $this->escape($line->title); ?>
					</a>
				</span>
			</li>
			<?php endforeach; ?>
		</ul>
		<?php else: ?>
		<p id="expand<?php echo $type->id; ?>" style="display:none;">No lines have been created for this product type.</p>
		<?php endif; ?>
	</li>
<?php endforeach; ?>
</ul>
<div class="clr"></div>