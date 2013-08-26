<?php 
/** 
 * @package JMAP::CONFIG::administrator::components::com_jmap
 * @subpackage views
 * @subpackage config
 * @subpackage tmpl
 * @author Joomla! Extensions Store
 * @copyright (C) 2013 - Joomla! Extensions Store
 * @license GNU/GPLv2 http://www.gnu.org/licenses/gpl-2.0.html  
 */
defined ( '_JEXEC' ) or die ( 'Restricted access' ); 
?> 

<form action="index.php" method="post" name="adminForm">  
	 <?php 
	//API nuova JForm da config.xml con fields personalizzati in sostituzione di JElement 	
	echo JHtml::_('tabs.start','config-tabs-jmap_configuration', array('useCookie'=>1));
	$fieldSets = $this->params_form->getFieldsets();
	foreach ($fieldSets as $name => $fieldSet) :
		$label = empty($fieldSet->label) ? 'COM_CONFIG_'.$name.'_FIELDSET_LABEL' : $fieldSet->label;
		echo JHtml::_('tabs.panel',JText::_($label), 'publishing-details');
		if (isset($fieldSet->description) && !empty($fieldSet->description)) :
			echo '<p class="tab-description">'.JText::_($fieldSet->description).'</p>';
		endif; 
		foreach ($this->params_form->getFieldset($name) as $field):
		 	echo '<div>';
			if (!$field->hidden) : 
				echo $field->label; 
			endif; 
			echo $field->input; 
			echo '</div>';
		endforeach; 
	endforeach;
	echo JHtml::_('tabs.end');
	?>
	<input type="hidden" name="option" value="<?php	echo JRequest::getVar('option');?>" /> 
	<input type="hidden" name="task" value="" />
</form> 