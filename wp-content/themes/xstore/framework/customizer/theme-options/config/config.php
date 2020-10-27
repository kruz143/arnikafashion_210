<?php  
	/**
	 * The template created for configurate vars in theme options 
	 *
	 * @version 0.0.1
	 * @since 6.0.0
	 */

	Kirki::add_config( 'et_kirki_options', array(
		'capability'    => 'edit_theme_options',
		'option_type'   => 'theme_mod',
	) );

      $sep = 0;

      $sep_style = 'padding: 7px 15px;background-color: #e1e1e1;color: #000;margin: 0 -15px;text-align: center;text-transform: uppercase;font-size: 14px;';

      $light_sep_style = $dark_sep_style = $active_sep_style = $bordered_sep_style = 'padding: 7px 15px;margin: 0 -15px;text-align: center;font-size: 14px;text-transform: uppercase;';

      $light_sep_style .= 'background-color: #f2f2f2;color: #222;';
      $dark_sep_style .= 'background-color: #000;color: #fff;';
      $active_sep_style .= 'background-color: #c62828;color: #fff;';
      $bordered_sep_style .= 'border: 1px solid #e1e1e1; color: #222; background: #fafafa;';

      $priority_i = 0;

      $priorities = array(
            'general' => $priority_i++,
            'header' => $priority_i++,
            'breadcrumbs' => $priority_i++,
            'footer' => $priority_i++,
            'mobile-panel' => $priority_i++,
            'styling' => $priority_i++,
            'typography' => $priority_i++,
            'woocommerce' => $priority_i++,
            'shop' => $priority_i++,
            'single-product-page' => $priority_i++,
            'shop-elements' =>$priority_i++,
            'promo-popup' =>$priority_i++,
            'blog' =>$priority_i++,
            'portfolio' =>$priority_i++,
            'social-sharing' =>$priority_i++,
            'facebook-login' =>$priority_i++,
            'instagram-api' =>$priority_i++,
            'mail-chimp' =>$priority_i++,
            'google-map' =>$priority_i++,
            '404' => $priority_i++,
            'custom-css' => $priority_i++,
            'speed-optimization' => $priority_i++,
            'import-export' => $priority_i++
      );
	
	$sidebars = array(
		'without' => ETHEME_CODE_CUSTOMIZER_IMAGES . '/global/layout/full-width.svg',
		'left'  => ETHEME_CODE_CUSTOMIZER_IMAGES . '/global/layout/left-sidebar.svg',
		'right'  => ETHEME_CODE_CUSTOMIZER_IMAGES . '/global/layout/right-sidebar.svg',
	);

      $single_product_layout = array(
            'small'   => ETHEME_CODE_CUSTOMIZER_IMAGES . '/woocommerce/single-product/Product-small.svg',
            'default' => ETHEME_CODE_CUSTOMIZER_IMAGES . '/woocommerce/single-product/Product-medium.svg',
            'xsmall'  => ETHEME_CODE_CUSTOMIZER_IMAGES . '/woocommerce/single-product/Product-thin.svg',
            'large'   => ETHEME_CODE_CUSTOMIZER_IMAGES . '/woocommerce/single-product/Product-large.svg',
            'fixed'   => ETHEME_CODE_CUSTOMIZER_IMAGES . '/woocommerce/single-product/Product-fixed.svg',
            'center'   => ETHEME_CODE_CUSTOMIZER_IMAGES . '/woocommerce/single-product/Product-center.svg',
            'wide'   => ETHEME_CODE_CUSTOMIZER_IMAGES . '/woocommerce/single-product/Product-wide.svg',
            'right'   => ETHEME_CODE_CUSTOMIZER_IMAGES . '/woocommerce/single-product/Product-right.svg',
            'booking'   => ETHEME_CODE_CUSTOMIZER_IMAGES . '/woocommerce/single-product/Product-booking.svg',
      );

      $blog_layout = array(
            'default'   => ETHEME_CODE_CUSTOMIZER_IMAGES . '/blog/Posts1-1.svg',
            'center' => ETHEME_CODE_CUSTOMIZER_IMAGES . '/blog/Posts-center.svg',
            'grid' => ETHEME_CODE_CUSTOMIZER_IMAGES . '/blog/Posts2-1.svg',
            'grid2' => ETHEME_CODE_CUSTOMIZER_IMAGES . '/blog/Posts2-2.svg',
            'timeline' => ETHEME_CODE_CUSTOMIZER_IMAGES . '/blog/Posts5-1.svg',
            'timeline2' => ETHEME_CODE_CUSTOMIZER_IMAGES . '/blog/Timeline2.svg',
            'small' => ETHEME_CODE_CUSTOMIZER_IMAGES . '/blog/Posts3-1.svg',
            'chess' => ETHEME_CODE_CUSTOMIZER_IMAGES . '/blog/Posts-chess.svg',
            'framed' => ETHEME_CODE_CUSTOMIZER_IMAGES . '/blog/Posts-framed.svg',
            'with-author' => ETHEME_CODE_CUSTOMIZER_IMAGES . '/blog/Posts-with-author.svg',
      );

      $post_template = array(
            'default'   => ETHEME_CODE_CUSTOMIZER_IMAGES . '/blog/3.svg',
            'full-width' => ETHEME_CODE_CUSTOMIZER_IMAGES . '/blog/2.svg',
            'large'   => ETHEME_CODE_CUSTOMIZER_IMAGES . '/blog/1.svg',
            'large2'   => ETHEME_CODE_CUSTOMIZER_IMAGES . '/blog/5.svg',
            'framed'   => ETHEME_CODE_CUSTOMIZER_IMAGES . '/blog/6.svg',
      );

	$text_color_scheme = array(
		'dark'  => esc_html__( 'Dark', 'xstore' ),
            'white' => esc_html__( 'White', 'xstore' ),
	);
      
      $text_color_scheme2 = array(
            'dark' => $text_color_scheme['dark'],
            'light' => esc_html__( 'Light', 'xstore' ),
      );

	$shopping_carts = array(
		1   => ETHEME_CODE_CUSTOMIZER_IMAGES . '/header/cart/Cart-1.svg',
		5   => ETHEME_CODE_CUSTOMIZER_IMAGES . '/header/cart/Cart-0.svg',
		2   => ETHEME_CODE_CUSTOMIZER_IMAGES . '/header/cart/Cart-3.svg',
		3   => ETHEME_CODE_CUSTOMIZER_IMAGES . '/header/cart/Cart-4.svg',
		4   => ETHEME_CODE_CUSTOMIZER_IMAGES . '/header/cart/Cart-2.svg'
	);

	$pages = Kirki_Helper::get_posts(
		array(
			'posts_per_page' => -1,
			'post_type'      => 'page'
		)
	);

	$pages[0] = esc_html__('Select page', 'xstore');

      $etheme_header_builder = get_option('etheme_header_builder', false );

	$product_templates = Kirki_Helper::get_posts(
		array(
		'posts_per_page'   => -1,
            'offset'           => 0,
            'category'         => '',
            'category_name'    => '',
            'orderby'          => 'date',
            'order'            => 'ASC',
            'include'          => '',
            'exclude'          => '',
            'meta_key'         => '',
            'meta_value'       => '',
            'post_type'        => 'vc_grid_item',
            'post_mime_type'   => '',
            'post_parent'      => '',
            'author'       => '',
            'author_name'      => '',
            'post_status'      => 'publish',
            'suppress_filters' => true 
		)
	);

    $product_templates['default'] = esc_html__( 'Inherit', 'xstore');

	$paddings_empty = $paddings_top_bottom_empty = array(
		'padding-top'    => '',
		'padding-right'  => '',
		'padding-bottom' => '',
		'padding-left'   => '',
	);

      unset($paddings_top_bottom_empty['padding-right']);
      unset($paddings_top_bottom_empty['padding-left']);

	$padding_labels = $padding_top_bottom_labels = array(
		'padding-top'  => esc_html__( 'Padding top', 'xstore' ),
		'padding-right'  => esc_html__( 'Padding right', 'xstore' ),
		'padding-bottom' => esc_html__( 'Padding bottom', 'xstore' ),
		'padding-left' => esc_html__( 'Padding left', 'xstore' ),
	);

      unset($padding_top_bottom_labels['padding-right']);
      unset($padding_top_bottom_labels['padding-left']);

	$borders_empty = array(
		'border-top'  => '',
		'border-right'  => '',
		'border-bottom' => '',
		'border-left' => '',
	);

	$border_labels = array(
		'border-top'  => esc_html__( 'Border top', 'xstore' ),
		'border-right'  => esc_html__( 'Border right', 'xstore' ),
		'border-bottom' => esc_html__( 'Border bottom', 'xstore' ),
		'border-left' => esc_html__( 'Border left', 'xstore' ),
	);

	$border_styles = array(
        'solid'  => esc_html__('Solid', 'xstore'),
        'dashed' => esc_html__('Dashed', 'xstore'),
        'dotted' => esc_html__('Dotted', 'xstore'),
        'double' => esc_html__('Double', 'xstore'),
        'none'   => esc_html__('None', 'xstore'),
	);

	$border_radius = array(
		'border-top-left-radius'  => '',
		'border-top-right-radius'  => '',
		'border-bottom-right-radius' => '',
		'border-bottom-left-radius' => '',
	);

	$border_radius_labels = array(
		'border-top-left-radius'  => esc_html__( 'Border top left radius', 'xstore' ),
		'border-top-right-radius'  => esc_html__( 'Border top right radius', 'xstore' ),
		'border-bottom-right-radius' => esc_html__( 'Border bottom right radius', 'xstore' ),
		'border-bottom-left-radius' => esc_html__( 'Border bottom left radius', 'xstore' ),
	);

	$et_selectors = array();

      // if ( etheme_get_option('etheme_optimize_js') ) {

            $et_selectors['active_color'] = '
                  .active-color,
                  .cart-widget-products a:hover,
                  .price ins .amount,
                  .cart ins .amount,
                  .product-price ins .amount,
                  .tabs .tab-title.opened,
                  .tabs .tab-title.opened:hover,
                  .tabs .tab-title:before,
                  .post-comments-count:hover,
                  .meta-post a[rel="author"]:hover,
                  .read-more,
                  span.active,
                  .active-link,
                  .active-link:hover,
                  ul.active > li:before,
                  .author-info .author-link,
                  .comment-reply-link,
                  .wpb-js-composer .vc_tta-container .vc_tta-color-grey.vc_tta-style-classic .vc_tta-tab.vc_active>a,
                  .meta-post-timeline .time-mon,
                  .et-masonry-filters-list .active,
                  .et-masonry-item .firstLetter,
                  .text-color-dark .category-grid .categories-mask span,
                  .team-member .member-details h5,
                  .team-member .member-content .et-follow-buttons a,
                  .price_slider_wrapper .button:hover,
                  .etheme_widget_brands li a strong,
                  .sidebar-widget ul li.current-cat > a,
                  .sidebar-widget ul li > ul.children li.current-cat > a, 
                  table.cart .product-details .product-title:hover,
                  .product-content .yith-wcwl-add-to-wishlist a:hover, 
                  .product-content .compare:hover,
                  .content-product .et-wishlist-holder .yith-wcwl-wishlistexistsbrowse a,
                  .content-product .et-wishlist-holder .yith-wcwl-wishlistaddedbrowse a,
                  .content-product .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistexistsbrowse a, 
                  .content-product .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistaddedbrowse a,
                  .woocommerce-MyAccount-navigation li.is-active a,
                  .sb-infinite-scroll-load-more:not(.finished):hover,
                  .mc4wp-alert.mc4wp-error,
                  .et-tabs-wrapper.title-hover .tabs-nav li a span,
                  .fullscreen-menu .menu > li > a:hover,
                  .slide-view-timeline2 .meta-post-timeline .time-day,
                  article.content-timeline2 .meta-post-timeline .time-day,
                  article.content-timeline .meta-post-timeline .time-day,
                  .content-grid2 .meta-post-timeline .time-day,
                  .menu-social-icons li a:hover,
                  .product-view-booking .content-product .button.compare:hover:before,
                  .et-menu-list .item-title-holder a:hover,
                  .mfp-close:hover:before, #cboxClose:hover:before,
                  .posts-nav-btn:hover .button,
                  #dokan-store-listing-filter-wrap .right .toggle-view .active,
                  .wishlist_table.mobile .remove_from_wishlist
                  ';

            if ( !$etheme_header_builder ) {
                  $et_selectors['active_color'] .= ',.et-wishlist-widget .wishlist-dropdown li .product-title a:hover,
                  #etheme-popup-holder .mfp-close:hover:before,
                  .item-design-mega-menu .item-level-1 > a:hover,
                  .menu-wrapper > .menu-main-container .menu > .current-menu-item > a,
                  .mobile-menu-wrapper .menu li:hover > .open-child,
                  .mobile-menu-wrapper .menu > li .sub-menu .menu-show-all a,
                  .item-design-mega-menu .nav-sublist-dropdown .nav-sublist li.current-menu-item a,
                  .item-design-dropdown .nav-sublist-dropdown ul > li.current-menu-item > a,
                  .secondary-menu-wrapper .menu li > a:hover,
                  .secondary-menu-wrapper .nav-sublist-dropdown .item-link:hover,
                  .secondary-menu-wrapper .nav-sublist-dropdown .menu-item-has-children .nav-sublist ul > li > a:hover,
                  .secondary-menu-wrapper .item-design-dropdown.menu-item-has-children ul .item-level-1 a:hover';
            }

              $et_selectors['active_bg'] = '
                  .tagcloud a:hover,
                  .button.active,
                  .btn.active,
                  .btn.active:hover,
                  .btn-advanced,
                  .btn-underline:after,
                  input[type="submit"].btn-advanced,
                  .button:hover, .btn:hover, input[type="submit"]:hover,
                  .price_slider_wrapper .ui-slider .ui-slider-handle,
                  .price_slider_wrapper .ui-slider-range,
                  .woocommerce-pagination ul li .current,
                  .woocommerce-pagination ul li a:hover,
                  .etheme-pagination .current, 
                  .etheme-pagination a:hover,
                  .dokan-pagination-container li a:hover,
                  .dokan-pagination-container .dokan-pagination li.active a,
                  .wpb_tabs .wpb_tabs_nav li a.opened span:after,
                  table.shop_table .remove-item:hover,
                  .active-link:before,
                  .block-title .label,
                  .form-row.place-order .button,
                  .post-grid .post-categories,
                  .blog-post .post-categories,
                  .post-header .post-categories,
                  .et-masonry-filters-list li a:after,
                  .vc_tta-color-grey.vc_tta-style-classic .vc_tta-tab.vc_active > a:after,
                  .vc_tta-style-classic .vc_tta-panel.vc_active .vc_tta-panel-heading a span:after,
                  .global-post-template-large .post-categories,
                  .global-post-template-large2 .post-categories,
                  .portfolio-item .portfolio-image,
                  .item-design-posts-subcategories .posts-content .post-preview-thumbnail .post-category,
                  ol.active > li:before,
                  span.dropcap.dark,
                  .product-information .yith-wcwl-add-to-wishlist a:hover:before,
                  .product-information .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistexistsbrowse a:before,
                  .product-information .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistaddedbrowse a:before,
                  .wp-picture .blog-mask:before,
                  .flexslider .flex-direction-nav a:hover,
                  .tagcloud a:hover,
                  .footer.text-color-light .tagcloud a:hover,
                  .widget_search button:hover,
                  .openswatch_widget_layered_nav ul li.chosen, .openswatch_widget_layered_nav ul li:hover,
                  ul.swatch li.selected,
                  .et-products-navigation > div:hover,
                  .et-looks .et-looks-nav li.active a,
                  .et-looks .et-looks-nav li:hover a,
                  .read-more:before,
                  .team-member .member-image:before,
                  #cookie-notice .button,
                  #cookie-notice .button.bootstrap,
                  #cookie-notice .button.wp-default,
                  #cookie-notice .button.wp-default:hover,
                  div.pp_default .pp_content_container a.pp_next:hover, div.pp_default .pp_content_container a.pp_previous:hover,
                  .content-framed .content-article .read-more,
                  .l2d-body footer .coupon-code .cc-wrapper .closed-text,
                  .et-tabs-wrapper.title-hover .tabs-nav li:hover a span:hover, .et-tabs-wrapper.title-hover .tabs-nav li.et-opened a span:hover,
                  .et-tabs-wrapper.title-hover .tabs-nav .delimiter,
                  .et-mailchimp:not(.dark) input[type="submit"],
                  .team-member.member-type-2:hover .content-section,
                  .slide-view-timeline2:hover .meta-post-timeline,
                  article.content-timeline2:hover .meta-post-timeline,
                  article.content-timeline:hover .meta-post-timeline,
                  .content-grid2:hover .meta-post-timeline,
                  .content-grid2:hover .meta-post-timeline,
                  .btn-view-wishlist,
                  .btn-checkout,
                  .et-mobile-panel .with-dot > a .et_b-icon:before,
                  .wcfmmp-stores-listing > .wcfmmp-store-search-form,
                  #wcmp-store-conatiner .wcmp-store-map-wrapper:not(:empty) + form .wcmp-store-map-filter,
                  .wcfmmp-store-search-form div.wcfm_radius_slidecontainer .wcfmmp_radius_range::-webkit-slider-thumb
                  ';

            if ( !$etheme_header_builder ) {
                  $et_selectors['active_bg'] .= ',.header-wrapper.header-advanced .header-search.act-default [role="searchform"] .btn,
                  .header-xstore .menu-wrapper .menu-main-container > .menu > li > a:after,
                  .header-xstore .menu-wrapper .menu-main-container > .menu > li > a:hover:after,
                  .header-xstore .menu-wrapper .menu-main-container > .menu > li.current-menu-item > a:after,
                  .et-wishlist-widget span.wishlist-count, 
                  .shopping-container .cart-bag .badge-number';
            }

            $et_selectors['active_border'] = '
                  .tagcloud a:hover,
                  .button.active,
                  .btn.active,
                  .btn.active:hover,
                  .btn-advanced,
                  input[type="submit"].btn-advanced,
                  .button:hover, input[type="submit"]:hover, .btn:hover,
                  .form-row.place-order .button,
                  .woocommerce-pagination ul li span.current,
                  .woocommerce-pagination ul li a:hover,
                  .etheme-pagination .current, 
                  .etheme-pagination a:hover,
                  .dokan-pagination-container li a:hover,
                  .dokan-pagination-container .dokan-pagination li.active a,
                  .widget_search button:hover,
                  table.cart .remove-item:hover,
                  .openswatch_widget_layered_nav ul li.chosen,
                  .openswatch_widget_layered_nav ul li:hover,
                  .et-tabs-wrapper .tabs-nav li.et-opened:before,
                  .et-tabs-wrapper .tabs .accordion-title.opened:before,
                  .btn-view-wishlist,
                  .btn-checkout,
                  .et-offer .product,
                  .et-tabs-wrapper.title-hover .tabs-nav li a span,
                  .team-member.member-type-2:hover .content-section:before,
                  .slide-view-timeline2 .meta-post-timeline,
                  article.content-timeline2 .timeline-content .meta-post-timeline,
                  article.content-timeline .timeline-content .meta-post-timeline,
                  .content-grid2 .meta-post-timeline,
                  .content-grid2:hover .meta-post-timeline,
                  .et-mobile-panel .with-dot > a .et_b-icon:after
                  ';

            if ( !$etheme_header_builder ) {
                  $et_selectors['active_border'] .= ',.secondary-menu-wrapper .menu,
                  .secondary-menu-wrapper .secondary-title,
                  .secondary-menu-wrapper .nav-sublist-dropdown';
            }

        $et_selectors['active_stroke'] = '
            .et-timer.dark .time-block .circle-box svg circle
            ';

      // }

      // else {
      //       $et_selectors['active_color'] = '
      //             .active-color,
      //             span.active,
      //             .sb-infinite-scroll-load-more:not(.finished):hover
      //             ';

      //       if ( !$etheme_header_builder ) {
      //             $et_selectors['active_color'] .= ',.et-wishlist-widget .wishlist-dropdown li .product-title a:hover,
      //             #etheme-popup-holder .mfp-close:hover:before,
      //             .item-design-mega-menu .item-level-1 > a:hover,
      //             .menu-wrapper > .menu-main-container .menu > .current-menu-item > a,
      //             .mobile-menu-wrapper .menu li:hover > .open-child,
      //             .mobile-menu-wrapper .menu > li .sub-menu .menu-show-all a,
      //             .item-design-mega-menu .nav-sublist-dropdown .nav-sublist li.current-menu-item a,
      //             .item-design-dropdown .nav-sublist-dropdown ul > li.current-menu-item > a,
      //             .secondary-menu-wrapper .menu li > a:hover,
      //             .secondary-menu-wrapper .nav-sublist-dropdown .item-link:hover,
      //             .secondary-menu-wrapper .nav-sublist-dropdown .menu-item-has-children .nav-sublist ul > li > a:hover,
      //             .secondary-menu-wrapper .item-design-dropdown.menu-item-has-children ul .item-level-1 a:hover';
      //       }

      //         $et_selectors['active_bg'] = '
      //             .button.active,
      //             input[type="submit"].btn-advanced,
      //             .button:hover, .btn:hover, input[type="submit"]:hover,

      //             .wpb_tabs .wpb_tabs_nav li a.opened span:after,
      //             .openswatch_widget_layered_nav ul li.chosen, .openswatch_widget_layered_nav ul li:hover
      //             ';

      //       if ( !$etheme_header_builder ) {
      //             $et_selectors['active_bg'] .= ',.header-wrapper.header-advanced .header-search.act-default [role="searchform"] .btn,
      //             .header-xstore .menu-wrapper .menu-main-container > .menu > li > a:after,
      //             .header-xstore .menu-wrapper .menu-main-container > .menu > li > a:hover:after,
      //             .header-xstore .menu-wrapper .menu-main-container > .menu > li.current-menu-item > a:after,
      //             .et-wishlist-widget span.wishlist-count, 
      //             .shopping-container .cart-bag .badge-number';
      //       }

      //       $et_selectors['active_border'] = '
      //             .button.active,
      //             .openswatch_widget_layered_nav ul li.chosen,
      //             .openswatch_widget_layered_nav ul li:hover
      //             ';

      //       if ( !$etheme_header_builder ) {
      //             $et_selectors['active_border'] .= ',.secondary-menu-wrapper .menu,
      //             .secondary-menu-wrapper .secondary-title,
      //             .secondary-menu-wrapper .nav-sublist-dropdown';
      //       }
      //       $et_selectors['active_stroke'] = '';
      // }

      $light_buttons = array(
            'regular' => '.btn.small:not(.black):not(.active):not(.bordered):not(.style-custom), .btn.medium:not(.black):not(.active):not(.bordered):not(.style-custom), .btn.big:not(.black):not(.active):not(.bordered):not(.style-custom), .content-product .product-details .button, .woocommerce-Button, .et_load-posts .btn a, .sb-infinite-scroll-load-more:not(.finished) a, form #qna-ask-input button',
            'hover' => '.btn.small:not(.black):not(.active):not(.bordered):not(.style-custom):hover, .btn.medium:not(.black):not(.active):not(.bordered):not(.style-custom):hover, .btn.big:not(.black):not(.active):not(.bordered):not(.style-custom):hover, .content-product .product-details .button:hover, .woocommerce-Button:hover, .et_load-posts .btn a:hover, .sb-infinite-scroll-load-more:not(.finished) a:hover, form #qna-ask-input button:hover',
            'active' => '.btn.small:active, .btn.medium:active, .btn.big:active, .content-product .product-details .button:active, .woocommerce-Button:active, .et_load-posts .btn a:active, .sb-infinite-scroll-load-more:not(.finished) a:active, form #qna-ask-input button:active'
      );

      $bordered_buttons = array(
            'regular' => '.btn.small.bordered, .btn.medium.bordered, .btn.big.bordered',
            'hover' => '.btn.small.bordered:hover, .btn.medium.bordered:hover, .btn.big.bordered:hover',
            'active' => '.btn.small:active, .btn.medium:active, .btn.big:active',
      );

      $bordered_buttons['hover'] = $bordered_buttons['hover'] . ',' . str_replace(':hover', ':focus', $bordered_buttons['hover']);

      $dark_buttons = array(
            'regular' => '.btn.small.black, 
                        .btn.medium.black, 
                        .btn.big.black, 
                        .before-checkout-form .button, 
                        .checkout-button, .shipping-calculator-form .button, 
                        .single_add_to_cart_button.button,
                        .single_add_to_cart_button.button:focus,
                        .single_add_to_cart_button.button.disabled,
                        .single_add_to_cart_button.button.disabled:hover,
                        form.login .button,
                        form.register .button, form.register .button.woocommerce-Button,
                        form.lost_reset_password .button,
                        .woocommerce-EditAccountForm .woocommerce-Button,
                        .empty-cart-block .btn,
                        .form-submit input[type="submit"],
                        #commentform input[type="button"],
                        .form-submit input[type="submit"]:focus,
                        .my_account_orders .view,
                        .et-quick-view-wrapper .product_type_variable,
                        .coupon input[type="submit"], 
                        .widget_search button, 
                        .widget_product_search button, 
                        .woocommerce-product-search button,
                        .woocommerce-product-search button:before, 
                        .widget_product_search button:before,
                        form.wpcf7-form .wpcf7-submit:not(.active),
                        .woocommerce table.wishlist_table td.product-add-to-cart a',
            'hover' => '.btn.small.black:hover, 
                        .btn.medium.black:hover, 
                        .btn.big.black:hover, 
                        .before-checkout-form .button:hover, 
                        .checkout-button:hover, .shipping-calculator-form .button:hover, 
                        .single_add_to_cart_button.button:hover,
                        .single_add_to_cart_button.button:hover:focus,
                        form.login .button:hover,
                        form.register .button:hover, form.register .button.woocommerce-Button:hover,
                        form.lost_reset_password .button:hover,
                        .woocommerce-EditAccountForm .woocommerce-Button:hover,
                        .empty-cart-block .btn:hover,
                        .form-submit input[type="submit"]:hover,
                        .form-submit input[type="submit"]:hover:focus,
                        #commentform input[type="button"]:hover,
                        #commentform input[type="button"]:hover:focus,
                        .my_account_orders .view:hover,
                        .et-quick-view-wrapper .product_type_variable:hover,
                        .coupon input[type="submit"]:hover, 
                        .widget_search button:hover, 
                        .widget_product_search button:hover, 
                        .woocommerce-product-search button:hover:before, 
                        .widget_product_search button:hover:before, 
                        .widget_search button:hover,
                        .woocommerce-product-search button:hover, form.wpcf7-form .wpcf7-submit:not(.active):hover,
                        .woocommerce table.wishlist_table td.product-add-to-cart a:hover',
            'active' => '.btn.small.black:active, 
                        .btn.medium.black:active, 
                        .btn.big.black:active, 
                        .before-checkout-form .button:active, 
                        .checkout-button:active, .shipping-calculator-form .button:active, 
                        .single_add_to_cart_button.button:active,
                        .single_add_to_cart_button.button:active:focus,
                        .single_add_to_cart_button.button.disabled:active,
                        .single_add_to_cart_button.button.disabled:active:hover,
                        form.login .button:active,
                        form.register .button:active,
                        form.lost_reset_password .button:active,
                        .woocommerce-EditAccountForm .woocommerce-Button:active,
                        .empty-cart-block .btn:active,
                        .form-submit input[type="submit"]:active,
                        .form-submit input[type="submit"]:active:focus,
                        #commentform input[type="button"]:active,
                        #commentform input[type="button"]:active:focus,
                        .my_account_orders .view:active,
                        .et-quick-view-wrapper .product_type_variable:active,
                        .woocommerce table.wishlist_table td.product-add-to-cart a:active',
      );

      $dark_buttons['hover'] = $dark_buttons['hover'] . ',' . str_replace(':hover', ':focus', $dark_buttons['hover']);

      $active_buttons = array(
            'regular' => '.btn.small.active, .btn.medium.active, .btn.big.active, .product_list_widget .buttons a, .et-wishlist-widget .wishlist-dropdown .buttons .btn-view-wishlist, .btn-checkout, .mini-cart-buttons a, .form-row.place-order .button, .form-row.place-order .button, input[type="submit"].dokan-btn-success, a.dokan-btn-success, .dokan-btn-success, .dokan-dashboard-content .add_note',
            'hover' => '.btn.small.active:hover, .btn.medium.active:hover, .btn.big.active:hover, .product_list_widget .buttons a:hover, .et-wishlist-widget .wishlist-dropdown .buttons .btn-view-wishlist:hover, .btn-checkout:hover, .mini-cart-buttons a:hover, .form-row.place-order .button:hover, input[type="submit"].dokan-btn-success:hover, a.dokan-btn-success:hover, .dokan-btn-success:hover, .dokan-dashboard-content .add_note:hover',
            'active' => '.btn.small.active:active, .btn.medium.active:active, .btn.big.active:active, .product_list_widget .buttons a:active, .et-wishlist-widget .wishlist-dropdown .buttons .btn-view-wishlist:active, .btn-checkout:active, .mini-cart-buttons a:active, .form-row.place-order .button:active, input[type="submit"].dokan-btn-success:active, a.dokan-btn-success:active, .dokan-btn-success:active, .dokan-dashboard-content .add_note:active',
      );

      $active_buttons['hover'] = $active_buttons['hover'] . ',' . str_replace(':hover', ':focus', $active_buttons['hover']);


?>