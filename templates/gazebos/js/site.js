jQuery.noConflict();
jQuery(document).ready(function ($) {
	
	$(".panel").hide();
	$("ul#tabs li:first").addClass("active").show();
	$(".panel:first").show();
	$("ul#tabs li").click(function() {
	$("ul#tabs li").removeClass("active");
	$(this).addClass("active");
	$(".panel").hide();
		var activeTab = jQuery(this).find("a").attr("href");
		$(activeTab).fadeIn();
		return false;
	});

	var advSlide = $('#slides');
	// Setup for Cycle Plugin
    advSlide.cycle({
    	timeout: 0,
    	pager: '#carousel',
    	pagerAnchorBuilder: function () {
	    	return '';
    	}
    });

	$('#carousel').jcarousel({
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

});
