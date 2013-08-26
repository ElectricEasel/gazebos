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
<form action="index.php" method="post" name="adminForm" id="adminForm"> 
	<div class="col60">
		<fieldset class="adminform">
			<legend><?php echo JText::_( 'Details' ); ?></legend> 
			<table class="admintable">
			<tbody>
				<tr>
					<td width="40%" class="key left_title">
						<label for="title">
							<?php echo JText::_( 'NAME' ); ?>:
						</label>
					</td>
					<td width="60%" class="right_details">
						<?php $readOnly = $this->record->type == 'menu' ? 'readonly="readonly"' : '';?>
						<input class="inputbox" type="text" <?php echo $readOnly;?>name="name" id="name" data-validation="required" size="50" value="<?php echo $this->record->name;?>" />
					</td>
				</tr>
				<tr>
					<td width="40%" class="key left_title">
						<label for="type">
							<?php echo JText::_( 'TYPE' ); ?>:
						</label>
					</td>
					<td width="60%" class="right_details">
						<input class="inputbox" type="text" readonly="readonly" name="type" id="type" size="50" value="<?php echo $this->record->type;?>" />
					</td>
				</tr> 
				<tr>
					<td width="40%" class="key left_title">
						<label for="description">
							<?php echo JText::_( 'DESCRIPTION' ); ?>:
						</label>
					</td>
					<td width="60%" class="right_details">
						<textarea class="inputbox" type="text" name="description" id="description" rows="5" cols="80" ><?php echo $this->record->description;?></textarea>
					</td>
				</tr> 
				<tr>
					<td width="40%" class="key left_title">
						<label for="published">
							<?php echo JText::_( 'PUBLISHED' ); ?>:
						</label>
					</td>
					<td width="60%" class="right_details">
						<?php echo $this->lists['published']; ?>
					</td>
				</tr>
			</tbody>
			</table>
		</fieldset>
	</div>
	<?php if ($this->record->type == 'user'): ?>
	<div class="col40"> 
	 	<fieldset id="sqlquerier" class="adminform">
			<legend><?php echo JText::_( 'SQLQUERY_INFO' ); ?></legend> 
			<div class="hasTip" id="dialog_trigger" title="<?php echo JText::_('HELP_EXPLAIN');?>"></div>
			<table  class="admintable">
				<tr>
					<td width="40%" class="key left_title">
						<label for="content" class="hasTip" title="<?php echo JText::_( 'SQLQUERY_COMPONENTNAME_DESC' ); ?>">
							<?php echo JText::_( 'SQLQUERY_COMPONENTNAME' ); ?>
						</label>
					</td>
					<td width="60%" class="right_details">
						<?php echo $this->lists['components']; ?> *
					</td>
				</tr> 
				
				<tr>
					<td width="40%" class="key left_title">
						<label for="content" class="hasTip" title="<?php echo JText::_( 'SQLQUERY_TABLENAME_DESC' ); ?>">
							<?php echo JText::_( 'SQLQUERY_TABLENAME' ); ?>:
						</label>
					</td>
					<td width="60%" class="right_details">
						<?php echo $this->lists['tables']; ?> *
					</td>
				</tr> 
				
				<tr>
					<td width="40%" class="key left_title">
						<label for="content" class="hasTip" title="<?php echo JText::_( 'SQLQUERY_TITLEFIELD_DESC' ); ?>">
							<?php echo JText::_( 'SQLQUERY_TITLEFIELD' ); ?>
						</label>
					</td>
					<td width="60%" class="right_details">
						<?php echo $this->lists ['fieldsTitle']; ?> 
						<input type="hidden" name="sqlquery_managed[titlefield_as]" value="<?php echo isset($this->record->sqlquery_managed->titlefield_as) ? $this->record->sqlquery_managed->titlefield_as : '';?>" /> *
					</td>
				</tr> 
				
				<tr>
					<td width="40%" class="key left_title">
						<label for="content" class="hasTip" title="<?php echo JText::_( 'SQLQUERY_IDFIELD_DESC' ); ?>">
							<?php echo JText::_( 'SQLQUERY_IDFIELD' ); ?>
						</label>
					</td>
					<td width="60%" class="right_details">
						<?php echo $this->lists ['fieldsID']; ?> 
						<label class="as">AS</label>
						<input type="text" name="sqlquery_managed[idfield_as]" value="<?php echo isset($this->record->sqlquery_managed->idfield_as) ? $this->record->sqlquery_managed->idfield_as : '';?>" /> *
					</td>
				</tr> 
				
				<tr>
					<td width="40%" class="key left_title">
						<label for="content" class="hasTip" title="<?php echo JText::_( 'SQLQUERY_CATIDNAME_DESC' ); ?>">
							<?php echo JText::_( 'SQLQUERY_CATIDNAME' ); ?>
						</label>
					</td>
					<td width="60%" class="right_details">
						<?php echo $this->lists ['fieldsCatid']; ?> 
						<label class="as">AS</label>
						<input type="text" name="sqlquery_managed[catidfield_as]" value="<?php echo isset($this->record->sqlquery_managed->catidfield_as) ? $this->record->sqlquery_managed->catidfield_as : '';?>" />
					</td>
				</tr> 
				 
				<tr>
					<td width="40%" class="key left_title">
						<label for="content" class="hasTip" title="<?php echo JText::_( 'SQLQUERY_VIEWNAME_DESC' ); ?>">
							<?php echo JText::_( 'SQLQUERY_VIEWNAME' ); ?>
						</label>
					</td>
					<td width="60%" class="right_details">
						<input type="text" name="sqlquery_managed[view]" value="<?php echo isset($this->record->sqlquery_managed->view) ? $this->record->sqlquery_managed->view : '';?>" />
					</td>
				</tr> 
				
				<tr>
					<td width="40%" class="key left_title">
						<label for="content" class="hasTip" title="<?php echo JText::_( 'SQLQUERY_ADDITIONAL_PARAMS_DESC' ); ?>">
							<?php echo JText::_( 'SQLQUERY_ADDITIONAL_PARAMS' ); ?>
						</label>
					</td>
					<td width="60%" class="right_details">
						<textarea type="text" name="sqlquery_managed[additionalparams]" id="sqlquery_rawparams" rows="5" cols="40" ><?php echo $this->record->sqlquery_managed->additionalparams;?></textarea>
					</td>
				</tr> 
				 
				<?php if($this->record->id):?>
				<tr>
					<td width="40%" class="key left_title">
						<label for="content" class="hasTip" title="<?php echo JText::_( 'SQLQUERY_RAW_DESC' ); ?>">
							<?php echo JText::_( 'SQLQUERY_RAW' ); ?>
						</label>
					</td>
					<td width="60%" class="right_details">
						<textarea type="text" name="sqlquery" id="sqlquery" rows="20" cols="80" ><?php echo $this->record->sqlquery;?></textarea>
						<button class="button hasTip regenerate" title="<?php echo JText::_( 'REGENERATE_QUERY_DESC' ); ?>" onclick="javascript: submitbutton('sources.regenerateQuery')"> 
							<?php echo JText::_( 'REGENERATE_QUERY' ); ?>
						</button>
					</td>
				</tr> 
				<?php endif;?>
			</table>
		</fieldset>
	</div>
	<?php endif; ?>  
	<div class="col40"> 
	 	<fieldset class="adminform">
			<legend><?php echo JText::_( 'Parameters' ); ?></legend> 
			<table  class="admintable">
				<tr>
					<td width="40%" class="paramlist_key left_title"><span class="editlinktip"><label id="paramsopentarget-lbl" for="paramsopentarget" class="hasTip" title="<?php echo JText::_('OPEN_TARGET_DESC');?>"><?php echo JText::_('OPEN_TARGET');?></label></span></td>
					<td width="60%" class="paramlist_value right_details">
						<?php 
							$arr = array(
									JHTML::_('select.option',  '', JText::_( 'JGLOBAL_USE_GLOBAL' ) ),
									JHTML::_('select.option',  '_self', JText::_( 'SELF_WINDOW' ) ),
									JHTML::_('select.option',  '_blank', JText::_( 'BLANK_WINDOW' ) ),
									JHTML::_('select.option',  '_parent', JText::_( 'PARENT_WINDOW' ) )
							);
							echo JHTML::_('select.radiolist',  $arr, 'params[opentarget]', '', 'value', 'text', $this->record->params->getValue('opentarget', ''));
						?>
					</td>
				</tr>
				<?php if(in_array($this->record->type, array('user', 'menu'))):?>
				<tr>
					<td width="40%" class="paramlist_key left_title">
						<span class="editlinktip"><label id="paramstitle-lbl" for="paramstitle" class="hasTip" title="<?php echo JText::_('SHOWED_SOURCE_TITLE_DESC');?>"><?php echo JText::_('SHOWED_SOURCE_TITLE');?></label></span>
					</td>
					<td width="60%" class="paramlist_value right_details">
						<input type="text" name="params[title]" id="paramstitle" value="<?php echo $this->record->params->getValue('title', '');?>" class="text_area">
					</td>
				</tr>
				<tr>
					<td width="40%" class="paramlist_key left_title"><span class="editlinktip"><label id="paramsshow_title-lbl" for="paramsshow_title" class="hasTip" title="<?php echo JText::_('SHOW_SOURCE_TITLE_DESC');?>"><?php echo JText::_('SHOW_SOURCE_TITLE');?></label></span></td>
					<td width="60%" class="paramlist_value right_details"><?php echo JHTML::_('select.booleanlist', 'params[showtitle]', null,  $this->record->params->getValue('showtitle', 1));?></td>
				</tr>
				<?php endif;?>
				<?php if($this->record->type == 'user'):?>
				<tr>
					<td width="40%" class="paramlist_key left_title"><span class="editlinktip"><label id="paramsdebug_mode-lbl" for="paramsdebug_mode" class="hasTip" title="<?php echo JText::_('DEBUG_MODE_DESC');?>"><?php echo JText::_('DEBUG_MODE');?></label></span></td>
					<td width="60%" class="paramlist_value right_details"><?php echo JHTML::_('select.booleanlist', 'params[debug_mode]', null,  $this->record->params->getValue('debug_mode', 0));?></td>
				</tr>
				<tr>
					<td width="40%" class="paramlist_key left_title">
						<span class="editlinktip"><label id="paramstitle-lbl" for="paramstitle" class="hasTip" title="<?php echo JText::_('ENTER_ADDITIONAL_QUERYSTRING_PARAMS_DESC');?>"><?php echo JText::_('ENTER_ADDITIONAL_QUERYSTRING_PARAMS');?></label></span>
					</td>
					<td class="paramlist_value right_details">
						<input size="100" type="text" name="params[additionalquerystring]" id="paramsadditionalquerystring" value="<?php echo $this->record->params->getValue('additionalquerystring', '');?>" class="text_area">
					</td>
				</tr>
				<?php endif;?>
				
				<?php if($this->record->type == 'menu'):?>
				<tr>
					<td width="40%" class="paramlist_key left_title"><span class="editlinktip"><label id="paramsdounpublished-lbl" for="paramsdounpublished" class="hasTip" title="<?php echo JText::_('DOUPUBLISHED_DESC');?>"><?php echo JText::_('DOUPUBLISHED');?></label></span></td>
					<td width="60%" class="paramlist_value right_details"><?php echo JHTML::_('select.booleanlist', 'params[dounpublished]', null,  $this->record->params->getValue('dounpublished', 0));?></td>
				</tr>
				<tr>
					<td width="40%" class="paramlist_key left_title"><span class="editlinktip"><label id="paramsinclude_external_links-lbl" for="paramsinclude_external_links" class="hasTip" title="<?php echo JText::_('INCLUDE_EXTERNAL_LINKS_DESC');?>"><?php echo JText::_('INCLUDE_EXTERNAL_LINKS');?></label></span></td>
					<td width="60%" class="paramlist_value right_details"><?php echo JHTML::_('select.booleanlist', 'params[include_external_links]', null,  $this->record->params->getValue('include_external_links', 1));?></td>
				</tr>
				<?php endif;?>
			</table>
		</fieldset> 
	</div> 
	<div class="col40"> 
	 	<fieldset class="adminform">
			<legend><?php echo JText::_( 'XMLSITEMAP_PARAMETERS' ); ?></legend> 
			<table  class="admintable">
				<tr>
					<td width="40%" class="paramlist_key left_title"><span class="editlinktip"><label id="paramsxmlinclude-lbl" for="paramsxmlinclude" class="hasTip" title="<?php echo JText::_('ELEMENTS_INCLUDE_DESC');?>"><?php echo JText::_('ELEMENTS_INCLUDE');?></label></span></td>
					<td width="60%" class="paramlist_value right_details"><?php echo JHTML::_('select.booleanlist', 'params[xmlinclude]', null,  $this->record->params->getValue('xmlinclude', 1));?></td>
				</tr>
				<tr>
					<td width="40%" class="paramlist_key left_title">
						<span class="editlinktip"><label id="paramstitle-lbl" for="paramstitle" class="hasTip" title="<?php echo JText::_('ELEMENTS_PRIORITY_DESC');?>"><?php echo JText::_('ELEMENTS_PRIORITY');?></label></span>
					</td>
					<td width="60%" class="paramlist_value right_details">
						<?php echo $this->lists['priority']; ?>
					</td>
				</tr>
				<tr>
					<td width="40%" class="paramlist_key left_title">
						<span class="editlinktip"><label id="paramstitle-lbl" for="paramstitle" class="hasTip" title="<?php echo JText::_('ELEMENTS_CHANGEFREQUENCY_DESC');?>"><?php echo JText::_('ELEMENTS_CHANGEFREQUENCY');?></label></span>
					</td>
					<td width="60%" class="paramlist_value right_details">
						<?php echo $this->lists['changefreq']; ?>
					</td>
				</tr>
			</table>
		</fieldset> 
	</div>
	<?php if($this->record->type == 'menu'):?>
		<fieldset class="adminform">
			<legend><?php echo JText::_( 'MENU_EXCLUSION' ); ?></legend> 
			<table  class="admintable">
				<tr>
					<td width="40%" class="paramlist_key left_title">
						<span class="editlinktip"><label id="paramstitle-lbl" for="paramstitle" class="hasTip" title="<?php echo JText::_('CHOOSE_MENU_EXCLUSION_DESC');?>"><?php echo JText::_('CHOOSE_MENU_EXCLUSION');?></label></span>
					</td>
					<td width="60%" class="paramlist_value right_details">
						<?php echo $this->lists['exclusion']; ?>
					</td>
				</tr>
			</table>
		</fieldset> 
	<?php endif;?>
	<?php if($this->record->type == 'content'):?>
		<fieldset class="adminform">
			<legend><?php echo JText::_( 'CATEGORIES_EXCLUSION' ); ?></legend> 
			<table  class="admintable">
				<tr>
					<td width="40%" class="paramlist_key">
						<span class="editlinktip"><label id="paramstitle-lbl" for="paramstitle" class="hasTip" title="<?php echo JText::_('CHOOSE_CATEGORIES_EXCLUSION_DESC');?>"><?php echo JText::_('CHOOSE_CATEGORIES_EXCLUSION');?></label></span>
					</td>
					<td class="paramlist_value">
						<?php echo $this->lists['catexclusion']; ?>
					</td>
				</tr>
			</table>
		</fieldset> 
	<?php endif;?>
	<input type="hidden" name="option" value="<?php echo $this->option?>" />
	<input type="hidden" name="id" value="<?php echo $this->record->id; ?>" />
	<input type="hidden" id="regenerate_query" name="regenerate_query" value="" />
	<input type="hidden" name="task" value="" />
</form>

<div id="dialog" title="<?php echo JText::_('EXAMPLE_DATA_SUGGESTIONS');?>">
	<iframe id="dialog_iframe"></iframe>
</div>