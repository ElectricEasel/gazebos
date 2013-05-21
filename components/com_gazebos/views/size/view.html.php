<?php
/**
 * @version     1.0.0
 * @package     com_gazebos
 * @copyright   Copyright (C) 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Don Gilbert <don@electriceasel.com> - http://www.electriceasel.com
 */
defined('_JEXEC') or die;

class GazebosViewSize extends EEViewItem
{
	public function display($tpl = null)
	{
		$this->form = $this->get('Form');

		parent::display($tpl);
	}

	protected function prepareDocument()
	{
		$this->document
			->addScript('//ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js')
			->addScript('/templates/gazebos/js/jquery.cycle2.js')
			->addScript('/templates/gazebos/js/jquery.cycle2.carousel.js')
			->addScriptDeclaration('
			// <![CDATA[
			jQuery(document).ready(function ($) {
				var slideshows = $(".cycle-slideshow").on("cycle-next cycle-prev", function (e, opts) {
					slideshows.not(this).cycle("goto", opts.currSlide);
				});

				$("#cycle2 img").click(function () {
					var index = $(this).data("slideindex");
					$("#cycle1").cycle("goto", index);
				});
			});
			// ]]>');
	}
}
