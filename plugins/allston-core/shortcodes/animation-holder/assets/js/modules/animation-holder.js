(function($) {
	'use strict';
	
	var animationHolder = {};
	eltdf.modules.animationHolder = animationHolder;
	
	animationHolder.eltdfInitAppearAnimations = eltdfInitAppearAnimations;
	animationHolder.eltdfOnDocumentReady = eltdfOnDocumentReady;
	
	$(document).ready(eltdfOnDocumentReady);
	
	/*
	 All functions to be called on $(document).ready() should be in this function
	 */
	function eltdfOnDocumentReady() {
		eltdfInitAppearAnimations();
	}
	
	/*
	 *	Init animation holder shortcode
	 */
	function eltdfInitAppearAnimations(){
		var elements = $('.eltdf-grow-in, .eltdf-fade-in-down, \
						.eltdf-element-from-fade, .eltdf-element-from-left, \
						.eltdf-element-from-right, .eltdf-element-from-top, \
						.eltdf-element-from-bottom, .eltdf-flip-in, \
						.eltdf-x-rotate, .eltdf-z-rotate, \
						.eltdf-y-translate, .eltdf-fade-in, .eltdf-fade-in-left-x-rotate');
		
		if(elements.length){
			var show = function() {
				elements.appear(function() {
					var element = $(this),
						animationData = element.data('animation'),
						animationDelay = parseInt(element.data('animation-delay'));
					
					if(typeof animationData !== 'undefined') {
						var newClass = animationData+'-on';
						
						setTimeout(function(){
							element.addClass(newClass);
						}, animationDelay);
					}
				},{accX: 0, accY: eltdfGlobalVars.vars.eltdfElementAppearAmount});
			}

			//init
			if ($('.eltdf-loader-title-spinner').length) {
				$(document).on('eltdfLoaderRemoved', function() {
					show();
				});
			} else {
				show();
			}
		}
	}
	
})(jQuery);