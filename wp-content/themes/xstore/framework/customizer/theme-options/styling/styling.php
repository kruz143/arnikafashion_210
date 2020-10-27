<?php  
	/**
	 * The template created for displaying style options 
	 *
	 * @version 0.0.1
	 * @since 6.0.0
	 */
	
	// section style
	Kirki::add_section( 'style', array(
	    'title'          => esc_html__( 'Styling', 'xstore' ),
	    'icon' => 'dashicons-admin-customizer',
	    'priority' => $priorities['styling']
		) );

		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'toggle',
			'settings'    => 'dark_styles',
			'label'       => esc_html__( 'Dark version', 'xstore' ),
			'description' => esc_html__( 'Turn on to switch site to dark styles.', 'xstore' ),
			'section'     => 'style',
			'default'     => 0,
		) );

		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'color',
			'settings'    => 'activecol',
			'label'       => esc_html__( 'Main Color', 'xstore' ),
			'description' => esc_html__( 'Choose the main color for the site (color of links, active buttons and elements like pagination, sale price, portfolio project mask, blog image mask etc).', 'xstore' ),
			'section'     => 'style',
			'default'     => '#c62828',
			'choices'	  => array(
				'alpha' => false
			),
			'transport' => 'auto',
			'output' => array(
				array(
					'element' => etheme_js2tring($et_selectors['active_color']),
					'property' => 'color',
				),
				array(
					'element' => etheme_js2tring($et_selectors['active_bg']),
					'property' => 'background-color',
				),
				array(
					'element' => etheme_js2tring($et_selectors['active_border']),
					'property' => 'border-color',
				),
				array(
					'element' => etheme_js2tring($et_selectors['active_stroke']),
					'property' => 'stroke',
				),
				array(
					'element' => 'body',
					'property' => '--et_active-color',
				),
			)
		) );

		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'background',
			'settings'    => 'background_img',
			'label'       => esc_html__( 'Site Background', 'xstore' ),
			'description' => esc_html__( 'Choose the background of the site. Visible if boxed layout is enabled.', 'xstore' ),
			'section'     => 'style',
			'default'     => array(
				'background-color'      => '#ffffff',
				'background-image'      => '',
				'background-repeat'     => '',
				'background-position'   => '',
				'background-size'       => '',
				'background-attachment' => '',
			),
			'transport'   => 'auto',
			'output'      => array(
				array(
					'element' => 'body, [data-mode="dark"]',
				),
				array(
					'choice' => 'background-color',
					'element' => '.bordered .body-border-left,
		                .bordered .body-border-top,
		                .bordered .body-border-right,
		                .bordered .body-border-bottom,
		                .swipers-couple-wrapper .swiper-wrapper img, .compare.button .blockOverlay:after,
		                .etheme-sticky-cart',
					'property' => 'background-color'
				),
			),
		) );

		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'color',
			'settings'    => 'container_bg',
			'label'       => esc_html__( 'Container Background Color', 'xstore' ),
			'description' => esc_html__( 'Choose the background color of the template container. Template container covers the whole visible area if wide layout is enabled.', 'xstore' ),
			'section'     => 'style',
			'transport' => 'auto',
			'output'      => array(
				array(
					'element' => 'article.content-timeline2 .timeline-content, .select2-results, .select2-drop, .select2-container .select2-choice, .form-control, .page-wrapper, .compare.button .blockOverlay:after,  .cart-popup-container, .emodal, #searchModal, .quick-view-popup, #etheme-popup, .et-wishlist-widget .wishlist-dropdown, .st-swatch-preview-wrap, .swipers-couple-wrapper .swiper-wrapper img, .sb-infinite-scroll-loader,
						[data-mode="dark"] .page-wrapper
					',
					'property' => 'background-color'
				),
			),
		) );

		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'color',
			'settings'    => 'forms_inputs_bg',
			'label'       => esc_html__( 'Inputs background color', 'xstore' ),
			'description' => esc_html__( 'Controls the background color of the all the inputs.', 'xstore' ),
			'section'     => 'style',
			'transport' => 'auto',
			'output'      => array(
				array(
					'element' => '.select2-results, .select2-drop, .select2-container .select2-choice, .form-control, select, .select2.select2-container--default .select2-selection--single, .quantity input[type="number"], div.quantity span, td.quantity span, .emodal, input[type="text"], input[type="email"], input[type="password"], input[type="tel"], input[type="url"], textarea, textarea.form-control, textarea, input[type="search"], .select2-container--default .select2-selection--single, .header-search.act-default input[type="text"], .header-wrapper.header-advanced .header-search.act-default input[type="text"], .header-wrapper.header-advanced .header-search.act-default div.fancy-select div.trigger,
						[data-mode="dark"] select, [data-mode="dark"] .select2.select2-container--default .select2-selection--single
					',
					'property' => 'background-color'
				),
			),
		) );

		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'color',
			'settings'    => 'forms_inputs_br',
			'label'       => esc_html__( 'Inputs border color', 'xstore' ),
			'description' => esc_html__( 'Controls the border color of the all the inputs.', 'xstore' ),
			'section'     => 'style',
			'transport' => 'auto',
			'output'      => array(
				array(
					'element' => '.select2-results, .select2-drop, .select2-container .select2-choice, .form-control, select, .select2.select2-container--default .select2-selection--single, .quantity input[type="number"], div.quantity > span, td.quantity > span, .emodal, input[type="text"], input[type="email"], input[type="password"], input[type="tel"], input[type="url"], textarea, textarea.form-control, textarea, input[type="search"], .select2-container--default .select2-selection--single, .header-search.act-default input[type="text"], .header-wrapper.header-advanced .header-search.act-default input[type="text"], .header-wrapper.header-advanced .header-search.act-default div.fancy-select div.trigger,
						[data-mode="dark"] select, [data-mode="dark"] .select2.select2-container--default .select2-selection--single
					',
					'property' => 'border-color'
				),
			),
		) );

		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'select',
			'settings'    => 'slider_arrows_colors',
			'label'       => esc_html__( 'Make all slider\'s arrows without background or with your custom color', 'xstore' ),
			'section'     => 'style',
			'default'     => 'transparent',
			'choices'     => array (
                'transparent' => esc_html__('Transparent', 'xstore'),
                'custom' => esc_html__('Custom', 'xstore'),
            ),
		) );

		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'color',
			'settings'    => 'slider_arrows_bg_color',
			'label'       => esc_html__( 'Slider arrows background color', 'xstore' ),
			'section'     => 'style',
			'transport' => 'auto',
			'output'      => array(
				array(
					'element' => '.swiper-custom-right, .swiper-custom-left, .swiper-custom-right:hover, .swiper-custom-left:hover',
					'property' => 'background-color'
				),
			),
			'active_callback' => array(
				array(
					'setting'  => 'slider_arrows_colors',
					'operator' => '==',
					'value'    => 'custom',
				),
			)
		) );

		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'color',
			'settings'    => 'slider_arrows_color',
			'label'       => esc_html__( 'Slider arrows color', 'xstore' ),
			'section'     => 'style',
			'transport' => 'auto',
			'output'      => array(
				array(
					'element' => '.swiper-custom-right:before, .swiper-custom-left:before, .swiper-custom-right:hover:before, .swiper-custom-left:hover:before',
					'property' => 'color'
				),
			),
		) );

		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'toggle',
			'settings'    => 'bold_icons',
			'label'       => esc_html__( 'Bold weight for icons', 'xstore' ),
			'description' => esc_html__( 'Turn on to make all the default icons (cart, search, wishlist, arrows etc) bold.', 'xstore' ),
			'section'     => 'style',
			'default'     => 0,
		) );

		// buttons styles 

		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'custom',
			'settings'    => 'separator'.$sep++,
			'section'     => 'style',
			'default'     => '<div style="'.$light_sep_style.'">' . esc_html__( 'Light buttons', 'xstore' ) . '</div>',
		) );

		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'typography',
			'settings'    => 'light_buttons_fonts',
			'section'     => 'style',
			'default'     => array(
				// 'font-family'    => 'Lato',
				// 'variant'        => 'regular',
				// 'font-size'      => '',
				// 'line-height'    => '',
				// 'letter-spacing' => '',
				// 'color'          => '#555',
				'text-transform' => '',
			),
			'transport'   => 'auto',
			'output'      => array(
				array(
					'element' => $light_buttons['regular'],
				),
			),
		) );

		Kirki::add_field( 'et_kirki_options', array(
		    'type'        => 'multicolor',
		    'settings'    => 'light_buttons_bg',
		    'label'       => esc_html__( 'Light buttons background', 'xstore' ),
		    'section'     => 'style',
		    'choices'     => array(
		        'regular'    => esc_html__( 'Regular', 'xstore' ),
		        'hover'   => esc_html__( 'Hover', 'xstore' ),
		    ),
		    'default'     => array(
		        'regular'    => '',
		        'hover'   => '',
		    ),
		    'transport' => 'auto',
	    	'output'    => array(
			    array(
			      'choice'    => 'regular',
			      'element'   => $light_buttons['regular'],
			      'property'  => 'background-color',
			    ),
			    array(
			      'choice'    => 'hover',
			      'element'   => $light_buttons['hover'],
			      'property'  => 'background-color',
			    ),
			  ),
		) );

		Kirki::add_field( 'et_kirki_options', array(
		    'type'        => 'multicolor',
		    'settings'    => 'light_buttons_color',
		    'label'       => esc_html__( 'Buttons text color', 'xstore' ),
		    'section'     => 'style',
		    'choices'     => array(
		        'regular'    => esc_html__( 'Regular', 'xstore' ),
		        'hover'   => esc_html__( 'Hover', 'xstore' ),
		        'active'  => esc_html__( 'Active', 'xstore' ),
		    ),
		    'default'     => array(
		        'regular'    => '',
		        'hover'   => '',
		        'active'  => '',
		    ),
		    'transport' => 'auto',
	    	'output'    => array(
			    array(
			      'choice'    => 'regular',
			      'element'   => $light_buttons['regular'],
			      'property'  => 'color',
			    ),
			    array(
			      'choice'    => 'hover',
			      'element'   => $light_buttons['hover'],
			      'property'  => 'color',
			    ),
			    array(
			      'choice'    => 'active',
			      'element'   => $light_buttons['active'],
			      'property'  => 'color',
			    ),
			  ),
		) );

		Kirki::add_field( 'et_kirki_options', array(
		    'type'        => 'multicolor',
			'settings'    => 'light_buttons_border_color',
			'label'       => esc_html__( 'Light buttons border color', 'xstore' ),
			'description' => esc_html__( 'Controls the light buttons border color', 'xstore' ),
			'section'     => 'style',
		    'choices'     => array(
		        'regular'    => esc_html__( 'Regular', 'xstore' ),
		        'hover'   => esc_html__( 'Hover', 'xstore' ),
		    ),
		    'default'     => array(
		        'regular'    => '',
		        'hover'   => '',
		    ),
		    'transport' => 'auto',
	    	'output'    => array(
			    array(
			      'choice'    => 'regular',
			      'element' => $light_buttons['regular'],
					'property' => 'border-color'
			    ),
			    array(
			      'choice'    => 'hover',
			      'element'  => $light_buttons['hover'],
					'property' => 'border-color'
			    ),
			  ),
		) );

		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'dimensions',
			'settings'    => 'light_buttons_border_width',
			'label'       => esc_html__( 'Light buttons border width', 'xstore' ),
			'description' => esc_html__( 'Controls the light buttons border width', 'xstore' ),
			'section'     => 'style',
			'default'     => $borders_empty,
			'choices'     => array(
				'labels' => $border_labels,
			),
			'transport' => 'auto',
			'output'      => array(
				array(
					'choice'   => 'border-top',
					'element'  => $light_buttons['regular'],
					'property' => 'border-top-width'
				),
				array(
					'choice'   => 'border-bottom',
					'element'  => $light_buttons['regular'],
					'property' => 'border-bottom-width'
				),
				array(
					'choice'   => 'border-left',
					'element'  => $light_buttons['regular'],
					'property' => 'border-left-width'
				),
				array(
					'choice'   => 'border-right',
					'element'  => $light_buttons['regular'],
					'property' => 'border-right-width'
				),
			),
		) );

		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'dimensions',
			'settings'    => 'light_buttons_border_radius',
			'label'    => esc_html__('Light buttons border radius', 'xstore'),
			'section'     => 'style',
			'default'     => $border_radius,
			'choices'     => array(
				'labels' => $border_radius_labels,
			),
			'transport' => 'auto',
			'output'      => array(
				array(
			      	'choice'      => 'border-top-left-radius',
			      	'element'  => $light_buttons['regular'],
			      	'property'    => 'border-top-left-radius',
			      	// 'suffix' => '!important'
			    ),
			    array(
			      	'choice'      => 'border-top-right-radius',
			      	'element'  => $light_buttons['regular'],
			      	'property'    => 'border-top-right-radius',
			      	// 'suffix' => '!important'
			    ),
			    array(
			      	'choice'      => 'border-bottom-right-radius',
			      	'element'  => $light_buttons['regular'],
			      	'property'    => 'border-bottom-right-radius',
			      	// 'suffix' => '!important'
			    ),
			    array(
			      	'choice'      => 'border-bottom-left-radius',
					'element'  => $light_buttons['regular'],
			      	'property'    => 'border-bottom-left-radius',
			      	// 'suffix' => '!important'
			    ),
			),
		) );

		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'dimensions',
			'settings'    => 'light_buttons_border_width_hover',
			'label'       => esc_html__( 'Light buttons border width (hover)', 'xstore' ),
			'description' => esc_html__( 'Controls the light buttons border width on hover', 'xstore' ),
			'section'     => 'style',
			'default'     => $borders_empty,
			'choices'     => array(
				'labels' => $border_labels,
			),
			'transport' => 'auto',
			'output'      => array(
				array(
					'choice'   => 'border-top',
					'element'  => $light_buttons['hover'],
					'property' => 'border-top-width'
				),
				array(
					'choice'   => 'border-bottom',
					'element'  => $light_buttons['hover'],
					'property' => 'border-bottom-width'
				),
				array(
					'choice'   => 'border-left',
					'element'  => $light_buttons['hover'],
					'property' => 'border-left-width'
				),
				array(
					'choice'   => 'border-right',
					'element'  => $light_buttons['hover'],
					'property' => 'border-right-width'
				),
			),
		) );

		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'select',
			'settings'    => 'light_buttons_border_style',
			'label'       => esc_html__( 'Light buttons border style', 'xstore' ),
			'description' => esc_html__( 'Controls the light buttons border style', 'xstore' ),
			'section'     => 'style',
			'default'     => 'none',
			'choices'     => $border_styles,
			'transport' => 'auto',
			'output'      => array(
				array(
					'element' => $light_buttons['regular'],
					'property' => 'border-style'
				),
			),
		) );

		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'select',
			'settings'    => 'light_buttons_border_style_hover',
			'label'       => esc_html__( 'Light buttons border style (hover)', 'xstore' ),
			'description' => esc_html__( 'Controls the light buttons border style on hover', 'xstore' ),
			'section'     => 'style',
			'default'     => 'none',
			'choices'     => $border_styles,
			'transport' => 'auto',
			'output'      => array(
				array(
					'element'  => $light_buttons['hover'],
					'property' => 'border-style'
				),
			),
		) );

		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'custom',
			'settings'    => 'separator'.$sep++,
			'section'     => 'style',
			'default'     => '<div style="'.$bordered_sep_style.'">' . esc_html__( 'Bordered buttons', 'xstore' ) . '</div>',
		) );

		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'typography',
			'settings'    => 'bordered_buttons_fonts',
			'section'     => 'style',
			'default'     => array(
				// 'font-family'    => 'Lato',
				// 'variant'        => 'regular',
				// 'font-size'      => '',
				// 'line-height'    => '',
				// 'letter-spacing' => '',
				// 'color'          => '#555',
				'text-transform' => '',
			),
			'transport'   => 'auto',
			'output'      => array(
				array(
					'element' => $bordered_buttons['regular'],
				),
			),
		) );

		Kirki::add_field( 'et_kirki_options', array(
		    'type'        => 'multicolor',
		    'settings'    => 'bordered_buttons_bg',
		    'label'       => esc_html__( 'Bordered buttons background', 'xstore' ),
		    'section'     => 'style',
		    'choices'     => array(
		        'regular'    => esc_html__( 'Regular', 'xstore' ),
		        'hover'   => esc_html__( 'Hover', 'xstore' ),
		    ),
		    'default'     => array(
		        'regular'    => '',
		        'hover'   => '',
		    ),
		    'transport' => 'auto',
	    	'output'    => array(
			    array(
			      'choice'    => 'regular',
			      'element'   => $bordered_buttons['regular'],
			      'property'  => 'background-color',
			    ),
			    array(
			      'choice'    => 'hover',
			      'element'   => $bordered_buttons['hover'],
			      'property'  => 'background-color',
			    ),
			  ),
		) );

		Kirki::add_field( 'et_kirki_options', array(
		    'type'        => 'multicolor',
		    'settings'    => 'bordered_buttons_color',
		    'label'       => esc_html__( 'Buttons text color', 'xstore' ),
		    'section'     => 'style',
		    'choices'     => array(
		        'regular'    => esc_html__( 'Regular', 'xstore' ),
		        'hover'   => esc_html__( 'Hover', 'xstore' ),
		        'active'  => esc_html__( 'Active', 'xstore' ),
		    ),
		    'default'     => array(
		        'regular'    => '',
		        'hover'   => '',
		        'active'  => '',
		    ),
		    'transport' => 'auto',
	    	'output'    => array(
			    array(
			      'choice'    => 'regular',
			      'element'   => $bordered_buttons['regular'],
			      'property'  => 'color',
			    ),
			    array(
			      'choice'    => 'hover',
			      'element'   => $bordered_buttons['hover'],
			      'property'  => 'color',
			    ),
			    array(
			      'choice'    => 'active',
			      'element'   => $bordered_buttons['active'],
			      'property'  => 'color',
			    ),
			  ),
		) );

		Kirki::add_field( 'et_kirki_options', array(
		    'type'        => 'multicolor',
			'settings'    => 'bordered_buttons_border_color',
			'label'       => esc_html__( 'Bordered buttons border color', 'xstore' ),
			'description' => esc_html__( 'Controls the bordered buttons border color', 'xstore' ),
			'section'     => 'style',
		    'choices'     => array(
		        'regular'    => esc_html__( 'Regular', 'xstore' ),
		        'hover'   => esc_html__( 'Hover', 'xstore' ),
		    ),
		    'default'     => array(
		        'regular'    => '',
		        'hover'   => '',
		    ),
		    'transport' => 'auto',
	    	'output'    => array(
			    array(
			      'choice'    => 'regular',
			      'element' => $bordered_buttons['regular'],
					'property' => 'border-color'
			    ),
			    array(
			      'choice'    => 'hover',
			      'element'  => $bordered_buttons['hover'],
					'property' => 'border-color'
			    ),
			  ),
		) );

		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'dimensions',
			'settings'    => 'bordered_buttons_border_width',
			'label'       => esc_html__( 'Bordered buttons border width', 'xstore' ),
			'description' => esc_html__( 'Controls the bordered buttons border width', 'xstore' ),
			'section'     => 'style',
			'default'     => array(
				'border-top'  => '1px',
				'border-right'  => '1px',
				'border-bottom' => '1px',
				'border-left' => '1px',
			),
			'choices'     => array(
				'labels' => $border_labels,
			),
			'transport' => 'auto',
			'output'      => array(
				array(
					'choice'   => 'border-top',
					'element'  => $bordered_buttons['regular'],
					'property' => 'border-top-width'
				),
				array(
					'choice'   => 'border-bottom',
					'element'  => $bordered_buttons['regular'],
					'property' => 'border-bottom-width'
				),
				array(
					'choice'   => 'border-left',
					'element'  => $bordered_buttons['regular'],
					'property' => 'border-left-width'
				),
				array(
					'choice'   => 'border-right',
					'element'  => $bordered_buttons['regular'],
					'property' => 'border-right-width'
				),
			),
		) );

		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'dimensions',
			'settings'    => 'bordered_buttons_border_radius',
			'label'    => esc_html__('Bordered buttons border radius', 'xstore'),
			'section'     => 'style',
			'default'     => $border_radius,
			'choices'     => array(
				'labels' => $border_radius_labels,
			),
			'transport' => 'auto',
			'output'      => array(
				array(
			      	'choice'      => 'border-top-left-radius',
			      	'element'  => $bordered_buttons['regular'],
			      	'property'    => 'border-top-left-radius',
			      	// 'suffix' => '!important'
			    ),
			    array(
			      	'choice'      => 'border-top-right-radius',
			      	'element'  => $bordered_buttons['regular'],
			      	'property'    => 'border-top-right-radius',
			      	// 'suffix' => '!important'
			    ),
			    array(
			      	'choice'      => 'border-bottom-right-radius',
			      	'element'  => $bordered_buttons['regular'],
			      	'property'    => 'border-bottom-right-radius',
			      	// 'suffix' => '!important'
			    ),
			    array(
			      	'choice'      => 'border-bottom-left-radius',
					'element'  => $bordered_buttons['regular'],
			      	'property'    => 'border-bottom-left-radius',
			      	// 'suffix' => '!important'
			    ),
			),
		) );

		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'dimensions',
			'settings'    => 'bordered_buttons_border_width_hover',
			'label'       => esc_html__( 'Bordered buttons border width (hover)', 'xstore' ),
			'description' => esc_html__( 'Controls the bordered buttons border width on hover', 'xstore' ),
			'section'     => 'style',
			'default'     => array(
				'border-top'  => '1px',
				'border-right'  => '1px',
				'border-bottom' => '1px',
				'border-left' => '1px',
			),
			'choices'     => array(
				'labels' => $border_labels,
			),
			'transport' => 'auto',
			'output'      => array(
				array(
					'choice'   => 'border-top',
					'element'  => $bordered_buttons['hover'],
					'property' => 'border-top-width'
				),
				array(
					'choice'   => 'border-bottom',
					'element'  => $bordered_buttons['hover'],
					'property' => 'border-bottom-width'
				),
				array(
					'choice'   => 'border-left',
					'element'  => $bordered_buttons['hover'],
					'property' => 'border-left-width'
				),
				array(
					'choice'   => 'border-right',
					'element'  => $bordered_buttons['hover'],
					'property' => 'border-right-width'
				),
			),
		) );

		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'select',
			'settings'    => 'bordered_buttons_border_style',
			'label'       => esc_html__( 'Bordered buttons border style', 'xstore' ),
			'description' => esc_html__( 'Controls the bordered buttons border style', 'xstore' ),
			'section'     => 'style',
			'default'     => 'solid',
			'choices'     => $border_styles,
			'transport' => 'auto',
			'output'      => array(
				array(
					'element' => $bordered_buttons['regular'],
					'property' => 'border-style'
				),
			),
		) );

		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'select',
			'settings'    => 'bordered_buttons_border_style_hover',
			'label'       => esc_html__( 'Bordered buttons border style (hover)', 'xstore' ),
			'description' => esc_html__( 'Controls the bordered buttons border style on hover', 'xstore' ),
			'section'     => 'style',
			'default'     => 'solid',
			'choices'     => $border_styles,
			'transport' => 'auto',
			'output'      => array(
				array(
					'element'  => $bordered_buttons['hover'],
					'property' => 'border-style'
				),
			),
		) );

		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'custom',
			'settings'    => 'separator'.$sep++,
			'section'     => 'style',
			'default'     => '<div style="'.$dark_sep_style.'">' . esc_html__( 'Dark buttons', 'xstore' ) . '</div>',
		) );

		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'typography',
			'settings'    => 'dark_buttons_fonts',
			'section'     => 'style',
			'default'     => array(
				// 'font-family'    => 'Lato',
				// 'variant'        => 'regular',
				// 'font-size'      => '',
				// 'line-height'    => '',
				// 'letter-spacing' => '',
				// 'color'          => '#555',
				'text-transform' => '',
			),
			'transport'   => 'auto',
			'output'      => array(
				array(
					'element' => $dark_buttons['regular'],
				),
			),
		) );

		Kirki::add_field( 'et_kirki_options', array(
		    'type'        => 'multicolor',
		    'settings'    => 'dark_buttons_bg',
		    'label'       => esc_html__( 'Dark buttons background', 'xstore' ),
		    'section'     => 'style',
		    'choices'     => array(
		        'regular'    => esc_html__( 'Regular', 'xstore' ),
		        'hover'   => esc_html__( 'Hover', 'xstore' ),
		    ),
		    'default'     => array(
		        'regular'    => '',
		        'hover'   => '',
		    ),
		    'transport' => 'auto',
	    	'output'    => array(
			    array(
			      'choice'    => 'regular',
			      'element'   => $dark_buttons['regular'],
			      'property'  => 'background-color',
			    ),
			    array(
			      'choice'    => 'hover',
			      'element'   => $dark_buttons['hover'],
			      'property'  => 'background-color',
			    ),
			  ),
		) );

		Kirki::add_field( 'et_kirki_options', array(
		    'type'        => 'multicolor',
		    'settings'    => 'dark_buttons_color',
		    'label'       => esc_html__( 'Buttons text color', 'xstore' ),
		    'section'     => 'style',
		    'choices'     => array(
		        'regular'    => esc_html__( 'Regular', 'xstore' ),
		        'hover'   => esc_html__( 'Hover', 'xstore' ),
		        'active'  => esc_html__( 'Active', 'xstore' ),
		    ),
		    'default'     => array(
		        'regular'    => '',
		        'hover'   => '',
		        'active'  => '',
		    ),
		    'transport' => 'auto',
	    	'output'    => array(
			    array(
			      'choice'    => 'regular',
			      'element'   => $dark_buttons['regular'],
			      'property'  => 'color',
			    ),
			    array(
			      'choice'    => 'hover',
			      'element'   => $dark_buttons['hover'],
			      'property'  => 'color',
			    ),
			    array(
			      'choice'    => 'active',
			      'element'   => $dark_buttons['active'],
			      'property'  => 'color',
			    ),
			  ),
		) );

		Kirki::add_field( 'et_kirki_options', array(
		    'type'        => 'multicolor',
			'settings'    => 'dark_buttons_border_color',
			'label'       => esc_html__( 'Dark buttons border color', 'xstore' ),
			'description' => esc_html__( 'Controls the dark buttons border color', 'xstore' ),
			'section'     => 'style',
		    'choices'     => array(
		        'regular'    => esc_html__( 'Regular', 'xstore' ),
		        'hover'   => esc_html__( 'Hover', 'xstore' ),
		    ),
		    'default'     => array(
		        'regular'    => '',
		        'hover'   => '',
		    ),
		    'transport' => 'auto',
	    	'output'    => array(
			    array(
			      'choice'    => 'regular',
			      'element'   => $dark_buttons['regular'],
			      'property'  => 'border-color',
			    ),
			    array(
			      'choice'    => 'hover',
			      'element'   => $dark_buttons['hover'],
			      'property'  => 'border-color',
			    ),
			),
		) );

		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'dimensions',
			'settings'    => 'dark_buttons_border_width',
			'label'       => esc_html__( 'Dark buttons border width', 'xstore' ),
			'description' => esc_html__( 'Controls the dark buttons border width', 'xstore' ),
			'section'     => 'style',
			'default'     => $borders_empty,
			'choices'     => array(
				'labels' => $border_labels,
			),
			'transport' => 'auto',
			'output'      => array(
				array(
					'choice'   => 'border-top',
					'element'  => $dark_buttons['regular'],
					'property' => 'border-top-width'
				),
				array(
					'choice'   => 'border-bottom',
					'element'  => $dark_buttons['regular'],
					'property' => 'border-bottom-width'
				),
				array(
					'choice'   => 'border-left',
					'element'  => $dark_buttons['regular'],
					'property' => 'border-left-width'
				),
				array(
					'choice'   => 'border-right',
					'element'  => $dark_buttons['regular'],
					'property' => 'border-right-width'
				),
			),
		) );

		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'dimensions',
			'settings'    => 'dark_buttons_border_radius',
			'label'    => esc_html__('Dark buttons border radius', 'xstore'),
			'section'     => 'style',
			'default'     => $border_radius,
			'choices'     => array(
				'labels' => $border_radius_labels,
			),
			'transport' => 'auto',
			'output'      => array(
				array(
			      	'choice'      => 'border-top-left-radius',
			      	'element'  => $dark_buttons['regular'],
			      	'property'    => 'border-top-left-radius',
			    ),
			    array(
			      	'choice'      => 'border-top-right-radius',
			      	'element'  => $dark_buttons['regular'],
			      	'property'    => 'border-top-right-radius',
			    ),
			    array(
			      	'choice'      => 'border-bottom-right-radius',
			      	'element'  => $dark_buttons['regular'],
			      	'property'    => 'border-bottom-right-radius',
			    ),
			    array(
			      	'choice'      => 'border-bottom-left-radius',
					'element'  => $dark_buttons['regular'],
			      	'property'    => 'border-bottom-left-radius',
			    ),
			),
		) );

		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'dimensions',
			'settings'    => 'dark_buttons_border_width_hover',
			'label'       => esc_html__( 'Dark buttons border width (hover)', 'xstore' ),
			'description' => esc_html__( 'Controls the dark buttons border width on hover', 'xstore' ),
			'section'     => 'style',
			'default'     => $borders_empty,
			'choices'     => array(
				'labels' => $border_labels,
			),
			'transport' => 'auto',
			'output'      => array(
				array(
					'choice'   => 'border-top',
					'element'  => $dark_buttons['hover'],
					'property' => 'border-top-width'
				),
				array(
					'choice'   => 'border-bottom',
					'element'  => $dark_buttons['hover'],
					'property' => 'border-bottom-width'
				),
				array(
					'choice'   => 'border-left',
					'element'  => $dark_buttons['hover'],
					'property' => 'border-left-width'
				),
				array(
					'choice'   => 'border-right',
					'element'  => $dark_buttons['hover'],
					'property' => 'border-right-width'
				),
			),
		) );

		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'select',
			'settings'    => 'dark_buttons_border_style',
			'label'       => esc_html__( 'Dark buttons border style', 'xstore' ),
			'description' => esc_html__( 'Controls the dark buttons border style', 'xstore' ),
			'section'     => 'style',
			'default'     => 'none',
			'choices'     => $border_styles,
			'transport' => 'auto',
			'output'      => array(
				array(
					'element' => $dark_buttons['regular'],
					'property' => 'border-style'
				),
			),
		) );

		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'select',
			'settings'    => 'dark_buttons_border_style_hover',
			'label'       => esc_html__( 'Dark buttons border style (hover)', 'xstore' ),
			'description' => esc_html__( 'Controls the dark buttons border style on hover', 'xstore' ),
			'section'     => 'style',
			'default'     => 'none',
			'choices'     => $border_styles,
			'transport' => 'auto',
			'output'      => array(
				array(
					'element'  => $dark_buttons['hover'],
					'property' => 'border-style'
				),
			),
		) );

		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'custom',
			'settings'    => 'separator'.$sep++,
			'section'     => 'style',
			'default'     => '<div style="'.$active_sep_style.'">' . esc_html__( 'Active buttons', 'xstore' ) . '</div>',
		) );

		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'typography',
			'settings'    => 'active_buttons_fonts',
			'section'     => 'style',
			'default'     => array(
				// 'font-family'    => 'Lato',
				// 'variant'        => 'regular',
				// 'font-size'      => '',
				// 'line-height'    => '',
				// 'letter-spacing' => '',
				// 'color'          => '#555',
				'text-transform' => '',
			),
			'transport'   => 'auto',
			'output'      => array(
				array(
					'element' => $active_buttons['regular'],
				),
			),
		) );

		Kirki::add_field( 'et_kirki_options', array(
		    'type'        => 'multicolor',
		    'settings'    => 'active_buttons_bg',
		    'label'       => esc_html__( 'Active buttons background', 'xstore' ),
		    'section'     => 'style',
		    'choices'     => array(
		        'regular'    => esc_html__( 'Regular', 'xstore' ),
		        'hover'   => esc_html__( 'Hover', 'xstore' ),
		    ),
		    'default'     => array(
		        'regular'    => '',
		        'hover'   => '',
		    ),
		    'transport' => 'auto',
	    	'output'    => array(
			    array(
			      'choice'    => 'regular',
			      'element'   => $active_buttons['regular'],
			      'property'  => 'background-color',
			    ),
			    array(
			      'choice'    => 'hover', 
			      'element'   => $active_buttons['hover'],
			      'property'  => 'background-color',
			    ),
			  ),
		) );

		Kirki::add_field( 'et_kirki_options', array(
		    'type'        => 'multicolor',
		    'settings'    => 'active_buttons_color',
		    'label'       => esc_html__( 'Buttons text color', 'xstore' ),
		    'section'     => 'style',
		    'choices'     => array(
		        'regular'    => esc_html__( 'Regular', 'xstore' ),
		        'hover'   => esc_html__( 'Hover', 'xstore' ),
		        'active'  => esc_html__( 'Active', 'xstore' ),
		    ),
		    'default'     => array(
		        'regular'    => '',
		        'hover'   => '',
		        'active'  => '',
		    ),
		    'transport' => 'auto',
	    	'output'    => array(
			    array(
			      'choice'    => 'regular',
			      'element'   => $active_buttons['regular'],
			      'property'  => 'color',
			    ),
			    array(
			      'choice'    => 'hover',
			     	'element'  => $active_buttons['hover'],
					'property'  => 'color',
			    ),
			    array(
			      'choice'    => 'active',
			      'element'  => $active_buttons['active'],
					'property'  => 'color',
			    ),
			  ),
		) );

		Kirki::add_field( 'et_kirki_options', array(
		    'type'        => 'multicolor',
		    'settings'    => 'active_buttons_border_color',
			'label'       => esc_html__( 'Active buttons border color', 'xstore' ),
			'description' => esc_html__( 'Controls the Active buttons border color', 'xstore' ),
			'section'     => 'style',
		    'choices'     => array(
		        'regular'    => esc_html__( 'Regular', 'xstore' ),
		        'hover'   => esc_html__( 'Hover', 'xstore' ),
		    ),
		    'default'     => array(
		        'regular'    => '',
		        'hover'   => '',
		    ),
		    'transport' => 'auto',
	    	'output'    => array(
			    array(
			      'choice'    => 'regular',
			      'element'   => $active_buttons['regular'],
			      'property'  => 'border-color',
			    ),
			    array(
			      'choice'    => 'hover',
			      'element'  => $active_buttons['hover'],
					'property'  => 'border-color',
			    ),
			)
		) );

		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'dimensions',
			'settings'    => 'active_buttons_border_width',
			'label'       => esc_html__( 'Active buttons border width', 'xstore' ),
			'description' => esc_html__( 'Controls the Active buttons border width', 'xstore' ),
			'section'     => 'style',
			'default'     => $borders_empty,
			'choices'     => array(
				'labels' => $border_labels,
			),
			'transport' => 'auto',
			'output'      => array(
				array(
					'choice'   => 'border-top',
					'element'  => $active_buttons['regular'],
					'property' => 'border-top-width'
				),
				array(
					'choice'   => 'border-bottom',
					'element'  => $active_buttons['regular'],
					'property' => 'border-bottom-width'
				),
				array(
					'choice'   => 'border-left',
					'element'  => $active_buttons['regular'],
					'property' => 'border-left-width'
				),
				array(
					'choice'   => 'border-right',
					'element'  => $active_buttons['regular'],
					'property' => 'border-right-width'
				),
			),
		) );

		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'dimensions',
			'settings'    => 'active_buttons_border_radius',
			'label'    => esc_html__('Active buttons border radius', 'xstore'),
			'section'     => 'style',
			'default'     => $border_radius,
			'choices'     => array(
				'labels' => $border_radius_labels,
			),
			'transport' => 'auto',
			'output'      => array(
				array(
			      	'choice'      => 'border-top-left-radius',
			      	'element'  => $active_buttons['regular'],
			      	'property'    => 'border-top-left-radius',
			    ),
			    array(
			      	'choice'      => 'border-top-right-radius',
			      	'element'  => $active_buttons['regular'],
			      	'property'    => 'border-top-right-radius',
			    ),
			    array(
			      	'choice'      => 'border-bottom-right-radius',
			      	'element'  => $active_buttons['regular'],
			      	'property'    => 'border-bottom-right-radius',
			    ),
			    array(
			      	'choice'      => 'border-bottom-left-radius',
					'element'  => $active_buttons['regular'],
			      	'property'    => 'border-bottom-left-radius',
			    ),
			),
		) );

		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'dimensions',
			'settings'    => 'active_buttons_border_width_hover',
			'label'       => esc_html__( 'Active buttons border width (hover)', 'xstore' ),
			'description' => esc_html__( 'Controls the Active buttons border width on hover', 'xstore' ),
			'section'     => 'style',
			'default'     => $borders_empty,
			'choices'     => array(
				'labels' => $border_labels,
			),
			'transport' => 'auto',
			'output'      => array(
				array(
					'choice'   => 'border-top',
					'element'  => $active_buttons['hover'],
					'property' => 'border-top-width'
				),
				array(
					'choice'   => 'border-bottom',
					'element'  => $active_buttons['hover'],
					'property' => 'border-bottom-width'
				),
				array(
					'choice'   => 'border-left',
					'element'  => $active_buttons['hover'],
					'property' => 'border-left-width'
				),
				array(
					'choice'   => 'border-right',
					'element'  => $active_buttons['hover'],
					'property' => 'border-right-width'
				),
			),
		) );

		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'select',
			'settings'    => 'active_buttons_border_style',
			'label'       => esc_html__( 'Active buttons border style', 'xstore' ),
			'description' => esc_html__( 'Controls the Active buttons border style', 'xstore' ),
			'section'     => 'style',
			'default'     => 'none',
			'choices'     => $border_styles,
			'transport' => 'auto',
			'output'      => array(
				array(
					'element' => $active_buttons['regular'],
					'property' => 'border-style'
				),
			),
		) );

		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'select',
			'settings'    => 'active_buttons_border_style_hover',
			'label'       => esc_html__( 'Active buttons border style (hover)', 'xstore' ),
			'description' => esc_html__( 'Controls the Active buttons border style on hover', 'xstore' ),
			'section'     => 'style',
			'default'     => 'none',
			'choices'     => $border_styles,
			'transport' => 'auto',
			'output'      => array(
				array(
					'element'  => $active_buttons['hover'],
					'property' => 'border-style'
				),
			),
		) );

?>