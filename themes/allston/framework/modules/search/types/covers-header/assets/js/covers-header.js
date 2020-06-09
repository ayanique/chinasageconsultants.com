(function($) {
    "use strict";

    var searchCoversHeader = {};
    eltdf.modules.searchCoversHeader = searchCoversHeader;

    searchCoversHeader.eltdfOnDocumentReady = eltdfOnDocumentReady;

    $(document).ready(eltdfOnDocumentReady);
    
    /* 
        All functions to be called on $(document).ready() should be in this function
    */
    function eltdfOnDocumentReady() {
	    eltdfSearchCoversHeader();
    }
	
	/**
	 * Init Search Types
	 */
	function eltdfSearchCoversHeader() {
        if ( eltdf.body.hasClass( 'eltdf-search-covers-header' ) ) {

            var searchOpener = $('a.eltdf-search-opener');

            if (searchOpener.length > 0) {
                searchOpener.each(function () {
	                var thisOpener = $(this);
	                thisOpener.on('click', function (e) {
		                e.preventDefault();
		
		                var thisSearchOpener = $(this),
			                searchFormHeight,
			                searchFormHeaderHolder = $('.eltdf-page-header'),
			                searchFormTopHeaderHolder = $('.eltdf-top-bar'),
			                searchFormFixedHeaderHolder = searchFormHeaderHolder.find('.eltdf-fixed-wrapper.fixed'),
			                searchFormMobileHeaderHolder = $('.eltdf-mobile-header'),
			                searchForm = $('.eltdf-search-cover'),
			                searchFormIsInTopHeader = !!thisSearchOpener.parents('.eltdf-top-bar').length,
			                searchFormIsInFixedHeader = !!thisSearchOpener.parents('.eltdf-fixed-wrapper.fixed').length,
			                searchFormIsInStickyHeader = !!thisSearchOpener.parents('.eltdf-sticky-header').length,
			                searchFormIsInMobileHeader = !!thisSearchOpener.parents('.eltdf-mobile-header').length;
		
		                searchForm.removeClass('eltdf-is-active');
		
		                //Find search form position in header and height
		                if (searchFormIsInTopHeader) {
			                searchFormHeight = eltdfGlobalVars.vars.eltdfTopBarHeight;
			                searchFormTopHeaderHolder.find('.eltdf-search-cover').addClass('eltdf-is-active');
			
		                } else if (searchFormIsInFixedHeader) {
			                searchFormHeight = searchFormFixedHeaderHolder.outerHeight();
			                searchFormHeaderHolder.children('.eltdf-search-cover').addClass('eltdf-is-active');
			
		                } else if (searchFormIsInStickyHeader) {
			                searchFormHeight = searchFormHeaderHolder.find('.eltdf-sticky-header').outerHeight();
			                searchFormHeaderHolder.children('.eltdf-search-cover').addClass('eltdf-is-active');
			
		                } else if (searchFormIsInMobileHeader) {
			                if (searchFormMobileHeaderHolder.hasClass('mobile-header-appear')) {
				                searchFormHeight = searchFormMobileHeaderHolder.children('.eltdf-mobile-header-inner').outerHeight();
			                } else {
				                searchFormHeight = searchFormMobileHeaderHolder.outerHeight();
			                }
			
			                searchFormMobileHeaderHolder.find('.eltdf-search-cover').addClass('eltdf-is-active');
			
		                } else {
			                searchFormHeight = searchFormHeaderHolder.outerHeight();
			                searchFormHeaderHolder.children('.eltdf-search-cover').addClass('eltdf-is-active');
		                }
		
		                if (searchForm.hasClass('eltdf-is-active')) {
			                searchForm.height(searchFormHeight).stop(true).fadeIn(600).find('input[type="text"]').focus();
		                }
		
		                searchForm.find('.eltdf-search-close').on('click', function (e) {
			                e.preventDefault();
			                searchForm.stop(true).fadeOut(450);
		                });
		
		                searchForm.blur(function () {
			                searchForm.stop(true).fadeOut(450);
		                });
		
		                $(window).scroll(function () {
			                searchForm.stop(true).fadeOut(450);
		                });
	                });
                });
            }
        }
	}

})(jQuery);
