<?php
/**
 * sh404SEF - SEO extension for Joomla!
 *
 * @author      Yannick Gaultier
 * @copyright   (c) Yannick Gaultier 2012
 * @package     sh404sef
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     3.7.0.1485
 * @date		2012-11-26
 */
defined('_JEXEC') or die;

// ------------------  standard plugin initialize function - don't change ---------------------------
global $sh_LANG;
$sefConfig = & Sh404sefFactory::getConfig();
$shLangName = '';
$shLangIso = '';
$title = array();
$shItemidString = '';
$dosef = shInitializePlugin( $lang, $shLangName, $shLangIso, $option);
if ($dosef == false) return;
// ------------------  standard plugin initialize function - don't change ---------------------------

// ------------------  load language file - adjust as needed ----------------------------------------
$shLangIso = shLoadPluginLanguage( 'com_content', $shLangIso, 'COM_SH404SEF_CREATE_NEW');
// ------------------  load language file - adjust as needed ----------------------------------------

// get DB
//$database =ShlDbHelper::getDb();

// 1.2.4.q this is content item, so let's try to improve missing Itemid handling
// retrieve section id to know whether this static or not
$shHomePageFlag = false;

$shHomePageFlag = !$shHomePageFlag ? shIsHomepage ($string): $shHomePageFlag;

if (!$shHomePageFlag) {  // we may have found that this is homepage, so we msut return an empty string
  // do something about that Itemid thing
  if (!preg_match( '/Itemid=[0-9]+/iu', $string)) { // if no Itemid in non-sef URL
    // V 1.2.4.t moved back here
    if ($sefConfig->shInsertGlobalItemidIfNone && !empty($shCurrentItemid)) {
      $string .= '&Itemid='.$shCurrentItemid; ;  // append current Itemid
      $Itemid = $shCurrentItemid;
      shAddToGETVarsList('Itemid', $Itemid); // V 1.2.4.m
    }

    if ($sefConfig->shInsertTitleIfNoItemid)
    $title[] = $sefConfig->shDefaultMenuItemName ?
  		$sefConfig->shDefaultMenuItemName : getMenuTitle($option, (isset($view) ? $view : null), $shCurrentItemid, null, $shLangName );  // V 1.2.4.q added forced language
  		$shItemidString = '';
  		if ($sefConfig->shAlwaysInsertItemid && (!empty($Itemid) || !empty($shCurrentItemid)))
    $shItemidString = JText::_('COM_SH404SEF_ALWAYS_INSERT_ITEMID_PREFIX').$sefConfig->replacement
    .(empty($Itemid)? $shCurrentItemid :$Itemid);
  } else {  // if Itemid in non-sef URL
    $shItemidString = $sefConfig->shAlwaysInsertItemid ?
    JText::_('COM_SH404SEF_ALWAYS_INSERT_ITEMID_PREFIX').$sefConfig->replacement.$Itemid
    : '';
    if ($sefConfig->shAlwaysInsertMenuTitle){
      //global $Itemid; V 1.2.4.g we want the string option, not current page !
      if ($sefConfig->shDefaultMenuItemName)
      $title[] = $sefConfig->shDefaultMenuItemName;// V 1.2.4.q added force language
      elseif ($menuTitle = getMenuTitle($option, (isset($view) ? $view : null), $Itemid, '',$shLangName )) {
        if ($menuTitle != '/') $title[] = $menuTitle;
      }
    }
  }
  // V 1.2.4.m
  shRemoveFromGETVarsList('option');
  shRemoveFromGETVarsList('lang');
  if (!empty($Itemid))
  shRemoveFromGETVarsList('Itemid');
  if (!empty($limit))
  shRemoveFromGETVarsList('limit');
  if (isset($limitstart))
  shRemoveFromGETVarsList('limitstart');
  if (isset($material_id))
  shRemoveFromGETVarsList('material_id');

  $view = isset($view) ? $view : null;
  $layout = isset($layout) ? $layout : null;
  $task = isset($task) ? $task : null;
  $material_id = isset($material_id) ? $material_id : null;


// THIS IS WHERE THE FUN STUFF BEGINS
switch ($view)
{
	case '':
		$title[] = 'series-quote-form';
		break;
	case 'gallery':
		$title[] = 'gallery';
		break;
	case 'type':
		$q = 'SELECT a.alias AS type' .
			' FROM #__gazebos_types AS a' .
			' WHERE a.id = ' . (int) $id;

		$r = JFactory::getDbo()->setQuery($q)->loadObject();

		$title[] = strtolower(JFilterOutput::stringUrlSafe($r->type));
		break;
	case 'material':
		$q = 'SELECT a.alias AS material, b.alias AS type' .
			' FROM #__gazebos_materials AS a' .
			' LEFT JOIN #__gazebos_types AS b ON b.id = a.type_id' .
			' WHERE a.id = ' . (int) $id;

		$r = JFactory::getDbo()->setQuery($q)->loadObject();

		$title[] = strtolower(JFilterOutput::stringUrlSafe($r->type));
		$title[] = strtolower(JFilterOutput::stringUrlSafe($r->material));
		break;
	case 'shape':
		$q = 'SELECT a.alias AS shape, b.alias AS type, c.alias AS material' .
			' FROM #__gazebos_shapes AS a' .
			' LEFT JOIN #__gazebos_types AS b ON b.id = a.type_id' .
			' LEFT JOIN #__gazebos_materials AS c ON c.type_id = b.id' .
			' WHERE a.id = ' . (int) $id .
			' AND c.id = ' . (int) $material_id;

		$r = JFactory::getDbo()->setQuery($q)->loadObject();

		$title[] = strtolower(JFilterOutput::stringUrlSafe($r->type));
		$title[] = strtolower(JFilterOutput::stringUrlSafe($r->material));
		$title[] = strtolower(JFilterOutput::stringUrlSafe($r->shape));
		break;
	case 'product':
		$q = 'SELECT a.alias AS product, b.alias AS material, c.alias AS shape, d.alias AS type, e.alias AS style' .
			' FROM #__gazebos_products AS a' .
			' LEFT JOIN #__gazebos_materials AS b ON b.id = a.material_id' .
			' LEFT JOIN #__gazebos_shapes AS c ON c.id = a.shape_id' .
			' LEFT JOIN #__gazebos_types AS d ON d.id = a.type_id' .
			' LEFT JOIN #__gazebos_styles AS e ON e.id = a.style_id' .
			' WHERE a.id = ' . (int) $id;

		$r = JFactory::getDbo()->setQuery($q)->loadObject();

		$title[] = strtolower(JFilterOutput::stringUrlSafe($r->type));
		$title[] = strtolower(JFilterOutput::stringUrlSafe($r->material));
		$title[] = strtolower(JFilterOutput::stringUrlSafe($r->shape));
		$title[] = strtolower(JFilterOutput::stringUrlSafe($r->style));

		if ($layout !== 'default')
		{
			$title[] = strtolower($layout);
		}
		break;
	case 'size':
		$q = 'SELECT' .
			' a.alias AS size,' .
			' b.alias AS product,' .
			' c.alias AS material,' .
			' d.alias AS shape,' .
			' e.alias AS type,' .
			' f.alias AS style' .
			' FROM #__gazebos_sizes AS a' .
			' LEFT JOIN #__gazebos_products AS b ON b.id = a.product_id' .
			' LEFT JOIN #__gazebos_materials AS c ON c.id = b.material_id' .
			' LEFT JOIN #__gazebos_shapes AS d ON d.id = b.shape_id' .
			' LEFT JOIN #__gazebos_types AS e ON e.id = b.type_id' .
			' LEFT JOIN #__gazebos_styles AS f ON f.id = b.style_id' .
			' WHERE a.id = ' . (int) $id;

		$r = JFactory::getDbo()->setQuery($q)->loadObject();

		$title[] = strtolower(JFilterOutput::stringUrlSafe($r->type));
		$title[] = strtolower(JFilterOutput::stringUrlSafe($r->material));
		$title[] = strtolower(JFilterOutput::stringUrlSafe($r->shape));
		$title[] = strtolower(JFilterOutput::stringUrlSafe($r->style));
		$title[] = strtolower(JFilterOutput::stringUrlSafe($r->size));

		if ($layout !== 'default')
		{
			$title[] = strtolower($layout);
		}
		break;
	default:
		$dosef = false;
		break;
}

if (strpos($task, '.submit') !== false)
{
	$dosef = false;
}

  // V 1.2.4.q
  shRemoveFromGETVarsList('view');
  if (isset($id))
  shRemoveFromGETVarsList('id');
  if (isset($layout))
  shRemoveFromGETVarsList('layout');
  // only remove format variable if forma tis html. In all other situations, leave it there as some
  // system plugins may cause pdf and rss to break if they call JFactory::getDocument() in the onAfterInitialize event handler
  // because at this time SEF url are not decoded yet.
  if (isset($format) && (!sh404SEF_PROTECT_AGAINST_DOCUMENT_TYPE_ERROR || (sh404SEF_PROTECT_AGAINST_DOCUMENT_TYPE_ERROR && $format == 'html')))
  shRemoveFromGETVarsList('format');
  if (isset($type))
  shRemoveFromGETVarsList('type');
  if (!empty($catid))
  shRemoveFromGETVarsList('catid');   // V 1.2.4.m
  if (isset($showall))
  shRemoveFromGETVarsList('showall');
  if (empty($page))  // remove page if not set or 0
  shRemoveFromGETVarsList('page');
  if (isset($print))
  shRemoveFromGETVarsList('print');
  if (isset($tmpl) && $tmpl == 'component')   // remove if 'component', show otherwise as querystring
  shRemoveFromGETVarsList('tmpl');

  // ------------------  standard plugin finalize function - don't change ---------------------------
  if ($dosef){
    $string = shFinalizePlugin( $string, $title, $shAppendString, $shItemidString,
    (isset($limit) ? $limit : null), (isset($limitstart) ? $limitstart : null),
    (isset($shLangName) ? $shLangName : null), (isset($showall) ? $showall : null));
  }
  // ------------------  standard plugin finalize function - don't change ---------------------------
} else { // this is multipage homepage
  $title[] = '/';
  $string = sef_404::sefGetLocation( $string, $title, null, (isset($limit) ? $limit : null),
  (isset($limitstart) ? $limitstart : null), (isset($shLangName) ? $shLangName : null),
  (isset($showall) ? $showall : null));
}
