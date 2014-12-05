
var bp = Array(960,600,480,1)
$.fn.respimg = function() {
	var ww = $(window).width();
	img = $(this)
	$(bp).each(function(key, val) {
		if(ww > val) {
		    	img.each(function() {
		    		MinSizeSrc = $(this).attr("data-min"+val);
		    		dataActive = $(this).attr("data-active");
		    		if(MinSizeSrc && (dataActive>ww || dataActive < val)) {
		    			$(this).attr("src", MinSizeSrc);
		    			$(this).attr("data-active", val);
		    		}	    		
		    	});
		}
	})  
};
$(document).ready(function() {
	$(".responsiveimg").respimg();
	    
    $(window).resize(function() {
        clearTimeout($.data(this, "resizeTimer"));
        
        $.data(this, "resizeTimer", setTimeout(function() {
            $(".responsiveimg").respimg();
        }, 100));
    });
});