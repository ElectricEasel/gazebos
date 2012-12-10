<?php
/**
 * @package		Gazebos.Modules
 * @subpackage	mod_product_search
 * @copyright	Copyright (C) 2012 Electric Easel, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

// Include the syndicate functions only once
require_once dirname(__FILE__).'/helper.php';

JHtml::script('//ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js');
EEHtml::asset('form.js', 'mod_product_search');

require JModuleHelper::getLayoutPath('mod_product_search', $params->get('layout', 'default'));
