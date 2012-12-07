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

JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.keepalive');

JFactory::getDocument()
	->addScriptDeclaration("
	// <![CDATA[
	Joomla.submitbutton = function(task)
	{
		if (task == 'product.cancel' || document.formvalidator.isValid(document.id('product-form'))) {
			Joomla.submitform(task, document.getElementById('product-form'));
		}
		else {
			alert('" . $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')) . "');
		}
	}
	// ]]>
	");
?>
<form action="index.php" method="post" name="adminForm" id="product-form" class="form-validate">
	<div class="width-60 fltlft">
		<?php foreach ($this->form->getFieldsets() as $fieldset) : ?>
		<fieldset class="adminform fieldset_<?php echo $fieldset->name; ?>">
			<legend><?php echo JText::_($fieldset->label); ?></legend>
			<ul class="adminformlist">
			<?php
			foreach ($this->form->getFieldset($fieldset->name) as $field) :
				$input = ($field->id === 'jform_gallery') ? str_replace('{{product_id}}', $this->item->id, $field->input) : $field->input;
				?>
				<li><?php echo $field->label, $input; ?></li>
			<?php endforeach; ?>
            </ul>
		</fieldset>
		<?php endforeach; ?>
	</div>

	<input type="hidden" name="task" value="" />
	<input type="hidden" name="id" value="<?php echo $this->item->id; ?>" />
	<input type="hidden" name="option" value="com_gazebos" />
	<input type="hidden" name="layout" value="edit" />
	<?php echo JHtml::_('form.token'); ?>
	<div class="clr"></div>
</form>