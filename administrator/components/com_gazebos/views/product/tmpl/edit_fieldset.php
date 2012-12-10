<?php
/**
 * @version     1.0.0
 * @package     com_gazebos
 * @copyright   Copyright (C) 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Don Gilbert <don@electriceasel.com> - http://www.electriceasel.com
 */

// no direct access
defined('_JEXEC') or die; ?>
<div class="width-100">
	<fieldset class="adminform fieldset_<?php echo $this->fieldset->name; ?>">
		<ul class="adminformlist">
		<?php foreach ($this->form->getFieldset($this->fieldset->name) as $field) : ?>
			<li><?php echo $field->label, $field->input; ?></li>
		<?php endforeach; ?>
        </ul>
	</fieldset>
</div>
