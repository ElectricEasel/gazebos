<?php
/**
 * @version     1.0.0
 * @package     com_gazebos
 * @copyright   Copyright (C) 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Don Gilbert <don@electriceasel.com> - http://www.electriceasel.com
 */
defined('_JEXEC') or die;

class GazebosTableSize extends EETable
{
	protected $_tbl = '#__gazebos_sizes';

	public function bind($array, $ignore = '')
	{
		$array['alias'] = EEHelper::buildAlias($array['size']);

		return parent::bind($array, $ignore);
	}
}
