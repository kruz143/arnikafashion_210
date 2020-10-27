<?php
namespace ETC\App\Models\Widgets;

use ETC\App\Models\Widgets;

/**
 * Twitter Widget.
 * 
 * @since      1.4.4
 * @package    ETC
 * @subpackage ETC/Models/Widgets
 */
class Twitter extends Widgets {
    function __construct() {
        $widget_ops = array( 'classname' => 'etheme_twitter', 'description' => esc_html__('Display most recent Twitter feed', 'xstore-core') );
        $control_ops = array( 'id_base' => 'etheme-twitter' );
        parent::__construct( 'etheme-twitter', '8theme - '.esc_html__('Twitter Feed', 'xstore-core'), $widget_ops, $control_ops );
    }
    function widget( $args, $instance ) {
        extract( $args );
        $title = apply_filters('widget_title', $instance['title'] );
        echo $before_widget;
        if ( $title ) echo $before_title . $title . $after_title;
        $attr = array( 'usernames' => $instance['usernames'], 'limit' => $instance['limit'], 'interval' => $instance['interval'] );
        // $attr['interval'] =  * 10;
        $attr['interval'] = (integer) $attr['interval'];
        $attr['interval'] = $attr['interval'] * 10;

        //echo etheme_get_twitter( $attr );
        $tweets = etheme_get_tweets($instance['consumer_key'],$instance['consumer_secret'],$instance['user_token'],$instance['user_secret'],$attr['usernames'], $attr['limit']);
        $html = '';
        if(count($tweets) > 0 && empty($tweets['errors'])) {
            $html = '<ul class="twitter-list">';
                foreach ($tweets as $tweet) {
                    $html .= '<li><div class="media"><i class="pull-left et-icon et-twitter"></i><div class="media-body">' . @$tweet['text'] . '</div></div></li>';
                }
            $html .= '</ul>';
        }

        $html = etheme_tweet_linkify($html);

        echo $html;

        echo $after_widget;
    }
    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title']           = ( ! isset( $new_instance['title'] ) ) ? '' : strip_tags( $new_instance['title'] );
        $instance['usernames']       = ( ! isset( $new_instance['usernames'] ) ) ? '' : strip_tags( $new_instance['usernames'] );
        $instance['consumer_key']    = ( ! isset( $new_instance['consumer_key'] ) ) ? '' : strip_tags( $new_instance['consumer_key'] );
        $instance['consumer_secret'] = ( ! isset( $new_instance['consumer_secret'] ) ) ? '' : strip_tags( $new_instance['consumer_secret'] );
        $instance['user_token']      = ( ! isset( $new_instance['user_token'] ) ) ? '' : strip_tags( $new_instance['user_token'] );
        $instance['user_secret']     = ( ! isset( $new_instance['user_secret'] ) ) ? '' : strip_tags( $new_instance['user_secret'] );
        $instance['limit']           = ( ! isset( $new_instance['limit'] ) ) ? '' : strip_tags( $new_instance['limit'] );
        $instance['interval']        = ( ! isset( $new_instance['interval'] ) ) ? '' : strip_tags( $new_instance['interval'] );
        return $instance;
    }
    function form( $instance ) {
        $defaults = array( 'title' => '', 'usernames' => '8theme', 'limit' => '2', 'interval' => '5', 'consumer_key' => '', 'consumer_secret' => '', 'interval' => '', 'user_secret' => '', 'user_token' => '' );
        $instance = wp_parse_args( (array) $instance, $defaults );
        
        parent::widget_input_text( esc_html__( 'Title:', 'xstore-core' ), $this->get_field_id( 'title' ), $this->get_field_name( 'title' ), $instance['title'] );
        parent::widget_input_text( esc_html__( 'Username:', 'xstore-core' ), $this->get_field_id( 'usernames' ), $this->get_field_name( 'usernames' ), $instance['usernames'] );
        parent::widget_input_text( esc_html__( 'Customer Key:', 'xstore-core' ), $this->get_field_id( 'consumer_key' ), $this->get_field_name( 'consumer_key' ), $instance['consumer_key'] );
        parent::widget_input_text( esc_html__( 'Customer Secret:', 'xstore-core' ), $this->get_field_id( 'consumer_secret' ), $this->get_field_name( 'consumer_secret' ), $instance['consumer_secret'] );
        parent::widget_input_text( esc_html__( 'Access Token:', 'xstore-core' ), $this->get_field_id( 'user_token' ), $this->get_field_name( 'user_token' ), $instance['user_token'] );
        parent::widget_input_text( esc_html__( 'Access Token Secret:', 'xstore-core' ), $this->get_field_id( 'user_secret' ), $this->get_field_name( 'user_secret' ), $instance['user_secret'] );
        parent::widget_input_text( esc_html__( 'Number of tweets:', 'xstore-core' ), $this->get_field_id( 'limit' ), $this->get_field_name( 'limit' ), $instance['limit'] );
    }
}
