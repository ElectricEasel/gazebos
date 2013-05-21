<?php
/**
 * @version     1.0.0
 * @package     com_gazebos
 * @copyright   Copyright (C) 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Don Gilbert <don@electriceasel.com> - http://www.electriceasel.com
 */
defined('_JEXEC') or die;

class GazebosControllerProduct extends GazebosController
{
	/**
	 * Handle the form submission
	 *
	 */
	public function submit()
	{
		$app = JFactory::getApplication();
		$jform = $app->input->get('jform', array(), null);

		parent::submitForm('Product');
		
		$this->setRedirect('index.php?option=com_gazebos&view=product&layout=form&tmpl=component&id=' . $jform['product_id']);
	}

	public static function addFavorite()
	{
		$app  = JFactory::getApplication();
		$sess = JFactory::getSession();
		$id   = JRequest::getVar('id');
		$favs = (array) $sess->get('favorites', array(), 'products');
		$type = 'fail';
		$html = null;
		
		if (!isset($favs[$id]))
		{
			$type = 'success';
			$tmp  =  new stdClass();
			$tmp->id= $id;

			$favs[$id]	= $tmp;

			$sess->set('favorites', $favs, 'products');

			$html = self::buildHtml($id);
		}
		
		$app->close(json_encode(array('type' => $type, 'html' => $html)));
	}
	
	public static function delFavorite()
	{
		$app  = JFactory::getApplication();
		$sess = JFactory::getSession();
		$id   = $app->input->getInt('id');
		$favs = (array) $sess->get('favorites', array(), 'products');

		if(isset($favs[$id])) unset($favs[$id]);

		$sess->set('favorites', $favs, 'products');

		$app->close(json_encode(array('type' => 'success', 'id' => $id)));
	}
	
	public static function buildHtml($id = null)
	{
		$app = JFactory::getApplication();
		$db = JFactory::getDbo();
		
		if ($id === null)
		{
			$id	= $app->input->getInt('id');
		}

		$q = 'SELECT a.*, (SELECT b.path FROM #__gazebos_gallery AS b WHERE b.product_id = a.id' .
			' ORDER BY b.ordering ASC LIMIT 1) AS image FROM #__gazebos_products AS a WHERE a.id = ' . $id;
		
		$item = $db->setQuery($q)->loadObject();
		
		$html = array();

		if ($item !== null)
		{
			$link = JRoute::_('index.php?option=com_gazebos&view=product&id=' . $item->id);

			$html[] = '<div class="favorite">';
			$html[] = '<a href="' . $link . '">';
			$html[] = EEHtml::asset("products/{$item->id}/thumbs/60x60_{$item->image}", 'com_gazebos');
			$html[] = '</a><div class="info"><a class="fav_title" href="' . $link . '">';
			$html[] = $item->title;
			$html[] = '</a><a class="rm_fav" href="javascript:void(0);" id="remove-';
			$html[] = $item->id;
			$html[] = '">remove</a></div><div class="clear"></div></div>';
		}

		return implode($html);
	}
}
