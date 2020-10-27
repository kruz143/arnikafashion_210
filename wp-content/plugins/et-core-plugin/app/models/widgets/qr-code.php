<?php
namespace ETC\App\Models\Widgets;

use ETC\App\Models\Widgets;
use ETC\App\Controllers\Shortcodes\QRCode;

/**
 * QR code Widget.
 * 
 * @since      1.4.4
 * @package    ETC
 * @subpackage ETC/Models/Widgets
 */
class QR_Code extends Widgets {

    function __construct() {
        $widget_ops = array('classname' => 'etheme_widget_qr_code', 'description' => esc_html__( "You can add a QR code image in sidebar to allow your users get quick access from their devices", 'xstore-core') );
        parent::__construct('etheme-qr-code', '8theme - '.esc_html__('QR Code', 'xstore-core'), $widget_ops);
        $this->alt_option_name = 'etheme_widget_qr_code';
    }

    function widget($args, $instance) {
        extract($args);

        $title = isset($instance['title']) ? $instance['title'] : '';
        $info  = isset($instance['info'])  ? $instance['info']  : '';
        $text  = isset($instance['text'])  ? $instance['text']  : '';
        $size  = !empty($instance['size']) ? (int) $instance['size'] : 256;
        $lightbox = (bool) $instance['lightbox'];
        $currlink = (bool) $instance['currlink'];

        echo $before_widget;
        if ( $title ) echo $before_title . $title . $after_title;
        $QRCode = QRCode::get_instance();
        echo $QRCode->etheme_qr_code($info, 'Open', $size, '', $currlink, $lightbox );
        if($text != '') 
            echo $text;
        echo $after_widget;
    }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title']    = strip_tags( $new_instance['title'] );
        $instance['info']     = strip_tags( $new_instance['info'] );
        $instance['text']     = ( $new_instance['text'] );
        $instance['size']     = (int) $new_instance['size'];
        $instance['lightbox'] = (bool) $new_instance['lightbox'];
        $instance['currlink'] = (bool) $new_instance['currlink'];

        if ( function_exists ( 'icl_register_string' ) ){
            icl_register_string( 'Widgets', 'ETheme_QRCode_Widget - title', $instance['title'] );
            icl_register_string( 'Widgets', 'ETheme_QRCode_Widget - info', $instance['info'] );
            icl_register_string( 'Widgets', 'ETheme_QRCode_Widget - text', $instance['text'] );
        }

        return $instance;
    }

    function form( $instance ) {
        $block_id = 0;
        if(!empty($instance['block_id']))
            $block_id = esc_attr($instance['block_id']);

        $info     = isset( $instance['info'] ) ? $instance['info'] : '';
        $text     = isset( $instance['text'] ) ? $instance['text'] : '';
        $title    = isset( $instance['title'] ) ? $instance['title'] : '';
        $size     = isset( $instance['size'] ) ? (int) $instance['size'] : 256;
        $lightbox = isset( $instance['lightbox'] ) ? (bool) $instance['lightbox'] : false;
        $currlink = isset( $instance['currlink'] ) ? (bool) $instance['currlink'] : false;

?>
        <?php parent::widget_input_text( esc_html__( 'Widget title:', 'xstore-core' ), $this->get_field_id( 'title' ),$this->get_field_name( 'title' ), $title ); ?>

        <?php parent::widget_textarea( esc_html__( 'Information to encode:', 'xstore-core' ), $this->get_field_id( 'info' ),$this->get_field_name( 'info' ), $info ); ?>

        <?php parent::widget_input_text( esc_html__( 'Image size:', 'xstore-core' ), $this->get_field_id( 'size' ), $this->get_field_name( 'size' ), $size ); ?>

        <?php parent::widget_input_checkbox( esc_html__( 'Show in lightbox', 'xstore-core' ), $this->get_field_id( 'lightbox' ), $this->get_field_name( 'lightbox' ),checked( $lightbox, true, false ), 1 ); ?>

        <?php parent::widget_input_checkbox( esc_html__( 'Encode link to the current page', 'xstore-core' ), $this->get_field_id( 'currlink' ), $this->get_field_name( 'currlink' ),checked( $currlink, true, false ), 1 ); ?>

        <?php parent::widget_textarea( esc_html__( 'Additional information in widget', 'xstore-core' ), $this->get_field_id( 'text' ),$this->get_field_name( 'text' ), $text ); ?>

<?php
    }
}
