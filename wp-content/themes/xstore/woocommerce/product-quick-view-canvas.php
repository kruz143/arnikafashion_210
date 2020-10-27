<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly
global $product, $etheme_global, $post;

$etheme_global['quick_view'] = true;

$element_options                    = array();
$element_options['product_content'] = etheme_get_option( 'quick_view_content' );

remove_all_actions( 'woocommerce_product_thumbnails' );

$element_options['images_type'] = etheme_get_option( 'quick_images' );
$element_options['content_pos'] = etheme_get_option( 'quick_view_content_position' );

$element_options['product_class']   = array();
$element_options['product_class'][] = ( $product->is_sold_individually() ) ? 'sold-individually' : '';

$element_options['class'] = array();

if ( in_array( $element_options['images_type'], array( 'slider', 'grid' ) ) ) {
	$element_options['class'][] = 'swipers-couple-wrapper swiper-entry';
	if ( $element_options['images_type'] == 'slider' ) {
		$element_options['class'][] = 'arrows-hovered';
	} else {
		$etheme_global['quick_view_gallery_grid'] = true;
		$element_options['class'][]               = 'swiper-grid';
	}
}

$element_options['quick_descr'] = etheme_get_option( 'quick_descr' );

ob_start();

?>

    <span class="et-close-popup et-toggle pos-absolute full-<?php echo esc_attr($element_options['content_pos']); ?> top">
        <svg xmlns="http://www.w3.org/2000/svg" width="0.8em" height="0.8em" viewBox="0 0 24 24">
            <path d="M13.056 12l10.728-10.704c0.144-0.144 0.216-0.336 0.216-0.552 0-0.192-0.072-0.384-0.216-0.528-0.144-0.12-0.336-0.216-0.528-0.216 0 0 0 0 0 0-0.192 0-0.408 0.072-0.528 0.216l-10.728 10.728-10.704-10.728c-0.288-0.288-0.768-0.288-1.056 0-0.168 0.144-0.24 0.336-0.24 0.528 0 0.216 0.072 0.408 0.216 0.552l10.728 10.704-10.728 10.704c-0.144 0.144-0.216 0.336-0.216 0.552s0.072 0.384 0.216 0.528c0.288 0.288 0.768 0.288 1.056 0l10.728-10.728 10.704 10.704c0.144 0.144 0.336 0.216 0.528 0.216s0.384-0.072 0.528-0.216c0.144-0.144 0.216-0.336 0.216-0.528s-0.072-0.384-0.216-0.528l-10.704-10.704z"></path>
        </svg>
    </span>
    <div class="et-content product-content">
        <div class="et-content-inner <?php echo implode( ' ', $element_options['class'] ); ?>">
			<?php
			
			foreach ( $element_options['product_content'] as $item ) {
				switch ( $item ) {
					case 'quick_product_name':
						?>
                        <h3 class="product-name"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
						<?php
						break;
					case 'quick_rating':
						woocommerce_template_single_rating();
						break;
					case 'quick_price':
						woocommerce_template_single_price();
						break;
					case 'quick_gallery':
						add_filter( 'woocommerce_sale_flash', 'etheme_woocommerce_sale_flash', 20, 3 );
						if ( in_array( $element_options['images_type'], array( 'slider', 'grid' ) ) ): ?>
							<?php
							/**
							 * woocommerce_before_single_product_summary hook
							 *
							 * @hooked woocommerce_show_product_sale_flash - 10
							 * @hooked woocommerce_show_product_images - 20
							 */
							do_action( 'woocommerce_before_single_product_summary' );
						
						else: ?>
							<?php
							$type = Kirki::get_option( 'images_loading_type_et-desktop' );
							if ( $type == 'lqip' ) {
								$placeholder = wp_get_attachment_image_src( get_post_thumbnail_id(), 'etheme-woocommerce-nimi' );
								$new_attr    = 'src="' . $placeholder[0] . '" data-src';
								$image       = get_the_post_thumbnail(
									$post->ID,
									apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ),
									array(
										'class' => 'lazyload lazyload-lqip',
										// 'data-lazy_timeout' => '300',
									)
								); ?>
                                <div class="main-images">
									<?php
									woocommerce_show_product_sale_flash();
									echo str_replace( 'src', $new_attr, $image );
									?>
                                </div>
								<?php
							} else { ?>
                                <div class="main-images">
									<?php woocommerce_show_product_sale_flash(); ?>
									<?php the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ) ); ?>
                                </div>
							<?php }
						
						endif;
						break;
					case 'quick_categories':
						woocommerce_template_single_meta();
						break;
					case 'quick_share':
						?>
                        <div class="product-share">
							<?php echo do_shortcode( '[share title="' . esc_html__( 'Share:', 'xstore' ) . '" text="' . get_the_title() . '"]' ); ?>
                        </div>
						<?php
						break;
					case 'quick_wishlist':
						// tweak to remove icon from wishlist
						add_filter( 'yith_wcwl_add_to_wishlist_params', function ( $additional_params ) {
							$additional_params['icon'] = 'custom';
							
							return $additional_params;
						} );
						echo etheme_wishlist_btn();
						break;
					case 'quick_short_descr':
//                            $element_options['length'] = etheme_get_option( 'quick_descr_length' );
//                            $element_options['length'] = ( $element_options['length'] ) ? $element_options['length'] : 120;
//                            $element_options['description'] = etheme_trunc( etheme_strip_shortcodes(get_the_content()), $element_options['length'] );
//                            $element_options['description'] = trim($element_options['description']);
						
						woocommerce_template_single_excerpt();
						break;
					case 'product_link':
						if ( ! $element_options['quick_descr'] ) : ?>
                            <a href="<?php the_permalink(); ?>" class="show-full-details">
								<?php esc_html_e( 'Show full details', 'xstore' ); ?>
                            </a>
						<?php endif;
						break;
					case 'quick_add_to_cart':
						// add quantity
						add_action( 'woocommerce_before_quantity_input_field', 'et_quantity_minus_icon' );
						add_action( 'woocommerce_after_quantity_input_field', 'et_quantity_plus_icon' );
						
						do_action( 'et_quick_view_swatch' );
						
						if ( etheme_get_option( 'just_catalog' ) ) {
							echo sprintf( '<div class="cart"><a rel="nofollow" href="%s" class="button single_add_to_cart_button show-product">%s</a></div>',
								esc_url( $product->get_permalink() ),
								__( 'Show details', 'xstore' ) );
						} else {
							if ( $product->get_type() == 'simple' ) {
								woocommerce_template_single_add_to_cart();
							} else {
								woocommerce_template_loop_add_to_cart();
							}
						}
						
						remove_action( 'woocommerce_before_quantity_input_field', 'et_quantity_minus_icon' );
						remove_action( 'woocommerce_after_quantity_input_field', 'et_quantity_plus_icon' );
						break;
					default:
						break;
				}
			}
			
			$element_options['length']      = etheme_get_option( 'quick_descr_length' );
			$element_options['length']      = ( $element_options['length'] ) ? $element_options['length'] : 120;
			$element_options['description'] = etheme_trunc( etheme_strip_shortcodes( get_the_content() ), $element_options['length'] );
			$element_options['description'] = trim( $element_options['description'] );
			
			if ( $element_options['quick_descr'] && ! empty( $element_options['description'] ) ): ?>
                <div class="quick-view-excerpts">
                    <div class="excerpt-title"><?php esc_html_e( 'More Details', 'xstore' ); ?></div>
                    <div class="excerpt-content">
                        <div class="excerpt-content-inner">
							<?php echo wp_kses_post( $element_options['description'] );
							if ( in_array( 'product_link', $element_options['product_content'] ) ): ?>
                                <div>
                                    <a href="<?php the_permalink(); ?>" class="show-full-details">
										<?php esc_html_e( 'Show full details', 'xstore' ); ?></a>
                                </div>
							<?php endif; ?>
                        </div>
                    </div>
                </div>
			<?php endif; ?>
        </div>
    </div>

<?php

echo json_encode(
	array(
		'html'    => ob_get_clean(),
		'classes' => esc_attr( implode( ' ', wc_get_product_class( $element_options['product_class'], $product_id ) ) )
	)
);