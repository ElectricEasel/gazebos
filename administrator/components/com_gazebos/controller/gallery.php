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
 * Gallery controller class.
 */
class GazebosControllerGallery extends EEControllerForm
{
	protected $view_list = 'gallerys';
	protected $dir = '/media/com_gazebos/images/products/';

	public function save($key = null, $urlVar = null)
	{
		ini_set('memory_limit', '256M');
		$app   = JFactory::getApplication();
		$model = $this->getModel();
		$data  = $app->input->post->get('jform', array(), null);
		// $files = $app->input->files->get('jform', array(), null);

		$this->full_dir = JPATH_SITE . $this->dir . $data['product_id'] . '/';

		if (!is_dir($this->full_dir))
		{
			JFolder::create($this->full_dir, 0755);
		}

		if (!empty($_FILES['jform']))
		{
			EEImageHelper::setThumbSizes(array(
				JImage::CROP_RESIZE => array(
					'600x600',
					'300x300',
					'200x200',
					'150x150',
					'60x60'
				)
			));

			EEImageHelper::saveImages($this->full_dir, $_FILES['jform'], $data);
		}

		JRequest::setVar('jform', $data, 'post', true);

		parent::save($key, $urlVar);
	}

	protected function getRedirectToItemAppend($recordId = null, $urlVar = 'id')
	{
		$app    = JFactory::getApplication();
		$tmpl   = $app->input->get('tmpl');
		$layout = $app->input->get('layout', 'edit');
		$jform  = $app->input->get('jform', array(), null);
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
		$app   = JFactory::getApplication();
		$pk    = $app->input->getInt('id');
		$model = $this->getModel();
		$db    = $model->getDbo();
		$q     = $db->getQuery(true);

		$q
			->select('a.*')
			->from('#__gazebos_gallery AS a')
			->where('a.id = ' . $pk);

		$obj = $db->setQuery($q)->loadObject();

		if ($model->delete($pk))
		{
			$path = $this->dir . $obj->product_id . '/' . $obj->path;

			$to_delete = array(JPATH_SITE . $path);

			foreach (EEImageHelper::getImageSizes() as $method => $sizes)
			{
				foreach ($sizes as $size)
				{
					$to_delete[] = JPATH_SITE . EEImageHelper::getThumbPath($path . 'thumbs/' . $obj->path, $size);
				}
			}

			JFile::delete($to_delete);
			$result = 'success';
		}
		else
		{
			$result = 'fail';
		}

		$app->close(json_encode(array('result' => $result)));
	}

	// Handles the ajax reordering of the photos
	public function reorderphotos()
	{
		$app    = JFactory::getApplication();
		$model  = $this->getModel('Gallery');
		$order  = explode(',', $app->input->getVar('new_order'));
		$pks    = array_values($order);
		$norder = array_keys($order);
		$result = ($model->saveOrder($pks, $norder) === true) ? 'success' : 'fail';

		$app->close(json_encode(array('result' => $result)));
	}

}
