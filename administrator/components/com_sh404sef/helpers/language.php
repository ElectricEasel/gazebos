<?php
/**
 * sh404SEF - SEO extension for Joomla!
 *
 * @author      Yannick Gaultier
 * @copyright   (c) Yannick Gaultier 2012
 * @package     sh404sef
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     4.1.0.1559
 * @date		2013-04-25
 */

// Security check to ensure this file is being included by a parent file.
defined( '_JEXEC' ) or die;

class Sh404sefHelperLanguage {

  /**
   * Find a language family
   *
   * @param object $language a Joomla! language object
   * @return string a 2 or 3 characters language family code
   */
  public static function getFamily( $language = null) {


    if (!is_object($language)) {

      // get application db instance
      $language = JFactory::getLanguage();

    }

    $code = $language->get( 'lang');
    $bits = explode( '-', $code);
    return empty($bits[0]) ? 'en' : $bits[0];
  }

}