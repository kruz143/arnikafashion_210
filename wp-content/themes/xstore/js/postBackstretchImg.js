/**
 * Description
 *
 * @package    postBackstretchImg.js
 * @since      6.3.4
 * @author     stas
 * @link       http://xstore.8theme.com
 * @license    Themeforest Split Licence
 */
var postBackstretch;

;(function ($) {

    "use strict";

    postBackstretch = {
        init : function() {
            this.postBackstretchImg();
        },

        postBackstretchImg: function () {
            var postImage = $('.post-template-large .wp-picture img, .post-template-large2 .wp-picture img, .content-article .post-gallery-slider img, .post-template-large img, .post-template-large2 img').first(),
                postHead = $(".single-post-large");
            if (postImage.length > 0 && postImage.attr('src')) {
                if (postImage.attr('data-src')) {
                    postHead.backstretch(postImage.attr('data-src'));
                } else {
                    postHead.backstretch(postImage.attr('src'));
                }
            }

            $(window).scroll(function () {
                var scrolledY = $(window).scrollTop();
                $(".single-post-large img").css('transform', 'translate3d(0px, ' + scrolledY / 1.2 + 'px, 0px)');

            });

            $('.swiper-entry').closest('.blog-post').find('> div').addClass('swiper-class-blog');
        }
    };

    $(document).ready(function () {
        postBackstretch.init();
    });

})(jQuery);