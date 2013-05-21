<?php
// no direct access
defined('_JEXEC') or die;

JLoader::register('GazebosControllerProduct', JPATH_SITE . '/components/com_gazebos/controllers/product.php');

class modFavoritesHelper
{
	public static function getItems()
	{
		$items = JFactory::getSession()->get('favorites', array(), 'products');

		foreach ($items as $key => $item)
		{
			$item->html = GazebosControllerProduct::buildHtml($key);
		}

		return $items;
	}
}