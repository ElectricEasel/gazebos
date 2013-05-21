<?php

/**
 * @version     1.0.0
 * @package     com_gazebos
 * @copyright   Copyright (C) 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Don Gilbert <don@electriceasel.com> - http://www.electriceasel.com
 */
defined('_JEXEC') or die;

class GazebosTableShape extends EETable
{
	protected $_tbl = '#__gazebos_shapes';

	public function bind($array, $ignore = '')
	{
		if (isset($array['sizes']) && is_array($array['sizes']))
		{
			foreach ($array['sizes'] as $key => $value)
			{
				if (empty($value))
				{
					unset($array['sizes'][$key]);
				}
			}

			$array['sizes'] = (string) new JRegistry($array['sizes']);
		}

		return parent::bind($array, $ignore);
	}
}
