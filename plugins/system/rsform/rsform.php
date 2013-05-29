<?php
/**
* @version 1.4.0
* @package RSform!Pro 1.4.0
* @copyright (C) 2007-2012 www.rsjoomla.com
* @license GPL, http://www.gnu.org/copyleft/gpl.html
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.plugin.plugin' );

/**
 * RSForm! Pro system plugin
 */
class plgSystemRSForm extends JPlugin
{
	/**
	 * Constructor
	 *
	 * For php4 compatibility we must not use the __constructor as a constructor for plugins
	 * because func_get_args ( void ) returns a copy of all passed arguments NOT references.
	 * This causes problems with cross-referencing necessary for the observer design pattern.
	 *
	 * @access	protected
	 * @param	object	$subject The object to observe
	 * @param 	array   $config  An array that holds the plugin configuration
	 * @since	1.0
	 */
	function plgSystemRSForm( &$subject, $config )
	{
		parent::__construct( $subject, $config );
	}
	
	function onAfterDispatch()
	{
		// Preload
		$doc = JFactory::getDocument();
		$app = JFactory::getApplication();
		if ($doc->getType() == 'html' && $app->isSite())
		{
			$doc->addStyleSheet(JURI::root(true).'/components/com_rsform/assets/calendar/calendar.css');
			$doc->addStyleSheet(JURI::root(true).'/components/com_rsform/assets/css/front.css');
		
			$doc->addScript(JURI::root(true).'/components/com_rsform/assets/js/script.js');
		}
	}
	
	function canRun()
	{
		if (class_exists('RSFormProHelper')) return true;
		
		$helper = JPATH_ADMINISTRATOR.'/components/com_rsform/helpers/rsform.php';
		if (file_exists($helper))
		{
			require_once($helper);
			return true;
		}
		
		return false;
	}
	
	function onAfterRender()
	{
		$mainframe = JFactory::getApplication();
		
		if ($mainframe->isAdmin()) return;
		$option = JRequest::getVar('option');
		$task 	= JRequest::getVar('task');
		if ($option == 'com_content' && $task == 'edit')
			return;
		
		if (!$this->canRun()) return true;
		
		$content = JResponse::getBody();
		
		if (strpos($content, '{rsform ') === false)
			return true;
		
		// expression to search for
		$pattern = '#\{rsform ([0-9]+)\}#i';
		if (preg_match_all($pattern, $content, $matches))
		{
			static $found_textarea;
			
			$lang = JFactory::getLanguage();
			$lang->load('com_rsform', JPATH_SITE);
			
			$db = JFactory::getDBO();
			$head = array('js' => array(), 'css' => array());			
			foreach ($matches[0] as $j => $match)
			{
				// within <textarea>
				$before = strtolower(reset(explode($match, $content, 2)));
				$before = preg_replace('#\s+#', ' ', $before);
				
				// we have a textarea
				if (strpos($before, '<textarea') !== false)
				{
					// find last occurrence
					$textarea = end(explode('<textarea', $before));				
					// found & no closing tag
					if (!empty($textarea) && strpos($textarea, '</textarea>') === false)
						continue;
				}
					
				$formId = $matches[1][$j];
				
				$db->setQuery("SELECT `FormId`, `FormLayout`, `ScriptDisplay`, `ErrorMessage`, `FormTitle`, `CSS`, `JS`, `CSSClass`, `CSSId`, `CSSName`, `CSSAction`, `CSSAdditionalAttributes`, `AjaxValidation`, `ThemeParams` FROM #__rsform_forms WHERE FormId='".$formId."' AND `Published`='1'");
				$form = $db->loadObject();
				if (!empty($form))
				{
					if ($form->JS)
						$head['js'][md5($form->JS)] = $form->JS;
					if ($form->CSS)
						$head['css'][md5($form->CSS)] = $form->CSS;
					if ($form->ThemeParams)
					{
						$registry = new JRegistry();
						$registry->loadString($form->ThemeParams, 'INI');
						$form->ThemeParams = $registry;
						
						if ($form->ThemeParams->get('num_css', 0) > 0)
							for ($i=0; $i<$form->ThemeParams->get('num_css'); $i++)
							{
								$css = $form->ThemeParams->get('css'.$i);
								$css = JURI::root(true).'/components/com_rsform/assets/themes/'.$form->ThemeParams->get('name').'/'.$css;
								$head['css'][md5($css)] = '<link rel="stylesheet" href="'.$css.'" type="text/css" />';
							}
						if ($form->ThemeParams->get('num_js', 0) > 0)
							for ($i=0; $i<$form->ThemeParams->get('num_js'); $i++)
							{
								$js = $form->ThemeParams->get('js'.$i);
								$js = JURI::root(true).'/components/com_rsform/assets/themes/'.$form->ThemeParams->get('name').'/'.$js;
								$head['js'][md5($js)] = '<script type="text/javascript" src="'.$js.'"></script>';
							}
					}
					
					$content = str_replace($matches[0][$j], RSFormProHelper::displayForm($formId), $content);
				}
			}
			
			if (count($head['css']))
				$content = str_replace('</head>', "\n".implode("\n", $head['css'])."\n".'</head>', $content);
			
			if (count($head['js']))
				$content = str_replace('</head>', "\n".implode("\n", $head['js'])."\n".'</head>', $content);
		}
		
		JResponse::setBody($content);
	}
}