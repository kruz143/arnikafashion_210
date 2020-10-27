<?php
/**
 * The shop public facing functionality.
 *
 * @package    St_Woo_Swatches
 * @subpackage St_Woo_Swatches/public/partials
 * @author     SThemes <s.themes@aol.com>
 */
class St_Woo_Shop extends St_Woo_Swatches_Base {

	public function __construct( $args ) {

		parent::__construct();

		if (!empty($args)) {
			foreach ($args as $property => $arg) {
                $this->{$property} = $arg;
            }
        }

        add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_close', 11 );
        add_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_link_open', 9 );

        add_action( 'init', array( $this, 'etheme_shop_swatches_position' ) );

		add_shortcode( 'st-swatch-shortcode', array( &$this, 'loop_swatch' ) );
		add_action( 'loop_swatch', array( &$this, 'loop_swatch' ) );

		add_filter( 'sten_wc_archive_loop_available_variations', array( &$this, 'available_variations' ) );

		add_filter( 'sten_wc_archive_loop_swatch_html', array( &$this, 'swatch_html' ), 10, 6 );

		add_action( 'wp_ajax_nopriv_sten_wc_product_loop_add_to_cart', array( &$this, 'add_to_cart' ) );
		add_action( 'wp_ajax_sten_wc_product_loop_add_to_cart', array( &$this, 'add_to_cart' ) );
	}

	public function etheme_shop_swatches_position(){
		$view_mode 	 = get_query_var('et_view-mode');
		$swatch_hook = function_exists('etheme_get_option') ? etheme_get_option( 'swatch_position_shop' ) : 'before';

		if ( $view_mode == 'list' ) {
			return;
		} elseif( $swatch_hook == 'before' ){
			add_action( 'et_before_shop_loop_title', function(){ do_action( 'loop_swatch', 'normal' ); }, 1 );
		} elseif( $swatch_hook == 'after' ){
			add_action( 'et_after_shop_loop_title', function(){ do_action( 'loop_swatch', 'normal' ); }, 9 );
		}

		add_action( 'et_quick_view_swatch', function(){ do_action( 'loop_swatch', 'large' ); }, 10 );

	}

	public function loop_swatch( $size = 'normal' ) {

		global $product;

		if( ! $product->is_type( 'variable' ) ) return;

		$available_variations = apply_filters( 'sten_wc_archive_loop_available_variations', $product->get_available_variations() );

		$sw_popup = ( function_exists('etheme_get_option') && etheme_get_option( 'swatch_layout_shop' ) == 'popup') ? true : false;

		$loop_class = '';

		if ( $sw_popup ) {
			$loop_class = ' st-swatch-popup';
		}

		if( empty( $available_variations ) )
			return;

		$html = '';

		$html .= sprintf('<div class="st-swatch-in-loop%3$s" data-product_id="%1$s" data-product_variations="%2$s">',
			esc_attr( absint( $product->get_id() ) ),
			htmlspecialchars( wp_json_encode( $available_variations ) ),
			esc_attr($loop_class)
		);

		$attributes = $product->get_variation_attributes();
		foreach( array_keys( $attributes ) as $taxonomy ) {

			$attribute = $this->get_tax_attribute( $taxonomy );

			if ( ! $attribute ) {
				continue;
			}

			if( array_key_exists( $attribute->attribute_type,  $this->attribute_types ) ) {

				$available_options = $attributes[$taxonomy];

				// Get terms if this is a taxonomy - ordered. We need the names too.
				$terms    = wc_get_product_terms( $product->get_id(), $taxonomy, array( 'fields' => 'all' ) );

				// Generate request variable name.
				$key      = 'attribute_' . sanitize_title( $taxonomy );
				$selected = $product->get_variation_default_attribute( $taxonomy );

				$html .= '<span class="et_attribute-name">' . $attribute->attribute_label . '</span>';
				$html .= apply_filters( 'sten_wc_archive_loop_swatch_html', $attribute->attribute_type, $taxonomy, $terms, $available_options, $selected, $size  );
			}
		}

		$html .= sprintf( '<a href="javascript:void(0);" class="sten-reset-loop-variation" style="display:none;"> %1$s </a>', esc_html__( 'Clear', 'xstore-core' )  );
			if ( $sw_popup ) {
				$html .= '<div class="st-swatch-preview-wrap"><div class="et_st-popup-holder"></div>';
					ob_start();
						do_action('woocommerce_after_shop_loop_item_title' );
						do_action( 'woocommerce_after_shop_loop_item' );
					$html .= ob_get_clean();
					$html .= '<i class="et-icon et-delete"></i>';
				$html .= '</div>';
			}
		$html .= '</div>';
		print ( $html );
	}

	public function available_variations( $variations ) {

		$new_variations = array();

		foreach ( $variations as $variation ) {

			if ( $variation['variation_id'] != '' ) {

				$id     = get_post_thumbnail_id( $variation['variation_id'] );
				$src    = wp_get_attachment_image_src( $id, 'shop_catalog' );
				$srcset = wp_get_attachment_image_srcset( $id, 'shop_catalog' );
				$sizes  = wp_get_attachment_image_sizes( $id, 'shop_catalog' );

				$variation = apply_filters( 'sten_wc_archive_loop_available_variation', array_merge( $variation, array(
					'st_image_src'    => $src,
					'st_image_srcset' => $srcset,
					'st_image_sizes'  => $sizes
				) ), $this, wc_get_product( $variation['variation_id'] ) );

				$new_variations[] = $variation;
			}
		}

		return $new_variations;
	}

	/**
	 * Print HTML of swatches
	 */
	public function swatch_html( $attribute_type, $taxonomy, $terms, $variations, $selected, $size ) {
		$html = '';
		$layout = function_exists('etheme_get_option') ? etheme_get_option( 'swatch_layout_shop' ) : 'default';
		$custom_class = '';
		$custom_class .= 'st-swatch-size-' . $size;
		$custom_class .= ( $layout == 'popup' ) ? ' st-swatch-et-disabled' : '' ;

		if ( strpos( $attribute_type, '-sq') !== false ) {
			$et_attribute_type = str_replace( '-sq', '', $attribute_type );
			$custom_class .= ' st-swatch-shape-square';
			$subtype = 'subtype-square';
		} else {
			$et_attribute_type = $attribute_type;
			$custom_class .= ' st-swatch-shape-circle';
			$subtype = '';
		}

		switch ( $et_attribute_type ) {

			case 'st-color-swatch':
				if( $terms ) {

					$out = '';

					foreach( $terms as $term ) {

						if ( in_array( $term->slug, $variations, true ) ) {

							$color = get_term_meta( $term->term_id, 'st-color-swatch', true );

							$class = ( $selected == $term->slug ) ? 'selected' : '';
							$class .= ( $color == '#ffffff' || $color == '#fcfcfc' || $color == '#f7f7f7' || $color == '#f4f4f4'  ) ?  ' st-swatch-white' : '';

							$out .= sprintf(
								'<li class="type-color %5$s %1$s" data-tooltip="%3$s"> <span class="st-custom-attribute" data-value="%2$s" data-name="%3$s" 
								style="background-color:%4$s"></span> </li>',
								esc_attr( $class ),
								esc_attr( $term->slug ),
								esc_attr( $term->name ),
								esc_attr( $color ),
								esc_attr( $subtype )
							);
						}
					}

					$html .= '<div class="et_st-default-holder" data-et-holder="' . sanitize_title( $taxonomy ) . '">';
						$html .= sprintf(
							'<ul class="st-swatch-preview %1$s %3$s" data-attribute="%2$s" data-default-attribute="%4$s">',
							esc_attr( $custom_class ),
							sanitize_title( $taxonomy ),
							!empty( $selected ) ? 'has-default-attribute' : '',
							!empty( $selected ) ? $selected : 'none'
						);
						$html .= $out;
					$html .= '</ul></div>';
				}

			break;

			case 'st-image-swatch':
				if( $terms ) {

					$out = '';

					foreach( $terms as $term ) {

						if ( in_array( $term->slug, $variations, true ) ) {

							$image = get_term_meta( $term->term_id, 'st-image-swatch', true );
							$class = ( $selected == $term->slug ) ? 'selected' : '';

							$out .= sprintf(
								'<li class="type-image %5$s %1$s" data-tooltip="%3$s"> <span class="st-custom-attribute" data-value="%2$s" data-name="%3$s"> %4$s </span> </li>',
								esc_attr( $class ),
								esc_attr( $term->slug ),
								esc_attr( $term->name ),
								( $image ) ? wp_get_attachment_image( $image ) : '<img src="'.esc_url( ET_CORE_URL . 'packages/st-woo-swatches/public/images/placeholder.png' ) . '"/>' ,
								esc_attr( $subtype )
							);
						}
					}

					$html .= '<div class="et_st-default-holder" data-et-holder="' . sanitize_title( $taxonomy ) . '">';
						$html .= sprintf(
							'<ul class="st-swatch-preview %1$s %3$s" data-attribute="%2$s" data-default-attribute="%4$s">',
							esc_attr( $custom_class ),
							sanitize_title( $taxonomy ),
							!empty( $selected ) ? 'has-default-attribute' : '',
							!empty( $selected ) ? $selected : 'none'
						);
						$html .= $out;
					$html .= '</ul></div>';
				}
			break;

			case 'st-label-swatch':
				if( $terms ) {

					$out = '';

					foreach( $terms as $term ) {

						if ( in_array( $term->slug, $variations, true ) ) {

							$label = get_term_meta( $term->term_id, 'st-label-swatch', true );
							$label = (!empty($label)) ? $label : $term->name;
							$class = ( $selected == $term->slug ) ? 'selected' : '';

							$out .= sprintf(
								'<li class="type-label %5$s %1$s"> <span class="st-custom-attribute" data-value="%2$s" data-name="%3$s"> %4$s </span> </li>',
								esc_attr( $class ),
								esc_attr( $term->slug ),
								esc_attr( $term->name ),
								esc_attr( $label ),
								esc_attr( $subtype )
							);
						}
					}

					$html .= '<div class="et_st-default-holder" data-et-holder="' . sanitize_title( $taxonomy ) . '">';
						$html .= sprintf(
							'<ul class="st-swatch-preview %1$s %3$s" data-attribute="%2$s" data-default-attribute="%4$s">',
							esc_attr( $custom_class ),
							sanitize_title( $taxonomy ),
							!empty( $selected ) ? 'has-default-attribute' : '',
							!empty( $selected ) ? $selected : 'none'
						);
						$html .= $out;
					$html .= '</ul></div>';
				}
			break;
		}

		return $html;
	}

	public function add_to_cart() {

		$product_id   = apply_filters( 'woocommerce_add_to_cart_product_id', absint( $_POST['product_id'] ) );
		$quantity     = empty( $_POST['quantity'] ) ? 1 : apply_filters( 'woocommerce_stock_amount', $_POST['quantity'] );
		$variation_id = $_POST['variation_id'];
		$variation    = array();
		$data         = array();

		if ( is_array( $_POST['variation'] ) ) {

			foreach ( $_POST['variation'] as $key => $value ) {

				$variation[ $key ] = $this->utf8_urldecode( $value );
			}
		}

		$passed_validation = apply_filters( 'woocommerce_add_to_cart_validation', true, $product_id, $quantity );

		if ( $passed_validation && WC()->cart->add_to_cart( $product_id, $quantity, $variation_id, $variation ) ) {

			do_action( 'woocommerce_ajax_added_to_cart', $product_id );

			remove_action('woocommerce_widget_shopping_cart_total', 'woocommerce_widget_shopping_cart_subtotal', 10);
			add_action('woocommerce_widget_shopping_cart_total', 'etheme_woocommerce_widget_shopping_cart_subtotal', 10);

			if ( get_option( 'woocommerce_cart_redirect_after_add' ) == 'yes' ) {
				wc_add_to_cart_message( $product_id );
			}

			$data = WC_AJAX::get_refreshed_fragments();
		} else {

			WC_AJAX::json_headers();

			$data = array(
				'error'       => true,
				'product_url' => apply_filters( 'woocommerce_cart_redirect_after_error', get_permalink( $product_id ), $product_id )
			);
		}

		wp_send_json( $data );
		wp_die();
	}
}