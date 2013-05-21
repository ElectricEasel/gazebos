<?php
/**
 * @version     1.0.0
 * @package     com_gazebos
 * @copyright   Copyright (C) 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Don Gilbert <don@electriceasel.com> - http://www.electriceasel.com
 */
defined('_JEXEC') or die;

class GazebosViewProduct extends EEViewAdminItem
{
	protected $useUniversalViews = false;

	public function prepareDocument()
	{
		$this->document
			->addStyleSheet('/administrator/components/com_gazebos/assets/js/chosen/chosen.css')
			->addScript('//ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js')
			->addScript('/administrator/components/com_gazebos/assets/js/chosen/chosen.jquery.min.js')
			->addScriptDeclaration('
			// <![CDATA[
			jQuery(document).ready(function ($) {
				$(\'select[multiple="multiple"]\').each(function () {
					$(this).chosen();
				});
			});
			
			Joomla.autoSave = function () {
				jQuery.ajax({
					url: "index.php?option=com_gazebos&task=product.apply&tmpl=component",
					type: "POST",
					data: jQuery("#product-form").serialize(),
					success: function (data) {
						console.log("autosaved");
					}
				});
			}

			// Auto save every minute.
			// setInterval(Joomla.autoSave, 6 * 1000);
			//]]>
			')
			->addStyleDeclaration('
				.tabs fieldset.adminform {
					overflow:visible
				}	
			    .adminformlist li {
			        clear: both;
			    }
			    #element-box {
			    	padding-top:0;
			    }
			    #element-box .current {
			    	background-color:#F4F4F4
			    }
			    #element-box .m,
			    #gazeboProductTabs .hiddenTab,
			    #gazeboProductTabs .filtersTab,
			    #jform_options_options-lbl,
			    #jform_features_features-lbl,
			    #jform_colors_colors-lbl,
			    #jform_roofing_roofing-lbl,
			    #jform_flooring_flooring-lbl {
			    	display:none;
			    }
			    select[multiple="multiple"]
			    {
			    	width:400px;
			    }
			    .adminformlist .chzn-container-multi li {
			    	clear:none;
			    }
			    .fieldset_options label {
			    	clear:both;
			    }
			    #jform_title.readonly {
			    	width:50%
			    }
			');
	}
}
