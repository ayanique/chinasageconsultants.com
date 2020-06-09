(function($) {
    'use strict';
    
    var parallaxInfoItem = {};
    eltdf.modules.parallaxInfoItem = parallaxInfoItem;
    
    parallaxInfoItem.eltdfParallaxInfoItem = eltdfParallaxInfoItem;
    
    parallaxInfoItem.eltdfOnDocumentReady = eltdfOnDocumentReady;
    
    $(document).ready(eltdfOnDocumentReady);
    
    /*
     All functions to be called on $(document).ready() should be in this function
     */
    function eltdfOnDocumentReady() {
        eltdfParallaxInfoItem();
    }
    
    /**
     * Init Parallax Info Item
     */
    function eltdfParallaxInfoItem() {
    	var items = $('.eltdf-parallax-info-item-holder');

    	if (items.length && !eltdf.htmlEl.hasClass('touch')) {
            items.find('.eltdf-pii-title').appear(function(){
                $(this).addClass('eltdf-appeared');
            },{accX: 0, accY: eltdfGlobalVars.vars.eltdfElementAppearAmount});
    	}
   	}
})(jQuery);