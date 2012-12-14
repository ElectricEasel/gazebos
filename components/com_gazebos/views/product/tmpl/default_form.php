<?php
/**
* @version     1.0.0
* @package     com_gazebos
* @copyright   Copyright (C) 2012. All rights reserved.
* @license     GNU General Public License version 2 or later; see LICENSE.txt
* @author      Don Gilbert <don@electriceasel.com> - http://www.electriceasel.com
*/

// no direct access
defined('_JEXEC') or die;
?>
		<h2>Get A Quote</h2>
 		<p><em>Fill out the form below and one of our representatives will contact you to discuss your gazebo options and provide you with a detailed quote.</em></p>
 		<form id="quote-form" action="" method="post">
 			<div class="field-contain">
 				<label for="q-fname">First Name</label>
 				<input type="text" id="q-fname"/>
 			</div>
 			<div class="field-contain">
 				<label for="q-lname">Last Name</label>
 				<input type="text" id="q-lname"/>
 			</div>
 			<div class="field-contain">
 				<label for="q-email">Email Address</label>
 				<input type="text" id="q-email"/>
 			</div>
 			<div class="field-contain">
 				<label for="q-phone">Phone Number</label>
 				<input type="text" id="q-phone"/>
 			</div>
 			
 			<h3><?php echo $this->item->title; ?> Options</h3>
 			
 			<div class="field-contain">
 				<label>Gazebo Size</label>
 				<select>
 					<option id="">Option 1</option>
 					<option id="">Option 2</option>
 					<option id="">Option 3</option>
 				</select>
 			</div>
 			<div class="field-contain">
 				<label>Roof Type</label>
 				<select>
 					<option id="">Option 1</option>
 					<option id="">Option 2</option>
 					<option id="">Option 3</option>
 				</select>
 			</div>
 			<div class="field-contain last">
 				<label>Gazebo Size</label>
 				<select>
 					<option id="">Option 1</option>
 					<option id="">Option 2</option>
 					<option id="">Option 3</option>
 				</select>
 			</div>
 			<br class="clear"/>
 			<div class="field-contain">
 				<span>Screen Package</span>
 				<input type="radio" name="screen" value="yes" /><label>yes</label>
 				<input type="radio" name="screen" value="no" /><label>no</label>
 			</div>
 			<div class="field-contain">
 				<span>Window Package</span>
 				<input type="radio" name="window" value="yes" /><label>yes</label>
 				<input type="radio" name="window" value="no" /><label>no</label>
 			</div>
 			<div class="field-contain last">
 				<span>Electrical Package</span>
 				<input type="radio" name="electrical" value="yes" /><label>yes</label>
 				<input type="radio" name="electrical" value="no" /><label>no</label>
 			</div>
 			
 			<input type="submit" class="green-button" value="Submit Request &gt;"/>
 		</form>