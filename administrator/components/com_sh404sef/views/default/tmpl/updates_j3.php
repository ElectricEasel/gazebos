<?php
/**
 * sh404SEF - SEO extension for Joomla!
 *
 * @author      Yannick Gaultier
 * @copyright   (c) Yannick Gaultier 2012
 * @package     sh404sef
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     4.1.0.1559
 * @date		2013-04-25
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');

?>

<div class="sh404sef-updates"
	id="sh404sef-updates">
<!-- start updates panel markup -->

<table class="table table-bordered">
<?php if(!$this->updates->status) : ?>
	<thead>
		<tr>
			<td class="span4 shl-right">
			   <?php
			   $button = ShlHtmlBs_Helper::button(JText::_('COM_SH404SEF_CHECK_UPDATES'));
			   echo '<a href="javascript: void(0);" onclick="javascript: shSetupUpdates(\'forced\');" >' . $button .'</a>';
			   ?>
			</td>
			<td >
        <?php echo JText::_('COM_SH404SEF_ERROR_CHECKING_NEW_VERSION'); ?>
      </td>
		</tr>
	</thead>

	<?php else : ?>
	<thead>
		<tr>
			<td class="span4 shl-right">
			   <?php
			   $button = ShlHtmlBs_Helper::button(JText::_('COM_SH404SEF_CHECK_UPDATES'));
			   echo '<a href="javascript: void(0);" onclick="javascript: shSetupUpdates(\'forced\');" >' . $button .'</a>';
			   ?>
			</td>
			<td >
      			<?php echo ShlHtmlBs_Helper::label($this->updates->statusMessage, $this->updates->shouldUpdate ? 'important' : 'success'); ?>
      		</td>
		</tr>
	</thead>
	<?php if ($this->updates->shouldUpdate) : ?>
	<tr>
	   <td class="span4 shl-right">
	     <?php echo ShlHtmlBs_Helper::label(JText::_( 'COM_SH404SEF_AVAILABLE_VERSION'), 'important')?>
	   </td>
	   <td>
	   <?php
	   if (!empty( $this->updates->current)) {
	       echo $this->updates->current . ' ['
	       . '<a target="_blank" href="' . $this->escape( $this->updates->changelogLink) . '" >'
	       . JText::_('COM_SH404SEF_VIEW_CHANGELOG')
	       . '</a>]'
	       . '&nbsp['
	       . '<a target="_blank" href="' . $this->escape( $this->updates->downloadLink) . '" >'
         . JText::_('COM_SH404SEF_GET_IT')
         . '</a>]';
	   }
	   ?>
     </td>
	</tr>
	<tr>
     <td class="shl-right">
       <?php echo JText::_( 'COM_SH404SEF_NOTES')?>
     </td>
     <td>
     <?php
         echo $this->escape($this->updates->note);
     ?>
     </td>
  </tr>
	<?php

	   endif;
	endif;
	?>
</table>

<!-- end updates panel markup --></div>

