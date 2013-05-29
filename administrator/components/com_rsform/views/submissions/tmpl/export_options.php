<?php
/**
* @version 1.4.0
* @package RSform!Pro 1.4.0
* @copyright (C) 2007-2013 www.rsjoomla.com
* @license GPL, http://www.gnu.org/copyleft/gpl.html
*/

defined('_JEXEC') or die('Restricted access');
?>
<table class="admintable" width="100%">
	<tr>
		<td width="200" style="width: 200px;" align="right" class="key">
			<span class="hasTip" title="<?php echo JText::_('RSFP_EXPORT_HEADERS_DESC'); ?>">
				<?php echo JText::_('RSFP_EXPORT_HEADERS');?>
			</span>
		</td>
		<td>
			<input type="checkbox" style="text-align: center" onchange="updateCSVPreview();" name="ExportHeaders" value="1" checked="checked" />
		</td>
	</tr>
	<?php if ($this->exportType == 'csv') { ?>
	<tr>
		<td width="200" style="width: 200px;" align="right" class="key">
			<span class="hasTip" title="<?php echo JText::_('RSFP_EXPORT_DELIMITER_DESC'); ?>">
				<?php echo JText::_('RSFP_EXPORT_DELIMITER');?>
			</span>
		</td>
		<td>
			<input type="text" class="rs_inp rs_5" style="text-align: center" onkeyup="updateCSVPreview();" name="ExportDelimiter" value="," size="5" />
		</td>
	</tr>
	<tr>
		<td width="200" style="width: 200px;" align="right" class="key">
			<span class="hasTip" title="<?php echo JText::_('RSFP_EXPORT_ENCLOSURE_DESC'); ?>">
				<?php echo JText::_('RSFP_EXPORT_ENCLOSURE');?>
			</span>
		</td>
		<td>
			<input type="text" class="rs_inp rs_5" style="text-align: center" onkeyup="updateCSVPreview();" name="ExportFieldEnclosure" value="&quot;" size="5" />
		</td>
	</tr>
	<?php } ?>
</table>