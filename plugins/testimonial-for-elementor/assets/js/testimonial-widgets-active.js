(function($){
"use strict";

var WidgetTestimonialCarouselHandler = function ($scope, $) {
        var carousel_elem = $scope.find('.tfe-testimonial-activation').eq(0);
        if (carousel_elem.length > 0) {
            var settings = carousel_elem.data('settings');
            var arrows = settings['arrows'];
            var arrow_prev_txt = settings['arrow_prev_txt'];
            var arrow_next_txt = settings['arrow_next_txt'];
            var testimonial_style_ck = parseInt(settings['testimonial_style_ck']) || 1;
            var dots = settings['dots'];
            var autoplay = settings['autoplay'];
            var autoplay_speed = parseInt(settings['autoplay_speed']) || 3000;
            var animation_speed = parseInt(settings['animation_speed']) || 300;
            var pause_on_hover = settings['pause_on_hover'];
            var center_mode = settings['center_mode'];
            var center_padding = parseInt(settings['center_padding']) || 50;
            var center_padding = center_padding.toString();
            var display_columns = parseInt(settings['display_columns']) || 1;
            var scroll_columns = parseInt(settings['scroll_columns']) || 1;
            var tablet_width = parseInt(settings['tablet_width']) || 800;
            var tablet_display_columns = parseInt(settings['tablet_display_columns']) || 1;
            var tablet_scroll_columns = parseInt( settings['tablet_scroll_columns'] ) || 1;
            var mobile_width = parseInt(settings['mobile_width']) || 480;
            var mobile_display_columns = parseInt(settings['mobile_display_columns']) || 1;
            var mobile_scroll_columns = parseInt(settings['mobile_scroll_columns']) || 1;

            if( testimonial_style_ck == 5){

                var carousel_elem_for = $scope.find('.tfe-testimonial-activation .tfe-testimonial-for').eq(0);
                var carousel_elem_nav = $scope.find('.tfe-testimonial-activation .tfe-testimonal-nav').eq(0);

                carousel_elem_for.slick({
                    slidesToShow: 1,
                    slidesToScroll: scroll_columns,
                    arrows: arrows,
                    prevArrow: '<button type="button" class="slick-prev">'+arrow_prev_txt+'</button>',
                    nextArrow: '<button type="button" class="slick-next">'+arrow_next_txt+'</button>',
                    dots: dots,
                    fade: true,
                    asNavFor: '.tfe-testimonal-nav'
                });

                carousel_elem_nav.slick({
                    slidesToShow: display_columns,
                    slidesToScroll: scroll_columns,
                    asNavFor: '.tfe-testimonial-for',
                    dots: false,
                    arrows: false,
                    centerMode: center_mode,
                    focusOnSelect: true,
                    centerPadding: center_padding,
                });

            }else{
                carousel_elem.slick({
                    arrows: arrows,
                    prevArrow: '<button type="button" class="slick-prev">'+arrow_prev_txt+'</button>',
                    nextArrow: '<button type="button" class="slick-next">'+arrow_next_txt+'</button>',
                    dots: dots,
                    infinite: true,
                    autoplay: autoplay,
                    autoplaySpeed: autoplay_speed,
                    speed: animation_speed,
                    fade: false,
                    pauseOnHover: pause_on_hover,
                    slidesToShow: display_columns,
                    slidesToScroll: scroll_columns,
                    centerMode: center_mode,
                    centerPadding: center_padding,
                    responsive: [
                        {
                            breakpoint: tablet_width,
                            settings: {
                                slidesToShow: tablet_display_columns,
                                slidesToScroll: tablet_scroll_columns
                            }
                        },
                        {
                            breakpoint: mobile_width,
                            settings: {
                                slidesToShow: mobile_display_columns,
                                slidesToScroll: mobile_scroll_columns
                            }
                        }
                    ]
                });
            }
        }
    }

    // Run this code under Elementor.
    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction( 'frontend/element_ready/testimonial-fe-addons.default', WidgetTestimonialCarouselHandler);
    });

})(jQuery);