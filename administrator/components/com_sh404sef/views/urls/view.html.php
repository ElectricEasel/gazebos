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
if (!defined('_JEXEC'))
	die('Direct Access to this location is not allowed.');

jimport('joomla.application.component.view');

class Sh404sefViewUrls extends ShlMvcView_Base
{
	// we are in 'urls' view
	protected $_context = 'urls';

	public function display($tpl = null)
	{
		// version prefix
		$this->joomlaVersionPrefix = Sh404sefHelperGeneral::getJoomlaVersionPrefix();

		// get model and update context with current
		$model = $this->getModel();

		$context = $model->setContext($this->_context . '.' . $this->getLayout());

		// display type: simple for very large sites/slow slq servers
		$sefConfig = Sh404sefFactory::getConfig();

		// if set for a slowServer, display simplified version of the url manager
		$this->assign('slowServer', $sefConfig->slowServer);

		// read data from model
		$list = $model
			->getList((object) array('layout' => $this->getLayout(), 'simpleUrlList' => $this->slowServer, 'slowServer' => $sefConfig->slowServer));

		// and push it into the view for display
		$this->assign('items', $list);
		$this->assign('itemCount', count($this->items));
		$this
			->assign('pagination',
				$model
					->getPagination(
						(object) array('layout' => $this->getLayout(), 'simpleUrlList' => $this->slowServer, 'slowServer' => $sefConfig->slowServer)));
		$options = $model->getDisplayOptions();
		$this->assign('options', $options);

		if (version_compare(JVERSION, '3.0', 'ge'))
		{
			$document = JFactory::getDocument();

			// add our own css
			JHtml::styleSheet(Sh404sefHelperGeneral::getComponentUrl() . '/assets/css/' . $this->joomlaVersionPrefix . '_list.css');
			JHtml::script(Sh404sefHelperGeneral::getComponentUrl() . '/assets/js/j3.js');

			// add modal css and js
			ShlHtmlBs_helper::addBootstrapCss(JFactory::getDocument());
			ShlHtmlBs_helper::addBootstrapJs(JFactory::getDocument());

			// variable for modal, not used in 3..x+
			$params = array();

			// add display filters
			$this->_addFilters();

			// render submenu sidebar
			$this->sidebar = Sh404sefHelperHtml::renderSubmenu();
		}
		else
		{
			// add our own css
			JHtml::styleSheet(Sh404sefHelperGeneral::getComponentUrl() . '/assets/css/' . $this->joomlaVersionPrefix . '_urls.css');

			// link to  custom javascript
			JHtml::script(Sh404sefHelperGeneral::getComponentUrl() . '/assets/js/list.js');

			// add behaviors and styles as needed
			$modalSelector = 'a.modalediturl';
			$js = '\\function(){window.parent.shAlreadySqueezed = false;if(window.parent.shReloadModal) {parent.window.location=\''
				. $this->defaultRedirectUrl . '\';window.parent.shReloadModal=true}}';
			$params = array('overlayOpacity' => 0, 'classWindow' => 'sh404sef-popup', 'classOverlay' => 'sh404sef-popup', 'onClose' => $js);
			Sh404sefHelperHtml::modal($modalSelector, $params);

			$this->assign('optionsSelect', $this->_makeOptionsSelect($options));
		}

		// build the toolbar
		$toolbarMethod = '_makeToolbar' . ucfirst($this->getLayout() . ucfirst($this->joomlaVersionPrefix));
		if (is_callable(array($this, $toolbarMethod)))
		{
			$this->$toolbarMethod($params);
		}

		// now display normally
		parent::display($this->joomlaVersionPrefix);
	}

	/**
	 * Create toolbar for default layout view
	 *
	 * @param midxed $params
	 */
	private function _makeToolbarDefaultJ2($params = null)
	{

		// add title
		$title = Sh404sefHelperGeneral::makeToolbarTitle(JText::_('COM_SH404SEF_SEF_URL_LIST'), $icon = 'sh404sef', $class = 'sh404sef-toolbar-title');
		JFactory::getApplication()->JComponentTitle = $title;

		// add "New url" button
		$bar = JToolBar::getInstance('toolbar');
		$bar->addButtonPath(JPATH_COMPONENT . '/' . 'classes');
		$params['class'] = 'modalediturl';
		$params['size'] = array('x' => 800, 'y' => 600);
		$js = '\\function(){window.parent.shAlreadySqueezed = false;if(window.parent.shReloadModal) parent.window.location=\''
			. $this->defaultRedirectUrl . '\';window.parent.shReloadModal=true}';
		$params['onClose'] = $js;
		$bar->appendButton('Shpopupbutton', 'new', JText::_('New'), "index.php?option=com_sh404sef&c=editurl&task=edit&tmpl=component", $params);

		// add edit button
		$params['class'] = 'modaltoolbar';
		$params['size'] = array('x' => 800, 'y' => 600);
		unset($params['onClose']);
		$url = 'index.php?option=com_sh404sef&c=editurl&task=edit&tmpl=component';
		$bar
			->appendButton('Shpopuptoolbarbutton', 'edit', $url, JText::_('Edit'), $msg = '', $task = 'edit', $list = true, $hidemenu = true, $params);

		// add delete with duplicates button
		$params['class'] = 'modaltoolbar';
		$params['size'] = array('x' => 500, 'y' => 300);
		unset($params['onClose']);
		$url = 'index.php?option=com_sh404sef&c=editurl&task=confirmdeletedeldup&tmpl=component';
		$bar
			->appendButton('Shpopuptoolbarbutton', 'deletedeldup', $url, JText::_('COM_SH404SEF_DELETE_URLS_WITH_DUP'),
				$msg = JText::_('VALIDDELETEITEMS', true), $task = 'delete', $list = true, $hidemenu = true, $params);

		// add delete button
		$params['class'] = 'modaltoolbar';
		$params['size'] = array('x' => 500, 'y' => 300);
		unset($params['onClose']);
		$url = 'index.php?option=com_sh404sef&c=editurl&task=confirmdelete&tmpl=component';
		$bar
			->appendButton('Shpopuptoolbarbutton', 'delete', $url, JText::_('Delete'), $msg = JText::_('VALIDDELETEITEMS', true), $task = 'delete',
				$list = true, $hidemenu = true, $params);

		// separator
		JToolBarHelper::divider();

		// add import button
		$params['class'] = 'modaltoolbar';
		$params['size'] = array('x' => 500, 'y' => 380);
		unset($params['onClose']);
		$url = 'index.php?option=com_sh404sef&c=wizard&task=start&tmpl=component&optype=import&opsubject=urls';
		$bar
			->appendButton('Shpopuptoolbarbutton', 'import', $url, JText::_('COM_SH404SEF_IMPORT_BUTTON'), $msg = '', $task = 'import',
				$list = false, $hidemenu = true, $params);

		// add import button
		$params['class'] = 'modaltoolbar';
		$params['size'] = array('x' => 500, 'y' => 380);
		unset($params['onClose']);
		$url = 'index.php?option=com_sh404sef&c=wizard&task=start&tmpl=component&optype=export&opsubject=urls';
		$bar
			->appendButton('Shpopuptoolbarbutton', 'export', $url, JText::_('COM_SH404SEF_EXPORT_BUTTON'), $msg = '', $task = 'export',
				$list = false, $hidemenu = true, $params);

		// separator
		JToolBarHelper::divider();

		// add purge and purge selected  buttons
		$params['class'] = 'modaltoolbar';
		$params['size'] = array('x' => 500, 'y' => 300);
		unset($params['onClose']);
		$url = 'index.php?option=com_sh404sef&c=urls&task=confirmpurge&tmpl=component';
		$bar
			->appendButton('Shpopuptoolbarbutton', 'purge', $url, JText::_('COM_SH404SEF_PURGE'), $msg = JText::_('VALIDDELETEITEMS', true),
				$task = 'purge', $list = false, $hidemenu = true, $params);

		// separator
		JToolBarHelper::divider();

		// edit home page button
		$params['class'] = 'modalediturl';
		$params['size'] = array('x' => 800, 'y' => 600);
		$js = '\\function(){window.parent.shAlreadySqueezed = false;if(window.parent.shReloadModal) parent.window.location=\''
			. $this->defaultRedirectUrl . '\';window.parent.shReloadModal=true}';
		$params['onClose'] = $js;
		$bar
			->appendButton('Shpopupbutton', 'home', JText::_('COM_SH404SEF_HOME_PAGE_ICON'),
				"index.php?option=com_sh404sef&c=editurl&task=edit&home=1&tmpl=component", $params);

		// separator
		JToolBarHelper::divider();

	}

	/**
	 * Create toolbar for default layout view
	 *
	 * @param midxed $params
	 */
	private function _makeToolbarDefaultJ3($params = null)
	{
		// add title
		JToolbarHelper::title('sh404SEF: ' . JText::_('COM_SH404SEF_SEF_URL_LIST'), 'sh404sef-toolbar-title');

		// add "New url" button
		$bar = JToolBar::getInstance('toolbar');

		// prepare configuration button
		$bar->addButtonPath(SHLIB_ROOT_PATH . 'toolbarbutton');

		// add url
		$params = array();
		$params['size'] = Sh404sefFactory::getPConfig()->windowSizes['editurl'];
		$params['buttonClass'] = 'btn btn-small';
		$params['iconClass'] = 'icon-plus';
		$params['checkListSelection'] = false;
		$url = 'index.php?option=com_sh404sef&c=editurl&task=edit&tmpl=component';
		$bar
			->appendButton('J3popuptoolbarbutton', 'new', JText::_('JTOOLBAR_NEW'), $url, $params['size']['x'], $params['size']['y'], $top = 0,
				$left = 0, $onClose = '', $title = '', $params);

		// add edit button
		$params = array();
		$params['size'] = Sh404sefFactory::getPConfig()->windowSizes['editurl'];
		$params['buttonClass'] = 'btn btn-small btn-primary';
		$params['iconClass'] = 'icon-edit';
		$params['checkListSelection'] = true;
		$url = 'index.php?option=com_sh404sef&c=editurl&task=edit&tmpl=component';
		$bar
			->appendButton('J3popuptoolbarbutton', 'edit', JText::_('JTOOLBAR_EDIT'), $url, $params['size']['x'], $params['size']['y'], $top = 0,
				$left = 0, $onClose = '', $title = '', $params);

		// separator
		JToolBarHelper::spacer(20);

		$params = array();
		$params['size'] = Sh404sefFactory::getPConfig()->windowSizes['confirm'];
		$params['buttonClass'] = 'btn btn-small';
		$params['iconClass'] = 'icon-trash';
		$params['checkListSelection'] = true;
		$url = 'index.php?option=com_sh404sef&c=editurl&task=confirmdeletedeldup&tmpl=component';
		$bar
			->appendButton('J3popuptoolbarbutton', 'deletedeldup', JText::_('COM_SH404SEF_DELETE_URLS_WITH_DUP'), $url, $params['size']['x'],
				$params['size']['y'], $top = 0, $left = 0, $onClose = '', $title = JText::_('COM_SH404SEF_CONFIRM_TITLE'), $params);

		// add delete button
		$params = array();
		$params['size'] = Sh404sefFactory::getPConfig()->windowSizes['confirm'];
		$params['buttonClass'] = 'btn btn-small';
		$params['iconClass'] = 'icon-trash';
		$params['checkListSelection'] = true;
		$url = 'index.php?option=com_sh404sef&c=editurl&task=confirmdelete&tmpl=component';
		$bar
			->appendButton('J3popuptoolbarbutton', 'delete', JText::_('JTOOLBAR_DELETE'), $url, $params['size']['x'], $params['size']['y'], $top = 0,
				$left = 0, $onClose = '', $title = JText::_('COM_SH404SEF_CONFIRM_TITLE'), $params);

		// separator
		JToolBarHelper::spacer(20);

		$params = array();
		$params['size'] = Sh404sefFactory::getPConfig()->windowSizes['import'];
		$params['buttonClass'] = 'btn btn-small';
		$params['iconClass'] = 'icon-upload';
		$params['checkListSelection'] = false;
		$url = 'index.php?option=com_sh404sef&c=wizard&task=start&tmpl=component&optype=import&opsubject=urls';
		$bar
			->appendButton('J3popuptoolbarbutton', 'import', JText::_('COM_SH404SEF_IMPORT_BUTTON'), $url, $params['size']['x'],
				$params['size']['y'], $top = 0, $left = 0, $onClose = '', $title = JText::_('COM_SH404SEF_IMPORTING_TITLE'), $params);

		// add import button
		$params = array();
		$params['size'] = Sh404sefFactory::getPConfig()->windowSizes['export'];
		$params['buttonClass'] = 'btn btn-small';
		$params['iconClass'] = 'icon-download';
		$params['checkListSelection'] = false;
		$url = 'index.php?option=com_sh404sef&c=wizard&task=start&tmpl=component&optype=export&opsubject=urls';
		$bar
			->appendButton('J3popuptoolbarbutton', 'export', JText::_('COM_SH404SEF_EXPORT_BUTTON'), $url, $params['size']['x'],
				$params['size']['y'], $top = 0, $left = 0, $onClose = '', $title = JText::_('COM_SH404SEF_EXPORTING_TITLE'), $params);

		// separator
		JToolBarHelper::spacer(20);

		// add purge and purge selected  buttons
		$params = array();
		$params['size'] = Sh404sefFactory::getPConfig()->windowSizes['confirm'];
		$params['buttonClass'] = 'btn btn-small btn-danger';
		$params['iconClass'] = 'shl-icon-remove-sign';
		$params['checkListSelection'] = false;
		$url = 'index.php?option=com_sh404sef&c=urls&task=confirmpurge&tmpl=component';
		$bar
			->appendButton('J3popuptoolbarbutton', 'purge', JText::_('COM_SH404SEF_PURGE'), $url, $params['size']['x'], $params['size']['y'],
				$top = 0, $left = 0, $onClose = '', $title = JText::_('COM_SH404SEF_CONFIRM_TITLE'), $params);

		// separator
		JToolBarHelper::spacer(20);

		// edit home page button
		$params = array();
		$params['size'] = Sh404sefFactory::getPConfig()->windowSizes['editurl'];
		$params['buttonClass'] = 'btn btn-small';
		$params['iconClass'] = 'icon-home';
		$params['checkListSelection'] = false;
		$url = 'index.php?option=com_sh404sef&c=editurl&task=edit&home=1&tmpl=component';
		$bar
			->appendButton('J3popuptoolbarbutton', 'home', JText::_('COM_SH404SEF_HOME_PAGE_ICON'), $url, $params['size']['x'], $params['size']['y'],
				$top = 0, $left = 0, $onClose = '', $title = JText::_('COM_SH404SEF_HOME_PAGE_EDIT_TITLE'), $params);
	}

	/**
	 * Create toolbar for 404 pages template
	 *
	 * @param midxed $params
	 */
	private function _makeToolbarView404J2($params = null)
	{

		// Get the JComponent instance of JToolBar
		$bar = JToolBar::getInstance('toolbar');

		// and connect to our buttons
		$bar->addButtonPath(JPATH_COMPONENT . '/' . 'classes');

		// add title
		$title = Sh404sefHelperGeneral::makeToolbarTitle(JText::_('COM_SH404SEF_404_MANAGER'), $icon = 'sh404sef', $class = 'sh404sef-toolbar-title');
		JFactory::getApplication()->JComponentTitle = $title;

		// add edit button
		$params['class'] = 'modaltoolbar';
		$params['size'] = array('x' => 800, 'y' => 600);
		unset($params['onClose']);
		$url = 'index.php?option=com_sh404sef&c=editurl&task=edit&tmpl=component';
		$bar
			->appendButton('Shpopuptoolbarbutton', 'edit', $url, JText::_('Edit'), $msg = '', $task = 'edit', $list = true, $hidemenu = true, $params);

		// add delete button
		$params['class'] = 'modaltoolbar';
		$params['size'] = array('x' => 500, 'y' => 300);
		unset($params['onClose']);
		$url = 'index.php?option=com_sh404sef&c=editurl&task=confirmdelete404&tmpl=component';
		$bar
			->appendButton('Shpopuptoolbarbutton', 'delete', $url, JText::_('Delete'), $msg = JText::_('VALIDDELETEITEMS', true), $task = 'delete',
				$list = true, $hidemenu = true, $params);

		// separator
		JToolBarHelper::divider();

		// add import button
		$params['class'] = 'modaltoolbar';
		$params['size'] = array('x' => 500, 'y' => 380);
		unset($params['onClose']);
		$url = 'index.php?option=com_sh404sef&c=wizard&task=start&tmpl=component&optype=export&opsubject=view404';
		$bar
			->appendButton('Shpopuptoolbarbutton', 'export', $url, JText::_('Export'), $msg = '', $task = 'export', $list = false, $hidemenu = true,
				$params);

		// separator
		JToolBarHelper::divider();

		// add purge and purge selected  buttons
		$params['class'] = 'modaltoolbar';
		$params['size'] = array('x' => 500, 'y' => 300);
		unset($params['onClose']);
		$url = 'index.php?option=com_sh404sef&c=urls&task=confirmpurge404&tmpl=component';
		$bar
			->appendButton('Shpopuptoolbarbutton', 'purge', $url, JText::_('COM_SH404SEF_PURGE'), $msg = JText::_('VALIDDELETEITEMS', true),
				$task = 'purge', $list = false, $hidemenu = true, $params);

		// separator
		JToolBarHelper::divider();

	}

	/**
	 * Create toolbar for 404 pages template
	 *
	 * @param midxed $params
	 */
	private function _makeToolbarView404J3($params = null)
	{
		// separator
		JToolBarHelper::divider();

		// add title
		JToolbarHelper::title('sh404SEF: ' . JText::_('COM_SH404SEF_404_MANAGER'), 'sh404sef-toolbar-title');

		// add "New url" button
		$bar = JToolBar::getInstance('toolbar');

		// prepare configuration button
		$bar->addButtonPath(SHLIB_ROOT_PATH . 'toolbarbutton');

		// add edit button
		$params = array();
		$params['size'] = Sh404sefFactory::getPConfig()->windowSizes['editurl'];
		$params['buttonClass'] = 'btn btn-small btn-primary';
		$params['iconClass'] = 'icon-edit';
		$params['checkListSelection'] = true;
		$url = 'index.php?option=com_sh404sef&c=editurl&task=edit&tmpl=component';
		$bar
			->appendButton('J3popuptoolbarbutton', 'edit', JText::_('JTOOLBAR_EDIT'), $url, $params['size']['x'], $params['size']['y'], $top = 0,
				$left = 0, $onClose = '', $title = '', $params);

		// add delete button
		$params = array();
		$params['size'] = Sh404sefFactory::getPConfig()->windowSizes['confirm'];
		$params['buttonClass'] = 'btn btn-small';
		$params['iconClass'] = 'icon-trash';
		$params['checkListSelection'] = true;
		$url = 'index.php?option=com_sh404sef&c=editurl&task=confirmdelete404&tmpl=component';
		$bar
			->appendButton('J3popuptoolbarbutton', 'delete', JText::_('JTOOLBAR_DELETE'), $url, $params['size']['x'], $params['size']['y'], $top = 0,
				$left = 0, $onClose = '', $title = JText::_('COM_SH404SEF_CONFIRM_TITLE'), $params);

		// separator
		JToolBarHelper::spacer(20);

		// add export button
		$params = array();
		$params['size'] = Sh404sefFactory::getPConfig()->windowSizes['export'];
		$params['buttonClass'] = 'btn btn-small';
		$params['iconClass'] = 'icon-download';
		$params['checkListSelection'] = false;
		$url = 'index.php?option=com_sh404sef&c=wizard&task=start&tmpl=component&optype=export&opsubject=view404';
		$bar
			->appendButton('J3popuptoolbarbutton', 'export', JText::_('COM_SH404SEF_EXPORT_BUTTON'), $url, $params['size']['x'],
				$params['size']['y'], $top = 0, $left = 0, $onClose = '', $title = JText::_('COM_SH404SEF_EXPORTING_TITLE'), $params);

		// separator
		JToolBarHelper::spacer(20);

		// add purge buttons
		$params = array();
		$params['size'] = Sh404sefFactory::getPConfig()->windowSizes['confirm'];
		$params['buttonClass'] = 'btn btn-small btn-danger';
		$params['iconClass'] = 'shl-icon-remove-sign';
		$params['checkListSelection'] = false;
		$url = 'index.php?option=com_sh404sef&c=urls&task=confirmpurge404&tmpl=component';
		$bar
			->appendButton('J3popuptoolbarbutton', 'purge', JText::_('COM_SH404SEF_PURGE404'), $url, $params['size']['x'], $params['size']['y'],
				$top = 0, $left = 0, $onClose = '', $title = JText::_('COM_SH404SEF_CONFIRM_TITLE'), $params);
	}

	private function _makeOptionsSelect($options)
	{
		$selects = new StdClass();

		// component list
		$current = $options->filter_component;
		$name = 'filter_component';
		$selectAllTitle = JText::_('COM_SH404SEF_ALL_COMPONENTS');
		$selects->components = Sh404sefHelperHtml::buildComponentsSelectList($current, $name, $autoSubmit = true, $addSelectAll = true,
			$selectAllTitle);

		// language list
		$current = $options->filter_language;
		$name = 'filter_language';
		$selectAllTitle = JText::_('COM_SH404SEF_ALL_LANGUAGES');
		$selects->languages = Sh404sefHelperHtml::buildLanguagesSelectList($current, $name, $autoSubmit = true, $addSelectAll = true, $selectAllTitle);

		// select duplicates
		$current = $options->filter_duplicate;
		$name = 'filter_duplicate';
		$selectAllTitle = JText::_('COM_SH404SEF_ALL_DUPLICATES');
		$data = array(array('id' => Sh404sefHelperGeneral::COM_SH404SEF_ONLY_DUPLICATES, 'title' => JText::_('COM_SH404SEF_ONLY_DUPLICATES')),
			array('id' => Sh404sefHelperGeneral::COM_SH404SEF_NO_DUPLICATES, 'title' => JText::_('COM_SH404SEF_ONLY_NO_DUPLICATES')));
		$selects->filter_duplicate = Sh404sefHelperHtml::buildSelectList($data, $current, $name, $autoSubmit = true, $addSelectAll = true,
			$selectAllTitle);

		// select aliases
		$current = $options->filter_alias;
		$name = 'filter_alias';
		$selectAllTitle = JText::_('COM_SH404SEF_ALL_ALIASES');
		$data = array(array('id' => Sh404sefHelperGeneral::COM_SH404SEF_ONLY_ALIASES, 'title' => JText::_('COM_SH404SEF_ONLY_ALIASES')),
			array('id' => Sh404sefHelperGeneral::COM_SH404SEF_NO_ALIASES, 'title' => JText::_('COM_SH404SEF_ONLY_NO_ALIASES')));
		$selects->filter_alias = Sh404sefHelperHtml::buildSelectList($data, $current, $name, $autoSubmit = true, $addSelectAll = true,
			$selectAllTitle);

		// select custom
		$current = $options->filter_url_type;
		$name = 'filter_url_type';
		$selectAllTitle = JText::_('COM_SH404SEF_ALL_URL_TYPES');
		$data = array(array('id' => Sh404sefHelperGeneral::COM_SH404SEF_ONLY_CUSTOM, 'title' => JText::_('COM_SH404SEF_ONLY_CUSTOM')),
			array('id' => Sh404sefHelperGeneral::COM_SH404SEF_ONLY_AUTO, 'title' => JText::_('COM_SH404SEF_ONLY_AUTO')));
		$selects->filter_url_type = Sh404sefHelperHtml::buildSelectList($data, $current, $name, $autoSubmit = true, $addSelectAll = true,
			$selectAllTitle);

		// return set of select lists
		return $selects;
	}

	private function _addFilters()
	{
		// component selector
		JHtmlSidebar::addFilter(JText::_('COM_SH404SEF_ALL_COMPONENTS'), 'filter_component',
			JHtml::_('select.options', Sh404sefHelperGeneral::getComponentsList(), 'element', 'name', $this->options->filter_component, true));

		// language list
		JHtmlSidebar::addFilter(JText::_('COM_SH404SEF_ALL_LANGUAGES'), 'filter_language',
			JHtml::_('select.options', JHtml::_('contentlanguage.existing', $all = false, $translate = true), 'value', 'text',
				$this->options->filter_language, false));

		if (!$this->slowServer)
		{
			// select duplicates
			$data = array(array('value' => Sh404sefHelperGeneral::COM_SH404SEF_ONLY_DUPLICATES, 'text' => JText::_('COM_SH404SEF_ONLY_DUPLICATES')),
				array('value' => Sh404sefHelperGeneral::COM_SH404SEF_NO_DUPLICATES, 'text' => JText::_('COM_SH404SEF_ONLY_NO_DUPLICATES')));
			JHtmlSidebar::addFilter(JText::_('COM_SH404SEF_ALL_DUPLICATES'), 'filter_duplicate',
				JHtml::_('select.options', $data, 'value', 'text', $this->options->filter_duplicate, true));

			// select aliases
			$data = array(array('value' => Sh404sefHelperGeneral::COM_SH404SEF_ONLY_ALIASES, 'text' => JText::_('COM_SH404SEF_ONLY_ALIASES')),
				array('value' => Sh404sefHelperGeneral::COM_SH404SEF_NO_ALIASES, 'text' => JText::_('COM_SH404SEF_ONLY_NO_ALIASES')));
			JHtmlSidebar::addFilter(JText::_('COM_SH404SEF_ALL_ALIASES'), 'filter_alias',
				JHtml::_('select.options', $data, 'value', 'text', $this->options->filter_alias, true));
		}

		// select custom
		$data = array(array('value' => Sh404sefHelperGeneral::COM_SH404SEF_ONLY_CUSTOM, 'text' => JText::_('COM_SH404SEF_ONLY_CUSTOM')),
			array('value' => Sh404sefHelperGeneral::COM_SH404SEF_ONLY_AUTO, 'text' => JText::_('COM_SH404SEF_ONLY_AUTO')));
		JHtmlSidebar::addFilter(JText::_('COM_SH404SEF_ALL_URL_TYPES'), 'filter_url_type',
			JHtml::_('select.options', $data, 'value', 'text', $this->options->filter_url_type, true));
	}
}
