<?php 
//namespace components\com_jmap\controllers; 
/** 
 * @package JMAP::AJAXSERVER::components::com_jmap 
 * @subpackage controllers
 * @author Joomla! Extensions Store
 * @copyright (C)2013 Joomla! Extensions Store
 * @license GNU/GPLv2 http://www.gnu.org/licenses/gpl-2.0.html  
 */
defined ( '_JEXEC' ) or die ( 'Restricted access' );
jimport ( 'joomla.application.component.controller' );

/** 
 * Classe che gestisce la logica dei tasks API ENDPOINT
 * @package JMAP::AJAXSERVER::components::com_jmap  
 * @subpackage controllers
 * @since 1.0
 */  
class JMapControllerAjaxserver extends JMapController { 
	/**
	 * L'entity nell'SMVC Model qui è la HTTP request
	 * @access public
	 * @return void 
	 */
	public function display($cachable = false, $urlparams = false) { 
		// Id entità risposta ajax che identifica il subtask da eseguire in questo caso
		$params = json_decode(JRequest::getVar('data', null));
		
		// Load models addizionali in Dependency injection da JS controls
		$DIModels = @$params->DIModels;
		$models = array();
		if(is_object($DIModels)) {
			foreach ($DIModels as $modelName=>$side) {
				$models[$modelName] = &$this->getModel ($modelName);
			} 
		}
		//Model per get risposta ajax - mappa la Remote Procedure Call
		$model = &$this->getModel ();
		$userData = &$model->loadEntity ($params->id, $params->param, $models);
		
	 	//Formattazione risposta ajax e stdout, qui la view riveste il ruolo di data HTTP response presentation format
		$view = $this->getView ();
		$view->display ($userData);
	} 
}