<?php
/**
 * sh404SEF - SEO extension for Joomla!
 *
 * @author      Yannick Gaultier
 * @copyright   (c) Yannick Gaultier 2012
 * @package     sh404sef
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     3.7.0.1485
 * @date		2012-11-26
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');

?>

<table class="adminlist">
  <tbody>
  
    <tr>
      <td width="20%" class="key">
        <label for="metatitle">
          <?php echo JText::_('COM_SH404SEF_META_TITLE'); ?>&nbsp;
        </label>
      </td>
      <td width="70%">
        <input class="text_area" type="text" name="metatitle" id="metatitle" size="90" value="<?php echo $this->escape( $this->meta->metatitle); ?>" />
      </td>
      <td width="10%">
      <?php echo JHTML::_('tooltip', JText::_('COM_SH404SEF_TT_META_TITLE')); ?>
      </td>
    </tr>
    
    <tr>
      <td width="20%" class="key">
        <label for="metadesc">
          <?php echo JText::_('COM_SH404SEF_META_DESC'); ?>&nbsp;
        </label>
      </td>
      <td width="70%">
        <textarea class="text_area" name="metadesc" id="metadesc" cols="51" rows="5"><?php echo $this->escape( $this->meta->metadesc); ?></textarea>
      </td>
      <td width="10%">
      <?php echo JHTML::_('tooltip', JText::_('COM_SH404SEF_TT_META_DESC')); ?>
      </td>
    </tr>

    <tr>
      <td width="20%" class="key">
        <label for="metakey">
          <?php echo JText::_('COM_SH404SEF_META_KEYWORDS'); ?>&nbsp;
        </label>
      </td>
      <td width="70%">
        <textarea class="text_area" name="metakey" id="metakey" cols="51" rows="3"><?php echo $this->escape( $this->meta->metakey); ?></textarea>
      </td>
      <td width="10%">
      <?php echo JHTML::_('tooltip', JText::_('COM_SH404SEF_TT_META_KEYWORDS')); ?>
      </td>
    </tr>

    <tr>
      <td width="20%" class="key">
        <label for="metarobots">
          <?php echo JText::_('COM_SH404SEF_META_ROBOTS'); ?>&nbsp;
        </label>
      </td>
      <td width="70%">
        <input class="text_area" type="text" name="metarobots" id="metarobots" size="30" value="<?php echo $this->escape( $this->meta->metarobots); ?>" />
      </td>
      <td width="10%">
      <?php echo JHTML::_('tooltip', JText::_('COM_SH404SEF_TT_META_ROBOTS')); ?>
      </td>
    </tr>
    
    <tr>
      <td width="20%" class="key">
        <label for="metalang">
          <?php echo JText::_('COM_SH404SEF_META_LANG'); ?>&nbsp;
        </label>
      </td>
      <td width="70%">
        <input class="text_area" type="text" name="metalang" id="metalang" size="30" value="<?php echo $this->escape( $this->meta->metalang); ?>" />
      </td>
      <td width="10%">
      <?php echo JHTML::_('tooltip', JText::_('COM_SH404SEF_TT_META_LANG')); ?>
      </td>
    </tr>

  </tbody>  
</table>
