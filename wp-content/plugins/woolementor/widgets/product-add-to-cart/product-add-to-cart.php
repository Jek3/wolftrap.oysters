<?php
namespace codexpert\Woolementor;

use Elementor\Repeater;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;

class Product_Add_To_Cart extends Widget_Base {

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
		return [ 'fancybox' ];
	}

	public function get_style_depends() {
		return [ "woolementor-{$this->id}", 'fancybox' ];
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
		 * Repeater Tabs
		 */
		$this->start_controls_section(
			'add_to_cart_section',
			[
				'label' 		=> __( 'Add to Cart', 'plugin-name' ),
				'tab' 			=> Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'add_to_cart_text',
			[
				'label' 		=> __( 'Button Text', 'woolementor' ),
				'type' 			=> Controls_Manager::TEXT,
				'default' 		=> __( 'Add to Cart', 'woolementor' ),
				'placeholder' 	=> __( 'Type your title here', 'woolementor' ),
			]
		);

		$this->add_control(
			'_product_type',
			[
				'label' 		=> __( 'Product Type', 'woolementor' ),
				'type' 			=> Controls_Manager::HIDDEN,
				'show_external' => false,
				'default' 		=> $this->woolementor_get_product_type(),
			]
		);

		$this->end_controls_section();

		/**
		 * add to cart button
		 */
		$this->start_controls_section(
			'add_to_cart_style',
			[
				'label' => __( 'Button', 'woolementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'add_to_cart_typographyrs',
				'label' 	=> __( 'Typography', 'woolementor' ),
				'scheme' 	=> Typography::TYPOGRAPHY_3,
				'selector' 	=> '{{WRAPPER}} .wl-atc-button-area .single_add_to_cart_button.button',
			]
		);

		$this->add_responsive_control(
			'add_to_cart_padding',
			[
				'label' 		=> __( 'Padding', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .wl-atc-button-area .single_add_to_cart_button.button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'		=> 'before',
			]
		);

		$this->add_responsive_control(
			'add_to_cart_margin',
			[
				'label' 		=> __( 'Margin', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .wl-atc-button-area .single_add_to_cart_button.button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'add_to_cart_border_radius',
			[
				'label'         => __( 'Border Radius', 'woolementor' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', '%', 'em' ],
				'selectors'     => [
					'{{WRAPPER}} .wl-atc-button-area .single_add_to_cart_button.button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'		=> 'before'
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'add_to_cart_box_shadow',
				'label' => __( 'Box Shadow', 'woolementor' ),
				'selector' => '{{WRAPPER}} .wl-atc-button-area .single_add_to_cart_button.button',
			]
		);

		$this->start_controls_tabs(
			'add_to_cart_button',
			[
				'separator' => 'before'
			]
		);

		$this->start_controls_tab( 
			'add_to_cart_normal',
			[
				'label' 	=> __( 'Normal', 'woolementor' ),
			]
		);

        $this->add_control(
			'add_to_cart_color',
			[
				'label' 	=> __( 'Text Color', 'woolementor' ),
				'type' 		=> Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-atc-button-area .single_add_to_cart_button.button' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'add_to_cart_bg',
				'label' => __( 'Background', 'woolementor' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .wl-atc-button-area .single_add_to_cart_button.button',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'add_to_cart_border',
				'label'         => __( 'Border', 'woolementor' ),
				'selector'      => '{{WRAPPER}} .wl-atc-button-area .single_add_to_cart_button.button',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'add_to_cart_hover',
			[
				'label' 	=> __( 'Hover', 'woolementor' ),
			]
		);

        $this->add_control(
			'add_to_cart_hover_color',
			[
				'label' 	=> __( 'Text Color', 'woolementor' ),
				'type' 		=> Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-atc-button-area .single_add_to_cart_button.button:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'add_to_cart_hover_bg',
				'label' => __( 'Background', 'woolementor' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .wl-atc-button-area .single_add_to_cart_button.button:hover',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'add_to_cart_border_hover',
				'label'         => __( 'Border', 'woolementor' ),
				'selector'      => '{{WRAPPER}} .wl-atc-button-area .single_add_to_cart_button.button:hover',
			]
		);

		$this->add_control(
			'add_to_cart_hover_transition',
			[
				'label' 	=> __( 'Transition Duration', 'woolementor' ),
				'type' 		=> Controls_Manager::SLIDER,
				'range' 	=> [
					'px' 	=> [
						'max' 	=> 3,
						'step' 	=> 0.1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wl-atc-button-area .single_add_to_cart_button.button:hover' => 'transition-duration: {{SIZE}}s',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		/**
		 * quantity Input
		 */
		$this->start_controls_section(
			'qty_input',
			[
				'label' => __( 'Quantity Input', 'woolementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'conditions' => [
					'relation' => 'or',
					'terms' => [
						[
							'name' => '_product_type',
							'operator' => '!=',
							'value' => 'external',
						],
					],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'qty_input_typographyrs',
				'label' 	=> __( 'Typography', 'woolementor' ),
				'scheme' 	=> Typography::TYPOGRAPHY_3,
				'selector' 	=> '{{WRAPPER}} .wl-atc-button-area .quantity input',
			]
		);

		$this->add_control(
			'qty_input_align',
			[
				'label' 		=> __( 'Alignment', 'woolementor' ),
				'type' 			=> Controls_Manager::CHOOSE,
				'options' 		=> [
					'left' => [
						'title' => __( 'Left', 'woolementor' ),
						'icon' 	=> 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'woolementor' ),
						'icon' 	=> 'fa fa-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'woolementor' ),
						'icon' 	=> 'fa fa-align-right',
					],
				],
				'default' 		=> 'center',
				'toggle' 		=> true,
				'selectors' => [
					'{{WRAPPER}} .wl-atc-button-area .quantity input' => 'text-align: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'qty_input_width',
			[
				'label' 	=> __( 'Width', 'woolementor' ),
				'type' 		=> Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 110,
				],
				'selectors' => [
					'{{WRAPPER}} .wl-atc-button-area .quantity input' => 'width: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'qty_input_border',
				'label'         => __( 'Border', 'woolementor' ),
				'selector'      => '{{WRAPPER}} .wl-atc-button-area .quantity input',
			]
		);

		$this->add_responsive_control(
			'qty_input_border_radius',
			[
				'label'         => __( 'Border Radius', 'woolementor' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', '%', 'em' ],
				'selectors'     => [
					'{{WRAPPER}} .wl-atc-button-area .quantity input' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'qty_input_margin',
			[
				'label'         => __( 'Margin', 'woolementor' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', '%', 'em' ],
				'selectors'     => [
					'{{WRAPPER}} .wl-atc-button-area .quantity input' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'		=> 'before'
			]
		);

		$this->add_responsive_control(
			'qty_input_padding',
			[
				'label'         => __( 'Padding', 'woolementor' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', '%', 'em' ],
				'selectors'     => [
					'{{WRAPPER}} .wl-atc-button-area .quantity input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/**
		 * Table Design
		 */
		$this->start_controls_section(
			'table_design',
			[
				'label' => __( 'Table Design', 'woolementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'conditions' => [
					'relation' => 'or',
					'terms' => [
						[
							'name' => '_product_type',
							'operator' => '==',
							'value' => 'variable',
						],
						[
							'name' => '_product_type',
							'operator' => '==',
							'value' => 'grouped',
						],
					],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'table_border',
				'label'         => __( 'Border', 'woolementor' ),
				'selector'      => '{{WRAPPER}} .wl-atc-button-area table',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'table_background',
				'label' => __( 'Background', 'woolementor' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .wl-atc-button-area table',
			]
		);

		$this->end_controls_section();

		/**
		 * Table row Design
		 */
		$this->start_controls_section(
			'table_row_design',
			[
				'label' => __( 'Table Row Design', 'woolementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'conditions' => [
					'relation' => 'or',
					'terms' => [
						[
							'name' => '_product_type',
							'operator' => '==',
							'value' => 'variable',
						],
						[
							'name' => '_product_type',
							'operator' => '==',
							'value' => 'grouped',
						],
					],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'table_content',
				'label' => __( 'Typography', 'woolementor' ),
				'scheme' => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .wl-atc-button-area table tr td',
			]
		);

		$this->add_control(
			'table_content_align',
			[
				'label' 		=> __( 'Vertical Alignment', 'woolementor' ),
				'type' 			=> Controls_Manager::CHOOSE,
				'options' 		=> [
					'top' => [
						'title' => __( 'Top', 'woolementor' ),
						'icon' 	=> 'eicon-v-align-top',
					],
					'middle' => [
						'title' => __( 'Middle', 'woolementor' ),
						'icon' 	=> 'eicon-v-align-middle',
					],
					'bottom' => [
						'title' => __( 'Bottom', 'woolementor' ),
						'icon' 	=> 'eicon-v-align-bottom',
					],
				],
				'default' 		=> 'top',
				'toggle' 		=> true,
				'selectors' => [
					'{{WRAPPER}} .wl-atc-button-area table tr td' => 'vertical-align: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'table_row_border',
				'label'         => __( 'Border', 'woolementor' ),
				'selector'      => '{{WRAPPER}} .wl-atc-button-area table tr td',
			]
		);

        $this->start_controls_tabs( 
        	'table_content_design',
        	[
                'separator' => 'before'
            ] 
        );

        $this->start_controls_tab(
            'table_row_odd',
            [
                'label' => __( 'ODD Row', 'woolementor' ),
            ]
        );

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'table_row_background_odd',
				'label' => __( 'Background 2', 'woolementor' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .wl-atc-button-area table tr:nth-child(2n+1) td',
			]
		);

		$this->add_control(
            'table_row_text_odd',
            [
                'label' => __( 'Text Color', 'woolementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
					'{{WRAPPER}} .wl-atc-button-area table tr:nth-child(2n+1) td' => 'color: {{VALUE}};',
					'{{WRAPPER}} .wl-atc-button-area table tr:nth-child(2n+1) td a' => 'color: {{VALUE}};',
                ],
            ]
        );
		 
		$this->end_controls_tab();

		$this->start_controls_tab(
            'table_row_even',
            [
                'label' => __( 'Even Row', 'woolementor' ),
            ]
        );

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'table_row_background_even',
				'label' => __( 'Background', 'woolementor' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .wl-atc-button-area table tr:nth-child(2n) td',
			]
		);

		$this->add_control(
            'table_row_text_even',
            [
                'label' => __( 'Text Color', 'woolementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wl-atc-button-area table tr:nth-child(2n) td' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .wl-atc-button-area table tr:nth-child(2n) td a' => 'color: {{VALUE}};',
                ],
            ]
        );

		$this->end_controls_tab();

		$this->start_controls_tab(
            'table_row_hover',
            [
                'label' => __( 'Hover Row', 'woolementor' ),
            ]
        );

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'table_row_background_hover',
				'label' => __( 'Background 2', 'woolementor' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .wl-atc-button-area table tr:hover td',
			]
		);

		$this->add_control(
            'table_row_text_hover',
            [
                'label' => __( 'Text Color', 'woolementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
					'{{WRAPPER}} .wl-atc-button-area table tr:hover td' => 'color: {{VALUE}};',
					'{{WRAPPER}} .wl-atc-button-area table tr:hover td a' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
		$this->end_controls_section();
	}

	protected function woolementor_get_product_type() {

		$product_id = get_the_ID();
		$product 	= wc_get_product( $product_id );

		if ( $product ) {
			return $product->get_type();
		}

		return false;
	}

	protected function render() {

		$settings 	= $this->get_settings_for_display();
		extract( $settings );

		$this->render_editing_attributes();

		$product_id = get_the_ID();
		if ( woolementor_is_edit_mode() || woolementor_is_preview_mode() ) {
			$product_id 	= woolementor_get_product_id();
		}
		$product 	= wc_get_product( $product_id );

		if ( !$product ) {
			_e( 'This is not a product or an invalid ID is provided.', 'woolementor' );
			return;
		}

		if( woolementor_is_live_mode() ) {
			wc_print_notices();
		}
		
		$product_type = $product->get_type();
		$button_text  = $add_to_cart_text;

		$product_url = get_post_meta( $product_id, '_product_url', true );
		?>
		<div class="wl-atc-button-area">
			<?php
			$template = 'simple.php';

			if ( 'external' == $product_type ) {
				$template = 'external.php';
			}

			elseif ( 'grouped' == $product_type ) {
				$post = get_post( $product_id );
				$grouped_products = $product->get_children();
				$template = 'grouped.php';
			}

			elseif ( 'simple' == $product_type || 'subscription' == $product_type ) {
				$template = 'simple.php';
			}

			elseif ( 'variable' == $product_type || 'variable-subscription' == $product_type ) {
				$template = 'variable.php';
			}

			include dirname( __FILE__ ) . "/templates/{$template}";
			?>
		</div>

		<?php 
	}

	private function render_editing_attributes() {
		$this->add_inline_editing_attributes( 'add_to_cart_text', 'basic' );
		$this->add_render_attribute( 'add_to_cart_text', 'class', 'single_add_to_cart_button button al' );
	}
}
