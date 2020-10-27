<?php
	/**
	 * The template created for displaying custom css options
	 *
	 * @version 0.0.1
	 * @since 6.0.0
	 */
	
	// section style-custom_css
	Kirki::add_panel( 'style-custom_css', array(
	    'title'          => esc_html__( 'Theme Custom CSS', 'xstore' ),
	    'description' => esc_html__( 'Once you\'ve isolated a part of theme that you\'d like to change, enter your CSS code to the fields below. Do not add JS or HTML to the fields. Custom CSS, entered here, will override a theme CSS. In some cases, the !important tag may be needed.', 'xstore' ),
	    'icon' => 'dashicons-admin-customizer',
	    'priority' => $priorities['custom-css']
		) );

		Kirki::add_section( 'global-custom_css', array(
			'title'          => esc_html__( 'Global CSS', 'xstore' ),
			'icon' => 'dashicons-admin-customizer',
			'type' => 'outer',
			'panel' => 'style-custom_css',
			'priority' => $priorities['custom-css']
		) );

		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'code',
			'settings'    => 'custom_css_global',
			'section'     => 'global-custom_css',
			'default'     => '',
			'choices'     => array(
				'language' => 'css',
			),
		) );

		Kirki::add_section( 'desktop-custom_css', array(
			'title'          => esc_html__( 'Desktop (992px+)', 'xstore' ),
			'icon' => 'dashicons-admin-customizer',
			'type' => 'outer',
			'panel' => 'style-custom_css',
			'priority' => $priorities['custom-css']
		) );

		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'code',
			'settings'    => 'custom_css_desktop',
			'section'     => 'desktop-custom_css',
			'default'     => '',
			'choices'     => array(
				'language' => 'css',
			),
		) );

		Kirki::add_section( 'tablet-custom_css', array(
			'title'          => esc_html__( 'Tablet (768px - 991px)', 'xstore' ),
			'icon' => 'dashicons-admin-customizer',
			'type' => 'outer',
			'panel' => 'style-custom_css',
			'priority' => $priorities['custom-css']
		) );

		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'code',
			'settings'    => 'custom_css_tablet',
			'section'     => 'tablet-custom_css',
			'default'     => '',
			'choices'     => array(
				'language' => 'css',
			),
		) );

		Kirki::add_section( 'wide_mobile-custom_css', array(
			'title'          => esc_html__( 'Mobile landscape (481px - 767px)', 'xstore' ),
			'icon' => 'dashicons-admin-customizer',
			'type' => 'outer',
			'panel' => 'style-custom_css',
			'priority' => $priorities['custom-css']
		) );

		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'code',
			'settings'    => 'custom_css_wide_mobile',
			'section'     => 'wide_mobile-custom_css',
			'default'     => '',
			'choices'     => array(
				'language' => 'css',
			),
		) );

		Kirki::add_section( 'mobile-custom_css', array(
			'title'          => esc_html__( 'Mobile (0 - 480px)', 'xstore' ),
			'icon' => 'dashicons-admin-customizer',
			'type' => 'outer',
			'panel' => 'style-custom_css',
			'priority' => $priorities['custom-css']
		) );

		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'code',
			'settings'    => 'custom_css_mobile',
			'section'     => 'mobile-custom_css',
			'default'     => '',
			'choices'     => array(
				'language' => 'css',
			),
		) );

?>