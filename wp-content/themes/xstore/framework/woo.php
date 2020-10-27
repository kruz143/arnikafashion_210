<?php
// **********************************************************************// 
// ! Remove Default STYLES
// **********************************************************************//

add_filter( 'woocommerce_enqueue_styles', '__return_false' );
add_filter( 'pre_option_woocommerce_enable_lightbox', 'return_no' ); // Remove woocommerce prettyphoto

function return_no( $option ) {
	return 'no';
}

// **********************************************************************// 
// ! Template hooks
// **********************************************************************// 

add_action( 'wp', 'etheme_template_hooks', 60 );
if ( ! function_exists( 'etheme_template_hooks' ) ) {
	function etheme_template_hooks() {
		
		if ( get_query_var( 'etheme_single_product_builder' ) ) {
			// add_filter('woocommerce_locate_template', function( $template, $template_name, $template_path ){
			// 	if ( is_product() ) {
			// 		$template = WC()->plugin_path() . '/templates/' . $template_name;
			// 	}
			// 	fack you $template;
			// }, 3, 10);
			
			add_action( 'woocommerce_product_meta_start', function () {
				$class = 'et-ghost-' . ( etheme_get_option( 'product_meta_direction_et-desktop' ) == 'column' ? 'block' : 'inline-block' );
				echo '<span class="hidden ' . $class . '"></span>';
			}, 1 );
			
			if ( etheme_get_option( 'product_navigation_et-desktop' ) ) {
				add_action( 'woocommerce_after_single_product', 'etheme_project_links', 10 );
			}
			
		}
		
		// wc demo store 
		remove_action( 'wp_footer', 'woocommerce_demo_store' );
		add_action( 'et_after_body', 'woocommerce_demo_store', 2 );
		
		// uses in plugin also 
		add_action( 'woocommerce_before_quantity_input_field', 'et_quantity_minus_icon' );
		add_action( 'woocommerce_after_quantity_input_field', 'et_quantity_plus_icon' );
		
		add_filter( 'woocommerce_product_description_heading', '__return_false' );
		add_filter( 'woocommerce_product_additional_information_heading', '__return_false' );
		add_filter( 'woocommerce_sale_flash', 'etheme_woocommerce_sale_flash', 20, 3 );
		
		// add_action( 'woocommerce_before_shop_loop', 'woocommerce_pagination', 40 ); // add pagination above the products
		remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
		
		add_action( 'woocommerce_before_shop_loop', function () {
			if ( wc_get_loop_prop( 'is_shortcode' ) ) { ?>
                <div class="filter-wrap">
                <div class="filter-content">
			<?php }
		}, 0 );
		
		add_action( 'woocommerce_before_shop_loop', function () {
			if ( wc_get_loop_prop( 'is_shortcode' ) ) { ?>
                </div>
                </div>
			<?php }
		}, 99999 );
		
		add_action( 'woocommerce_before_shop_loop', function () {
			if ( wc_get_loop_prop( 'is_shortcode' ) ) {
				etheme_shop_filters_sidebar();
			}
		}, 100000 );
		
		// WCFM Marketplace compatibility
		add_action( 'wcfmmp_woocommerce_before_shop_loop_before', function () { ?>
            <div class="filter-wrap">
            <div class="filter-content">
		<?php }, 0 );
		
		add_action( 'wcfmmp_woocommerce_before_shop_loop_after', function () { ?>
            </div>
            </div>
		<?php }, 100000 );
		
		remove_action( 'woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_button_view_cart', 10 );
		
		// ! Change single product main gallery image size
		add_filter( 'woocommerce_gallery_image_size', function ( $size ) {
			return 'woocommerce_single';
		} );
		
		if ( ! class_exists( 'SB_WooCommerce_Infinite_Scroll' ) ) {
			add_action( 'woocommerce_after_shop_loop', 'woocommerce_result_count', 5 );
		}
		
		remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
		add_action( 'woocommerce_before_shop_loop_item', 'woocommerce_show_product_loop_sale_flash', 10 );
		remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
		remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
		remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
		
		/* Remove link open and close on product content */
		remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
		remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
		
		
		if ( ! get_query_var( 'etheme_single_product_builder' ) ) {
			// Change rating position on the single product page
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
			add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 15 );
			add_action( 'woocommerce_single_product_summary', 'etheme_product_share', 50 );
			
			$single_layout        = etheme_get_option( 'single_layout' );
			$single_layout_custom = etheme_get_custom_field( 'single_layout' );
			
			if ( etheme_get_option( 'tabs_location' ) == 'after_image' && etheme_get_option( 'tabs_type' ) != 'disable' && $single_layout != 'large' ) {
				add_action( 'woocommerce_single_product_summary', 'woocommerce_output_product_data_tabs', 61 );
				add_filter( 'et_option_tabs_type', function () {
					return "accordion";
				} );
				if ( etheme_get_option( 'reviews_position' ) == 'outside' ) {
					add_action( 'woocommerce_single_product_summary', 'comments_template', 110 );
				}
			}
			
			if ( ( $single_layout == 'fixed' && ! in_array( $single_layout_custom, array(
						'small',
						'default',
						'xsmall',
						'large',
						'center',
						'wide',
						'right',
						'booking'
					) ) ) || $single_layout_custom == 'fixed' ) {
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 15 );
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
			} else if ( ( $single_layout == 'center' && $single_layout_custom == 'standard' ) || $single_layout_custom == 'center' ) {
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
			} else if ( ( $single_layout == 'wide' && $single_layout_custom == 'standard' ) ||
			            $single_layout_custom == 'wide' ||
			            ( $single_layout == 'right' && $single_layout_custom == 'standard' ) ||
			            $single_layout_custom == 'right' ) {
				if ( is_singular( 'product' ) ) {
					remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
				}
				remove_action( 'woocommerce_before_single_product', 'wc_print_notices', 10 );
				add_action( 'woocommerce_single_product_summary', 'wc_print_notices', 1 );
				add_action( 'woocommerce_single_product_summary', 'woocommerce_breadcrumb', 3 );
				add_action( 'woocommerce_single_product_summary', 'etheme_size_guide', 21 );
			} else if ( ( $single_layout == 'booking' && $single_layout_custom == 'standard' ) || $single_layout_custom == 'booking' ) {
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 15 );
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
				if ( etheme_get_option( 'tabs_location' ) == 'after_image' && etheme_get_option( 'tabs_type' ) != 'disable' ) {
					remove_action( 'woocommerce_single_product_summary', 'woocommerce_output_product_data_tabs', 61 );
				}
				//remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
				//remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );
			} else {
				// Add product categories after title
				add_action( 'woocommerce_single_product_summary', 'etheme_size_guide', 21 );
			}
			
			if ( etheme_get_custom_field( 'sale_counter' ) == 'single' || etheme_get_custom_field( 'sale_counter' ) == 'single_list' ) {
				add_action( 'woocommerce_single_product_summary', 'etheme_product_countdown', 29 );
			}
			
			if ( etheme_get_option( 'reviews_position' ) == 'outside' ) {
				add_filter( 'woocommerce_product_tabs', 'etheme_remove_reviews_from_tabs', 98 );
				add_action( 'woocommerce_after_single_product_summary', 'comments_template', 30 );
			}
			
			if ( get_option( 'yith_wcwl_button_position' ) == 'shortcode' ) {
				add_action( 'woocommerce_after_add_to_cart_button', 'etheme_wishlist_btn', 30 );
			}
		}
		if ( etheme_get_option( 'enable_brands' ) && etheme_get_option( 'show_brand' ) && etheme_get_option( 'brands_location' ) == 'content' ) {
			if ( ! get_query_var( 'etheme_single_product_builder' ) ) {
				add_action( 'woocommerce_single_product_summary', 'etheme_single_product_brands', 11 );
			} else {
				add_action( 'etheme_woocommerce_template_single_excerpt', 'etheme_single_product_brands', 9 );
			}
		}
		if ( etheme_get_option( 'enable_brands' ) && etheme_get_option( 'show_brand' ) && etheme_get_option( 'brands_location' ) == 'under_content' ) {
			add_action( 'woocommerce_product_meta_start', 'etheme_single_product_brands', 2 );
		}
		
		remove_action( 'woocommerce_before_shop_loop', 'wc_print_notices', 10 );
		
		/* Increase avatar size for reviews on product page */
		
		add_filter( 'woocommerce_review_gravatar_size', function () {
			return 80;
		}, 30 );
		
		// ! Remove empty cart message
		remove_action( 'woocommerce_cart_is_empty', 'wc_empty_cart_message', 10 );
		
		// Pagination shop
		add_filter( 'woocommerce_pagination_args', 'et_woocommerce_pagination' );
		
		add_action( 'template_redirect', 'et_wc_track_product_view', 20 );
		
		// 360 view plugin
		if ( class_exists( 'SmartProductPlugin' ) ) {
			remove_filter( 'woocommerce_single_product_image_html', array(
				'SmartProductPlugin',
				'wooCommerceImage'
			), 999, 2 );
		}
		
		remove_action( 'woocommerce_widget_shopping_cart_total', 'woocommerce_widget_shopping_cart_subtotal', 10 );
		add_action( 'woocommerce_widget_shopping_cart_total', 'etheme_woocommerce_widget_shopping_cart_subtotal', 10 );
		
		// if ( etheme_get_option('advanced_stock_status') ) { 
		// add_filter( 'woocommerce_get_stock_html', function($html, $product) {
		//           if ( $product->get_type() == 'simple' && 'yes' === get_option( 'woocommerce_manage_stock' ) )
		//             return et_product_stock_line($product);
		// 	return $html;
		// }, 2, 10);
		// }
        
//        if ( apply_filters('etheme_single_product_variation_gallery', get_query_var( 'etheme_single_product_variation_gallery', false ) ) ) {
	        add_filter( 'woocommerce_available_variation', 'etheme_available_variation_gallery', 90, 3 );
//		add_filter( 'sten_wc_archive_loop_available_variation', 'etheme_available_variation_gallery', 90, 3 );
	
	        add_action( 'woocommerce_admin_process_variation_object', 'et_clear_default_variation_transient_by_variation' );
	        add_action( 'woocommerce_delete_product_transients', 'et_clear_default_variation_transient_by_product' );
	
	        // this add variation gallery filters at loop start and remove it after loop end
	        add_filter( 'woocommerce_product_loop_start', 'remove_et_variation_gallery_filter' );
	        add_filter( 'woocommerce_product_loop_end', 'add_et_variation_gallery_filter' );
//        }
		
		add_filter( 'woocommerce_get_availability_class', 'etheme_wc_get_availability_class', 20, 2 );
		
		add_action( 'et_woocomerce_mini_cart_footer', 'et_woocomerce_mini_cart_footer', 10 );
		
		if ( ! get_query_var( 'etheme_single_product_builder' ) ) {
			add_action( 'woocommerce_single_product_summary', 'etheme_dokan_seller', 11 );
		} else {
			add_action( 'etheme_woocommerce_template_single_excerpt', 'etheme_dokan_seller', 9 );
		}
		
		// set 4 columns for all products output in wc-tabs
		add_action( 'woocommerce_product_tabs', 'etheme_set_loop_props_product_tabs', 1 );
		
		add_action('woocommerce_product_after_tabs', 'etheme_reset_loop_props_product_tabs', 99999);
		
		add_filter('wcfm_store_wrapper_class', function($classes) {
		    return $classes . ' container';
        });
		
	}
}

function etheme_set_loop_props_product_tabs($tabs = array()) {
	wc_set_loop_prop( 'columns_old', wc_get_loop_prop('columns') );
	wc_set_loop_prop( 'columns', 4 );
	return $tabs;
}

function etheme_reset_loop_props_product_tabs () {
	wc_set_loop_prop( 'columns', wc_get_loop_prop('columns_old') );
}

if ( !function_exists('etheme_dokan_seller')) {
	function etheme_dokan_seller() {
		if ( class_exists( 'WeDevs_Dokan' ) || class_exists( 'Dokan_Pro' ) ) {
			global $product;
			$seller = get_post_field( 'post_author', $product->get_id() );
			$author = get_user_by( 'id', $seller );
			
			$store_info = dokan_get_store_info( $author->ID );
			
			if ( ! empty( $store_info['store_name'] ) ) { ?>
                <span class="product_seller">
	            <?php printf( '<a href="%s" class="by-vendor-name-link">%s %s</a>', dokan_get_store_url( $author->ID ), esc_html__( 'Sold by', 'xstore' ), $store_info['store_name'] ); ?>
	        </span>
				<?php
			}
		}
		
	}
}

if ( ! function_exists( 'etheme_shop_filters_sidebar' ) ) {
	function etheme_shop_filters_sidebar() {
		if ( is_active_sidebar( 'shop-filters-sidebar' ) ): ?>
            <div class="shop-filters widget-columns-<?php echo etheme_get_option( 'filters_columns' ); ?><?php echo ( etheme_get_option( 'filter_opened' ) ) ? ' filters-opened' : ''; ?>">
                <div class="shop-filters-area">
					<?php if ( ! function_exists( 'dynamic_sidebar' ) || ! dynamic_sidebar( 'shop-filters-sidebar' ) ): ?>
					<?php endif; ?>
                </div>
            </div>
		<?php endif;
	}
}

if ( ! function_exists( 'et_woocomerce_mini_cart_footer' ) ) {
	function et_woocomerce_mini_cart_footer() {
		global $woocommerce;
		if ( ! WC()->cart->is_empty() ) : ?>

            <div class="product_list-popup-footer-wrapper">

                <div class="product_list-popup-footer-inner">

                    <div class="cart-popup-footer">
                        <a href="<?php echo esc_url( wc_get_cart_url() ); ?>"
                           class="btn-view-cart wc-forward"><?php esc_html_e( 'Shopping cart ', 'xstore' ); ?>
                            (<?php echo WC()->cart->cart_contents_count; ?>)</a>
                        <div class="cart-widget-subtotal woocommerce-mini-cart__total total">
							<?php
							/**
							 * Woocommerce_widget_shopping_cart_total hook.
							 *
							 * @hooked woocommerce_widget_shopping_cart_subtotal - 10
							 */
							do_action( 'woocommerce_widget_shopping_cart_total' );
							?>
                        </div>
                    </div>
					
					<?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>

                    <p class="buttons mini-cart-buttons">
						<?php do_action( 'woocommerce_widget_shopping_cart_buttons' ); ?>
                    </p>
					
					<?php do_action( 'woocommerce_widget_shopping_cart_after_buttons' ); ?>

                </div>

            </div>
		
		<?php endif;
	}
}

if ( ! function_exists( 'etheme_wc_get_availability_class' ) ) {
	function etheme_wc_get_availability_class( $class, $product ) {
		$stock_quantity = $product->get_stock_quantity();
		$stock_class    = 'step-1';
		$already_sold   = get_post_meta( $product->get_ID(), 'total_sales', true );
		
		if ( ! empty( $stock_quantity ) && (int) $stock_quantity > 0 && get_option( 'woocommerce_manage_stock' ) ) {
			$already_sold     = empty( $already_sold ) ? 0 : $already_sold;
			$all_stock        = $stock_quantity + $already_sold;
			$stock_line_inner = 100 - ( ( $already_sold * 100 ) / $all_stock );
			if ( $stock_quantity <= get_option( 'woocommerce_notify_low_stock_amount' ) ) {
				$stock_class = 'step-3';
			} elseif ( $stock_line_inner > 50 ) {
				$stock_class = 'step-1';
			} else {
				$stock_class = 'step-2';
			}
		}
		
		if ( $product->is_in_stock() ) {
			$class .= ' ' . $stock_class;
		}
		
		return $class;
	}
}

function et_product_stock_line( $product ) {
	$stock_line     = '';
	$stock_quantity = $product->get_stock_quantity();
	$already_sold   = get_post_meta( $product->get_ID(), 'total_sales', true );
	
	if ( ! empty( $stock_quantity ) ) {
		$already_sold = empty( $already_sold ) ? 0 : $already_sold;
		$all_stock    = $stock_quantity + $already_sold;
		ob_start();
		$stock_line_inner = ( ( $already_sold * 100 ) / $all_stock );
		if ( $stock_quantity <= get_option( 'woocommerce_notify_low_stock_amount' ) ) {
			$stock_class = 'step-3';
		} elseif ( ( 100 - $stock_line_inner ) > 50 ) {
			$stock_class = 'step-1';
		} else {
			$stock_class = 'step-2';
		}
		?>
        <div class="product-stock <?php echo esc_attr( $stock_class ); ?>">
            <span class="stock-in"><?php echo esc_html__( 'Available:', 'xstore' ) . ' <span class="stock-count">' . $stock_quantity . '</span>'; ?></span>
            <span class="stock-out"><?php echo esc_html__( 'Sold:', 'xstore' ) . ' <span class="stock-count">' . $already_sold . '</span>'; ?></span>
            <span class="stock-line"><span class="stock-line-inner"
                                           style="width: <?php echo esc_attr( $stock_line_inner ); ?>%"></span></span>
        </div>
		<?php $stock_line = ob_get_clean();
	}
	
	return $stock_line;
}

function et_quantity_plus_icon() {
	echo '<span value="+" class="plus"><i class="et-icon et-plus"></i></span>';
}

function et_quantity_minus_icon() {
	echo '<span value="-" class="minus"><i class="et-icon et-minus"></i></span>';
}

if ( ! function_exists( 'et_wc_track_product_view' ) ) {
	function et_wc_track_product_view() {
		if ( ! is_singular( 'product' ) && ! get_query_var( 'recently_viewed', 0 ) ) {
			return;
		}
		
		global $post;
		
		if ( empty( $_COOKIE['woocommerce_recently_viewed'] ) ) { // @codingStandardsIgnoreLine.
			$viewed_products = array();
		} else {
			$viewed_products = wp_parse_id_list( (array) explode( '|', wp_unslash( $_COOKIE['woocommerce_recently_viewed'] ) ) ); // @codingStandardsIgnoreLine.
		}
		
		// Unset if already in viewed products list.
		$keys = array_flip( $viewed_products );
		
		if ( isset( $keys[ $post->ID ] ) ) {
			unset( $viewed_products[ $keys[ $post->ID ] ] );
		}
		
		$viewed_products[] = $post->ID;
		
		if ( count( $viewed_products ) > 15 ) {
			array_shift( $viewed_products );
		}
		
		// Store for session only.
		wc_setcookie( 'woocommerce_recently_viewed', implode( '|', $viewed_products ) );
	}
}

// because of btn-checkout class name
function woocommerce_widget_shopping_cart_proceed_to_checkout() {
	echo '<a href="' . esc_url( wc_get_checkout_url() ) . '" class="button btn-checkout wc-forward">' . esc_html__( 'Checkout', 'xstore' ) . '</a>';
}

if ( ! function_exists( 'etheme_woocommerce_widget_shopping_cart_subtotal' ) ) {
	function etheme_woocommerce_widget_shopping_cart_subtotal() {
		echo '<span class="small-h">' . esc_html__( 'Subtotal:', 'xstore' ) . '</span> <span class="big-coast">' . WC()->cart->get_cart_subtotal() . '</span>';
	}
}

if ( ! function_exists( 'etheme_product_share' ) ) {
	function etheme_product_share() {
		if ( etheme_get_option( 'share_icons' ) ):
			global $product; ?>
            <div class="product-share">
				<?php echo do_shortcode( '[share title="' . __( 'Share: ', 'xstore' ) . '"]' ); ?>
            </div>
		<?php endif;
	}
}

if ( ! function_exists( 'etheme_single_product_brands' ) ) :
	function etheme_single_product_brands() {
		if ( etheme_xstore_plugin_notice() ) {
			return;
		}
		global $post;
		$terms = wp_get_post_terms( $post->ID, 'brand' );
		$brand = etheme_get_option( 'brand_title' );
		if ( count( $terms ) < 1 ) {
			return;
		}
		$_i = 0;
		?>
        <span class="product_brand">
			<?php if ( $brand ) {
				esc_html_e( 'Brand: ', 'xstore' );
			} ?>
			<?php foreach ( $terms as $brand ) : $_i ++; ?>
				<?php
				$thumbnail_id = absint( get_term_meta( $brand->term_id, 'thumbnail_id', true ) ); ?>
                <a href="<?php echo get_term_link( $brand ); ?>">
							<?php if ( $thumbnail_id ) {
								echo wp_get_attachment_image( $thumbnail_id, 'full' );
							} else { ?>
								<?php echo esc_html( $brand->name ); ?>
							<?php } ?>
						</a>
				<?php if ( count( $terms ) > $_i ) {
					echo ", ";
				} ?>
			<?php endforeach; ?>
			</span>
		<?php
	}
endif;

// Woocommerce pagination

if ( ! function_exists( 'et_woocommerce_pagination' ) ) {
	function et_woocommerce_pagination() {
		
		$args = array(
			'total'   => wc_get_loop_prop( 'total_pages' ),
			'current' => wc_get_loop_prop( 'current_page' ),
			'base'    => esc_url_raw( add_query_arg( 'product-page', '%#%', false ) ),
			'format'  => '?product-page=%#%',
		);
		
		$format = isset( $format ) ? $format : '';
		$base   = esc_url_raw( add_query_arg( 'product-page', '%#%', false ) );
		
		if ( ! wc_get_loop_prop( 'is_shortcode' ) ) {
			$format = '';
			$base   = esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', wp_specialchars_decode( get_pagenum_link( 999999999 ) ) ) ) );
		}
		
		$total   = isset( $total ) ? $total : wc_get_loop_prop( 'total_pages' );
		$current = isset( $current ) ? $current : wc_get_loop_prop( 'current_page' );
		
		$et_per_page  = ( isset( $_REQUEST['et_per_page'] ) ) ? $_REQUEST['et_per_page'] : etheme_get_option( 'products_per_page' );
		$selected_val = ( isset( $_POST['et_per_page'] ) ) ? $_POST['et_per_page'] : $et_per_page;
		
		return array(
			'base'      => $base,
			'format'    => $format,
			'add_args'  => ( ! wc_get_loop_prop( 'is_shortcode' ) ? array( 'et_per_page' => $selected_val ) : false ),
			'current'   => max( 1, $current ),
			'total'     => $total,
			'prev_text' => '<i class="et-icon et-left-arrow"></i>',
			'next_text' => '<i class="et-icon et-right-arrow"></i>',
			'type'      => 'list',
			'end_size'  => 1,
			'mid_size'  => 1,
		);
	}
}

if ( ! function_exists( 'etheme_additional_information' ) ) {
	function etheme_additional_information() {
		global $product;
		?>
        <div class="product-attributes"><?php do_action( 'woocommerce_product_additional_information', $product ); ?></div>
		<?php
	}
}

if ( ! function_exists( 'etheme_get_single_product_class' ) ) {
	function etheme_get_single_product_class( $layout ) {
		$classes           = array();
		$classes['layout'] = $layout;
		$classes['class']  = 'tabs-' . etheme_get_option( 'tabs_location' );
		$classes['class']  .= ' single-product-' . $layout;
		$classes['class']  .= ' reviews-position-' . etheme_get_option( 'reviews_position' );
		
		if ( etheme_get_option( 'ajax_addtocart' ) ) {
			$classes['class'] .= ' ajax-cart-enable';
		}
		if ( etheme_get_option( 'single_product_hide_sidebar' ) ) {
			$classes['class'] .= ' sidebar-mobile-hide';
		}
		if ( etheme_get_option( 'product_name_signle' ) ) {
			$classes['class'] .= ' hide-product-name';
		}
		
		if ( $layout != 'large' ) {
			if ( etheme_get_option( 'fixed_images' ) && $layout != 'fixed' ) {
				$classes['class'] .= ' product-fixed-images';
			} else if ( etheme_get_option( 'fixed_content' ) || $layout == 'fixed' ) {
				$classes['class'] .= ' product-fixed-content';
			}
		}
		
		switch ( $layout ) {
			case 'small':
				$classes['image_class'] = 'col-lg-4 col-md-5 col-sm-12';
				$classes['infor_class'] = 'col-lg-8 col-md-7 col-sm-12';
				break;
			case 'large':
				$classes['image_class'] = 'col-sm-12';
				$classes['infor_class'] = 'col-lg-6 col-md-6 col-sm-12';
				break;
			case 'xsmall':
				$classes['image_class'] = 'col-lg-9 col-md-8 col-sm-12';
				$classes['infor_class'] = 'col-lg-3 col-md-4 col-sm-12';
				break;
			case 'fixed':
				$classes['image_class'] = 'col-sm-6';
				$classes['infor_class'] = 'col-lg-3 col-md-3 col-sm-12';
				break;
			case 'center':
				$classes['image_class'] = 'col-lg-4 col-md-4 col-sm-12';
				$classes['infor_class'] = 'col-lg-4 col-md-4 col-sm-12';
				break;
			default:
				$classes['image_class'] = 'col-lg-6 col-md-6 col-sm-12';
				$classes['infor_class'] = 'col-lg-6 col-md-6 col-sm-12';
				break;
		}
		
		return $classes;
	}
}

if ( ! function_exists( 'etheme_360_view_block' ) ) {
	function etheme_360_view_block() {
		global $post;
		$post_id = $post->ID;
		
		if ( ! class_exists( 'SmartProductPlugin' ) ) {
			return;
		}
		
		$smart_product = get_post_meta( $post_id, "smart_product_meta", true );
		
		// Check if id set
		if ( ! isset( $smart_product['id'] ) || $smart_product['id'] == "" ) {
			return '';
		}
		
		// Create slider instance
		$slider = new ThreeSixtySlider( $smart_product );
		
		?>
        <a href="#product-360-popup" class="open-360-popup"><?php esc_html_e( 'Open 360 view', 'xstore' ); ?></a>
		
		<?php echo '<div id="product-360-popup" class="product-360-popup mfp-hide">';
		echo $slider->show();
		echo '</div>'; ?>
	<?php }
}

// **********************************************************************//
// ! After products widget area
// **********************************************************************//

if ( ! function_exists( 'etheme_after_products_widgets' ) ) {
	function etheme_after_products_widgets() {
		echo '<div class="after-products-widgets">';
		dynamic_sidebar( 'shop-after-products' );
		echo '</div>';
	}
}


// **********************************************************************//
// ! Product sale countdown
// **********************************************************************//

if ( ! function_exists( 'etheme_product_countdown' ) ) {
	function etheme_product_countdown( $type = 'type2' ) {
		$date       = get_post_meta( get_the_ID(), '_sale_price_dates_to', true );
		$date_from  = get_post_meta( get_the_ID(), '_sale_price_dates_from', true );
		$time_start = get_post_meta( get_the_ID(), '_sale_price_time_start', true );
		$time_start = explode( ':', $time_start );
		$time_end   = get_post_meta( get_the_ID(), '_sale_price_time_end', true );
		$time_end   = explode( ':', $time_end );
		if ( ! $date_from ) {
			$data_from = strtotime( "now" );
		}
		if ( ! $date || ! class_exists( 'ETC\App\Controllers\Shortcodes\Countdown' ) ) {
			return false;
		}
		
		echo ETC\App\Controllers\Shortcodes\Countdown::countdown_shortcode( array(
			'year'   => date( 'Y', $date ),
			'month'  => date( 'M', $date ),
			'day'    => date( 'd', $date ),
			'hour'   => ( isset( $time_end[0] ) && $time_end[0] > 0 ) ? $time_end[0] : '00',
			'minute' => isset( $time_end[1] ) ? $time_end[1] : '00',
			
			'start_year'   => date( 'Y', (int) $date_from ),
			'start_month'  => date( 'M', (int) $date_from ),
			'start_day'    => date( 'd', (int) $date_from ),
			'start_hour'   => ( isset( $time_start[0] ) && $time_start[0] > 0 ) ? $time_start[0] : '00',
			'start_minute' => isset( $time_start[1] ) ? $time_start[1] : '00',
			'type'         => ( isset( $type ) && ! empty( $type ) ) ? $type : 'type2',
			'scheme'       => etheme_get_option( 'dark_styles' ) ? 'white' : 'dark',
			'class'        => 'product-sale-counter'
		) );
	}
}


// **********************************************************************//
// ! Wishlist
// **********************************************************************//

if ( ! function_exists( 'etheme_wishlist_btn' ) ) {
	function etheme_wishlist_btn( $args = array() ) {
		if ( ! class_exists( 'YITH_WCWL_Shortcode' ) ) {
			return;
		}
		
		// $args['type'] = etheme_get_option('single_wishlist_type');
		// $args['position'] = etheme_get_option('single_wishlist_position');
		// $args['type'] = ( $args['type'] ) ? $args['type'] : 'icon-text';
		// $args['position'] = ( $args['position'] ) ? $args['position'] : 'under';
		
		if ( ! is_array( $args ) ) {
			$args = array();
		}
		
		$args['type']     = ( isset( $args['type'] ) ) ? $args['type'] : 'icon-text';
		$args['position'] = ( isset( $args['position'] ) ) ? $args['position'] : 'under';
		$args['class']    = ( isset( $args['class'] ) ) ? $args['class'] : '';
		
		$out = '<div class="et-wishlist-holder type-' . $args['type'] . ' position-' . $args['position'] . ' ' . $args['class'] . '">';
		$out .= do_shortcode( '[yith_wcwl_add_to_wishlist]' );
		$out .= '</div>';
		
		return $out;
	}
}

if ( ! function_exists( 'etheme_remove_reviews_from_tabs' ) ) {
	function etheme_remove_reviews_from_tabs( $tabs ) {
		unset( $tabs['reviews'] );            // Remove the reviews tab
		
		return $tabs;
		
	}
}


if ( ! function_exists( 'etheme_compare_css' ) ) {
	add_action( 'wp_print_styles', 'etheme_compare_css', 200 );
	function etheme_compare_css() {
		if ( ! class_exists( 'YITH_Woocompare' ) ) {
			return;
		}
		if ( ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) && ( ! isset( $_REQUEST['action'] ) || $_REQUEST['action'] != 'yith-woocompare-view-table' ) ) {
			return;
		}
		wp_enqueue_style( 'parent-style' );
	}
}

// **********************************************************************//
// ! Catalog setup
// **********************************************************************//

add_action( 'after_setup_theme', 'etheme_catalog_setup', 50 );

if ( ! function_exists( 'etheme_catalog_setup' ) ) {
	function etheme_catalog_setup() {
		if ( is_admin() ) {
			return;
		}
		$just_catalog = etheme_get_option( 'just_catalog' );
		
		if ( $just_catalog ) {
			#remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
			//remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
			remove_action( 'woocommerce_simple_add_to_cart', 'woocommerce_simple_add_to_cart', 30 );
			// remove_action( 'woocommerce_grouped_add_to_cart', 'woocommerce_grouped_add_to_cart', 30 );
			//remove_action( 'woocommerce_variable_add_to_cart', 'woocommerce_variable_add_to_cart', 30 );
			remove_action( 'woocommerce_single_variation', 'woocommerce_single_variation_add_to_cart_button', 20 );
			remove_action( 'woocommerce_external_add_to_cart', 'woocommerce_external_add_to_cart', 30 );
			
			add_filter( 'woocommerce_loop_add_to_cart_link', 'etheme_add_to_cart_catalog_button', 50, 3 );
			
		}
		
		// **********************************************************************//
		// ! Set number of products per page
		// **********************************************************************//
		$products_per_page = isset( $_REQUEST['et_per_page'] ) ? $_REQUEST['et_per_page'] : etheme_get_option( 'products_per_page' );
		add_filter( 'loop_shop_per_page', function () use ( $products_per_page ) {
			return $products_per_page;
		}, 50 );
	}
}

if ( ! function_exists( 'etheme_add_to_cart_catalog_button' ) ) {
	function etheme_add_to_cart_catalog_button( $sprintf, $product, $args ) {
		return sprintf( '<a rel="nofollow" href="%s" class="button show-product">%s</a>',
			esc_url( $product->get_permalink() ),
			__( 'Show details', 'xstore' )
		);
	}
}

if ( ! function_exists( 'etheme_before_fix_just_catalog_link' ) ) {
	function etheme_before_fix_just_catalog_link() {
		add_filter( 'woocommerce_loop_add_to_cart_link', 'etheme_add_to_cart_catalog_button', 50, 3 );
	}
}

if ( ! function_exists( 'etheme_after_fix_just_catalog_link' ) ) {
	function etheme_after_fix_just_catalog_link() {
		remove_filter( 'woocommerce_loop_add_to_cart_link', 'etheme_add_to_cart_catalog_button', 50, 3 );
	}
}

// **********************************************************************//
// ! Define image sizes
// **********************************************************************//
if ( ! function_exists( 'etheme_woocommerce_image_dimensions' ) ) {
	function etheme_woocommerce_image_dimensions() {
		global $pagenow;
		
		if ( ! isset( $_GET['activated'] ) || $pagenow != 'themes.php' ) {
			return;
		}
		
		$catalog = array(
			'width'  => '555',    // px
			'height' => '760',    // px
			'crop'   => 0        // true
		);
		
		$single = array(
			'width'  => '720',    // px
			'height' => '961',    // px
			'crop'   => 0        // true
		);
		
		$thumbnail = array(
			'width'  => '205',    // px
			'height' => '272',    // px
			'crop'   => 0        // false
		);
		
		// Image sizes
		update_option( 'shop_catalog_image_size', $catalog );        // Product category thumbs
		update_option( 'shop_single_image_size', $single );        // Single product image
		update_option( 'shop_thumbnail_image_size', $thumbnail );    // Image gallery thumbs
	}
}

add_action( 'after_switch_theme', 'etheme_woocommerce_image_dimensions', 1 );

// **********************************************************************//
// ! AJAX Quick View
// **********************************************************************//

add_action( 'wp_ajax_etheme_product_quick_view', 'etheme_product_quick_view' );
add_action( 'wp_ajax_nopriv_etheme_product_quick_view', 'etheme_product_quick_view' );
if ( ! function_exists( 'etheme_product_quick_view' ) ) {
	function etheme_product_quick_view() {
		if ( empty( $_POST['prodid'] ) ) {
			echo 'Error: Absent product id';
			die();
		}
		
		$args = array(
			'p'                => (int) $_POST['prodid'],
			'post_type'        => 'product',
		);
		
		if ( class_exists( 'SmartProductPlugin' ) ) {
			remove_filter( 'woocommerce_single_product_image_html', array(
				'SmartProductPlugin',
				'wooCommerceImage'
			), 999, 2 );
		}
		
		$the_query = new WP_Query( $args );
		if ( $the_query->have_posts() ) {
			while ( $the_query->have_posts() ) : $the_query->the_post();
				if ( etheme_get_option( 'quick_view_content_type' ) == 'off_canvas' ) {
					wc_get_template( 'product-quick-view-canvas.php' );
				} else {
					wc_get_template( 'product-quick-view.php' );
				}
			endwhile;
			wp_reset_query();
			wp_reset_postdata();
		} else {
			echo 'No posts were found!';
		}
		die();
	}
}

if ( ! function_exists( 'etheme_size_guide' ) ) {
	function etheme_size_guide() {
		
		$global_guide = etheme_get_option( 'size_guide_img' );
		$local_guide  = etheme_get_custom_field( 'size_guide_img' );
		$global_type  = etheme_get_option( 'size_guide_type' );
		$local_type   = etheme_get_custom_field( 'size_guide_type' );
		$global_type  = $local_type != '' ? $local_type : $global_type;
		$size_file    = etheme_get_option( 'size_guide_file' );
		$size_file    = etheme_get_option( 'size_guide_file' );
		$attr         = array();
		
		if ( $local_guide ) {
			$image = $local_guide;
		} elseif ( $global_type == 'popup' && isset( $global_guide['url'] ) ) {
			$image = $global_guide['url'];
		} elseif ( $global_type == 'download_button' && ! empty( $size_file ) ) {
			$image = $size_file;
		} else {
			$image = '';
		}
		
		if ( ! empty( $image ) ) : ?>
			<?php
			$attr[] = 'href="' . esc_url( $image ) . '"';
			if ( $global_type == 'popup' ) {
				$attr[] = 'rel="lightbox"';
			} else {
				$attr[] = 'download="' . wp_basename($image) . '"';
			}
			
			?>
            <div class="size-guide">
                <a <?php echo implode( ' ', $attr ); ?>><?php esc_html_e( 'Sizing guide', 'xstore' ); ?></a>
            </div>
		<?php endif;
	}
}

if ( ! function_exists( 'etheme_product_cats' ) ) {
	function etheme_product_cats( $single = false ) {
		global $post, $product;
		$cat  = etheme_get_custom_field( 'primary_category' );
		$html = '';
		if ( ! empty( $cat ) && $cat != 'auto' ) {
			$primary = get_term_by( 'slug', $cat, 'product_cat' );
			if ( ! is_wp_error( $primary ) ) {
				$term_link = get_term_link( $primary );
				if ( ! is_wp_error( $term_link ) ) {
					if ( $single ) {
						$html .= '<span class="posted_in">' . esc_html__( 'Category: ', 'xstore' ) . '<a href="' . esc_url( $term_link ) . '">' . $primary->name . '</a></span>';
					} else {
						$html .= '<a href="' . esc_url( $term_link ) . '">' . $primary->name . '</a>';
					}
				}
			}
		} else {
			if ( $single ) {
				$html .= wc_get_product_category_list( $product->get_id(), ', ', '<span class="posted_in">' . _n( 'Category:', 'Categories:', count( $product->get_category_ids() ), 'xstore' ) . ' ', '</span>' );
			} else {
				$html .= wc_get_product_category_list( $product->get_id(), ', ' );
			}
		}
		if ( $html ) {
			echo '<div class="products-page-cats">' . $html . '</div>';
		}
	}
}

// **********************************************************************//
// ! Get list of all product brands
// **********************************************************************//
if ( ! function_exists( 'etheme_product_brands' ) ) :
	function etheme_product_brands() {
		if ( etheme_xstore_plugin_notice() ) {
			return;
		}
		global $post;
		$terms = wp_get_post_terms( $post->ID, 'brand' );
		if ( is_wp_error( $terms ) || $terms == '' || ( is_array( $terms ) && count( $terms ) < 1 ) ) {
			return;
		}
		$_i = 0;
		
		?>
        <div class="products-page-brands">
			<?php foreach ( $terms as $brand ) : $_i ++; ?>
                <a href="<?php echo get_term_link( $brand ); ?>"
                   class="view-products"><?php echo esc_html( $brand->name ); ?></a>
				<?php if ( count( $terms ) > $_i ) {
					echo ", ";
				} ?>
			<?php endforeach; ?>
        </div>
		<?php
	}
endif;

// **********************************************************************//
// ! Get list of all product images
// **********************************************************************//

if ( ! function_exists( 'etheme_get_image_list' ) ) {
	function etheme_get_image_list( $size = 'shop_catalog' ) {
		global $post, $product, $woocommerce;
		$images_string = '';
		
		$attachment_ids = $product->get_gallery_image_ids();
		
		$_i = 0;
		
		if ( count( $attachment_ids ) > 0 ) {
			$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), $size );
			if ( is_array( $image ) && isset( $image[0] ) ) {
				$images_string .= $image[0];
			}
			foreach ( $attachment_ids as $id ) {
				$_i ++;
				$image = wp_get_attachment_image_src( $id, $size );
				if ( $image == '' ) {
					continue;
				}
				if ( $_i == 1 && $images_string != '' ) {
					$images_string .= ',';
				}
				
				
				$images_string .= $image[0];
				
				if ( $_i != count( $attachment_ids ) ) {
					$images_string .= ',';
				}
			}
			
		}
		
		return $images_string;
	}
}


// **********************************************************************//
// ! Display second image in the gallery
// **********************************************************************//

if ( ! function_exists( 'etheme_get_second_image' ) ) {
	function etheme_get_second_image( $size = 'shop_catalog' ) {
		global $product, $woocommerce_loop;
		$attachment_ids = $product->get_gallery_image_ids();
		
		$image = '';
		
		if ( ! empty( $attachment_ids[0] ) ) {
			$image = wp_get_attachment_image( $attachment_ids[0], $size );
		}
		
		if ( $image != '' ) {
			echo '<div class="image-swap">' . $image . '</div>';
		}
		
		
	}
}


// **********************************************************************//
// ! Out image html for swiper lazy
// **********************************************************************//
if ( ! function_exists( 'etheme_lazy_swiper_image' ) ) :
	
	function etheme_lazy_swiper_image( $id, $size = 'shop_catalog', $type, $echo = true ) {
		if ( ! $id || ! $type ) {
			return;
		}
		
		$image_size = apply_filters( 'single_product_archive_thumbnail_size', $size );
		
		if ( $type == 'main' ) {
			$id = get_post_thumbnail_id( $id );
		} else {
			$product        = wc_get_product( $id );
			$attachment_ids = $product->get_gallery_image_ids();
			if ( ! $attachment_ids ) {
				return;
			}
			$id = $attachment_ids[0];
		}
		
		list( $src, $width, $height ) = wp_get_attachment_image_src( $id, $image_size );
		
		// ! Fix for old products with parent product image
		if ( ! $src && $type == 'main' ) {
			global $product;
			if ( $product ) {
				$parent_id = $product->get_parent_id();
				$id        = get_post_thumbnail_id( $parent_id );
				list( $src, $width, $height ) = wp_get_attachment_image_src( $id, $image_size );
			}
		}
		
		if ( ! $src ) {
			$src = wc_placeholder_img_src();
		}
		
		$image_meta = wp_get_attachment_metadata( $id );
		
		
		$l_type = '';
		if ( defined( 'ET_CORE_VERSION' ) && !isset($_GET['vc_editable']) ) {
			$l_type = Kirki::get_option( 'images_loading_type_et-desktop' );
		}
		
		$attr = array(
			'alt'   => trim( strip_tags( get_post_meta( $id, '_wp_attachment_image_alt', true ) ) ),
			'class' => '' . ( ( $type == 'main' ) ? ' wp-post-image' : '' ),
		);
		
		if ( $l_type != 'default' ) {
			$attr['data-src']   = $src;
			$attr['data-o_src'] = $src;
			$attr['class']      .= ' swiper-lazy';
		} else {
			$attr['src'] = $src;
		}
		
		if ( $l_type == 'lqip' ) {
			$placeholder   = wp_get_attachment_image_src( $id, 'etheme-woocommerce-nimi' );
			if ($placeholder){
				$attr['src']   = $placeholder[0];
			}
			$attr['style'] = 'width:100%; height:100%;';
			$attr['class'] .= ' lazyload lazyload-lqip';
		} elseif ( $l_type == 'lazy' ) {
			$attr['class'] .= ' lazyload lazyload-simple';
		}
		
		$out = '<img';
		foreach ( $attr as $key => $value ) {
			if ( $value ) {
				$out .= " $key=" . '"' . $value . '"';
			}
		}
		$out .= ' />';
		
		if ( $echo ) {
			echo wp_specialchars_decode( $out );
		} else {
			return $out;
		}
	}
endif;

// **********************************************************************//
// ! Get product availability
// **********************************************************************//

if ( ! function_exists( 'etheme_product_availability' ) ) {
	function etheme_product_availability() {
		if ( ! etheme_get_option( 'out_of_icon' ) ) {
			return;
		}
		global $product;
		// Availability
		$availability      = $product->get_availability();
		$availability_html = empty( $availability['availability'] ) ? '' : '<p class="stock ' . esc_attr( $availability['class'] ) . '">' . esc_html( $availability['availability'] ) . '</p>';
		
		echo apply_filters( 'woocommerce_stock_html', $availability_html, $availability['availability'], $product );
	}
}

// **********************************************************************//
// ! Grid/List switcher
// **********************************************************************//
add_action( 'woocommerce_before_shop_loop', 'etheme_grid_list_switcher', 35 );
if ( ! function_exists( 'etheme_grid_list_switcher' ) ) {
	function etheme_grid_list_switcher() {
		global $wp;
		
		// prevent filter button from products shortcode
		if ( wc_get_loop_prop( 'is_shortcode' ) || is_tax('dc_vendor_shop') ) {
			return;
		}
		
		$current_url = home_url( $wp->request );
		
		$view_mode = etheme_get_option( 'view_mode' );
		
		if ( in_array( $view_mode, array( 'grid', 'list' ) ) ) {
			return;
		}
		
		$url_grid = add_query_arg( 'view_mode', 'grid', remove_query_arg( 'view_mode', $current_url ) );
		$url_list = add_query_arg( 'view_mode', 'list', remove_query_arg( 'view_mode', $current_url ) );
		
		$current = get_query_var( 'et_view-mode' );
		?>
        <div class="view-switcher hidden-tablet hidden-phone">
            <label><?php esc_html_e( 'View as:', 'xstore' ); ?></label>
			<?php if ( $view_mode == 'grid_list' ): ?>
                <div class="switch-grid <?php if ( $current == 'grid' ) {
					echo 'switcher-active';
				} ?>">
                    <a href="<?php echo esc_url( $url_grid ); ?>"><?php esc_html_e( 'Grid', 'xstore' ); ?></a>
                </div>
                <div class="switch-list <?php if ( $current == 'list' ) {
					echo 'switcher-active';
				} ?>">
                    <a href="<?php echo esc_url( $url_list ); ?>"><?php esc_html_e( 'List', 'xstore' ); ?></a>
                </div>
			<?php elseif ( $view_mode == 'list_grid' ): ?>
                <div class="switch-list <?php if ( $current == 'list' ) {
					echo 'switcher-active';
				} ?>">
                    <a href="<?php echo esc_url( $url_list ); ?>"><?php esc_html_e( 'List', 'xstore' ); ?></a>
                </div>
                <div class="switch-grid <?php if ( $current == 'grid' ) {
					echo 'switcher-active';
				} ?>">
                    <a href="<?php echo esc_url( $url_grid ); ?>"><?php esc_html_e( 'Grid', 'xstore' ); ?></a>
                </div>
			<?php endif; ?>
        </div>
		<?php
	}
}


// **********************************************************************//
// ! View mode
// **********************************************************************//

// ! Get view mode
if ( ! function_exists( 'etheme_get_view_mode' ) ) {
	function etheme_get_view_mode() {
		$current = 'grid';
		if ( is_customize_preview() ) {
			$mode = etheme_get_option( 'view_mode' );
			if ( $mode == 'list_grid' || $mode == 'list' ) {
				$current = 'list';
			}
			
			return $current;
		}
		if ( class_exists( 'WC_Session_Handler' ) && ! is_admin() ) {
			$s = WC()->session;
			
			if ( $s == null ) {
				return $current;
			}
			
			$s    = $s->__get( 'view_mode', 0 );
			$mode = etheme_get_option( 'view_mode' );
			
			if ( isset( $_REQUEST['view_mode'] ) ) {
				$current = ( $_REQUEST['view_mode'] );
			} elseif ( isset( $s ) && ! empty( $s ) ) {
				$current = ( $s );
			} elseif ( $mode == 'list_grid' || $mode == 'list' ) {
				$current = 'list';
			}
		}
		
		return $current;
	}
}

// ! Set view mode
if ( ! function_exists( 'etheme_view_mode_action' ) ) {
	add_action( 'init', 'etheme_view_mode_action', 100 );
	function etheme_view_mode_action() {
		if ( isset( $_REQUEST['view_mode'] ) && class_exists( 'WC_Session_Handler' ) ) {
			$s = WC()->session;
			if ( $s != null ) {
				$s->set( 'view_mode', ( $_REQUEST['view_mode'] ) );
			}
		}
	}
}

// **********************************************************************//
// ! Filters button
// **********************************************************************//

add_action( 'woocommerce_before_shop_loop', 'etheme_filters_btn', 11 );
if ( ! function_exists( 'etheme_filters_btn' ) ) {
	function etheme_filters_btn() {
		if ( ! wc_get_loop_prop( 'is_shortcode' ) ) { // prevent filter button from products shortcode
			if ( is_active_sidebar( 'shop-filters-sidebar' ) ) {
				?>
                <div class="open-filters-btn">
                    <a href="#" class="<?php echo ( etheme_get_option( 'filter_opened' ) ) ? ' active' : ''; ?>">
                        <i class="et-icon et-controls"></i>
						<?php esc_html_e( 'Filters', 'xstore' ); ?>
                    </a>
                </div>
				<?php
			}
		}
	}
}

// **********************************************************************//
// ! Productes per page dropdown
// **********************************************************************//
add_action( 'woocommerce_before_shop_loop', 'etheme_products_per_page_select', 37 );
if ( ! function_exists( 'etheme_products_per_page_select' ) ) {
	function etheme_products_per_page_select() {
		global $wp_query;
		
		// prevent filter button from products shortcode
		if ( wc_get_loop_prop( 'is_shortcode' ) ) {
			return;
		}
		
		$action = $cat = $out = $et_ppp = $per_page = $class = '';
		
		if ( is_active_sidebar( 'shop-filters-sidebar' ) ) {
			$class .= ' et-hidden-phone';
		}
		$cat      = $wp_query->get_queried_object();
		$et_ppp   = etheme_get_option( 'et_ppp_options' );
		$et_ppp   = ( ! empty( $et_ppp ) ) ? explode( ',', $et_ppp ) : array( 12, 24, 36, - 1 );
		$action   = ( isset( $cat->term_id ) ) ? get_term_link( $cat->term_id ) : esc_url_raw( get_pagenum_link() );
		$per_page = ( isset( $_REQUEST['et_per_page'] ) ) ? $_REQUEST['et_per_page'] : etheme_get_option( 'products_per_page' );
		
		$out .= '<span>' . esc_html__( 'Show', 'xstore' ) . '</span>';
		$out .= '<form method="post" action="' . esc_url( $action ) . '">';
		$out .= '<select name="et_per_page" onchange="this.form.submit()" class="et-per-page-select">';
		foreach ( $et_ppp as $key => $value ) {
			$out .= sprintf(
				'<option value="%s" %s>%s</option>',
				esc_attr( $value ),
				selected( $value, $per_page, false ),
				( $value == - 1 ) ? esc_html__( 'All', 'xstore' ) : $value
			);
		}
		foreach ( $_GET as $key => $val ) {
			if ( 'et_per_page' === $key || 'submit' === $key ) {
				continue;
			}
			if ( is_array( $val ) ) {
				foreach ( $val as $inner_val ) {
					$out .= '<input type="hidden" name="' . esc_attr( $key ) . '[]" value="' . esc_attr( $inner_val ) . '" />';
				}
			} else {
				$out .= '<input type="hidden" name="' . esc_attr( $key ) . '" value="' . esc_attr( $val ) . '" />';
			}
		}
		$out .= '</select>';
		$out .= '</form>';
		echo '<div class="products-per-page ' . $class . '">' . $out . '</div>';
	}
}

// **********************************************************************//
// ! Category thumbnail
// **********************************************************************//
if ( ! function_exists( 'etheme_category_header' ) ) {
	function etheme_category_header() {
		global $wp_query;
		$cat = $wp_query->get_queried_object();
		
		if ( ! property_exists( $cat, 'term_id' ) && ! is_search() && etheme_get_option( 'product_bage_banner' ) != '' ) {
			echo '<div class="category-description">';
			echo do_shortcode( etheme_get_option( 'product_bage_banner' ) );
			echo '</div>';
		} else {
			;
			
			return;
		}
	}
}

// **********************************************************************//
// ! Second product category description
// **********************************************************************//
if ( ! function_exists( 'etheme_second_cat_desc' ) ) {
	function etheme_second_cat_desc() {
		global $wp_query;
		$cat = $wp_query->get_queried_object();
		
		if ( property_exists( $cat, 'term_id' ) && ! is_search() ) {
			$desc = get_term_meta( $cat->term_id, '_et_second_description', true );
		} else {
			return;
		}
		
		if ( ! empty( $desc ) ) {
			echo '<div class="term-description et_second-description">' . do_shortcode( $desc ) . '</div>';
		}
		
		return;
	}
}

// **********************************************************************//
// ! Wishlist Widget
// **********************************************************************//

if ( ! function_exists( 'etheme_wishlist_widget' ) ) {
	function etheme_wishlist_widget() {
		if ( class_exists( 'YITH_WCWL' ) ):
			$args = array();
			
			if ( defined( 'YITH_WCWL_PREMIUM' ) && is_user_logged_in() ) {
				$args['wishlist_id'] = 'all';
			} else {
				$args['is_default'] = true;
			}
			
			
			$products = YITH_WCWL()->get_products( $args );
			
			$limit = etheme_get_option( 'mini-cart-items-count' );
			$limit = is_numeric( $limit ) ? $limit : 3;
			
			$icon_label = etheme_get_option( 'cart_icon_label' );
			$class      = ' ico-label-' . $icon_label;
			
			if ( ! defined( 'YITH_WCWL_PREMIUM' ) ) {
				$products = array_reverse( $products );
			}
			
			// $wl_count = YITH_WCWL()->count_products();
			$wl_count = count( $products );
			?>
            <div class="et-wishlist-widget <?php echo esc_attr( $class ); ?> <?php echo 'popup-count-' . $wl_count; ?>">
                <a href="<?php echo esc_url( YITH_WCWL()->get_wishlist_url() ); ?>"><i
                            class="et-icon et-heart icon-like_outline"></i>
                    <span class="wishlist-count wl-count-number-<?php echo (int) $wl_count;
					echo ( ! etheme_get_option( 'favicon_label_zero' ) ) ? ' label-hidden' : ''; ?>"><?php echo (int) $wl_count; ?></span>
                </a>
                <div class="wishlist-dropdown product_list_widget">
					
					<?php if ( ! empty( $products ) ) : ?>

                        <ul class="cart-widget-products clearfix">
							<?php
							$i = 0;
							foreach ( $products as $item ) {
								$i ++;
								if ( $i > $limit ) {
									break;
								}
								
								if ( function_exists( 'yit_wpml_object_id' ) ) {
									$item['prod_id'] = yit_wpml_object_id( $item['prod_id'], 'product', true );
								}
								
								if ( function_exists( 'wc_get_product' ) ) {
									$_product = wc_get_product( $item['prod_id'] );
								} else {
									$_product = get_product( $item['prod_id'] );
								}
								
								if ( ! $_product ) {
									continue;
								}
								
								$product_name = $_product->get_title();
								$thumbnail    = $_product->get_image();
								?>
                                <li class="">
									<?php if ( ! $_product->is_visible() ) : ?>
										<?php echo str_replace( array(
												'http:',
												'https:'
											), '', $thumbnail ) . '&nbsp;'; ?>
									<?php else : ?>
                                        <a href="<?php echo esc_url( $_product->get_permalink() ); ?>"
                                           class="product-mini-image">
											<?php echo str_replace( array(
													'http:',
													'https:'
												), '', $thumbnail ) . '&nbsp;'; ?>
                                        </a>
									<?php endif; ?>

                                    <div class="product-item-right">

                                        <h4 class="product-title"><a
                                                    href="<?php echo esc_url( $_product->get_permalink() ); ?>"><?php echo wp_specialchars_decode( $product_name ); ?></a>
                                        </h4>

                                        <div class="descr-box">
											<?php echo WC()->cart->get_product_price( $_product ); ?>
                                        </div>

                                    </div>
                                </li>
								<?php
							}
							?>
                        </ul>

                        <p class="buttons mini-cart-buttons">
                            <a href="<?php echo esc_url( YITH_WCWL()->get_wishlist_url() ); ?>"
                               class="button btn-view-wishlist"><?php _e( 'View Wishlist', 'xstore' ); ?></a>
                        </p>
					
					<?php else : ?>

                        <p class="empty"><?php esc_html_e( 'No products in the wishlist.', 'xstore' ); ?></p>
					
					<?php endif; ?>

                </div><!-- end product list -->
            </div>
		<?php
		endif;
	}
}


if ( ! function_exists( 'etheme_support_multilingual_ajax' ) ) {
	add_filter( 'wcml_multi_currency_is_ajax', 'etheme_support_multilingual_ajax' );
	function etheme_support_multilingual_ajax( $functions ) {
		$functions[] = 'etheme_wishlist_fragments';
		
		return $functions;
	}
}

if ( ! function_exists( 'etheme_wishlist_fragments' ) ) {
	add_action( 'wp_ajax_etheme_wishlist_fragments', 'etheme_wishlist_fragments' );
	add_action( 'wp_ajax_nopriv_etheme_wishlist_fragments', 'etheme_wishlist_fragments' );
	
	function etheme_wishlist_fragments() {
		if ( ! function_exists( 'wc_setcookie' ) || ! function_exists( 'YITH_WCWL' ) ) {
			return;
		}
		$products = YITH_WCWL()->get_products( array(
			#'wishlist_id' => 'all',
			'is_default' => true
		) );
		
		// Get mini cart
		ob_start();
		
		etheme_wishlist_widget();
		
		$wishlist = ob_get_clean();
		
		// Fragments and mini cart are returned
		$data = array(
			'wishlist'      => $wishlist,
			'wishlist_hash' => md5( json_encode( $products ) )
		);
		
		wp_send_json( $data );
	}
}

// **********************************************************************//
// ! Is zoom plugin activated
// **********************************************************************//
if ( ! function_exists( 'etheme_is_zoom_activated' ) ) {
	function etheme_is_zoom_activated() {
		return class_exists( 'YITH_WCMG_Frontend' );
	}
}

// **********************************************************************//
// ! Top Cart Widget
// **********************************************************************//

if ( ! function_exists( 'etheme_top_cart' ) ) {
	function etheme_top_cart( $load_cart = false ) {
		global $woocommerce;
		
		$icon_design = etheme_get_option( 'shopping_cart_icon' );
		$icon_label  = etheme_get_option( 'cart_icon_label' );
		
		$class = 'ico-design-' . $icon_design;
		$class .= ' ico-label-' . $icon_label;
		
		?>
        <div class="shopping-container <?php echo esc_attr( $class );
		echo ( ! etheme_get_option( 'favicon_label_zero' ) ) ? ' label-hidden' : ''; ?>">
            <div class="shopping-cart-widget" id='basket'>
                <a href="<?php echo wc_get_cart_url(); ?>" class="cart-summ">
						<span class="cart-bag">
							<i class='ico-sum'></i>
							<?php etheme_cart_number(); ?>
						</span>
					<?php if ( etheme_get_option( 'shopping_cart_total' ) ) {
						etheme_cart_total();
					} ?>
                </a>
            </div>
			<?php etheme_cart_items_count(); ?>
            <div class="cart-popup-container">
                <div class="cart-popup clearfix">
                    <div class="widget woocommerce widget_shopping_cart">
						<?php
						// if($load_cart) {
						the_widget( 'WC_Widget_Cart', 'title=' );
						// } else {
						// echo '<div class="widget_shopping_cart_content"></div>';
						// }
						?>
                    </div>
                </div>
                <div class="cart-popup-banner"><?php echo etheme_get_option( 'cart_popup_banner' ); ?></div>
            </div>
        </div>
		<?php
	}
}

if ( ! function_exists( 'etheme_cart_total' ) ) {
	function etheme_cart_total() {
		global $woocommerce;
		?>
        <span class="shop-text"><span class="cart-items"><?php esc_html_e( 'Cart', 'xstore' ) ?>:</span> <span
                    class="total"><?php echo wp_specialchars_decode( $woocommerce->cart->get_cart_subtotal() ); ?></span></span>
		<?php
	}
}

// to hide popup if empty
if ( ! function_exists( 'etheme_cart_items_count' ) ) {
	function etheme_cart_items_count() {
		global $woocommerce;
		?>
        <span class="popup-count popup-count-<?php echo esc_attr( $woocommerce->cart->cart_contents_count ); ?>"></span>
		<?php
	}
}


if ( ! function_exists( 'etheme_cart_number' ) ) {
	function etheme_cart_number() {
		global $woocommerce;
		?>
        <span class="badge-number number-value-<?php echo esc_attr( $woocommerce->cart->cart_contents_count ); ?>"
              data-items-count="<?php echo esc_attr( $woocommerce->cart->cart_contents_count ); ?>"><?php echo esc_html( $woocommerce->cart->cart_contents_count ); ?></span>
		<?php
	}
}

if ( ! function_exists( 'etheme_cart_items' ) ) {
	function etheme_cart_items( $limit = 3 ) {
		?>
		<?php if ( ! WC()->cart->is_empty() ) : ?>

            <ul class="cart-widget-products clearfix">
				<?php
				$i    = 0;
				$cart = array_reverse( WC()->cart->get_cart() );
				do_action( 'woocommerce_before_mini_cart_contents' );
				foreach ( $cart as $cart_item_key => $cart_item ) {
					
					if ( $i >= $limit ) {
						continue;
					}
					$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
					$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
					
					if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
						$i ++;
						$product_name        = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
						$thumbnail           = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
						$product_price       = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
						$product_remove_icon = apply_filters( 'woocommerce_cart_item_remove_icon_html', '<i class="et-icon et-delete et-remove-type1"></i><i class="et-trash-wrap et-remove-type2"><img src="' . ETHEME_BASE_URI . 'theme/assets/images/trash-bin.gif' . '"></i>' ); ?>
                        <li class="woocommerce-mini-cart-item <?php echo esc_attr( apply_filters( 'woocommerce_mini_cart_item_class', 'mini_cart_item', $cart_item, $cart_item_key ) ); ?>">
							<?php
							echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
								'<a href="%s" class="remove remove_from_cart_button" aria-label="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s">' . $product_remove_icon . '</a>',
								esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
								__( 'Remove this item', 'xstore' ),
								esc_attr( $product_id ),
								esc_attr( $cart_item_key ),
								esc_attr( $_product->get_sku() )
							), $cart_item_key );
							?>
							<?php if ( ! $_product->is_visible() ) : ?>
								<?php echo str_replace( array( 'http:', 'https:' ), '', $thumbnail ) . ''; ?>
							<?php else : ?>
                                <a href="<?php echo esc_url( $_product->get_permalink( $cart_item ) ); ?>"
                                   class="product-mini-image">
									<?php echo str_replace( array( 'http:', 'https:' ), '', $thumbnail ) . ''; ?>
                                </a>
							<?php endif; ?>
                            <div class="product-item-right">
                                <h4 class="product-title">
                                    <a href="<?php echo esc_url( $_product->get_permalink( $cart_item ) ); ?>">
										<?php echo wp_specialchars_decode( $product_name ); ?>
                                    </a>
                                </h4>

                                <div class="descr-box">
									<?php echo wc_get_formatted_cart_item_data( $cart_item ); ?>
									<?php echo apply_filters( 'woocommerce_widget_cart_item_quantity', '<span class="quantity">' . sprintf( '%s &times; %s', $cart_item['quantity'], $product_price ) . '</span>', $cart_item, $cart_item_key ); ?>
                                </div>
                            </div>

                        </li>
						<?php
					}
				}
				do_action( 'woocommerce_mini_cart_contents' );
				?>
            </ul>
		
		<?php else : ?>

            <p class="woocommerce-mini-cart__empty-message empty"><?php esc_html_e( 'No products in the cart.', 'xstore' ); ?></p>
		
		<?php endif;
		
		if ( ! get_option( 'etheme_header_builder', false ) ) {
			do_action( 'et_woocomerce_mini_cart_footer' );
		}
		
	}
}

if ( ! function_exists( 'etheme_get_fragments' ) ) {
	add_filter( 'woocommerce_add_to_cart_fragments', 'etheme_get_fragments', 30 );
	function etheme_get_fragments( $array = array() ) {
		ob_start();
		etheme_cart_total();
		$cart_total = ob_get_clean();
		
		ob_start();
		etheme_cart_number();
		$cart_number = ob_get_clean();
		
		ob_start();
		etheme_cart_items_count();
		$cart_count = ob_get_clean();
		
		$array['span.shop-text']    = $cart_total;
		$array['span.badge-number'] = $cart_number;
		$array['span.popup-count']  = $cart_count;
		
		return $array;
	}
}

// **********************************************************************//
// ! Product brand label
// **********************************************************************//
if ( ! function_exists( 'etheme_product_brand_image' ) ) {
	function etheme_product_brand_image() {
		global $post;
		$terms = wp_get_post_terms( $post->ID, 'brand' );
		
		if ( ! is_wp_error( $terms ) && count( $terms ) > 0 && etheme_get_option( 'show_brand' ) ) {
			?>
            <div class="sidebar-widget product-brands">
                <h4 class="widget-title"><span><?php esc_html_e( 'Product brand', 'xstore' ) ?></span></h4>
				<?php
				foreach ( $terms as $brand ) {
					$thumbnail_id = absint( get_term_meta( $brand->term_id, 'thumbnail_id', true ) );
					?>
                    <a href="<?php echo get_term_link( $brand ); ?>">
						<?php if ( etheme_get_option( 'show_brand_title' ) ) : ?>
                            <div class="view-products-title colorGrey"><?php echo esc_html( $brand->name ); ?></div>
						<?php endif;
						if ( $thumbnail_id && etheme_get_option( 'show_brand_image' ) ) :
							echo wp_get_attachment_image( $thumbnail_id, 'full' );
						endif; ?>
                    </a>
					<?php if ( etheme_get_option( 'show_brand_desc' ) ) : ?>
                        <div class="short-description text-center colorGrey">
                            <p><?php echo wp_specialchars_decode( $brand->description ); ?></p></div>
					<?php endif; ?>
                    <a href="<?php echo get_term_link( $brand ); ?>" id="test-slyle-less"
                       class="view-products"><?php esc_html_e( 'View all products', 'xstore' ); ?></a>
					<?php
				}
				?>
            </div>
			<?php
		}
	}
}

function etheme_get_custom_product_template() {
	$view_mode = etheme_get_view_mode();
	$view_mode = apply_filters( 'et_view-mode-grid', $view_mode == 'grid' );
	// set shop products custom template
	$grid_custom_template = etheme_get_option( 'custom_product_template' );
	$list_custom_template = etheme_get_option( 'custom_product_template_list' );
	$list_custom_template = ( $list_custom_template != '-1' ) ? $list_custom_template : $grid_custom_template;
	
	return $view_mode == 'grid' ? (int) $grid_custom_template : (int) $list_custom_template;
}

// **********************************************************************//
// ! Cart&Checkout separator
// **********************************************************************//
if ( ! function_exists( 'etheme_get_cart_sep' ) ) {
	function etheme_get_cart_sep() {
		$sep = '<i class="et-icon et-right-arrow"></i>';
		$sep = "/";
		
		return $sep;
	}
}

// **********************************************************************//
// ! Load elements for ajax shop filters/pagination
// **********************************************************************//
function et_ajax_shop() { ?>
    <div>
		<?php if ( woocommerce_product_loop() ) : ?>
			
			<?php if ( is_active_sidebar( 'shop-filters-sidebar' ) ): ?>
                <div class="shop-filters widget-columns-<?php echo etheme_get_option( 'filters_columns' ); ?><?php echo ( etheme_get_option( 'filter_opened' ) ) ? ' filters-opened' : ''; ?>">
                    <div class="shop-filters-area">
						<?php if ( ! function_exists( 'dynamic_sidebar' ) || ! dynamic_sidebar( 'shop-filters-sidebar' ) ): ?>
						<?php endif; ?>
                    </div>
                </div>
			<?php endif; ?>
			<?php woocommerce_product_loop_start(); ?>
			
			<?php if ( wc_get_loop_prop( 'total' ) ) { ?>
				
				<?php while ( have_posts() ) : the_post(); ?>
					
					<?php do_action( 'woocommerce_shop_loop' ); ?>
					
					<?php wc_get_template_part( 'content', 'product' ); ?>
				
				<?php endwhile; // end of the loop. ?>
			
			<?php } ?>
			
			<?php woocommerce_product_loop_end(); ?>
		
		<?php elseif ( ! woocommerce_product_subcategories( array(
			'before' => woocommerce_product_loop_start( false ),
			'after'  => woocommerce_product_loop_end( false )
		) ) ) : ?>
			<?php do_action( 'woocommerce_no_products_found' ); ?>
		<?php endif; ?>
		
		<?php do_action( 'woocommerce_sidebar' ); ?>

        <div class="after-shop-loop">
			<?php
			/*** woocommerce_after_shop_loop hook** @hooked woocommerce_pagination - 10 */
			do_action( 'woocommerce_after_shop_loop' );
			?>
        </div>

        <?php
            $woocommerce_price_slider_params = json_encode(
                array(
                    'min_price' => isset( $_GET['min_price'] ) ? esc_attr( $_GET['min_price'] ) : '',
                    'max_price' => isset( $_GET['max_price'] ) ? esc_attr( $_GET['max_price'] ) : '',
                    'currency_format_num_decimals' => 0,
                    'currency_format_symbol' => get_woocommerce_currency_symbol(),
                    'currency_format_decimal_sep' => esc_attr( wc_get_price_decimal_separator() ),
                    'currency_format_thousand_sep' => esc_attr( wc_get_price_thousand_separator() ),
                    'currency_format' => esc_attr( str_replace( array( '%1$s', '%2$s' ), array( '%s', '%v' ), get_woocommerce_price_format() ) ),
                )
            );
        ?>
        <div class="et_woocommerce_price_slider_params">
            <script type="text/javascript" >
                    /* <![CDATA[ */
                    var woocommerce_price_slider_params = <?php echo $woocommerce_price_slider_params; ?>;
                    var woocommerce_price_slider_params = <?php echo $woocommerce_price_slider_params; ?>;
                    /* ]]> */
            </script>
        </div>
    </div>
	<?php die;
}

if ( ! function_exists( 'etheme_woocommerce_sale_flash' ) ) {
	/**
	 * Product sale label function.
	 *
	 * @param string - sale label content
	 * @param object - post
	 * @param object - product
	 *
	 * @return string
	 * @version 1.0.0
	 * @since   6.1.6
	 */
	
	function etheme_woocommerce_sale_flash( $span, $post, $product ) {
		$element_options                   = array();
		$element_options['single_product'] = false;
		$element_options['single_product'] = apply_filters( 'etheme_sale_label_single', $element_options['single_product'] );
		$element_options['in_percentage']  = etheme_get_option( 'sale_percentage' );
		$element_options['in_percentage']  = apply_filters( 'etheme_sale_label_percentage', $element_options['in_percentage'] );
		
		$element_options['is_customize_preview'] = is_customize_preview();
		
		$element_options['sale_icon']       = etheme_get_option( 'sale_icon' );
		$element_options['sale_label_text'] = etheme_get_option( 'sale_icon_text' );
		$element_options['show_label']      = $element_options['sale_icon'] || $element_options['is_customize_preview'];
		
		$element_options['wrapper_class'] = '';
		
		if ( $element_options['single_product'] ) {
			$element_options['sale_label_type']     = etheme_get_option( 'product_sale_label_type_et-desktop' );
			$element_options['show_label']          = $element_options['sale_label_type'] != 'none' || $element_options['is_customize_preview'];
			$element_options['sale_label_position'] = etheme_get_option( 'product_sale_label_position_et-desktop' );
			$element_options['sale_label_text']     = etheme_get_option( 'product_sale_label_text_et-desktop' );
			$element_options['sale_label_text']     = ( $element_options['in_percentage'] ) ? etheme_sale_label_percentage_text( $product, $element_options['sale_label_text'] ) : $element_options['sale_label_text'];
			
			$element_options['class'] = 'type-' . $element_options['sale_label_type'];
			$element_options['class'] .= ' ' . $element_options['sale_label_position'];
			$element_options['class'] .= ' single-sale';
		} else {
			$element_options['sale_label_type']     = $element_options['sale_icon'] ? 'square' : 'none';
			$element_options['sale_label_position'] = 'left';
			$element_options['sale_label_text']     = ( $element_options['in_percentage'] ) ? etheme_sale_label_percentage_text( $product, $element_options['sale_label_text'] ) : $element_options['sale_label_text'];
			
			$element_options['class'] = 'type-' . $element_options['sale_label_type'];
			$element_options['class'] .= ' ' . $element_options['sale_label_position'];
		}
		
		if ( $element_options['sale_label_type'] == 'none' && $element_options['is_customize_preview'] ) {
			$element_options['wrapper_class'] .= ' dt-hide mob-hide';
		}
		
		if ( strpos( $element_options['sale_label_text'], '%' ) != false ) {
			$element_options['class'] .= ' with-percentage';
		}
		
		ob_start();
		
		if ( $element_options['show_label'] ) {
			echo '<div class="sale-wrapper ' . esc_attr( $element_options['wrapper_class'] ) . '"><span class="onsale ' . esc_attr( $element_options['class'] ) . '">' . $element_options['sale_label_text'] . '</span></div>';
		}
		
		unset( $element_options );
		
		return ob_get_clean();
	}
}

if ( ! function_exists( 'etheme_sale_label_percentage_text' ) ) {
	
	/**
	 * Product sale label percentage.
	 *
	 * @param object - product
	 * @param string - sale text ( when product is not on sale yet )
	 *
	 * @return string
	 * @since   6.1.6
	 * @version 1.0.0
	 */
	
	function etheme_sale_label_percentage_text( $product_object, $sale_text ) {
		$element_options = array();
		if ( ! $product_object->is_on_sale() ) {
			return $sale_text;
		}
		$sale_variables = etheme_get_option( 'sale_percentage_variable' );
		if ( $product_object->get_type() == 'variable' ) {
			if ( $sale_variables ) {
				$element_options['variation_sale_prices'] = array();
				foreach ( $product_object->get_available_variations() as $key ) {
					if ( $key['display_regular_price'] == $key['display_price'] ) {
						continue;
					}
					$element_options['variation_sale_prices'][] = (float) round( ( ( $key['display_regular_price'] - $key['display_price'] ) / $key['display_regular_price'] ) * 100 );
				}
				$element_options['sale_label_text'] = esc_html__( 'Up to', 'xstore' ) . ' ' . max( $element_options['variation_sale_prices'] ) . '%';
			} else {
				$element_options['sale_label_text'] = $sale_text;
			}
		} elseif ( $product_object->get_type() == 'grouped' ) {
			if ( $sale_variables ) {
				$element_options['grouped_sale_prices'] = array();
				foreach ( $product_object->get_children() as $key ) {
					$_product = wc_get_product( $key );
					if ( $_product->get_type() == 'variable' && $_product->is_on_sale() ) {
						foreach ( $_product->get_available_variations() as $key ) {
							if ( $key['display_regular_price'] == $key['display_price'] ) {
								continue;
							}
							$element_options['grouped_sale_prices'][] = (float) round( ( ( $key['display_regular_price'] - $key['display_price'] ) / $key['display_regular_price'] ) * 100 );
						}
					} else {
						if ( $_product->is_on_sale() ) {
							$regular_price = (float) $_product->get_regular_price();
							$sale_price    = (float) $_product->get_sale_price();
							if ( $regular_price == $sale_price ) {
								continue;
							}
							$element_options['grouped_sale_prices'][] = (float) round( ( ( $regular_price - $sale_price ) / $regular_price ) * 100 );
						}
					}
				}
				$element_options['sale_label_text'] = esc_html__( 'Up to', 'xstore' ) . ' ' . max( $element_options['grouped_sale_prices'] ) . '%';
			} else {
				$element_options['sale_label_text'] = $sale_text;
			}
		} else {
			$element_options['regular_price']   = (float) $product_object->get_regular_price();
			$element_options['sale_price']      = (float) $product_object->get_sale_price();
			$element_options['sale_label_text'] = $sale_text . ' ' . round( ( ( $element_options['regular_price'] - $element_options['sale_price'] ) / $element_options['regular_price'] ) * 100 ) . '%';
		}
		
		if ( class_exists( 'WAD_Discount' ) ) {
			$product_type  = $product_object->get_type();
			$all_discounts = wad_get_active_discounts( true );
			$product_id    = $product_object->get_id();
			if ( in_array( $product_type, array( 'variation', 'variable' ) ) ) {
				$product_id = $product_object->get_available_variations();
			}
			foreach ( $all_discounts as $discount_type => $discounts ) {
				foreach ( $discounts as $discount_id ) {
					$discount_obj = new WAD_Discount( $discount_id );
					if ( $discount_obj->is_applicable( $product_id ) ) {
						$settings                           = $discount_obj->settings;
						$element_options['sale_label_text'] = $sale_text . ' ' . $settings['percentage-or-fixed-amount'] . '%';
					}
				}
			}
		}
		
		return $element_options['sale_label_text'];
	}
}

if ( ! function_exists( 'remove_et_variation_gallery_filter' ) ) {
	
	/**
	 * Variation galleries.
	 * remove filters for product variation props to js encoding
	 *
	 * @param string
	 *
	 * @return string
	 * @version 1.0.0
	 * @since   6.2.12
	 */
	
	function remove_et_variation_gallery_filter( $ob_get_clean ) {
		remove_filter( 'woocommerce_available_variation', 'etheme_available_variation_gallery', 90, 3 );
//		remove_filter( 'sten_wc_archive_loop_available_variation', 'etheme_available_variation_gallery', 90, 3 );
		
		return $ob_get_clean;
	}
}

if ( ! function_exists( 'add_et_variation_gallery_filter' ) ) {
	
	/**
	 * Variation galleries.
	 * add filters for product variation props to js encoding
	 *
	 * @param string
	 *
	 * @return string
	 * @version 1.0.0
	 * @since   6.2.12
	 */
	function add_et_variation_gallery_filter( $ob_get_clean ) {
		add_filter( 'woocommerce_available_variation', 'etheme_available_variation_gallery', 90, 3 );
//		add_filter( 'sten_wc_archive_loop_available_variation', 'etheme_available_variation_gallery', 90, 3 );
		
		return $ob_get_clean;
	}
}

if ( ! function_exists( 'etheme_get_external_video' ) ) {
	function etheme_get_external_video( $post_id ) {
		if ( ! $post_id ) {
			return false;
		}
		$product_video_code = get_post_meta( $post_id, '_product_video_code', true );
		
		return $product_video_code;
	}
}

if ( ! function_exists( 'etheme_get_attach_video' ) ) {
	function etheme_get_attach_video( $post_id ) {
		if ( ! $post_id ) {
			return false;
		}
		$product_video_code = get_post_meta( $post_id, '_product_video_gallery', false );
		
		return $product_video_code;
	}
}


// new variation gallery

if ( ! function_exists( 'etheme_available_variation_gallery' ) ):
	function etheme_available_variation_gallery( $available_variation, $variationProductObject, $variation ) {
		
		if ( !etheme_get_option('enable_variation_gallery') )
			return $available_variation;
		
		$product_id         = absint( $variation->get_parent_id() );
		$variation_id       = absint( $variation->get_id() );
		$variation_image_id = absint( $variation->get_image_id() );
		
		$has_variation_gallery_images = (bool) get_post_meta( $variation_id, 'et_variation_gallery_images', true );
		//  $product                      = wc_get_product( $product_id );
		
		if ( $has_variation_gallery_images ) {
			$gallery_images = (array) get_post_meta( $variation_id, 'et_variation_gallery_images', true );
		} else {
			// $gallery_images = $product->get_gallery_image_ids();
			$gallery_images = $variationProductObject->get_gallery_image_ids();
		}
		
		
		if ( $variation_image_id ) {
			// Add Variation Default Image
			array_unshift( $gallery_images, $variation_image_id );
		} else {
			// Add Product Default Image
			
			/*if ( has_post_thumbnail( $product_id ) ) {
				array_unshift( $gallery_images, get_post_thumbnail_id( $product_id ) );
			}*/
			$parent_product          = wc_get_product( $product_id );
			$parent_product_image_id = $parent_product->get_image_id();
			
			if ( ! empty( $parent_product_image_id ) ) {
				array_unshift( $gallery_images, $parent_product_image_id );
			}
		}
		
		$available_variation['variation_gallery_images'] = array();
		
		$index = 0;
		foreach ( $gallery_images as $i => $variation_gallery_image_id ) {
			$available_variation['variation_gallery_images'][ $i ] = et_get_gallery_image_props( $variation_gallery_image_id, $index );
			$index++;
		}
		
		return apply_filters( 'etheme_available_variation_gallery', $available_variation, $variation, $product_id );
	}
endif;

add_action( 'wp_footer', 'slider_template_js' );
add_action( 'wp_footer', 'thumbnail_template_js' );

function slider_template_js() {
    if ( !get_query_var( 'etheme_single_product_variation_gallery', false ) ) return;
	ob_start();
	?>
    <script type="text/html" id="tmpl-et-variation-gallery-slider-template">
        <div class="swiper-slide">
	        <div class="woocommerce-product-gallery__image">
	            <a href="{{data.url}}" data-large="{{data.full_src}}" data-width="{{data.full_src_w}}" data-height="{{data.full_src_h}}" data-index="{{data.index}}" class="woocommerce-main-image <# if (data.index < 1) { #> pswp-main-image <# } #> zoom">
		            <img class="{{data.class}}" width="{{data.src_w}}" height="{{data.src_h}}" src="{{data.src}}" alt="{{data.alt}}" title="{{data.title}}" data-caption="{{data.caption}}" data-src="{{data.full_src}}" data-large_image="{{data.full_src}}" data-large_image_width="{{data.full_src_w}}" data-large_image_height="{{data.full_src_h}}" <# if( data.srcset ){ #> srcset="{{data.srcset}}" <# } #> sizes="{{data.sizes}}"/>
	            </a>
	        </div>
        </div>
    </script>
	<?php echo ob_get_clean();
}

function thumbnail_template_js() {
    if ( !get_query_var( 'etheme_single_product_variation_gallery', false ) ) return;
	ob_start();
	?>
    <script type="text/html" id="tmpl-et-variation-gallery-thumbnail-template">
        <li class="<?php echo get_query_var('etheme_single_product_vertical_slider', false) ? 'slick-slide' : 'swiper-slide'; ?> thumbnail-item" <?php echo get_query_var('etheme_single_product_vertical_slider', false) ? 'style="width: 100%;"' : ''; ?>>
	        <a href="{{data.url}}" data-small="{{data.src}}" data-large="{{data.full_src}}" data-width="{{data.full_src_w}}" data-height="{{data.full_src_h}}" class="pswp-additional zoom" title="{{data.a_title}}">
		        <img class="{{data.class}}" width="{{data.thumbnail_src_w}}" height="{{data.thumbnail_src_h}}" src="{{data.thumbnail_src}}" alt="{{data.alt}}" title="{{data.title}}" />
	        </a>
        </li>
    </script>
	<?php echo ob_get_clean();
}

// Get Default Gallery Images
add_action( 'wp_ajax_nopriv_et_get_default_variation_gallery', 'et_get_default_variation_gallery' );

add_action( 'wp_ajax_et_get_default_variation_gallery', 'et_get_default_variation_gallery' );


// Get Default Gallery Images
add_action( 'wp_ajax_nopriv_et_get_available_variation_images', 'et_get_available_variation_images' );

add_action( 'wp_ajax_et_get_available_variation_images', 'et_get_available_variation_images' );

if ( ! function_exists( 'et_get_default_variation_gallery' ) ):
	function et_get_default_variation_gallery() {
		$product_id = absint( $_POST['product_id'] );
		
		$images = et_get_default_variation_gallery_images( $product_id );
		
		wp_send_json_success( apply_filters( 'et_get_default_variation_gallery', $images, $product_id ) );
	}
endif;

//-------------------------------------------------------------------------------
// Get Default Gallery Images
//-------------------------------------------------------------------------------
if ( ! function_exists( 'et_get_default_variation_gallery_images' ) ):
	function et_get_default_variation_gallery_images( $product_id ) {
		
		$product           = wc_get_product( $product_id );
		$product_id        = $product->get_id();
		$attachment_ids    = $product->get_gallery_image_ids();
		$post_thumbnail_id = $product->get_image_id();
		
		$images = array();
		
		$post_thumbnail_id = (int) apply_filters( 'et_variation_gallery_post_thumbnail_id', $post_thumbnail_id, $attachment_ids, $product );
		$attachment_ids    = (array) apply_filters( 'et_variation_gallery_attachment_ids', $attachment_ids, $post_thumbnail_id, $product );
		
		
		if ( ! empty( $post_thumbnail_id ) ) {
			array_unshift( $attachment_ids, $post_thumbnail_id );
		}
		
		if ( is_array( $attachment_ids ) && ! empty( $attachment_ids ) ) {
		    
		    $index = 0;
			
			foreach ( $attachment_ids as $i => $image_id ) {
				$images[ $i ] = et_get_gallery_image_props( $image_id, $index );
				$index++;
			}
		}
		
		return apply_filters( 'et_get_default_variation_gallery_images', $images, $product );
	}
endif;

/**
 * Description of the function.
 *
 * @param       $attachment_id
 * @param       bool $index
 * @return      mixed
 *
 * @since 1.0.0
 *
 */
function et_get_gallery_image_props( $attachment_id, $index = false ) {
	
	$props      = array(
		'title'                   => '',
		'caption'                 => '',
		'url'                     => '',
		'alt'                     => '',
		'full_src'                => '',
		'full_src_w'              => '',
		'full_src_h'              => '',
		'thumbnail_src'           => '',
		'thumbnail_src_w'         => '',
		'thumbnail_src_h'         => '',
		'thumbnail_class'         => '',
		'src'                     => '',
		'src_w'                   => '',
		'src_h'                   => '',
		'srcset'                  => '',
		'sizes'                   => '',
        'index'                   => $index
	);
	$attachment = get_post( $attachment_id );
	
	if ( $attachment ) {
		
		$props['title']    = _wp_specialchars( get_post_field( 'post_title', $attachment_id ), ENT_QUOTES, 'UTF-8', true );
		$props['caption']  = _wp_specialchars( get_post_field( 'post_excerpt', $attachment_id ), ENT_QUOTES, 'UTF-8', true );
		$props['url']      = wp_get_attachment_url( $attachment_id );
		
		// Alt text.
		$alt_text = array(
			trim( wp_strip_all_tags( get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ) ) ),
			$props['caption'],
			wp_strip_all_tags( $attachment->post_title )
		);
		
		$alt_text     = array_filter( $alt_text );
		$props['alt'] = isset( $alt_text[0] ) ? $alt_text[0] : '';
		
		// Large version.
		$full_size           = apply_filters( 'woocommerce_gallery_full_size', apply_filters( 'woocommerce_product_thumbnails_large_size', 'full' ) );
		$full_size_src       = wp_get_attachment_image_src( $attachment_id, $full_size );
		$props['full_src']   = esc_url( $full_size_src[0] );
		$props['full_src_w'] = esc_attr( $full_size_src[1] );
		$props['full_src_h'] = esc_attr( $full_size_src[2] );
		
		
		// Gallery thumbnail.
		$thumbnail_size                = apply_filters('single_product_small_thumbnail_size', 'shop_catalog' );
		$thumbnail_src            = wp_get_attachment_image_src( $attachment_id, $thumbnail_size );
		$props['thumbnail_src']   = esc_url( $thumbnail_src[0] );
		$props['thumbnail_src_w'] = esc_attr( $thumbnail_src[1] );
		$props['thumbnail_src_h'] = esc_attr( $thumbnail_src[2] );
		
		$image_size     = apply_filters( 'woocommerce_gallery_image_size', 'shop_single' );
		$src            = wp_get_attachment_image_src( $attachment_id, $image_size );
		$props['src']   = esc_url( $src[0] );
		$props['src_w'] = esc_attr( $src[1] );
		$props['src_h'] = esc_attr( $src[2] );
		
		$props['srcset'] = wp_get_attachment_image_srcset( $attachment_id, $image_size );
		$props['sizes']  = wp_get_attachment_image_sizes( $attachment_id, $image_size );
		
	}
	
	return apply_filters( 'woo_variation_gallery_get_image_props', $props, $attachment_id );
}

//-------------------------------------------------------------------------------
// Ajax request of non ajax variation
//-------------------------------------------------------------------------------
if ( ! function_exists( 'et_get_available_variation_images' ) ):
	function et_get_available_variation_images( $product_id = false ) {
		$product_id           = $product_id ? $product_id : absint( $_POST[ 'product_id' ] );
		$images               = array();
		$available_variations = et_get_product_variations( $product_id );
		
		foreach ( $available_variations as $i => $variation ) {
			array_push( $variation[ 'variation_gallery_images' ], $variation[ 'image' ] );
		}
		
		foreach ( $available_variations as $i => $variation ) {
			foreach ( $variation[ 'variation_gallery_images' ] as $image ) {
				array_push( $images, $image );
			}
		}
		
		wp_send_json_success( apply_filters( 'et_get_available_variation_images', $images, $product_id ) );
	}
endif;

if ( ! function_exists( 'et_get_product_variations' ) ):
	/**
	 * get variations of product
	 */
	function et_get_product_variations( $product ) {
		
		if ( is_numeric( $product ) ) {
			$product = wc_get_product( absint( $product ) );
		}
		
		return $product->get_available_variations();
	}
endif;

function et_clear_default_variation_transient_by_product( $product_id ) {
	if ( $product_id > 0 ) {
		$transient_name = sprintf( 'et_get_product_default_variation_%s', $product_id );
		delete_transient( $transient_name );
	}
}

function et_clear_default_variation_transient_by_variation( $variation ) {
	$product_id = $variation->get_parent_id();
	et_clear_default_variation_transient_by_product( $product_id );
}

function et_add_action_to_multi_currency_ajax( $array ) {
	$array[] = 'etheme_product_quick_view'; // Add a AJAX action to the array
	return $array;
}
add_filter( 'wcml_multi_currency_ajax_actions', 'et_add_action_to_multi_currency_ajax');