<?php
// namespace administrator\components\com_jmap\controllers;
/**
 * @package JMAP::SOURCES::administrator::components::com_jmap
 * @subpackage controllers
 * @author Joomla! Extensions Store
 * @copyright (C) 2013 - Joomla! Extensions Store
 * @license GNU/GPLv2 http://www.gnu.org/licenses/gpl-2.0.html  
 */
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.controller');
jimport('joomla.html.pagination');

/**
 * Main sitemap sources controller manager
 * @package JMAP::SOURCES::administrator::components::com_jmap
 * @subpackage controllers
 * @since 1.0
 */
class JMapControllerSources extends JMapController { 
	
	/**
	 * Default listEntities
	 * 
	 * @access public
	 * @return void
	 */
	public function display($cachable = false, $urlparams = false) {
		// Set model state
		$this->setModelState('sources');
		$option = JRequest::getVar('option');

		// Get app, vars and set model state 
		$app = JFactory::getApplication();
		// Get default model
		$defaultModel = $this->getModel();
		$filter_state = $app->getUserStateFromRequest("$option.sources.filterstate", 'filter_state', '*');
		// Set model state
		$defaultModel->setState('state', $filter_state);

		// Parent construction and view display
		parent::display();
	}

	/**
	 * Edit entity
	 *
	 * @access public
	 * @return void
	 */
	public function editEntity() {
		JRequest::setVar('hidemainmenu', 1);
		$cid = JRequest::getVar('cid', array(0), 'method', 'array');
		$idEntity = (int) $cid[0];
		$user = JFactory::getUser();
		$model = $this->getModel();
		$record = $model->loadEntity($idEntity);

		$model->setState('option', JRequest::getVar('option'));

		// Check out del record
		if ($record->checked_out && $record->checked_out != $user->id) {
			$this->setRedirect('index.php?option=com_jmap&task=sources.display', JTEXT::_('CHECKEDOUT_RECORD'));
			return false;
		}

		// Access check
		if($record->id && !$this->allowEdit($model->getState('option'))) {
			$this->setRedirect('index.php?option=com_jmap&task=sources.display', JTEXT::_('JERROR_ALERT_NOACCESS'));
			return false;
		}
		
		if(!$record->id && !$this->allowAdd($model->getState('option'))) {
			$this->setRedirect('index.php?option=com_jmap&task=sources.display', JTEXT::_('JERROR_ALERT_NOACCESS'));
			return false;
		}
		
		if ($record->id) {
			$record->checkout($user->id);
		}

		$view = $this->getView();
		$view->setModel($model, true);
		$view->editEntity($record);
	}

	/**
	 * Gestisce il save dell'edit entity apply/save
	 *
	 * @access public
	 * @return void
	 */
	public function saveEntity() {
		$task = JRequest::getCmd('task', 'saveEntity');
		$option = JRequest::getVar('option');
		$regenerateQuery = JRequest::getVar('regenerate_query', false);
		//Load della  model e bind store
		$model = $this->getModel();
		$result = $model->storeEntity($regenerateQuery);
		if (!$id = $result->id) {
			$id = JRequest::getVar('id');
		}

		$msgPrefix = $result ? 'SUCCESS' : 'ERROR';
		$msgSufix = $task == 'sources.saveEntity' ? '_SAVING' : '_APPLY';
		$controllerTask = $task == 'sources.saveEntity' ? 'display' : 'editEntity&cid[]=' . $id;
		$msg = $msgPrefix . $msgSufix;

		$this->setRedirect("index.php?option=$option&task=sources.$controllerTask", JTEXT::_($msg));
	}

	/**
	 * Gestisce il cancel edit e unlock del record checked out
	 *
	 * @access public
	 * @return void
	 */
	public function cancelEntity() {
		$id = JRequest::getVar('id');
		$option = JRequest::getVar('option');
		//Load della  model e checkin before exit
		$model = $this->getModel();
		$model->cancelEntity($id);

		$this->setRedirect("index.php?option=$option&task=sources.display", JTEXT::_('CANCELED_OPERATION'));
	}

	/**
	 * Copies one or more items
	 * 
	 * @access public
	 * @return void
	 */
	public function copyEntity() {
		$cids = JRequest::getVar('cid', null, 'post', 'array');
		$option = JRequest::getVar('option');
		//Load della  model e checkin before exit
		$model = $this->getModel();
		$result = $model->copyEntity($cids);

		$msg = $result ? 'SUCCESS_DUPLICATING' : 'ERROR_DUPLICATING';

		$this->setRedirect("index.php?option=$option&task=sources.display", JTEXT::_($msg));
	}

	/**
	 * Cancella una entity dal DB
	 *
	 * @access public
	 * @return void
	 */
	public function deleteEntity() { 
		$cids = JRequest::getVar('cid', array(0), 'method', 'array');
		$option = JRequest::getVar('option');
		// Access check
		if(!$this->allowDelete($option)) {
			$this->setRedirect('index.php?option=com_jmap&task=sources.display', JTEXT::_('JERROR_ALERT_NOACCESS'));
			return false;
		}
		//Load della  model e checkin before exit
		$model = $this->getModel();
		$result = $model->deleteEntity($cids);

		$msg = $result ? 'SUCCESS_DELETE' : 'ERROR_DELETE';

		$this->setRedirect("index.php?option=$option&task=sources.display", JTEXT::_($msg));
	}

	/**
	 * Moves the order of a record
	 * 
	 * @access public
	 * @param integer The increment to reorder by
	 * @return void
	 */
	public function moveOrder() {
		// Set model state
		$this->setModelState('sources');
		// ID Entity
		$cid = JRequest::getVar('cid', array(), 'post', 'array');
		$idEntity = $cid[0];
		// Task direction
		$model = $this->getModel();
		$orderDir = $model->getState('order_dir');

		switch ($orderDir) {
		case 'desc':
			$orderUp = 1;
			$orderDown = -1;
			break;

		case 'asc':
		default:
			$orderUp = -1;
			$orderDown = 1;
			break;
		}

		$direction = $this->task == 'moveorder_up' ? $orderUp : $orderDown;
		$result = $model->changeOrder($idEntity, $direction);
		$msg = $result ? 'SUCCESS_REORDER' : 'ERROR_REORDER';

		$this->setRedirect('index.php?option=com_jmap&task=sources.display', JTEXT::_($msg));
	}

	/**
	 * Save ordering
	 *
	 * @access public
	 * @return void
	 */
	public function saveOrder() {
		$cid = JRequest::getVar('cid', array(), 'post', 'array');
		$order = JRequest::getVar('order', array(), 'post', 'array');
		JArrayHelper::toInteger($cid);
		JArrayHelper::toInteger($order);

		$model = $this->getModel();
		$result = $model->saveOrder($cid, $order);
		$msg = $result ? 'SUCCESS_REORDER' : 'ERROR_REORDER';

		$this->setRedirect('index.php?option=com_jmap&task=sources.display', JTEXT::_($msg));
	}

	/**
	 * Publishing entities
	 * 
	 * @access public
	 * @return void
	 */
	public function publishEntities() {
		// Access check
		if(!$this->allowEditState(JRequest::getVar('option'))) {
			$this->setRedirect('index.php?option=com_jmap&task=sources.display', JTEXT::_('JERROR_ALERT_NOACCESS'));
			return false;
		}
		
		$cid = JRequest::getVar('cid', array(0), 'method', 'array');
		$idEntity = (int) $cid[0];
		$model = $this->getModel();
		

		$result = $model->publishEntities($idEntity, $this->task);
		$msg = $result ? 'SUCCESS_STATE_CHANGE' : 'ERROR_STATE_CHANGE';

		$this->setRedirect('index.php?option=com_jmap&task=sources.display', JTEXT::_($msg));
	}

	/**
	 * Reset regenerate SQL raw query
	 * 
	 * @access public
	 * @return void
	 */
	public function regenerateQuery() {
		$model = $this->getModel();
		$task = JRequest::getCmd('task', 'saveEntity');
		$option = JRequest::getVar('option');
		//Load della  model e bind store
		$model = $this->getModel();
		$result = $model->regenerateRawSqlQuery();
		if (!$id = $result->id) {
			$id = JRequest::getVar('id');
		}

		$msg = $result ? 'SUCCESS_REGENERATE' : 'ERROR_REGENERATE';
		$controllerTask = 'editEntity&cid[]=' . $id;

		$this->setRedirect("index.php?option=$option&task=sources.$controllerTask", JTEXT::_($msg));
	}

	/**
	 * Class Constructor
	 * 
	 * @access public
	 * @return Object&
	 */
	public function __construct($config = array()) {
		parent::__construct($config);
		// Register Extra tasks
		$this->registerTask('moveorder_up', 'moveOrder');
		$this->registerTask('moveorder_down', 'moveOrder');
		$this->registerTask('applyEntity', 'saveEntity');
		$this->registerTask('unpublish', 'publishEntities');
		$this->registerTask('publish', 'publishEntities');
	}
}
