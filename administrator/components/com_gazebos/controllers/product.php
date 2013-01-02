<?php
/**
 * @version     1.0.0
 * @package     com_gazebos
 * @copyright   Copyright (C) 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Don Gilbert <don@electriceasel.com> - http://www.electriceasel.com
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controllerform');

jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');

/**
 * Product controller class.
 */
class GazebosControllerProduct extends JControllerForm
{
	public function __construct()
	{
		$this->view_list = 'products';
		parent::__construct();
	}

	public function save($key = null, $urlVar = null)
	{
		$app = JFactory::getApplication();
		$files = $app->input->files->get('jform');

		// If brochure name is set, we assume successful upload.
		if (isset($files['name']['brochure']))
		{
			die('test');
			$dest = JPATH_SITE . '/media/com_gazebos/brochures/' . JFile::makeSafe($files['name']['brochure']);

			// Add field to jform if successfull upload
			if (JFile::upload($files['tmp_name']['brochure'], $dest))
			{
				$jform = JRequest::getVar('jform', array());
				$jform['brochure'] = $data['name'];

				JRequest::setVar('jform', $jform);
			}
		}

		parent::save($key, $urlVar);
	}

}
