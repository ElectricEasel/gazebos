<?php
/**
* @version 1.4.0
* @package RSForm! Pro 1.4.0
* @copyright (C) 2007-2013 www.rsjoomla.com
* @license GPL, http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access');

class RSFormModelRSForm extends JModelLegacy
{
	protected $isJ30;
	protected $config;
	
	public function __construct() {
		parent::__construct();
		
		$jversion 	  = new JVersion();
		
		$this->config = RSFormProConfig::getInstance();
		$this->isJ30  = $jversion->isCompatible('3.0');
	}
	
	public function getCode() {
		return $this->config->get('global.register.code');
	}
	
	public function getSideBar() {
		require_once JPATH_COMPONENT.'/helpers/toolbar.php';
		
		return RSFormProToolbarHelper::render();
	}
	
	public function getButtons() {
		JFactory::getLanguage()->load('com_rsfirewall.sys', JPATH_ADMINISTRATOR);
		
		/* $button = array(
				'access', 'id', 'link', 'target', 'onclick', 'title', 'image', 'alt', 'text'
			); */
		
		$buttons = array(
			array(
				'link' => JRoute::_('index.php?option=com_rsform&view=forms'),
				'image' =>'components/com_rsform/assets/images/forms.png',
				'text' => JText::_('RSFP_MANAGE_FORMS'),
				'access' => true
			),
			array(
				'link' => JRoute::_('index.php?option=com_rsform&view=submissions'),
				'image' =>'components/com_rsform/assets/images/viewdata.png',
				'text' => JText::_('RSFP_MANAGE_SUBMISSIONS'),
				'access' => true
			),
			array(
				'link' => JRoute::_('index.php?option=com_rsform&view=backuprestore'),
				'image' =>'components/com_rsform/assets/images/backup.png',
				'text' => JText::_('RSFP_BACKUP_RESTORE'),
				'access' => true
			),
			array(
				'link' => JRoute::_('index.php?option=com_rsform&view=configuration'),
				'image' =>'components/com_rsform/assets/images/config.png',
				'text' => JText::_('RSFP_CONFIGURATION'),
				'access' => true
			),
			array(
				'link' => JRoute::_('index.php?option=com_rsform&view=updates'),
				'image' =>'components/com_rsform/assets/images/restore.png',
				'text' => JText::_('RSFP_UPDATES'),
				'access' => true
			),
			array(
				'link' => JRoute::_('index.php?option=com_rsform&task=goto.support'),
				'image' =>'components/com_rsform/assets/images/support.png',
				'text' => JText::_('RSFP_SUPPORT'),
				'access' => true
			),
			array(
				'link' => JRoute::_('index.php?option=com_rsform&task=goto.plugins'),
				'image' =>'components/com_rsform/assets/images/samples.png',
				'text' => JText::_('RSFP_PLUGINS'),
				'access' => true
			)
		);
		
		return $buttons;
	}
	
	public function getLongVersion() {
		$version = new RSFormProVersion();
		return $version->long;
	}
	
	public function getRevision() {
		$version = new RSFormProVersion();
		return $version->revision;
	}
}