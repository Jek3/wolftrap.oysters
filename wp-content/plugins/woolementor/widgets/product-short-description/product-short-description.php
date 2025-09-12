<?php
namespace codexpert\Woolementor;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use codexpert\Woolementor\Controls\Group_Control_Gradient_Text;

class Product_Short_Description extends Widget_Base {

	public $id;

	public function __construct( $data = [], $args = null ) {
	    parent::__construct( $data, $args );

	    $this->id = woolementor_get_widget_id( __CLASS__ );
	    $this->widget = woolementor_get_widget( $this->id );
	    
		// Are we in debug mode?
		$min = defined( 'WOOLEMENTOR_DEBUG' ) && WOOLEMENTOR_DEBUG ? '' : '.min';

		wp_register_style( "woolementor-{$this->id}", plugins_url( "assets/css/style{$min}.css", __FILE__ ), [], '1.1' );
	}

	public function get_script_depends() {
		return [ "woolementor-{$this->id}" ];
	}

	public function get_style_depends() {
		return [ "woolementor-{$this->id}" ];
	}

	public function get_name() {
		return $this->id;
	}

	public function get_title() {
		return $this->widget['title'];
	}

	public function get_icon() {
		return $this->widget['icon'];
	}

	public function get_categories() {
		return $this->widget['categories'];
	}

	protected function _register_controls() {

		// global $post;

		/**
		 * Settings controls
		 */
		$this->start_controls_section(
			'pd_settings',
			[
				'label' 		=> __( 'General', 'woolementor' ),
				'tab'   		=> Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'product_description_type',
			[
				'label' 		=> __( 'Content Source', 'woolementor' ),
				'type' 			=> Controls_Manager::SELECT2,
				'options' 		=> [
					'default_description'  	=> __( 'Current Product', 'woolementor' ),
					'custom_description' 	=> __( 'Custom', 'woolementor' ),
				],
				'default' 		=> 'default_description' ,
				'label_block' 	=> true,
			]
		);

		$this->add_control(
			'pd_product_description',
			[
				'label' 	=> __( 'Custom Description', 'woolementor' ),
				'type' 		=> Controls_Manager::TEXTAREA,
				'rows' 		=> 10,
				'default' 	=> __( 'Type your description here', 'woolementor' ),
				'condition' => [
                    'product_description_type' => 'custom_description'
                ],
			]
		);

		$this->add_control(
			'pd_alignment',
			[
				'label' 		=> __( 'Alignment', 'woolementor' ),
				'type' 			=> Controls_Manager::CHOOSE,
				'options' 		=> [
					'start' 		=> [
						'title' 	=> __( 'Left', 'woolementor' ),
						'icon'	 	=> 'fa fa-align-left',
					],
					'center' 	=> [
						'title' 	=> __( 'Center', 'woolementor' ),
						'icon' 		=> 'fa fa-align-center',
					],
					'justify' 	=> [
						'title' 	=> __( 'Justify', 'woolementor' ),
						'icon' 		=> 'fa fa-align-justify',
					],
					'right' 	=> [
						'title' 	=> __( 'Right', 'woolementor' ),
						'icon' 		=> 'fa fa-align-right',
					],
				],
				'default' => 'justify',
				'toggle' => true,
				'selectors' => [
					'{{WRAPPER}} .wl-product-description' => 'text-align: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

		/**
		 * Descriptio style Section
		 */
		$this->start_controls_section(
			'pd_style',
			[
				'label'			=> __( 'Design', 'woolementor' ),
				'tab'   		=> Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
            Group_Control_Gradient_Text::get_type(),
            [
                'name' => 'pd_title_gradient_color',
                'selector' => '{{WRAPPER}} .wl-product-description p',
            ]
        );

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'pd_typography',
				'label' => __( 'Typography', 'woolementor' ),
				'scheme' => Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .wl-product-description p',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'pd_border',
				'label'         => __( 'Border', 'woolementor' ),
				'selector'      => '{{WRAPPER}} .wl-product-description p',
				'separator'		=> 'before'
			]
		);

		$this->add_responsive_control(
			'pd_border_radius',
			[
				'label'         => __( 'Border Radius', 'woolementor' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', '%', 'em' ],
				'selectors'     => [
					'{{WRAPPER}} .wl-product-description p' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'pd_box_shadow',
				'label' => __( 'Box Shadow', 'woolementor' ),
				'selector' => '{{WRAPPER}} .wl-product-description p',
			]
		);

		$this->add_responsive_control(
			'pd_field_padding',
			[
				'label' 		=> __( 'Padding', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .wl-product-description p' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'		=> 'before',
			]
		);

		$this->add_responsive_control(
			'pd_margin',
			[
				'label' 		=> __( 'Margin', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .wl-product-description p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

	}

	protected function render() {

		$settings 	= $this->get_settings_for_display();
		extract( $settings );

		$this->add_inline_editing_attributes( 'pd_product_description', 'basic' );

		$the_excerpt = get_the_excerpt();
		if ( woolementor_is_edit_mode() || woolementor_is_preview_mode() ) {
			$product_id = woolementor_get_product_id();
			$product = wc_get_product( $product_id );
			$the_excerpt = $product->get_short_description();
		}
		?>

		<div class="wl-product-description">

			<?php 
			if ( 'default_description' == $product_description_type ) {
				printf( '<p>%s</p>',
		            $the_excerpt
		        );
			}
			else {
				printf( '<p %s>%s</p>',
		            $this->get_render_attribute_string( 'pd_product_description' ),
		            esc_html( $pd_product_description ) 
		        );
			}
			?>
		</div>

		<?php
	}
}