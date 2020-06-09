(function($) {
    'use strict';
	
	var imageGallery = {};
	eltdf.modules.imageGallery = imageGallery;
	
	imageGallery.eltdfInitImageGalleryMasonry = eltdfInitImageGalleryMasonry;
	
	
	imageGallery.eltdfOnWindowLoad = eltdfOnWindowLoad;
	
	$(window).load(eltdfOnWindowLoad);
	
	/*
	 ** All functions to be called on $(window).load() should be in this function
	 */
	function eltdfOnWindowLoad() {
		eltdfInitImageGalleryMasonry();
	}
	
	/*
	 ** Init Image Gallery shortcode - Masonry layout
	 */
	function eltdfInitImageGalleryMasonry(){
		var holder = $('.eltdf-image-gallery.eltdf-ig-masonry-type');
		
		if(holder.length){
			holder.each(function(){
				var thisHolder = $(this),
					masonry = thisHolder.find('.eltdf-ig-masonry');
				
				masonry.waitForImages(function() {
					masonry.isotope({
						layoutMode: 'packery',
						itemSelector: '.eltdf-ig-image',
						percentPosition: true,
						packery: {
							gutter: '.eltdf-ig-grid-gutter',
							columnWidth: '.eltdf-ig-grid-sizer'
						}
					});
					
					setTimeout(function() {
						masonry.isotope('layout');
						eltdf.modules.common.eltdfInitParallax();
					}, 800);
					
					masonry.css('opacity', '1');
				});
			});
		}
	}

})(jQuery);