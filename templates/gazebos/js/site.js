jQuery.noConflict();
jQuery(document).ready(function($){
	
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
	$('#product-gallery').cycle({ 
    fx:     'fade', 
    speed:  'slow',
    prev:   '#prev', 
    next:   '#next', 
    timeout: 0, 
    pager:  '#product-gallery-nav', 
    pagerAnchorBuilder: function(idx, slide) { 
        // return selector string for existing anchor 
        return '#product-gallery-nav li:eq(' + idx + ') a'; 
    } 
    });
});
