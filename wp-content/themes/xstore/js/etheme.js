var etTheme;

;(function ($) {

    "use strict";

    var swipers = [],
        initIterator = 0;

    function setParams(swiper, dataValue, returnValue) {
        return (swiper.is('[data-' + dataValue + ']')) ? ((typeof swiper.data(dataValue) != "string") ? parseInt(swiper.data(dataValue), 10) : swiper.data(dataValue)) : returnValue;
    }

    var et_ajax, et_woocommerce, et_global;

    etTheme = {
        init: function () {
            et_ajax = {
                'in_progress': false
            };
            et_woocommerce = {
                'is_single_product': $('body').hasClass('single-product'),
                'quick_view_opened': false,
            };
            et_global = {
                'w_width': $(window).width(),
                'w_height': $(window).height(),
                'is_masonry': $('body').hasClass('etheme_masonry_on'),
                's_widgets_open_close': $('body').hasClass('s_widgets-open-close'), // widgets
                'f_widgets_open_close': $('body').hasClass('f_widgets-open-close'), // widgets
                's_widgets_open_close_done': false,
                'deny_link_click': false,
                'classes': {
                    'skeleton': etConfig.et_global.classes.skeleton,
                    'mfp': etConfig.et_global.classes.mfp
                }
            };

            // must_have functions
            this.helpers();
            this.copyToClipboard();
            this.sitePreloader();
            this.resizeVideo();
            this.swiperFunc();
            this.ajaxNotifies();

            // fixes functions
            this.windowsPhoneFix();
            this.cleanSpaces();
            this.customCss();
            this.customCssOne();
            this.fixTabsFullWidth();

            // breadcrumbs
            this.breadcrumbs(); // only parallax animation

            // header functions
            // menu modules
            this.secondaryMenu();
            this.onePageMenu();
            this.menuPosts();

            this.mainNavigation(); // переробити структуру і винести в інший
            if ( !etConfig['layoutSettings']['is_header_builder']) {
                this.navMenuSmart();
            }

            // footer
            this.fixedFooter();

            // modules
            this.blogIsotope();
            this.isotope();
            this.isotopeFilters(); // uses in brand-list element
            this.backToTop();

            // manually with VC
            this.tabs();
            this.global_image_lazy();

            // ajax modules
            this.PostProductAjaxLoad();
            this.AjaxElement();

            // post/product modules
            this.commentsForm();

            // woocommerce
            if (etConfig['woocommerceSettings']['is_woocommerce']) {
                this.contentProdImages();
                this.photoSwipe();
                if (et_woocommerce['is_single_product']) {
                    this.sliderVertical();
                }
                this.woocommerce();
                this.quantityIncrements(false);
                this.ajaxAddToCartInit();
                if ( etConfig.variationGallery ) {
                    this.variationGallery();
                }
                else {
                    this.variationsThumbs();
                    this.jumpToSlide();
                }
                this.videoPopup();
                this.quickView();
                this.theLook();
                this.filtersArea();
                if (!etConfig['layoutSettings']['is_single_product_builder']) {
                    // this.affixJS();
                    this.stickyProductImages();
                }
                this.ForCompare();
                this.after_cart_refreshed();

                // widgets
                if (etConfig.catsAccordion) {
                    this.categoriesAccordion();
                }

                // 3rd-party plugins compatibility
                this.ReinitForInfiniteScroll();
            }

            // widgets
            this.CustomMenuAccordion();
            this.widgetsOpenCloseDefault();
            this.widgetsOpenClose();

            // sidebar functions
            this.stickySidebar();
            this.sidebarMobile();
            this.sidebarMobileToggle();

            // 3rd-party plugins compatibility

            // massive addons
            this.heightFixMassive();

            // counters, timers
            this.imagesLightbox();
            this.loadInView();
            this.countdown();

            $(window).resize();

        },

        // must have
        helpers: function () {
            $(window).resize(function () {
                et_global['w_width'] = $(window).width();
                et_global['w_height'] = $(window).height();
            });
            $(document).on('click', 'a', function (e) {
                if (et_global['deny_link_click'] && !$(this).parents().hasClass('et-mini-content')) {
                    e.preventDefault();
                }
            });
            $(document).on('et_ajax_content_loaded', function() {
                et_global['deny_link_click'] = false;
            });
            $(document).on('et_ajax_popup_loaded', function() {
                etTheme.tabs();
            });
        },

        copyToClipboard: function() {
            $(document).on('click', '.copy-to-clipboard', function(e) {
                e.preventDefault();
                var link_to_copy =  $(this).attr('href');
                $('#et-buffer').text(link_to_copy);
                copyToClipboard(document.getElementById('et-buffer'));

                var et_notify = $('.et-notify');
                // to show mini text when added to cart with ajax
                et_notify.removeClass('removing').attr('data-type', 'success').html(etConfig.successfullyCopied);
                setTimeout(function () {
                    et_notify.addClass('removing');
                }, 2000);
                setTimeout(function () {
                    et_notify.removeClass('removing').attr('data-type', null).html('');
                }, 2400);

            });

            //copy buffer
            function copyToClipboard(elem) {
                // create hidden text element, if it doesn't already exist
                var targetId = "_hiddenCopyText_";
                var isInput = elem.tagName === "INPUT" || elem.tagName === "TEXTAREA";
                var origSelectionStart, origSelectionEnd;
                if (isInput) {
                    // can just use the original source element for the selection and copy
                    target = elem;
                    origSelectionStart = elem.selectionStart;
                    origSelectionEnd = elem.selectionEnd;
                } else {
                    // must use a temporary form element for the selection and copy
                    target = document.getElementById(targetId);
                    if (!target) {
                        var target = document.createElement("textarea");
                        target.style.position = "fixed";
                        target.style.left = "0";
                        target.style.top = "0";
                        target.style.right = "0";
                        target.style.bottom = "0";
                        target.id = targetId;
                        document.body.appendChild(target);
                    }
                    target.textContent = elem.textContent;
                }
                // select the content
                var currentFocus = document.activeElement;
                target.focus();
                target.setSelectionRange(0, target.value.length);

                // copy the selection
                var succeed;
                try {
                    succeed = document.execCommand("copy");
                } catch(e) {
                    succeed = false;
                }
                // restore original focus
                if (currentFocus && typeof currentFocus.focus === "function") {
                    currentFocus.focus();
                }

                if (isInput) {
                    // restore prior selection
                    elem.setSelectionRange(origSelectionStart, origSelectionEnd);
                } else {
                    // clear temporary content
                    target.textContent = "";
                }
                return succeed;
            }
        },

        sitePreloader: function () {
            setTimeout(function () {
                $('body').removeClass('et-preloader-on').addClass('et-preloader-hide');
            }, 500);
        },

        resizeVideo: function () {
            $(document).find('.single-product .product-video-popup iframe[src*="youtube.com"], .single-product .product-video-popup iframe[src*="vimeo.com"], article.blog-post iframe[src*="youtube.com"], article.blog-post iframe[src*="vimeo.com"]').each(function () {
                $(this).attr('width', '100%').css('height', $(this).width() * 0.56, 'important');
            });
        },

        swiperFunc: function () {

            var swiper_control_top_index;

            $('.swiper-container').not('.initialized, .et-self-init-slider').each(function () {
                var $t = $(this);

                var index = 'swiper-unique-id-' + initIterator;

                $t.addClass('swiper-' + index + ' initialized').attr('id', index);
                $t.parent().find('.swiper-button-prev, .swiper-custom-left').addClass('swiper-button-prev-' + index);
                $t.parent().find('.swiper-button-next, .swiper-custom-right').addClass('swiper-button-next-' + index);

                if ( $t.find('.elementor-swiper-button').length || $t.find('.elementor-image-carousel').length) {
                }
                else {
                    $t.find('.swiper-pagination').addClass('swiper-pagination-' + index);
                }

                if (window.elementorFrontend) {
                    // Bottom Nvaigation
                    $t.parent().parent().find('.swiper-button-prev, .swiper-custom-left').addClass('swiper-button-prev-' + index);
                    $t.parent().parent().find('.swiper-button-next, .swiper-custom-right').addClass('swiper-button-next-' + index);
                    // NvarBar Navigation
                    var nav_id = $t.parent().parent().attr('data-id');
                    var menu_container = $t.parent().parent().parent().prev('.et-tabs-nav');
                    $(menu_container).find('ul li[data-id="' + nav_id + '"].swiper-button-prev').addClass('swiper-button-prev-' + index);
                    $(menu_container).find('ul li[data-id="' + nav_id + '"].swiper-button-next').addClass('swiper-button-next-' + index);

                }

                // if ($t.parents().is('.mpc-container') && !$t.parents('.mpc-container').data('active')) {
                if ($t.parents().hasClass('mpc-container') && !$t.parents('.mpc-container').data('active')) {
                    $t.find('img').removeClass('swiper-lazy').addClass('swiper-pre-lazy');
                }

                var autoplay = false;

                if (setParams($t, 'autoplay', false)) {
                    autoplay = {
                        delay: setParams($t, 'autoplay', false),
                    };
                }

                var slider_params = {
                    'freeMode': false,
                    'centeredSlides': false,
                    'preloadImages': false,
                    'lazyImages': true,
                    'mousewheel': false,
                    'grabCursor': false
                };

                if ($t.is('[data-free-mode]')) {
                    slider_params['freeMode'] = setParams($t, 'freeMode', true);
                    slider_params['preloadImages'] = true;
                    slider_params['lazyImages'] = false;
                    slider_params['mousewheel'] = true;
                    slider_params['grabCursor'] = true;
                } else {
                    slider_params['centeredSlides'] = setParams($t, 'center', false);
                }

                swipers['swiper-' + index] = new Swiper('.swiper-' + index, {
                    pagination: {
                        el: '.swiper-pagination-' + index,
                        clickable: true
                    },
                    navigation: {
                        nextEl: '.swiper-button-next-' + index,
                        prevEl: '.swiper-button-prev-' + index,
                    },
                    grabCursor: slider_params['grabCursor'],
                    autoplay: autoplay,
                    loop: !!($t.is('[data-loop]')),
                    slidesPerView: setParams($t, 'slides-per-view', true), // +
                    slidesPerGroup: setParams($t, 'slides-per-group', true), // +
                    autoHeight: !!($t.is('[data-autoheight]')), // +
                    centeredSlides: slider_params['centeredSlides'], // +
                    freeMode: slider_params['freeMode'],
                    breakpoints: ((window.elementorFrontend) ? {
                        0: {
                            slidesPerView: ($t.is('[data-xs-slides]') && $t.attr('data-xs-slides') != 'auto') ? parseInt($t.attr('data-xs-slides'), 10) : 'auto'
                        },
                        481: {
                            slidesPerView: ($t.is('[data-sm-slides]') && $t.attr('data-sm-slides') != 'auto') ? parseInt($t.attr('data-sm-slides'), 10) : 'auto'
                        },
                        1366: {
                            slidesPerView: ($t.is('[data-lt-slides]') && $t.attr('data-lt-slides') != 'auto') ? parseInt($t.attr('data-lt-slides'), 10) : 'auto'
                        },
                    } : ($t.is('[data-breakpoints]')) ? {
                        767: {
                            slidesPerView: ($t.attr('data-xs-slides') != 'auto') ? parseInt($t.attr('data-xs-slides'), 10) : 'auto'
                            // slidesPerGroup: ($t.attr('data-xs-slides')!='auto' && $t.data('center')!='1')?parseInt($t.attr('data-xs-slides'), 10):1
                        },
                        991: {
                            slidesPerView: ($t.attr('data-sm-slides') != 'auto') ? parseInt($t.attr('data-sm-slides'), 10) : 'auto'
                            // slidesPerGroup: ($t.attr('data-sm-slides')!='auto' && $t.data('center')!='1')?parseInt($t.attr('data-sm-slides'), 10):1
                        },
                        1199: {
                            slidesPerView: ($t.attr('data-md-slides') != 'auto') ? parseInt($t.attr('data-md-slides'), 10) : 'auto'
                            // slidesPerGroup: ($t.attr('data-md-slides')!='auto' && $t.data('center')!='1')?parseInt($t.attr('data-md-slides'), 10):1
                        },
                        1370: {
                            slidesPerView: ($t.attr('data-lt-slides') != 'auto') ? parseInt($t.attr('data-lt-slides'), 10) : 'auto'
                            // slidesPerGroup: ($t.attr('data-lt-slides')!='auto' && $t.data('center')!='1')?parseInt($t.attr('data-lt-slides'), 10):1
                        }
                    } : {}),

                    initialSlide: setParams($t, 'initialslide', 0), // +
                    speed: setParams($t, 'speed', 500), // +
                    // parallax: setParams($t,'parallax',false), //+
                    // slideToClickedSlide: setParams($t,'clickedslide',0),// + ?
                    // mousewheelControl: grunt watchetParams($t,'mousewheel',0),
                    mousewheel: slider_params['mousewheel'],
                    direction: ($t.is('[data-direction]')) ? $t.data('direction') : 'horizontal',
                    spaceBetween: ($t.is('[data-space]')) ? $t.data('space') : 10,
                    watchSlidesProgress: true,
                    //autoplayDisableOnInteraction: true, // ?
                    //keyboardControl: true, // ?
                    //mousewheelReleaseOnEdges: true, // ?
                    preloadImages: slider_params['preloadImages'],
                    lazy: slider_params['lazyImages'],
                    // lazyLoadingInPrevNext: true,
                    // lazyLoadingInPrevNextAmount: 1,
                    // lazyLoadingOnTransitionStart: true,
                    // loopedSlides: 3,
                    observer: true,
                    observeParents: true,
                    // roundLengths: true, temporary because in some cases loop brokes
                    watchSlidesVisibility: true,
                    slidesPerColumn: setParams($t, 'slidespercolumn', 1),
                    effect: ($t.is('[data-effect]')) ? $t.data('effect') : 'slide',
                    // on: {
                    //     init: function () {
                    //         setTimeout(function () {
                    //             etTheme.reinitSwatches();
                    //         }, 300);
                    //     },
                    //
                    //     transitionStart: function () {
                    //         etTheme.reinitSwatches();
                    //     }
                    // }
                });


                if ($t.hasClass('swiper-control-top')) {
                    swiper_control_top_index = index;
                }

                // ! Switcher ON/OFF mobile optimization carousel.

                // $(window).resize(function(){

                //    if( $(window).width() > 768 ) {
                //         $t.find( '.image-swap img' ).removeClass( 'lazy-off hidden' );
                //         $t.find( '.image-swap img' ).addClass( 'swiper-lazy' );
                //         swipers['swiper-'+index].init();
                //    }

                //    if( $(window).width() <= 768 ) {
                //         $t.find( '.image-swap img' ).addClass( 'lazy-off hidden' );
                //         $t.find( '.image-swap img' ).removeClass( 'swiper-lazy' );
                //         swipers['swiper-'+index].init();
                //    }
                // });


                $(document).on('click', '.mpc-tabs__nav-item', function () {

                    var mpc_container = $t.parents('.mpc-container');

                    mpc_container.addClass('et_load-tab');

                    $t.find('img.swiper-pre-lazy').not('.lazy-off').addClass('swiper-lazy');
                    swipers['swiper-' + index].lazy.load();
                    // setTimeout(function() {
                    //     if ( $t.find( '.swiper-lazy-loaded' ).height() ) {
                    //         $t.find( '.product-content-image' ).height( $t.find( '.swiper-lazy-loaded' ).height() );
                    //     }
                    // }, 500);

                    if ($t.find('img.swiper-lazy-loaded'))
                        mpc_container.removeClass('et_load-tab').addClass('et_loaded-tab');

                });

                if (etConfig.builders.is_wpbakery) {

                    $(document).on('click', '.vc_tta-tab', function () {
                        swipers['swiper-' + index].init();
                        swipers['swiper-' + index].update();
                        // setTimeout(function() {
                        //     $t.find( '.product-content-image' ).height( $t.find( '.swiper-lazy-loaded' ).height() );
                        // }, 500);
                    });

                }

                // $( document ).on('click', '.et-tabs-wrapper .tab-title', function(){
                //     setTimeout(function() {
                //         $t.find( '.product-content-image' ).height( $t.find( '.swiper-lazy-loaded' ).height() );
                //     }, 500);

                // });

                $(document).ready(function () {
                    $('.fadeIn-slide').each(function () {
                        $(this).addClass('fadedIn-slide');
                        setTimeout(function () {
                            $('.fadeIn-slide').removeClass('fadedIn-slide').removeClass('fadeIn-slide');
                        }, 700);
                    });
                });

                // $(document).ready(function(){

                //     $('.swiper-bg-image-lazy').each(function(){
                //         var lazy_slide = '.slider-item-'+$(this).attr('data-slide-id');
                //         if ( $(lazy_slide).attr('data-bg-img') != '' ) {
                //             var e = $(this).parent()[0];
                //             var bg_lazy_observer = new MutationObserver(function (event) {
                //                 if ( $(lazy_slide).parent().hasClass('swiper-slide-active') ) {
                //                     if ( !$(lazy_slide).hasClass('bg-img-loaded') ) {
                //                         $(lazy_slide).closest('.swiper-container').find('.et-loader').css({
                //                             'visibility': 'visible',
                //                             'opacity' : '1',
                //                             'z-index': '9'
                //                         })
                //                     }
                //                     if ($(lazy_slide).css({'background-image': $(lazy_slide).attr('data-bg-image') }) ) {
                //                         $(lazy_slide).removeAttr('data-bg-image');
                //                     }

                //                     if ( !$(lazy_slide).hasClass('bg-img-loaded') ) {
                //                         setTimeout(function(){
                //                             $(lazy_slide).addClass('bg-img-loaded');
                //                             $(lazy_slide).closest('.swiper-container').find('.et-loader').attr('style', '');
                //                         }, 500);
                //                     }
                //                 }
                //             });

                //             bg_lazy_observer.observe(e, {
                //               attributes: true,
                //               attributeFilter: ['class'],
                //               childList: false,
                //               characterData: false
                //             });
                //         }
                //     });
                // });

                if (etConfig.builders.is_wpbakery) {

                    // ! for swipers inside tabs with autoplay
                    $('.vc_tta-tab').each(function () {
                        var e = $(this)[0];
                        var observer = new MutationObserver(function (event) {
                            swipers['swiper-' + index].init();
                            swipers['swiper-' + index].update();
                        });

                        observer.observe(e, {
                            attributes: true,
                            attributeFilter: ['class'],
                            childList: false,
                            characterData: false
                        });

                        // setTimeout(function() {
                        //     if ( $t.find( '.swiper-lazy-loaded' ).height() ) {
                        //         $t.find( '.product-content-image' ).height( $t.find( '.swiper-lazy-loaded' ).height() );
                        //     }
                        // }, 500);
                    });

                    setTimeout(function () {
                        $('.vc_tta-tab.vc_active').click();
                    }, 500);

                    $(window).bind("vc_js", function () {
                        swipers['swiper-' + index].update();
                        // if ( $t.find( '.swiper-lazy-loaded' ).height() ) {
                        //     $t.find( '.product-content-image' ).height( $t.find( '.swiper-lazy-loaded' ).height() );
                        // }
                    });

                }

                $(window).load(function () {
                    swipers['swiper-' + index].init();
                    swipers['swiper-' + index].update();
                    swipers['swiper-' + index].lazy.load();
                    // if ( $t.find( '.swiper-lazy-loaded' ).height() ) {
                    //     $t.find( '.product-content-image' ).height( $t.find( '.swiper-lazy-loaded' ).height() );
                    // }
                });

                $('.swiper-container.stop-on-hover')
                    .on('mouseenter', function () {
                        swipers['swiper-' + ($(this).attr('id'))].autoplay.stop();
                    })
                    .on('mouseleave', function () {
                        swipers['swiper-' + ($(this).attr('id'))].autoplay.start();
                    });

                $(document)
                    .on('found_variation', 'form.variations_form', function () {
                        swipers['swiper-' + index].slideTo(0);
                    })
                    .on('reset_image', 'form.variations_form', function () {
                        swipers['swiper-' + index].slideTo(0);
                    });

                if (etConfig.variationGallery) {

                    $('.variations_form')
                        .on('found_variation', function () {
                            setTimeout(function () {
                                swipers['swiper-' + index].init();
                                swipers['swiper-' + index].update();
                                swipers['swiper-' + index].lazy.load();
                                swipers['swiper-' + index].slideTo(0);
                            }, 300);
                        })
                        .on('reset_data', function () {
                            setTimeout(function () {
                                swipers['swiper-' + index].init();
                                swipers['swiper-' + index].update();
                                swipers['swiper-' + index].lazy.load();
                                swipers['swiper-' + index].slideTo(0);
                            }, 300);
                        });

                    $(document).on('click', '.et-quick-view-wrapper .st-swatch-preview li, .et-quick-view-wrapper .sten-reset-loop-variation', function () {
                        setTimeout(function () {
                            swipers['swiper-' + index].init();
                            swipers['swiper-' + index].update();
                            swipers['swiper-' + index].lazy.load();
                        }, 300);
                    });

                }

                $(document).on('click', '.quick-view-info .sten-reset-loop-variation, .quick-view-info .st-swatch-preview li', function () {
                    swipers['swiper-' + index].slideTo(0);
                });

                swipers['swiper-' + index].update();
                initIterator++;
            });

            $(window).load(function () {
                // need because when slow network, loop slider, and full width then it showed for sec 2 slides and reinit then
                etTheme.secondInitSwipers();
                etTheme.reinitSwatches();

                $('.swiper-wrapper.thumbnails-list .swiper-slide').eq(0).addClass('active-thumbnail');

                $('.swiper-container-multirow').each(function(){
                    console.log('sdfsdf22');
                    swipers['swiper-' + ($(this).attr('id'))].init();
                    swipers['swiper-' + ($(this).attr('id'))].update();
                })

            });

            if (swiper_control_top_index) {
                swipers['swiper-' + swiper_control_top_index].on('transitionStart', function () {
                    var real_index = swipers['swiper-' + swiper_control_top_index].realIndex | 0;
                    $('.swiper-wrapper.thumbnails-list .swiper-slide').removeClass('active-thumbnail');
                    $('.swiper-wrapper.thumbnails-list .swiper-slide').eq(real_index).addClass('active-thumbnail');
                    $('.slick-slider.vertical-thumbnails .slick-slide').eq(real_index).trigger('click');
                });
            }

            $(document).on('click', '.thumbnail-item', function () {
                $(this).addClass('active-thumbnail');
                $(this).siblings($(this)).removeClass('active-thumbnail');

                var switchIndex = $(this).closest('.swipers-couple-wrapper').find('.thumbnail-item').index(this);
                swipers['swiper-' + $(this).closest('.swipers-couple-wrapper').find('.swiper-control-top').attr('id')].slideTo(switchIndex);
                return false;
            });

            etTheme.resizeVideo();

            // $(document).on( 'click', '.swiper-custom-right', function () {
            //     swipers['swiper-'+$(this).siblings('.swiper-container').attr('id')].slideNext();
            // });
            //
            // $(document).on('click', '.swiper-custom-left', function () {
            //     swipers['swiper-'+$(this).siblings('.swiper-container').attr('id')].slidePrev();
            // });

        },

        secondInitSwipers: function () {
            $('.swiper-container').not('.second-initialized').each(function () {
                var $t = $(this);
                var wrapper = $t.parent().hasClass('swipers-couple-wrapper') ? $t : $t.parent();

                var prev = wrapper.find('.swiper-button-prev.swiper-button-disabled, .swiper-custom-left.swiper-button-disabled');
                var next = wrapper.find('.swiper-button-next.swiper-button-disabled, .swiper-custom-right.swiper-button-disabled');

                if (next.length > 0 && prev.length > 0) {
                    if ($t.hasClass('swiper-control-top') && etConfig.variationGallery) {}
                    else {
                        next.remove();
                        prev.remove();
                    }
                }

                $t.addClass('second-initialized');
            });
        },

        ajaxNotifies: function () {
            if (etConfig.ajaxProductNotify) {
                $(document.body)
                    .on('added_to_cart', function (event, fragments, cart_hash, $thisbutton) {
                        var et_notify = $('.et-notify');
                        // to show mini text when added to cart with ajax
                        et_notify.removeClass('removing').attr('data-type', 'success').html(etConfig.successfullyAdded);
                        setTimeout(function () {
                            et_notify.addClass('removing');
                        }, 2000);
                        setTimeout(function () {
                            et_notify.removeClass('removing').attr('data-type', null).html('');
                        }, 2400);
                    });
            }
        },

        // fixes functions

        windowsPhoneFix: function () {
            // **********************************************************************//
            // ! Windows Phone Responsive Fix
            // **********************************************************************//
            if ("-ms-user-select" in document.documentElement.style && navigator.userAgent.match(/IEMobile\/10\.0/)) {
                var msViewportStyle = document.createElement("style");
                msViewportStyle.appendChild(
                    document.createTextNode("@-ms-viewport{width:auto!important}")
                );
                document.getElementsByTagName("head")[0].appendChild(msViewportStyle);
            }
        },

        cleanSpaces: function () {
            // **********************************************************************//
            // ! Remove some br and p
            // **********************************************************************//
            $('.toggle-element ~ br, .toggle-element ~ p').remove();
            $('.block-with-ico h5, .tab-content .row-fluid').next('p').remove();
            $('.tab-content .row-fluid').prev('p').remove();
        },

        customCss: function () {
            var shortcodeCss = $('.etheme-css');
            if (shortcodeCss.length > 0) {
                var css = '';
                shortcodeCss.each(function (i, e) {
                    var $e = $(e), data = $e.data('css');
                    if (data) {
                        css += data;
                        $e.attr('data-css', '');
                    }
                });
                $('head').append('<style>' + css + '</style>');
            }
        },

        customCssOne: function () {
            var products_row = $('.products-with-custom-template');
            if (products_row.length > 0) {
                products_row.each(function () {
                    var parent = $(this).attr('data-post-id');
                    var shortcodeCss = $(this).find('.etheme-css-one');
                    if (shortcodeCss.length > 0) {
                        var css = '';
                        var elements = [];
                        // shortcodeCss.each(function (i, e) {
                        shortcodeCss.each(function (e) {
                            if ($.inArray($(e).attr('class'), elements) < 0) {
                                var $e = $(e), data = $e.data('css');
                                if (data) {
                                    var el_css = data.split('}');
                                    for (var i = 0; i < el_css.length - 1; i++) {
                                        css += '.products-template-' + parent + ' ';
                                        css += el_css[i] + '}';
                                    }
                                    elements.push($e.attr('class'));
                                }
                            }
                        });
                        $('head').append('<style>' + css + '</style>');
                    }
                    shortcodeCss.attr('data-css', '');
                });

            }
        },

        fixTabsFullWidth: function() {
            if ( !etConfig.builders.is_wpbakery && $('.tabs-full-width').length ) {
                var left = $('.tabs-full-width').offset().left;
                var right = $('.tabs-full-width').offset().right;

                $('.tabs-full-width').css({
                    'position': 'relative',
                    'left': -left,
                    'width': et_global['w_width'],
                    'padding-left': left - 15,
                    'padding-right': left - 15
                });
            }
        },

        // breadcrumbs
        breadcrumbs: function () {
            if (et_global['w_width'] < 1200) return;

            var previousScroll = 0,
                deltaY = 0,
                breadcrumbs = $('.bc-effect-text-scroll').find('.container'),
                opacity = 1,
                finalOpacity = 0.3,
                scale = 1,
                finalScale = 0.8,
                scrollTo = 300;

            $(window).scroll(function () {
                var currentScroll = $(this).scrollTop();

                if (currentScroll > 1 && currentScroll < scrollTo) {

                    opacity = 1 - (1 - finalOpacity) * (currentScroll / scrollTo);
                    scale = 1 - (1 - finalScale) * (currentScroll / scrollTo);

                    opacity = opacity.toFixed(3);
                    scale = scale.toFixed(3);

                    breadcrumbsAnimation(breadcrumbs);
                } else if (currentScroll < 10) {
                    opacity = 1;
                    scale = 1;

                    breadcrumbsAnimation(breadcrumbs);
                }

                var scrolledY = $(window).scrollTop();
                // $('.bc-type-8').css('background-position', 'left ' + ((scrolledY)/1.5) + 'px');

            });

            var breadcrumbsAnimation = function (el) {
                if (deltaY >= 0 || $(window).scrollTop() < 1) deltaY = 0;
                el.css({
                    'transform': 'scale(' + scale + ')',
                    '-webkit-transform': 'scale(' + scale + ')',
                    'opacity': opacity
                });
            };

            /* Parallax on mouse move */

            var mouseParallax = $('.bc-effect-mouse'),
                x0 = 50,
                y0 = 0,
                koef = 0.35,
                time = 350;

            mouseParallax.mousemove(function (e) {
                var width = et_global['w_width'],
                    height = $(this).outerHeight();

                var dX = width / 2 - e.pageX,
                    dY = height / 2 - e.pageY;

                var x = x0 + dX / width * 100 * koef,
                    y = y0 - dY / height * 100 * koef;

                if (x < 0) x = 0;
                if (y < 0) y = 0;

                $(this).stop().animate({
                    backgroundPositionX: x + '%',
                    backgroundPositionY: y + '%'
                }, time, 'linear');
            }).mouseleave(function () {
                $(this).stop().animate({
                    backgroundPositionX: x0 + '%',
                    backgroundPositionY: y0 + '%',
                }, time);
            });

        },

        // header functions
        // menu modules
        secondaryMenu: function () {

            var secondaryShown = false;

            $(document)
                .on('click', '.et-secondary-visibility-on_click .secondary-title', function () {
                    secondaryShowHide();
                })
                .on('mouseover', '.et-secondary-visibility-on_hover.et-secondary-darkerning-on .secondary-menu-wrapper', function () {
                    secondaryShow();
                })
                .on('mouseleave', '.et-secondary-visibility-on_hover.et-secondary-darkerning-on .secondary-menu-wrapper', function () {
                    secondaryHide();
                })
                .on('click touchstart', function (event) {
                    if (!$(event.target).closest('.secondary-menu-wrapper').length) {
                        if (secondaryShown) {
                            $('body').removeClass('et-secondary-shown');
                        }
                    }
                })
                .on('click', '.secondary-menu-wrapper .show-more', function() {
                    $(this).prevAll('li.hidden').removeClass('hidden');
                    $(this).remove();
                });

            var secondaryShowHide = function () {
                    if (secondaryShown) {
                        secondaryHide();
                    } else {
                        secondaryShow();
                    }
                },

                secondaryShow = function () {
                    $('body').addClass('et-secondary-shown');
                    secondaryShown = true;
                },

                secondaryHide = function () {
                    $('body').removeClass('et-secondary-shown');
                    secondaryShown = false;
                };

        },

        onePageMenu: function () {
            // **********************************************************************//
            // ! One page hash navigation
            // **********************************************************************//

            // Click on menu item with hash
            $(document).on('click', '.one-page-menu a', function (e) {
                if ($(this).attr('href').split('#')[0] == window.location.href.split('#')[0]) {
                    e.preventDefault();
                    var hash = $(this).attr('href').split('#')[1];
                    changeActiveItem(hash);
                    scrollToId(hash);
                }

                if (et_global['mob_menu_opened']) {
                    $('body').removeClass('mobile-menu-opened').addClass('mobile-menu-closed');
                    et_global['mob_menu_opened'] = false;
                }

                // for core plugin header builder
                if ($('.et-popup-wrapper.mobile-menu-popup').length) {
                    $('.et-popup-wrapper').remove();
                    $('html').removeClass('et-overflow-hidden');
                }

                if ($('.et_b_header-mobile-menu .et-mini-content.active').length) {
                    $('.et_b_header-mobile-menu .et-mini-content.active').removeClass('active');
                    $('.et_b_header-mobile-menu.et-content-shown').removeClass('et-content-shown');
                    setTimeout(function () {
                        $('html').removeClass('et-overflow-hidden');
                    }, 700);
                }
            });

            $('[data-scroll-to]').click(function () {
                var hash = $(this).attr('data-scroll-to');
                changeActiveItem(hash);
                scrollToId(hash);
            });

            // if loaded page with hash
            var windowHash = window.location.hash.split('#')[1];

            if (window.location.hash.length > 1) {
                setTimeout(function () {
                    scrollToId(windowHash);
                }, 600);
            }

            function scrollToId(id) {
                var offset = (et_global['fixed_header']) ? 65 : 0; // 130
                var position = 0;
                if (id != 'top') {
                    if ($('#' + id).length < 1) {
                        return;
                    }
                    position = $('#' + id).offset().top - offset;


                }

                if (et_global['w_width'] < 992) {
                    $('body').removeClass('show-nav');
                }

                $('html, body').stop().animate({
                    scrollTop: position
                }, 1000, function () {
                    changeActiveItem(id);
                });
            }

            function changeActiveItem(hash) {
                var itemId;
                var menu = $('.menu');
                if (!menu.parent().hasClass('one-page-menu')) return;

                menu.find('.current-menu-item').removeClass('current-menu-item');

                if (hash == 'top') {
                    menu.each(function () {
                        $(this).find('li').first().addClass('current-menu-item');
                    });
                    return;
                }

                menu.find('li').each(function () {
                    if ($(this).find('>a').attr('href')) {
                        var thisHash = $(this).find('>a').attr('href').split('#')[1];
                        if (thisHash == hash) {
                            itemId = $(this).attr('id');
                        }
                    }
                });

                $('.' + itemId).addClass('current-menu-item');
            }


            $(window).scroll(function () {
                if ($(window).scrollTop() < 200) {
                    changeActiveItem('top');
                }
            });
            changeActiveItem('top');

            if (etConfig.builders.is_wpbakery) {
                // change active link on scroll
                $('.vc_row[id]').waypoint(function () {
                    var id = $(this).attr('id');
                    changeActiveItem(id);
                }, {offset: 150});
            }

        },

        menuPosts: function () {
            var widget = $('.posts-subcategories'),
                nav = widget.find('.subcategories-tabs'),
                content = widget.find('.posts-content'),
                ajaxProcess = false,
                activeClass = 'active';

            nav.on('click', 'li', function () {
                if (ajaxProcess || $(this).hasClass(activeClass)) return;

                ajaxProcess = true;
                widget.addClass('loading-posts');
                var cat = $(this).data('cat'),
                    _this = $(this);

                $.ajax({
                    url: etConfig.ajaxurl,
                    type: 'GET',
                    dataType: 'html',
                    cache: true,
                    data: {action: 'menu_posts', cat: cat},
                    success: function (data) {
                        content.html(data);
                    },
                    complete: function () {
                        widget.removeClass('loading-posts');
                        nav.find('li').removeClass(activeClass);
                        $(_this).addClass(activeClass);
                        ajaxProcess = false;
                    },
                    error: function () {
                        etTheme.et_notice('menu', 'error');
                    }
                });
            });
        },

        // header global function
        mainNavigation: function () {
            // **********************************************************************//
            // ! Main Navigation plugin
            // **********************************************************************//
            $.fn.et_menu = function (options) {
                var methods = {
                    init: function (el) {
                        methods.el = el;

                        var vertical_fixed = $('body').hasClass('et-vertical-fixed');

                        if (!etConfig['layoutSettings']['is_header_builder'] && et_global['w_width'] <= 1024) {
                            methods.responsive();
                        }

                        if (et_global['w_width'] <= 1440) {
                            methods.TouchHoverDropdown();
                        }

                        if (et_global['w_width'] >= 993) {
                            methods.openByClick();
                        }

                        $(window).resize(function () {
                            if (!vertical_fixed || $('.et_b_header-menu').length > 0) methods.setOffsets();
                            if (!etConfig['layoutSettings']['is_header_builder'])
                                methods.sideMenu();
                        });

                        if (!vertical_fixed || $('.et_b_header-menu').length > 0) methods.setOffsets();
                        // methods.alignLeft();

                        el.find('a').has('.nav-item-tooltip').hover(function () {
                            var newContent = '',
                                tooltip = $(this).find('.nav-item-tooltip'),
                                src = tooltip.find('>div').first().attr('data-src');
                            if (src.length > 10) {
                                newContent = '<img src="' + src + '" />';
                                tooltip.html(newContent);
                            }
                        });

                    },
                    responsive: function () {
                        $('.header-wrapper .menu-main-container li a').on('click', function (e) {
                            if (!$(this).parent('li').hasClass('menu-item-has-children')) return;
                            if (!$(this).is('[q]')) {
                                $(this).attr('q', 0);
                            }
                            var q = $(this).attr('q');
                            if (q < 1) {
                                q++;
                                $(this).attr('q', q);
                                e.preventDefault();
                            }
                        });
                    },
                    setOffsets: function () {

                        methods.el.find('.item-design-mega-menu > .nav-sublist-dropdown, .item-design-posts-subcategories > .nav-sublist-dropdown').each(function () {

                            if ($('body').hasClass('mega-menus-full-width') && $(this).parent().hasClass('item-design-mega-menu')) {
                                return;
                            }

                            var boxed = $.inArray(etConfig.layoutSettings.layout, ['boxed', 'framed']) > -1,
                                extraBoxedOffset = (boxed) ? $('.page-wrapper').offset().left : 0;

                            var li = $(this).parent(),
                                liOffset = li.offset().left - extraBoxedOffset,
                                liOffsetTop = li.offset().top,
                                liWidth = $(this).parent().width(),
                                dropdowntMarginLeft = liWidth / 2,
                                dropdownWidth = $(this).outerWidth(),
                                dropdowntLeft = liOffset - dropdownWidth / 2,
                                dropdownBottom = liOffsetTop - $(window).scrollTop() + $(this).outerHeight(),
                                left = 0,
                                fitHeight = false;

                            if (dropdowntLeft < 0) {
                                left = liOffset - 10;
                                dropdowntMarginLeft = 0;
                            } else {
                                left = dropdownWidth / 2;
                            }

                            if (etConfig.layoutSettings.is_rtl) {
                                $(this).css({
                                    'right': -left,
                                    'marginLeft': dropdowntMarginLeft
                                });
                            } else {
                                $(this).css({
                                    'left': -left,
                                    'marginLeft': dropdowntMarginLeft
                                });
                            }

                            var dropdownRight = (et_global['w_width'] - extraBoxedOffset * 2) - (liOffset - left + dropdownWidth + dropdowntMarginLeft);

                            if (dropdownRight < 0) {
                                $(this).css({
                                    'left': 'auto',
                                    'right': -(et_global['w_width'] - liOffset - liWidth - 10) + extraBoxedOffset * 2
                                });
                            }

                            if (fitHeight && dropdownBottom > et_global['w_height']) {
                                $(this).css({
                                    'top': 'auto',
                                    'bottom': -(et_global['w_height'] - (liOffsetTop - $(window).scrollTop() + li.outerHeight())) + 15
                                });
                            }

                        });

                    },

                    openByClick: function () {

                        var singleClickTimer = 0; //define a var to hold timer event in parent scope
                        methods.el.find('.menu-item-has-children.menu-open-by-click > a').click(function (e) { //using jquery click handler
                            e.preventDefault();
                            var parent = $(this).parent();
                            if (e.detail == 1) { //ensure this is the first click
                                singleClickTimer = setTimeout(function () { //create a timer
                                    parent.toggleClass('opened'); //run your single click code
                                }, 250); //250 or 1/4th second is about right to know that check if sublist is opened or closed
                            }
                        })

                            .dblclick(function (e) { //using jquery dblclick handler
                                e.preventDefault();
                                clearTimeout(singleClickTimer); //cancel the single click
                                window.location = $(this).attr('href'); //run your double click code
                            });

                    },

                    sideMenu: function () {
                        if (et_global['w_height'] < 800) {
                            $('.header-wrapper').addClass('header-scrolling');
                        } else {
                            $('.header-wrapper').removeClass('header-scrolling');
                        }
                    },

                    TouchHoverDropdown: function () {
                        if (et_global['w_width'] < 992) return;
                        var times = 0,
                            isTouch = ('ontouchstart' in document.documentElement);
                        if (isTouch) {
                            $('.menu-item-has-children a').click(function (e) {
                                if (times == 0) {
                                    e.preventDefault();
                                    times = 1;
                                } else {
                                    $('.menu-item-has-children a').dblclick(function () {
                                        window.location = $(this).attr('href');
                                    });
                                }
                            });
                        }
                    }
                };

                methods.init(this);

                return this;
            };

            // First Type of column Menu
            $('.menu-main-container .menu:not(.header-type-vertical .menu, .header-type-vertical2 .menu), .et_b_header-menu .menu').et_menu({
                type: "default"
            });

        },

        // old header functions
        navMenuSmart: function () {
            if ($.inArray(etConfig['layoutSettings']['header_type'], ['vertical', 'vertical2', 'hamburger-icon']) > -1)
                return;

            if (window.innerWidth > 991 && ($('body').hasClass('header-smart-responsive'))) {
                $('.menu-wrapper > .menu-main-container .menu').append('<li class="more menu-more item-design-dropdown"><div class="menu-more-toggle"><span></span></div><div class="nav-sublist-dropdown"><div class="container"><ul></ul></div></div></li>');
                $('.header-wrapper').addClass('header-resizing');
                et_global['header_resizing'] = true;
                $(document).on('click', '.menu-more', function () {
                    if ($(this).hasClass('opened')) {
                        $(this).removeClass('opened');
                    } else {
                        $(this).addClass('opened');
                    }
                });
                var calcWidth = function () {
                    if (window.innerWidth < 993) return;
                    // Prefix '_f' for fixed headers
                    var fixed_check = false,
                        double_header = false,
                        secondaryMenu = false,
                        items_f,
                        availablespace_h;

                    var menu_wrapper = $('.header-wrapper .menu-wrapper');

                    var each_item_of = $(menu_wrapper).find(' .menu > .menu-item');
                    if ($.inArray(etConfig['layoutSettings']['fixed_header_type'], ['fixed', 'sticky']) > -1) {
                        fixed_check = true;
                        each_item_of = $('.header-wrapper .menu-wrapper .menu > .menu-item, .fixed-header .menu-wrapper .menu > .menu-item');
                    }

                    if ($('body').hasClass('et-secondary-menu-on')) {
                        secondaryMenu = true;
                    }

                    $(each_item_of).each(function () {
                        $(this).attr('data-width', $(this).outerWidth(true));
                    });

                    var morewidth_f = $('.fixed-header .menu-wrapper .menu .more').outerWidth(true);
                    var morewidth = $(menu_wrapper).find(' .menu .more').outerWidth(true);
                    var extra_space = morewidth,
                        extra_space_f = morewidth_f;

                    // Save the origin size of toggle into the attribute just one time
                    $(document).one('ready', function () {
                        $('.header-wrapper .menu-main-container .menu .more').attr('data-width', morewidth);
                        if (fixed_check) {
                            $('.fixed-header .menu-main-container .menu .more').attr('data-width', morewidth_f);
                        }
                    });

                    //var availablespace = $('nav').outerWidth(true) - morewidth;
                    var extra_space = $(menu_wrapper).find(' .menu .more').attr('data-width'),
                        extra_space_f = $('.fixed-header .menu-main-container .menu .more').attr('data-width'),
                        availablespace_h = $('.header-wrapper .menu-wrapper > .menu-main-container').outerWidth(true) - extra_space * 1.5;

                    if (etConfig['layoutSettings']['header_type'] == 'xstore') {
                        availablespace_h = availablespace_h - extra_space / 2; // only for these header types
                    } else if (etConfig['layoutSettings']['header_type'] == 'double-menu') {

                        double_header = true;
                        availablespace_h = [];
                        var i = 0;
                        $(menu_wrapper).each(function () {
                            availablespace_h.push($(this).outerWidth(true) - extra_space * 1.5);
                            i += 1;
                        });

                        var children_width = 0;
                        $('.menu-wrapper:eq(' + i + ')').next('.navbar-header').children().each(function () {
                            children_width += $(this).outerWidth(true);
                        });

                        availablespace_h[availablespace_h.length - 1] = $('.menu-wrapper:eq(' + i + ')').outerWidth(true) - Math.ceil(children_width) - extra_space * 1.5;

                    } else if (etConfig['layoutSettings']['header_type'] == 'advanced' && secondaryMenu) {
                        availablespace_h = $('.header-wrapper .menu-inner').outerWidth(true) - $(menu_wrapper).prevAll().outerWidth(true) - extra_space * 2;
                    } else if ($.inArray(etConfig['layoutSettings']['header_type'], ['center3', 'standard']) > -1 && secondaryMenu) {
                        availablespace_h = $('.header-wrapper .menu-inner').outerWidth(true) - $(menu_wrapper).find('> .menu-main-container').prevAll().outerWidth(true) - $(menu_wrapper).nextAll().outerWidth(true) - extra_space * 2;
                    } else if ($.inArray(etConfig['layoutSettings']['header_type'], ['center3', 'standard', 'advanced']) > -1) {
                        availablespace_h = $('.header-wrapper .menu-inner').outerWidth(true) - $(menu_wrapper).nextAll().outerWidth(true) - extra_space * 2;
                    }

                    if (availablespace_h < 0) {
                        return;
                    }

                    /* check the length of all items */
                    function et_checking_h() {
                        var navwidth = 0;

                        if (double_header) {

                            var i = 0;
                            var array = [];

                            // For multiple menu in header let's count the width of each one
                            $(menu_wrapper).each(function () {
                                var navwidth = 0;
                                $(this).find('.menu > .menu-item').each(function () {
                                    navwidth += $(this).data('width');
                                });
                                array.push(navwidth);
                                i += 1;
                            });
                            navwidth = array;

                        } else {
                            $(menu_wrapper).find('> .menu-main-container .menu > .menu-item').each(function () {
                                navwidth += $(this).data('width');
                            });
                        }
                        return navwidth;
                    }

                    /* remove item and place in submenu if their width is more than available*/
                    function et_removing_h() {
                        var navwidth = et_checking_h();
                        // if ( navwidth < 0 ) { return; }

                        if ($.isArray(navwidth)) {
                            var i = 0; // for array
                            var j = 1; // for menu number
                            $($(menu_wrapper)).each(function () {

                                // Remove items in each menu of header and add on resize if there is enought space
                                function et_multiple_removing() {
                                    navwidth = et_checking_h();
                                    if (navwidth[i] > availablespace_h[i] || navwidth[i] == availablespace_h[i]) {
                                        var lastitem = $('.menu-wrapper:eq(' + (j) + ') > .menu-main-container .menu > .menu-item').last();
                                        lastitem.prependTo($('.menu-wrapper:eq(' + (j) + ') > .menu-main-container .menu .more ul').first());
                                        et_multiple_removing();
                                    } else {
                                        var firstItem = $('.menu-wrapper:eq(' + (j) + ') > .menu-main-container .menu .more ul').first().find('.menu-item').first();
                                        var firstItemWidth = firstItem.data('width');
                                        if ((navwidth[i] + firstItemWidth) < availablespace_h[i]) {
                                            firstItem.insertBefore($('.menu-wrapper:eq(' + (j) + ') > .menu-main-container .menu .more'));
                                        }
                                    }
                                }

                                et_multiple_removing();
                                i += 1;
                                j += 1;
                            });
                        } else {
                            if (navwidth > availablespace_h || navwidth == availablespace_h) {
                                var lastitem = $(menu_wrapper).find('.menu > .menu-item').last();
                                lastitem.prependTo($(menu_wrapper).find('.menu .more ul').first());
                                et_removing_h();
                            } else {
                                var firstItem = $(menu_wrapper).find('.menu .more ul').first().find('.menu-item').first();
                                var firstItemWidth = firstItem.data('width');
                                if ((navwidth + firstItemWidth) < availablespace_h) {
                                    firstItem.insertBefore($('.header-wrapper .menu .more'));
                                }
                            }
                        }
                    }

                    et_removing_h();
                    if (fixed_check) {
                        var availablespace_f = $('.fixed-header .menu-wrapper > .menu-main-container').outerWidth(true) - extra_space_f * 2; // extra space ( morewidth_f * 2), because sometimes there is enought space but toggle jumps down ( because of padd )
                        if (double_header) {
                            var availablespace_f = $('.fixed-header .menu-wrapper').outerWidth(true) - extra_space_f * 2;
                            var toggle_check = $('.fixed-header').find('.menu-main-container:eq(1)').find('.more ul .menu-item').length;
                            availablespace_f = availablespace_f - extra_space_f / 2;
                            if (toggle_check < 0 || toggle_check == 0) {
                                $('.fixed-header').find('.menu-main-container:eq(1)').find('.more').remove();
                            }
                        }
                        var et_checking_f = function () {
                            var navwidth = 0;
                            $('.fixed-header .menu-wrapper > .menu-main-container .menu > .menu-item').each(function () {
                                navwidth += $(this).outerWidth(true);
                            });
                            return navwidth;
                        }
                        var et_removing_f = function () {
                            var navwidth = et_checking_f();
                            if (navwidth < 0) {
                                return;
                            }
                            if (navwidth > availablespace_f || navwidth == availablespace_f) {
                                var lastitem = $('.fixed-header .menu-wrapper .menu > .menu-item').last();
                                lastitem.prependTo($('.fixed-header .menu-wrapper .menu .more ul').first());
                                et_removing_f();
                            } else {
                                var firstItem = $('.fixed-header .menu-wrapper .menu .more ul').first().find('.menu-item').first();
                                var firstItemWidth = firstItem.data('width');
                                if ((navwidth + firstItemWidth) < availablespace_f) {
                                    firstItem.insertBefore($('.fixed-header .menu .more'));
                                }
                            }
                        }
                        et_removing_f();

                        header_toggle('.fixed-header .menu-wrapper .menu .more');
                    }

                    // header_toggle - remove or show more toggle

                    function header_toggle(header) {
                        if ($(header).find('ul .menu-item').length > 0) {
                            if ($(header).hasClass('hidden')) {
                                $(header).removeClass('hidden');
                            }
                        } else {
                            if ($(header).hasClass('hidden') === false) {
                                $(header).addClass('hidden');
                            }
                        }
                    }

                    // if double header let's check each menu for overcount items in it

                    if (double_header) {
                        var i = 0;
                        $.each($(menu_wrapper), function () {
                            header_toggle($('.header-wrapper .menu-wrapper:eq(' + i + ')').find('.menu .more'));
                            i += 1;
                        });
                    } else {
                        header_toggle('.header-wrapper .menu-wrapper .menu .more');
                    }
                }
                // end calcWidth

                $(window).on('load resize', function () {
                    var header_wrap = $('.header-wrapper');
                    var s_height = $(header_wrap).height();
                    if (et_global['header_resizing']) {
                        if (header_wrap.attr('data-height')) {
                            calcWidth();
                            var e_height = header_wrap.height();
                            header_wrap.css('height', header_wrap.attr('data-height'));
                            // if ( header_wrap.attr('data-end-height') ) {
                            // header_wrap.animate({
                            //     height: header_wrap.attr('data-end-height')
                            // }, 300);
                            // header_wrap.removeAttr('data-height').removeAttr('data-end-height');
                            // setTimeout(function(){
                            //     header_wrap.removeClass('header-resizing').attr('style', '');
                            //     et_global['header_resizing'] = false;
                            // }, 1500);
                            // }
                            // else {
                            // header_wrap.attr('data-end-height', e_height);
                            header_wrap.animate({
                                height: e_height
                            }, 300);
                            header_wrap.removeAttr('data-height');
                            setTimeout(function () {
                                header_wrap.removeClass('header-resizing').attr('style', '').addClass('header-resized');
                                et_global['header_resizing'] = false;
                            }, 1500);
                            // }
                        } else {
                            header_wrap.attr('data-height', s_height);
                            calcWidth();
                        }
                    } else {
                        calcWidth();
                    }

                });
            } // end check for window width
        },

        // footer
        fixedFooter: function () {
            if (!$('body').hasClass('et-footer-fixed-on')) return;
            var footer = $('.et-footers-wrapper'),
                pageWrapper = $('.page-wrapper');

            pageWrapper.css('marginBottom', footer.outerHeight());
            $(window).resize(function () {
                pageWrapper.css('marginBottom', footer.outerHeight());
            });
        },

        // modules
        blogIsotope: function () {

            if (!et_global['is_masonry']) return;

            $(window).load(function () {
                var $blog = $('.blog-masonry');

                if ($blog.find('.post-grid').length < 1) return;

                $blog.each(function () {

                    var $grid = $(this).isotope({
                        isOriginLeft: !etConfig.layoutSettings.is_rtl,
                        itemSelector: '.post-grid'
                    });

                    // layout Isotope after each image loads
                    // $grid.imagesLoaded().progress( function() {
                    $grid.isotope('layout');
                    // });

                });
            });
        },

        isotope: function () {

            if (!et_global['is_masonry']) return;

            $(window).load(function () {
                var $isotope = $('.et-isotope');

                $isotope.each(function () {

                    var $grid = $(this).isotope({
                        itemSelector: '.et-isotope-item',
                        isOriginLeft: !etConfig.layoutSettings.is_rtl,
                        masonry: {
                            columnWidth: '.grid-sizer'
                        }
                    });

                    // layout Isotope after each image loads
                    // $grid.imagesLoaded().progress( function() {
                    $grid.isotope('layout').trigger('layout-changed');
                    // });

                });
            });

        },

        isotopeFilters: function () {

            if (!et_global['is_masonry']) return;

            $(window).load(function () {
                var etMasonryFilters = $('.et-masonry-filters');

                etMasonryFilters.each(function () {

                    var $grid = $(this);

                    $grid.parent().find('.et-masonry-filters-list a').click(
                        function (e) {
                            e.preventDefault();
                            $(this).parents('.et-masonry-filters-list').find('.active').removeClass('active');
                            $(this).addClass('active');
                            if (et_global['is_masonry']) {
                                $grid.isotope({filter: $(this).data('filter')});
                                $grid.isotope('layout');
                            }
                        });
                });

                setTimeout(function () {
                    $('.et-masonry-filters, .et-masonry-item').addClass('with-transition');
                    $(window).resize();
                }, 500);
            });
        },

        backToTop: function () {
            // **********************************************************************//
            // ! "Top" button
            // **********************************************************************//

            var displayed = false,
                $message = $('.back-top');

            $(window).scroll(function () {
                if ($(window).scrollTop() <= 0) {
                    displayed = false;
                    $message.addClass('backOut').removeClass('backIn');
                } else if (displayed == false) {
                    displayed = true;
                    $message.stop(true, true).removeClass('backOut').addClass('backIn').click(function () {
                        $message.addClass('backOut').removeClass('backIn');
                    });
                }
            });

            $message.click(function (e) {
                $('html, body').animate({scrollTop: 0}, 600);
                return false;
            });
        },

        tabs: function () {
            // **********************************************************************//
            // ! Tabs
            // **********************************************************************//

            var tabs = $('.tabs');
            $('.tabs > p > a').unwrap('p');

            var leftTabs = $('.left-bar, .right-bar');
            var newTitles;
            var time = 50;

            leftTabs.each(function () {

                var $this = $(this);

                newTitles = $this.find('.tabs-nav').clone();

                newTitles.removeClass('tabs-nav').find('a').addClass('tab-title-left');

                newTitles.first().addClass('opened');

                var tabNewTitles = $('<div class="left-titles"></div>').prependTo($this);
                tabNewTitles.html(newTitles);

                $this.find('.tab-content').css({
                    'minHeight': tabNewTitles.height()
                });
            });


            tabs.each(function () {
                var $this = $(this);
                var href = [];
                var id = '';
                var tab_closed = ($this.find('.tab-title').first().parent().hasClass('tab_closed') != true);

                if ($('.tabs').find('.swiper-container').length) {
                    swipers['swiper-' + tabs.first('.et-tab').find('.swiper-container').attr('id')].init();
                    swipers['swiper-' + tabs.first('.et-tab').find('.swiper-container').attr('id')].update();
                    $this.find('.tab-title').on('click', function () {
                        swipers['swiper-' + tabs.first('.et-tab').find('.swiper-container').attr('id')].init();
                        swipers['swiper-' + tabs.first('.et-tab').find('.swiper-container').attr('id')].update();

                    });
                }

                if (tabs.hasClass('accordion') || tabs.hasClass('left-bar')) {
                    $this.find('.tabs-nav').remove();
                    if (tab_closed) {
                        $this.find('.accordion-title').first().addClass('opened-parent');
                    }
                }

                $.each($this.find('.tab-title'), function (i, val) {
                    href[i] = val.href;
                });

                if ($.inArray(document.URL, href) != -1) {
                    id = document.URL.split('#');
                    $('#' + id[1]).addClass('opened').parent().addClass('et-opened');
                    $this.find('.accordion-title').first().addClass('opened');
                    $this.addClass('tabs-ready');
                    $this.find('#content_' + id[1] + '.et-tab').show();
                } else {
                    if (tab_closed) {
                        $this.find('.tab-title').first().addClass('opened').parent().addClass('et-opened');
                        $this.find('.accordion-title').first().addClass('opened');
                        $this.find('.et-tab').first().show();
                    }
                    $this.addClass('tabs-ready');
                }


                // fast fix tabs asap
                if (et_global['w_width'] < 993) {
                    $this.on('click', '.tab-contents .accordion-title', function (e) {
                        e.preventDefault();

                        //if ( $this.parents( '.woocommerce-tabs' ).length > 0 ) return;
                        var tabId = $(this).attr('data-id');

                        if (tabOpened(tabId)) {
                            closeTab($this, tabId, false);
                        } else {
                            var reopen = ($(this).parents('.tabs').first().find('.et-tabs-wrapper').length > 0) ? tabReopen($(this)) : '';

                            closeAllTabs($this, $(this));
                            setTimeout(function () {
                                if ($this.parent().hasClass('tab_closed')) {
                                    $this.parent().removeClass('tab_closed');
                                } else {
                                    openTab($this, tabId);
                                    setTimeout(function () {
                                        scrollToId(tabId);
                                    }, time + 150);
                                    if (reopen != '') {
                                        openTab($this, reopen);
                                        setTimeout(function () {
                                            scrollToId(tabId);
                                        }, time + 150);
                                    }
                                }
                            }, time);
                        }
                    });
                    var scrollToId = function (id) {
                        var offset = ($('.fixed-header').length > 0) ? $('.fixed-header').outerHeight() : 0,
                            position = 0;

                        position = $('[data-id=' + id + ']').offset().top - offset;

                        $('html, body').animate({
                            scrollTop: position
                        }, 1000);
                    }
                }


                if ($this.hasClass('accordion')) {
                    $this.on('click', '.accordion-title', function (e) {
                        e.preventDefault();
                        if ($this.parents('.woocommerce-tabs').length > 0) return;
                        var tabId = $(this).find('.tab-title').attr('id');

                        if (tabOpened(tabId)) {
                            closeTab($this, tabId, false);
                        } else {
                            var reopen = ($(this).parents('.tabs').first().find('.et-tabs-wrapper').length > 0) ? tabReopen($(this)) : '';

                            closeAllTabs($this, $(this));
                            setTimeout(function () {
                                if ($this.parent().hasClass('tab_closed')) {
                                    $this.parent().removeClass('tab_closed');
                                } else {
                                    openTab($this, tabId);
                                    if (reopen != '') openTab($this, reopen);
                                    if ($this.parents('.fixed-content').length > 0) {
                                    } else scrollToId(tabId);
                                }
                            }, time + 500);
                        }

                        function scrollToId(id) {
                            var offset = ($('.fixed-header').length > 0) ? $('.fixed-header').outerHeight() : 0,
                                position = 0;

                            position = $('#' + id).offset().top - offset;

                            $('html, body').animate({
                                scrollTop: position
                            }, 1000);
                        }
                    });
                } else {
                    $this.on('click', '.tab-title, .tab-title-left', function (e) {
                        e.preventDefault();
                        var tabId = $(this).attr('id');

                        if (tabOpened(tabId)) {
                            //closeTab($this, tabId, false);
                        } else {
                            var reopen = ($(this).parents('.tabs').first().find('.et-tabs-wrapper').length > 0) ? tabReopen($(this)) : '';

                            closeAllTabs($this, $(this));
                            setTimeout(function () {
                                if ($this.parent().hasClass('tab_closed')) {
                                    $this.parent().removeClass('tab_closed');
                                } else {
                                    openTab($this, tabId);
                                    if (reopen != '') openTab($this, reopen);
                                }

                                // Init slider inside etheme tabs
                                var content = $('#content_' + tabId);
                                if (content.find('.swiper-container').length > 0) {
                                    var slide_id = content.find('.swiper-container').attr('id');
                                    swipers['swiper-' + slide_id].init();
                                    swipers['swiper-' + slide_id].update();
                                }
                            }, time);

                            // if ( $(this).parent().hasClass( 'accordion-title' ) ) {
                            //     setTimeout(function() {
                            //        scrollToId(tabId);
                            //     }, time + 150 );
                            // };
                        }
                    });
                }

            });

            var tabReopen = function (tab) {
                var reopen = '';
                tab.parents('.tabs').first().find('.et-tabs-wrapper .tab-title, .et-tabs-wrapper .tab-title-left').each(function () {
                    if ($(this).hasClass('opened')) {
                        reopen = $(this).attr('id');
                    }

                });
                return reopen;
            };

            var tabOpened = function (id) {
                return $('#' + id).hasClass('opened');
            };

            var openTab = function (tabs, id) {
                if (tabs.hasClass('accordion') || (et_global['w_width'] < 767 && !tabs.hasClass('products-tabs'))) {
                    $('#' + id).parent().addClass('opened-parent');
                    $('#content_' + id).slideDown(300); // Fix it
                } else {
                    $('#content_' + id).fadeIn(100);
                }

                $('#' + id).addClass('opened').parent().addClass('et-opened');
                $('[data-id="' + id + '"]').addClass('opened');

                if ($('.tabs').find('.swiper-container').length) {
                    swipers['swiper-' + $('#content_' + id).find('.swiper-container').attr('id')].init();
                }

                setTimeout(function () {
                    $(window).resize();
                    var content = $('#content_' + id);
                    if (content.find('.swiper-container').length > 0) {
                        var slide_id = content.find('.swiper-container').attr('id');
                        swipers['swiper-' + slide_id].init();
                        swipers['swiper-' + slide_id].update();
                    }
                }, 100);
            };

            var closeTab = function (tabs, id, forceClose) {
                if (tabs.hasClass('accordion') || (et_global['w_width'] < 767 && !tabs.hasClass('products-tabs'))) {
                    $('#' + id).removeClass('opened').parent().removeClass('et-opened').removeClass('opened-parent');
                    // $('#' + id).parent().removeClass('opened-parent');
                    $('[data-id="' + id + '"]').removeClass('opened');
                    $('#content_' + id).slideUp(300);
                } else if (forceClose) {
                    $('#' + id).removeClass('opened').parent().removeClass('et-opened');
                    $('[data-id="' + id + '"]').removeClass('opened');
                    $('#content_' + id).fadeOut(100);
                }

            };

            var closeAllTabs = function (tabs, curretTab) {
                curretTab.parents('.tabs').first().find('.tab-title, .tab-title-left').each(function () {
                    var tabId = $(this).attr('id');
                    if (tabOpened(tabId)) {
                        closeTab(tabs, tabId, true);
                    }
                });
            };

            // $('.tabs-with-scroll .tab-content-inner').nanoScroller({
            //     contentClass: 'tab-content-scroll',
            //     preventPageScrolling: true
            // });
        },

        /**
         * Global image lazy
         *
         * @version 1.0.0
         * @since 6.2.4
         */
        global_image_lazy: function () {
            // alert('global image');
            $.each($(document).find('.lazyload:not(.swiper-lazy, .zoomImg)'), function () {
                var img = $(this),
                    src = img.attr('data-src'),
                    srcset = img.attr('data-srcset');

                if (img.attr('data-l-src')) {
                    src = img.attr('data-l-src');
                }

                if (img.attr('data-lazy_timeout')) {
                    setTimeout(function () {
                        img.attr({
                            'src': src,
                            'srcset': srcset
                        }).removeAttr('data-src data-srcset').removeClass('lazyload').addClass('lazyloaded');
                    }, img.attr('data-lazy_timeout'));
                } else {
                    // img.attr( { 'src': src, 'srcset': srcset } ).removeAttr( 'data-src data-srcset' ).removeClass( 'lazyload' ).addClass('lazyloaded');
                    if (img.parents('.wpb_content_element').hasClass('wpb_images_carousel')) {
                        img.attr({'src': src}).removeClass('lazyload').addClass('lazyloaded');
                    } else {
                        img.attr({'src': src, 'srcset': srcset}).removeClass('lazyload').addClass('lazyloaded');
                    }
                }
            });
        },// End of global_image_lazy

        PostProductAjaxLoad: function () {
            // ! Loading for blog VC elements pagination
            $('body')
                .on('click', '.et-blog .etheme-pagination a', function (e) {
                    e.preventDefault();
                    var $this = $(this),
                        url_string = $(this).attr('href'),
                        url = new URL(url_string),
                        paged = url.searchParams.get("et-paged"),
                        data = $this.parents('.et-blog').find('.et-load-blog .et-element-args').text(),
                        element = $this.parents('.et-blog').find('.et-load-blog .et-element-args').attr('data-element'),
                        args = JSON.parse(data),
                        top_offset = $this.parents('.et-blog').offset().top;

                    if ($(document).find('.fixed-header').length) {
                        top_offset -= $(document).find('.fixed-header').outerHeight(true);
                    }

                    $.ajax({
                        url: etConfig.ajaxurl,
                        method: 'POST',
                        data: {
                            'action': 'et_ajax_blog_element',
                            'args': args,
                            'element': element,
                            'paged': paged,
                        },
                        dataType: 'html',
                        success: function (respond) {
                            $this.parents('.et-blog').html(respond);
                        },
                        complete: function () {
                            $('html, body').animate({
                                scrollTop: top_offset
                            }, 1000);
                            etTheme.global_image_lazy();
                        },
                        error: function (data) {
                            etTheme.et_notice('post-product', 'error');
                        },
                    });
                })
                // ! Loading for post button
                .on('click', '.et_load-posts a', function (e) {
                    e.preventDefault();

                    if ($(this).hasClass('loading')) return;

                    $(this).addClass('loading');

                    var url = $(this).attr('href');

                    if ($(this).length > 0) {
                        et_load_posts(url);
                    }
                })
                // ! Loading for product button
                .on('click', '.et_load-products a', function (e) {
                    e.preventDefault();
                    load_products($(this));
                });

            // ! Lazy(scroll) loading for post/products
            // if ( $('.et_load-products').hasClass( 'lazy-loading' ) ) {
            //     var load_btn = $('.et_load-products');
            //     loading_by_scroll(load_btn);
            // } else if( $('.et_load-posts').hasClass( 'lazy-loading' ) ){
            //     var load_btn = $('.et_load-posts');
            //     loading_by_scroll(load_btn);
            // };
            $('.lazy-loading').each(function () {
                if ($(this).hasClass('et_load-products')) {
                    var load_btn = $(this);
                    loading_by_scroll(load_btn);
                } else if ($(this).hasClass('et_load-posts')) {
                    var load_btn = $(this);
                    loading_by_scroll(load_btn);
                }
            });


            function loading_by_scroll(load_btn) {
                $(window).scroll(function () {
                    if (load_btn.length < 1) return;

                    if (load_btn.parents().hasClass('vc_tta-panel') && !load_btn.parents('.vc_tta-panel').hasClass('vc_active')) {
                        return;
                    }

                    var btn_top = load_btn.offset().top,
                        btn_height = load_btn.outerHeight(),
                        window_scroll = $(this).scrollTop();

                    if (window_scroll < (btn_top + btn_height - et_global['w_height'])) return;
                    if (!load_btn) return;
                    if (load_btn.hasClass('loading')) return;

                    load_btn.addClass('loading');

                    if (load_btn.hasClass('et_load-posts')) {
                        var url = load_btn.find('a').attr('href');
                        et_load_posts(url);
                    } else {
                        load_products(load_btn.find('a'));
                    }
                });
            }

            function load_products(btn) {
                var parent = btn.parents('.etheme_products'),
                    paged = btn.attr('paged'),
                    max_paged = btn.attr('max-paged');

                //btn.addClass( 'hidden' );
                //parent.find( '.et-loader' ).removeClass( 'hidden' );
                parent.find('.et-load-block').addClass('loading');
                paged = parseInt(paged);

                if (paged >= max_paged) return;

                paged = paged + 1;

                var attr = {
                    'paged': paged,
                    'per-page': parent.attr('per-page'),
                    'columns': parent.attr('columns'),
                    'ids': parent.attr('ids'),
                    'orderby': parent.attr('orderby'),
                    'order': parent.attr('order'),
                    'stock': parent.attr('stock'),
                    'type': parent.attr('type'),
                    'taxonomies': parent.attr('taxonomies'),
                    'product_view': parent.attr('product_view'),
                    'custom_template': parent.attr('custom_template'),
                    'product_view_color': parent.attr('product_view_color'),
                    'hover': parent.attr('hover'),
                    'size': parent.attr('size'),
                    'show_counter': parent.attr('show_counter'),
                    'show_stock': parent.attr('show_stock')
                };

                var next = parseInt(parent.find('.product').length) + parseInt(parent.attr('per-page'));

                if (btn.attr('limit') && next >= btn.attr('limit')) {
                    attr['limit'] = parseInt(parent.attr('per-page')) - (next - btn.attr('limit'));
                }

                $.ajax({
                    url: etConfig.ajaxurl,
                    method: 'POST',
                    data: {
                        'action': 'etheme_ajax_products',
                        'attr': attr,
                        'context': 'frontend'
                    },
                    dataType: 'html',
                    success: function (respond) {
                        var p_loop = btn.parents('.etheme_products').find('.products-loop');
                        if (p_loop.hasClass('with-ajax')) {
                            p_loop = p_loop.find('.ajax-content');
                        }
                        p_loop.append(respond);
                        setTimeout(function () {
                            p_loop.find('.productAnimated').addClass('product-faded').removeClass('product-fade');
                        }, 300);  // 300 is compatible with transition in css
                        etTheme.reinitSwatches();
                        etTheme.contentProdImages();
                        etTheme.countdown(); // refresh product timers
                    },
                    error: function (data) {
                        etTheme.et_notice('products', 'error');
                    },
                    complete: function () {
                        btn.attr('paged', paged);
                        if (paged >= max_paged || (btn.attr('limit') && next >= btn.attr('limit'))) {
                            parent.find('.et_load-products').remove();
                        } else {
                            parent.find('.et-load-block').removeClass('loading').addClass('loaded');
                        }
                        etTheme.isotope();
                    }
                });
            }

            function et_load_posts(url) {
                // ! Page elements
                var load_posts = $('.et_blog-ajax'),
                    load_btn = $('.et_load-posts'),
                    loader = load_btn.find('.slide-loader');

                if (load_btn.find('a').length < 1) return;

                load_btn.removeClass('loaded').addClass('loading');
                loader.css('opacity', '1');

                $.ajax({
                    url: url,
                    method: 'GET',
                    timeout: 10000,
                    dataType: 'text',
                    success: function (respond) {
                        // ! Respond elements
                        ///console.log(respond);
                        var respond_load_btn = $(respond).find('.et_load-posts'),
                            respond_posts = $(respond).find('.et_blog-ajax').html();

                        // ! Add articles to page content
                        if (load_posts.hasClass('blog-masonry')) {
                            load_posts.isotope('insert', $(respond_posts));
                        } else {
                            // ! Change article class
                            respond_posts = respond_posts.replace(/article class="/g, 'article class="loading ');
                            load_posts.append(respond_posts);
                        }

                        // ! Add more post btn
                        if ($(respond).find('.et_load-posts a').length < 1) {
                            load_btn.html('<p>' + load_btn.attr('data-loaded') + '</p>');
                            load_btn.addClass('all-loaded');
                        } else {
                            load_btn.html(respond_load_btn.html());
                        }

                        load_btn.removeClass('loading').addClass('loaded');
                    },
                    error: function (data) {
                        etTheme.et_notice('posts', 'error');
                    },
                    complete: function () {
                        load_btn.removeClass('loading');
                        setTimeout(function () {
                            $('article.loading').removeClass('loading').addClass('loaded');
                            $(window).resize();
                            etTheme.resizeVideo();
                            etTheme.swiperFunc();
                            if (load_posts.hasClass('blog-masonry')) {

                                if (load_posts.find('.post-grid').length < 1) return;

                                load_posts.each(function () {

                                    var $grid = $(this).isotope({
                                        isOriginLeft: !etConfig.layoutSettings.is_rtl,
                                        itemSelector: '.post-grid'
                                    });

                                    $grid.imagesLoaded().progress(function () {
                                        $grid.isotope('layout');
                                    });

                                });
                            }
                            loader.css('opacity', '0');
                            etTheme.global_image_lazy();
                        }, 300);
                    }
                });
            }
        },

        AjaxElement: function () {
            $.each($('.et-ajax-element'), function () {
                loading_by_scroll($(this));
            });

            function loading_by_scroll(load_btn) {
                $(window).scroll(function () {
                    if (load_btn.length < 1) return;

                    var btn_top = load_btn.offset().top,
                        btn_height = load_btn.outerHeight(),
                        window_scroll = $(this).scrollTop();

                    if (window_scroll < (btn_top + btn_height - et_global['w_height'])) return;
                    if (!load_btn) return;
                    if (load_btn.hasClass('loading')) return;

                    load_btn.addClass('loading');

                    load_element(load_btn);
                });
            }

            function load_element(element) {
                var shortcode = element.attr('element'),
                    attr = element.find('span.et-element-args').text(),
                    content = element.find('span.et-element-content').html(),
                    args = JSON.parse(attr),
                    extra = element.attr('extra');

                $.ajax({
                    url: etConfig.ajaxurl,
                    method: 'POST',
                    data: {
                        'action': 'et_ajax_element',
                        'args': args,
                        'element': shortcode,
                        'content': content
                    },
                    dataType: 'html',
                    success: function (response) {
                        $(element).after(response);
                        if (extra == 'slider') {
                            etTheme.swiperFunc();
                        }
                        etTheme.reinitSwatches();
                        etTheme.contentProdImages();
                        etTheme.countdown(); // refresh product timers
                    },
                    error: function (data) {
                        etTheme.et_notice('element', 'error');
                    },
                    complete: function () {
                        $(element).remove();
                        etTheme.global_image_lazy();
                    }
                });
            }
        },

        // post/product modules
        commentsForm: function () {
            // **********************************************************************//
            // ! Custom Comment Form Validation
            // **********************************************************************//
            var commentForm = $('#commentform');

            commentForm.on('click', '#submit', function (e) {
                $('#commentsMsgs').html('');

                commentForm.find('.required-field').each(function () {
                    if ($(this).val() == '') {
                        $(this).addClass('validation-failed');
                        e.preventDefault();
                    }
                });

            });
        },

        // woocommerce
        contentProdImages: function () {
            // **********************************************************************//
            // ! Products grid images slider
            // **********************************************************************//

            $('.hover-effect-slider').each(function () {
                var element_settings = {
                    'slider': $(this),
                    'index': 0,
                    'process': false,
                    'time': 300,
                    'imageLink': $(this).find('.product-content-image'),
                    'imagesWrapper': $(this).find('.images-slider-wrapper'),
                    'arrowsHTML': '<div class="sm-arrow arrow-left"></div><div class="sm-arrow arrow-right"></div>',
                    'added': false,
                };

                element_settings['image'] = element_settings['imageLink'].find('img');
                element_settings['imagesList'] = element_settings['imageLink'].attr('data-images').split(",");
                element_settings['counterHTML'] = '<div class="slider-counter"><span class="current-index">1</span>/<span class="slides-count">' + element_settings['imagesList'].length + '</span></div>';

                if (element_settings['imagesList'].length > 1) {
                    if (!element_settings['imagesWrapper'].hasClass('arrows-added')) {
                        element_settings['imagesWrapper'].addClass('arrows-added').prepend(element_settings['arrowsHTML']);
                        // element_settings['slider'].prepend(element_settings['counterHTML']);
                    }

                    element_settings['slider'].find('.sm-arrow').mouseover(function () {
                        element_settings['slider'].addClass('is_arrows-hovered');
                    });

                    element_settings['slider'].find('.sm-arrow').mouseleave(function () {
                        element_settings['slider'].removeClass('is_arrows-hovered');
                    });

                    // Previous image on click on left arrow
                    element_settings['slider'].find('.arrow-left').click(function (event) {
                        if (element_settings['process']) return;
                        element_settings['process'] = true;
                        prevImage();
                    });

                    // Next image on click on left arrow
                    element_settings['slider'].find('.arrow-right').click(function (event) {
                        if (element_settings['process']) return;
                        element_settings['process'] = true;
                        nextImage();
                    });
                }

                function nextImage() {
                    if (element_settings['index'] < element_settings['imagesList'].length - 1) {
                        element_settings['index']++;
                    } else {
                        element_settings['index'] = 0; // if the last image set it to first
                    }
                    changeImage(element_settings['index']);
                }

                function prevImage() {
                    if (element_settings['index'] > 0) {
                        element_settings['index']--;
                    } else {
                        element_settings['index'] = element_settings['imagesList'].length - 1; // if the first item set it to last
                    }
                    changeImage(element_settings['index']);
                }

                function changeImage(index) {

                    element_settings['process'] = false;
                    element_settings['image'].attr('src', element_settings['imagesList'][index]).attr('srcset', '');
                    element_settings['image'].removeAttr('srcset');
                    //slider.find('.current-index').text(index);// update slider counter
                }

            });

            $(document)
                .on('mouseover', '.st-swatch-in-loop', function () {
                    $(this).parents('.content-product').find('.product-image-wrapper').addClass('is_arrows-hovered');
                })
                .on('mouseleave', '.st-swatch-in-loop', function () {
                    $(this).parents('.content-product').find('.product-image-wrapper').removeClass('is_arrows-hovered');
                });

        },

        photoSwipe: function () {

            setTimeout(function () {
                $('.zoom-images-button, .open-video-popup, .open-360-popup').addClass('showed');
            }, 400);

            // **********************************************************************//
            // ! init photoswipe
            // **********************************************************************//

            var pswpElement = document.querySelectorAll('.pswp')[0],
                mainImages = $('.images-wrapper');

            if (!mainImages.hasClass('with-pswp')) return;

            mainImages.on('click', '.main-images a.zoom, .main-images .zoomImg', function (e) {
                e.preventDefault();

                var index = 0;
                var items = [];
                var mainImage = $(this);

                if ($(this).hasClass('.zoom') != true) {
                    mainImage = $(this).parent().find('.woocommerce-main-image');
                }

                var additionalImages = '';
                if (mainImages.find('.images').hasClass('gallery-slider-on')) {
                    additionalImages = $('.pswp-additional');
                } else {
                    additionalImages = $('.woocommerce-main-image:not(.pswp-main-image)');
                    var firstImg = $('.woocommerce-main-image.pswp-main-image');
                    items.push({
                        src: firstImg.attr('href'),
                        w: firstImg.data('width'),
                        h: firstImg.data('height'),
                    });
                }

                additionalImages.each(function () {
                    items.push({
                        src: $(this).attr('data-large'),
                        w: $(this).data('width'),
                        h: $(this).data('height'),
                    });
                });

                if (!additionalImages.length && mainImages.find('.images').hasClass('gallery-slider-on')) {
                    items.push({
                        src: mainImage.attr('href'),
                        w: mainImage.data('width'),
                        h: mainImage.data('height'),
                    });
                }

                // define options (if needed)
                var options = {
                    // optionName: 'option value'
                    // for example:
                    index: mainImage.data('index') // start at first slide
                };

                // Initializes and opens PhotoSwipe
                var gallery = new PhotoSwipe(pswpElement, PhotoSwipeUI_Default, items, options);
                gallery.init();

                if (etConfig.variationGallery) {
                    gallery.listen('destroy', function () {
                        $('.pswp > *').addClass('dt-hide mob-hide');
                        setTimeout(function () {
                            $('.pswp').attr('class', 'pswp');
                            $('.pswp > *').removeClass('dt-hide mob-hide');
                        }, 300);
                    });
                }

            });
        },

        sliderVertical: function () {
            if ($('.swiper-entry').hasClass('swiper-vertical-images')) {

                var is_rtl = !!$('.thumbnails').hasClass('slick-rtl');

                $('.thumbnails-list').slick({
                    slidesToScroll: 1,
                    autoplay: false,
                    vertical: true,
                    verticalSwiping: true,
                    infinite: false,
                    rtl: is_rtl,
                    adaptiveHeight: true,
                    lazyLoad: 'ondemand',
                    nextArrow: '<div class="swiper-custom-right"></div>',
                    prevArrow: '<div class="swiper-custom-left"></div>',
                    responsive: [
                        {
                            breakpoint: 650,
                            settings: {
                                slidesToShow: 3,
                                slidesToScroll: 3,
                                vertical: false,
                                verticalSwiping: false,
                                adaptiveHeight: false,
                            }
                        }
                    ]
                });

                $(window).load(function () {
                    $('.thumbnails-list .slick-current').eq(0).addClass('active-thumbnail');
                });
            }
        },

        woocommerce: function () {
            // **********************************************************************//
            // ! WooCommerce
            // **********************************************************************//

            $(window).load(function () {
                if (et_woocommerce['is_single_product']) {
                    if (document.URL.split('#reviews').length == 2) {
                        $('#tab_reviews').click();
                        setTimeout(function () {
                            $('html, body').animate({scrollTop: $('.woocommerce-tabs').offset().top}, 300);
                        }, 300);
                    }
                    if (document.URL.split('#comment').length == 2) {
                        var id = document.URL.split('#')[1];
                        $('#tab_reviews').click();
                        setTimeout(function () {
                            $('html, body').animate({scrollTop: $('#' + id).offset().top}, 300);
                        }, 300);
                    }
                }
            });

            $('.woocommerce-review-link').click(function (e) {
                e.preventDefault();
                if (!$('#tab_reviews').hasClass('opened')) $('#tab_reviews').click();
                $('html, body').animate({scrollTop: $('.woocommerce-tabs').offset().top}, 300);
            });

        },

        quantityIncrements: function (reinit) {
            if ($('body').hasClass('et_quantity-off') || reinit) return;

            // Quantity buttons
            // $( 'div.quantity:not(.buttons_added), td.quantity:not(.buttons_added)' ).addClass( 'buttons_added' ).append( '<span value="+" class="plus" >+</span>' ).prepend( '<span value="-" class="minus" >-</span>' );

            // if (reinit) return;

            $(document).on('click', '.plus, .minus', function () {

                // Get values
                var $qty = $(this).closest('.quantity').find('.qty'),
                    currentVal = parseFloat($qty.val()),
                    max = parseFloat($qty.attr('max')),
                    min = parseFloat($qty.attr('min')),
                    step = $qty.attr('step'),
                    new_val = '';

                // Format values
                if (!currentVal || currentVal === '' || currentVal === 'NaN') currentVal = 0;
                if (max === '' || max === 'NaN') max = '';
                if (min === '' || min === 'NaN') min = 0;
                if (step === 'any' || step === '' || step === undefined || parseFloat(step) === 'NaN') step = 1;

                // Change the value
                if ($(this).is('.plus')) {

                    if (max && (max == currentVal || currentVal > max)) {
                        $qty.val(max);
                    } else {
                        new_val = currentVal + parseFloat(step);
                        if ( step.indexOf('.') !== -1 || step.indexOf(',') !== -1 ) {
                            new_val = new_val.toFixed(3);
                        }
                        else {
                            new_val = parseFloat(new_val);
                        }
                        $qty.val(new_val);
                    }
                } else {
                    if (min && (min == currentVal || currentVal < min)) {
                        $qty.val(min);
                    } else if (currentVal > 0) {
                        new_val = currentVal - parseFloat(step);
                        if ( step.indexOf('.') !== -1 || step.indexOf(',') !== -1 ) {
                            new_val = new_val.toFixed(3);
                        }
                        else {
                            new_val = parseFloat(new_val);
                        }
                        $qty.val(new_val);
                    }

                }

                // Trigger change event
                $qty.trigger('change');

            });

            $(document.body).on('updated_wc_div', function () {
                etTheme.quantityIncrements(true);
            });

            // in loop
            $(document).on('change', '.content-product input.qty', function() {
                $(this).parents('.content-product').find('.button[data-quantity]').attr('data-quantity', this.value);
            });
        },

        ajaxAddToCartInit: function () {
            var timeout = 0;

            $(document.body)
                .on('adding_to_cart', function (event, $thisbutton, data) {

                    if ($thisbutton == null) return;

                    var product = $thisbutton.parents('.content-product, form.cart');

                    product.addClass('adding-to-cart').addClass('et-vpf'); // et-visible-product-footer

                    // if($thisbutton.hasClass('single_add_to_cart_button')) {
                    $thisbutton.prepend('<div class="et-loader"><svg class="loader-circular" viewBox="25 25 50 50"><circle class="loader-path" cx="50" cy="50" r="12" fill="none" stroke-width="2" stroke-miterlimit="10"></circle></svg></div>');
                    // }

                })
                .on('added_to_cart', function (event, fragments, cart_hash, $thisbutton) {

                    etTheme.global_image_lazy();

                    var product = $thisbutton.parents('.content-product, .type-product, form.cart');

                    clearTimeout(timeout);

                    // if($thisbutton.hasClass('single_add_to_cart_button')) {
                    $thisbutton.find('.et-loader').remove();
                    // }

                    if (et_woocommerce['quick_view_opened']) {
                        $('.quick-view-popup').magnificPopup('close');
                    }

                    setTimeout(function () {
                        product.removeClass('adding-to-cart').removeClass('et-vpf');
                    }, 400);

                    if (!etConfig['layoutSettings']['is_header_builder'] && !etConfig.ajaxProductNotify ) {
                        var cart = (et_global['fixed_header'] && $('.fixed-header').hasClass('fixed-enabled')) ?
                            $('.fixed-header .shopping-container') : $('.header .shopping-container');

                        cart.addClass('cart-show');
                        timeout = setTimeout(function () {
                            cart.removeClass('cart-show');
                            // tooltip.removeClass('tooltip-shown');
                        }, 3500);
                    }

                });

            /* Quantity sync */
            $(document).on('change', 'form.cart input.qty', function () {
                $(this).parents('form').find('button[data-quantity]').attr('data-quantity', this.value);
            });

        },

        variationsThumbs: function () {
            /* Variations images */

            var firstThumb = $('.thumbnails-list .thumbnail-item').first().find('a');

            if (!firstThumb) return;

            var img = firstThumb.find('img'),
                origSrc = img.attr('src'),
                origSrcset = img.attr('srcset'),
                origHref = firstThumb.attr('href'),
                isVerticalSlider = $('.images-wrapper').hasClass('swiper-vertical-images');

            $('.variations_form')
                .on('found_variation', function (event, variation) {
                    if (variation.image_link) {
                        firstThumb.attr('href', variation.image_link);
                    }
                    if (variation.image_src) {
                        img.attr('src', variation.image_src);
                    }
                    if (variation.image_srcset) {
                        img.attr('srcset', variation.image_srcset);
                    }
                    goToFirst();
                })
                .on('reset_data', function () {
                    firstThumb.attr('href', origHref);
                    img.attr('src', origSrc).attr('srcset', origSrcset);
                    if (isVerticalSlider) {
                        $('.thumbnails-list').slick('slickGoTo', 0);
                    }
                });

            var goToFirst = function () {
                var swiperMain = $(".main-images").data('Swiper');
                if (isVerticalSlider) {
                    $('.thumbnails-list').slick('slickGoTo', 0);
                } else {
                    if (typeof swiperMain != 'undefined') {
                        swipers['swiper-' + index].slideTo(0);
                    }
                }
            };

        },

        variationGallery: function() {

            var form = $('.variations_form');
            var is_variation_product = $(form).length > 0;
            var product_id = form.data('product_id');
            var isVerticalSlider = $('.images-wrapper').hasClass('swiper-vertical-images');
            var quick_view = $(document).find('.quick-view-popup');

            if ( quick_view.length )
                form = quick_view.find('.variations_form');

            initDefaultGallery(form, product_id);
            initVariationGallery(form, product_id);

            form
                .on('found_variation', function (event, variation) {
                    setVariationGalleryImages(variation.variation_gallery_images);
                    goToFirst();
                })
                .on('reset_data', function () {
                    if ( $(this).data('et_variation_gallery_default') ) {
                        setVariationGalleryImages($(this).data('et_variation_gallery_default'));
                    }
                    goToFirst();
                });

            var goToFirst = function () {
                var swiperMain = $(".main-images").data('Swiper'),
                    swiperThumb = $(".thumbnails-list").data('Swiper');
                if (typeof swiperMain != 'undefined') {
                    swipers['swiper-' + index].slideTo(0);
                }
                if (isVerticalSlider) {
                    $('.thumbnails-list').slick('slickGoTo', 0);
                } else {
                    if (typeof swiperThumb != 'undefined') {
                        swipers['swiper-' + index].slideTo(0);
                    }
                }
            };

            function setVariationGalleryImages(images) {

                if ( !is_variation_product ) return;

                var thumbnails = images.map(function (image) {
                    var template = wp.template('et-variation-gallery-thumbnail-template');
                    return template(image);
                }).join('');

                $('.thumbnails-list').parent().removeClass('dt-hide mob-hide');
                $('.swiper-control-top').find('.swiper-custom-left, .swiper-custom-right').removeClass('dt-hide mob-hide');
                $('.thumbnails-list.vertical-thumbnails').find('.slick-arrow').remove();
                $('.swiper-wrapper.thumbnails-list, .thumbnails-list.vertical-thumbnails .slick-track').html(thumbnails);

                if ( images.length <= 1 ) {
                    $('.swiper-wrapper.thumbnails-list').parent().addClass('dt-hide mob-hide');
                    $('.swiper-control-top').find('.swiper-custom-left, .swiper-custom-right').addClass('dt-hide mob-hide');
                }

                var main = images.map(function (image) {
                    var template = wp.template('et-variation-gallery-slider-template');
                    return template(image);
                }).join('');

                $('.swiper-control-top .main-images').html(main);

                etTheme.global_image_lazy();
                etTheme.resizeVideo();

                setTimeout(function(){
                    if ( isVerticalSlider ) {
                        // tweak to remove double arrows in slider
                        $('.thumbnails-list.vertical-thumbnails .slick-arrow').remove();
                        $('.thumbnails-list.vertical-thumbnails').slick('reinit');
                    }
                    $(window).resize();
                }, 500);

                if ( $.fn.zoom && !quick_view.length ) {

                    var zoomEnabled  = wc_single_product_params.zoom_enabled;

                    if ( ! zoomEnabled ) {
                        return false;
                    }

                    $( '.woocommerce-main-image' ).each( function( index, target ) {
                        var galleryWidth = $(target).width(),
                            image = $( target ).find( 'img' );

                        // But only zoom if the img is larger than its container.
                        if ( image.data( 'large_image_width' ) > galleryWidth ) {

                            var zoom_options = $.extend( {
                                touch: false
                            }, wc_single_product_params.zoom_options );

                            if ( 'ontouchstart' in document.documentElement ) {
                                zoom_options.on = 'click';
                            }
                            else {
                                $(target).zoom( zoom_options );
                            }

                        }
                    } );
                }
            }

            function initDefaultGallery(_this, product_id) {

                if ( !is_variation_product ) return;

                wp.ajax.send('et_get_default_variation_gallery', {
                    data: {
                        product_id: product_id
                    },
                    success: function success(data) {
                        $(_this).data('et_variation_gallery_default', data);
                        etTheme.global_image_lazy();
                        etTheme.resizeVideo();
                        setTimeout(function(){
                            $(window).resize();
                        }, 500);
                    },
                    error: function error(e) {
                        $(_this).data('et_variation_gallery_default', []);
                        etTheme.et_notice('variationGalleryNotAvailable', 'error', ' ' + product_id + '.');
                    }
                });
            }

            function initVariationGallery(_this, product_id, images) {

                if ( !is_variation_product ) return;

                wp.ajax.send('et_get_available_variation_images', {
                    data: {
                        product_id: product_id
                    },
                    success: function success(data) {
                        $(_this).data('et_variation_gallery_variation_images', images);

                        if ( !images || images.length < 1 )
                            images = $(_this).data('et_variation_gallery_default');

                        setVariationGalleryImages(images);

                    },
                    error: function error(e) {
                        $(_this).data('et_variation_gallery_variation_images', []);
                    }
                });
            }

        },

        videoPopup: function () {
            $('.open-360-popup').magnificPopup({
                type: 'inline',
                midClick: true,
                beforeOpen: function () {
                    $('html').addClass(et_global['classes']['mfp']);

                },
                afterClose: function () {
                    $('html').removeClass(et_global['classes']['mfp']);
                }
            });
        },

        quickView: function () {
            // **********************************************************************//
            // ! AJAX Quick View
            // **********************************************************************//
            $(document).on('click', '.show-quickly, .show-quickly-btn', (function () {

                var $thisbutton = $(this),
                    $productCont = $(this).parent().parent().parent(),
                    prodid = $thisbutton.data('prodid'),
                    off_canvas = etConfig.quickView['type'] == 'off_canvas';

                if (off_canvas) {
                    $('body').prepend(
                        '<div class="' + et_global['classes']['skeleton'] + ' et-off-canvas et-off-canvas-wide et-content-' + etConfig.quickView['position'] +
                        ' et-popup-wrapper et-quick-view-canvas et-quick-view-wrapper product">' +
                        '<div class="et-mini-content et-popup-content"></div>' +
                        '</div>');
                } else {
                    $.magnificPopup.open({
                        items: {
                            src: '<div class="quick-view-popup et-quick-view-wrapper mfp-with-anim">' +
                                '<div class="doubled-border ' + et_global['classes']['skeleton'] + '">' +
                                '<div class="product-content quick-view-layout-' + etConfig.quickView['layout'] + '">' +
                                '<div class="row">' +
                                '<div class="col-lg-6 col-sm-6 product-images"></div>' +
                                '<div class="col-lg-6 col-sm-6 product-information"></div>' +
                                '</div>' +
                                '</div>' +
                                '</div>' +
                                '</div>'
                        },
                        // type: 'inline',
                        removalDelay: 0,
                        callbacks: {
                            beforeOpen: function () {
                                // just a hack that adds mfp-anim class to markup
                                this.st.image.markup = this.st.image.markup.replace('mfp-figure', 'mfp-figure mfp-with-anim');
                                this.st.mainClass = 'mfp-zoom-out';
                                $('html').addClass('quick-view-open ' + et_global['classes']['mfp']);
                                et_woocommerce['quick_view_opened'] = true;
                            },
                            afterClose: function () {
                                $('html').removeClass('quick-view-open ' + et_global['classes']['mfp']);
                                et_woocommerce['quick_view_opened'] = false;
                            },
                        },
                    }, 0);
                }

                $.ajax({
                    url: etConfig.ajaxurl,
                    method: 'POST',
                    data: {
                        'action': 'etheme_product_quick_view',
                        'prodid': prodid

                    },
                    dataType: 'json',
                    beforeSend: function () {
                        $productCont.addClass('loading').addClass('et-vpf'); // visible product footer
                        $thisbutton.addClass('loading').prepend('<div class="et-loader"><svg class="loader-circular" viewBox="25 25 50 50"><circle class="loader-path" cx="50" cy="50" r="12" fill="none" stroke-width="2" stroke-miterlimit="10"></circle></svg></div>');
                    },
                    complete: function () {
                        $thisbutton.find('.et-loader').remove();
                        $thisbutton.removeClass('loading');
                        $productCont.removeClass('loading').removeClass('et-vpf');

                        etTheme.quantityIncrements(true);
                        etTheme.global_image_lazy();
                    },
                    success: function (response) {
                        if (off_canvas) {
                            $('.et-quick-view-canvas .et-mini-content').html(response.html).parent()
                                .removeClass(et_global['classes']['skeleton']).addClass(response.classes);
                            // $('body').prepend(response);
                            setTimeout(function () {
                                $('.et-quick-view-canvas').addClass('done');
                            }, 400);
                        } else {

                            $('.quick-view-popup .product-content').attr('class', response.classes);

                            $('.quick-view-popup .product-images').html(response.html_col_one)
                                .addClass(response.col_one_classes);

                            $('.quick-view-popup .product-information').html(response.html_col_two);

                            $('.et-quick-view-wrapper .main-images img').first().load(function () {
                                $('.quick-view-popup .doubled-border').removeClass(et_global['classes']['skeleton']);
                            });
                        }

                        if (response.quick_image_height) {
                            $('.et-quick-view-wrapper img').css({
                                'min-height': response.quick_image_height,
                                'object-fit': 'cover'
                            });
                        }

                        $('.images').addClass('shown');

                        var excerpt = $('.quick-view-excerpts'),
                            product_info = (off_canvas) ? $('.et-quick-view-canvas .et-content') : $('.product-information'),
                            product_info_scroll = (off_canvas) ? $('.et-content-inner') : product_info,
                            to_show = true;

                        excerpt.on('click', '.excerpt-title', function () {
                            if (to_show) {
                                product_info.stop().animate({
                                    scrollTop: product_info_scroll[0].scrollHeight
                                });
                                to_show = false;
                            } else {
                                to_show = true;
                            }
                            excerpt.toggleClass('show-content');
                        });

                        etTheme.swiperFunc();
                        etTheme.reinitSwatches();

                        var swiperId = $('.et-quick-view-wrapper .swiper-control-top').attr('id');

                        if ( swiperId ) {
                            $(document).on('click', '.st-swatch-preview li', function () {
                                swipers['swiper-' + swiperId].slideTo(0);
                            });
                        }
                    },
                    error: function () {
                        if (off_canvas) {
                            $('.et-quick-view-canvas .et-mini-content').html('Error with ajax').parent()
                                .removeClass(et_global['classes']['skeleton']);
                            // $('body').prepend(response);
                            setTimeout(function () {
                                $('.et-quick-view-canvas').addClass('done');
                            }, 400);
                        } else {
                            $('.quick-view-popup .doubled-border').html('Error with ajax').parent().removeClass(et_global['classes']['skeleton']);
                        }
                    }
                });

            }));

            $('body').on('click', '.et-quick-view-wrapper .main-images a', function (e) {
                e.preventDefault();
            });
        },

        theLook: function () {
            var looks = $('.et-looks'),
                nav = looks.find('.et-looks-nav'),
                content = looks.find('.et-looks-content'),
                openedClass = 'active-look',
                productClass = 'product-ready',
                originalTimeout = 100,
                timeout = 0;

            var recalcul = function () {
                var look = content.find('.' + openedClass).first();
                if (look.length < 1) {
                    look = content.find('.et-look').first();
                }
                var height = look.attr('style', '').outerHeight();
                looks.height(height);
            };

            $(window).resize(function () {
                recalcul();
            });

            looks.find('.et-isotope').on('layout-changed', function () {
                recalcul();
            });

            nav.find('li').first().addClass('active');

            nav.on('click', 'a', function (e) {

                e.preventDefault();

                var index = $(this).parent().index(),
                    openLook = content.find('.et-look').eq(index);

                timeout = originalTimeout;

                if (openLook.hasClass(openedClass)) return;

                content.removeClass('has-no-active-item').find('.' + openedClass).removeClass(openedClass);

                openLook.addClass(openedClass);

                content.find('.' + productClass).removeClass(productClass);
                openLook.find('.et-isotope-item').each(function () {
                    var product = $(this).find('.content-product');
                    setTimeout(function () {
                        product.addClass(productClass);
                    }, timeout);
                    timeout = timeout + originalTimeout;
                });

                nav.find('.active').removeClass('active');
                $(this).parent().addClass('active');

                etTheme.isotope();

            });
        },

        filtersArea: function () {
            var filters = $('.shop-filters'),
                time = 200;
            $('.open-filters-btn').on('click', 'a', function (e) {
                e.preventDefault();
                if (filters.is(':visible')) {
                    $(this).removeClass('active');
                    filters.slideUp(time);
                } else {
                    $(this).addClass('active');
                    filters.slideDown(time);
                    if (et_global['is_masonry']) {
                        $('.shop-filters-area').isotope({
                            itemSelector: '.sidebar-widget',
                            isOriginLeft: !etConfig.layoutSettings.is_rtl,
                            masonry: {
                                columnWidth: '.sidebar-widget'
                            }
                        });
                    }
                }
            });
        },

        stickyProductImages: function () {
            if (et_global['w_width'] < 992) return;

            $(window).load(function () {

                var imgHeight = $('.single-product .product-fixed-images .images-wrapper').innerHeight(),
                    infHeight = $('.single-product .product-information').innerHeight();

                if (!$('.product-images .images .swiper-control-top').hasClass('gallery-slider-off')) {
                    //     $(window).load(function(){

                    var ProductImgsHeight = $('.product-images').outerHeight();

                    $('.fixed-product-block').css({
                        'minHeight': ProductImgsHeight - 30
                    });

                    //       });

                }

                if (imgHeight >= infHeight) return;

                $('.product-fixed-images .images-wrapper').stick_in_parent({
                    offset_top: 150
                });

                $('.product-fixed-content .product-information-inner').stick_in_parent({
                    offset_top: 150
                });

                $('.fixed-product-block').each(function () {
                    $(this).stick_in_parent({
                        offset_top: 150
                    });
                });

            });
        },

        ForCompare: function () {
            // Reinit lazy for new compare
            $(document)
                .on('yith_woocompare_render_table', function () {
                    etTheme.global_image_lazy();
                })
                .on('click', 'a.compare.button', function () {
                    $('body').addClass('et-compare');
                })
                .on('click', '#cboxOverlay, #cboxClose', function () {
                    $('body').removeClass('et-compare');
                })
                .on('click', '.et-open', function (e) {
                    e.preventDefault();
                    var c_name = $(this).attr("class").match(/to_open[\w-]*\b/),
                        open_what = c_name[0].split('to_open-')[1];
                    $(this).parent().find('.' + open_what).slideToggle(300);
                });

        },

        jumpToSlide: function () {
            $(document)
                .on('found_variation', 'form.variations_form', function (evt, variation) {
                    if ($('.main-slider-on').hasClass('gallery-slider-on')) {
                        if ($('.images-wrapper').hasClass('swiper-vertical-images')) {
                            $('.slick-slider.thumbnails-list .slick-slide.slick-current img').attr('src', variation.image.thumb_src);
                            var parent = $('.slick-slider.thumbnails-list .slick-slide.slick-current img').parent();

                            if (!parent.attr('data-o_large')) {
                                parent.attr('data-o_large', parent.attr('data-large'));
                            }

                            parent.attr('data-large', variation.image.full_src);

                            if (variation.image.srcset) {
                                $('.slick-slider.thumbnails-list .slick-slide.slick-current img').attr('srcset', variation.image.thumb_src);
                            } else {
                                $('.slick-slider.thumbnails-list .slick-slide.slick-current img').attr('srcset', variation.image.thumb_src);
                            }

                        } else {
                            var parent = $('.swiper-wrapper.thumbnails-list .swiper-slide.swiper-slide-active img').parent();

                            if (!parent.attr('data-o_large')) {
                                parent.attr('data-o_large', parent.attr('data-large'));
                            }

                            parent.attr('data-large', variation.image.full_src);

                            $('.swiper-wrapper.thumbnails-list .swiper-slide.swiper-slide-active img').attr('src', variation.image.thumb_src);
                            if (variation.image.srcset) {
                                $('.swiper-wrapper.thumbnails-list .swiper-slide.swiper-slide-active img').attr('srcset', variation.image.thumb_src);
                            } else {
                                $('.swiper-wrapper.thumbnails-list .swiper-slide.swiper-slide-active img').attr('srcset', variation.image.thumb_src);
                            }
                        }
                    }
                })
                .on('reset_image', 'form.variations_form', function (evt) {
                    if ($('.main-slider-on').hasClass('gallery-slider-on')) {

                        var thumbnail_default =
                            $('.main-images .swiper-slide.swiper-slide-active .woocommerce-product-gallery__image').data('thumb');

                        if ($('.images-wrapper').hasClass('swiper-vertical-images')) {
                            var parent = $('.slick-slider.thumbnails-list .slick-slide.slick-current img').parent();
                            parent.attr('data-large', parent.attr('data-o_large'));

                            $('.slick-slider.thumbnails-list .slick-slide.slick-current img')
                                .attr('src', thumbnail_default).attr('srcset', thumbnail_default);
                        } else {
                            var parent = $('.swiper-wrapper.thumbnails-list .swiper-slide.swiper-slide-active img').parent();
                            parent.attr('data-large', parent.attr('data-o_large'));

                            $('.swiper-wrapper.thumbnails-list .swiper-slide.swiper-slide-active img')
                                .attr('src', thumbnail_default).attr('srcset', thumbnail_default);
                        }
                    }
                })
                .on('click', '.swiper-wrapper.thumbnails-list .swiper-slide img', function (e) {
                    e.preventDefault();
                });
        },

        // ! Shop page ajax filters and pagination

        /**
         * After cart refreshed
         *
         * @version 1.0.1
         * @since 6.2.4
         */
        after_cart_refreshed: function () {
            $(document.body).on('wc_fragments_loaded wc_fragments_refreshed added_to_cart removed_from_cart', function () {
                etTheme.global_image_lazy();
            });
        },

        // woocommerce widgets
        categoriesAccordion: function () {
            // **********************************************************************//
            // ! Categories Accordion
            // **********************************************************************//

            $.fn.etAccordionMenu = function () {

                var $this = $(this),
                    openerHTML = ' <i class="et-icon et-down-arrow open-this"></i>';

                $this.addClass('with-accordion');

                $this.find('> li').has('.children, .nav-sublist-dropdown').has('li').addClass('parent-level0');
                $this.find('li').has('.children, .nav-sublist-dropdown').prepend(openerHTML);

                if ( $this.parents().hasClass('sidebar')) {
                    $this.parents('.sidebar').find('.widget').addClass('sidebar-widget');
                }
                if ( $this.parents().hasClass('footer')) {
                    $this.parents('.footer').find('.widget').addClass('footer-widget');
                }

                if ($this.find('.current-cat, .current-cat-parent').length > 0) {
                    $this.find('.current-cat, .current-cat-parent').find('> .open-this').removeClass('et-down-arrow').addClass('et-up-arrow').parent().addClass('opened').find('> ul.children').show();
                } else if (etConfig.sidebar.closed_pc_by_default) {
                    $this.find('>li').find('> .open-this').removeClass('et-down-arrow').addClass('et-up-arrow').parent().addClass('opened').find('> ul.children').show();
                }

                $this.find('.open-this').click(function () {
                    if ($(this).parent().hasClass('opened')) {
                        $(this).removeClass('et-up-arrow').addClass('et-down-arrow').parent().removeClass('opened').find('> ul, > div.nav-sublist-dropdown').slideUp(200);
                    } else {
                        $(this).removeClass('et-down-arrow').addClass('et-up-arrow').parent().addClass('opened').find('> ul, > div.nav-sublist-dropdown').slideDown(200);
                    }
                });

                return this;
            };

            $('.content-page .product-categories, #primary .product-categories').etAccordionMenu();

        },

        // woo 3d party
        ReinitForInfiniteScroll: function () {
            $(document).on('click', '#sb-infinite-scroll-load-more a', function (e) {
                var count = $('.products-loop .product').length;
                if ($(this).attr('data-count') >= count) {
                    return;
                } else {
                    var swatchInit = setInterval(timer, 300);
                    function timer () {
                        if ($('#sb-infinite-scroll-load-more').hasClass('finished')) {
                            clearInterval(swatchInit);
                        }
                        if ($('.products-loop .product').length > count) {
                            etTheme.reinitSwatches();
                            etTheme.contentProdImages();
                            etTheme.countdown(); // refresh product timers
                            etTheme.global_image_lazy();
                            clearInterval(swatchInit);
                        }
                    };
                    $(this).attr('data-count', count);
                }
            });
        },

        // widgets
        CustomMenuAccordion: function () {
            // **********************************************************************//
            // ! Custom Menu Accordion
            // **********************************************************************//

            $.fn.etAccordionMenu = function () {

                var $this = $(this),
                    openerHTML = ' <i class="et-icon et-down-arrow open-this"></i>';

                if ($this.parents('.et_b_header-widget').length > 0) {
                    // $this.parents('.et_b_header-widget').find('.sidebar-widget, .topbar-widget, .mobile-sidebar-widget, .top-panel-widget').removeClass('sidebar-widget topbar-widget mobile-sidebar-widget top-panel-widget');
                    return;
                }

                $this.addClass('with-accordion');

                $this.find('> li').has('.menu-item-has-children, .sub-menu').has('li').addClass('parent-level0');
                $this.find('li').has('.menu-item-has-children, .sub-menu').prepend(openerHTML);

                if ($this.find('.current-menu-item').length > 0) {
                    $this.find('.current-menu-item').find('> .open-this').removeClass('et-down-arrow').addClass('et-up-arrow').parent().addClass('opened').find('> ul.children, > ul.sub-menu').show();
                } else {
                    $this.find('>li').first().find('> .open-this').removeClass('et-down-arrow').addClass('et-up-arrow').parent().addClass('opened').find('> ul.children, > ul.sub-menu').show();
                }

                $this.find('.open-this').click(function () {
                    if ($(this).parent().hasClass('opened')) {
                        $(this).removeClass('et-up-arrow').addClass('et-down-arrow').parent().removeClass('opened').find('> ul, > div.nav-sublist-dropdown').slideUp(200);
                    } else {
                        $(this).removeClass('et-down-arrow').addClass('et-up-arrow').parent().addClass('opened').find('> ul, > div.nav-sublist-dropdown').slideDown(200);
                    }
                });

                return this;
            };

            $('.sidebar-widget.widget_nav_menu .menu').etAccordionMenu();
        },

        widgetsOpenClose: function () {

            if (et_global['s_widgets_open_close']) {
                $(document).on('click', '.sidebar-widget .widget-title', function () {
                    $(this).parent().toggleClass('et_widget-closed');
                    $(this).parent().find('> ul, > select:not(.select2-hidden-accessible), > .select2-container, > div:not(.widget-title), > p:not(.widget-title), > form').slideToggle(300);
                });
            }
            if (et_global['f_widgets_open_close'] && et_global['w_width'] <= 768) {
                $(document).on('click', '.footer-widget > .widget-title', function () {
                    $(this).parent().toggleClass('et_widget-closed');
                    $(this).parent().find('> ul, > select:not(.select2-hidden-accessible), > .select2-container, > div:not(.widget-title), > p:not(.widget-title), > form').slideToggle(300);
                });
            }
        },

        widgetsOpenCloseDefault: function () {

                if (et_global['s_widgets_open_close'] && $('body').hasClass('swc-default') && !$('body').is('.swc-default-done')) {
                    $('.sidebar-widget .widget-title').parent().addClass('et_widget-closed');
                    $('.sidebar-widget .widget-title').parent().find('> ul, > select:not(.select2-hidden-accessible), > .select2-container, > div:not(.widget-title), > p:not(.widget-title), > form').hide();
                    $(window).load(function() {
                        $('.sidebar-widget .widget-title').parent().find('> ul, > select:not(.select2-hidden-accessible), > .select2-container, > div:not(.widget-title), > p:not(.widget-title), > form').hide();
                    });
                    $('body').addClass('swc-default-done');
                }

                if (et_global['f_widgets_open_close'] && et_global['w_width'] <= 768 && $('body').hasClass('fwc-default') && !$('body').is('.fwc-default-done')) {
                    $('.footer-widget > .widget-title').parent().addClass('et_widget-closed');
                    $('.footer-widget > .widget-title').parent().find('> ul, > select:not(.select2-hidden-accessible), > .select2-container, > div:not(.widget-title), > p:not(.widget-title), > form').hide();
                    $(window).load(function() {
                        $('.footer-widget > .widget-title').parent().find('> ul, > select:not(.select2-hidden-accessible), > .select2-container, > div:not(.widget-title), > p:not(.widget-title), > form').hide();
                    });
                    $('body').addClass('fwc-default-done');
                }

        },

        // sidebar functions
        stickySidebar: function () {

            if (et_global['w_width'] < 992) return;

            $('body').addClass('sticky-sidebar-loaded');

            var sticky_sidebar = $('.sidebar.sticky-sidebar');

            if ( sticky_sidebar.length < 1) return;

            $(document).on('click', sticky_sidebar, function (e) {

                if ( $.inArray(e.target.tagName, ['INPUT', 'TEXTAREA']) > -1 ) return;

                var initHeight = $(this).height();
                setTimeout(function () {
                    var currentHeight = $('.sidebar.sticky-sidebar').height();
                    if (initHeight !== currentHeight) {
                        $(document.body).trigger('sticky_kit:recalc');
                    }
                }, 100);
            });

            var args = {
                offset_top: 50
            };

            if (!$('.content-page').hasClass('shop-full-width') && $('body').hasClass('woocommerce-page')) {
                args['parent'] = '.container.content-page';
            }

            sticky_sidebar.stick_in_parent(args);

            if (!sticky_sidebar.hasClass('sidebar-left')) return;

            sticky_sidebar
                .on('sticky_kit:stick sticky_kit:unbottom', function () {
                    var parent = $(this).parents('.row'),
                        left = parent.offset().left;
                    $(this).css('left', left);
                })
                .on('sticky_kit:unstick', function () {
                    $(this).css('left', 'auto');
                    $(this).css('position', 'relative');
                })
                .on('sticky_kit:bottom', function () {
                    $(this).css('left', 0);
                })
            ;

            $('.sidebar.sticky-sidebar.sidebar-left').css({
                'position': 'relative'
            });

            $('head').append('<style type="text/css">.content + .sticky-sidebar.sidebar-left {left: auto !important;position: relative;}</style>');

        },

        sidebarMobile: function () {
            if (et_global['w_width'] < 992 && $('.sidebar-mobile-off_canvas').length > 0) {
                var sidebars_toggles = '';
                $('.sidebar:not(.hidden-xs)').each(function () {
                    sidebars_toggles += '<div class="et-toggle-mob-sidebar et-off-canvas flex-inline align-items-center et-fadeIn">' +
                        '<span class="et-toggle flex-inline align-items-center" data-hide-text="Hide filter" data-show-text="Show filter">' +
                        '<span class="et-icon"><svg version="1.1" width="1em" height="1em" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 100" style="enable-background:new 0 0 100 100;" xml:space="preserve">' +
                        '<path d="M94.8,0H5.6C4,0,2.6,0.9,1.9,2.3C1.1,3.7,1.3,5.4,2.2,6.7l32.7,46c0,0,0,0,0,0c1.2,1.6,1.8,3.5,1.8,5.5v37.5' +
                        'c0,1.1,0.4,2.2,1.2,3c0.8,0.8,1.8,1.2,3,1.2c0.6,0,1.1-0.1,1.6-0.3l18.4-7c1.6-0.5,2.7-2.1,2.7-3.9V58.3c0-2,0.6-3.9,1.8-5.5' +
                        'c0,0,0,0,0,0l32.7-46c0.9-1.3,1.1-3,0.3-4.4C97.8,0.9,96.3,0,94.8,0z M61.4,49.7c-1.8,2.5-2.8,5.5-2.8,8.5v29.8l-16.8,6.4V58.3' +
                        'c0-3.1-1-6.1-2.8-8.5L7.3,5.1h85.8L61.4,49.7z"></path>' +
                        '</svg></span></span>' +
                        '</div>';
                    $(this).addClass('et-mini-content et-content-left');
                    $(this).after('<span class="et-close-sidebar et-icon et-delete"></span>');
                });
                if (sidebars_toggles != '' && $('.et-toggle-mob-sidebar').length < 1) {
                    $('body').append('<div class="et-toggle-mob-sidebars-wrapper"><div class="et-toggle-mob-sidebars-inner pos-fixed et-content-left">' + sidebars_toggles + '</div></div>');
                }
            }
        },

        sidebarMobileToggle: function () {
            $(document)
                .on('click touchstart', '.et-toggle-mob-sidebar .et-toggle', function () {
                    var sidebar = $('.sidebar'),
                        loaded = false;

                    if (loaded) {
                        sidebar.toggleClass('active');
                    } else {
                        sidebar.addClass('loaded');
                        loaded = true;
                        setTimeout(function () {
                            sidebar.toggleClass('active');
                        }, 200);
                    }
                    $('.et-toggle-mob-sidebars-wrapper').toggleClass('et-content-shown');
                    $('.et-mobile-panel-wrapper').addClass('outside');
                    et_global['deny_link_click'] = true;
                    // $('html').toggleClass('et-overflow-hidden');
                })
                .on('click touchstart', '.et-close-sidebar', function () {
                    setTimeout(function () {
                        $('.sidebar').removeClass('active');
                        $('.et-toggle-mob-sidebars-wrapper').removeClass('et-content-shown');
                        $('.et-mobile-panel-wrapper').removeClass('outside');
                        et_global['deny_link_click'] = false;
                    }, 300);
                });
        },

        // 3rd-party plugins compatibility

        // massive addons tabs
        heightFixMassive: function () {

            $(document).on('click', '.mpc-toggled .vc_tta-panel-heading', function () {

                var height = $(this).parents('.vc_tta-panel').children('.vc_tta-panel-body').height(),
                    data_height = $(this).parents('.mpc-toggled').data('height');
                height = data_height + height;

                $(this).parents('.mpc-toggled').css('max-height', height);
            });
        },

        // counters, timers

        imagesLightbox: function () {
            $("a[rel^='lightboxGall']").magnificPopup({
                type: 'image',
                gallery: {
                    enabled: true
                },
                beforeOpen: function () {
                    $('html').addClass(et_global['classes']['mfp']);
                },
                afterClose: function () {
                    $('html').removeClass(et_global['classes']['mfp']);
                }
            });

            $("a[rel='lightbox'], a[rel='pphoto']").magnificPopup({
                type: 'image',
                closeBtnInside: true,
                midClick: true,
                image: {
                    verticalFit: false, // Fits image in area vertically
                },
                removalDelay: 500,
                callbacks: {
                    beforeOpen: function () {
                        $('html').addClass('et-lightbox-opened ' + et_global['classes']['mfp']);
                        // just a hack that adds mfp-anim class to markup
                        this.st.image.markup = this.st.image.markup.replace('mfp-figure', 'mfp-figure mfp-with-anim');
                        this.st.mainClass = 'mfp-zoom-out';
                    },
                    afterClose: function () {
                        $('html').removeClass('et-lightbox-opened ' + et_global['classes']['mfp']);
                    }
                },
            });
        },

        animateCounter: function (el) {
            // **********************************************************************//
            // ! Animated Counters
            // **********************************************************************//
            var initVal = parseInt(el.text()),
                finalVal = el.data('value');
            if (finalVal <= initVal) return;
            var intervalTime = 1,
                time = 200,
                step = parseInt((finalVal - initVal) / time.toFixed());
            if (step < 1) {
                step = 1;
                time = finalVal - initVal;
            }
            var firstAdd = (finalVal - initVal) / step - time,
                counter = parseInt((firstAdd * step).toFixed()) + initVal,
                i = 0,
                interval = setInterval(function () {
                    i++;
                    counter = counter + step;
                    el.text(counter);
                    if (i == time) {
                        clearInterval(interval);
                    }
                }, intervalTime);
        },

        loadInView: function () {
            var counters = $('.animated-counter');

            counters.each(function () {
                $(this).waypoint(function () {
                    etTheme.animateCounter($(this));
                }, {offset: '100%'});
            });
        },

        countdown: function () {
            $('.et-timer').each(function () {
                var countdown = $(this),
                    update = function () {

                        var eventDate = Date.parse(countdown.data('final')) / 1000,
                            currentDate = Math.floor($.now() / 1000),
                            startDate = Date.parse(countdown.data('start')) / 1000;
                        if (startDate > currentDate) {
                            eventDate = startDate;
                            countdown.find('.timer-info').text('Sale starts in');
                        } else if (currentDate > eventDate) {
                            // countdown.find('.timer-info').text('This sale already finished');
                            countdown.remove();
                        } else {
                            countdown.find('.timer-info').remove();
                        }
                        var days = countdown.find('.days'),
                            hours = countdown.find('.hours'),
                            minutes = countdown.find('.minutes'),
                            seconds = countdown.find('.seconds'),

                            remindSeconds = eventDate - currentDate;

                        if (remindSeconds > 0) {
                            var remindDays = Math.floor(remindSeconds / (60 * 60 * 24));
                            remindSeconds -= remindDays * 60 * 60 * 24;
                            var remindHours = Math.floor(remindSeconds / (60 * 60));
                            remindSeconds -= remindHours * 60 * 60;
                            var remindMinutes = Math.floor(remindSeconds / (60));
                            remindSeconds -= remindMinutes * 60;

                            updateCircle($('.days').parent().find('circle'), remindDays);
                            updateCircle($('.hours').parent().find('circle'), remindHours);
                            updateCircle($('.minutes').parent().find('circle'), remindMinutes);
                            updateCircle($('.seconds').parent().find('circle'), remindSeconds);

                            if (remindDays < 10) remindDays = '0' + remindDays;
                            if (remindHours < 10) remindHours = '0' + remindHours;
                            if (remindMinutes < 10) remindMinutes = '0' + remindMinutes;
                            if (remindSeconds < 10) remindSeconds = '0' + remindSeconds;

                            if (days < 1 || remindDays == '00') {
                                days.parent().hide();
                                if ( remindHours == '00' ) {
                                    days.parent().next().hide();
                                }
                            } else {
                                days.text(remindDays);
                            }
                            hours.text(remindHours);
                            minutes.text(remindMinutes);
                            seconds.text(remindSeconds);
                        }
                    };
                setInterval(update, 1000);
                update();
            });

            function updateCircle(circle, value) {
                var val = parseInt((value / parseInt(circle.data('max-val'))) * 100, 10),
                    r = parseInt(circle.attr('r'), 10),
                    c = Math.PI * (r * 2);
                circle.attr('stroke-dasharray', c);
                var pct = ((val) / 100) * c;
                circle.css({strokeDashoffset: pct});
            }
        },

        reinitSwatches: function () {
            if (etConfig.woocommerceSettings.is_swatches) {
                ST_WC_FRONT_SWATCH.productLoop.itemSwatches();
            }
        },

        /**
         * Get notice
         *
         * @version 1.0.0
         * @since 6.2.4
         *
         * @param  {string} $key - notice key
         * @return {string}      - notice text
         */
        et_get_notice: function (key) {
            var notices = etConfig.notices;
            return notices[key];
        },// End of et_get_notice

        /**
         * Show notice
         *
         * @version 1.0.0
         * @since 6.2.4
         *
         * @param  {string} $key  - notice key
         * @param  {string} $type - how to show notice
         * @param  {string} $text - extra tex for notice
         */
        et_notice: function (key, type, text) {
            if (!text) {
                text = '';
            }
            var notice = etTheme.et_get_notice(key);
            switch (type) {
                case 'error':
                    console.error(notice + text);
                    break;
                case 'warning':
                    console.warn(notice + text);
                    break;
                case 'log':
                    console.log(notice + text);
                    break;
                case 'alert':
                    alert(notice + text);
                    break;
                default:
                    console.log(notice + text);
            }
        },// End of et_notice

    };

    $(document).ready(function () {
        etTheme.init();
    });

})(jQuery);