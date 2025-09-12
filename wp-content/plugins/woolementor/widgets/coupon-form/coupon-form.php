<?php
namespace codexpert\Woolementor;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use codexpert\Woolementor\Controls\Group_Control_Gradient_Text;

class Coupon_Form extends Widget_Base {

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

		/**
		 * Settings controls
		 */
		$this->start_controls_section(
			'coupon_section_settings',
			[
				'label' 		=> __( 'General', 'woolementor' ),
				'tab'   		=> Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'coupon_placeholder_text',
			[
				'label' 		=> __( 'Placeholder Text', 'woolementor' ),
				'type' 			=> Controls_Manager::TEXT,
				'default' 		=> __( 'Coupon Code', 'woolementor' ),
				'placeholder' 	=> __( 'Type your title here', 'woolementor' ),
			]
		);

		$this->add_control(
			'coupon_button_text',
			[
				'label' 		=> __( 'Button Text', 'woolementor' ),
				'type' 			=> Controls_Manager::TEXT,
				'default' 		=> __( 'Apply', 'woolementor' ),
				'placeholder' 	=> __( 'Type your title here', 'woolementor' ),
			]
		);

		$this->add_control(
			'coupon_Alignment',
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
					'flex-end' 		=> [
						'title' 	=> __( 'Right', 'woolementor' ),
						'icon' 		=> 'fa fa-align-right',
					],
				],
				'default' 		=> 'center',
				'toggle' 		=> true,
				'selectors' 	=> [
					'{{WRAPPER}} .wl-cf-apply-coupon' => 'justify-content: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

		/**
		 * Coupon Input Field
		 */
		$this->start_controls_section(
			'coupon_input_field',
			[
				'label'			=> __( 'Input Field', 'woolementor' ),
				'tab'   		=> Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'coupon_input_width',
			[
				'label' 	=> __( 'Input Size', 'woolementor' ),
				'type' 		=> Controls_Manager::SLIDER,
				'size_units'=> [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .wl-cf-apply-coupon-fields' => 'width: {{SIZE}}{{UNIT}}',
				],
				'range' 	=> [
					'px' 	=> [
						'min' 	=> 100,
						'max' 	=> 1000
					],
					'em' 	=> [
						'min' 	=> 10,
						'max' 	=> 50
					],
				],
			]
		);

		$this->add_control(
			'coupon_input_color',
			[
				'label' 		=> __( 'Text Color', 'woolementor' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} input.wl-cf-apply-coupon-input' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'coupon_input_bg',
			[
				'label' 		=> __( 'Background Color', 'woolementor' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} input.wl-cf-apply-coupon-input' => 'background-color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 			=> 'coupon_input_typography',
				'label' 		=> __( 'Typography', 'woolementor' ),
				'scheme' 		=> Typography::TYPOGRAPHY_1,
				'selector' 		=> '{{WRAPPER}} input.wl-cf-apply-coupon-input',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'coupon_input_field_border',
				'label'         => __( 'Border', 'woolementor' ),
				'selector'      => '{{WRAPPER}} input.wl-cf-apply-coupon-input',
				'separator'		=> 'before'
			]
		);

		$this->add_responsive_control(
			'coupon_input_field_border_radius',
			[
				'label'         => __( 'Border Radius', 'woolementor' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', '%', 'em' ],
				'selectors'     => [
					'{{WRAPPER}} input.wl-cf-apply-coupon-input' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default'       => [
					'top'           => '20',
					'right'         => '20',
					'bottom'        => '20',
					'left'          => '20',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' 			=> 'coupon_input_field_box_shadow',
				'label' 		=> __( 'Box Shadow', 'woolementor' ),
				'selector' 		=> '{{WRAPPER}} input.wl-cf-apply-coupon-input',
			]
		);

		$this->add_responsive_control(
			'coupon_input_field_padding',
			[
				'label' 		=> __( 'Padding', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} input.wl-cf-apply-coupon-input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'		=> 'before'
			]
		);

		$this->add_responsive_control(
			'coupon_input_field_margin',
			[
				'label' 		=> __( 'Margin', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} input.wl-cf-apply-coupon-input' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/**
		 * Coupon Button
		 */
		$this->start_controls_section(
			'coupon_button',
			[
				'label'			=> __( 'Apply Button', 'woolementor' ),
				'tab'   		=> Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'coupon_button_color',
			[
				'label'     => __( 'Text Color', 'woolementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-cf-apply-coupon-button.button' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'coupon_button_typography',
				'label' 	=> __( 'Typography', 'woolementor' ),
				'scheme' 	=> Typography::TYPOGRAPHY_1,
				'selector' 	=> '{{WRAPPER}} .wl-cf-apply-coupon-button.button',
			]
		);

		$this->add_control(
			'coupon_button_bg',
			[
				'label'     => __( 'Background', 'woolementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-cf-apply-coupon-button.button' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'coupon_button_border',
				'label'         => __( 'Border', 'woolementor' ),
				'selector'      => '{{WRAPPER}} .wl-cf-apply-coupon-button.button',
				'separator'		=> 'before'
			]
		);

		$this->add_responsive_control(
			'coupon_button_border_radius',
			[
				'label'         => __( 'Border Radius', 'woolementor' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', '%' ],
				'selectors'     => [
					'{{WRAPPER}} .wl-cf-apply-coupon-button.button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default'       => [
					'top'           => '0',
					'right'         => '20',
					'bottom'        => '20',
					'left'          => '0',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' 			=> 'coupon_button_box_shadow',
				'label' 		=> __( 'Box Shadow', 'woolementor' ),
				'selector' 		=> '{{WRAPPER}} .wl-cf-apply-coupon-button.button',
			]
		);

		$this->add_responsive_control(
			'coupon_button_padding',
			[
				'label' 		=> __( 'Padding', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .wl-cf-apply-coupon-button.button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'		=> 'before'
			]
		);

		$this->add_responsive_control(
			'coupon_button_margin',
			[
				'label' 		=> __( 'Margin', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .wl-cf-apply-coupon-button.button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {

		$settings 	= $this->get_settings_for_display();
		extract( $settings );

		$this->render_editing_attributes();
		?>

		<div class="cx-row">
			<div class="cx-col-md-12 cx-col-sm-12">
				<form class="checkout_coupon woocommerce-form-coupon" method="post" style="">
					<div class="wl-cf-apply-coupon">
						<div class="wl-cf-apply-coupon-fields">
							<input type="text" name="coupon_code" class="wl-cf-apply-coupon-input input-text" placeholder="<?php echo esc_attr( $coupon_placeholder_text ); ?>" id="coupon_code" value="">

							<?php 
							printf( '<button %1$s type="submit" name="apply_coupon" value="%2$s">%2$s</button>',
								$this->get_render_attribute_string( 'coupon_button_text' ),
								esc_html( $coupon_button_text )
							);
							?>
							
						</div>
					</div>
					<div class="clear"></div>
				</form>
			</div>
		</div>

		<?php
	}

	private function render_editing_attributes() {
		$this->add_inline_editing_attributes( 'coupon_button_text', 'none' );
		$this->add_render_attribute( 'coupon_button_text', 'class', 'wl-cf-apply-coupon-button button' );
	}
}