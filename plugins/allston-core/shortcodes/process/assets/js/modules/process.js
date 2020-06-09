(function($) {
	'use strict';
	
	var process = {};
	eltdf.modules.process = process;
	
	process.eltdfInitProcess = eltdfInitProcess;
	
	
	process.eltdfOnDocumentReady = eltdfOnDocumentReady;
	
	$(document).ready(eltdfOnDocumentReady);
	
	/*
	 All functions to be called on $(document).ready() should be in this function
	 */
	function eltdfOnDocumentReady() {
		eltdfInitProcess()
	}
	
	/**
	 * Inti process shortcode on appear
	 */
	function eltdfInitProcess() {
		var holder = $('.eltdf-process-holder');
		
		if(holder.length) {
			holder.appear(function(){
				var items = $(this).find('.eltdf-process-item');

				items.each(function(i) {
					var item = $(this);

					setTimeout(function() {
						item.addClass('eltdf-show');
					}, i * 300);
				});
			},{accX: 0, accY: eltdfGlobalVars.vars.eltdfElementAppearAmount});
		}
	}
	
})(jQuery);