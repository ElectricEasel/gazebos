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

class Sh404sefViewConfiguration extends ShlMvcView_Base
{

	public function display($tpl = null)
	{
		// version prefix
		$this->joomlaVersionPrefix = Sh404sefHelperGeneral::getJoomlaVersionPrefix();

		$layout = $this->getLayout();

		switch ($layout)
		{
			case 'qcontrol':
				$this->_doQuickControl($this->joomlaVersionPrefix);
				break;
			default:
				$this->_doDefault($tpl);
				break;
		}
	}

	/**
	 * Ajax response handler for any configuration dialog
	 * except quick control panel
	 *
	 * @param string $tpl
	 */
	private function _doDefault($tpl)
	{
		// prepare elements of respn
		$this->assign('taskexecuted', $this->getLayout());
		$errors = $this->getError();
		$task = JRequest::getCmd('task');
		switch ($task)
		{
			case 'apply':
			// applying : dialog box not going to be closed
				if (($this->taskexecuted == 'default' || $this->taskexecuted == 'ext') && empty($errors))
				{
					// no errors, insert success messages
					$this
						->assign('message',
							'<li>' . JText::_('COM_SH404SEF_ELEMENT_SAVED') . '.</li><br /><li>' . JText::_('COM_SH404SEF_MAY_NEED_PURGE_DIALOGBOX')
								. '</li>');
				}
				else if (empty($errors))
				{
					$this->assign('message', JText::_('COM_SH404SEF_ELEMENT_SAVED'));
				}
				break;
			case 'save':
			// box is going to be close, we want to redirect so that message is displayed
				if (($this->taskexecuted == 'default' || $this->taskexecuted == 'ext') && empty($errors))
				{
					// no errors, tell user they must purge urls
					$messagecode = 'COM_SH404SEF_MAY_NEED_PURGE';
				}
				else if (empty($errors))
				{
					// no errors, but no need to purge : seo settings, security settings, etc
					$messagecode = 'COM_SH404SEF_ELEMENT_SAVED';
				}
				$this->assign('redirectTo', $this->defaultRedirectUrl);
				$this->assign('messagecode', $messagecode);
				break;
		}

		// use helper to prepare response
		$response = Sh404sefHelperGeneral::prepareAjaxResponse($this);

		// declare document mime type
		$document = JFactory::getDocument();
		$document->setMimeEncoding('text/xml');

		// output resulting text, no need for a layout file I think
		echo $response;
	}

	private function _doQuickControl($tpl)
	{
		// get configuration object
		$sefConfig = Sh404sefFactory::getConfig($reset = true);

		// push it into to the view
		$this->sefConfig = $sefConfig;

		$messages = JFactory::getApplication()->getMessageQueue();
		$noMsg = JRequest::getInt('noMsg', 0);
		$this->error = array();
		// push any message
		if (is_array($messages) && !empty($messages))
		{
			foreach ($messages as $msg)
			{
				if (!empty($msg['message']))
				{
					$msg['type'] = isset($msg['type']) ? $msg['type'] : 'info';
					if ($msg['type'] != 'error')
					{
						if (empty($noMsg))
						{
							$this->message = $msg['message'];
						}
					}
					else
					{
						$this->errors[] = $msg['message'];
					}
				}
			}
		}

		parent::display($tpl);
	}

}
