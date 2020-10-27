<?php  
	/**
	 * The template created for displaying google map api options 
	 *
	 * @version 0.0.1
	 * @since 6.0.0
	 */
	// section general-google-map
	Kirki::add_section( 'general-google-map', array(
		'title'     => esc_html__( 'Google Map API', 'xstore' ),
		'icon' 		=> 'dashicons-location-alt',
		'priority'  => $priorities['google-map']
	) );

	Kirki::add_field( 'et_kirki_options', array(
		'type'     => 'text',
		'settings' => 'google_map_api',
		'label'    => esc_html__( 'Google Map API Key', 'xstore' ),
		'section'  => 'general-google-map',
		'default'  => '',
	) );

?>