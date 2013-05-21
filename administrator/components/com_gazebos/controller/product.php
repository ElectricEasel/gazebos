<?php
/**
 * @version     1.0.0
 * @package     com_gazebos
 * @copyright   Copyright (C) 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Don Gilbert <don@electriceasel.com> - http://www.electriceasel.com
 */
defined('_JEXEC') or die;

jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');

/**
 * Product controller class.
 */
class GazebosControllerProduct extends EEControllerForm
{
	protected $view_list = 'products';

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
				$jform = $app->input->get('jform', array(), null);
				$jform['brochure'] = $data['name'];

				JRequest::setVar('jform', $jform);
			}
		}

		parent::save($key, $urlVar);
	}

	protected function getRedirectToItemAppend($recordId = null, $urlVar = 'id')
	{
		$append = parent::getRedirectToItemAppend($recordId, $urlVar);

		$jform = JRequest::getVar('jform');

		if (isset($jform['type_id']))
		{
			$append .= '&type_id=' . $jform['type_id'];
		}

		return $append;
	}

}
