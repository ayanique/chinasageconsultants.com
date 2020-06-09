(function($) {
	'use strict';
	
	var progressBar = {};
	eltdf.modules.progressBar = progressBar;
	
	progressBar.eltdfInitProgressBars = eltdfInitProgressBars;
	
	
	progressBar.eltdfOnDocumentReady = eltdfOnDocumentReady;
	
	$(document).ready(eltdfOnDocumentReady);
	
	/*
	 All functions to be called on $(document).ready() should be in this function
	 */
	function eltdfOnDocumentReady() {
		eltdfInitProgressBars();
	}
	
	/*
	 **	Horizontal progress bars shortcode
	 */
	function eltdfInitProgressBars(){
		var progressBar = $('.eltdf-progress-bar');
		
		if(progressBar.length){
			progressBar.each(function() {
				var thisBar = $(this),
					thisBarContent = thisBar.find('.eltdf-pb-content'),
					percentage = thisBarContent.data('percentage');
				
				thisBar.appear(function() {
					eltdfInitToCounterProgressBar(thisBar, percentage);
					
					thisBarContent.css('width', '0%');
					thisBarContent.animate({'width': percentage+'%'}, 2000);
				});
			});
		}
	}
	
	/*
	 **	Counter for horizontal progress bars percent from zero to defined percent
	 */
	function eltdfInitToCounterProgressBar(progressBar, $percentage){
		var percentage = parseFloat($percentage),
			percent = progressBar.find('.eltdf-pb-percent');
		
		if(percent.length) {
			percent.each(function() {
				var thisPercent = $(this);
				thisPercent.css('opacity', '1');
				
				thisPercent.countTo({
					from: 0,
					to: percentage,
					speed: 2000,
					refreshInterval: 50
				});
			});
		}
	}
	
})(jQuery);