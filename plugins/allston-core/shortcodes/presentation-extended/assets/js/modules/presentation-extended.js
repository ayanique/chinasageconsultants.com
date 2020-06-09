(function($) {
	'use strict';
	
	var presentationExtended = {};
	eltdf.modules.presentationExtended = presentationExtended;
	
	presentationExtended.eltdfInitPresentationExtended = eltdfInitPresentationExtended;
	presentationExtended.eltdfOnWindowLoad = eltdfOnWindowLoad;
	
	$(window).load(eltdfOnWindowLoad);
	
	/*
	 All functions to be called on $(window).load() should be in this function
	 */
	function eltdfOnWindowLoad() {
		eltdfInitPresentationExtended();
	}
	
	/**
	 * Inti presentation extended shortcode on appear
	 */
	function eltdfInitPresentationExtended() {
		var items = $('.eltdf-pe-slider-uncover');
		
		if(items.length) {
			items.appear(function(){
				$(this).addClass('eltdf-uncovered');
			},{accX: 0, accY: eltdfGlobalVars.vars.eltdfElementAppearAmount});
		}
	}
	
})(jQuery);