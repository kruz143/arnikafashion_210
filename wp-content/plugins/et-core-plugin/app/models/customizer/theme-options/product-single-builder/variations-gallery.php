<?php  
	/**
	 * The template created for displaying single product variation gallery options 
	 *
	 * @version 0.0.1
	 * @since 2.2.2
	 */
	
	// section variations-gallery
	Kirki::add_section( 'variations-gallery', array(
	    'title'          => esc_html__( 'Variation gallery', 'xstore-core' ),
	    'panel' => 'single_product_builder',
	    'icon' => 'dashicons-images-alt'
		) );

		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'toggle',
			'settings'    => 'enable_variation_gallery',
			'label'       => esc_html__( 'Variation gallery', 'xstore-core' ),
			'description' => esc_html__( 'Turn on to use separate gallery for product variations.', 'xstore-core'),
			'section'     => 'variations-gallery',
			'default'     => 0,
		) );

?>