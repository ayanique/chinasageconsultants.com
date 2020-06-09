(function($) {
	'use strict';

	var portfolioFullscreenSlider = {};
	eltdf.modules.portfolioFullscreenSlider = portfolioFullscreenSlider;

	portfolioFullscreenSlider.eltdfOnDocumentReady = eltdfOnDocumentReady;
	portfolioFullscreenSlider.eltdfOnWindowLoad = eltdfOnWindowLoad;
	portfolioFullscreenSlider.eltdfOnWindowResize = eltdfOnWindowResize;
	portfolioFullscreenSlider.eltdfOnWindowScroll = eltdfOnWindowScroll;

	$(document).ready(eltdfOnDocumentReady);
	$(window).load(eltdfOnWindowLoad);
	$(window).resize(eltdfOnWindowResize);
	$(window).scroll(eltdfOnWindowScroll);

	/*
	 All functions to be called on $(document).ready() should be in this function
	 */
	function eltdfOnDocumentReady() {

	}

	/*
	 All functions to be called on $(window).load() should be in this function
	 */
	function eltdfOnWindowLoad() {
		eltdfPortfolioFullscreenSlider();
	}

	/*
	 All functions to be called on $(window).resize() should be in this function
	 */
	function eltdfOnWindowResize() {
	}

	/*
	 All functions to be called on $(window).scroll() should be in this function
	 */
	function eltdfOnWindowScroll() {
	}

	function eltdfPortfolioFullscreenSlider(){
		var fullscreenSliders = $('.eltdf-portfolio-fullscreen-slider-holder');

		if (fullscreenSliders.length){
			fullscreenSliders.each(function () {
				var thisSlider = $(this),
					articles = thisSlider.find('.eltdf-pfs-item'),
					articlesLink = thisSlider.find('.eltdf-pfs-link'),
					articlesImages = thisSlider.find('.eltdf-pfs-image-holder .eltdf-pfs-image-holder-item'),
					articlesHolder = thisSlider.find('.eltdf-pfs-articles-holder'),
					swiperInstance = thisSlider.find('.swiper-container'),
                    swiperInstanceHeight = 0,
					direction = 'vertical',
					loop = false,
					wheel = true,
					slideSpeed = 600,
					slidesOffsetBefore = 0,
					mobileHeaderHeight = $('.eltdf-mobile-header').height();


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

                    swiperInstanceHeight += thisArticle.outerHeight();

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

				if(eltdf.htmlEl.hasClass('touch')){
					thisSlider.css('height','calc(100vh - '+mobileHeaderHeight+'px)');
				}



				slidesOffsetBefore = -eltdf.windowHeight * 0.3;
				
				if(eltdf.windowWidth <= 1366) {
					slidesOffsetBefore = -eltdf.windowHeight * 0.7;
				}

				if(eltdf.windowWidth <= 1280) {
					slidesOffsetBefore = -eltdf.windowHeight * 0.5;
				}

				if(eltdf.windowWidth <= 1025) {
					slidesOffsetBefore = -eltdf.windowHeight * 0.3;
				}

				if (eltdf.htmlEl.hasClass('touch')) {

					articles.each(function(){
						$(this).css('min-height', $(this).outerHeight());
					})
				}

                var centeredSlides = swiperInstanceHeight < eltdf.windowHeight * 0.9 ? false : true; //0.9 beace of the top padding on container which is 10% of window height

				//sliders
				var swiperSlider = new Swiper(swiperInstance, {
					loop: loop,
					initialSlide: 0,
					slidesOffsetBefore: slidesOffsetBefore,
					slidesPerView: 'auto',
					centeredSlides: centeredSlides,
					speed: slideSpeed,
					direction: direction,
					mousewheel: wheel,
					preventClicks: true,
					preventClicksPropagation: false,
					on: {
						init: function (e) {
							thisSlider.addClass('eltdf-initialized');
						}
					}
				});
				
				swiperSlider.on('slideChangeTransitionEnd', function () {
					var lastSlide = articlesHolder.find('.eltdf-pfs-item').last();
					swiperSlider.allowSlideNext = lastSlide.offset().top + lastSlide.height() > eltdf.windowHeight;
				});

			});
		}
	}

})(jQuery);