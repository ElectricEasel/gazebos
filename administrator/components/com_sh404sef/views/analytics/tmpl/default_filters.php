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

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');

?>
  	<tr>
       <td>
         <?php 
           if (!empty( $this->analytics->filters)) {
             foreach( $this->analytics->filters as $filter) {
               echo $filter;
             }
           }
         ?>
       </td>
    </tr>
    
