jQuery.noConflict();
jQuery(document).ready(function ($) {

	$("input[placeholder]").placeHeld();

	$(".chosen").chosen({disable_search_threshold: 8});
	$(".rsform-select-box").chosen({disable_search_threshold: 8});

	(function(){
		$(".panel").hide();
		$("ul#product-tabs li:first").addClass("active").show();
		$(".panel:first").show();
		$("ul#product-tabs li").click(function() {
		$("ul#product-tabs li").removeClass("active");
		$(this).addClass("active");
		$(".panel").hide();
			var activeTab = jQuery(this).find("a").attr("href");
			$(activeTab).fadeIn();
			return false;
		});
	})();
	
	(function(){
		$(".panel").hide();
		$("#sidebar.series .menu li:first").addClass("active").show();
		$(".panel:first").show();
		$("#sidebar.series .menu li").click(function() {
		$("#sidebar.series .menu li").removeClass("active");
		$(this).addClass("active");
		$(".panel").hide();
			var activeTab = jQuery(this).find("a").attr("href");
			$(activeTab).fadeIn();
			return false;
		});
	})();

	var advSlide = $('#slides');
	// Setup for Cycle Plugin
	if (advSlide.length > 0)
	{
	    advSlide.cycle({
	    	timeout: 0,
	    	pager: '#carousel',
	    	pagerAnchorBuilder: function () {
		    	return '';
	    	}
	    });

	    var carousel = $('#carousel');
	    var carouselImgs = carousel.find('img');

    	carouselImgs.each(function (el) {
    		$(el).click(function (e) {
    			e.preventDefault();
		        slideNum = parseInt($(el).attr('data-slide'));
		        advSlide.cycle(slideNum);
    		});
    	});

	    if (carouselImgs.length > 3)
	    {
			carousel.jcarousel({
				scroll: 1,
		        visible: 3,
		        auto:3,
		        wrap: 'circular',
		        itemFallbackDimension: 177,
		        buttonNextHTML: '<div>NEXT</div>',
		        buttonPrevHTML: '<div>PREV</div>',
		        itemVisibleInCallback: function (carousel, el, idx, state) {
		        	slideNum = parseInt($(el).attr('data-slide'));
		        	advSlide.cycle(slideNum);
		        }
		    });
		}
	}
});
