<?php 
/** 
 * @package JMAP::CPANEL::administrator::components::com_jmap
 * @subpackage views
 * @subpackage cpanel
 * @subpackage tmpl
 * @author Joomla! Extensions Store
 * @copyright (C) 2013 - Joomla! Extensions Store
 * @license GNU/GPLv2 http://www.gnu.org/licenses/gpl-2.0.html  
 */
defined ( '_JEXEC' ) or die ( 'Restricted access' ); 
?>
<div id="accordion_suggestions">
	<?php foreach ($this->images as $imageName=>$imagePath): ?>
		<h3><?php echo $imageName?></h3>
		<div><img style="width: 730px;" src="<?php echo $imagePath;?>" alt="suggestion"/></div>
	<?php endforeach; ?>
</div>