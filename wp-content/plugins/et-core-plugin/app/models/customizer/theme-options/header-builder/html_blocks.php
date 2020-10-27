<?php  
	/**
	 * The template created for displaying header html blocks elements options
	 *
	 * @version 1.0.2
	 * @since 1.4.0
	 * last changes in 1.5.5
	 */

	// section html_blocks
	Kirki::add_section( 'html_blocks', array(
	    'title'          => esc_html__( 'Html blocks', 'xstore-core' ),
	    'panel' => 'header-builder',
	    'icon' => 'dashicons-editor-code'
		) );

		// content separator
		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'custom',
			'settings'    => 'html_block1_content_separator',
			'section'     => 'html_blocks',
			'default'     => '<div style="'.$sep_style.'"><span class="dashicons dashicons-admin-settings"></span> <span style="padding-left: 3px;">' . esc_html__( 'HTML Block 1', 'xstore-core' ) . '</span></div>',
			'priority'    => 10,
		) );

		// html_block1
		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'editor',
			'settings'    => 'html_block1',
			'label'       => esc_html__( 'HTML block 1', 'xstore-core' ),
			'description' => $strings['label']['editor_control'],
			'section'     => 'html_blocks',
			'default'     => '',
			'active_callback' => array(
				array(
					'setting'  => 'html_block1_sections',
					'operator' => '!=',
					'value'    => '1',
				),
			),
			'transport' => 'postMessage',
			'partial_refresh' => array(
				'html_block1' => array(
					'selector'  => '.header-html_block1',
					'render_callback' => function() {
					    return html_blocks_callback(array(
					    	'html_backup' => 'html_block1',
					    ));
					},
				),
			),
		) );

		// html_block1_sections
		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'toggle',
			'settings'    => 'html_block1_sections',
			'label'       => $strings['label']['use_static_block'],
			'section'     => 'html_blocks',
			'default'     => 0,
			'transport'   => 'postMessage',
			'partial_refresh' => array(
				'html_block1_sections' => array(
					'selector'  => '.header-html_block1',
					'render_callback' => function() {
					    return html_blocks_callback(array(
					    	'section' => 'html_block1_section',
					    	'sections' => 'html_block1_sections',
					    	'html_backup' => 'html_block1',
					    	'section_content' => true
					    ));
					},
				),
			),
		) );

		// html_block1_section
		Kirki::add_field( 'et_kirki_options', array(
			'type'     => 'select',
			'settings' => 'html_block1_section',
			'label'    => sprintf(esc_html__( 'Choose %1s for HTML Block 1', 'xstore-core' ), '<a href="https://xstore.helpscoutdocs.com/article/47-static-blocks" target="_blank" style="color: #555">'.esc_html__('static block', 'xstore-core').'</a>'),
			'section'  => 'html_blocks',
			'default'  => '',
			'priority' => 10,
			'choices'  => $post_types['sections'],
			'active_callback' => array(
				array(
					'setting'  => 'html_block1_sections',
					'operator' => '==',
					'value'    => 1,
				),
			),
			'transport' => 'postMessage',
			'partial_refresh' => array(
				'html_block1_section' => array(
					'selector'  => '.header-html_block1',
					'render_callback' => function() {
					    return html_blocks_callback(array(
					    	'section' => 'html_block1_section',
					    	'sections' => 'html_block1_sections',
					    	'html_backup' => 'html_block1',
					    	'section_content' => true
					    ));
					},
				),
			),
		) );

		// content separator
		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'custom',
			'settings'    => 'html_block2_content_separator',
			'section'     => 'html_blocks',
			'default'     => '<div style="'.$sep_style.'"><span class="dashicons dashicons-admin-settings"></span> <span style="padding-left: 3px;">' . esc_html__( 'HTML Block 2', 'xstore-core' ) . '</span></div>',
			'priority'    => 10,
		) );

		// html_block2
		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'editor',
			'settings'    => 'html_block2',
			'label'       => esc_html__( 'Html block 2', 'xstore-core' ),
			'description' => $strings['label']['editor_control'],
			'section'     => 'html_blocks',
			'default'     => '',
			'active_callback' => array(
				array(
					'setting'  => 'html_block2_sections',
					'operator' => '!=',
					'value'    => '1',
				),
			),
			'transport' => 'postMessage',
			'partial_refresh' => array(
				'html_block2' => array(
					'selector'  => '.header-html_block2',
					'render_callback' => function() {
					    return html_blocks_callback(array(
					    	'html_backup' => 'html_block2',
					    ));
					},
				),
			),
		) );

		// html_block2_sections
		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'toggle',
			'settings'    => 'html_block2_sections',
			'label'       => $strings['label']['use_static_block'],
			'section'     => 'html_blocks',
			'default'     => 0,
			'transport'   => 'postMessage',
			'partial_refresh' => array(
				'html_block2_sections' => array(
					'selector'  => '.header-html_block2',
					'render_callback' => function() {
					    return html_blocks_callback(array(
					    	'section' => 'html_block2_sections',
					    	'sections' => 'html_block2_sections',
					    	'html_backup' => 'html_block2',
					    	'section_content' => true
					    ));
					},
				),
			),
		) );

		// html_block2_section
		Kirki::add_field( 'et_kirki_options', array(
			'type'     => 'select',
			'settings' => 'html_block2_section',
			'label'    => sprintf(esc_html__( 'Choose %1s for HTML Block 2', 'xstore-core' ), '<a href="https://xstore.helpscoutdocs.com/article/47-static-blocks" target="_blank" style="color: #555">'.esc_html__('static block', 'xstore-core').'</a>'),
			'section'  => 'html_blocks',
			'default'  => '',
			'priority' => 10,
			'choices'  => $post_types['sections'],
			'active_callback' => array(
				array(
					'setting'  => 'html_block2_sections',
					'operator' => '==',
					'value'    => 1,
				),
			),
			'transport' => 'postMessage',
			'partial_refresh' => array(
				'html_block2_section' => array(
					'selector'  => '.header-html_block2',
					'render_callback' => function() {
					    return html_blocks_callback(array(
					    	'section' => 'html_block2_sections',
					    	'sections' => 'html_block2_sections',
					    	'html_backup' => 'html_block2',
					    	'section_content' => true
					    ));
					},
				),
			),
		) );

		// content separator
		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'custom',
			'settings'    => 'html_block3_content_separator',
			'section'     => 'html_blocks',
			'default'     => '<div style="'.$sep_style.'"><span class="dashicons dashicons-admin-settings"></span> <span style="padding-left: 3px;">' . esc_html__( 'HTML Block 3', 'xstore-core' ) . '</span></div>',
			'priority'    => 10,
		) );

		// html_block3
		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'editor',
			'settings'    => 'html_block3',
			'label'       => esc_html__( 'Html block 3', 'xstore-core' ),
			'description' => $strings['label']['editor_control'],
			'section'     => 'html_blocks',
			'default'     => '',
			'active_callback' => array(
				array(
					'setting'  => 'html_block3_sections',
					'operator' => '!=',
					'value'    => '1',
				),
			),
			'transport' => 'postMessage',
			'partial_refresh' => array(
				'html_block3' => array(
					'selector'  => '.header-html_block3',
					'render_callback' => function() {
					    return html_blocks_callback(array(
					    	'html_backup' => 'html_block3',
					    ));
					},
				),
			),
		) );

		// html_block3_sections
		Kirki::add_field( 'et_kirki_options', array(
			'type'        => 'toggle',
			'settings'    => 'html_block3_sections',
			'label'       => $strings['label']['use_static_block'],
			'section'     => 'html_blocks',
			'default'     => 0,
			'transport' => 'postMessage',
			'partial_refresh' => array(
				'html_block3_sections' => array(
					'selector'  => '.header-html_block3',
					'render_callback' => function() {
					    return html_blocks_callback(array(
					    	'section' => 'html_block3_section',
					    	'sections' => 'html_block3_sections',
					    	'html_backup' => 'html_block3',
					    	'section_content' => true
					    ));
					},
				),
			),
		) );

		// html_block3_section
		Kirki::add_field( 'et_kirki_options', array(
			'type'     => 'select',
			'settings' => 'html_block3_section',
			'label'    => sprintf(esc_html__( 'Choose %1s for HTML Block 3', 'xstore-core' ), '<a href="https://xstore.helpscoutdocs.com/article/47-static-blocks" target="_blank" style="color: #555">'.esc_html__('static block', 'xstore-core').'</a>'),
			'section'  => 'html_blocks',
			'default'  => '',
			'priority' => 10,
			'choices'  => $post_types['sections'],
			'active_callback' => array(
				array(
					'setting'  => 'html_block3_sections',
					'operator' => '==',
					'value'    => 1,
				),
			),
			'transport' => 'postMessage',
			'partial_refresh' => array(
				'html_block3_section' => array(
					'selector'  => '.header-html_block3',
					'render_callback' => function() {
					    return html_blocks_callback(array(
					    	'section' => 'html_block3_section',
					    	'sections' => 'html_block3_sections',
					    	'html_backup' => 'html_block3',
					    	'section_content' => true
					    ));
					},
				),
			),
		) );
?>