<?php
namespace ETC\App\Controllers\Elementor\General;

use ETC\App\Traits\Elementor;
use ETC\App\Controllers\Shortcodes\Slider as ShortcodeSlider;

/**
 * Slider widget.
 *
 * @since      2.1.3
 * @package    ETC
 * @subpackage ETC/Controllers/Elementor
 */
class Slider extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * @since 2.1.3
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'etheme_slider';
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
		return __( 'Slider', 'xstore-core' );
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
		return 'eight_theme-elementor-icon et-elementor-slider';
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
		return [ 'slider', 'slider-item' ];
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
	 * Register Slider widget controls.
	 *
	 * @since 2.1.3
	 * @access protected
	 */
	protected function _register_controls() {

		$this->start_controls_section(
			'item_settings',
			[
				'label' => __( 'Slides', 'xstore-core' ),
				'tab' 	=> \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new \Elementor\Repeater();

		Elementor::get_slider_item( $repeater );

		$this->add_control(
			'get_slider_item',
			[
				'label' => __( 'Slider Item', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'title' => __( 'Slide 1 Heading', 'xstore-core' ),
						'subtitle' => __( 'Slide 1 Subtitle', 'xstore-core' ),
						'content' => __( 'Lorem ipsum dolor sit amet consectetur adipiscing elit dolor.', 'xstore-core' ),
						'button_title' => __( 'Click here', 'xstore-core' )
					],
					[
						'title' => __( 'Slide 2 Heading', 'xstore-core' ),
						'subtitle' => __( 'Slide 2 Subtitle', 'xstore-core' ),
						'content' => __( 'Lorem ipsum dolor sit amet consectetur adipiscing elit dolor.', 'xstore-core' ),
						'button_title' => __( 'Click here', 'xstore-core' )
					],
					[
						'title' => __( 'Slide 3 Heading', 'xstore-core' ),
						'subtitle' => __( 'Slide 3 Subtitle', 'xstore-core' ),
						'content' => __( 'Lorem ipsum dolor sit amet consectetur adipiscing elit dolor.', 'xstore-core' ),
						'button_title' => __( 'Click here', 'xstore-core' )
					],
				],
				'title_field' => '{{{ title }}}',
				'show_label' => true,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'settings',
			[
				'label' => __( 'General Settings', 'xstore-core' ),
				'tab' 	=> \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'height',
			[
				'label' 		=>	__( 'Height', 'xstore-core' ),
				'type' 			=>	\Elementor\Controls_Manager::SELECT,
				'options' 		=>	[
					'full'		=>	esc_html__('Full height', 'xstore-core'),
					'custom'	=>	esc_html__('Custom height', 'xstore-core'),
					'auto'		=>	esc_html__('Height of content', 'xstore-core'),
				],
				'default'		=> 'custom',
			]
		);

		$this->add_responsive_control(
			'height_value',
			[
				'label' => __( 'Custom height value', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%', 'vw', 'vh' ],
				'default' => [
					'unit' => 'px',
					'size' => 580,
				],
				// 'devices' => [ self::RESPONSIVE_DESKTOP, self::RESPONSIVE_MOBILE ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1200,
					],
					'em' => [
						'min' => 0,
						'max' => 100,
					],
					'%' => [
						'min' => 0,
						'max' => 200,
					],
					'vh' => [
						'min' => 0,
						'max' => 150,
					],
					'vw' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'condition' => ['height' => 'custom'],
				'selectors'    => [
					'{{WRAPPER}} .et-slider' => 'height: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_control(
			'nav',
			[
				'label' 		=>	__( 'Navigation', 'xstore-core' ),
				'type' 			=>	\Elementor\Controls_Manager::SELECT,
				'options' 		=>	[
					'arrows_bullets'	=>	esc_html__('Arrows + Bullets', 'xstore-core'),
					'arrows'			=>	esc_html__('Arrows', 'xstore-core'),
					'bullets'			=>	esc_html__('Bullets', 'xstore-core'), 
					'disable'			=>	esc_html__('Disable', 'xstore-core')           
				],
				'default'		=> 'arrows_bullets',
			]
		);

		$this->add_control(
			'slider_autoplay',
			[
				'label' 		=>	__( 'Slider autoplay', 'xstore-core' ),
				'type' 			=>	\Elementor\Controls_Manager::SWITCHER,
				'label_on' 		=>	__( 'Hide', 'xstore-core' ),
				'label_off' 	=>	__( 'Show', 'xstore-core' ),
				'return_value'  =>	'yes',
				'default' 		=>	'',
			]
		);

		$this->add_control(
			'slider_loop',
			[
				'label' 		=>	__( 'Slider loop', 'xstore-core' ),
				'type' 			=>	\Elementor\Controls_Manager::SWITCHER,
				'label_on' 		=>	__( 'Hide', 'xstore-core' ),
				'label_off' 	=>	__( 'Show', 'xstore-core' ),
				'return_value'  =>	'yes',
				'default' 		=>	'yes',
			]
		);

		$this->add_control(
			'slider_interval',
			[
				'label' => __( 'Interval', 'xstore-core' ),
				'type' 	=> \Elementor\Controls_Manager::TEXT,
				'description' => esc_html__( 'Interval between slides.', 'xstore-core' ),
				'condition' => ['slider_autoplay' => 'yes'],
				'default' => 5000
			]
		);

		$this->add_control(
			'transition_effect',
			[
				'label' 		=>	__( 'Transition style', 'xstore-core' ),
				'type' 			=>	\Elementor\Controls_Manager::SELECT,
				'options' 		=>	[
					'slide'		=>	esc_html__('Slide', 'xstore-core'),
					'fade'		=>	esc_html__('Fade', 'xstore-core'),
					'cube'		=>	esc_html__('Cube', 'xstore-core'),
					'coverflow'	=>	esc_html__('Coverflow', 'xstore-core'),
					'flip'		=>	esc_html__('Flip', 'xstore-core'),
				],
				'default' => 'slide'
			]
		);

		$this->add_control(
			'slider_speed',
			[
				'label' => __( 'Transition speed', 'xstore-core' ),
				'type' 	=> \Elementor\Controls_Manager::NUMBER,
				'description' => esc_html__( 'Duration of transition between slides.', 'xstore-core' ),
				'default' 		=> 300,
			]
		);

		$this->add_control(
			'bg_color',
			[
				'label' 	=> __( 'Slider Background color', 'xstore-core' ),
				'type' 		=> \Elementor\Controls_Manager::COLOR,
				'description' 	=> __( 'Apply for slider and loader background colors', 'xstore-core' ),
				'scheme' 	=> [
					'type' 	=> \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_1,
				],
			]
		);

		$this->add_control(
			'el_class',
			[
				'label' => __( 'CSS Classes', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'navigation_style',
			[
				'label' => __( 'Navigation', 'xstore-core' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
	        'arrows_divider_style',
	        [
	          'label' => __( 'Arrows', 'xstore-core' ),
	          'type' => \Elementor\Controls_Manager::HEADING,
	        ]
	    );

		$this->add_control(
			'nav_on_hover',
			[
				'label' 		=>	__( 'Show navigation on hover', 'xstore-core' ),
				'type' 			=>	\Elementor\Controls_Manager::SWITCHER,
				'return_value'  =>	'true',
				'default' 		=>	'',
				'conditions' 	=> [
					'terms' 	=> [
						[
							'name' 		=> 'nav',
							'operator'  => '!=',
							'value' 	=> 'disable'
						]
					]
				]
			]
		);

		$this->add_control(
			'nav_color',
			[
				'label' 	=> __( 'Arrows color', 'xstore-core' ),
				'type' 		=> \Elementor\Controls_Manager::COLOR,
				'scheme' 	=> [
					'type' 	=> \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_1,
				],
				'default' 	=> '#222',
				'conditions' 	=> [
					'terms' 	=> [
						[
							'name' 		=> 'nav',
							'operator'  => '!=',
							'value' 	=> 'disable'
						]
					]
				]
			]
		);

		$this->add_control(
			'arrows_bg_color',
			[
				'label' 	=> __( 'Arrows background color', 'xstore-core' ),
				'type' 		=> \Elementor\Controls_Manager::COLOR,
				'scheme' 	=> [
					'type' 	=> \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_1,
				],
				'default' 	=> '#e1e1e1',
				'conditions' 	=> [
					'terms' 	=> [
						[
							'name' 		=> 'nav',
							'operator'  => '!=',
							'value' 	=> 'disable'
						]
					]
				]
			]
		);

	    $this->add_control(
	        'bullets_divider_style',
	        [
	          'label' => __( 'Bullets', 'xstore-core' ),
	          'type' => \Elementor\Controls_Manager::HEADING,
	          'separator' => 'before',
	        ]
	     );

		$this->add_control(
			'default_color',
			[
				'label' 	=> __( 'Bullets default color', 'xstore-core' ),
				'type' 		=> \Elementor\Controls_Manager::COLOR,
				'scheme' 	=> [
					'type' 	=> \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_1,
				],
				'default' 	=> '',
			]
		);

		$this->add_control(
			'active_color',
			[
				'label' 	=> __( 'Bullets active/hover color', 'xstore-core' ),
				'type' 		=> \Elementor\Controls_Manager::COLOR,
				'scheme' 	=> [
					'type'  => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_1,
				],
				'default' 	=> '',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render Slider widget output on the frontend.
	 *
	 * @since 2.1.3
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$atts = array();
		foreach ( $settings as $key => $setting ) {
			if ( '_' == substr( $key, 0, 1) ) {
				continue;
			}

			if ( in_array($key, array('height_value', 'height_value_tablet', 'height_value_mobile') ) ) 
				// $atts[$key] = $setting['size'].$setting['unit'];
				continue;

			if ( $setting ) {
				$atts[$key] = $setting;
			}
		}

		$content = '';
		if ( $settings['get_slider_item'] ) {
			foreach (  $settings['get_slider_item'] as $item ) {

				$item['button_link']['title'] = $item['button_title'];

				$local_settings['build_button_link'] = array(
					'keys' => array(),
					'values' => array()
				);

				// not working in item anyway 
				$item['button_link']['custom_attributes'] = '';

				foreach ($item['button_link'] as $key => $value) {
					$local_settings['build_button_link']['keys'][] = $key;
					$local_settings['build_button_link']['values'][] = ( !empty($value) ? $value : '' );
				}

			   $item['button_link'] = implode(',', $local_settings['build_button_link']['keys']) . 
			   '|'
			    . implode(',', $local_settings['build_button_link']['values']);

			    $item['bg_img'] = isset( $item['bg_img']['id'] ) ? $item['bg_img']['id'] : '';

			    $item['el_class'] .= ' elementor-repeater-item-' . $item['_id'];

				$content .= '[etheme_slider_item title="'. $item['title'] .'" title_class="'. $item['title_class'] .' animated" use_custom_fonts_title="true" subtitle_class="'. $item['subtitle_class'] .' animated" use_custom_fonts_subtitle="true" subtitle="'. $item['subtitle'] .'" subtitle_above="'. $item['subtitle_above'] .'" description_class="animated" align="'. $item['align'] .'" v_align="'. $item['v_align'] .'" content_width="'. $item['content_width']['size'] .'" el_class="'. $item['el_class'] .'" bg_overlay="'. $item['bg_overlay'] .'" button_link="'. $item['button_link'] .'" link="'. $item['link'] .'" button_color="'. $item['button_color'] .'" button_hover_color="'. $item['button_hover_color'] .'" button_bg="'. $item['button_bg'] .'" button_hover_bg="'. $item['button_hover_bg'] .'"  button_class="animated" content_bg_position="" is_preview="'. ( \Elementor\Plugin::$instance->editor->is_edit_mode() ? true : false ) .'" is_elementor="true"]'. $item['content'] .'[/etheme_slider_item]';
			}
		}

		$slider =  ShortcodeSlider::get_instance();
		echo $slider->slider_shortcode( $atts, $content);

	}

}
