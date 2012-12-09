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

/**
 * Gallery controller class.
 */
class GazebosControllerGallery extends JControllerForm
{

	function __construct()
	{
		$this->view_list = 'gallerys';
		parent::__construct();
	}

	public function save($key = null, $urlVar = null)
	{
		ini_set('memory_limit', '256M');
		$model = $this->getModel();
		$data  = JRequest::getVar('jform', array(), 'post', 'array');

		$this->dir = '/media/com_gazebos/gallery/products/'.$data['product_id'].'/';
		$this->full_dir = JPATH_SITE.$this->dir;

		if (!is_dir($this->full_dir))
		{
			JFolder::create($this->full_dir, 0755);
		}

		if (!empty($_FILES['jform']))
		{
			EEImageHelper::saveImages($this->full_dir, $_FILES['jform'], $data);
		}

		JRequest::setVar('jform', $data, 'post', true);

		parent::save($key, $urlVar);
	}

	protected function getRedirectToItemAppend($recordId = null, $urlVar = 'id')
	{
		$tmpl = JRequest::getCmd('tmpl');
		$layout = JRequest::getCmd('layout', 'edit');
		$jform = JRequest::getVar('jform');
		$append = '';

		// Setup redirect info.
		if ($tmpl)
		{
			$append .= '&tmpl=' . $tmpl;
		}

		if ($layout)
		{
			$append .= '&layout=' . $layout;
		}

		if ($recordId && ($tmpl != 'component'))
		{
			$append .= '&' . $urlVar . '=' . $recordId;
		}

		if (isset($jform['product_id']))
		{
			$append .= '&product_id=' . $jform['product_id'];
		}

		return $append;
	}

	// for the ajax delete function in the gallery manager
	public function delete()
	{
		$pk  = JRequest::getInt('id');
		$model = $this->getModel();
		$db  = $model->getDbo();
		$query = $db->getQuery(true);

		$query
			->select('*')
			->from('#__gazebos_gallery AS a')
			->where('a.id = '.$pk);

		$obj = $db->setQuery($query)->loadObject();

		if ($model->delete($pk))
		{
			$dir = '/media/com_gazebos/gallery/products/'.$data['product_id'].'/';
			$full_dir = JPATH_SITE.$dir;

			$to_delete = array($full_dir.$obj->path);

			foreach (EEImageHelper::getImageSizes() as $type => $sizes)
			{
				foreach ($sizes as $size)
				{
					list($width, $height) = $size;
					$prefix = str_replace('__', '_', "{$width}_{$height}_");
					$to_delete[] = $full_dir.$prefix.$obj->path;
				}
			}

			JFile::delete($to_delete);
			$result = 'success';
		}
		else
		{
			$result = 'fail';
		}

		echo json_encode(array('result' => $result));
		JFactory::getApplication()->close();
	}

	// Handles the ajax reordering of the photos
	public function reorderphotos()
	{
		$model = $this->getModel('gallery');

		$order = explode(',', JRequest::getVar('new_order'));
		$pks = array_values($order);
		$new_order = array_keys($order);
		$status = $model->saveOrder($pks, $new_order);

		if ($status === true)
		{
			$result = 'success';
		}
		else
		{
			$result = 'fail';
		}

		JFactory::getApplication()->close(json_encode(array('result' => $result)));
	}

}