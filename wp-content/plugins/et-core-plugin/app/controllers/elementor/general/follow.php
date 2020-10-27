<?php
namespace ETC\App\Controllers\Elementor\General;

/**
 * Follow widget.
 *
 * @since      2.1.3
 * @package    ETC
 * @subpackage ETC/Controllers/Elementor
 */
class Follow extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * @since 2.1.3
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'etheme-follow';
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
		return __( 'Social links', 'xstore-core' );
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
		return 'eight_theme-elementor-icon et-elementor-social-links';
	}

	/**
	 * Get widget keywords.
	 *
	 * @since 2.1.3
	 * @access public
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'social-links', 'follow' ];
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
	 * Register follow widget controls.
	 *
	 * @since 2.1.3
	 * @access protected
	 */
	protected function _register_controls() {
		$this->start_controls_section(
			'settings',
			[
				'label' => __( 'Social links', 'xstore-core' ),
				'tab' 	=> \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'facebook',
			[
				'label' => __( 'Facebook link', 'xstore-core' ),
				'type' 	=> \Elementor\Controls_Manager::TEXT,
			]
		);

		$this->add_control(
			'twitter',
			[
				'label' => __( 'Twitter link', 'xstore-core' ),
				'type' 	=> \Elementor\Controls_Manager::TEXT,
			]
		);

		$this->add_control(
			'instagram',
			[
				'label' => __( 'Instagram link', 'xstore-core' ),
				'type' 	=> \Elementor\Controls_Manager::TEXT,
				'default' => '#'
			]
		);

		$this->add_control(
			'pinterest',
			[
				'label' => __( 'Pinterest link', 'xstore-core' ),
				'type' 	=> \Elementor\Controls_Manager::TEXT,
			]
		);

		$this->add_control(
			'linkedin',
			[
				'label' => __( 'LinkedIn link', 'xstore-core' ),
				'type' 	=> \Elementor\Controls_Manager::TEXT,
			]
		);

		$this->add_control(
			'tumblr',
			[
				'label' => __( 'Tumblr link', 'xstore-core' ),
				'type' 	=> \Elementor\Controls_Manager::TEXT,
			]
		);

		$this->add_control(
			'youtube',
			[
				'label' => __( 'YouTube link', 'xstore-core' ),
				'type' 	=> \Elementor\Controls_Manager::TEXT,
				'default' => '#'
			]
		);

		$this->add_control(
			'telegram',
			[
				'label' => __( 'Telegram link', 'xstore-core' ),
				'type' 	=> \Elementor\Controls_Manager::TEXT,
				'default' => '#'
			]
		);
		
		$this->add_control(
			'whatsapp',
			[
				'label' => __( 'Whatsapp link', 'xstore-core' ),
				'type' 	=> \Elementor\Controls_Manager::TEXT,
			]
		);

		$this->add_control(
			'vimeo',
			[
				'label' => __( 'Vimeo link', 'xstore-core' ),
				'type' 	=> \Elementor\Controls_Manager::TEXT,
			]
		);

		$this->add_control(
			'rss',
			[
				'label' => __( 'RSS link', 'xstore-core' ),
				'type' 	=> \Elementor\Controls_Manager::TEXT,
			]
		);

		$this->add_control(
			'vk',
			[
				'label' => __( 'VK link', 'xstore-core' ),
				'type' 	=> \Elementor\Controls_Manager::TEXT,
			]
		);

		$this->add_control(
			'houzz',
			[
				'label' => __( 'Houzz link', 'xstore-core' ),
				'type' 	=> \Elementor\Controls_Manager::TEXT,
			]
		);

		$this->add_control(
			'tripadvisor',
			[
				'label' => __( 'Tripadvisor link', 'xstore-core' ),
				'type' 	=> \Elementor\Controls_Manager::TEXT,
			]
		);

		$this->add_control(
			'target',
			[
				'label' 		=>	__( 'Links target', 'xstore-core' ),
				'type' 			=>	\Elementor\Controls_Manager::SELECT,
				'options' 		=>	[
					'_self'		=>	esc_html__('Current window', 'xstore-core'),
					'_blank'	=>	esc_html__('Blank', 'xstore-core'),
				],
				'default' => '_blank'
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'style_settings',
			[
				'label' => __( 'Style', 'xstore-core' ),
				'tab' 	=> \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'size',
			[
				'label' 		=>	__( 'Size', 'xstore-core' ),
				'type' 			=>	\Elementor\Controls_Manager::SELECT,
				'options' 		=>	[
					'normal'	=>	esc_html__('Normal', 'xstore-core'),
					'small'		=>	esc_html__('Small', 'xstore-core'),
					'large'		=>	esc_html__('Large', 'xstore-core'),
					'custom'	=>	esc_html__('Custom', 'xstore-core'),
				],
				'default'		=> 'normal',
			]
		);

		$this->add_responsive_control(
			'custom_size',
			[
				'label' => __( 'Custom size', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'default' => [
					'unit' => 'px',
					'size' => 16,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
					'em' => [
						'min' => 0,
						'max' => 50,
					],
					'rem' => [
						'min' => 0,
						'max' => 50,
					],
					'%' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'condition' => ['size' => 'custom'],
				'selectors'    => [
					'{{WRAPPER}} .et-follow-buttons a' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'spacing',
			[
				'label' => __( 'Space between', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'default' => [
					'unit' => 'px',
					'size' => 10,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
					'em' => [
						'min' => 0,
						'max' => 50,
					],
					'rem' => [
						'min' => 0,
						'max' => 50,
					],
					'%' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'selectors'    => [
					'{{WRAPPER}} .et-follow-buttons a' => 'margin: 0 {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label' 		=>	__( 'Alignment', 'xstore-core' ),
				'type' 			=>	\Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'flex-start'    => [
						'title' => __( 'Left', 'xstore-core' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'xstore-core' ),
						'icon' => 'eicon-text-align-center',
					],
					'flex-end' => [
						'title' => __( 'Right', 'xstore-core' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default'		=> 'flex-start',
				'selectors' => [
					'{{WRAPPER}} .et-follow-buttons' => 'justify-content: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'filled',
			[
				'label' 		=>	__( 'Filled icons', 'xstore-core' ),
				'type' 			=>	\Elementor\Controls_Manager::SWITCHER,
				'return_value'  =>	'true',
				'default' 		=>	'',
			]
		);

		$this->add_responsive_control(
			'padding',
			[
				'label' => __( 'Padding', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'default' => [
					'unit' => 'px',
					'size' => 7,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 30,
					],
					'em' => [
						'min' => 0,
						'max' => 30,
					],
					'rem' => [
						'min' => 0,
						'max' => 30,
					],
					'%' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'condition' => ['filled' => 'true'],
				'selectors'    => [
					'{{WRAPPER}} .et-follow-buttons a' => 'padding: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'icon_colors' );

		$this->start_controls_tab(
			'icon_colors_normal',
			[
				'label' => __( 'Normal', 'xstore-core' ),
			]
		);

		$this->add_control(
			'icons_color',
			[
				'label' 	=> __( 'Icons color', 'xstore-core' ),
				'type' 		=> \Elementor\Controls_Manager::COLOR,
				'scheme' 	=> [
					'type' 		=> \Elementor\Scheme_Color::get_type(),
					'value' 	=> \Elementor\Scheme_Color::COLOR_1,
				],
			]
		);

		$this->add_control(
			'icons_bg',
			[
				'label' 	=> __( 'Icons background', 'xstore-core' ),
				'type' 		=> \Elementor\Controls_Manager::COLOR,
				'scheme' 	=> [
					'type' 		=> \Elementor\Scheme_Color::get_type(),
					'value' 	=> \Elementor\Scheme_Color::COLOR_1,
				],
				'condition' => [ 'filled' => 'true' ],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'icon_colors_hover',
			[
				'label' => __( 'Hover', 'xstore-core' ),
			]
		);

		$this->add_control(
			'icons_color_hover',
			[
				'label' 	=> __( 'Icons color', 'xstore-core' ),
				'type' 		=> \Elementor\Controls_Manager::COLOR,
				'scheme' 	=> [
					'type' 		=> \Elementor\Scheme_Color::get_type(),
					'value' 	=> \Elementor\Scheme_Color::COLOR_1,
				],
			]
		);

		$this->add_control(
			'icons_bg_hover',
			[
				'label' 	=> __( 'Icons background', 'xstore-core' ),
				'type' 		=> \Elementor\Controls_Manager::COLOR,
				'scheme' 	=> [
					'type' 		=> \Elementor\Scheme_Color::get_type(),
					'value' 	=> \Elementor\Scheme_Color::COLOR_1,
				],
				'condition' => [ 'filled' => 'true' ],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'icons_border_radius',
			[
				'label' => __( 'Icons Border Radius', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'condition' => [ 'filled' => 'true' ],
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 5,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .et-follow-buttons > a' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

	}

	/**
	 * Render follow widget output on the frontend.
	 *
	 * @since 2.1.3
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		// unset value and make with css selectors 
		$settings['align'] = '';

		echo do_shortcode( '[follow 
			facebook="'. $settings['facebook'] .'"
			twitter="'. $settings['twitter'] .'"
			instagram="'. $settings['instagram'] .'"
			pinterest="'. $settings['pinterest'] .'"
			linkedin="'. $settings['linkedin'] .'"
			tumblr="'. $settings['tumblr'] .'"
			youtube="'. $settings['youtube'] .'"
			telegram="'. $settings['telegram'] .'"
			whatsapp="'. $settings['whatsapp'] .'"
			vimeo="'. $settings['vimeo'] .'"
			rss="'. $settings['rss'] .'"
			vk="'. $settings['vk'] .'"
			houzz="'. $settings['houzz'] .'"
			tripadvisor="'. $settings['tripadvisor'] .'"
			target="'. $settings['target'] .'"
			size="'. $settings['size'] .'"
			align="'. $settings['align'] .'"
			filled="'. $settings['filled'] .'"
			icons_color="'. $settings['icons_color'] .'"
			icons_color_hover="'. $settings['icons_color_hover'] .'"
			icons_bg="'. $settings['icons_bg'] .'"
			icons_bg_hover="'. $settings['icons_bg_hover'] .'"
			is_preview="'. ( \Elementor\Plugin::$instance->editor->is_edit_mode() ? true : false ) .'"]' 
		);

	}

}
