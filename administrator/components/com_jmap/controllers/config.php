<?php
// namespace administrator\components\com_jmap\controllers;
/**
 *
 * @package JMAP::CONFIG::administrator::components::com_jmap
 * @subpackage controllers
 * @author Joomla! Extensions Store
 * @copyright (C) 2013 - Joomla! Extensions Store
 * @license GNU/GPLv2 http://www.gnu.org/licenses/gpl-2.0.html  
 */
defined ( '_JEXEC' ) or die ( 'Restricted access' );
jimport ( 'joomla.application.component.controller' );

/**
 * Config controller responsibilities
 *
 * @package JMAP::CONFIG::administrator::components::com_jmap
 * @subpackage controllers
 * @since 1.0
 */
interface IConfigController {

	/**
	 * Save config entity
	 * @access public
	 * @return void
	 */
	public function saveEntity();
}


/**
 * Config controller concrete implementation
 *
 * @package JMAP::CONFIG::administrator::components::com_jmap
 * @subpackage controllers
 * @since 1.0
 */
class JMapControllerConfig extends JMapController implements IConfigController {

	/**
	 * Show configuration
	 * @access public
	 * @return void
	 */
	public function display($cachable = false, $urlparams = false) { 
		// Access check.
		if (!$this->allowAdmin(JRequest::getVar('option'))) {
			$this->setRedirect('index.php?option=com_jmap&task=cpanel.display', JTEXT::_('JERROR_ALERT_NOACCESS'));
			return false;
		}
		parent::display();
	}

	/**
	 * Save config entity
	 * @access public
	 * @return void
	 */
	public function saveEntity() {
		$model = $this->getModel();
		$result = $model->storeEntity();
		$msg = $result ? JText::_('SAVED_PARAMS') : JText::_ ( 'SAVE_PARAMS_ERROR' ); 
		
		$this->setRedirect( 'index.php?option=com_jmap&task=config.display', $msg);
	}
}
?>