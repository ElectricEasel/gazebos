<?php
/**
* @version 1.4.0
* @package RSform!Pro 1.4.0
* @copyright (C) 2007-2013 www.rsjoomla.com
* @license GPL, http://www.gnu.org/copyleft/gpl.html
*/

defined('_JEXEC') or die('Restricted access');
?>
<table class="admintable">
	<tr>
		<td valign="top" align="left">
			<fieldset>
			<legend><?php echo JText::_('RSFP_FORM_INFO_BASIC'); ?></legend>
			<table width="100%" class="com-rsform-table-props">
				<tr>
					<td width="25%" align="right" nowrap="nowrap" class="key"><?php echo JText::_('Published'); ?></td>
					<td><?php echo $this->lists['Published']; ?></td>
				</tr>
				<tr>
					<td width="25%" align="right" nowrap="nowrap" class="key"><?php echo RSFormProHelper::translateIcon(); ?> <?php echo JText::_('RSFP_FORM_TITLE'); ?></td>
					<td><input name="FormTitle" class="rs_inp rs_80" value="<?php echo $this->escape($this->form->FormTitle); ?>" size="105" id="FormTitle" /></td>
				</tr>
				<tr>
					<td width="25%" align="right" nowrap="nowrap" class="key"><?php echo JText::_('RSFP_SHOW_FORM_TITLE'); ?></td>
					<td><?php echo $this->lists['ShowFormTitle']; ?></td>
				</tr>				
				<tr>
					<td width="25%" align="right" nowrap="nowrap" class="key"><?php echo JText::_('RSFP_FORM_NAME'); ?></td>
					<td><input name="FormName" class="rs_inp rs_80" value="<?php echo $this->escape($this->form->FormName); ?>" size="105" id="FormName" /></td>
				</tr>
				<tr>
					<td width="25%" align="right" nowrap="nowrap" class="key"><?php echo JText::_('RSFP_AJAX_VALIDATION'); ?></td>
					<td><?php echo $this->lists['AjaxValidation']; ?></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td><?php echo JText::_('RSFP_AJAX_VALIDATION_DESC'); ?></td>
				</tr>
			</table>
			</fieldset>
			<fieldset>
			<legend><?php echo JText::_('RSFP_FORM_INFO_SUBMISSION'); ?></legend>
			<table width="100%" class="com-rsform-table-props">
				<tr>
					<td width="25%" align="right" nowrap="nowrap" class="key"><?php echo JText::_('RSFP_SHOW_THANKYOU_MESSAGE'); ?></td>
					<td><?php echo $this->lists['ShowThankyou']; ?></td>
				</tr>
				<tr>
					<td width="25%" align="right" nowrap="nowrap" class="key"><?php echo RSFormProHelper::translateIcon(); ?> <?php echo JText::_('RSFP_THANKYOU'); ?></td>
					<td>
						<button class="rs_button rs_left" onclick="openRSModal('<?php echo JRoute::_('index.php?option=com_rsform&task=richtext.show&opener=Thankyou&formId='.$this->form->FormId.'&tmpl=component'); ?>')" type="button"><span class="rsform_edit"><?php echo JText::_('RSFP_EDIT_THANKYOU'); ?></span></button>
						<button class="rs_button rs_left" onclick="openRSModal('<?php echo JRoute::_('index.php?option=com_rsform&task=richtext.preview&opener=Thankyou&formId='.$this->form->FormId.'&tmpl=component'); ?>', 'RichtextPreview')" type="button"><span class="rsform_preview"><?php echo JText::_('PREVIEW'); ?></span></button>
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td><?php echo JText::_('RSFP_THANKYOU_DESC'); ?></td>
				</tr>
				<tr>
					<td width="25%" align="right" nowrap="nowrap" class="key"><?php echo JText::_('RSFP_SHOW_CONTINUE'); ?></td>
					<td><?php echo $this->lists['ShowContinue']; ?></td>
				</tr>
				<tr>
					<td width="25%" align="right" nowrap="nowrap" class="key"><?php echo JText::_('RSFP_RETURN_URL'); ?></td>
					<td><input name="ReturnUrl" class="rs_inp rs_80" value="<?php echo $this->escape($this->form->ReturnUrl); ?>" size="105" id="ReturnUrl" /></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td><?php echo JText::_('RSFP_RETURN_URL_DESC'); ?></td>
				</tr>
			</table>
			</fieldset>
			<fieldset>
			<legend><?php echo JText::_('RSFP_FORM_INFO_MISC'); ?></legend>
			<table width="100%" class="com-rsform-table-props">
				<tr>
					<td width="25%" align="right" nowrap="nowrap" class="key"><?php echo JText::_('RSFP_SAVE_TO_DATABASE'); ?></td>
					<td><?php echo $this->lists['keepdata']; ?></td>
				</tr>
				<tr>
					<td width="25%" align="right" nowrap="nowrap" class="key"><?php echo JText::_('RSFP_CONFIRM_SUBMISSION'); ?></td>
					<td><?php echo $this->lists['confirmsubmission']; ?></td>
				</tr>
				<tr>
					<td width="25%" align="right" nowrap="nowrap" class="key"><?php echo JText::_('RSFP_REQUIRED'); ?></td>
					<td><input name="Required" class="rs_inp rs_10" value="<?php echo $this->escape($this->form->Required); ?>" size="105" id="Required" /></td>
				</tr>
				<tr>
					<td width="25%" align="right" nowrap="nowrap" class="key"><?php echo RSFormProHelper::translateIcon(); ?>  <?php echo JText::_('RSFP_ERROR_MESSAGE'); ?></td>
					<td>
						<button class="rs_button rs_left" onclick="openRSModal('<?php echo JRoute::_('index.php?option=com_rsform&task=richtext.show&opener=ErrorMessage&formId='.$this->form->FormId.'&tmpl=component'); ?>')" type="button"><span class="rsform_edit"><?php echo JText::_('RSFP_EDIT_ERROR_MESSAGE'); ?></span></button>
						<button class="rs_button rs_left" onclick="openRSModal('<?php echo JRoute::_('index.php?option=com_rsform&task=richtext.preview&opener=ErrorMessage&formId='.$this->form->FormId.'&tmpl=component'); ?>', 'RichtextPreview')" type="button"><span class="rsform_preview"><?php echo JText::_('PREVIEW'); ?></span></button>
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td><?php echo JText::_('RSFP_ERROR_MESSAGE_DESC'); ?></td>
				</tr>
				<tr>
					<td width="25%" align="right" nowrap="nowrap" class="key"><?php echo JText::_('RSFP_MULTIPLE_SEPARATOR'); ?></td>
					<td><input name="MultipleSeparator" class="rs_inp rs_10" value="<?php echo $this->escape($this->form->MultipleSeparator); ?>" size="105" id="MultipleSeparator" /></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td><?php echo JText::_('RSFP_MULTIPLE_SEPARATOR_DESC'); ?></td>
				</tr>
				<tr>
					<td width="25%" align="right" nowrap="nowrap" class="key"><?php echo JText::_('RSFP_TEXTAREA_NEW_LINES'); ?></td>
					<td><?php echo $this->lists['TextareaNewLines']; ?></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td><?php echo JText::_('RSFP_TEXTAREA_NEW_LINES_DESC'); ?></td>
				</tr>
			</table>
			</fieldset>
		  </td>
			<td valign="top" width="1%" nowrap="nowrap">
				<button type="button" class="rs_button" onclick="toggleQuickAdd();"><?php echo JText::_('RSFP_TOGGLE_QUICKADD'); ?></button>
				<div id="QuickAdd2">
					<h3><?php echo JText::_('RSFP_QUICK_ADD');?></h3>
					<?php echo JText::_('RSFP_QUICK_ADD_DESC');?><br/><br/>
					<?php if(!empty($this->quickfields))
						foreach($this->quickfields as $quickfield) { ?>
							<strong><?php echo $quickfield;?></strong><br/>
							<pre>{<?php echo $quickfield; ?>:caption}</pre>
							<pre>{<?php echo $quickfield; ?>:value}</pre>
							<br/>
					<?php } ?>
				</div>
			</td>
	  </tr>

</table>