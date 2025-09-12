<?php
namespace codexpert\Woolementor;

use Elementor\Widget_Base;
use Elementor\Control_Icon;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Background;
use Elementor\Products_Renderer;
use Elementor\Controls_Stack;
use codexpert\Woolementor\Controls\Group_Control_Gradient_Text;

class Cart_Items extends Widget_Base {

	public $id;

	public function __construct( $data = [], $args = null ) {
	    parent::__construct( $data, $args );

	    $this->id = woolementor_get_widget_id( __CLASS__ );
	    $this->widget = woolementor_get_widget( $this->id );
	    
		// Are we in debug mode?
		$min = defined( 'WOOLEMENTOR_DEBUG' ) && WOOLEMENTOR_DEBUG ? '' : '.min';

		wp_register_script( "woolementor-{$this->id}", plugins_url( "assets/js/script{$min}.js", __FILE__ ), ['jquery'], '1.1', true );

		wp_register_style( "woolementor-{$this->id}", plugins_url( "assets/css/style{$min}.css", __FILE__ ), [], '1.1' );
	}

	public function get_script_depends() {
		return [ "woolementor-{$this->id}", 'fancybox' ];
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
		 * Columns
		 */
		$this->start_controls_section(
			'section_content_columns',
			[
				'label' => __( 'Columns', 'woolementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
			'product_image_show_hide',
			[
				'label' 		=> __( 'Thumbnail', 'woolementor' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'Show', 'woolementor' ),
				'label_off' 	=> __( 'Hide', 'woolementor' ),
				'return_value' 	=> 'yes',
				'desktop_default'	=> 'yes',
				'tablet_default'	=> 'yes',
				'mobile_default'	=> 'yes',
				'prefix_class' 	=> 'wl-product-image-show%s-',
				'selectors' => [
					'{{WRAPPER}} .wl-ci-product-style table thead tr th.wl-product-thumbnail' => 'display: {{VALUE}}',
					'{{WRAPPER}} .wl-ci-product-style table tbody tr td.wl-ci-product-thumbnail' => 'display: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'product_image_heading',
			[
				'label' 		=> __( 'Heading', 'woolementor' ),
				'type' 			=> Controls_Manager::TEXT,
				'default' 		=> __( 'Thumbnail', 'woolementor' ),
				'placeholder' 	=> __( 'Type your title here', 'woolementor' ),
				'condition' 	=> [
					'product_image_show_hide' => 'yes'
				],
			]
		);

		$this->add_control(
			'product_image_click',
			[
				'label'     => __( 'On Click', 'woolementor' ),
				'type'      => Controls_Manager::SELECT2,
				'options'   => [
					'none'          => __( 'None', 'woolementor' ),
					'zoom'          => __( 'Zoom', 'woolementor' ),
					'product_page'  => __( 'Product Page', 'woolementor' ),
				],
				'default'   => 'none',
				'condition' 	=> [
					'product_image_show_hide' => 'yes'
				],
			]
		);

		$this->add_responsive_control(
			'product_name_show_hide',
			[
				'label' 		=> __( 'Product', 'woolementor' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'Show', 'woolementor' ),
				'label_off' 	=> __( 'Hide', 'woolementor' ),
				'return_value' 	=> 'yes',
				'separator'		=> 'before',
				'desktop_default'	=> 'yes',
				'tablet_default'	=> 'yes',
				'mobile_default'	=> 'yes',
				'prefix_class' 	=> 'wl-product-name-show%s-',
			]
		);

		$this->add_control(
			'product_name_heading',
			[
				'label' 		=> __( 'Heading', 'woolementor' ),
				'type' 			=> Controls_Manager::TEXT,
				'default' 		=> __( 'Product', 'woolementor' ),
				'placeholder' 	=> __( 'Type your title here', 'woolementor' ),
				'condition' 	=> [
					'product_name_show_hide' => 'yes'
				],
			]
		);

		$this->add_responsive_control(
			'product_category_show_hide',
			[
				'label' 		=> __( 'Category', 'woolementor' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'Show', 'woolementor' ),
				'label_off' 	=> __( 'Hide', 'woolementor' ),
				'return_value' 	=> 'yes',
				'default' 		=> 'yes',
				'condition' 	=> [
					'product_name_show_hide' => 'yes'
				],
				'separator'		=> 'before',
				'desktop_default'	=> 'yes',
				'tablet_default'	=> 'yes',
				'mobile_default'	=> 'no',
				'prefix_class' 		=> 'wl-product-category-show%s-',
			]
		);

		$this->add_control(
			'product_category_heading',
			[
				'label' 		=> __( 'Label', 'woolementor' ),
				'type' 			=> Controls_Manager::TEXT,
				'default' 		=> __( 'Category: ', 'woolementor' ),
				'placeholder' 	=> __( 'Type your title here', 'woolementor' ),
				'condition' 	=> [
					'product_name_show_hide' => 'yes',
					'product_category_show_hide' => 'yes'
				],
			]
		);

		$this->add_responsive_control(
			'product_price_show_hide',
			[
				'label' 		=> __( 'Price', 'woolementor' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'Show', 'woolementor' ),
				'label_off' 	=> __( 'Hide', 'woolementor' ),
				'return_value' 	=> 'yes',
				'separator'		=> 'before',
				'desktop_default'	=> 'yes',
				'tablet_default'	=> 'yes',
				'mobile_default'	=> 'yes',
				'prefix_class' 	=> 'wl-product-price-show%s-',
			]
		);

		$this->add_control(
			'product_price_heading',
			[
				'label' 		=> __( 'Heading', 'woolementor' ),
				'type' 			=> Controls_Manager::TEXT,
				'default' 		=> __( 'Price', 'woolementor' ),
				'placeholder' 	=> __( 'Type your title here', 'woolementor' ),
				'condition' 	=> [
					'product_price_show_hide' => 'yes'
				],
			]
		);

		$this->add_responsive_control(
			'product_quantity_show_hide',
			[
				'label' 		=> __( 'Quantity', 'woolementor' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'Show', 'woolementor' ),
				'label_off' 	=> __( 'Hide', 'woolementor' ),
				'return_value' 	=> 'yes',
				'separator'		=> 'before',
				'desktop_default'	=> 'yes',
				'tablet_default'	=> 'yes',
				'mobile_default'	=> 'yes',
				'prefix_class' 	=> 'wl-product-quantity-show%s-',
			]
		);

		$this->add_control(
			'product_quantity_heading',
			[
				'label' 		=> __( 'Heading', 'woolementor' ),
				'type' 			=> Controls_Manager::TEXT,
				'default' 		=> __( 'Quantity', 'woolementor' ),
				'placeholder' 	=> __( 'Type your title here', 'woolementor' ),
				'condition' 	=> [
					'product_quantity_show_hide' => 'yes'
				],
			]
		);

		$this->add_responsive_control(
			'product_subtotal_show_hide',
			[
				'label' 		=> __( 'Subtotal', 'woolementor' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'Show', 'woolementor' ),
				'label_off' 	=> __( 'Hide', 'woolementor' ),
				'return_value' 	=> 'yes',
				'separator'		=> 'before',
				'desktop_default'	=> 'yes',
				'tablet_default'	=> 'yes',
				'mobile_default'	=> 'yes',
				'prefix_class' 	=> 'wl-product-subtotal-show%s-',
			]
		);

		$this->add_control(
			'product_subtotal_heading',
			[
				'label' 		=> __( 'Heading', 'woolementor' ),
				'type' 			=> Controls_Manager::TEXT,
				'default' 		=> __( 'Subtotal', 'woolementor' ),
				'placeholder' 	=> __( 'Type your title here', 'woolementor' ),
				'condition' 	=> [
					'product_subtotal_show_hide' => 'yes'
				],
			]
		);

		$this->add_responsive_control(
			'product_remove_btn_show_hide',
			[
				'label' 		=> __( 'Remove Button', 'woolementor' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'Show', 'woolementor' ),
				'label_off' 	=> __( 'Hide', 'woolementor' ),
				'return_value' 	=> 'yes',
				'separator'		=> 'before',
				'desktop_default'	=> 'yes',
				'tablet_default'	=> 'yes',
				'mobile_default'	=> 'yes',
				'prefix_class' 	=> 'wl-product-remove-show%s-',
			]
		);

		$this->end_controls_section();

		/**
		 * Bottom Sections
		 */
		$this->start_controls_section(
			'section_content_bottom_sections',
			[
				'label' => __( 'Bottom Sections', 'woolementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'coupon_show_hide',
			[
				'label' 		=> __( 'Coupon Area', 'woolementor' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'Show', 'woolementor' ),
				'label_off' 	=> __( 'Hide', 'woolementor' ),
				'return_value' 	=> 'yes',
				'default' 		=> 'yes',
			]
		);

		$this->add_control(
			'Coupon_button_name',
			[
				'label' 		=> __( 'Button Text', 'woolementor' ),
				'type' 			=> Controls_Manager::TEXT,
				'default' 		=> __( 'Apply coupon', 'woolementor' ),
				'placeholder' 	=> __( 'Type your title here', 'woolementor' ),
				'condition' 	=> [
					'coupon_show_hide' => 'yes'
				],
			]
		);

		$this->add_control(
			'Coupon_button_placeholder',
			[
				'label' 		=> __( 'Placeholder Text', 'woolementor' ),
				'type' 			=> Controls_Manager::TEXT,
				'default' 		=> __( 'Coupon code', 'woolementor' ),
				'placeholder' 	=> __( 'Type your title here', 'woolementor' ),
				'condition' 	=> [
					'coupon_show_hide' => 'yes'
				],
			]
		);

		$this->add_control(
			'update_cart_show_hide',
			[
				'label' 		=> __( 'Update Button', 'woolementor' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'Show', 'woolementor' ),
				'label_off' 	=> __( 'Hide', 'woolementor' ),
				'return_value' 	=> 'yes',
				'default' 		=> 'yes',
				'separator'		=> 'before'
			]
		);

		$this->add_control(
			'update_cart_button_name',
			[
				'label' 		=> __( 'Button Text', 'woolementor' ),
				'type' 			=> Controls_Manager::TEXT,
				'default' 		=> __( 'Update Cart', 'woolementor' ),
				'placeholder' 	=> __( 'Type your title here', 'woolementor' ),
				'condition' 	=> [
					'update_cart_show_hide' => 'yes'
				],
			]
		);

		$this->add_control(
			'checkout_show_hide',
			[
				'label' 		=> __( 'Proceed to Checkout', 'woolementor' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'Show', 'woolementor' ),
				'label_off' 	=> __( 'Hide', 'woolementor' ),
				'return_value' 	=> 'yes',
				'default' 		=> 'yes',
				'separator'		=> 'before'
			]
		);

		$this->add_control(
			'checkout_button_name',
			[
				'label' 		=> __( 'Button Text', 'woolementor' ),
				'type' 			=> Controls_Manager::TEXT,
				'default' 		=> __( 'Proceed to Checkout', 'woolementor' ),
				'placeholder' 	=> __( 'Type your title here', 'woolementor' ),
				'condition' 	=> [
					'checkout_show_hide' => 'yes'
				],
			]
		);

		$this->add_control(
			'enable_back_to_shop_btn',
			[
				'label' 		=> __( 'Show Back to Shop Button', 'woolementor' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'Show', 'woolementor' ),
				'label_off' 	=> __( 'Hide', 'woolementor' ),
				'return_value' 	=> 'yes',
				'default' 		=> 'yes',
				'separator'		=> 'before',
			]
		);

		$this->add_control(
			'back_to_shop_btn_txt',
			[
				'label' 		=> __( 'Button Text', 'woolementor' ),
				'type' 			=> Controls_Manager::TEXT,
				'default' 		=> __( 'Back to Shop', 'woolementor' ),
				'placeholder' 	=> __( 'Type your title here', 'woolementor' ),
				'condition' 	=> [
					'enable_back_to_shop_btn' => 'yes'
				],
			]
		);

		$this->end_controls_section();

		/**
		 * Cart Table
		 */
		$this->start_controls_section(
			'style_section_cart_table',
			[
				'label' => __( 'Table', 'woolementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' 		=> 'cart_table_background',
				'label' 	=> __( 'Background', 'woolementor' ),
				'types' 	=> [ 'classic', 'gradient' ],
				'selector' 	=> '{{WRAPPER}} table.wl-ci-cart-table',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 		=> 'cart_table_border',
				'label' 	=> __( 'Border', 'woolementor' ),
				'selector' 	=> '{{WRAPPER}} table.wl-ci-cart-table',
				'separator' => 'before'
			]
		);

		$this->add_responsive_control(
			'cart_table_border_radius',
			[
				'label' 		=> __( 'Border Radius', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%' ],
				'selectors' 	=> [
					'{{WRAPPER}} table.wl-ci-cart-table' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' 		=> 'cart_table_box_shadow',
				'label' 	=> __( 'Box Shadow', 'woolementor' ),
				'selector' 	=> '{{WRAPPER}} table.wl-ci-cart-table',
			]
		);

		$this->add_responsive_control(
			'cart_table_shadow_padding',
			[
				'label' 		=> __( 'Padding', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} table.wl-ci-cart-table' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'		=> 'before'
			]
		);

		$this->add_responsive_control(
			'cart_table_shadow_margin',
			[
				'label' 		=> __( 'Margin', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} table.wl-ci-cart-table' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/**
		 * cart-heading
		 */
		$this->start_controls_section(
			'section_cart_heading',
			[
				'label' => __( 'Table Heading', 'woolementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'cart_heading_color',
			[
				'label'     => __( 'Text Color', 'woolementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} thead tr.wl-ci-heading-nav th.wl-ci-heading' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'cart_heading_typography',
				'label'     => __( 'Typography', 'woolementor' ),
				'scheme'    => Typography::TYPOGRAPHY_3,
				'selector'  => '{{WRAPPER}} thead tr.wl-ci-heading-nav th.wl-ci-heading',
			]
		); 

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' 		=> 'cart_heading_background',
				'label' 	=> __( 'Background', 'woolementor' ),
				'types' 	=> [ 'classic', 'gradient' ],
				'selector' 	=> '{{WRAPPER}} thead tr.wl-ci-heading-nav',
			]
		);

		$this->add_responsive_control(
			'cart_heading_padding',
			[
				'label' 		=> __( 'Padding', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} thead tr.wl-ci-heading-nav th.wl-ci-heading' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/**
		 * Product Image controls
		 */
		$this->start_controls_section(
			'section_style_image',
			[
				'label' => __( 'Product Image', 'woolementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'image_width',
			[
				'label' 	=> __( 'Image Width', 'woolementor' ),
				'type' 		=> Controls_Manager::SLIDER,
				'size_units'=> [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .product-thumbnail.wl-ci-product-thumbnail img' => 'width: {{SIZE}}{{UNIT}}',
				],
				'range' 	=> [
					'px' 	=> [
						'min' 	=> 1,
						'max' 	=> 250
					],
					'em' 	=> [
						'min' 	=> 1,
						'max' 	=> 30
					],
				],
			]
		);

		$this->add_responsive_control(
			'image_height',
			[
				'label' 	=> __( 'Image Height', 'woolementor' ),
				'type' 		=> Controls_Manager::SLIDER,
				'size_units'=> [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .product-thumbnail.wl-ci-product-thumbnail img' => 'height: {{SIZE}}{{UNIT}}',
				],
				'range' 	=> [
					'px' 	=> [
						'min' 	=> 1,
						'max' 	=> 250
					],
					'em' 	=> [
						'min' 	=> 1,
						'max' 	=> 30
					],
				],
			]
		);

		$this->add_responsive_control(
			'image_box_height',
			[
				'label' 	=> __( 'Image Box Height', 'woolementor' ),
				'type' 		=> Controls_Manager::SLIDER,
				'size_units'=> [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .product-thumbnail.wl-ci-product-thumbnail' => 'height: {{SIZE}}{{UNIT}}',
				],
                'range'     => [
                    'px'    => [
                        'min'   => 1,
                        'max'   => 500
                    ],
                    'em'    => [
                        'min'   => 1,
                        'max'   => 30
                    ],
                ],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 		=> 'image_border',
				'label' 	=> __( 'Border', 'woolementor' ),
				'selector' 	=> '{{WRAPPER}} .product-thumbnail.wl-ci-product-thumbnail img',
			]
		);

		$this->add_responsive_control(
			'image_border_radius',
			[
				'label' 		=> __( 'Border Radius', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%' ],
				'selectors' 	=> [
					'{{WRAPPER}} .product-thumbnail.wl-ci-product-thumbnail img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' 		=> 'image_box_shadow',
				'label' 	=> __( 'Box Shadow', 'woolementor' ),
				'selector' 	=> '{{WRAPPER}} .product-thumbnail.wl-ci-product-thumbnail img',
			]
		);

		$this->start_controls_tabs(
			'image_effects',
			[
				'separator' => 'before'
			]
		);

		$this->start_controls_tab(
			'image_effects_normal',
			[
				'label' 	=> __( 'Normal', 'woolementor' ),
			]
		);

		$this->add_control(
			'image_opacity',
			[
				'label' 	=> __( 'Opacity', 'woolementor' ),
				'type' 		=> Controls_Manager::SLIDER,
				'range' 	=> [
					'px' 	=> [
						'max' 	=> 1,
						'min' 	=> 0.10,
						'step' 	=> 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .product-thumbnail.wl-ci-product-thumbnail img' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' 		=> 'image_css_filters',
				'selector' 	=> '{{WRAPPER}} .product-thumbnail.wl-ci-product-thumbnail img',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'image_hover',
			[
				'label' 	=> __( 'Hover', 'woolementor' ),
			]
		);

		$this->add_control(
			'image_opacity_hover',
			[
				'label' 	=> __( 'Opacity', 'woolementor' ),
				'type' 		=> Controls_Manager::SLIDER,
				'range' 	=> [
					'px' 	=> [
						'max' 	=> 1,
						'min' 	=> 0.10,
						'step' 	=> 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .product-thumbnail.wl-ci-product-thumbnail img:hover' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' 		=> 'image_css_filters_hover',
				'selector' 	=> '{{WRAPPER}} .product-thumbnail.wl-ci-product-thumbnail img:hover',
			]
		);

		$this->add_control(
			'image_hover_transition',
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
					'{{WRAPPER}} .product-thumbnail.wl-ci-product-thumbnail img:hover' => 'transition-duration: {{SIZE}}s',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();

		/**
		 * Product Title
		 */
		$this->start_controls_section(
			'section_style_title',
			[
				'label' => __( 'Product Title', 'woolementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
            Group_Control_Gradient_Text::get_type(),
            [
                'name' => 'title_gradient_color',
                'selector' => '{{WRAPPER}} .wl-ci-product-name.product-name > a',
            ]
        );

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'title_typography',
				'label' 	=> __( 'Typography', 'woolementor' ),
				'scheme' 	=> Typography::TYPOGRAPHY_1,
				'selector' 	=> '{{WRAPPER}} .wl-ci-product-name.product-name > a',
			]
		);

		$this->end_controls_section();

		/**
		 * Product Category
		 */
		$this->start_controls_section(
			'section_style_category',
			[
				'label' => __( 'Product Category', 'woolementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs(
			'category_label_separator',
			[
				'separator' => 'before'
			]
		);

		$this->start_controls_tab(
			'category_label',
			[
				'label' 	=> __( 'Label', 'woolementor' ),
			]
		);

		$this->add_group_control(
            Group_Control_Gradient_Text::get_type(),
            [
                'name' => 'category_label_gradient_color',
                'selector' => '{{WRAPPER}} .wl-ci-cart-category span',
            ]
        );

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'category_label_typography',
				'label' 	=> __( 'Typography', 'woolementor' ),
				'scheme' 	=> Typography::TYPOGRAPHY_3,
				'selector' 	=> '{{WRAPPER}} .wl-ci-cart-category span',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'category_text',
			[
				'label' 	=> __( 'Text', 'woolementor' ),
			]
		);

		$this->add_group_control(
            Group_Control_Gradient_Text::get_type(),
            [
                'name' => 'category_gradient_color',
                'selector' => '{{WRAPPER}} .wl-ci-cart-category a',
            ]
        );

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'category_typography',
				'label' 	=> __( 'Typography', 'woolementor' ),
				'scheme' 	=> Typography::TYPOGRAPHY_3,
				'selector' 	=> '{{WRAPPER}} .wl-ci-cart-category a',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();

		/**
		 * Product Price
		 */
		$this->start_controls_section(
			'section_style_price',
			[
				'label' => __( 'Product Price', 'woolementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'price_color',
			[
				'label'     => __( 'Font Color', 'woolementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .product-price.wl-ci-product-price .woocommerce-Price-amount.amount' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'price_size_typography',
				'label' 	=> __( 'Typography', 'woolementor' ),
				'scheme' 	=> Typography::TYPOGRAPHY_3,
				'selector' 	=> '{{WRAPPER}} .product-price.wl-ci-product-price .woocommerce-Price-amount.amount',
			]
		);

		$this->end_controls_section();

		/**
		 * Quantity
		 */
		$this->start_controls_section(
			'section_style_quantity',
			[
				'label' => __( 'Quantity', 'woolementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'quantity_font_color',
			[
				'label'     => __( 'Font Color', 'woolementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .product-quantity.wl-ci-product-quantity .input-text.qty.text' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 		=> 'quantity_border',
				'label' 	=> __( 'Border', 'woolementor' ),
				'selector' 	=> '{{WRAPPER}} .product-quantity.wl-ci-product-quantity .quantity.buttons_added',
				'separator' => 'before'
			]
		);

		$this->add_responsive_control(
			'quantity_border_radius',
			[
				'label' 		=> __( 'Border Radius', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%' ],
				'selectors' 	=> [
					'{{WRAPPER}} .product-quantity.wl-ci-product-quantity .quantity.buttons_added' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'quantity_padding',
			[
				'label' 		=> __( 'Padding', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .product-quantity.wl-ci-product-quantity input[type=button]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'quantity_icon_color',
			[
				'label'     => __( 'Icon Color', 'woolementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .product-quantity.wl-ci-product-quantity input[type=button]' => 'color: {{VALUE}}',
				],
				'separator' => 'before'
			]
		);

		$this->add_control(
			'quantity_icon_bg_color',
			[
				'label'     => __( 'Background', 'woolementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .product-quantity.wl-ci-product-quantity input[type=button]' => 'background: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

		/**
		 * Subtotal
		 */
		$this->start_controls_section(
			'section_style_subtotal',
			[
				'label' => __( 'Subtotal', 'woolementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'subtotal_color',
			[
				'label'     => __( 'Font Color', 'woolementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .product-subtotal.wl-ci-product-subtotal .woocommerce-Price-amount.amount' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'Subtotal_typography',
				'label' 	=> __( 'Typography', 'woolementor' ),
				'scheme' 	=> Typography::TYPOGRAPHY_3,
				'selector' 	=> '{{WRAPPER}} .product-subtotal.wl-ci-product-subtotal .woocommerce-Price-amount.amount',
			]
		);

		$this->end_controls_section();

		/**
		 * Product Remove
		 */
		$this->start_controls_section(
			'section_product_remove_button',
			[
				'label' => __( 'Remove Button', 'woolementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'section_product_remove_color',
			[
				'label'     => __( 'Icon Color', 'woolementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .product-remove.wl-ci-product-remove a.remove' => 'color: {{VALUE}} !important',
				],
			]
		);

		$this->add_control(
			'section_product_remove_icon',
			[
				'label' 	=> __( 'Icon', 'woolementor' ),
				'type' 		=> Controls_Manager::ICONS,
				'default' 	=> [
					'value' 	=> 'fa fa-times',
					'library' 	=> 'solid',
				],
			]
		);

		$this->add_control(
			'section_product_remove_bg',
			[
				'label'     => __( 'Background', 'woolementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .product-remove.wl-ci-product-remove a.remove' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 		=> 'section_product_remove_border',
				'label' 	=> __( 'Border', 'woolementor' ),
				'selector' 	=> '{{WRAPPER}} .product-remove.wl-ci-product-remove a.remove',
			]
		);

		$this->add_responsive_control(
			'section_product_remove_border_radius',
			[
				'label' 		=> __( 'Border Radius', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%' ],
				'selectors' 	=> [
					'{{WRAPPER}} .product-remove.wl-ci-product-remove a.remove' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' 		=> 'section_product_remove_box_shadow',
				'label' 	=> __( 'Box Shadow', 'woolementor' ),
				'selector' 	=> '{{WRAPPER}} .product-remove.wl-ci-product-remove a.remove',
			]
		);

		$this->add_responsive_control(
			'section_product_remove_padding',
			[
				'label' 		=> __( 'Padding', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .product-remove.wl-ci-product-remove a.remove' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'		=> 'before'
			]
		);

		$this->add_responsive_control(
			'section_product_remove_margin',
			[
				'label' 		=> __( 'Margin', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .product-remove.wl-ci-product-remove a.remove' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/**
		 * Coupon Button
		 */
		$this->start_controls_section(
			'section_coupon_button',
			[
				'label' => __( 'Coupon Button', 'woolementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'coupon_button_typography',
				'label'     => __( 'Typography', 'woolementor' ),
				'scheme'    => Typography::TYPOGRAPHY_3,
				'selector'  => '{{WRAPPER}} .button.wl-ci-coupon-button',
			]
		);

		$this->add_responsive_control(
			'coupon_button_border_radius',
			[
				'label' 		=> __( 'Border Radius', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%' ],
				'selectors' 	=> [
					'{{WRAPPER}} .button.wl-ci-coupon-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' 		=> 'coupon_button_box_shadow',
				'label' 	=> __( 'Box Shadow', 'woolementor' ),
				'selector' 	=> '{{WRAPPER}} .button.wl-ci-coupon-button',
			]
		);

		$this->add_responsive_control(
			'coupon_button_margin',
			[
				'label' 		=> __( 'Margin', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .button.wl-ci-coupon-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'coupon-button-tab',
			[

				'separator' => 'before'
			]
		);

		$this->start_controls_tab( 
			'coupon-button-tab-active',
			[
				'label' => __( 'Normal', 'woolementor' ),
			]
		);

		$this->add_control(
			'coupon_button_color',
			[
				'label'     => __( 'Text Color', 'woolementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .button.wl-ci-coupon-button' => 'color: {{VALUE}} !important',
				],
			]
		);

		$this->add_control(
			'coupon_button_bg',
			[
				'label'     => __( 'Background', 'woolementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .button.wl-ci-coupon-button' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 		=> 'coupon_button_border',
				'label' 	=> __( 'Border', 'woolementor' ),
				'selector' 	=> '{{WRAPPER}} .button.wl-ci-coupon-button',
			]
		);$this->end_controls_tab();

		$this->start_controls_tab( 
			'coupon-button-tab-hover',
			[
				'label' => __( 'Hover', 'woolementor' ),
			]
		);

		$this->add_control(
			'coupon_button_color_hover',
			[
				'label'     => __( 'Text Color', 'woolementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .button.wl-ci-coupon-button:hover' => 'color: {{VALUE}} !important',
				],
			]
		);

		$this->add_control(
			'coupon_button_bg_hover',
			[
				'label'     => __( 'Background', 'woolementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .button.wl-ci-coupon-button:hover' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 		=> 'coupon_button_border_hover',
				'label' 	=> __( 'Border', 'woolementor' ),
				'selector' 	=> '{{WRAPPER}} .button.wl-ci-coupon-button:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();		

		$this->end_controls_section();

		/**
		 * Update Cart Button
		 */
		$this->start_controls_section(
			'section_update_cart_button',
			[
				'label' => __( 'Update Cart Button', 'woolementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'update_cart_button_typography',
				'label'     => __( 'Typography', 'woolementor' ),
				'scheme'    => Typography::TYPOGRAPHY_3,
				'selector'  => '{{WRAPPER}} .button.wl-ci-update-cart-button',
			]
		);

		$this->add_responsive_control(
			'update_cart_button_border_radius',
			[
				'label' 		=> __( 'Border Radius', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%' ],
				'selectors' 	=> [
					'{{WRAPPER}} .button.wl-ci-update-cart-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' 		=> 'update_cart_button_box_shadow',
				'label' 	=> __( 'Box Shadow', 'woolementor' ),
				'selector' 	=> '{{WRAPPER}} .button.wl-ci-update-cart-button',
			]
		);

		$this->add_responsive_control(
			'update_cart_button_padding',
			[
				'label' 		=> __( 'Padding', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .button.wl-ci-update-cart-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
				'separator' => 'before'
			]
		);

		$this->add_responsive_control(
			'update_cart_button_margin',
			[
				'label' 		=> __( 'Margin', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .button.wl-ci-update-cart-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'update-cart-button-tab',
			[
				
				'separator' => 'before'
			]
		);

		$this->start_controls_tab( 
			'update-cart-button-tab-active',
			[
				'label' => __( 'Normal', 'woolementor' ),
			]
		);

		$this->add_control(
			'update_cart_button_color',
			[
				'label'     => __( 'Text Color', 'woolementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .button.wl-ci-update-cart-button' => 'color: {{VALUE}} !important',
				],
			]
		);

		$this->add_control(
			'update_cart_button_bg',
			[
				'label'     => __( 'Background', 'woolementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .button.wl-ci-update-cart-button' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 		=> 'update_cart_button_border',
				'label' 	=> __( 'Border', 'woolementor' ),
				'selector' 	=> '{{WRAPPER}} .button.wl-ci-update-cart-button',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 
			'update-cart-button-tab-hover',
			[
				'label' => __( 'Hover', 'woolementor' ),
			]
		);

		$this->add_control(
			'update_cart_button_color_hover',
			[
				'label'     => __( 'Text Color', 'woolementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .button.wl-ci-update-cart-button:hover' => 'color: {{VALUE}} !important',
				],
			]
		);

		$this->add_control(
			'update_cart_button_bg_hover',
			[
				'label'     => __( 'Background', 'woolementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .button.wl-ci-update-cart-button:hover' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 		=> 'update_cart_button_border_hover',
				'label' 	=> __( 'Border', 'woolementor' ),
				'selector' 	=> '{{WRAPPER}} .button.wl-ci-update-cart-button:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();		


		$this->end_controls_section();

		/**
		 * Proceed to Checkout Button
		 */
		$this->start_controls_section(
			'section_checkout_button',
			[
				'label' => __( 'Checkout Button', 'woolementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'checkout_button_typography',
				'label'     => __( 'Typography', 'woolementor' ),
				'scheme'    => Typography::TYPOGRAPHY_3,
				'selector'  => '{{WRAPPER}} .wl-ci-proceed-to-checkout .button.checkout-button',
			]
		);

		$this->add_responsive_control(
			'checkout_button_border_radius',
			[
				'label' 		=> __( 'Border Radius', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%' ],
				'selectors' 	=> [
					'{{WRAPPER}} .wl-ci-proceed-to-checkout .button.checkout-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' 		=> 'checkout_button_box_shadow',
				'label' 	=> __( 'Box Shadow', 'woolementor' ),
				'selector' 	=> '{{WRAPPER}} .wl-ci-proceed-to-checkout .button.checkout-button',
			]
		);

		$this->add_responsive_control(
			'checkout_button_padding',
			[
				'label' 		=> __( 'Padding', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .wl-ci-proceed-to-checkout .button.checkout-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before'
			]
		);

		$this->add_responsive_control(
			'checkout_button_margin',
			[
				'label' 		=> __( 'Margin', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .wl-ci-proceed-to-checkout .button.checkout-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


		$this->start_controls_tabs( 'checkout-button-tab',
			[
				
				'separator' => 'before'
			]
		);

		$this->start_controls_tab( 
			'checkout-button-tab-active',
			[
				'label' => __( 'Normal', 'woolementor' ),
			]
		);

		$this->add_control(
			'checkout_button_color',
			[
				'label'     => __( 'Text Color', 'woolementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-ci-proceed-to-checkout .button.checkout-button' => 'color: {{VALUE}} !important',
				],
			]
		);

		$this->add_control(
			'checkout_button_bg',
			[
				'label'     => __( 'Background', 'woolementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-ci-proceed-to-checkout .button.checkout-button' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 		=> 'checkout_button_border',
				'label' 	=> __( 'Border', 'woolementor' ),
				'selector' 	=> '{{WRAPPER}} .wl-ci-proceed-to-checkout .button.checkout-button',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 
			'checkout-button-tab-hover',
			[
				'label' => __( 'Hover', 'woolementor' ),
			]
		);

		$this->add_control(
			'checkout_button_color_hover',
			[
				'label'     => __( 'Text Color', 'woolementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-ci-proceed-to-checkout .button.checkout-button:hover' => 'color: {{VALUE}} !important',
				],
			]
		);

		$this->add_control(
			'checkout_button_bg_hover',
			[
				'label'     => __( 'Background', 'woolementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-ci-proceed-to-checkout .button.checkout-button:hover' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 		=> 'checkout_button_border_hover',
				'label' 	=> __( 'Border', 'woolementor' ),
				'selector' 	=> '{{WRAPPER}} .wl-ci-proceed-to-checkout .button.checkout-button:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();	

		$this->end_controls_section();

		/**
		 * Back to shop Button bts
		 */
		$this->start_controls_section(
			'section_bts_button',
			[
				'label' => __( 'Back to Shop Button', 'woolementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'enable_back_to_shop_btn' => 'yes'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'bts_button_typography',
				'label'     => __( 'Typography', 'woolementor' ),
				'scheme'    => Typography::TYPOGRAPHY_3,
				'selector'  => '{{WRAPPER}} .wl-ci button.wl-ci-back-to-shop a',
			]
		);

		$this->add_responsive_control(
			'bts_button_border_radius',
			[
				'label' 		=> __( 'Border Radius', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%' ],
				'selectors' 	=> [
					'{{WRAPPER}} .wl-ci button.wl-ci-back-to-shop' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' 		=> 'bts_button_box_shadow',
				'label' 	=> __( 'Box Shadow', 'woolementor' ),
				'selector' 	=> '{{WRAPPER}} .wl-ci button.wl-ci-back-to-shop',
			]
		);

		$this->add_responsive_control(
			'bts_button_padding',
			[
				'label' 		=> __( 'Padding', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .wl-ci button.wl-ci-back-to-shop' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before'
			]
		);

		$this->add_responsive_control(
			'bts_button_margin',
			[
				'label' 		=> __( 'Margin', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .wl-ci button.wl-ci-back-to-shop' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


		$this->start_controls_tabs( 'bts-button-tab',
			[
				
				'separator' => 'before'
			]
		);

		$this->start_controls_tab( 
			'bts-button-tab-active',
			[
				'label' => __( 'Normal', 'woolementor' ),
			]
		);

		$this->add_control(
			'bts_button_color',
			[
				'label'     => __( 'Text Color', 'woolementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-ci button.wl-ci-back-to-shop a' => 'color: {{VALUE}} !important',
				],
			]
		);

		$this->add_control(
			'bts_button_bg',
			[
				'label'     => __( 'Background', 'woolementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-ci button.wl-ci-back-to-shop' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 		=> 'bts_button_border',
				'label' 	=> __( 'Border', 'woolementor' ),
				'selector' 	=> '{{WRAPPER}} .wl-ci button.wl-ci-back-to-shop',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 
			'bts-button-tab-hover',
			[
				'label' => __( 'Hover', 'woolementor' ),
			]
		);

		$this->add_control(
			'bts_button_color_hover',
			[
				'label'     => __( 'Text Color', 'woolementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-ci button.wl-ci-back-to-shop:hover a' => 'color: {{VALUE}} !important',
				],
			]
		);

		$this->add_control(
			'bts_button_bg_hover',
			[
				'label'     => __( 'Background', 'woolementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-ci button.wl-ci-back-to-shop:hover' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 		=> 'bts_button_border_hover',
				'label' 	=> __( 'Border', 'woolementor' ),
				'selector' 	=> '{{WRAPPER}} .wl-ci button.wl-ci-back-to-shop:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();	

		$this->end_controls_section();

	}

	protected function render() {	

		if( is_order_received_page() ) return;

		if( is_null( WC()->cart ) ) {
			include_once WC_ABSPATH . 'includes/wc-cart-functions.php';
			include_once WC_ABSPATH . 'includes/class-wc-cart.php';
			wc_load_cart();
		}

		$settings = $this->get_settings_for_display();
		extract( $settings );

        $this->render_editing_attributes();

        do_action( 'woocommerce_before_cart' ); ?>

		<div class="wl-ci">
			<div class="wl-ci-product-style">
				<div class="cx-container">
					<div class="cx-row">
						<div class="cx-col-md-12 cx-col-sm-12">
							<div class="woocommerce">
								<form class="woocommerce-cart-form wl-ci-cart-form" action="<?php echo get_permalink(); ?>" method="post">
									<?php 
									do_action( 'woocommerce_before_cart_table' );

									if ( !empty( WC()->cart->get_cart() ) ) : ?>

									<table class="shop_table cart woocommerce-cart-form__contents wl-ci-cart-table" cellspacing="0">
										<thead class="">
											<tr class="wl-ci-heading-nav">

												<th <?php echo $this->get_render_attribute_string( 'product_image_heading' ); ?> ><?php echo esc_html( $product_image_heading ); ?></th>

												<th <?php echo $this->get_render_attribute_string( 'product_name_heading' ); ?> ><?php echo esc_html( $product_name_heading ); ?></th>

												<th <?php echo $this->get_render_attribute_string( 'product_price_heading' ); ?> ><?php echo esc_html( $product_price_heading ); ?></th>

												<th <?php echo $this->get_render_attribute_string( 'product_quantity_heading' ); ?> ><?php echo esc_html( $product_quantity_heading ); ?></th>

												<th <?php echo $this->get_render_attribute_string( 'product_subtotal_heading' ); ?> ><?php echo esc_html( $product_subtotal_heading ); ?></th>

												<th <?php echo $this->get_render_attribute_string( 'product_remove' ); ?>></th>
											</tr>
										</thead>
										<tbody>
											<?php 
											do_action( 'woocommerce_before_cart_contents' );

											foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
												$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
												$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
												$image_url 	= get_the_post_thumbnail_url( $product_id );

												if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
													$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
													?>
													<tr class="woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

														<td class="product-thumbnail wl-ci-product-thumbnail" data-title="<?php esc_attr_e( 'Thumbnail', 'woocommerce' ); ?>">
															<?php $thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key ); ?>

															<?php if ( 'none' == $product_image_click ): ?>
																<?php echo $thumbnail; ?>
															 <?php elseif ( 'zoom' == $product_image_click ) : ?>
																 <a id="wl-sgs-product-image-zoom" href="<?php echo esc_html( $image_url ); ?>">
																 	<?php echo $thumbnail; ?>
																 </a>
															 <?php elseif ( 'product_page' == $product_image_click ) : ?>
																<?php printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail ); ?>
															 <?php endif; ?>
														</td>

														<td class="product-name wl-ci-product-name" data-title="<?php esc_attr_e( 'Product', 'woocommerce' ); ?>">

														<?php
														if ( ! $product_permalink ) {
															echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;' );
														} else {
															echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
														}

														do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );

														// Meta data.
														echo wc_get_formatted_cart_item_data( $cart_item ); // PHPCS: XSS ok.

														// Backorder notification.
														if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
															echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>', $product_id ) );
														}
														?>
															<div <?php echo $this->get_render_attribute_string( 'product_category_show_hide' ); ?>>
																<span>
																	<?php esc_html_e( $product_category_heading, 'woocommerce' ); ?>
																</span>
																 <?php echo wc_get_product_category_list( $product_id ); ?>
																
															</div>
														</td>

														<td class="product-price wl-ci-product-price" data-title="<?php esc_attr_e( 'Price', 'woocommerce' ); ?>">
															<?php
																echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
															?>
														</td>

														<td class="product-quantity wl-ci-product-quantity" data-title="<?php esc_attr_e( 'Quantity', 'woocommerce' ); ?>">

														<?php
														if ( $_product->is_sold_individually() ) {
															$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
														} else {
															$product_quantity = woocommerce_quantity_input(
																array(
																	'input_name'   => "cart[{$cart_item_key}][qty]",
																	'input_value'  => $cart_item['quantity'],
																	'max_value'    => $_product->get_max_purchase_quantity(),
																	'min_value'    => '0',
																	'product_name' => $_product->get_name(),
																),
																$_product,
																false
															);
														}

														echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ); // PHPCS: XSS ok.
														?>
														</td>

														<td class="product-subtotal wl-ci-product-subtotal" data-title="<?php esc_attr_e( 'Subtotal', 'woocommerce' ); ?>">
															<?php
																echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
															?>
														</td>

														<td class="product-remove wl-ci-product-remove">
															<?php
																echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
																	'woocommerce_cart_item_remove_link',
																	sprintf(
																		'<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s"><i class="'. $section_product_remove_icon['value'] .'"></i></a>',
																		esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
																		esc_html__( 'Remove this item', 'woocommerce' ),
																		esc_attr( $product_id ),
																		esc_attr( $_product->get_sku() )
																	),
																	$cart_item_key
																);
															?>
														</td>
													</tr>
													<?php
												}
											}

											do_action( 'woocommerce_cart_contents' );

											if ( !( empty( $coupon_show_hide ) && empty( $update_cart_show_hide ) && empty( $checkout_show_hide ) ) ): ?>
												<tr>
													<td colspan="6" class="actions wl-bottom-actions">

														<?php if ( 'yes' == $coupon_show_hide ):
															if ( wc_coupons_enabled() ) { ?>
																<div class="coupon wl-ci-coupon">
																	<label for="coupon_code"><?php esc_html_e( 'Coupon:', 'woocommerce' ); ?></label> 
																	<input type="text" name="coupon_code" class="wl-ci-coupon-field" id="coupon_code" value="" placeholder="<?php echo esc_attr( $Coupon_button_placeholder ); ?>" />

																	<?php 
																	printf( '<button %1$s type="submit" name="apply_coupon" value="%2$s">%2$s</button>',
																		$this->get_render_attribute_string( 'Coupon_button_name' ),
																		esc_html( $Coupon_button_name )
																	);
																	do_action( 'woocommerce_cart_coupon' ); 
																	?>

																</div>
															<?php }
															endif; ?>

														<div class="wl-ci-btns">

														<?php 
														if ( 'yes' == $update_cart_show_hide ):
															echo "<div>";
															printf( '<button %1$s type="submit" name="update_cart" value="%2$s">%2$s</button>',
																$this->get_render_attribute_string( 'update_cart_button_name' ),
																esc_html( $update_cart_button_name )
															);
															echo "</div>";

														endif;

														if( 'yes' == $enable_back_to_shop_btn ): ?>
															<div class="wl-ci-back-to-shop-btn-area">
																<button class="wl-ci-back-to-shop">
																	<?php 
																	printf( '<a %s href="%s">%s</a>',
																		$this->get_render_attribute_string( 'back_to_shop_btn_txt' ),
																		get_permalink( wc_get_page_id( 'shop' ) ),
																		esc_html( $back_to_shop_btn_txt )
																	);
																	?>
																</button>
															</div>
														<?php endif;

														if ( 'yes' == $checkout_show_hide ): ?>
															<div class="wl-ci-proceed-to-checkout">

																<?php 
																printf( '<a %s href="%s">%s</a>',
																	$this->get_render_attribute_string( 'checkout_button_name' ),
																	get_permalink( wc_get_page_id( 'checkout' ) ),
																	esc_html( $checkout_button_name )
																);
																?>

															</div>
														<?php endif; ?>

														</div>

														<?php 
															do_action( 'woocommerce_cart_actions' );
															wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' );
														?>
													</td>
												</tr>
											<?php endif;
											do_action( 'woocommerce_after_cart_contents' ); ?>

										</tbody>
									</table>

									<?php else:
										if ( !did_action( 'woocommerce_cart_is_empty' ) ) {
											do_action( 'woocommerce_cart_is_empty' );
										}
										if( 'yes' == $enable_back_to_shop_btn ): ?>
											<div class="wl-ci-back-to-shop-btn-area">
												<button class="wl-ci-back-to-shop">
													<?php 
													printf( '<a %s href="%s">%s</a>',
														$this->get_render_attribute_string( 'back_to_shop_btn_txt' ),
														get_permalink( wc_get_page_id( 'shop' ) ),
														esc_html( $back_to_shop_btn_txt )
													);
													?>
												</button>
											</div>
										<?php endif;
									endif;
									do_action( 'woocommerce_after_cart_table' ); ?>
								</form>
							</div>
						</div>

						<?php do_action( 'woocommerce_before_cart_collaterals' ); ?>					

					</div>
				</div>
			</div>
		</div>

		<?php 
	}

	private function render_editing_attributes() {
		$this->add_inline_editing_attributes( 'product_image_heading', 'basic' );
        $this->add_render_attribute( 'product_image_heading', 'class', 'product-thumbnail wl-product-thumbnail wl-ci-heading' );

		$this->add_inline_editing_attributes( 'product_name_heading', 'basic' );
        $this->add_render_attribute( 'product_name_heading', 'class', 'product-name wl-product-name wl-ci-heading' );
        
		$this->add_inline_editing_attributes( 'product_category_show_hide', 'basic' );
        $this->add_render_attribute( 'product_category_show_hide', 'class', 'product-category wl-ci-cart-category' );
        
		$this->add_inline_editing_attributes( 'product_price_heading', 'basic' );
        $this->add_render_attribute( 'product_price_heading', 'class', 'product-price wl-product-price wl-ci-heading' );
        
		$this->add_inline_editing_attributes( 'product_quantity_heading', 'basic' );
        $this->add_render_attribute( 'product_quantity_heading', 'class', 'product-quantity wl-product-quantity wl-ci-heading' );
        
		$this->add_inline_editing_attributes( 'product_subtotal_heading', 'basic' );
        $this->add_render_attribute( 'product_subtotal_heading', 'class', 'product-subtotal wl-product-subtotal wl-ci-heading' );

        $this->add_render_attribute( 'product_remove', 'class', 'product-remove wl-product-remove wl-ci-heading' );
        
		$this->add_inline_editing_attributes( 'Coupon_button_name', 'basic' );
        $this->add_render_attribute( 'Coupon_button_name', 'class', 'button wl-ci-coupon-button' );
        
		$this->add_inline_editing_attributes( 'update_cart_button_name', 'basic' );
        $this->add_render_attribute( 'update_cart_button_name', 'class', 'button wl-ci-update-cart-button' );
        
		$this->add_inline_editing_attributes( 'checkout_button_name', 'basic' );
        $this->add_render_attribute( 'checkout_button_name', 'class', 'button checkout-button alt wc-forward' );
	}
}