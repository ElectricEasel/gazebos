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
if (!defined('_JEXEC'))
	die('Direct Access to this location is not allowed.');

?>

<div class="row-fluid">

<div id="j-sidebar-container" class="span2">
	<?php echo $this->sidebar; ?>
</div>
<div class="span10">
	<?php include($this->readmeFilename); ?>
</div>
</div>
