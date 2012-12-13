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
?>
<!-- close the m div, since we're using tabs -->
</div>
<form action="index.php" method="post" name="adminForm" id="product-form" class="form-validate">
<?php
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

$options = array(
	'startOffset' => 0,
	'useCookie' => false
);

echo JHtml::_('tabs.start', 'gazeboProductTabs', $options);

foreach ($this->form->getFieldsets() as $fieldset)
{
	$this->fieldset = $fieldset;
	echo JHtml::_('tabs.panel', $fieldset->label, $fieldset->name . 'Tab');
	echo $this->loadTemplate('fieldset');
}

if (!empty($this->item->id))
{
	echo JHtml::_('tabs.panel', 'Gallery', 'galleryTab');
	echo $this->loadTemplate('gallery');
}

echo JHtml::_('tabs.end');
echo JHtml::_('form.token'); ?>
<input type="hidden" name="task" value="" />
<input type="hidden" name="id" value="<?php echo $this->item->id; ?>" />
<input type="hidden" name="option" value="com_gazebos" />
<input type="hidden" name="layout" value="edit" />
<div class="clr"></div>
</form>
<!-- reopen the m div -->
<div>