<?php
/**
 * @version     1.0.0
 * @package     com_gazebos
 * @copyright   Copyright (C) 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Don Gilbert <don@electriceasel.com> - http://www.electriceasel.com
 */
defined('_JEXEC') or die;

class GazebosViewProduct extends EEViewItem
{
	public function display($tpl = null)
	{
		$this->form = $this->get('Form');

		parent::display($tpl);
	}

	protected function prepareDocument()
	{
		$title = !empty($this->item->seo_title) ? $this->item->seo_title : $this->item->title;

		$this->document
			->setTitle($title)
			->setDescription($this->item->seo_description)
			->addStyleSheet('/templates/gazebos/css/jquery.fancybox.css')
			->addScript('//ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js')
			->addScript('/templates/gazebos/js/jquery.cycle2.js')
			->addScript('/templates/gazebos/js/jquery.cycle2.carousel.js')
			->addScript('/templates/gazebos/js/jquery.fancybox.pack.js')
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

				$("[rel^=fancybox]").each(function () {
					var base = $(this);

					base.fancybox({
						width: 720,
						height:700,
						padding:0,
						autoSize:false
					});
				});
			});
			// ]]>');

		if ($this->getLayout() === 'form')
		{
			EEHtml::asset('quoteform.css');
			$this->document
				->addStyleSheet('/templates/gazebos/css/chosen.css')
				->addScript('/templates/gazebos/js/jquery.placeheld.min.js')
				->addScript('//ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js')
				->addScript('/templates/gazebos/js/chosen.jquery.min.js')
				->addScript('/templates/gazebos/js/site.js')
				->addScriptDeclaration('
				// <![CDATA[
				jQuery(document).ready(function ($) {
					$("input[placeholder]").placeHeld();
					
				});
				
				// ]]>
				');
		}
	}

}
