(function($) {
	'use strict';

	var portfolioFullscreenGrid = {};
	eltdf.modules.portfolioFullscreenGrid = portfolioFullscreenGrid;
	
	portfolioFullscreenGrid.eltdfOnWindowLoad = eltdfOnWindowLoad;
	portfolioFullscreenGrid.eltdfOnWindowResize = eltdfOnWindowResize;
	
	$(window).load(eltdfOnWindowLoad);
	$(window).resize(eltdfOnWindowResize);

	/*
	 All functions to be called on $(window).load() should be in this function
	 */
	function eltdfOnWindowLoad() {
		eltdfPortfolioFullscreenGrid();
		eltdfPortfolioFullscreenGridSize();
	}

	/*
	 All functions to be called on $(window).resize() should be in this function
	 */
	function eltdfOnWindowResize() {
		eltdfPortfolioFullscreenGridSize();
	}

	/**
	 * Initializes portfolio list article animation
	 */
	function eltdfPortfolioFullscreenGrid(){
		var fullscreenGrid = $('.eltdf-fullscreen-portfolio-grid-holder');

		if (fullscreenGrid.length){
			fullscreenGrid.each(function () {
				var thisGrid = $(this),
					articles = thisGrid.find('.eltdf-fpg-item'),
					articlesLink = thisGrid.find('.eltdf-fpgi-link'),
					articlesImages = thisGrid.find('.eltdf-fpg-image-holder .eltdf-image-url-holder-inner');


				articles.eq(0).addClass('hovered');
				articlesImages.eq(0).addClass('hovered');

				//remove first click when on touch devices - go to link on second click
				if(eltdf.htmlEl.hasClass('touch')){
					articlesLink.eq(0).addClass('active');

					articlesLink.each(function () {
						var link = $(this);

						link.on('click', function(e){
							if (!link.hasClass('active')) {
								e.preventDefault();
								articlesLink.removeClass('active');
								link.addClass('active');
							}

						});
					});
				}

				articles.each(function(e){
					var thisArticle = $(this);

					thisArticle.on('mouseover', function () {

						var imageHolder = articlesImages.eq(e);

						if (!thisArticle.hasClass('hovered')){
							thisArticle.siblings().removeClass('hovered');
							imageHolder.siblings().removeClass('hovered');

							thisArticle.addClass('hovered');
							imageHolder.addClass('hovered');
						}
					});
				});

			});
		}
	}

	function eltdfPortfolioFullscreenGridSize(){
		var fullscreenGrid = $('.eltdf-fullscreen-portfolio-grid-holder');

		if (fullscreenGrid.length){
			fullscreenGrid.each(function () {
				var thisGrid = $(this),
					thisGridHeight,
					articlesHolder = thisGrid.find('.eltdf-fpg-holder-inner'),
					articles = thisGrid.find('.eltdf-fpg-item'),
					columns,
					postsNumber,
					numberOfRows,
					articleHeight,
					mobileHeaderHeight = $('.eltdf-mobile-header').height();


				if(eltdf.htmlEl.hasClass('touch')){
					thisGrid.css('height','calc(100vh - '+mobileHeaderHeight+'px)');
				}

				thisGridHeight = thisGrid.height();

				if (typeof thisGrid.data('col-number') !== 'undefined' && thisGrid.data('col-number') !== ''){
					columns = thisGrid.data('col-number');
				}

				if (typeof thisGrid.data('number-of-posts') !== 'undefined' && thisGrid.data('number-of-posts') !== ''){
					postsNumber = thisGrid.data('number-of-posts');
				}

				if (eltdf.windowWidth <= 480){
					columns = 1;
				} else if (eltdf.windowWidth <= 768){
					if (columns > 2){
						columns = 2;
					}
				}

				if (postsNumber !== 0){
					numberOfRows = Math.ceil(postsNumber/columns);
				}

				articleHeight = thisGridHeight/numberOfRows;

				if (eltdf.windowWidth <= 480){
					articleHeight = 'auto';
				}

				articles.each(function(e){
					var thisArticle = $(this);

					thisArticle.height(articleHeight);
				});

				//2px is for rounding of px
				if (articlesHolder.height() > thisGridHeight + 2){
					thisGrid.css('height','auto');
				}

				thisGrid.css('opacity',1);

			});
		}
	}

})(jQuery);