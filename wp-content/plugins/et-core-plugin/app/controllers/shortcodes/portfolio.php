<?php
namespace ETC\App\Controllers\Shortcodes;

use ETC\App\Controllers\Shortcodes;

/**
 * Portfolio shortcode.
 *
 * @since      1.4.4
 * @package    ETC
 * @subpackage ETC/Controllers/Shortcodes
 */
class Portfolio extends Shortcodes {

	function hooks() {}

	function portfolio_shortcode( $atts, $content ) {
		$atts = shortcode_atts(array(
			'limit'  => '',
			'columns' => '',
			'ajax' => false,
			'is_preview' => false
		), $atts);

		global $et_portfolio_loop;

		$et_portfolio_loop['columns'] = $atts['columns'];

		ob_start();
		etheme_portfolio( false, $atts['limit'], true );

        if ( $atts['is_preview'] ) 
            echo parent::initPreviewJs();

		return ob_get_clean();
	}
}
