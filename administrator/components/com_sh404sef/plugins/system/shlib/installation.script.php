<?php
/**
 * Shlib - Db query cache and programming library
 *
 * @author      Yannick Gaultier
 * @copyright   (c) Yannick Gaultier 2012
 * @package     shlib
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     0.2.3.353
 * @date				2013-03-02
 */

// Security check to ensure this file is being included by a parent file.
defined( '_JEXEC' ) or die;

/**
 * Installation/Uninstallation script
 *
 */

class plgSystemShlibInstallerScript {

  const MIN_JOOMLA_VERSION = '2.5.6';
  const MAX_JOOMLA_VERSION = '4';

  public function install($parent) {

    // create a db table to register extensions using shlib
    // will allow those extensions to decide whether
    // to remove or not shlib when they are uninstalled themselves
    // id, extension, min_version, max_version, refuse_versions, accept_versions
    // n, com_sh404sef, [0|1.2], [0|3.4]
    // if an extension wants to install a new version of shlib, it must first check that
    // existing extensions can accept the new one
    // When uninstalling, the extension must unregister itself from the db
    // then decide whether to uninstall shlib (only if no other extension is using it)
    $this->_updateDbStructure();

    $this->_hacks();

  }

  public function uninstall($parent) {

    $db = JFactory::getDbo();
    $db->dropTable('#__shlib_consumers' );
    $db->dropTable('#__shlib_resources' );

  }

  public function update($parent) {

    // create registration table, if it was not done upon initial install
    $this->_updateDbStructure();

    $this->_hacks();

  }

  public function preflight( $route, $installer) {

    if($route == 'install' || $route == 'update') {
      // check Joomla! version
      if(version_compare( JVERSION, self::MIN_JOOMLA_VERSION, '<') || version_compare( JVERSION, self::MAX_JOOMLA_VERSION, 'ge')) {
        JFactory::getApplication()->enqueueMessage( sprintf( 'shLib requires Joomla! version between %s and %s (you are using %s). Aborting installation', self::MIN_JOOMLA_VERSION, self::MAX_JOOMLA_VERSION, JVERSION));
        return false;
      }
    }
  }

  public function postflight($type, $parent) {

  }

  /**
   * Things that don't fit elsewhere
   */
  protected function _hacks() {

    // Josetta registration
    // First versions of Josetta used shLib, but a version prior
    // to the addition of the resource manager. Therefore when
    // installing an extension (sh404sef) using shLib on a site
    // running an old version of Josetta (pre-1.3.0), Josetta
    // does not register itself. Thus uninstalling sh404sef, in that example,
    // may result in uninstalling also shLIb, and breaking Josetta
    // so if Josetta is installed on that site, we make sure
    // there's an entry for it in the registration table
    $path = JPATH_ROOT . '/administrator/components/com_josetta/index.html';
    jimport( 'joomla.filesystem.file');
    if(JFile::exists( $path)) {
      try {
        // do we have a record?
        $db = JFactory::getDBO();
        $query = $db->getQuery( true);
        $query->select( '*')->from('#__shlib_consumers');
        $query->where( $db->quoteName('resource') . '=' . $db->quote( 'shlib'));
        $query->where( $db->quoteName('context') . '=' . $db->quote( 'com_josetta'));
        $existingRecord = $db->setQuery( $query)->loadObject();

        // if not, create one
        if(empty( $existingRecord)) {
          $query->clear();
          $query->insert( '#__shlib_consumers');
          $query->set( $db->quoteName('resource') . '=' . $db->quote( 'shlib'));
          $query->set( $db->quoteName('context') . '=' . $db->quote( 'com_josetta'));
          $db->setQuery( $query)->execute();
        }
      } catch (Exception $e) {
        if(class_exists( 'ShlSystem_Log') && method_exists( 'ShlSystem_Log', 'error')) {
          ShlSystem_Log::error( 'shlib', '%s::%s::%d: %s', __CLASS__, __METHOD__, __LINE__, $e->getMessage());
        }
        return false;
      }
    }
  }

  /**
   * Create database table needed to register/unregister
   * resource shared by several extensions
   *
   * @throws Exception
   */
  protected function _updateDbStructure() {

    $query1 = "CREATE TABLE IF NOT EXISTS `#__shlib_consumers` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `resource` varchar(50) NOT NULL DEFAULT '',
    `context` varchar(50) NOT NULL DEFAULT '',
    `min_version` varchar(20) NOT NULL DEFAULT '0',
    `max_version` varchar(20) NOT NULL DEFAULT '0',
    `refuse_versions` varchar(255) NOT NULL DEFAULT '',
    `accept_versions` varchar(255) NOT NULL DEFAULT '',
    PRIMARY KEY (`id`),
    KEY `idx_context` (`context`)
    ) DEFAULT CHARSET=utf8;";

    $query2 = "CREATE TABLE IF NOT EXISTS `#__shlib_resources` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `resource` varchar(50) NOT NULL DEFAULT '',
    `current_version` varchar(20) NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`),
    KEY `idx_resource` (`resource`)
    ) DEFAULT CHARSET=utf8;";

    // run query
    try {
      $db = JFactory::getDBO();
      $db->setQuery( $query1);
      $db->query();
      $error = $db->getErrorNum();
      if(!empty( $error)) {
        throw new Exception( $db->getErrorMsg());
      }
      $db->setQuery( $query2);
      $db->query();
      $error = $db->getErrorNum();
      if(!empty( $error)) {
        throw new Exception( $db->getErrorMsg());
      }

    } catch( Exception $e) {
      $app = JFactory::getApplication();
      $app->enqueueMessage( 'Error while creating/upgrading the database : ' . $e->getMessage()
          . '.<br />shLib will probably not operate properly. Please uninstall it, then try again after checking your database server setup. Contact us in case this happens again.');
    }
  }
}