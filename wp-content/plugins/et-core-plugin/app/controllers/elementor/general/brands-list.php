<?php
namespace ETC\App\Controllers\Elementor\General;

use ETC\App\Traits\Elementor;

/**
 * Brands List widget.
 *
 * @since      2.1.3
 * @package    ETC
 * @subpackage ETC/Controllers/Elementor
 */
class Brands_List extends \Elementor\Widget_Base {

	use Elementor;

	/**
	 * Get widget name.
	 *
	 * @since 2.1.3
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'etheme_brands_list';
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
		return __( 'Brands List', 'xstore-core' );
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
		return 'eicon-product-title eight_theme-element-icon';
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
		return [ 'brands-list', 'brands' ];
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
	 * Register Brands List widget controls.
	 *
	 * @since 2.1.3
	 * @access protected
	 */
	protected function _register_controls() {
		$this->start_controls_section(
			'settings',
			[
				'label' => __( 'Brand list Settings', 'xstore-core' ),
				'tab' 	=> \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'ids',
			[
				'label' 	=>	__( 'Select Brand', 'xstore-core' ),
				'type' 		=>	\Elementor\Controls_Manager::SELECT2,
				'multiple' 	=>	true,
				'options' 	=>	Elementor::get_terms('brand'),
				'label_block'	=> 'true',
			]
		);

		$this->add_control(
			'hide_a_z',
			[
				'label' => __( 'Display A-Z filter', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'description' => __( 'Do not forget switch on Customize -> Speed Optimization -> Masonry Scripts', 'xstore-core' ),
				'label_on' => __( 'Yes', 'xstore-core' ),
				'label_off' => __( 'No', 'xstore-core' ),
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'columns',
			[
				'label' 	=> __( 'Columns', 'xstore-core' ),
				'type' 		=> \Elementor\Controls_Manager::SELECT,
				'default' 	=> '',
				'options' 	=> [
					'1' => esc_attr__( '1', 'xstore-core' ),
					'2' => esc_attr__( '2', 'xstore-core' ),
					'3' => esc_attr__( '3', 'xstore-core' ),
					'4' => esc_attr__( '4', 'xstore-core' ),
					'5' => esc_attr__( '5', 'xstore-core' ),
					'6' => esc_attr__( '6', 'xstore-core' ),
				],
			]
		);

		$this->add_control(
			'alignment',
			[
				'label' 	 => __( 'Alignment', 'xstore-core' ),
				'type' 		 => \Elementor\Controls_Manager::SELECT,
				'options' 	 => [
					'left' 	 => esc_html__('Left', 'xstore-core') , 
					'center' => esc_html__('Center', 'xstore-core') , 
					'right'	 => esc_html__('Right', 'xstore-core') 
				],
				'default'	 => 'left'
			]
		);

		$this->add_control(
			'capital_letter',
			[
				'label' => __( 'Display brands capital letter', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'xstore-core' ),
				'label_off' => __( 'No', 'xstore-core' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_control(
			'brand_image',
			[
				'label' => __( 'Brand image', 'xstore-core' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'xstore-core' ),
				'label_off' => __( 'No', 'xstore-core' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_control(
			'size',
			[
				'label' 	=>	__( 'Images size', 'xstore-core' ),
				'type' 		=>	\Elementor\Controls_Manager::TEXT,
				'condition' => ['brand_image' => 'yes'],
				'default' 	=>	'',
			]
		);

		$this->add_control(
			'brand_title',
			[
				'label' 		=> __( 'Brand title', 'xstore-core' ),
				'type'			=> \Elementor\Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'Yes', 'xstore-core' ),
				'label_off' 	=> __( 'No', 'xstore-core' ),
				'return_value' 	=> 'yes',
				'default' 		=> 'yes',
			]
		);

		$this->add_control(
			'tooltip',
			[
				'label' 		=> __( 'Title with tooltip', 'xstore-core' ),
				'type'			=> \Elementor\Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'Yes', 'xstore-core' ),
				'label_off' 	=> __( 'No', 'xstore-core' ),
				'return_value' 	=> 'yes',
				'default' 		=> '',
			]
		);

		$this->add_control(
			'brand_desc',
			[
				'label' 		=> __( 'Brand description', 'xstore-core' ),
				'type'			=> \Elementor\Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'Yes', 'xstore-core' ),
				'label_off' 	=> __( 'No', 'xstore-core' ),
				'return_value' 	=> 'yes',
				'default' 		=> '',
			]
		);

		$this->add_control(
			'hide_empty',
			[
				'label' 		=> __( 'Hide empty', 'xstore-core' ),
				'type'			=> \Elementor\Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'Yes', 'xstore-core' ),
				'label_off' 	=> __( 'No', 'xstore-core' ),
				'return_value' 	=> 'yes',
				'default' 		=> '',
			]
		);

		$this->add_control(
			'show_product_counts',
			[
				'label' 		=> __( 'Show Product Counts', 'xstore-core' ),
				'type'			=> \Elementor\Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'Yes', 'xstore-core' ),
				'label_off' 	=> __( 'No', 'xstore-core' ),
				'return_value' 	=> 'yes',
				'default' 		=> '',
			]
		);

		$this->add_control(
			'class',
			[
				'label' 	=>	__( 'Extra Class', 'xstore-core' ),
				'type' 		=>	\Elementor\Controls_Manager::TEXT,
			]
		);

		$this->end_controls_section();

	}

	/**
	 * Render brands list widget output on the frontend.
	 *
	 * @since 2.1.3
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$settings['ids']	=	!empty( $settings['ids'] ) ? implode( ',', $settings['ids'] ) : '';

		echo do_shortcode( '[etheme_brands_list 
			ids="'. $settings['ids'] .'"
			hide_a_z="'. $settings['hide_a_z'] .'"
			columns="'. $settings['columns'] .'"
			alignment="'. $settings['alignment'] .'"
			capital_letter="'. $settings['capital_letter'] .'"
			brand_image="'. $settings['brand_image'] .'"
			size="'. $settings['size'] .'"
			brand_title="'. $settings['brand_title'] .'"
			tooltip="'. $settings['tooltip'] .'"
			brand_desc="'. $settings['brand_desc'] .'"
			hide_empty="'. $settings['hide_empty'] .'"
			show_product_counts="'. $settings['show_product_counts'] .'"
			class="'. $settings['class'] .'"
			is_preview="'. ( \Elementor\Plugin::$instance->editor->is_edit_mode() ? true : false ) .'"]' 
		);
	}

}
