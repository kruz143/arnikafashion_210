<?php  
	/**
	 * The template created for displaying single button options
	 *
	 * @version 1.0.1
	 * @since 1.5
	 * last changes in 1.5.5
	 */

	// section single button
	Kirki::add_section( 'single-button', array(
	    'title'          => esc_html__( 'Button', 'xstore-core' ),
	    'panel' => 'single_product_builder',
	    'icon' => 'dashicons-editor-removeformatting'
		) );

		// content separator
		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'custom',
			'settings'    => 'single_product_button_content_separator',
			'section'     => 'single-button',
			'default'     => $separators['content'],
			'priority'    => 10,
		) );

		// single_product_button_text
		Kirki::add_field( 'et_kirki_options', array (
			'type'     => 'text',
			'settings' => 'single_product_button_text_et-desktop',
			'label'    => $strings['label']['button_text'],
			'section'  => 'single-button',
			'default'  => esc_html__( 'Button', 'xstore-core' ),
			'transport' => 'postMessage',
			'js_vars' => array(
				array(
					'element'  => '.et_b_single-button',
					'function' => 'html',
				),
			),
		) );

		// single_product_button_link
		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'select',
			'settings'    => 'single_product_button_link_et-desktop',
			'label'       => $strings['label']['page_links'],
			'section'     => 'single-button',
			'multiple'    => 1,
			'choices'     => $post_types['pages'],
			'transport' => 'postMessage',
			'partial_refresh' => array(
				'single_product_button_link_et-desktop' => array(
					'selector'  => '.single-product-button-wrapper',
					'render_callback' => 'single_product_button_callback'
				),
			),
		) );

		// single_product_button_link
		Kirki::add_field( 'et_kirki_options', array (
			'type'     => 'link',
			'settings' => 'single_product_button_custom_link_et-desktop',
			'label'    => $strings['label']['custom_link'],
			'section'  => 'single-button',
			'default'  => '#',
			'active_callback' => array(
				array(
					'setting'  => 'single_product_button_link_et-desktop',
					'operator' => '==',
					'value'    => 'custom',
				),
			),
			'transport' => 'postMessage',
			'js_vars' => array(
				array(
					'element'  => '.et_b_single-button',
					'attr' => 'href',
					'function' => 'html',
				),
			),
		) );

		// style separator
		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'custom',
			'settings'    => 'single_product_button_style_separator',
			'section'     => 'single-button',
			'default'     => $separators['style'],
			'priority'    => 10,
		) );

		// single_product_button_fonts
		Kirki::add_field( 'et_kirki_options', array (
			'type'        => 'typography',
			'settings'    => 'single_product_button_fonts_et-desktop',
			'label'       => $strings['label']['fonts'],
			'section'     => 'single-button',
			'default'     => array(
				// 'font-family'    => '',
				// 'variant'        => 'regular',
				// 'font-size'      => '15px',
				// 'line-height'    => '1.5',
				// 'letter-spacing' => '0',
				// 'color'          => '#555',
				'text-transform' => 'none',
				// 'text-align'     => 'left',
			),
			'transport' => 'auto',
			'output'      => array(
				array(
					'element' => '.et_b_single-button',
				),
			),
		) );

		// single_product_button_zoom 
		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'slider',
			'settings'    => 'single_product_button_zoom_et-desktop',
			'label'       => $strings['label']['button_size_proportion'],
			'section'     => 'single-button',
			'default'     => 1,
			'choices'     => array(
				'min'  => '.2',
				'max'  => '3',
				'step' => '.01',
			),
			'transport' => 'auto',
			'output'      => array(
				array(
					'element' => '.et_b_single-button',
					'property' => 'font-size',
					'value_pattern' => 'calc(var(--content-zoom, 1rem) * $)'
				),
			),
		) );

		// single_product_button_content_align
		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'radio-buttonset',
			'settings'    => 'single_product_button_content_align_et-desktop',
			'label'       => $strings['label']['alignment'],
			'description' => $strings['description']['size_bigger_attention'],
			'section'     => 'single-button',
			'default'     => 'start',
			'choices'     => $choices['alignment'],
			'transport' => 'postMessage',
			'js_vars'     => array(
				array(
					'element'  => '.single-product-button-wrapper',
					'function' => 'toggleClass',
					'class' => 'justify-content-start',
					'value' => 'start'
				),
				array(
					'element'  => '.single-product-button-wrapper',
					'function' => 'toggleClass',
					'class' => 'justify-content-center',
					'value' => 'center'
				),
				array(
					'element'  => '.single-product-button-wrapper',
					'function' => 'toggleClass',
					'class' => 'justify-content-end',
					'value' => 'end'
				),
			),
		) );

		// single_product_button_background_custom
		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'color',
			'settings'    => 'single_product_button_background_custom_et-desktop',
			'label'       => $strings['label']['bg_color'],
			'section'     => 'single-button',
			'default' 	  => '#000000',
			'choices'	  => array (
				'alpha'	  => true
			),
			'transport' => 'auto',
			'output'      => array(
				array(
					'element' => '.et_b_single-button',
					'property' => 'background-color',
				),
			),
		) );

		// single_product_button_color
		Kirki::add_field( 'et_kirki_options', array(
			'settings'    => 'single_product_button_color_et-desktop',
			'label'       => $strings['label']['wcag_color'],
			'description' => $strings['description']['wcag_color'],
			'type'        => 'kirki-wcag-tc',
			'section'     => 'single-button',
			'default'     => '#ffffff',
			'choices'     => array(
				'setting' => 'single_product_button_background_custom_et-desktop',
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
					'element' => '.et_b_single-button',
					'property' => 'color',
					'suffix' => '!important'
				),
			),
		) );

		// single_product_button_background_hover_custom
		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'color',
			'settings'    => 'single_product_button_background_hover_custom_et-desktop',
			'label'       => esc_html__( 'Background color (hover)', 'xstore-core' ),
			'section'     => 'single-button',
			'default' 	  => '#ffffff',
			'choices'	  => array (
				'alpha'	  => true
			),
			'transport' => 'auto',
			'output'      => array(
				array(
					'element' => '.et_b_single-button:hover',
					'property' => 'background-color',
				),
			),
		) );

		// single_product_button_hover_color
		Kirki::add_field( 'et_kirki_options', array(
			'settings'    => 'single_product_button_hover_color_et-desktop',
			'label'       => $strings['label']['wcag_color_hover'],
			'description' => $strings['description']['wcag_color'],
			'type'        => 'kirki-wcag-tc',
			'section'     => 'single-button',
			'default'     => '#000000',
			'choices'     => array(
				'setting' => 'single_product_button_background_hover_custom_et-desktop',
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
					'element' => '.et_b_single-button:hover',
					'property' => 'color',
					'suffix' => '!important'
				),
			),
		) );

		// single_product_button_border_radius
		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'slider',
			'settings'    => 'single_product_button_border_radius_et-desktop',
			'label'       => $strings['label']['border_radius'],
			'section'     => 'single-button',
			'default'     => 0,
			'choices'     => array(
				'min'  => '0',
				'max'  => '100',
				'step' => '1',
			),
			'transport' => 'auto',
			'output'      => array(
				array(
					'element' => '.et_b_single-button',
					'property' => 'border-radius',
					'units' => 'px'
				),
			),
		) );

		// single_product_button_box_model
		Kirki::add_field( 'et_kirki_options', array(
			'settings'    => 'single_product_button_box_model_et-desktop',
			'label'       => $strings['label']['computed_box'],
			'description' => $strings['description']['computed_box'],
			'type'        => 'kirki-box-model',
			'section'     => 'single-button',
			'default'     => array(
				'margin-top'          => '0px',
				'margin-right'        => '0px',
				'margin-bottom'       => '10px',
				'margin-left'         => '0px',
				'border-top-width'    => '1px',
				'border-right-width'  => '1px',
				'border-bottom-width' => '1px',
				'border-left-width'   => '1px',
				'padding-top'         => '5px',
				'padding-right'       => '10px',
				'padding-bottom'      => '5px',
				'padding-left'        => '10px',
			),
			'output'      => array(
				array(
					'element' => '.et_b_single-button'
				),
			),
			'transport' => 'postMessage',
	        'js_vars'   => box_model_output('.et_b_single-button')
		) );

		// single_product_button_border
		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'select',
			'settings'    => 'single_product_button_border_et-desktop',
			'label'       => $strings['label']['border_style'],
			'section'     => 'single-button',
			'default'     => 'solid',
			'choices'     => $choices['border_style'],
			'transport' => 'auto',
			'output'      => array(
				array(
					'element' => '.et_b_single-button',
					'property' => 'border-style'
				),
			),
		) );

		// single_product_button_border_color_custom
		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'color',
			'settings'    => 'single_product_button_border_color_custom_et-desktop',
			'label'       => $strings['label']['border_color'],
			'description' => $strings['description']['border_color'],
			'section'     => 'single-button',
			'default' 	  => '#e1e1e1',
			'choices' 	  => array (
				'alpha' => true
			),
			'transport' => 'auto',
			'output'      => array(
				array(
					'element' => '.et_b_single-button',
					'property' => 'border-color',
				),
			),
		) );

		// advanced separator
		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'custom',
			'settings'    => 'single_product_button_advanced_separator',
			'section'     => 'single-button',
			'default'     => $separators['advanced'],
			'priority'    => 10,
		) );

		// single_product_button_target
		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'toggle',
			'settings'    => 'single_product_button_target_et-desktop',
			'label'       => $strings['label']['target_blank'],
			'section'     => 'single-button',
			'default'     => 0,
			'transport' => 'postMessage',
			'partial_refresh' => array(
				'single_product_button_target_et-desktop' => array(
					'selector'  => '.single-product-button-wrapper',
					'render_callback' => 'single_product_button_callback'
				),
			),
		) );

		// single_product_button_no_follow
		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'toggle',
			'settings'    => 'single_product_button_no_follow_et-desktop',
			'label'       => $strings['label']['rel_no_follow'],
			'section'     => 'single-button',
			'default'     => 0,
			'transport' => 'postMessage',
			'partial_refresh' => array(
				'single_product_button_no_follow_et-desktop' => array(
					'selector'  => '.single-product-button-wrapper',
					'render_callback' => 'single_product_button_callback'
				),
			),
		) );
?>