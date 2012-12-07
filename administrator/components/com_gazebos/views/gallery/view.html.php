<?php defined('_JEXEC') or die;

class GazebosViewGallery extends EEView
{
	protected $useUniversalViews = false;

	protected function getGallery()
	{
		$id		= JRequest::getInt('product_id');
		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);

		$query
			->select('a.*')
			->from('#__gazebos_gallery AS a')
			->leftJoin('#__gazebos_products AS b ON a.product_id = b.id')
			->where('b.id = '. $id)
			->order('ordering ASC');

		return $db->setQuery($query)->loadObjectList();
	}
}
