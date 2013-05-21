<?php
/**
 * sh404SEF - SEO extension for Joomla!
 *
 * @author      Yannick Gaultier
 * @copyright   (c) Yannick Gaultier 2012
 * @package     sh404sef
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     4.1.0.1559
 * @date		2013-04-25
 */

// Security check to ensure this file is being included by a parent file.
defined('_JEXEC') or die('Direct Access to this location is not allowed.');

jimport('joomla.application.component.controller');

Class Sh404sefControllerDefault extends Sh404sefClassBasecontroller
{

	protected $_context = 'com_sh404sef.dashboard';

	/**
	 * Display the view
	 */
	public function display($cachable = false, $urlparams = false)
	{
		// Set the default view name in case it's missing
		$this->_setDefaults();

		// then display normally
		parent::display($cachable, $urlparams);
	}

	/**
	 * Browse through security log files
	 * and update statistics, stored in
	 * general config file for quick access
	 */
	public function updatesecstats()
	{
		// Set the default view name in case it's missing
		$this->_setDefaults();

		Sh404sefHelperSecurity::updateSecStats();

		parent::display();
	}

	/**
	 * Update statistics, based on data stored in
	 * general config file for quick access
	 */
	public function showsecstats()
	{
		// Set the default view name in case it's missing
		$this->_setDefaults();

		parent::display();
	}

	/**
	 * Show updates information, w/o actually
	 * checking for updates
	 */
	public function showupdates()
	{
		// Set the default view name in case it's missing
		$this->_setDefaults();

		parent::display();
	}

	function info()
	{
		// Set the default view name in case it's missing
		$this->_setDefaults();

		// set the layout for info display
		JRequest::setVar('layout', 'info');

		// default display
		parent::display();
	}

	private function _setDefaults()
	{
		$viewName = JRequest::getWord('view');
		if (empty($viewName))
		{
			JRequest::setVar('view', 'default');
		}
		$layout = JRequest::getWord('layout');
		if (empty($layout))
		{
			JRequest::setVar('layout', 'default');
		}
	}
}
