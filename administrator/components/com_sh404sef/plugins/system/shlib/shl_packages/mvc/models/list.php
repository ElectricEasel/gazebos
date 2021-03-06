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
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');

if(version_compare(JVERSION, '3', 'ge')) {

  Class ShlMvcModel_List extends JModelList {

    /**
     * Constructor
     *
     * @param   array  $config  An array of configuration options (name, state, dbo, table_path, ignore_request).
     *
     * @since   11.1
     */
    public function __construct($config = array())
    {

      parent::__construct( $config);

      // Set the model dbo
      if (!array_key_exists('dbo', $config))
      {
        $this->_db = ShlDbHelper::getDb();
      }

    }

  }

} else {

  jimport( 'joomla.application.component.model' );
  Class ShlMvcModel_List extends JModelList {

    /**
     * Constructor
     *
     * @param   array  $config  An array of configuration options (name, state, dbo, table_path, ignore_request).
     *
     * @since   11.1
     */
    public function __construct($config = array())
    {

      parent::__construct( $config);

      // Set the model dbo
      if (!array_key_exists('dbo', $config))
      {
        $this->_db = ShlDbHelper::getDb();
      }

    }
  }

}