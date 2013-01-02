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

/**
 * View class for a list of Gazebos.
 */
class GazebosViewProductLines extends EEViewList
{
	protected $singleItemView = 'productline';
	protected $useUniversalViews = false;
}