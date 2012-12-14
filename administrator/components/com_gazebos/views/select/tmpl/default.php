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
$types = GazebosHelper::getProductTypes();
?>
<h2 class="modal-title">Select a Type</h2>

<ul id="new-modules-list">
<?php foreach ($types as $type) :
$link = 'index.php?option=com_gazebos&view=product&layout=edit&type_id=' . $type->id;
$name	= $this->escape($type->title);
?>
	<li>
		<span class="editlinktip">
			<a href="<?php echo JRoute::_($link);?>" target="_top">
				<?php echo $name; ?>
			</a>
		</span>
	</li>
<?php endforeach; ?>
</ul>
<div class="clr"></div>