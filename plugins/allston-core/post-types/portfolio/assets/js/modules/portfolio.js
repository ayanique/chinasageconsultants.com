(function($) {
    'use strict';

    var portfolio = {};
    eltdf.modules.portfolio = portfolio;
	
	portfolio.eltdfOnDocumentReady = eltdfOnDocumentReady;
    portfolio.eltdfOnWindowLoad = eltdfOnWindowLoad;
	portfolio.eltdfOnWindowResize = eltdfOnWindowResize;
	
	$(document).ready(eltdfOnDocumentReady);
    $(window).load(eltdfOnWindowLoad);
	$(window).resize(eltdfOnWindowResize);
	
	/*
	 All functions to be called on $(document).ready() should be in this function
	 */
	function eltdfOnDocumentReady() {
		eltdfPortfolioFullScreenSlider().init();
		initPortfolioSingleMasonry();
	}
	
	/*
	 All functions to be called on $(window).load() should be in this function
	 */
	function eltdfOnWindowLoad() {
		eltdfPortfolioSingleFollow().init();
	}
	
	/*
	All functions to be called on $(window).resize() should be in this function
	*/
	function eltdfOnWindowResize() {
		initPortfolioSingleMasonry();
	}
	
	var eltdfPortfolioSingleFollow = function () {
		var info = $('.eltdf-follow-portfolio-info .eltdf-portfolio-single-holder .eltdf-ps-info-sticky-holder');
		
		if (info.length) {
			var infoHolder = info.parent(),
				infoHolderOffset = infoHolder.offset().top,
				infoHolderHeight = infoHolder.height(),
				mediaHolder = $('.eltdf-ps-image-holder'),
				mediaHolderHeight = mediaHolder.height(),
				header = $('.header-appear, .eltdf-fixed-wrapper'),
				headerHeight = (header.length) ? header.height() : 0,
				constant = 30; //30 to prevent mispositioned
		}
		
		var infoHolderPosition = function () {
			if (info.length && mediaHolderHeight >= infoHolderHeight) {
				if (eltdf.scroll >= infoHolderOffset - headerHeight - eltdfGlobalVars.vars.eltdfAddForAdminBar - constant) {
					var marginTop = eltdf.scroll - infoHolderOffset + eltdfGlobalVars.vars.eltdfAddForAdminBar + headerHeight + constant;
					// if scroll is initially positioned below mediaHolderHeight
					if (marginTop + infoHolderHeight > mediaHolderHeight) {
						marginTop = mediaHolderHeight - infoHolderHeight + constant;
					}
					info.stop().animate({
						marginTop: marginTop
					});
				}
			}
		};
		
		var recalculateInfoHolderPosition = function () {
			if (info.length && mediaHolderHeight >= infoHolderHeight) {
				//Calculate header height if header appears
				if (eltdf.scroll > 0 && header.length) {
					headerHeight = header.height();
				}
				
				if (eltdf.scroll >= infoHolderOffset - headerHeight - eltdfGlobalVars.vars.eltdfAddForAdminBar - constant) {
					if (eltdf.scroll + headerHeight + eltdfGlobalVars.vars.eltdfAddForAdminBar + constant + infoHolderHeight < infoHolderOffset + mediaHolderHeight) {
						info.stop().animate({
							marginTop: (eltdf.scroll - infoHolderOffset + eltdfGlobalVars.vars.eltdfAddForAdminBar + headerHeight + constant)
						});
						//Reset header height
						headerHeight = 0;
					} else {
						info.stop().animate({
							marginTop: mediaHolderHeight - infoHolderHeight
						});
					}
				} else {
					info.stop().animate({
						marginTop: 0
					});
				}
			}
		};
		
		return {
			init: function () {
				infoHolderPosition();
				$(window).scroll(function () {
					recalculateInfoHolderPosition();
				});
			}
		};
	};
	
	function initPortfolioSingleMasonry(){
		var masonryHolder = $('.eltdf-portfolio-single-holder .eltdf-ps-masonry-images'),
			masonry = masonryHolder.children();
		
		if(masonry.length){
			var size = masonry.find('.eltdf-ps-grid-sizer').width(),
				isFixedEnabled = masonry.find('.eltdf-ps-image[class*="eltdf-masonry-size-"]').length > 0;
			
			masonry.waitForImages(function(){
				masonry.isotope({
					layoutMode: 'packery',
					itemSelector: '.eltdf-ps-image',
					percentPosition: true,
					packery: {
						gutter: '.eltdf-ps-grid-gutter',
						columnWidth: '.eltdf-ps-grid-sizer'
					}
				});
				
				eltdf.modules.common.setFixedImageProportionSize(masonry, masonry.find('.eltdf-ps-image'), size, isFixedEnabled);
				
				masonry.isotope( 'layout').css('opacity', '1');
			});
		}
	}
	
	/**
	 * Init Full Screen Slider
	 */
	var eltdfPortfolioFullScreenSlider = function() {
		
		var sliderHolder = $('.eltdf-full-screen-slider-holder');
		var content = $('.eltdf-wrapper .eltdf-content');
		
		var sliders = $('.eltdf-portfolio-full-screen-slider');
		var fullScreenSliderHolder = $('.full-screen-slider');
		
		var eltdfFullScreenSliderHeight = function() {
			if (sliderHolder.length) {
				
				var contentMargin = parseInt(content.css('margin-top')),
					imageHolder = sliderHolder.find('.eltdf-portfolio-single-media'),
					title = $('.eltdf-title'),
					paspartuHeight = 0,
					sliderHeight = eltdf.windowHeight;
				
				
				if (eltdf.body.hasClass('eltdf-passepartout')){
					var paspartu = $('.eltdf-passepartout-top');
					
					paspartuHeight = paspartu.outerHeight() * 2;
					sliderHeight -= paspartuHeight;
				}
				
				if (title.length){
					sliderHeight -= title.height();
				}
				
				if(eltdf.windowWidth > 1024) {
					if(contentMargin >= 0) {
						sliderHeight -= eltdfGlobalVars.vars.eltdfMenuAreaHeight;
					}
				}
				else {
					sliderHeight -= eltdfGlobalVars.vars.eltdfMobileHeaderHeight;
				}
				
				fullScreenSliderHolder.css("height", sliderHeight);
				sliderHolder.css("height", sliderHeight);
				imageHolder.css("height", sliderHeight);
			}
		};
		
		var eltdfFullScreenSlider = function() {
			
			if (sliderHolder.length) {
				sliders.each(function () {
					var slider = $(this);
					
					slider.on('init', function(slick){
						var activeSlide = slider.find('.slick-active.eltdf-portfolio-single-media');
						if(activeSlide.hasClass('eltdf-slide-dark-skin')){
							slider.removeClass('eltdf-slide-light-skin').addClass('eltdf-slide-dark-skin');
						}else{
							slider.removeClass('eltdf-slide-dark-skin').addClass('eltdf-slide-light-skin');
						}
					});
					
					slider.on('afterChange', function(slick, currentSlide){
						var activeSlide = slider.find('.slick-active.eltdf-portfolio-single-media');
						if(activeSlide.hasClass('eltdf-slide-dark-skin')){
							slider.removeClass('eltdf-slide-light-skin').addClass('eltdf-slide-dark-skin');
						}else{
							slider.removeClass('eltdf-slide-dark-skin').addClass('eltdf-slide-light-skin');
						}
					});
					
					slider.slick({
						vertical: true,
						verticalSwiping: true,
						infinite: true,
						slidesToShow : 1,
						arrows: false,
						dots: true,
						easing: 'easeOutQuart',
						dotsClass: 'eltdf-slick-dots',
						prevArrow: '<span class="eltdf-slick-prev eltdf-prev-icon"><span class="arrow_up"></span></span>',
						nextArrow: '<span class="eltdf-slick-next eltdf-prev-icon"><span class="arrow_down"></span></span>',
						customPaging: function(slider, i) {
							return '<span class="eltdf-slick-dot-inner"></span>';
						}
					}).animate({'opacity': 1}, 600);
				});
			}
			
		};
		
		var eltdfFullScreenSliderInfo = function() {
			
			if (sliderHolder.length) {
				
				var sliderContent = $('.eltdf-portfolio-slider-content');
				var close = $('.eltdf-control.eltdf-close');
				var description = $('.eltdf-description');
				var info = $('.eltdf-portfolio-slider-content-info');
				
				sliderContent.on('click',function(e){
					e.preventDefault();
					if (!sliderContent.hasClass('opened')) {
						description.fadeOut(400, function() {
							sliderContent.addClass('opened');
							eltdf.body.addClass('eltdf-full-screen-slider-info-opened');
							setTimeout(function(){
								info.fadeIn(400);
							}, 400);
							setTimeout(function(){
								var scrollHeight = info.outerHeight();
								info.height(scrollHeight).perfectScrollbar({
									wheelSpeed: 0.6,
									suppressScrollX: true
								});
							}, 800);
						});
					}
				});
				
				close.on('click',function(e){
					e.preventDefault();
					e.stopPropagation();
					info.fadeOut( 400, function() {
						sliderContent.removeClass('opened');
						eltdf.body.removeClass('eltdf-full-screen-slider-info-opened');
						setTimeout(function() {
							description.fadeIn(400);
						}, 400);
					});
				});
				
			}
			
		};
		return {
			init : function() {
				eltdfFullScreenSliderHeight();
				eltdfFullScreenSlider();
				eltdfFullScreenSliderInfo();
				
				$(window).resize(function(){
					eltdfFullScreenSliderHeight();
				});
			}
		};
	};

})(jQuery);