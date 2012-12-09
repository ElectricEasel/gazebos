<?php
/**
 * @version     1.0.0
 * @package     com_gazebos
 * @copyright   Copyright (C) 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Don Gilbert <don@electriceasel.com> - http://www.electriceasel.com
 */

// no direct access
defined('_JEXEC') or die;
$fieldset = $this->fieldset; ?>
<div class="width-100">
	<fieldset class="adminform fieldset_<?php echo $fieldset->name; ?>">
		<ul class="adminformlist">
		<?php foreach ($this->form->getFieldset($fieldset->name) as $field) :
			$input = ($field->id === 'jform_gallery') ? str_replace('{{product_id}}', $this->item->id, $field->input) : $field->input; ?>
			<li><?php echo $field->label, $input; ?></li>
		<?php endforeach; ?>
        </ul>
	</fieldset>
</div>