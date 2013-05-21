<?php
// no direct access
defined('_JEXEC') or die;

JFactory::getDocument()
	->addScript('//ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js')
	->addScript('/modules/mod_favorites/assets/js/favorites.js')
	->addStyleSheet('/modules/mod_favorites/assets/css/favorites.css');

JLoader::register('modFavoritesHelper', dirname(__FILE__).'/helper.php');

$items				= modFavoritesHelper::getItems();
$moduleclass_sfx	= htmlspecialchars($params->get('moduleclass_sfx'));

require JModuleHelper::getLayoutPath('mod_favorites', $params->get('layout', 'default'));
