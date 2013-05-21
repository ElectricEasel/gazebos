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

$types = $this->get('Item');
?>
<h2 class="modal-title">Select Product Type</h2>

<ul id="new-modules-list">
<?php foreach ($types as $type) : ?>
	<li>
		<span class="editlinktip">
			<?php $link = 'index.php?option=com_gazebos&view=' . $this->editView . '&layout=edit&type_id=' . $type->id; ?>
			<a href="<?php echo $link; ?>" target="_top">
				<?php echo $this->escape($type->title); ?>
			</a>
		</span>
	</li>
<?php endforeach; ?>
</ul>
<div class="clr"></div>