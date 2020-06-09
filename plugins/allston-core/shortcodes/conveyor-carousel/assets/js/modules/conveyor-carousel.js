(function($) {
    'use strict';

    var conveyorCarousel = {};
    eltdf.modules.conveyorCarousel = conveyorCarousel;

    conveyorCarousel.eltdfInitConveyorCarousel = eltdfInitConveyorCarousel;
    conveyorCarousel.eltdfOnDocumentReady = eltdfOnDocumentReady;

    $(document).ready(eltdfOnDocumentReady);

    /*
     All functions to be called on $(document).ready() should be in this function
     */
    function eltdfOnDocumentReady() {
        eltdfInitConveyorCarousel();
    }

    function eltdfInitConveyorCarousel() {
        var shortcodes = $('.eltdf-conveyor-carousel');

        if (shortcodes.length) {
            var initSwiper = function(shortcode) {
                var swiperInstance = new Swiper(shortcode.find('.swiper-container'), {
                    slidesPerView: 'auto',
                    loop: true,
                    loopSlides: shortcode.find('.eltdf-cc-image').length,
                    speed: 400,
                    autoplay: {
                        delay: 2500,
                        disableOnInteraction: false
                    },
                    freeMode: true,
                    navigation: {
                        nextEl: shortcode.find('.eltdf-cc-next'),
                        prevEl: shortcode.find('.eltdf-cc-prev'),
                    },
                    680: {
                      slidesPerView: 1,
                    }
                });

                shortcode
                    .find('.eltdf-cc-images-holder')
                    .on('mouseenter', function() {
                        swiperInstance.autoplay.stop();
                    })
                    .on('mouseleave', function() {
                        swiperInstance.autoplay.start();
                    });
            }

            shortcodes.each(function() {
                initSwiper($(this));
            });
        }
    }
})(jQuery);