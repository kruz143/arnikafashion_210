<?php
/**
 * The template created for displaying header compare options when woocommerce plugin is installed
 *
 * @version 1.0.0
 * @since 2.3.7
 */

// section compare
Kirki::add_section( 'compare', array(
	'title'          => esc_html__( 'Compare', 'xstore-core' ),
	'panel' => 'header-builder',
	'icon' => 'dashicons-update-alt'
) );

// content separator
Kirki::add_field( 'et_kirki_options', array(
	'type'        => 'custom',
	'settings'    => 'compare_content_separator',
	'section'     => 'compare',
	'default'     => $separators['content'],
	'priority'    => 10,
) );

// compare_style
Kirki::add_field( 'et_kirki_options', array(
	'type'        => 'radio-image',
	'settings'    => 'compare_style_et-desktop',
	'label'       => $strings['label']['style'],
	'description' => esc_html__( 'Take a look on the video tutorial "How to ..." set up compare style2 and style3 ', 'xstore-core' ),
	'section'     => 'compare',
	'default'     => 'type1',
	'choices'     => et_b_element_styles('compare'),
	'transport' => 'postMessage',
	'partial_refresh' => array(
		'compare_style_et-desktop' => array(
			'selector'  => '.et_b_header-compare.et_element-top-level',
			'render_callback' => 'header_compare_callback'
		),
	),
	'js_vars'     => array(
		array(
			'element'  => '.et_b_header-compare.et_element-top-level',
			'function' => 'toggleClass',
			'class' => 'compare-type1',
			'value' => 'type1'
		),
		array(
			'element'  => '.et_b_header-compare.et_element-top-level',
			'function' => 'toggleClass',
			'class' => 'compare-type2',
			'value' => 'type2'
		),
		array(
			'element'  => '.et_b_header-compare.et_element-top-level',
			'function' => 'toggleClass',
			'class' => 'compare-type3',
			'value' => 'type3'
		),
	),
) );

// compare_icon
Kirki::add_field( 'et_kirki_options', array(
	'type'        => 'radio-image',
	'settings'    => 'compare_icon_et-desktop',
	'label'       => $strings['label']['icon'],
	'description' => $strings['description']['icons_style'],
	'section'     => 'compare',
	'default'     => 'type1',
	'choices'     => array(
		'type1'   => ETHEME_CODE_CUSTOMIZER_IMAGES . '/header/compare/Compare-1.svg',
		'custom'  => ETHEME_CODE_CUSTOMIZER_IMAGES . '/global/icon-custom.svg',
		'none'    => ETHEME_CODE_CUSTOMIZER_IMAGES . '/global/icon-none.svg'
	),
	'transport' => 'postMessage',
	'partial_refresh' => array(
		'compare_icon' => array(
			'selector'        => '.et_b_header-compare > a .et_b-icon .et-svg',
			'render_callback' => function() {
				global $et_icons;
				switch ( get_theme_mod('compare_icon_et-desktop') ) {
					case 'type1':
						return $et_icons['light']['et_icon-compare'];
					break;
					case 'custom':
						return get_theme_mod('compare_icon_custom_et-desktop');
					break;
					default:
						return '';
				}
			},
		),
	),
) );

// compare_icon_custom
Kirki::add_field( 'et_kirki_options', array (
	'type'     => 'code',
	'settings' => 'compare_icon_custom_et-desktop',
	'label'    => $strings['label']['custom_icon_svg'],
	'section'  => 'compare',
	'default'  => '',
	'choices'  => array(
		'language' => 'html'
	),
	'active_callback' => array(
		array(
			'setting'  => 'compare_icon_et-desktop',
			'operator' => '==',
			'value'    => 'custom',
		),
	),
	'transport' => 'postMessage',
	'js_vars' => array(
		array(
			'element'  => '.et_b_header-compare > a .et_b-icon .et-svg',
			'function' => 'html',
		),
	),
) );

// compare_icon_zoom  
Kirki::add_field( 'et_kirki_options', array(
	'type'        => 'slider',
	'settings'    => 'compare_icon_zoom_et-desktop',
	'label'       => $strings['label']['icons_zoom'],
	'section'     => 'compare',
	'default'     => 1.3,
	'choices'     => array(
		'min'  => '.7',
		'max'  => '3',
		'step' => '.1',
	),
	'active_callback' => array(
		array(
			'setting'  => 'compare_icon_et-desktop',
			'operator' => '!=',
			'value'    => 'none',
		),
	),
	'transport' => 'auto',
	'output' => array(
		array(
			'element' => '.et_b_header-compare.et_element-top-level > a svg',
			'property' => 'width',
			'units' => 'em'
		),
		array(
			'element' => '.et_b_header-compare.et_element-top-level > a svg',
			'property' => 'height',
			'units' => 'em'
		)
	)
) );

// compare_icon_zoom
Kirki::add_field( 'et_kirki_options', array(
	'type'        => 'slider',
	'settings'    => 'compare_icon_zoom_et-mobile',
	'label'       => $strings['label']['icons_zoom'],
	'section'     => 'compare',
	'default'     => 1.4,
	'choices'     => array(
		'min'  => '.7',
		'max'  => '3',
		'step' => '.1',
	),
	'active_callback' => array(
		array(
			'setting'  => 'compare_icon_et-mobile',
			'operator' => '!=',
			'value'    => 'none',
		),
	),
	'transport' => 'auto',
	'output' => array(
		array(
			'element' => '.mobile-header-wrapper .et_b_header-compare.et_element-top-level > a svg',
			'property' => 'width',
			'units' => 'em'
		),
		array(
			'element' => '.mobile-header-wrapper .et_b_header-compare.et_element-top-level > a svg',
			'property' => 'height',
			'units' => 'em'
		)
	)
) );

// compare_label
Kirki::add_field( 'et_kirki_options', array(
	'type'        => 'toggle',
	'settings'    => 'compare_label_et-desktop',
	'label'       => $strings['label']['show_title'],
	'section'     => 'compare',
	'default'     => '1',
	'transport' => 'postMessage',
	'js_vars'     => array(
		array(
			'element'  => '.et_b_header-compare.et_element-top-level > a .et-element-label',
			'function' => 'toggleClass',
			'class' => 'dt-hide',
			'value' => false
		),
	),
) );

// compare_label
Kirki::add_field( 'et_kirki_options', array(
	'type'        => 'toggle',
	'settings'    => 'compare_label_et-mobile',
	'label'       => $strings['label']['show_title'],
	'section'     => 'compare',
	'default'     => '0',
	'transport' => 'postMessage',
	'js_vars'     => array(
		array(
			'element'  => '.et_b_header-compare.et_element-top-level > a .et-element-label',
			'function' => 'toggleClass',
			'class' => 'mob-hide',
			'value' => false
		),
	),
) );

// compare_label_custom
Kirki::add_field( 'et_kirki_options', array (
	'type'     => 'text',
	'settings' => 'compare_label_custom_et-desktop',
	'section'  => 'compare',
	'default'  => esc_html__( 'Compare', 'xstore-core' ),
	'transport' => 'postMessage',
	'js_vars' => array(
		array(
			'element'  => '.et_b_header-compare > a .et-element-label',
			'function' => 'html',
		),
	),
) );

// style separator
Kirki::add_field( 'et_kirki_options', array(
	'type'        => 'custom',
	'settings'    => 'compare_style_separator',
	'section'     => 'compare',
	'default'     => $separators['style'],
	'priority'    => 10,
) );

// compare_content_alignment
Kirki::add_field( 'et_kirki_options', array(
	'type'        => 'radio-buttonset',
	'settings'    => 'compare_content_alignment_et-desktop',
	'label'       => $strings['label']['alignment'],
	'description' => esc_html__( 'Attention: if your element size bigger than the column width where the element is placed, element positioning may be a little bit different than as expected', 'xstore-core' ),
	'section'     => 'compare',
	'default'     => 'start',
	'choices'     => $choices['alignment'],
	'transport' => 'postMessage',
	'js_vars'     => array(
		array(
			'element'  => '.et_b_header-compare.et_element-top-level > a',
			'function' => 'toggleClass',
			'class' => 'justify-content-start',
			'value' => 'start'
		),
		array(
			'element'  => '.et_b_header-compare.et_element-top-level > a',
			'function' => 'toggleClass',
			'class' => 'justify-content-center',
			'value' => 'center'
		),
		array(
			'element'  => '.et_b_header-compare.et_element-top-level > a',
			'function' => 'toggleClass',
			'class' => 'justify-content-end',
			'value' => 'end'
		),
	),
) );

// compare_content_alignment
Kirki::add_field( 'et_kirki_options', array(
	'type'        => 'radio-buttonset',
	'settings'    => 'compare_content_alignment_et-mobile',
	'label'       => $strings['label']['alignment'],
	'description' => esc_html__( 'Attention: if your element size bigger than the column width where the element is placed, element positioning may be a little bit different than as expected', 'xstore-core' ),
	'section'     => 'compare',
	'default'     => 'start',
	'choices'     => $choices['alignment'],
	'transport' => 'postMessage',
	'js_vars'     => array(
		array(
			'element'  => '.et_b_header-compare.et_element-top-level > a',
			'function' => 'toggleClass',
			'class' => 'mob-justify-content-start',
			'value' => 'start'
		),
		array(
			'element'  => '.et_b_header-compare.et_element-top-level > a',
			'function' => 'toggleClass',
			'class' => 'mob-justify-content-center',
			'value' => 'center'
		),
		array(
			'element'  => '.et_b_header-compare.et_element-top-level > a',
			'function' => 'toggleClass',
			'class' => 'mob-justify-content-end',
			'value' => 'end'
		),
	),
) );

// compare_background
Kirki::add_field( 'et_kirki_options', array(
	'type'        => 'select',
	'settings'    => 'compare_background_et-desktop',
	'label'       => $strings['label']['colors'],
	'section'     => 'compare',
	'default'     => 'current',
	'choices'     => $choices['colors'],
	'output'      => array(
		array(
			'element' => '.et_b_header-compare.et_element-top-level > a',
			'property' => 'color',
			'value_pattern' => 'var(--$-color)'
		),
	),
) );

// compare_background_custom
Kirki::add_field( 'et_kirki_options', array(
	'type'        => 'color',
	'settings'    => 'compare_background_custom_et-desktop',
	'label'       => esc_html__( 'Background', 'xstore-core' ),
	'section'     => 'compare',
	'choices' 	  => array (
		'alpha' => true
	),
	'default' => '#ffffff',
	'active_callback' => array(
		array(
			'setting'  => 'compare_background_et-desktop',
			'operator' => '==',
			'value'    => 'custom',
		),
	),
	'transport' => 'auto',
	'output'      => array(
		array(
			'element' => '.et_b_header-compare.et_element-top-level > a',
			'property' => 'background-color',
		),
	),
) );

// compare_color
Kirki::add_field( 'et_kirki_options', array(
	'settings'    => 'compare_color_et-desktop',
	'label'       => $strings['label']['wcag_color'],
	'description' => $strings['description']['wcag_color'],
	'type'        => 'kirki-wcag-tc',
	'section'     => 'compare',
	'default'     => '#000000',
	'choices'     => array(
		'setting' => 'compare_background_custom_et-desktop',
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
	'active_callback' => array(
		array(
			'setting'  => 'compare_background_et-desktop',
			'operator' => '==',
			'value'    => 'custom',
		),
	),
	'transport' => 'auto',
	'output'	  => array(
		array(
			'element' => '.et_b_header-compare.et_element-top-level > a',
			'property' => 'color'
		)
	),
) );

// compare_border_radius
Kirki::add_field( 'et_kirki_options', array(
	'type'        => 'slider',
	'settings'    => 'compare_border_radius_et-desktop',
	'label'       => $strings['label']['border_radius'],
	'section'     => 'compare',
	'default'     => 0,
	'choices'     => array(
		'min'  => '0',
		'max'  => '100',
		'step' => '1',
	),
	'transport' => 'auto',
	'output' => array(
		array(
			'element' => '.et_b_header-compare.et_element-top-level > a',
			'property' => 'border-radius',
			'units' => 'px'
		)
	)
) );

// compare_box_model
Kirki::add_field( 'et_kirki_options', array(
	'settings'    => 'compare_box_model_et-desktop',
	'label'       => $strings['label']['computed_box'],
	'description' => esc_html__( 'You can select the margin, border-width and padding for compare element.', 'xstore-core' ),
	'type'        => 'kirki-box-model',
	'section'     => 'compare',
	'default'     => array(
		'margin-top'          => '0px',
		'margin-right'        => '0px',
		'margin-bottom'       => '0px',
		'margin-left'         => '0px',
		'border-top-width'    => '0px',
		'border-right-width'  => '0px',
		'border-bottom-width' => '0px',
		'border-left-width'   => '0px',
		'padding-top'         => '5px',
		'padding-right'       => '0px',
		'padding-bottom'      => '5px',
		'padding-left'        => '0px',
	),
	'output'      => array(
		array(
			'element' => '.et_b_header-compare.et_element-top-level > a'
		),
	),
	'transport' => 'postMessage',
	'js_vars'   => box_model_output('.et_b_header-compare.et_element-top-level > a')
) );

// compare_box_model
Kirki::add_field( 'et_kirki_options', array(
	'settings'    => 'compare_box_model_et-mobile',
	'label'       => $strings['label']['computed_box'],
	'description' => esc_html__( 'You can select the margin, border-width and padding for compare element.', 'xstore-core' ),
	'type'        => 'kirki-box-model',
	'section'     => 'compare',
	'default'     => $box_models['empty'],
	'output'      => array(
		array(
			'element' => '.mobile-header-wrapper .et_b_header-compare.et_element-top-level > a'
		),
	),
	'transport' => 'postMessage',
	'js_vars'   => box_model_output('.mobile-header-wrapper .et_b_header-compare.et_element-top-level > a')
) );

// compare_border
Kirki::add_field( 'et_kirki_options', array(
	'type'        => 'select',
	'settings'    => 'compare_border_et-desktop',
	'label'       => $strings['label']['border_style'],
	'section'     => 'compare',
	'default'     => 'solid',
	'choices'     => $choices['border_style'],
	'transport' => 'auto',
	'output'      => array(
		array(
			'element' => '.et_b_header-compare.et_element-top-level > a',
			'property' => 'border-style',
		),
	),
) );

// compare_border_color_custom
Kirki::add_field( 'et_kirki_options', array(
	'type'        => 'color',
	'settings'    => 'compare_border_color_custom_et-desktop',
	'label'       => $strings['label']['border_color'],
	'description' => $strings['description']['border_color'],
	'section'     => 'compare',
	'default' 	  => '#e1e1e1',
	'choices' 	  => array (
		'alpha' => true
	),
	'transport' => 'auto',
	'output'      => array(
		array(
			'element' => '.et_b_header-compare.et_element-top-level > a',
			'property' => 'border-color',
		),
	),
) );

?>