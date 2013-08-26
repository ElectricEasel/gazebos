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
<div id="cpanel">
	<?php echo $this->icons; ?>
</div>
<div id="help">
	<?php
		echo $this->pane->startPane( 'stat-pane' );
		echo $this->pane->startPanel( JText::_('JMAP_INFO_STATUS') , 'one' );
	?> 
	<div class="slidercontents">
		<div class="container"> 
			<!-- INFO 1 -->
		 	<div class="codeinfo">
		 		<div class="single_container hasTip" title="<?php echo JText::_('APPEND_LANG_PARAM');?>">
			 		<div class="box"></div><label class="infotitle"><?php echo JText::_('XML_LINK')?></label>
			 		<input data-role="sitemap_links" type="text" size="120" value="<?php echo $this->livesite;?>/index.php?option=com_jmap&view=source&format=xml" />
		 		</div>
		 		 
		 		<div class="single_container">
			 		<div class="box"></div><label class="infotitle"><?php echo JText::_('HTML_LINK')?></label>
			 		<input data-role="sitemap_links" type="text" size="120" value="<?php echo $this->livesite;?>/index.php?option=com_jmap&view=source" />
		 		</div>
		 		
		 		<?php if($this->lists['languages']):?>
		 		<div class="single_container hasTip" title="<?php echo JText::_('CHOOSE_LANGUAGE');?>">
			 		<div class="box"></div><label class="infotitle"><?php echo JText::_('CHOOSE_LANG')?></label>
			 		<?php echo $this->lists['languages'];?>
		 		</div>
		 		<?php endif;?>
			</div>
			<div id="seperator"></div>
			
			<!-- COMPONENT STATUS INDICATOR -->
			<div class="codeinfo">
				<div class="single_container">
			 		<div class="box"></div><label class="infotitle"><?php echo JText::_('NUM_PUBLISHED_DATA_SOURCES');?></label>
			 		<label class="infotitle"><?php echo $this->infodata['publishedDataSource']?></label>
		 		</div>
		 		
		 		<div class="single_container">
			 		<div class="box"></div><label class="infotitle"><?php echo JText::_('NUM_TOTAL_DATA_SOURCES');?></label>
			 		<label class="infotitle"><?php echo $this->infodata['totalDataSource']?></label>
		 		</div>
		 		
		 		<div class="single_container">
			 		<div class="box"></div><label class="infotitle"><?php echo JText::_('NUM_MENU_DATA_SOURCES');?></label>
			 		<label class="infotitle"><?php echo $this->infodata['menuDataSource']?></label> 
		 		</div>
		 		
		 		<div class="single_container">
			 		<div class="box"></div><label class="infotitle"><?php echo JText::_('NUM_USER_DATA_SOURCES');?></label>
			 		<label class="infotitle"><?php echo $this->infodata['userDataSource']?></label> 
		 		</div>
			</div>
		</div>
	</div>  
	<?php
		echo $this->pane->endPanel();
		echo $this->pane->startPanel( JText::_('ABOUT') , 'two' );
	?>
	<div class="slidercontents"> 
		<div class="codeinfo">
			<div class="single_container">
		 		<div class="box"></div><label class="infotitle"><?php echo JText::_('VERSION_COMPONENT');?></label>
	 		</div>
	 		
	 		<div class="single_container">
		 		<div class="box"></div><label class="infotitle"><?php echo JText::_('AUTHOR_COMPONENT');?></label>
	 		</div>
	 		
	 		<div class="single_container">
		 		<div class="box"></div><label class="infotitle"><?php echo JText::_('SUPPORTLINK');?></label>
	 		</div>
	 		
	 		<div class="single_container">
		 		<div class="box"></div><label class="infotitle"><?php echo JText::_('DEMOLINK');?></label>
	 		</div>
	 		
	 		<div class="single_container">
		 		<div class="box"></div><label class="infotitle"><?php echo JText::_('JOOMLAEXTENSIONSLINK');?></label>
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