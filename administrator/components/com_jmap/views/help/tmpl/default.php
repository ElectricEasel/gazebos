<?php 
/** 
 * @package JMAP::CPANEL::administrator::components::com_jmap
 * @subpackage views
 * @subpackage cpanel
 * @subpackage tmpl
 * @author Joomla! Extensions Store
 * @copyright (C) 2013 - Joomla! Extensions Store
 * @license GNU/GPLv2 http://www.gnu.org/licenses/gpl-2.0.html  
 */
defined ( '_JEXEC' ) or die ( 'Restricted access' ); 
?> 
<div id="help">
	<?php
		echo $this->pane->startPane( 'stat-pane' );
		echo $this->pane->startPanel( JText::_('JMAP_FUNCTIONALITIES') , 'one' );
	?> 
	<div class="slidercontents">
		<div id="license"> 
			<!-- INFO 1 -->
		 	<div class="codeinfo">
		 		 <?php echo JText::_('JMAP_FUNCIONALITIES_DESC');?>
			</div>
		</div>
	</div>  
	<?php
		echo $this->pane->endPanel();
		echo $this->pane->startPanel( JText::_('JMAP_DATASOURCES') , 'two' );
	?>
  	<div class="slidercontents">
		<div id="license"> 
			<!-- INFO 1 -->
		 	<div class="codeinfo">
		 		 <?php echo JText::_('JMAP_DATASOURCES_DESC');?>
			</div>
			<div id="seperator"></div>
			
			<!-- COMPONENT STATUS INDICATOR -->
			<div id="componentstatus">
				 <?php echo JText::_('JMAP_DATASOURCES_RESULT_DESC');?>
			</div>
		</div>
	</div>  
	<?php
		echo $this->pane->endPanel();
		echo $this->pane->startPanel( JText::_('JMAP_CONTROLPANEL') , 'two' );
	?>
  	<div class="slidercontents">
		<div id="license"> 
			<!-- INFO 1 -->
		 	<div class="codeinfo">
		 		 <?php echo JText::_('JMAP_CONTROLPANEL_DESC');?>
			</div>
		</div>
	</div>  
	<?php
		echo $this->pane->endPanel();
		echo $this->pane->endPane();
	?>
</div>

<form name="adminForm" action="index.php">
	<input type="hidden" name="option" value="<?php echo JRequest::getCmd('option');?>"/>
	<input type="hidden" name="task" value=""/>
</form>