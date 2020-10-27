<?php
namespace ETC\App\Controllers\Elementor\General;

/**
 * General tabs widget.
 *
 * @since      2.3.1
 * @package    ETC
 * @subpackage ETC/Controllers/Elementor
 */
class Tabs extends \Elementor\Widget_Base {

    /**
    * Get widget name.
    *
    * @since 2.3.1
    * @access public
    *
    * @return string Widget name.
    */
    public function get_name() {
    	return 'et-general-tabs';
    }

    /**
     * Get widget title.
     *
     * @since 2.1.3
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
    	return __( 'General Tabs', 'xstore-core' );
    }

    /**
     * Get widget icon.
     *
     * @since 2.1.3
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon() {
    	return 'eight_theme-elementor-icon et-elementor-tabs';
    }

    /**
     * Get widget keywords.
     *
     * @since 2.1.3
     * @access public
     *
     * @return array Widget keywords.
     */
    public function get_keywords(){
    	return [ 'tab', 'tabs',];
    }

    /**
     * Get widget categories.
     *
     * @since 2.1.3
     * @access public
     *
     * @return array Widget categories.
     */
    public function get_categories() {
    	return ['eight_theme_general'];
    }

    /**
    * Register general tabs widget controls.
    *
    * @since 2.1.3
    * @access protected
    */
    protected function _register_controls() {

    	$this->start_controls_section(
    		'et_section_tabs_settings',
    		[
    			'label' => esc_html__( 'General Settings', 'xstore-core' ),
    		]
    	);

    	$this->add_control(
    		'et_tab_layout',
    		[
    			'label' => esc_html__( 'Layout', 'xstore-core' ),
    			'type' => \Elementor\Controls_Manager::SELECT,
    			'label_block' => false,
    			'options' => [
    				'et-tabs-horizontal' => esc_html__('Horizontal', 'xstore-core'),
    				'et-tabs-vertical'   => esc_html__('Vertical', 'xstore-core'),
    			],
    			'default' => 'et-tabs-horizontal',
    		]
    	);    	

    	$this->add_control(
    		'et_tab_horizontal_style',
    		[
    			'label' => esc_html__( 'Horizontal Style', 'xstore-core' ),
    			'type' => \Elementor\Controls_Manager::SELECT,
    			'label_block' => false,
    			'options' => [
    				'horizontal-style-1' => esc_html__( 'Style 1', 'xstore-core' ),
    				'horizontal-style-2' => esc_html__( 'Style 2', 'xstore-core' ),
    				'horizontal-style-3' => esc_html__( 'Style 3', 'xstore-core' ),
    				'horizontal-style-4' => esc_html__( 'Style 4', 'xstore-core' ),
    				'horizontal-style-5' => esc_html__( 'Style 5', 'xstore-core' ),
    				'horizontal-style-6' => esc_html__( 'Style 6', 'xstore-core' ),
    				'horizontal-style-7' => esc_html__( 'Style 7', 'xstore-core' ),
    			],
    			'condition' => ['et_tab_layout' => 'et-tabs-horizontal'],
    			'default'   => 'horizontal-style-1',
    		]
    	);

    	$this->add_control(
    		'et_tab_vertical_style',
    		[
    			'label' => esc_html__( 'Vertical Style', 'xstore-core' ),
    			'type' => \Elementor\Controls_Manager::SELECT,
    			'label_block' => false,
    			'options' => [
    				'vertical-style-1' => esc_html__('Style 1', 'xstore-core'),
    				'vertical-style-2' => esc_html__('Style 2', 'xstore-core'),
    			],
    			'condition' => ['et_tab_layout' => 'et-tabs-vertical'],
    			'default'   => 'vertical-style-1',
    		]
    	);

    	$this->add_control(
    		'et_tabs_icon_show_horizontal',
    		[
    			'label' => esc_html__( 'Enable Icon', 'xstore-core' ),
    			'type' => \Elementor\Controls_Manager::SWITCHER,
    			'default' => '',
    			'return_value' => 'yes',
    			'condition' => [ 'et_tab_horizontal_style' => [ 'horizontal-style-4','horizontal-style-5','horizontal-style-6'], 'et_tab_layout' => 'et-tabs-horizontal' ]
    		]
    	);

    	$this->add_control(
    		'et_tabs_icon_show_vertical',
    		[
    			'label' => esc_html__( 'Enable Icon', 'xstore-core' ),
    			'type' => \Elementor\Controls_Manager::SWITCHER,
    			'default' => '',
    			'return_value' => 'yes',
    			'condition' => [ 'et_tab_vertical_style' => ['vertical-style-2'], 'et_tab_layout' => 'et-tabs-vertical' ]
    		]
    	);

    	$this->add_responsive_control(
    		'et_tabs_spacer_margin',
    		[
    			'label' => __('Tab Horizontal Spacer', 'xstore-core'),
    			'type' =>  \Elementor\Controls_Manager::SLIDER,
    			'size_units' => ['px', 'em'],
    			'range' => [
    				'px' => [
    					'min' => 0,
    					'max' => 1000,
    					'step' => 1,
    				],
    				'em' => [
    					'min' => 0,
    					'max' => 50,
    					'step' => 1,
    				],
    			],
    			'selectors' => [
    				'{{WRAPPER}} .et-advance-tabs.et-tabs-horizontal .et-tabs-nav > ul li:not(:last-child), {{WRAPPER}} .et-advance-tabs.et-tabs-vertical .et-tabs-nav > ul li' => 'margin-right: {{SIZE}}{{UNIT}};',
    			],
                'conditions' => [
                    'terms'  => [
                        [
                            'name'      => 'et_tab_horizontal_style',
                            'operator'  => '!in',
                            'value'     => ['horizontal-style-3'],
                        ]
                    ]
                ]
            ]
        );

        $this->add_responsive_control(
            'et_tabs_spacer_padding',
            [
                'label' => __('Tab Horizontal Spacer', 'xstore-core'),
                'type' =>  \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 50,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .et-advance-tabs.horizontal-style-3 .et-tabs-nav > ul li' => 'padding-right: {{SIZE}}{{UNIT}};',
                ],
                'conditions' => [
                    'terms' => [
                        [
                            'name'     => 'et_tab_horizontal_style',
                            'operator' => 'in',
                            'value'    => ['horizontal-style-3']
                        ]
                    ]
                ]
            ]
        );

        $this->add_responsive_control(
            'et_tabs_vertical_spacer',
            [
                'label' => __('Tab Vertical Space', 'xstore-core'),
                'type' =>  \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 50,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .et-advance-tabs.et-tabs-vertical .et-tabs-nav > ul li' => 'padding-top: {{SIZE}}{{UNIT}}; padding-bottom: {{SIZE}}{{UNIT}};',
                ],
                'condition' => ['et_tab_layout' => 'et-tabs-vertical'],
            ]
        );

    	$this->add_control(
    		'et_tab_icon_position_horizontal',
    		[
    			'label' => esc_html__( 'Icon Position', 'xstore-core' ),
    			'type' => \Elementor\Controls_Manager::SELECT,
    			'default' => 'et-tab-inline-icon',
    			'label_block' => false,
    			'options' => [
    				'et-tab-top-icon' 	 => esc_html__('Stacked', 'xstore-core'),
    				'et-tab-inline-icon' => esc_html__('Inline', 'xstore-core'),
    			],
                'condition' => [ 'et_tab_horizontal_style' => [ 'horizontal-style-4','horizontal-style-5','horizontal-style-6'], 'et_tabs_icon_show_horizontal' => 'yes', 'et_tab_layout' => 'et-tabs-horizontal' ]
    		]
    	);

    	$this->add_control(
    		'et_tab_icon_position_vertical',
    		[
    			'label' => esc_html__( 'Icon Position', 'xstore-core' ),
    			'type' => \Elementor\Controls_Manager::SELECT,
    			'default' => 'et-tab-inline-icon',
    			'label_block' => false,
    			'options' => [
    				'et-tab-top-icon' 	 => esc_html__('Stacked', 'xstore-core'),
    				'et-tab-inline-icon' => esc_html__('Inline', 'xstore-core'),
    			],
                'condition' => [ 'et_tab_horizontal_style' => [ 'horizontal-style-4','horizontal-style-5','horizontal-style-6'], 'et_tabs_icon_show_vertical' => 'yes', 'et_tab_layout' => 'et-tabs-vertical' ]
    		]
    	);

    	$this->end_controls_section();

    	$this->start_controls_section(
    		'et_section_tabs_content_settings',
    		[
    			'label' => esc_html__('Content', 'xstore-core'),
    		]
    	);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'et_tabs_tab_show_as_default', [
				'label' => __('Set as Default', 'xstore-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'inactive',
				'return_value' => 'active-default',
			]
		);

		$repeater->add_control(
			'et_tabs_icon_type', [
				'label' => esc_html__('Icon Type', 'xstore-core'),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'label_block' => false,
				'options' => [
					'none' => [
						'title' => esc_html__('None', 'xstore-core'),
						'icon' => 'fa fa-ban',
					],
					'icon' => [
						'title' => esc_html__('Icon', 'xstore-core'),
						'icon' => 'fa fa-gear',
					],
					'image' => [
						'title' => esc_html__('Image', 'xstore-core'),
						'icon' => 'fa fa-picture-o',
					],
				],
				'default' => 'none',
			]
		);

		$repeater->add_control(
			'et_tabs_tab_title_icon', [
				'label' => esc_html__('Icon', 'xstore-core'),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-home',
					'library' => 'fa-solid',
				],
				'condition'	=> ['et_tabs_icon_type' => 'icon']
			]
		);		

		$repeater->add_control(
			'et_tabs_tab_title_image', [
				'label' => esc_html__('Image', 'xstore-core'),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
				'condition'	=> ['et_tabs_icon_type' => 'image']
			]
		);

		$repeater->add_control(
			'et_tabs_tab_title', [
				'label' => esc_html__('Tab Title', 'xstore-core'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__('Tab Title', 'xstore-core'),
			]
		);

		$repeater->add_control(
			'et_tabs_text_type', [
				'label' => __('Content Type', 'xstore-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'content' => __('Content', 'xstore-core'),
					'template' => __('Saved Templates', 'xstore-core'),
				],
				'default' => 'content',
			]
		);

		$repeater->add_control(
			'et_primary_templates', [
				'label' => __('Choose Template', 'xstore-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => $this->et_get_page_templates(),
				'condition'	=> ['et_tabs_text_type' => 'template']
			]
		);

		$repeater->add_control(
			'et_tabs_tab_content', [
				'label' => esc_html__('Tab Content', 'xstore-core'),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'default' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipisicing elit. Optio, neque qui velit. Magni dolorum quidem ipsam eligendi, totam, facilis laudantium cum accusamus ullam voluptatibus commodi numquam, error, est. Ea, consequatur.', 'xstore-core'),
				'condition'	=> ['et_tabs_text_type' => 'content']
			]
		);

		$this->add_control(
			'et_tabs_tab',
			[
				'label' => __( 'Tab Title', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
    				['et_tabs_tab_title' => esc_html__('Tab Title 1', 'xstore-core')],
    				['et_tabs_tab_title' => esc_html__('Tab Title 2', 'xstore-core')],
    				['et_tabs_tab_title' => esc_html__('Tab Title 3', 'xstore-core')],
				],
				'title_field' => '{{et_tabs_tab_title}}',
			]
		);

    	$this->end_controls_section();

    	$this->start_controls_section(
    		'et_section_tabs_tab_style_settings',
    		[
    			'label' => esc_html__('Tab Style', 'xstore-core'),
    			'tab' =>  \Elementor\Controls_Manager::TAB_STYLE,
    		]
    	);

    	$this->add_group_control(
    		\Elementor\Group_Control_Typography::get_type(),
    		[
    			'name' => 'et_tabs_tab_title_typography',
    			'selector' => '{{WRAPPER}} .et-advance-tabs .et-tabs-nav > ul li',
    		]
    	);

    	$this->add_responsive_control(
    		'et_tabs_title_width',
    		[
    			'label' => __('Title Min Width', 'xstore-core'),
    			'type' =>  \Elementor\Controls_Manager::SLIDER,
    			'size_units' => ['px', 'em'],
    			'range' => [
    				'px' => [
    					'min' => 0,
    					'max' => 1000,
    					'step' => 1,
    				],
    				'em' => [
    					'min' => 0,
    					'max' => 50,
    					'step' => 1,
    				],
    			],
    			'selectors' => [
    				'{{WRAPPER}} .et-advance-tabs.et-tabs-vertical .et-tabs-nav > ul' => 'min-width: {{SIZE}}{{UNIT}};',
    			],
    			'condition' => ['et_tab_layout' => 'et-tabs-vertical'],
    		]
    	);

    	$this->add_responsive_control(
    		'et_tabs_tab_icon_size_horizontal',
    		[
    			'label' => __('Icon Size', 'xstore-core'),
    			'type' =>  \Elementor\Controls_Manager::SLIDER,
    			'size_units' => ['px'],
    			'range' => [
    				'px' => [
    					'min' => 0,
    					'max' => 200,
    					'step' => 1,
    				],
    			],
    			'selectors' => [
    				'{{WRAPPER}} .et-advance-tabs .et-tabs-nav > ul li i' => 'font-size: {{SIZE}}{{UNIT}};',
    				'{{WRAPPER}} .et-advance-tabs .et-tabs-nav > ul li img' => 'width: {{SIZE}}{{UNIT}};',
    			],
    			'condition' => ['et_tabs_icon_show_horizontal' => 'yes'],
    		]
    	);

    	$this->add_responsive_control(
    		'et_tabs_tab_icon_size_vertical',
    		[
    			'label' => __('Icon Size', 'xstore-core'),
    			'type' =>  \Elementor\Controls_Manager::SLIDER,
    			'size_units' => ['px'],
    			'range' => [
    				'px' => [
    					'min' => 0,
    					'max' => 200,
    					'step' => 1,
    				],
    			],
    			'selectors' => [
    				'{{WRAPPER}} .et-advance-tabs .et-tabs-nav > ul li i' => 'font-size: {{SIZE}}{{UNIT}};',
    				'{{WRAPPER}} .et-advance-tabs .et-tabs-nav > ul li img' => 'width: {{SIZE}}{{UNIT}};',
    			],
    			'condition' => ['et_tabs_icon_show_vertical' => 'yes'],
    		]
    	);

    	$this->add_responsive_control(
    		'et_tabs_tab_icon_gap_horizontal',
    		[
    			'label' => __('Icon Gap', 'xstore-core'),
    			'type' =>  \Elementor\Controls_Manager::SLIDER,
    			'size_units' => ['px'],
    			'range' => [
    				'px' => [
    					'min' => 0,
    					'max' => 100,
    					'step' => 1,
    				],
    			],
    			'selectors' => [
    				'{{WRAPPER}} .et-tab-inline-icon li i, {{WRAPPER}} .et-tab-inline-icon li img' => 'margin-right: {{SIZE}}{{UNIT}};',
    				'{{WRAPPER}} .et-tab-top-icon li i, {{WRAPPER}} .et-tab-top-icon li img' => 'margin-bottom: {{SIZE}}{{UNIT}};',
    			],
    			'condition' => ['et_tabs_icon_show_horizontal' => 'yes'],
    		]
    	);

    	$this->add_responsive_control(
    		'et_tabs_tab_icon_gap_vertical',
    		[
    			'label' => __('Icon Gap', 'xstore-core'),
    			'type' =>  \Elementor\Controls_Manager::SLIDER,
    			'size_units' => ['px'],
    			'range' => [
    				'px' => [
    					'min' => 0,
    					'max' => 100,
    					'step' => 1,
    				],
    			],
    			'selectors' => [
    				'{{WRAPPER}} .et-tab-inline-icon li i, {{WRAPPER}} .et-tab-inline-icon li img' => 'margin-right: {{SIZE}}{{UNIT}};',
    				'{{WRAPPER}} .et-tab-top-icon li i, {{WRAPPER}} .et-tab-top-icon li img' => 'margin-bottom: {{SIZE}}{{UNIT}};',
    			],
    			'condition' => ['et_tabs_icon_show_vertical' => 'yes'],
    		]
    	);

    	$this->add_responsive_control(
    		'et_tabs_tab_padding',
    		[
    			'label' => esc_html__('Padding', 'xstore-core'),
    			'type' =>  \Elementor\Controls_Manager::DIMENSIONS,
    			'size_units' => ['px', 'em', '%'],
    			'selectors' => [
    				'{{WRAPPER}} .et-advance-tabs .et-tabs-nav > ul li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
    			],
    		]
    	);

    	$this->add_responsive_control(
    		'et_tabs_tab_margin',
    		[
    			'label' => esc_html__('Margin', 'xstore-core'),
    			'type' =>  \Elementor\Controls_Manager::DIMENSIONS,
    			'size_units' => ['px', 'em', '%'],
    			'selectors' => [
    				'{{WRAPPER}} .et-advance-tabs .et-tabs-nav > ul li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
    			],
    		]
    	);

    	$this->start_controls_tabs('et_tabs_header_tabs');
    	$this->start_controls_tab( 'et_tabs_header_normal',
    		[
    			'label' => esc_html__('Normal', 'xstore-core')
    		]
    	);

    	$this->add_control(
    		'et_tabs_tab_color',
    		[
    			'label' => esc_html__('Background Color', 'xstore-core'),
    			'type' =>  \Elementor\Controls_Manager::COLOR,
    			'selectors' => [
    				'{{WRAPPER}} .et-advance-tabs .et-tabs-nav > ul li' => 'background-color: {{VALUE}};',
    			],
    		]
    	);

    	$this->add_group_control(
    		\Elementor\Group_Control_Background::get_type(),
    		[
    			'name' => 'et_tabs_tab_bgtype',
    			'types' => [ 'classic', 'gradient' ],
    			'selector' => '{{WRAPPER}} .et-advance-tabs .et-tabs-nav > ul li'
    		]
    	);

    	$this->add_control(
    		'et_tabs_tab_text_color',
    		[
    			'label' => esc_html__('Text Color', 'xstore-core'),
    			'type' =>  \Elementor\Controls_Manager::COLOR,
    			'selectors' => [
    				'{{WRAPPER}} .et-advance-tabs .et-tabs-nav > ul li' => 'color: {{VALUE}};',
    			],
    		]
    	);

    	$this->add_control(
    		'et_tabs_tab_icon_color_horizontal',
    		[
    			'label' => esc_html__('Icon Color', 'xstore-core'),
    			'type' =>  \Elementor\Controls_Manager::COLOR,
    			'selectors' => [
    				'{{WRAPPER}} .et-advance-tabs .et-tabs-nav > ul li i' => 'color: {{VALUE}};',
    			],
    			'condition' => ['et_tabs_icon_show_horizontal' => 'yes'],
    		]
    	);

    	$this->add_control(
    		'et_tabs_tab_icon_color_vertical',
    		[
    			'label' => esc_html__('Icon Color', 'xstore-core'),
    			'type' =>  \Elementor\Controls_Manager::COLOR,
    			'selectors' => [
    				'{{WRAPPER}} .et-advance-tabs .et-tabs-nav > ul li i' => 'color: {{VALUE}};',
    			],
    			'condition' => ['et_tabs_icon_show_vertical' => 'yes'],
    		]
    	);

    	$this->end_controls_tab();

    	$this->start_controls_tab(
    		'et_tabs_header_hover', 
    		[
    			'label' => esc_html__('Hover', 'xstore-core')
    		]
    	);

    	$this->add_control(
    		'et_tabs_tab_color_hover',
    		[
    			'label' => esc_html__('Tab Background Color', 'xstore-core'),
    			'type' =>  \Elementor\Controls_Manager::COLOR,
    			'selectors' => [
    				'{{WRAPPER}} .et-advance-tabs .et-tabs-nav > ul li:hover' => 'background-color: {{VALUE}};',
    			],
    		]
    	);

    	$this->add_group_control(
    		\Elementor\Group_Control_Background::get_type(),
    		[
    			'name' => 'et_tabs_tab_bgtype_hover',
    			'types' => [ 'classic', 'gradient' ],
    			'selector' => '{{WRAPPER}} .et-advance-tabs .et-tabs-nav > ul li:hover'
    		]
    	);

    	$this->add_control(
    		'et_tabs_tab_text_color_hover',
    		[
    			'label' => esc_html__('Text Color', 'xstore-core'),
    			'type' =>  \Elementor\Controls_Manager::COLOR,
    			'selectors' => [
    				'{{WRAPPER}} .et-advance-tabs .et-tabs-nav > ul li:hover' => 'color: {{VALUE}};',
    			],
    		]
    	);

    	$this->add_control(
    		'et_tabs_tab_icon_color_hover_horizontal',
    		[
    			'label' => esc_html__('Icon Color', 'xstore-core'),
    			'type' =>  \Elementor\Controls_Manager::COLOR,
    			'selectors' => [
    				'{{WRAPPER}} .et-advance-tabs .et-tabs-nav > ul li:hover > i' => 'color: {{VALUE}};'
    			],
    			'condition' => ['et_tabs_icon_show_horizontal' => 'yes'],
    		]
    	);

    	$this->add_control(
    		'et_tabs_tab_icon_color_hover_vertical',
    		[
    			'label' => esc_html__('Icon Color', 'xstore-core'),
    			'type' =>  \Elementor\Controls_Manager::COLOR,
    			'selectors' => [
    				'{{WRAPPER}} .et-advance-tabs .et-tabs-nav > ul li:hover > i' => 'color: {{VALUE}};'
    			],
    			'condition' => ['et_tabs_icon_show_vertical' => 'yes'],
    		]
    	);

    	$this->end_controls_tab();

    	$this->start_controls_tab(
    		'et_tabs_header_active', 
    		[
    			'label' => esc_html__('Active', 'xstore-core')
    		]
    	);

    	$this->add_control(
    		'et_tabs_tab_color_active',
    		[
    			'label' => esc_html__('Tab Background Color', 'xstore-core'),
    			'type' =>  \Elementor\Controls_Manager::COLOR,
    			'selectors' => [
    				'{{WRAPPER}} .et-advance-tabs .et-tabs-nav > ul li.active' => 'background-color: {{VALUE}};',
    				'{{WRAPPER}} .et-advance-tabs .et-tabs-nav > ul li.active-default' => 'background-color: {{VALUE}};',
    			],
    		]
    	);

    	$this->add_group_control(
    		\Elementor\Group_Control_Background::get_type(),
    		[
    			'name' => 'et_tabs_tab_bgtype_active',
    			'types' => [ 'classic', 'gradient' ],
    			'selector' => '{{WRAPPER}} .et-advance-tabs .et-tabs-nav > ul li.active,{{WRAPPER}} .et-advance-tabs .et-tabs-nav > ul li.active-default'
    		]
    	);

    	$this->add_control(
    		'et_tabs_tab_text_color_active',
    		[
    			'label' => esc_html__('Text Color', 'xstore-core'),
    			'type' =>  \Elementor\Controls_Manager::COLOR,
    			'selectors' => [
    				'{{WRAPPER}} .et-advance-tabs .et-tabs-nav > ul li.active' => 'color: {{VALUE}};',
    				'{{WRAPPER}} .et-advance-tabs .et-tabs-nav > ul .active-default .et-tab-title' => 'color: {{VALUE}};',
    			],
    		]
    	);

    	$this->add_control(
    		'et_tabs_tab_icon_color_active_horizontal',
    		[
    			'label' => esc_html__('Icon Color', 'xstore-core'),
    			'type' =>  \Elementor\Controls_Manager::COLOR,
    			'selectors' => [
    				'{{WRAPPER}} .et-advance-tabs .et-tabs-nav > ul li.active > i' => 'color: {{VALUE}};',
    				'{{WRAPPER}} .et-advance-tabs .et-tabs-nav > ul li.active-default > i' => 'color: {{VALUE}};',
    			],
    			'condition' => ['et_tabs_icon_show_horizontal' => 'yes'],
    		]
    	);

    	$this->add_control(
    		'et_tabs_tab_icon_color_active_vertical',
    		[
    			'label' => esc_html__('Icon Color', 'xstore-core'),
    			'type' =>  \Elementor\Controls_Manager::COLOR,
    			'selectors' => [
    				'{{WRAPPER}} .et-advance-tabs .et-tabs-nav > ul li.active > i' => 'color: {{VALUE}};',
    				'{{WRAPPER}} .et-advance-tabs .et-tabs-nav > ul li.active-default > i' => 'color: {{VALUE}};',
    			],
    			'condition' => ['et_tabs_icon_show_vertical' => 'yes'],
    		]
    	);

        $this->add_control(
            'et_tabs_tab_divider_show',
            [
                'label' => esc_html__( 'Hide Divider', 'xstore-core' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => '',
                'return_value' => 'yes',
                'selectors' => [
                    '{{WRAPPER}} .et-advance-tabs .et-tabs-nav > ul li.active .et-tab-title:after' => 'opacity: 0 !important',
                    '{{WRAPPER}} .et-advance-tabs .et-tabs-nav > ul li:after' => 'opacity: 0 !important',
                ],
            ]
        );

        $this->add_control(
            'et_tabs_tab_divider_color',
            [
                'label' => esc_html__( 'Divider Color', 'xstore-core' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .et-advance-tabs .et-tabs-nav > ul li.active .et-tab-title:after' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .et-advance-tabs .et-tabs-nav > ul li:after' => 'background-color: {{VALUE}};',
                ],
                'condition' => ['et_tabs_tab_divider_show' => ''],
            ]
        );

    	$this->end_controls_tab();
    	$this->end_controls_tabs();
    	$this->end_controls_section();

    	$this->start_controls_section(
    		'et_section_tabs_tab_content_style_settings',
    		[
    			'label' => esc_html__('Content Style', 'xstore-core'),
    			'tab' =>  \Elementor\Controls_Manager::TAB_STYLE,
    		]
    	);

    	$this->add_control(
    		'adv_tabs_content_bg_color',
    		[
    			'label' => esc_html__('Background Color', 'xstore-core'),
    			'type' =>  \Elementor\Controls_Manager::COLOR,
    			'selectors' => [
    				'{{WRAPPER}} .et-advance-tabs .et-tabs-content > div' => 'background-color: {{VALUE}};',
    			],
    		]
    	);

    	$this->add_group_control(
    		\Elementor\Group_Control_Background::get_type(),
    		[
    			'name' => 'adv_tabs_content_bgtype',
    			'types' => [ 'classic', 'gradient' ],
    			'selector' => '{{WRAPPER}} .et-advance-tabs .et-tabs-content > div'
    		]
    	);

    	$this->add_control(
    		'adv_tabs_content_text_color',
    		[
    			'label' => esc_html__('Text Color', 'xstore-core'),
    			'type' =>  \Elementor\Controls_Manager::COLOR,
    			'selectors' => [
    				'{{WRAPPER}} .et-advance-tabs .et-tabs-content > div' => 'color: {{VALUE}};',
    			],
    		]
    	);

    	$this->add_group_control(
    		\Elementor\Group_Control_Typography::get_type(),
    		[
    			'name' => 'et_tabs_content_typography',
    			'selector' => '{{WRAPPER}} .et-advance-tabs .et-tabs-content > div',
    		]
    	);

    	$this->add_responsive_control(
    		'et_tabs_content_padding',
    		[
    			'label' => esc_html__('Padding', 'xstore-core'),
    			'type' =>  \Elementor\Controls_Manager::DIMENSIONS,
    			'size_units' => ['px', 'em', '%'],
    			'selectors' => [
    				'{{WRAPPER}} .et-advance-tabs .et-tabs-content > div' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
    			],
    		]
    	);

    	$this->add_responsive_control(
    		'et_tabs_content_margin',
    		[
    			'label' => esc_html__('Margin', 'xstore-core'),
    			'type' =>  \Elementor\Controls_Manager::DIMENSIONS,
    			'size_units' => ['px', 'em', '%'],
    			'selectors' => [
    				'{{WRAPPER}} .et-advance-tabs .et-tabs-content > div' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
    			],
    		]
    	);

    	$this->add_group_control(
    		\Elementor\Group_Control_Border::get_type(),
    		[
    			'name' => 'et_tabs_content_border',
    			'label' => esc_html__('Border', 'xstore-core'),
    			'selector' => '{{WRAPPER}} .et-advance-tabs .et-tabs-content > div',
    		]
    	);
    	$this->add_responsive_control(
    		'et_tabs_content_border_radius',
    		[
    			'label' => esc_html__('Border Radius', 'xstore-core'),
    			'type' =>  \Elementor\Controls_Manager::DIMENSIONS,
    			'size_units' => ['px', 'em', '%'],
    			'selectors' => [
    				'{{WRAPPER}} .et-tabs-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
    			],
    		]
    	);

    	$this->add_group_control(
    		\Elementor\Group_Control_Box_Shadow::get_type(),
    		[
    			'name' => 'et_tabs_content_shadow',
    			'selector' => '{{WRAPPER}} .et-advance-tabs .et-tabs-content > div',
    			'separator' => 'before',
    		]
    	);

    	$this->end_controls_section();

    	$this->start_controls_section(
    		'et_responsive_controls',
    		[
    			'label' => esc_html__('Responsive Controls', 'xstore-core'),
    			'tab' => \Elementor\Controls_Manager::TAB_STYLE,
    			'condition' => [
    				'et_tab_layout' => 'et-tabs-vertical',
    			],
    		]
    	);

    	$this->add_control(
    		'responsive_vertical_layout',
    		[
    			'label'     => __( 'Vertical Layout', 'xstore-core' ),
    			'type'      => \Elementor\Controls_Manager::SWITCHER,
    			'label_on'  => __( 'Yes', 'xstore-core' ),
    			'label_off' => __( 'No', 'xstore-core' ),
    			'return_value' => 'yes',
    			'default' => 'yes',
    		]
    	);

    	$this->end_controls_section();

    }

    /**
    * Render general tabs widget output on the frontend.
    *
    * @since 2.1.3
    * @access protected
    */
    protected function render() {
    	$settings = $this->get_settings_for_display();
    	$et_find_default_tab = array();

    	$this->add_render_attribute(
    		'et_tab_wrapper',
    		[
    			'id' => "et-advance-tabs-{$this->get_id()}",
    			'class' => ['et-advance-tabs', $settings['et_tab_layout'], $settings['et_tab_vertical_style'], $settings['et_tab_horizontal_style']],
    			'data-tabid' => $this->get_id(),
    		]
    	);

    	if( 'yes' != $settings['responsive_vertical_layout'] ) {
    		$this->add_render_attribute('et_tab_wrapper', 'class', 'responsive-vertical-layout');
    	}

    	if ( 'yes' === $settings['et_tabs_icon_show_horizontal'] ) {
    		$this->add_render_attribute('et_tab_icon_position', 'class', esc_attr($settings['et_tab_icon_position_horizontal']));
    	} elseif ( 'yes' === $settings['et_tabs_icon_show_vertical'] ) {
    		$this->add_render_attribute('et_tab_icon_position', 'class', esc_attr($settings['et_tab_icon_position_vertical']));
    	}
    	?>
    	<div <?php echo $this->get_render_attribute_string('et_tab_wrapper'); ?>>
    		<div class="et-tabs-nav">
    			<ul <?php echo $this->get_render_attribute_string('et_tab_icon_position'); ?>>
    				<?php foreach ($settings['et_tabs_tab'] as $tab): ?>
    					<li class="<?php echo esc_attr($tab['et_tabs_tab_show_as_default']); ?> et-tab-nav">
    						<!-- Horizontal -->
    						<?php if ( 'yes' === $settings['et_tabs_icon_show_horizontal'] ):
    							if ( $tab['et_tabs_icon_type'] === 'icon' ): ?>
    								<?php echo '<i class="' . $tab['et_tabs_tab_title_icon']['value'] . '"></i>'; ?>
    							<?php elseif ( $tab['et_tabs_icon_type'] === 'image' ): ?>
    								<img src="<?php echo esc_attr( $tab['et_tabs_tab_title_image']['url'] ); ?>" alt="<?php echo esc_attr( get_post_meta( $tab['et_tabs_tab_title_image']['id'], '_wp_attachment_image_alt', true ) ); ?>">
    							<?php endif;?>
    						<?php endif;?>
    						<!-- Vertical  -->
    						<?php if ( 'yes' === $settings['et_tabs_icon_show_vertical'] ):
    							if ( $tab['et_tabs_icon_type'] === 'icon' ): ?>
    								<?php echo '<i class="' . $tab['et_tabs_tab_title_icon']['value'] . '"></i>'; ?>
    							<?php elseif ( $tab['et_tabs_icon_type'] === 'image' ): ?>
    								<img src="<?php echo esc_attr( $tab['et_tabs_tab_title_image']['url'] ); ?>" alt="<?php echo esc_attr( get_post_meta( $tab['et_tabs_tab_title_image']['id'], '_wp_attachment_image_alt', true ) ); ?>">
    							<?php endif;?>
    						<?php endif;?>
    						<?php if( 'horizontal-style-6' != $settings['et_tab_horizontal_style'] ): ?>
    							<span class="et-tab-title">
    								<?php echo $tab['et_tabs_tab_title']; ?>
    							</span>
    						<?php endif; ?>
    					</li>
    					<?php endforeach; ?>
    				</ul>
    			</div>
			<div class="et-tabs-content">
				<?php foreach ( $settings['et_tabs_tab'] as $tab ): 
					$et_find_default_tab[] = $tab['et_tabs_tab_show_as_default'];
					?>
					<div class="clearfix <?php echo esc_attr($tab['et_tabs_tab_show_as_default']); ?>">
						<?php if ('content' == $tab['et_tabs_text_type'] ): ?>
							<?php echo do_shortcode( $tab['et_tabs_tab_content'] ); ?>
						<?php elseif ('template' == $tab['et_tabs_text_type']): ?>
							<?php if ( !empty( $tab['et_primary_templates'] ) ): ?>
								<?php echo \Elementor\Plugin::$instance->frontend->get_builder_content( $tab['et_primary_templates'], true ); ?>
							<?php endif; ?>
						<?php endif;?>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
    <?php
    }

    /**
     * Get all elementor page templates
     *
     * @return array
     */
    public function et_get_page_templates($type = null)
    {
    	$args = [
    		'post_type' => 'elementor_library',
    		'posts_per_page' => -1,
    	];

    	if ($type) {
    		$args['tax_query'] = [
    			[
    				'taxonomy' => 'elementor_library_type',
    				'field' => 'slug',
    				'terms' => $type,
    			],
    		];
    	}

    	$page_templates = get_posts($args);
    	$options = array();

    	if (!empty($page_templates) && !is_wp_error($page_templates)) {
    		foreach ($page_templates as $post) {
    			$options[$post->ID] = $post->post_title;
    		}
    	}
    	return $options;
    }

}