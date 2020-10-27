<?php 
use ETC\App\Traits\Elementor;
?>
<div data-id="<?php echo esc_attr( $tabs['_id'] ); ?>" class="clearfix active <?php echo esc_attr( $tabs['navigation_position_style'] );?> <?php echo ( 'middle-inside' === $tabs['navigation_position'] ) ? esc_attr( 'middle-inside' ): ''; ?>">
    <?php
    foreach ( $tabs as $key => $tab ):

        if ( $tab ) {
            switch ( $key ) {
                case 'ids':
                case 'taxonomies':
                $atts[$key] = !empty( $tab ) ? implode( ',',$tab ) : array();
                break;
                case 'slides':
                $atts['large'] = $atts['notebook'] = $tab;
                break;
                case 'slides_tablet':
                $atts['tablet_land'] = $atts['tablet_portrait'] = $tab;
                break;
                case 'slides_mobile':
                $atts['mobile'] = $tab;
                break;

                default:
                $atts[$key] = $tab;
                break;
            }
        }

    endforeach;

    $atts['is_preview'] = $is_preview;
    $atts['elementor']  = true;
    echo $Products_Shortcode->products_shortcode( $atts, '' );

    echo '<script>jQuery(document).ready(function(){ 
        etTheme.swiperFunc();
        etTheme.secondInitSwipers();
        etTheme.global_image_lazy(); 
        etTheme.contentProdImages();
        etTheme.countdown(); 
        etTheme.customCss();
        etTheme.customCssOne();
    });</script>';


   ?>
</div>