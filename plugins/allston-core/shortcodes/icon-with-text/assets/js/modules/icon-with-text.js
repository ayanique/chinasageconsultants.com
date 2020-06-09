(function($) {
	'use strict';
	
	var iconWithText = {};
	eltdf.modules.iconWithText = iconWithText;
	
	iconWithText.eltdfIconWithTextSVG = eltdfIconWithTextSVG;
	iconWithText.eltdfOnDocumentReady = eltdfOnDocumentReady;
	
	$(document).ready(eltdfOnDocumentReady);

	/*
	 All functions to be called on $(document).ready() should be in this function
	 */
	function eltdfOnDocumentReady() {
		eltdfIconWithTextSVG();
	}
	
    /*
    * Init SVG animation
    */
    function eltdfIconWithTextSVG() {
    	var items = $('.eltdf-svg-icon-holder > svg');

    	if (items.length) {
    		items.each(function() {
    			var item = $(this),
    				duration = typeof item.parent().data('svg-animation-duration') !== 'undefined' ? parseInt(item.parent().data('svg-animation-duration')) : 800,
    				delay = typeof item.parent().data('svg-animation-delay') !== 'undefined' ? parseInt(item.parent().data('svg-animation-delay')) : 0;

    			item
	    			.drawsvg({
				      	duration: duration,
				      	stagger: 250,
				      	easing: 'easeOutQuint'
				    })
				    .appear(function() {
		    			setTimeout(function(){
			    			item.parent().addClass('eltdf-svg-visible');
				    		item.drawsvg('animate');
		    			}, delay);
		    		});
    		});
    	}
    }
	
})(jQuery);