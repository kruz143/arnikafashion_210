<?php  
	/**
	 * The template created for displaying mobile panel options 
	 *
	 * @version 0.0.2
	 * @since 2.3.1
	 * last changes in 3.0.1
	 */
	
	// section mobile_panel
	Kirki::add_section( 'mobile_panel', array(
	    'title'          => esc_html__( 'Mobile panel', 'xstore-core' ),
	    'icon' => 'dashicons-download',
	    'priority' => 5
		) );

		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'toggle',
			'settings'    => 'mobile_panel_et-mobile',
			'label'       => esc_html__('Enable mobile panel', 'xstore-core'),
			'section'     => 'mobile_panel',
			'default'     => '0',
			'transport' => 'postMessage',
			'js_vars'     => array(
				array(
					'element'  => '.et-mobile-panel-wrapper',
					'function' => 'toggleClass',
					'class' => 'mob-hide',
					'value' => false
				),
			),
		) );

		// content separator
		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'custom',
			'settings'    => 'mobile_panel_content_separator',
			'section'     => 'mobile_panel',
			'default'     => $separators['content'],
			'priority'    => 10,
		) );

		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'repeater',
			'label'       => esc_html__( 'Sections', 'xstore-core' ),
			'section'     => 'mobile_panel',
			'row_label' => array(
				'type' => 'field',
				'value' => esc_html__('Item', 'xstore-core' ),
				'element' => 'element',
			),
			'button_label' => esc_html__('Add new item', 'xstore-core' ),
			'settings'     => 'mobile_panel_package_et-mobile',
			'default'      => array(
				array(
					'element' => 'home',
					'icon'  => 'et_icon-home',
					'link' => 0,
					'custom_link' => '',
					'text' => '',
					'is_active' => false
				),
				array(
					'element' => 'shop',
					'icon'  => 'et_icon-shop',
					'link' => 0,
					'custom_link' => '',
					'text' => '',
					'is_active' => false
				),
				array(
					'element' => 'cart',
					'icon'  => 'et_icon-shopping-bag',
					'link' => 0,
					'custom_link' => '',
					'text' => '',
					'is_active' => false
				),
			),
			'fields' => array(
				'element' => array(
					'type'        => 'select',
					'label'       => esc_html__( 'Element', 'xstore-core' ),
					'default'     => 'shop',
					'choices'	  => $mobile_panel_elements
				),
				'icon' => array(
					'type'        => 'select',
					'label'       => $strings['label']['icon'],
					'description' => $strings['description']['icons_style'],
					'default'     => 'et_icon-coupon',
					'choices'     =>  array_merge($icons['simple'], $icons['socials']),
				),
				'text' => array(
					'type'        => 'text',
					'label'       => esc_html__( 'Custom text', 'xstore-core' ),
					'default'     => '',
				),
				'is_active' => array(
					'type'		  => 'checkbox',
					'label'       => esc_html__( 'Animation dot', 'xstore-core' ),
					'default'     => false,
				),
				'link' => array(
					'type'        => 'select',
					'label'       => esc_html__( 'Page link', 'xstore-core' ),
					'choices'     => $post_types['pages_all'],
				),
				'custom_link' => array(
					'type'        => 'link',
					'label'       => esc_html__( 'Custom Link', 'xstore-core' ),
					'default'     => ''
				),
			),
			'transport' => 'postMessage',
			'partial_refresh' => array(
				'mobile_panel_package_et-mobile' => array(
					'selector'  => '.et-mobile-panel-wrapper .et-mobile-panel .et-wrap-columns',
					'render_callback' => 'etheme_mobile_panel_callback'
				),
			),
		) );

		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'toggle',
			'settings'    => 'mobile_panel_elements_labels_et-mobile',
			'label'       => esc_html__('Show labels', 'xstore-core'),
			'section'     => 'mobile_panel',
			'default'     => 1,
			'transport' => 'postMessage',
			'partial_refresh' => array(
				'obile_panel_elements_labels_et-mobile' => array(
					'selector'  => '.et-mobile-panel-wrapper .et-mobile-panel .et-wrap-columns',
					'render_callback' => 'etheme_mobile_panel_callback'
				),
			),
		) );

		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'toggle',
			'settings'    => 'mobile_panel_elements_texts_et-mobile',
			'label'       => esc_html__('Show texts', 'xstore-core'),
			'section'     => 'mobile_panel',
			'default'     => 1,
			'transport' => 'postMessage',
			'partial_refresh' => array(
				'mobile_panel_elements_texts_et-mobile' => array(
					'selector'  => '.et-mobile-panel-wrapper .et-mobile-panel .et-wrap-columns',
					'render_callback' => 'etheme_mobile_panel_callback'
				),
			),
		) );

		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'select',
			'settings'    => 'mobile_panel_more_toggle_menu_term',
			'label'       => esc_html__('Select menu for more toggle element', 'xstore-core'),
			'section'     => 'mobile_panel',
			'choices'     => $post_types['menus'],
			'transport' => 'postMessage',
			'partial_refresh' => array(
				'mobile_panel_more_toggle_menu_term' => array(
					'selector'  => '.et-mobile-panel-wrapper .et-mobile-panel .et-wrap-columns',
					'render_callback' => 'etheme_mobile_panel_callback'
				),
			),
		) );

		// style separator
		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'custom',
			'settings'    => 'mobile_panel_style_separator',
			'section'     => 'mobile_panel',
			'default'     => $separators['style'],
			'priority'    => 10,
		) );

		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'slider',
			'settings'    => 'mobile_panel_height_et-mobile',
			'label'       => esc_html__('Height', 'xstore-core'),
			'section'     => 'mobile_panel',
			'default'     => 60,
			'choices'     => array(
				'min'  => '0',
				'max'  => '300',
				'step' => '1',
			),
			'transport' => 'auto',
			'output'      => array(
				array(
					'element' => '.et-mobile-panel-wrapper .et-mobile-panel .et-wrap-columns',
					'property' => 'height',
					'units' => 'px'
				),
				array(
					'media_query' => '@media only screen and (max-width: 992px)',
					'element' => '.et-mobile-panel-wrapper:not(.mob-hide):not(.outside) ~ .back-top',
					'property' => 'bottom',
					'value_pattern' => 'calc($px + 15px)',
				),
				array(
					'element' => '.et_b_mobile-panel-more_toggle .et-mini-content',
					'property' => 'height',
					'value_pattern' => 'calc(100% - $px + 1px)'
				),

			),
		) );

		// mobile_panel_elements_zoom 
		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'slider',
			'settings'    => 'mobile_panel_elements_zoom_et-mobile',
			'label'       => esc_html__( 'Content zoom (%)', 'xstore-core' ),
			'section'     => 'mobile_panel',
			'default'     => 100,
			'choices'     => array(
				'min'  => '30',
				'max'  => '250',
				'step' => '1',
			),
			'transport' => 'auto',
			'output' => array (
				array(
					'element' => '.et-mobile-panel-wrapper',
					'property' => '--content-zoom',
					'value_pattern' => 'calc($em * .01)'
				)
			)
		) );

		// mobile_panel_background
		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'background',
			'settings'    => 'mobile_panel_background_et-mobile',
			'label'       => $strings['label']['wcag_bg_color'],
			'description' => $strings['description']['wcag_bg_color'],
			'section'     => 'mobile_panel',
			'default'     => array(
				'background-color'      => '#ffffff',
				'background-image'      => '',
				'background-repeat'     => 'no-repeat',
				'background-position'   => 'center center',
				'background-size'       => '',
				'background-attachment' => '',
			),
			'transport' => 'auto',
			'output'      => array(
				array(
					'element' => '.et-mobile-panel-wrapper, .et_b_mobile-panel-more_toggle .et-mini-content, .et_b_mobile-panel-more_toggle .et-mini-content, .et-mobile-panel .et_column',
				),
			),
		) );
		
		// mobile_panel_color
		Kirki::add_field( 'et_kirki_options', array(
			'settings'    => 'mobile_panel_color_et-mobile',
			'label'       => $strings['label']['wcag_color'],
			'description' => $strings['description']['wcag_color'],
			'type'        => 'kirki-wcag-tc',
			'section'     => 'mobile_panel',
			'default'     => '#000000',
			'choices'     => array(
				'setting' => 'mobile_panel_background_et-mobile[background-color]',
				// 'maxHueDiff'          => 60,   // Optional.
				// 'stepHue'             => 15,   // Optional.
				// 'maxSaturation'       => 0.5,  // Optional.
				// 'stepSaturation'      => 0.1,  // Optional.
				// 'stepLightness'       => 0.05, // Optional.
				// 'precissionThreshold' => 6,    // Optional.
				// 'contrastThreshold'   => 4.5   // Optional. 
				'show'    => array(
					// 'auto'        => false,
					// 'custom'      => false,
					'recommended' => false,
				),
			),
			'transport' => 'auto',
			'output'	  => array(
				array(
					'element' => '.et-mobile-panel-wrapper, .et_b_mobile-panel-more_toggle .et-mini-content, .et_b_mobile-panel-more_toggle .et-mini-content',
					'property' => 'color'
				)
			)
		) );

		// advanced separator
		// Kirki::add_field( 'et_kirki_options', array(
		// 	'type'        => 'custom',
		// 	'settings'    => 'mobile_panel_advanced_separator',
		// 	'section'     => 'mobile_panel',
		// 	'default'     => $separators['advanced'],
		// 	'priority'    => 10,
		// ) );

		// mobile_panel_target
		// Kirki::add_field( 'et_kirki_options', array(
		// 	'type'        => 'toggle',
		// 	'settings'    => 'mobile_panel_target_et-desktop',
		// 	'label'       => $strings['label']['target_blank'],
		// 	'section'     => 'mobile_panel',
		// 	'default'     => 0,
		// 	'transport' => 'postMessage',
		// 	'partial_refresh' => array(
		// 		'mobile_panel_target' => array(
		// 			'selector'  => '.et_b_header-socials',
		// 			'render_callback' => 'mobile_panel_callback'
		// 		),
		// 	),
		// ) );

?>