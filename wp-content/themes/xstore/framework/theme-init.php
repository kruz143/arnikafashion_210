<?php if ( ! defined( 'ETHEME_FW' ) ) {
	exit( 'No direct script access allowed' );
}

// **********************************************************************//
// ! Set Content Width
// **********************************************************************//
if ( ! isset( $content_width ) ) {
	$content_width = 1170;
}

// **********************************************************************//
// ! Include CSS and JS
// **********************************************************************//
if ( ! function_exists( 'etheme_enqueue_scripts' ) ) {
	function etheme_enqueue_scripts() {
		if ( ! is_admin() ) {
			
			$theme = wp_get_theme();
			
			$etheme_scripts = array( 'jquery' );
			
			if ( is_singular() && get_option( 'thread_comments' ) ) {
				wp_enqueue_script( 'comment-reply' );
			}
			
			if ( etheme_get_option( 'et_optimize_js' ) ) {
				wp_enqueue_script( 'etheme_optimize', get_template_directory_uri() . '/js/etheme.optimize.min.js', array(), false, true );
			}
			
			wp_enqueue_script( 'et_imagesLoaded', get_template_directory_uri() . '/js/imagesLoaded.js', array(), $theme->version, true );
			
			if ( etheme_masonry() ) {
				wp_enqueue_script( 'et_masonry', get_template_directory_uri() . '/js/isotope.js', array(), $theme->version, true );
			}
			
			//wp_enqueue_script('et_plugins', get_template_directory_uri().'/js/plugins.min.js',array(),false,true);
			
			if ( class_exists( 'WooCommerce' ) && is_product() ) {
				wp_enqueue_script( 'photoswipe_optimize', get_template_directory_uri() . '/js/photoswipe-optimize.min.js', array(), $theme->version, true );
			}
			
			$single_template = get_query_var( 'et_post-template', 'default' );
			
			if ( in_array( $single_template, array(
					'large',
					'large2'
				) ) && has_post_thumbnail() && is_singular( array( 'post', 'wpsl_stores' ) ) ) {
				wp_enqueue_script( 'backstretch_single', get_template_directory_uri() . '/js/jquery.backstretch.min.js', array(), $theme->version, true );
				wp_enqueue_script( 'backstretch_single_postImg', get_template_directory_uri() . '/js/postBackstretchImg.min.js', array('backstretch_single'), $theme->version, true );
			}
			
			if ( get_query_var( 'etheme_single_product_variation_gallery', false ) ) {
				$etheme_scripts[] = 'wp-util';
			}
			
			wp_enqueue_script( 'etheme', get_template_directory_uri() . '/js/etheme.min.js', $etheme_scripts, $theme->version, true );
			
			if ( !get_query_var( 'etheme_header_builder', false ) ) {
				wp_enqueue_script( 'oldHeader', get_template_directory_uri() . '/js/oldHeader.min.js', array_merge($etheme_scripts, array('etheme')), $theme->version, true );
			}
			
			if ( etheme_get_option('portfolio_projects') ) {
				wp_enqueue_script( 'portfolio', get_template_directory_uri() . '/js/portfolio.min.js', array_merge($etheme_scripts, array('etheme')), $theme->version, true );
			}
			
			if ( class_exists( 'Woocommerce' ) && is_product() ) {
				$product_id      = get_the_ID();
				$slider_vertical = ( etheme_get_option( 'thumbs_slider_vertical' ) || etheme_get_custom_field( 'slider_direction', $product_id ) == 'vertical' ) || ( get_query_var( 'etheme_single_product_builder' ) && etheme_get_option( 'product_gallery_type_et-desktop' ) == 'thumbnails_left' );
				if ( $slider_vertical ) {
					wp_enqueue_script( 'stick', get_template_directory_uri() . '/js/slick.min.js', array(), $theme->version );
				}
			}
			
			$etConf  = array();
			$cartUrl = '#';
			
			if ( class_exists( 'WooCommerce' ) ) {
				$cartUrl               = esc_url( wc_get_cart_url() );
				
				// dequeue woocommerce zoom scripts
				if ( ( ! get_query_var( 'etheme_single_product_builder' ) && ! etheme_get_option( 'product_zoom' ) ) || ( get_query_var( 'etheme_single_product_builder' ) && ! etheme_get_option( 'product_gallery_zoom_et-desktop' ) ) || get_query_var( 'is_mobile' ) ) {
					wp_deregister_script( 'zoom' );
					wp_dequeue_script( 'zoom' );
				}
				
				if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) {
					
					wp_enqueue_script( 'dokan-form-validate' );
					wp_enqueue_script( 'speaking-url' );
					wp_enqueue_script( 'dokan-vendor-registration' );
					
					wp_enqueue_script( 'wc-password-strength-meter' );
					
					$form_validate_messages = array(
						'required'        => __( "This field is required", 'xstore' ),
						'remote'          => __( "Please fix this field.", 'xstore' ),
						'email'           => __( "Please enter a valid email address.", 'xstore' ),
						'url'             => __( "Please enter a valid URL.", 'xstore' ),
						'date'            => __( "Please enter a valid date.", 'xstore' ),
						'dateISO'         => __( "Please enter a valid date (ISO).", 'xstore' ),
						'number'          => __( "Please enter a valid number.", 'xstore' ),
						'digits'          => __( "Please enter only digits.", 'xstore' ),
						'creditcard'      => __( "Please enter a valid credit card number.", 'xstore' ),
						'equalTo'         => __( "Please enter the same value again.", 'xstore' ),
						'maxlength_msg'   => __( "Please enter no more than {0} characters.", 'xstore' ),
						'minlength_msg'   => __( "Please enter at least {0} characters.", 'xstore' ),
						'rangelength_msg' => __( "Please enter a value between {0} and {1} characters long.", 'xstore' ),
						'range_msg'       => __( "Please enter a value between {0} and {1}.", 'xstore' ),
						'max_msg'         => __( "Please enter a value less than or equal to {0}.", 'xstore' ),
						'min_msg'         => __( "Please enter a value greater than or equal to {0}.", 'xstore' ),
					);
					
					wp_localize_script( 'dokan-form-validate', 'DokanValidateMsg', apply_filters( 'DokanValidateMsg_args', $form_validate_messages ) );
				}
				
			}
			
			$etGlobalConf = array(
				'ajaxurl'                 => admin_url( 'admin-ajax.php' ),
				'woocommerceSettings'     => array(
					'is_woocommerce'  => false,
					'is_swatches'     => false,
					'ajax_filters'    => false,
					'ajax_pagination' => false,
					'is_single_product_builder' => get_query_var( 'etheme_single_product_builder', false )
				),
				'notices'                 => array(
					'ajax-filters'         => esc_html__( 'Ajax error: cannot get filters result', 'xstore' ),
					'post-product'         => esc_html__( 'Ajax error: cannot get post/product result', 'xstore' ),
					'products'             => esc_html__( 'Ajax error: cannot get products result', 'xstore' ),
					'posts'                => esc_html__( 'Ajax error: cannot get posts result', 'xstore' ),
					'element'              => esc_html__( 'Ajax error: cannot get element result', 'xstore' ),
					'portfolio'            => esc_html__( 'Ajax error: problem with ajax et_portfolio_ajax action', 'xstore' ),
					'portfolio-pagination' => esc_html__( 'Ajax error: problem with ajax et_portfolio_ajax_pagination action', 'xstore' ),
					'menu'                 => esc_html__( 'Ajax error: problem with ajax menu_posts action', 'xstore' ),
					'noMatchFound'         => esc_html__( 'No matches found', 'xstore' ),
					'variationGalleryNotAvailable' => esc_html__('Variation Gallery not available on variation id', 'xstore'),
				),
				'layoutSettings'          => array(
					'layout'            => etheme_get_option( 'main_layout' ),
					'is_rtl'            => is_rtl(),
					'is_header_builder' => get_query_var( 'etheme_header_builder', false )
				),
				'sidebar' => array(
					'closed_pc_by_default' => etheme_get_option('first_catItem_opened'),
				),
				'et_global' => array(
					'classes' => array(
						'skeleton' => 'skeleton-body',
						'mfp' => 'et-mfp-opened'
					)
				)
			);
			
			$etPortfolioConf = array(
				'ajaxurl' => $etGlobalConf['ajaxurl'],
				'layoutSettings'          => array(
					'is_rtl'            => $etGlobalConf['ajaxurl'],
				),
			);
			
			$etOldHeaderConf = array(
				'menuBack'                => esc_html__( 'Back', 'xstore' ),
			);
			
			$etConf = array(
				'noresults'               => esc_html__( 'No results were found!', 'xstore' ),
				'successfullyAdded'       => esc_html__( 'Product added.', 'xstore' ),
				'successfullyCopied' => esc_html__('Copied to clipboard', 'xstore'),
				'checkCart'               => esc_html__( 'Please check your ', 'xstore' ) . "<a href='" . $cartUrl . "'>" . esc_html__( 'cart.', 'xstore' ) . "</a>",
				'catsAccordion'           => etheme_get_option( 'cats_accordion' ),
				'contBtn'                 => esc_html__( 'Continue shopping', 'xstore' ),
				'checkBtn'                => esc_html__( 'Checkout', 'xstore' ),
//				'ajaxProductNotify'       => etheme_get_option( 'ajax_added_product_notify' ) &&
//				                             ( get_query_var( 'etheme_header_builder', false ) &&  ( ( ! get_query_var( 'is_mobile' ) &&
//				                                                                                       Kirki::get_option( 'cart_content_type_et-desktop' ) != 'off_canvas' ) ||
//				                                                                                     get_query_var( 'is_mobile' ) && Kirki::get_option( 'cart_content_type_et-mobile' ) != 'off_canvas' ) ),
				'ajaxProductNotify'       => etheme_get_option( 'ajax_added_product_notify' ),
				'variationGallery'        => get_query_var( 'etheme_single_product_variation_gallery', false ),
				'quickView'               => array(
					'type'     => etheme_get_option( 'quick_view_content_type' ),
					'position' => etheme_get_option( 'quick_view_content_position' ),
					'layout'   => etheme_get_option( 'quick_view_layout' ),
					'variationGallery' => etheme_get_option('enable_variation_gallery')
				),
				'builders' => array(
					'is_wpbakery' => ( class_exists( 'WPBMap' ) && method_exists( 'WPBMap', 'addAllMappedShortcodes' ) ),
				),
			);
			
			if ( class_exists( 'WooCommerce' ) && current_theme_supports( 'woocommerce' ) ) {
				$etGlobalConf['woocommerceSettings']['is_woocommerce'] = true;
				$etGlobalConf['woocommerceSettings']['is_swatches']    = etheme_get_option( 'enable_swatch' ) && class_exists( 'St_Woo_Swatches_Base' );
				if ( is_shop() || is_product_category() ) {
					$etGlobalConf['woocommerceSettings']['ajax_filters']    = etheme_get_option( 'ajax_product_filter' );
					$etGlobalConf['woocommerceSettings']['ajax_pagination'] = etheme_get_option( 'ajax_product_pagination' );
				}
			}
			
			if ( $etGlobalConf['woocommerceSettings']['ajax_filters'] || $etGlobalConf['woocommerceSettings']['ajax_pagination'] ) {
				wp_enqueue_script( 'ajaxFilters', get_template_directory_uri() . '/js/ajax-filters.min.js',array('etheme'), $theme->version, true );
			}
			
			if ( !get_query_var( 'etheme_header_builder', false ) ) {
				$post_id = (array) get_query_var( 'et_page-id' );
				$ht      = get_query_var( 'et_ht', 'xstore' );
				
				$custom_header = etheme_get_custom_field( 'custom_header', $post_id['id'] );
				
				$etOldHeaderConf['layoutSettings']['header_type'] = $etGlobalConf['layoutSettings']['header_type']       = ( ! empty( $custom_header ) && $custom_header != $ht && ( $custom_header != 'inherit' ) ) ? $custom_header : $ht;
				$etOldHeaderConf['layoutSettings']['fixed_header_type'] = $etGlobalConf['layoutSettings']['fixed_header_type'] = etheme_get_option( 'fixed_header' );
			}
			
			$etConf = array_merge($etConf, $etGlobalConf);
			$etOldHeaderConf = array_merge($etGlobalConf, $etOldHeaderConf);
			
			wp_localize_script( 'etheme', 'etConfig', $etConf );
			wp_localize_script( 'oldHeader', 'etOldHeaderConfig', $etOldHeaderConf );
			wp_localize_script( 'portfolio', 'etPortfolioConfig', $etPortfolioConf );
			wp_localize_script( 'ajaxFilters', 'etAjaxFiltersConfig', $etGlobalConf );
			// wp_dequeue_script('prettyPhoto');
			wp_dequeue_script( 'prettyPhoto-init' );
			
			if ( class_exists( 'Vc_Manager' ) ) {
				// fix to scripts in static blocks
				wp_enqueue_script( 'wpb_composer_front_js' );
			}
			
		}
	}
}

add_action( 'wp_enqueue_scripts', 'etheme_enqueue_scripts', 30 );

// **********************************************************************//
// ! Add new images size
// **********************************************************************//

if ( ! function_exists( 'etheme_image_sizes' ) ) {
	function etheme_image_sizes() {
		add_image_size( 'shop_catalog_alt', 600, 600, true );
	}
}
add_action( 'after_setup_theme', 'etheme_image_sizes' );

// **********************************************************************//
// ! Theme 3d plugins
// **********************************************************************//
add_action( 'init', 'etheme_3d_plugins' );
if ( ! function_exists( 'etheme_3d_plugins' ) ) {
	function etheme_3d_plugins() {
		if ( function_exists( 'set_revslider_as_theme' ) ) {
			set_revslider_as_theme();
		}
		if ( function_exists( 'set_ess_grid_as_theme' ) ) {
			set_ess_grid_as_theme();
		}
	}
}

add_action( 'vc_before_init', 'etheme_vcSetAsTheme' );
if ( ! function_exists( 'etheme_vcSetAsTheme' ) ) {
	function etheme_vcSetAsTheme() {
		if ( function_exists( 'vc_set_as_theme' ) ) {
			vc_set_as_theme();
		}
	}
}

// ! REFER for woo premium plugins
if ( ! defined( 'YITH_REFER_ID' ) ) {
	define( 'YITH_REFER_ID', '1028760' );
}

// REFER for yellow pencil
if ( ! defined( 'YP_THEME_MODE' ) ) {
	define( 'YP_THEME_MODE', "true" );
}

// **********************************************************************//
// ! Load theme translations
// **********************************************************************//
if ( ! function_exists( 'etheme_load_textdomain' ) ) {
	add_action( 'after_setup_theme', 'etheme_load_textdomain' );
	
	function etheme_load_textdomain() {
		load_theme_textdomain( 'xstore', get_template_directory() . '/languages' );
		
		$locale      = get_locale();
		$locale_file = get_template_directory() . "/languages/$locale.php";
		if ( is_readable( $locale_file ) ) {
			require_once( $locale_file );
		}
	}
}
