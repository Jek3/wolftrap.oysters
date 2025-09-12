<?php
namespace codexpert\Woolementor;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use codexpert\Woolementor\Controls\Group_Control_Gradient_Text;

class Cart_Overview extends Widget_Base {

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
		 * Heading controls
		 */
		$this->start_controls_section(
			'section_heading',
			[
				'label' => __( 'Sections', 'woolementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'section_heading_show_hide',
			[
				'label' 		=> __( 'Show/Hide Heading', 'woolementor' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'Show', 'woolementor' ),
				'label_off' 	=> __( 'Hide', 'woolementor' ),
				'return_value' 	=> 'yes',
				'default' 		=> 'yes',
			]
		);

		$this->add_control(
			'section_heading_text',
			[
				'label' 		=> __( 'Heading', 'woolementor' ),
				'type' 			=> Controls_Manager::TEXT,
				'default' 		=> __( 'Cart totals', 'woolementor' ),
			]
		);

		$this->add_control(
			'section_heading_tag',
			[
				'label'		=> __( 'Heading Tag', 'woolementor' ),
				'type' 		=>Controls_Manager::CHOOSE,
				'options' 	=> [
					'h1' 	=> [
						'title' 	=> __( 'H1', 'woolementor' ),
						'icon' 		=> 'eicon-editor-h1',
					],
					'h2' 	=> [
						'title' 	=> __( 'H2', 'woolementor' ),
						'icon' 		=> 'eicon-editor-h2',
					],
					'h3' 	=> [
						'title' 	=> __( 'H3', 'woolementor' ),
						'icon' 		=> 'eicon-editor-h3',
					],
					'h4' 	=> [
						'title' 	=> __( 'H4', 'woolementor' ),
						'icon' 		=> 'eicon-editor-h4',
					],
					'h5' 	=> [
						'title' 	=> __( 'H5', 'woolementor' ),
						'icon' 		=> 'eicon-editor-h5',
					],
					'h6' 	=> [
						'title' 	=> __( 'H6', 'woolementor' ),
						'icon' 		=> 'eicon-editor-h6',
					],
				],
				'default' 	=> 'h2',
				'condition' 	=> [
					'section_heading_show_hide' => 'yes'
				],
			]
		);

		$this->add_control(
			'section_checkout_show_hide',
			[
				'label' 		=> __( 'Proceed Button', 'woolementor' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'Show', 'woolementor' ),
				'label_off' 	=> __( 'Hide', 'woolementor' ),
				'return_value' 	=> 'block',
				'default' 		=> 'block',
				'selectors' 	=> [
					'{{WRAPPER}} .wc-proceed-to-checkout a.checkout-button' => 'display: {{VALUE}}!important',
				],
				'separator' 	=> 'before'
			]
		);

		$this->end_controls_section();

		/**
		 * Cart overview section title
		 */
		$this->start_controls_section(
			'cart_table_title_style',
			[
				'label' 		=> __( 'Section Title', 'woolementor' ),
				'tab'   		=> Controls_Manager::TAB_STYLE,
				'condition' 	=> [
					'section_heading_show_hide' => 'yes'
				],
			]
		);

		$this->add_control(
			'cart_table_title_alignment',
			[
				'label'		=> __( 'Title Alignment', 'woolementor' ),
				'type' 		=>Controls_Manager::CHOOSE,
				'options' 	=> [
					'left' 	=> [
						'title' 	=> __( 'Left', 'woolementor' ),
						'icon' 		=> 'fa fa-align-left',
					],
					'center' 	=> [
						'title' 	=> __( 'Center', 'woolementor' ),
						'icon' 		=> 'fa fa-align-center',
					],
					'right' 	=> [
						'title' 	=> __( 'Right', 'woolementor' ),
						'icon' 		=> 'fa fa-align-right',
					],
				],
				'default' 	=> 'left',
				'toggle'    => false,
				'selectors' => [
					'{{WRAPPER}} .wl-cart-overview .cart_totals .wl-co-title' => 'text-align: {{VALUE}}',
					'{{WRAPPER}} .wl-cart-overview .cart_totals .elementor-inline-editing' => 'text-align: {{VALUE}}',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'cart_table_title_typography',
				'label' => __( 'Typography', 'woolementor' ),
				'scheme' => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .wl-cart-overview .cart_totals .wl-co-title, {{WRAPPER}} .wl-cart-overview .cart_totals .elementor-inline-editing',
			]
		);

		$this->add_group_control(
            Group_Control_Gradient_Text::get_type(),
            [
                'name' => 'cart_table_title_gradient_color',
                'selector' => '{{WRAPPER}} .wl-cart-overview .cart_totals .wl-co-title, {{WRAPPER}} .wl-cart-overview .cart_totals .elementor-inline-editing',
            ]
        );

		$this->end_controls_section();

		/**
		 * Cart Table
		 */
		$this->start_controls_section(
			'style_cart_overview',
			[
				'label' 		=> __( 'Table', 'woolementor' ),
				'tab'   		=> Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' 			=> 'style_cart_overview_background',
				'label' 		=> __( 'Background', 'woolementor' ),
				'types' 		=> [ 'classic', 'gradient' ],
				'selector' 		=> '{{WRAPPER}} .wl-cart-overview table',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'style_cart_overview_border',
				'label'         => __( 'Border', 'woolementor' ),
				'selector'      => '{{WRAPPER}} .wl-cart-overview table tr td, {{WRAPPER}} .wl-cart-overview table tr th',
				'separator'		=> 'before'
			]
		);

		$this->end_controls_section();

		/**
		 * Table Content controls
		 */
		$this->start_controls_section(
			'section_table_content',
			[
				'label' 		=> __( 'Table Content', 'woolementor' ),
				'tab'   		=> Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'content_alignment',
			[
				'label'		=> __( 'Content Alignment', 'woolementor' ),
				'type' 		=>Controls_Manager::CHOOSE,
				'options' 	=> [
					'left' 	=> [
						'title' 	=> __( 'Left', 'woolementor' ),
						'icon' 		=> 'fa fa-align-left',
					],
					'center' 	=> [
						'title' 	=> __( 'Center', 'woolementor' ),
						'icon' 		=> 'fa fa-align-center',
					],
					'right' 	=> [
						'title' 	=> __( 'Right', 'woolementor' ),
						'icon' 		=> 'fa fa-align-right',
					],
				],
				'default' 	=> 'right',
				'toggle'    => false,
				'selectors' => [
					'{{WRAPPER}} .wl-cart-overview table tr td' => 'text-align: {{VALUE}}',
					'{{WRAPPER}} .wl-cart-overview table tr th' => 'text-align: {{VALUE}}',
				]
			]
		);

		$this->start_controls_tabs(
			'table_content_tab',
			[ ]
		);

		$this->start_controls_tab(
			'table_content_label',
			[
				'label' 		=> __( 'Label', 'woolementor' ),
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 			=> 'table_content_label_typography',
				'label' 		=> __( 'Typography', 'woolementor' ),
				'scheme' 		=> Typography::TYPOGRAPHY_3,
				'selector' 		=> '{{WRAPPER}} .wl-cart-overview table tr th',
			]
		);

		$this->add_control(
			'table_content_label_bg_color',
			[
				'label' 		=> __( 'Background Color', 'woolementor' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .wl-cart-overview table tr th' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'table_content_label_color',
			[
				'label' 		=> __( 'Color', 'woolementor' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .wl-cart-overview table tr th' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
            '_table_content_label_hover',
            [
                'type' => Controls_Manager::HEADING,
                'label' => __( 'Hover', 'woolementor' ),
                'separator' => 'before'
            ]
        );

		$this->add_control(
			'table_content_label_hover_bg_color',
			[
				'label' 		=> __( 'Background Color', 'woolementor' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .wl-cart-overview table tr:hover th' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'table_content_label_hover_color',
			[
				'label' 		=> __( 'Color', 'woolementor' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .wl-cart-overview table tr:hover th' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'table_content_value',
			[
				'label' 		=> __( 'Value', 'woolementor' ),
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 			=> 'table_content_value_typography',
				'label' 		=> __( 'Typography', 'woolementor' ),
				'scheme' 		=> Typography::TYPOGRAPHY_3,
				'selector' 		=> '{{WRAPPER}} .wl-cart-overview table tr td',
			]
		);

		$this->add_control(
			'table_content_value_bg_color',
			[
				'label' 		=> __( 'Background Color', 'woolementor' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .wl-cart-overview table tr td' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'table_content_value_color',
			[
				'label' 		=> __( 'Color', 'woolementor' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .wl-cart-overview table tr td' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
            '_table_content_value_hover',
            [
                'type' => Controls_Manager::HEADING,
                'label' => __( 'Hover', 'woolementor' ),
                'separator' => 'before'
            ]
        );

		$this->add_control(
			'table_content_value_hover_bg_color',
			[
				'label' 		=> __( 'Background Color', 'woolementor' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .wl-cart-overview table tr:hover td' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'table_content_value_hover_color',
			[
				'label' 		=> __( 'Color', 'woolementor' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .wl-cart-overview table tr:hover td' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();

		/**
		 * Checkout Button
		 */
		$this->start_controls_section(
			'checkout_button',
			[
				'label'			=> __( 'Proceed Button', 'woolementor' ),
				'tab'   		=> Controls_Manager::TAB_STYLE,
				'condition' 	=> [
					'section_checkout_show_hide' => 'block'
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'checkout_button_typography',
				'label' 	=> __( 'Typography', 'woolementor' ),
				'scheme' 	=> Typography::TYPOGRAPHY_3,
				'selector' 	=> '{{WRAPPER}} .wl-cart-overview .wc-proceed-to-checkout a.checkout-button',
			]
		);

		$this->add_responsive_control(
			'checkout_button_padding',
			[
				'label' 		=> __( 'Padding', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .wc-proceed-to-checkout a.checkout-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'		=> 'before'
			]
		);

		$this->add_responsive_control(
			'checkout_button_margin',
			[
				'label' 		=> __( 'Margin', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .wc-proceed-to-checkout a.checkout-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs(
			'cart_proceed_btn_tab',
			[ 'separator'		=> 'before' ]
		);

		$this->start_controls_tab(
			'cart_proceed_btn',
			[
				'label' 		=> __( 'Normal', 'woolementor' ),
			]
		);

		$this->add_control(
			'checkout_button_color',
			[
				'label'     => __( 'Text Color', 'woolementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-cart-overview .wc-proceed-to-checkout a.checkout-button' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'checkout_button_bg',
			[
				'label'     => __( 'Background', 'woolementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-cart-overview .wc-proceed-to-checkout a.checkout-button' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'checkout_button_border',
				'label'         => __( 'Border', 'woolementor' ),
				'selector'      => '{{WRAPPER}} .wc-proceed-to-checkout a.checkout-button',
				'separator'		=> 'before'
			]
		);

		$this->add_responsive_control(
			'checkout_button_border_radius',
			[
				'label'         => __( 'Border Radius', 'woolementor' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', '%' ],
				'selectors'     => [
					'{{WRAPPER}} .wc-proceed-to-checkout a.checkout-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'cart_proceed_btn_hover',
			[
				'label' 		=> __( 'Hover', 'woolementor' ),
			]
		);

		$this->add_control(
			'checkout_button_color_hover',
			[
				'label'     => __( 'Text Color', 'woolementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-cart-overview .wc-proceed-to-checkout a.checkout-button:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'checkout_button_bg_hover',
			[
				'label'     => __( 'Background', 'woolementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-cart-overview .wc-proceed-to-checkout a.checkout-button:hover' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'checkout_button_border_hover',
				'label'         => __( 'Border', 'woolementor' ),
				'selector'      => '{{WRAPPER}} .wc-proceed-to-checkout a.checkout-button:hover',
				'separator'		=> 'before'
			]
		);

		$this->add_responsive_control(
			'checkout_button_border_radius_hover',
			[
				'label'         => __( 'Border Radius', 'woolementor' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', '%' ],
				'selectors'     => [
					'{{WRAPPER}} .wc-proceed-to-checkout a.checkout-button:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
	}

	protected function render() {
		$settings 	= $this->get_settings_for_display();
		extract( $settings );

		$this->render_editing_attributes();

		if ( !empty( WC()->cart->get_cart() ) ) : 

			?>
			<div class="wl-cart-overview">
				<?php include plugin_dir_path(__FILE__ ).'/assets/templates/cart-totals.php'; return; ?>
			</div>
			<?php 
			
		else:
			if ( !did_action( 'woocommerce_cart_is_empty' ) ) {
				do_action( 'woocommerce_cart_is_empty' );
			}
		endif;
	}

	private function render_editing_attributes() {
		$this->add_inline_editing_attributes( 'section_heading_text', 'basic' );
	}
}