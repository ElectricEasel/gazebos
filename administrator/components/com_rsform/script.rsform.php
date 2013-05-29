<?php
/**
* @version 1.4.0
* @package RSForm! Pro 1.4.0
* @copyright (C) 2007-2013 www.rsjoomla.com
* @license GPL, http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access');

class com_rsformInstallerScript
{
	protected $source;
	
	public function install($parent) {
		
	}
	
	public function update($parent) {
		$db = JFactory::getDbo();
		$this->source = $parent->getParent()->getPath('source');
		
		// Disable error reporting
		$query = $db->getQuery(true);
		$query->update('#__rsform_config')
			  ->set($db->quoteName('SettingValue').'='.$db->quote(0))
			  ->where($db->quoteName('SettingName').'='.$db->quote('global.debug.mode'));
		$db->setQuery($query);
		$db->execute();
		
		// #__rsform_forms updates
		$columns = $db->getTableColumns('#__rsform_forms');
		if (!isset($columns['UserEmailAttach'])) {
			$db->setQuery("ALTER TABLE #__rsform_forms ADD `UserEmailAttach` TINYINT NOT NULL AFTER `UserEmailMode`");
			$db->execute();
		}
		if (!isset($columns['UserEmailAttachFile'])) {
			$db->setQuery("ALTER TABLE #__rsform_forms ADD `UserEmailAttachFile` VARCHAR (255) NOT NULL AFTER `UserEmailAttach`");
			$db->execute();
		}
		if (!isset($columns['ScriptProcess2'])) {
			$db->setQuery("ALTER TABLE #__rsform_forms ADD `ScriptProcess2` TEXT NOT NULL AFTER `ScriptProcess`");
			$db->execute();
		}
		if (!isset($columns['UserEmailCC'])) {
			$db->setQuery("ALTER TABLE #__rsform_forms ADD `UserEmailCC` VARCHAR (255) NOT NULL AFTER `UserEmailTo`");
			$db->execute();
		}
		if (!isset($columns['UserEmailBCC'])) {
			$db->setQuery("ALTER TABLE #__rsform_forms ADD `UserEmailBCC` VARCHAR (255) NOT NULL AFTER `UserEmailCC`");
			$db->execute();
		}
		if (!isset($columns['UserEmailReplyTo'])) {
			$db->setQuery("ALTER TABLE #__rsform_forms ADD `UserEmailReplyTo` VARCHAR (255) NOT NULL AFTER `UserEmailBCC`");
			$db->execute();
		}
		if (!isset($columns['AdminEmailCC'])) {
			$db->setQuery("ALTER TABLE #__rsform_forms ADD `AdminEmailCC` VARCHAR (255) NOT NULL AFTER `AdminEmailTo`");
			$db->execute();
		}
		if (!isset($columns['AdminEmailBCC'])) {
			$db->setQuery("ALTER TABLE #__rsform_forms ADD `AdminEmailBCC` VARCHAR (255) NOT NULL AFTER `AdminEmailCC`"); 
			$db->execute();
		}
		if (!isset($columns['AdminEmailReplyTo'])) {
			$db->setQuery("ALTER TABLE #__rsform_forms ADD `AdminEmailReplyTo` VARCHAR (255) NOT NULL AFTER `AdminEmailBCC`");
			$db->execute();
		}
		if (!isset($columns['MetaTitle'])) {
			$db->setQuery("ALTER TABLE `#__rsform_forms` ADD `MetaTitle` TINYINT( 1 ) NOT NULL");
			$db->execute();
			$db->setQuery("ALTER TABLE `#__rsform_forms` ADD `MetaDesc` TEXT NOT NULL");
			$db->execute();
			$db->setQuery("ALTER TABLE `#__rsform_forms` ADD `MetaKeywords` TEXT NOT NULL");
			$db->execute();
			$db->setQuery("ALTER TABLE `#__rsform_forms` ADD `Required` VARCHAR( 255 ) NOT NULL DEFAULT '(*)'");
			$db->execute();
			$db->setQuery("ALTER TABLE `#__rsform_forms` ADD `ErrorMessage` TEXT NOT NULL");
			$db->execute();
			
			$db->setQuery("SELECT FormId FROM #__rsform_forms WHERE FormId='1' AND FormName='RSformPro example' AND ErrorMessage=''");
			if ($db->loadResult())
			{
				$db->setQuery("UPDATE #__rsform_forms SET MetaTitle=0, MetaDesc='This is the meta description of your form. You can use it for SEO purposes.', MetaKeywords='rsform, contact, form, joomla', Required='(*)', ErrorMessage='<p class=\"formRed\">Please complete all required fields!</p>' WHERE FormId='1' LIMIT 1");
				$db->execute();
			}
		}
		if (!isset($columns['CSS'])) {
			$db->setQuery("ALTER TABLE `#__rsform_forms` ADD `CSS` TEXT NOT NULL AFTER `FormLayoutAutogenerate` ,".
						  " ADD `JS` TEXT NOT NULL AFTER `CSS` ,".
						  " ADD `ShowThankyou` TINYINT( 1 ) NOT NULL DEFAULT '1' AFTER `ReturnUrl` ,".
						  " ADD `UserEmailScript` TEXT NOT NULL AFTER `ScriptDisplay` ,".
						  " ADD `AdminEmailScript` TEXT NOT NULL AFTER `UserEmailScript` ,".
						  " ADD `MultipleSeparator` VARCHAR( 64 ) NOT NULL AFTER `ErrorMessage` ,".
						  " ADD `TextareaNewLines` TINYINT( 1 ) NOT NULL AFTER `MultipleSeparator`");
			$db->execute();
		}
		if (!isset($columns['CSSClass'])) {
			$db->setQuery("ALTER TABLE `#__rsform_forms` ADD `CSSClass` VARCHAR( 255 ) NOT NULL AFTER `TextareaNewLines` ,".
						  " ADD `CSSId` VARCHAR( 255 ) NOT NULL DEFAULT 'userForm' AFTER `CSSClass` ,".
						  " ADD `CSSName` VARCHAR( 255 ) NOT NULL AFTER `CSSId` ,".
						  " ADD `CSSAction` TEXT NOT NULL AFTER `CSSName` ,".
						  " ADD `CSSAdditionalAttributes` TEXT NOT NULL AFTER `CSSAction`,".
						  " ADD `AjaxValidation` TINYINT( 1 ) NOT NULL AFTER `CSSAdditionalAttributes`");
			$db->execute();
		}
		if (isset($columns['UserEmailConfirmation'])) {
			$db->setQuery("ALTER TABLE `#__rsform_forms` DROP `UserEmailConfirmation`");
			$db->execute();
		}
		if (!isset($columns['ThemeParams'])) {
			$db->setQuery("ALTER TABLE `#__rsform_forms` ADD `ThemeParams` TEXT NOT NULL");
			$db->execute();
		}
		if (!isset($columns['ShowContinue'])) {
			$db->setQuery("ALTER TABLE `#__rsform_forms` ADD `ShowContinue` TINYINT( 1 ) NOT NULL DEFAULT '1' AFTER `Thankyou`");
			$db->execute();
		}
		if (!isset($columns['Keepdata'])) {
			$db->setQuery("ALTER TABLE `#__rsform_forms` ADD `Keepdata` TINYINT( 1 ) NOT NULL DEFAULT '1'");
			$db->execute();
			$db->setQuery("UPDATE `#__rsform_forms` SET `Keepdata` = 1");
			$db->execute();
		} else {
			$db->setQuery("ALTER TABLE `#__rsform_forms` CHANGE `Keepdata` `Keepdata` TINYINT( 1 ) NOT NULL DEFAULT '1'");
			$db->execute();
		}
		if (!isset($columns['Backendmenu'])) {
			$db->setQuery("ALTER TABLE `#__rsform_forms` ADD `Backendmenu` TINYINT( 1 ) NOT NULL");
			$db->execute();
		}
		if (!isset($columns['ConfirmSubmission'])) {
			$db->setQuery("ALTER TABLE `#__rsform_forms` ADD `ConfirmSubmission` TINYINT( 1 ) NOT NULL DEFAULT '0'");
			$db->execute();
		}
		if (!isset($columns['AdditionalEmailsScript'])) {
			$db->setQuery("ALTER TABLE `#__rsform_forms` ADD `AdditionalEmailsScript` TEXT NOT NULL AFTER `AdminEmailScript`");
			$db->execute();
		}
		if (!isset($columns['ShowFormTitle'])) {
			$db->setQuery("ALTER TABLE `#__rsform_forms` ADD `ShowFormTitle` TINYINT( 1 ) NOT NULL DEFAULT '1' AFTER `FormTitle`");
			$db->execute();
		}
		
		if ($columns['FormLayout'] == 'text') {
			$db->setQuery("ALTER TABLE `#__rsform_forms` CHANGE `FormLayout` `FormLayout` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL");
			$db->execute();
		}
		
		// #__rsform_config updates
		$columns = $db->getTableColumns('#__rsform_config', false);
		if (isset($columns['ConfigId'])) {
			$db->setQuery("ALTER TABLE `#__rsform_config` DROP `ConfigId`");
			$db->execute();
		}
		if (!$columns['SettingName']->Key) {
			$db->setQuery("ALTER TABLE `#__rsform_config` ADD PRIMARY KEY (`SettingName`)");
			if (!$db->execute()) {
				// remove duplicates
				$query = $db->getQuery(true);
				$query->select($db->quoteName('SettingName'))->from('#__rsform_config');
				$db->setQuery($query);
				$results = $db->loadColumn();
				
				$counts = array_count_values($results);
				foreach ($counts as $key => $num) {
					if ($num > 1) {
						$db->setQuery("DELETE FROM #__rsform_config WHERE ".$db->quoteName('SettingName').'='.$db->quote($key)." LIMIT ".($num-1));
						$db->execute();
					}
				}
				
				$db->setQuery("ALTER TABLE `#__rsform_config` ADD PRIMARY KEY (`SettingName`)");
				$db->execute();
			}
		}
		
		// #__rsform_submission_values updates
		$columns = $db->getTableColumns('#__rsform_submission_values', false);
		if ($columns['FormId']->Key != 'MUL') {
			$db->setQuery("ALTER TABLE #__rsform_submission_values ADD INDEX (`FormId`)"); 
			$db->execute();
		}
		if ($columns['SubmissionId']->Key != 'MUL') {
			$db->setQuery("ALTER TABLE #__rsform_submission_values ADD INDEX (`SubmissionId`)");
			$db->execute();
		}
		if (!isset($columns['FormId'])) {
			$db->setQuery("ALTER TABLE #__rsform_submission_values ADD `FormId` INT NOT NULL AFTER `SubmissionValueId`");
			$db->execute();
			$db->setQuery("UPDATE #__rsform_submission_values sv, #__rsform_submissions s SET sv.FormId=s.FormId WHERE sv.SubmissionId = s.SubmissionId");
			$db->execute();
		}
		
		// #__rsform_submissions updates
		$columns = $db->getTableColumns('#__rsform_submissions', false);
		if ($columns['FormId']->Key != 'MUL') {
			$db->setQuery("ALTER TABLE #__rsform_submissions ADD INDEX (`FormId`)");
			$db->execute();
		}
		if (!isset($columns['Lang'])) {
			$db->setQuery("ALTER TABLE `#__rsform_submissions` ADD `Lang` VARCHAR( 255 ) NOT NULL AFTER `UserId`");
			$db->execute();
		}
		if (!isset($columns['confirmed'])) {
			$db->setQuery("ALTER TABLE `#__rsform_submissions` ADD `confirmed` TINYINT( 1 ) NOT NULL");
			$db->execute();
		}
		
		// #__rsform_component_type_fields updates
		$query = $db->getQuery(true);
		$query->update('#__rsform_component_type_fields')
			  ->set($db->quoteName('FieldType').'='.$db->quote('textarea'))
			  ->where($db->quoteName('FieldName').'='.$db->quote('DEFAULTVALUE'))
			  ->where($db->quoteName('ComponentTypeId').'='.$db->quote(1));
		$db->setQuery($query);
		$db->execute();
		
		$columns = $db->getTableColumns('#__rsform_component_type_fields', false);
		if (isset($columns['ComponentTypeFieldId'])) {
			$db->setQuery("ALTER TABLE `#__rsform_component_type_fields` DROP `ComponentTypeFieldId`");
			$db->execute();
		}
		if ($columns['ComponentTypeId']->Key != 'MUL') {
			$db->setQuery("ALTER TABLE #__rsform_component_type_fields ADD INDEX (`ComponentTypeId`)");
			$db->execute();
		}
		if ($columns['FieldType']->Type != "enum('hidden','hiddenparam','textbox','textarea','select','emailattach')") {
			$db->setQuery("ALTER TABLE `#__rsform_component_type_fields` CHANGE `FieldType` `FieldType` ENUM( 'hidden', 'hiddenparam', 'textbox', 'textarea', 'select', 'emailattach' ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'hidden'");
			$db->execute();
		}
		// rename old RSadapter function to new one
		$db->setQuery("UPDATE #__rsform_component_type_fields SET FieldValues='".$db->escape("//<code>\r\nreturn JPATH_SITE.'/components/com_rsform/uploads/';\r\n//</code>")."' WHERE FieldName='DESTINATION' AND ComponentTypeId=9 AND FieldValues LIKE '%RSadapter%'");
		$db->execute();
		// remove old "ATTACHUSEREMAIL" and "ATTACHADMINEMAIL" fields
		$db->setQuery("SELECT * FROM #__rsform_component_type_fields WHERE `ComponentTypeId` = 9 AND `FieldName`='ATTACHUSEREMAIL' OR `FieldName`='ATTACHADMINEMAIL'");
		if ($db->loadResult()) {
			$db->setQuery("DELETE FROM `#__rsform_component_type_fields` WHERE `ComponentTypeId` = 9 AND `FieldName` ='ATTACHUSEREMAIL'");
			$db->execute();
			$db->setQuery("DELETE FROM `#__rsform_component_type_fields` WHERE `ComponentTypeId` = 9 AND `FieldName` ='ATTACHADMINEMAIL'");
			$db->execute();
			
			// if we deleted the fields, then we need to migrate the old information
			$db->setQuery("SELECT `ComponentId` FROM `#__rsform_components` WHERE `ComponentTypeId` = 9 ");
			if ($uploadcomponents = $db->loadColumn()) {
				$db->setQuery("SELECT * FROM #__rsform_properties WHERE ComponentId IN (".implode(",", $uploadcomponents).") AND PropertyName IN ('ATTACHADMINEMAIL', 'ATTACHUSEREMAIL') AND PropertyValue='YES'");
				$properties = array();
				if ($tmp = $db->loadObject()) {
					if (!isset($properties[$tmp->ComponentId])) {
						$properties[$tmp->ComponentId] = array();
					}
					$properties[$tmp->ComponentId][$tmp->PropertyName] = 1;
				}
				
				foreach ($properties as $ComponentId => $property) {
					$updateemailattach = array();
					
					if (isset($property['ATTACHADMINEMAIL'])) {
						$updateemailattach[] = 'adminemail';
					}
					if (isset($property['ATTACHUSEREMAIL'])) {
						$updateemailattach[] = 'useremail';
					}
					
					if ($updateemailattach) {
						$db->setQuery("INSERT INTO #__rsform_properties SET ComponentId = '".$ComponentId."' , PropertyName = 'EMAILATTACH', PropertyValue = '".$db->escape(implode(",", $updateemailattach))."' ");
						$db->execute();
					}
				}
				
				// delete them
				$db->setQuery("DELETE FROM #__rsform_properties WHERE PropertyName IN ('ATTACHADMINEMAIL', 'ATTACHUSEREMAIL')");
				$db->execute();
			}
		}
		$db->setQuery("UPDATE `#__rsform_component_type_fields` SET `FieldType` = 'textarea' WHERE `ComponentTypeId` = 6 AND `FieldName` IN ('MINDATE', 'MAXDATE') AND `FieldType` = 'textbox'");
		$db->execute();
		
		// #__rsform_components updates
		$columns = $db->getTableColumns('#__rsform_components', false);
		if ($columns['FormId']->Key != 'MUL') {
			$db->setQuery("ALTER TABLE #__rsform_components ADD INDEX (`FormId`)");
			$db->execute();
		}
		if ($columns['ComponentTypeId']->Key != 'MUL') {
			$db->setQuery("ALTER TABLE #__rsform_components ADD INDEX (`ComponentTypeId`)");
			$db->execute();
		}
		
		// #__rsform_properties
		$columns = $db->getTableColumns('#__rsform_properties', false);
		if ($columns['ComponentId']->Key != 'MUL') {
			$db->setQuery("ALTER TABLE #__rsform_properties ADD INDEX (`ComponentId`)");
			$db->execute();
		}
		
		// #__rsform_mappings migration
		$columns = $db->getTableColumns('#__rsform_mappings');
		if (isset($columns['MappingTable'])) {
			$db->setQuery("SELECT * FROM #__rsform_mappings");
			$mappings = $db->loadObjectList();

			$mtables = array();
			if (!empty($mappings))
			{
				foreach ($mappings as $mapping)
				{		
					$db->setQuery("SELECT p.PropertyValue FROM #__rsform_properties p LEFT JOIN #__rsform_components c ON (p.ComponentId = c.ComponentId) WHERE c.ComponentId='".$mapping->ComponentId."' AND p.PropertyName='NAME' AND c.Published='1' ORDER BY c.Order");
					$component = $db->loadResult();
					
					$db->setQuery("SELECT FormId FROM #__rsform_components WHERE ComponentId = '".$mapping->ComponentId."'");
					$formId = $db->loadResult();
					
					if (!empty($component))
					{
						$object = new stdClass();
						$object->column = $mapping->MappingColumn;
						$object->component = '{'.$component.':value}';
						$mtables[$mapping->MappingTable][$formId][] = $object;
					}
				}
			}
			
			$db->setQuery("DROP TABLE `#__rsform_mappings`");
			$db->execute();
			
			$this->runSQL('mappings.sql');

			$data = array();
			if (!empty($mtables))
			{
				foreach ($mtables as $table => $details)
				{
					if (!empty($details))
					foreach ($details as $formId => $columns)
					{
						if (!empty($columns))
						foreach ($columns as $column)
						{
							$data[$column->column] = $column->component;
						}
						
						if (!empty($data))
						{
							$data = serialize($data);
							
							$db->setQuery("INSERT INTO `#__rsform_mappings` SET `formId` = '".$db->escape($formId)."', `connection` = 0, `port` = '3306', `method` = 0, `table` = '".$db->escape($table)."', `data` = '".$db->escape($data)."' ");
							$db->execute();
						}
						unset($data);
					}
				}
			}
		}
		
		// add config data
		$this->runSQL('config.data.sql');
		
		$this->runSQL('component_type_fields.data.sql');
		$this->runSQL('component_types.data.sql');
		$this->runSQL('conditions.sql');
		$this->runSQL('condition_details.sql');
		$this->runSQL('emails.sql');
		$this->runSQL('posts.sql');
		$this->runSQL('submission_columns.sql');
		$this->runSQL('translations.sql');
	}
	
	public function uninstall($parent) {
		
	}
	
	public function preflight($type, $parent) {
		$app = JFactory::getApplication();
		
		$jversion = new JVersion();
		if (!$jversion->isCompatible('2.5.5')) {
			$app->enqueueMessage('Please upgrade to at least Joomla! 2.5.5 before continuing!', 'error');
			return false;
		}
		
		if ($jversion->isCompatible('3.0.0') && !$jversion->isCompatible('3.0.2')) {
			$app->enqueueMessage('Please upgrade to at least Joomla! 3.0.2 before continuing!', 'error');
			return false;
		}
		
		return true;
	}
	
	public function postflight($type, $parent) {
		if ($type == 'uninstall') {
			return true;
		}
		
		$this->source = $parent->getParent()->getPath('source');
		
		// Get a new installer
		$installer = new JInstaller();
		
		$db = JFactory::getDbo();
		
		$messages = array(
			'lib_tcpdf' => false,
			'plugins' 	=> array(),
			'modules' 	=> array()
		);
		// update plugins, modules as necessary
		if ($installer->install($this->source.'/other/lib_tcpdf')) {
			$messages['lib_tcpdf'] = true;
		}
		
		$this->checkPlugins($messages);
		
		$this->showInstallMessage($messages);
	}
	
	protected function checkPlugins(&$messages) {
		$data = array(
			// folder => name
			'plg_akismet' => 'rsfpakismet',
			'plg_constantcontact' => 'rsfpconstantcontact',
			'plg_content' => 'rsform',
			'plg_google' => 'rsfpgoogle',
			'plg_mailchimp' => 'rsfpmailchimp',
			'plg_pdf' => 'rsfppdf',
			'plg_recaptcha ' => 'rsfprecaptcha',
			'plg_rseventspro' => 'rsfprseventspro',
			'plg_rsform' => 'rsform',
			'plg_rsfpregistration' => 'rsfpregistration',
			'plg_rsfprsmail' => 'rsfprsmail',
			'plg_salesforce' => 'rsfpsalesforce',
			'plg_vtiger' => 'rsfpvtiger',
			'pkg_payment' => 'rsfppaypal',
			'' => 'rsfpfeedback'
		);
		$plugins = array_values($data);
		$folders = array_flip($data);
		
		if ($installed = $this->getPlugins($plugins)) {
			// need to update old plugins
			foreach ($installed as $plugin) {
				$file = JPATH_SITE.'/plugins/'.$plugin->folder.'/'.$plugin->element.'/'.$plugin->element.'.xml';
				if (file_exists($file)) {
					$xml = file_get_contents($file);
					if (strpos($xml, '<extension') === false) {
						$this->disableExtension($plugin->extension_id);
						
						$status = 'warning';
						$text	= 'Disabled';
						
						if ($plugin->element == 'rsfpfeedback') {
							$status = 'not-ok';
							$text 	= 'No longer needed, please uninstall!';
						}
						
						$messages['plugins'][] = (object) array(
							'name' 		=> $plugin->name,
							'status' 	=> $status,
							'text'		=> $text
						);
					}
				}
			}
		}
		
		$modules = array(
			'mod_rsform',
			'mod_rsform_feedback',
			'mod_rsform_list'
		);
		
		if ($installed = $this->getModules($modules)) {
			foreach ($installed as $module) {
				$file = JPATH_SITE.'/modules/'.$module->element.'/'.$module->element.'.xml';
				if (file_exists($file)) {
					$xml = file_get_contents($file);
					if (strpos($xml, '<install') !== false) {
						$this->disableExtension($module->extension_id);
						
						$messages['modules'][] = (object) array(
							'name' 		=> $module->name,
							'status' 	=> 'warning',
							'text'		=> 'Disabled'
						);
					}
				}
			}
		}
	}
	
	protected function disableExtension($extension_id) {
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->update('#__extensions')
			  ->set($db->quoteName('enabled').'='.$db->quote(0))
			  ->where($db->quoteName('extension_id').'='.$db->quote($extension_id));
		$db->setQuery($query);
		$db->execute();
	}
	
	protected function runSQL($file) {
		$db = JFactory::getDbo();
		$driver = strtolower($db->name);
		if ($driver == 'mysqli') {
			$driver = 'mysql';
		} elseif ($driver == 'sqlsrv') {
			$driver = 'sqlazure';
		}
		
		$sqlfile = $this->source.'/admin/sql/'.$driver.'/'.$file;
		
		if (file_exists($sqlfile)) {
			$buffer = file_get_contents($sqlfile);
			if ($buffer !== false) {
				$queries = JInstallerHelper::splitSql($buffer);
				foreach ($queries as $query) {
					$query = trim($query);
					if ($query != '' && $query{0} != '#') {
						$db->setQuery($query);
						if (!$db->execute()) {
							JError::raiseWarning(1, JText::sprintf('JLIB_INSTALLER_ERROR_SQL_ERROR', $db->stderr(true)));
						}
					}
				}
			}
		}
	}
	
	protected function escape($string) {
		return htmlentities($string, ENT_COMPAT, 'utf-8');
	}
	
	protected function getPlugins($element) {
		$db 	= JFactory::getDbo();
		$query 	= $db->getQuery(true);
		$one	= false;
		if (!is_array($element)) {
			$element = array($element);
			$one = true;
		}
		
		$query->select('*')
			  ->from('#__extensions')
			  ->where($db->quoteName('type').'='.$db->quote('plugin'))
			  ->where($db->quoteName('folder').' IN ('.$this->quoteImplode(array('content', 'system')).')')
			  ->where($db->quoteName('element').' IN ('.$this->quoteImplode($element).')');
		$db->setQuery($query);
		
		return $one ? $db->loadObject() : $db->loadObjectList();
	}
	
	protected function getModules($element) {
		$db 	= JFactory::getDbo();
		$query 	= $db->getQuery(true);
		$one	= false;
		if (!is_array($element)) {
			$element = array($element);
			$one = true;
		}
		
		$query->select('*')
			  ->from('#__extensions')
			  ->where($db->quoteName('type').'='.$db->quote('module'))
			  ->where($db->quoteName('element').' IN ('.$this->quoteImplode($element).')');
		$db->setQuery($query);
		
		return $one ? $db->loadObject() : $db->loadObjectList();
	}
	
	protected function quoteImplode($array) {
		$db = JFactory::getDbo();
		foreach ($array as $k => $v) {
			$array[$k] = $db->quote($v);
		}
		
		return implode(',', $array);
	}
	
	protected function showInstallMessage($messages=array()) {
?>
<style type="text/css">
.version-history {
	margin: 0 0 2em 0;
	padding: 0;
	list-style-type: none;
}
.version-history > li {
	margin: 0 0 0.5em 0;
	padding: 0 0 0 4em;
}
.version-new,
.version-fixed,
.version-upgraded {
	float: left;
	font-size: 0.8em;
	margin-left: -4.9em;
	width: 4.5em;
	color: white;
	text-align: center;
	font-weight: bold;
	text-transform: uppercase;
	-webkit-border-radius: 4px;
	-moz-border-radius: 4px;
	border-radius: 4px;
}

.version-new {
	background: #7dc35b;
}
.version-fixed {
	background: #e9a130;
}
.version-upgraded {
	background: #61b3de;
}

.install-ok {
	background: #7dc35b;
	color: #fff;
	padding: 3px;
}

.install-not-ok {
	background: #E9452F;
	color: #fff;
	padding: 3px;
}

.install-warning {
	background: #EFBB67;
	color: #fff;
	padding: 3px;
}

#installer-left {
	float: left;
	width: 230px;
	padding: 5px;
}

#installer-right {
	float: left;
	width: 680px;
}

.com-rsform-button {
	display: inline-block;
	background: #459300 url(components/com_rsform/assets/images/bg-button-green.gif) top left repeat-x !important;
	border: 1px solid #459300 !important;
	padding: 2px;
	color: #fff !important;
	cursor: pointer;
	margin: 0;
	-webkit-border-radius: 5px;
     -moz-border-radius: 5px;
          border-radius: 5px;
}

.big-warning {
	background: #FAF0DB;
	border: solid 1px #EBC46F;
	padding: 5px;
}

.big-warning b {
	color: red;
}
</style>
	<div id="installer-left">
		<img src="components/com_rsform/assets/images/box.jpg" alt="RSForm! Pro Box" />
	</div>
	<div id="installer-right">
		<p>TCP Library ...
			<?php if ($messages['lib_tcpdf']) { ?>
			<b class="install-ok">Installed</b>
			<?php } else { ?>
			<b class="install-not-ok">Error installing! Please make sure /libraries/ and/or /libraries/tcpdf/ is writable!</b>
			<?php } ?>
		</p>
		<?php if ($messages['plugins']) { ?>
			<p class="big-warning"><b>Warning!</b> The following plugins have been temporarily disabled to prevent any errors being shown on your website. Please <a href="http://www.rsjoomla.com/downloads.html" target="_blank">download the latest versions</a> from your account and update your installation before enabling them.</p>
			<?php foreach ($messages['plugins'] as $plugin) { ?>
			<p><?php echo $this->escape($plugin->name); ?> ...
				<b class="install-<?php echo $plugin->status; ?>"><?php echo $plugin->text; ?></b>
			</p>
			<?php } ?>
		<?php } ?>
		<?php if ($messages['modules']) { ?>
			<p class="big-warning"><b>Warning!</b> The following modules have been temporarily disabled to prevent any errors being shown on your website. Please <a href="http://www.rsjoomla.com/downloads.html" target="_blank">download the latest versions</a> from your account and update your installation before enabling them.</p>
			<?php foreach ($messages['modules'] as $module) { ?>
			<p><?php echo $this->escape($module->name); ?> ...
				<b class="install-<?php echo $module->status; ?>"><?php echo $module->text; ?></b>
			</p>
			<?php } ?>
		<?php } ?>
		<ul class="version-history">
			<li><span class="version-upgraded">Upg</span> Two calendars can now be connected between each other by using the &quot;Date Modifier&quot; parameter</li>
			<li><span class="version-upgraded">Upg</span> Calendars now accept custom PHP code in the &quot;Min Date&quot; and &quot;Max Date&quot; parameter</li>
			<li><span class="version-upgraded">Upg</span> Redone calendar initialization script (cal.js)</li>
			<li><span class="version-upgraded">Upg</span> Calendars can now be accessed through Javascript: format is RSFormProCalendars[formId][calendarName]</li>
			<li><span class="version-upgraded">Upg</span> Newly created forms are using the &quot;Responsive Layout&quot; by default</li>
			<li><span class="version-upgraded">Upg</span> Small performance improvements on form validation</li>
			<li><span class="version-new">New</span> New &quot;Birthday Field&quot;</li>
			<li><span class="version-new">New</span> Scripting language in User, Admin &amp; Additional Emails and Thank You Message: {if {placeholder:value}}this text gets displayed if the placeholder has a value{/if}</li>
			<li><span class="version-new">New</span> New &quot;Validation Rule&quot;: &quot;Same Value as Other Field&quot; (ensures two fields have the same value)</li>
			<li><span class="version-new">New</span> Configurable &quot;XSS Filtering&quot; option</li>
			<li><span class="version-new">New</span> Ability to hide &quot;Form Title&quot;</li>
			<li><span class="version-new">New</span> &quot;Date Mask&quot; in the Configuration</li>
			<li><span class="version-new">New</span> New triggers for plugins: rsfp_bk_onCreateConditionOptionFields, rsfp_bk_onFormDelete, rsfp_bk_onFormCopy, rsfp_bk_onFormBackup, rsfp_bk_onFormRestoreTruncate.</li>
			<li><span class="version-fixed">Fix</span> &quot;Continue&quot; button did not inherit the Responsive Layout's design</li>
			<li><span class="version-fixed">Fix</span> When editing a submission, textareas are preferred over text inputs if there are new lines in the value</li>
			<li><span class="version-fixed">Fix</span> SQL Mappings &amp; Additional Emails were not being saved when copying a form</li>
		</ul>
		<a class="com-rsform-button" href="index.php?option=com_rsform">Start using RSForm! Pro</a>
		<a class="com-rsform-button" href="http://www.rsjoomla.com/support/documentation/view-knowledgebase/21-rsform-pro-user-guide.html" target="_blank">Read the RSForm! Pro User Guide</a>
		<a class="com-rsform-button" href="http://www.rsjoomla.com/customer-support/tickets.html" target="_blank">Get Support!</a>
	</div>
	<div style="clear: both;"></div>
		<?php
	}
}