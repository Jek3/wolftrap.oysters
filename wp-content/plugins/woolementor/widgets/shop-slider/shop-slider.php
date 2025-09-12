<?php
namespace codexpert\Woolementor;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Background;
use codexpert\Woolementor\Controls\Group_Control_Gradient_Text;

class Shop_Slider extends Widget_Base {

	public $id;

	public function __construct( $data = [], $args = null ) {
	    parent::__construct( $data, $args );

	    $this->id 		= woolementor_get_widget_id( __CLASS__ );
	    $this->widget 	= woolementor_get_widget( $this->id );
	    
		// Are we in debug mode?
		$min = defined( 'WOOLEMENTOR_DEBUG' ) && WOOLEMENTOR_DEBUG ? '' : '.min';

		wp_register_style( "woolementor-{$this->id}", plugins_url( "assets/css/style{$min}.css", __FILE__ ), [], '1.1' );
	}

	public function get_script_depends() {
		return [ "woolementor-{$this->id}", 'fancybox', 'slick' ];
	}

	public function get_style_depends() {
		return [ "woolementor-{$this->id}", 'fancybox', 'slick' ];
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
            '_section_settings_slick',
            [
                'label' => __( 'Settings', 'woolementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'animation_speed',
            [
                'label' 		=> __( 'Animation Speed', 'woolementor' ),
                'type' 			=> Controls_Manager::NUMBER,
                'min' 			=> 100,
                'step' 			=> 10,
                'max' 			=> 10000,
                'default' 		=> 300,
                'description' 	=> __( 'Slide speed in milliseconds', 'woolementor' ),
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'autoplay',
            [
                'label' 		=> __( 'Autoplay?', 'woolementor' ),
                'type' 			=> Controls_Manager::SWITCHER,
                'label_on' 		=> __( 'Yes', 'woolementor' ),
                'label_off' 	=> __( 'No', 'woolementor' ),
                'return_value' 	=> 'yes',
                'default' 		=> 'yes',
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'autoplay_speed',
            [
                'label' 		=> __( 'Autoplay Speed', 'woolementor' ),
                'type' 			=> Controls_Manager::NUMBER,
                'min' 			=> 100,
                'step' 			=> 100,
                'max' 			=> 10000,
                'default' 		=> 3000,
                'description' 	=> __( 'Autoplay speed in milliseconds', 'woolementor' ),
                'condition' 	=> [
                    'autoplay' 	=> 'yes'
                ],
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'infinite_loop',
            [
                'label' 		=> __( 'Infinite Loop?', 'woolementor' ),
                'type' 			=> Controls_Manager::SWITCHER,
                'label_on' 		=> __( 'Yes', 'woolementor' ),
                'label_off' 	=> __( 'No', 'woolementor' ),
                'return_value' 	=> true,
                'default' 		=> true,
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'navigation',
            [
                'label' 		=> __( 'Navigation', 'woolementor' ),
                'type' 			=> Controls_Manager::SELECT,
                'options' 		=> [
                    'none' 		=> __( 'None', 'woolementor' ),
                    'arrow' 	=> __( 'Arrow', 'woolementor' ),
                    'dots' 		=> __( 'Dots', 'woolementor' ),
                    'both' 		=> __( 'Arrow & Dots', 'woolementor' ),
                ],
                'default' 		=> 'arrow',
                'frontend_available' => true,
                'style_transfer' => true,
            ]
        );

        $this->add_control(
			'arrow_icon_left',
			[
				'label' 		=> __( 'Arrow Icon Left', 'text-domain' ),
				'type' 			=> Controls_Manager::ICONS,
				'default' 		=> [
					'value' 	=> 'fa fa-chevron-left',
					'library' => 'solid',
				],
				'condition' 	=> [
                    'navigation' => array( 'arrow', 'both' ),
                ],
			]
		);

        $this->add_control(
			'arrow_icon_right',
			[
				'label' 		=> __( 'Arrow Icon Right', 'text-domain' ),
				'type' 			=> Controls_Manager::ICONS,
				'default' 		=> [
					'value' 	=> 'fa fa-chevron-right',
					'library' => 'solid',
				],
				'condition' 	=> [
                    'navigation' => array( 'arrow', 'both' ),
                ],
				'separator' => 'after'
			]
		);

		$this->add_responsive_control(
            'slides_show',
            [
                'label' 		=> __( 'Show at Once', 'woolementor' ),
                'type' 			=> Controls_Manager::NUMBER,
                'max' 			=> 12,
                // 'default' 		=> 2,
				'desktop_default' 	=> 2,
				'tablet_default' 	=> 2,
				'mobile_default' 	=> 1,
                'frontend_available' => true,
            ]
        );

        $this->add_control(
			'slider_alignment',
			[
				'label'		=> __( 'Slider Alignment', 'woolementor' ),
				'type' 		=>Controls_Manager::CHOOSE,
				'options' 	=> [
					'false' => [
						'title' 	=> __( 'Horizontal', 'woolementor' ),
						'icon' 		=> 'fas fa-arrows-alt-h',
					],
					'true' 	=> [
						'title' 	=> __( 'Vertical', 'woolementor' ),
						'icon' 		=> 'fas fa-arrows-alt-v',
					],
				],
				'default' 	=> 'false',
				'toggle'    => false,
			]
		);

        $this->end_controls_section();

		$this->start_controls_section(
			'_section_settings',
			[
				'label' => __( 'Layout', 'woolementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'alignment',
			[
				'label'		=> __( 'Content Alignment', 'woolementor' ),
				'type' 		=>Controls_Manager::CHOOSE,
				'options' 	=> [
					'wl-ssl-left' 	=> [
						'title' 	=> __( 'Left', 'woolementor' ),
						'icon' 		=> 'fa fa-align-left',
					],
					'wl-ssl-right' 	=> [
						'title' 	=> __( 'Right', 'woolementor' ),
						'icon' 		=> 'fa fa-align-right',
					],
				],
				'default' 	=> 'wl-ssl-left',
				'toggle'    => false,
			]
		);

		$this->end_controls_section();

		/**
         * Query controls
         */
        $this->start_controls_section(
            '_query_settings',
            [
                'label' => __( 'Query', 'woolementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'custom_query',
            [
                'label'         => __( 'Custom Query', 'woolementor' ),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => __( 'Yes', 'woolementor' ),
                'label_off'     => __( 'No', 'woolementor' ),
                'return_value'  => 'yes',
                'default'       => 'no',
            ]
        );

        $this->add_control(
            'number',
            [
                'label'     => __( 'Products per page', 'woolementor' ),
                'type'      => Controls_Manager::NUMBER,
                'default'   => 6,
            ]
        );

        $this->add_control(
            'order',
            [
                'label'         => __( 'Order', 'woolementor' ),
                'type'          => Controls_Manager::SELECT,
                'default'       => 'ASC',
                'options'       => [
                    'ASC'       => __( 'ASC', 'woolementor' ),
                    'DESC'      => __( 'DESC', 'woolementor' ),
                ],
            ]
        );

        $this->add_control(
            'orderby',
            [
                'label'         => __( 'Order By', 'woolementor' ),
                'type'          => Controls_Manager::SELECT,
                'default'       => 'ID',
                'options'       => woolementor_order_options(),
            ]
        );

        $this->start_controls_tabs(
            'custom_query_section_separator',
            [
                'separator' => 'before',
                'condition' => [
                    'custom_query' => 'yes'
                ],
            ]
        );

        $this->start_controls_tab(
            'custom_query_section_normal',
            [
                'label'     => __( 'Custom Query', 'woolementor' ),
            ]
        );

        $this->add_control(
            'categories',
            [
                'label'     => __( 'Include Category', 'woolementor' ),
                'type'      => Controls_Manager::SELECT2,
                'options'   => woolementor_get_terms(),
                'multiple'  => true,
                'label_block' => true,
            ]
        );

        $this->add_control(
            'exclude_categories',
            [
                'label'     => __( 'Exclude Categories', 'woolementor' ),
                'type'      => Controls_Manager::SELECT2,
                'options'   => woolementor_get_terms(),
                'multiple'  => true,
                'label_block' => true,
            ]
        );

        $this->add_control(
            'include_products',
            [
                'label'         => __( 'Include Products', 'woolementor' ),
                'type'          => Controls_Manager::TEXT,
                'label_block'   => 'block',
                'description'   => __( 'Separate values with comma delimiter', 'woolementor' ),
            ]
        );

        $this->add_control(
            'exclude_products',
            [
                'label'         => __( 'Exclude Products', 'woolementor' ),
                'type'          => Controls_Manager::TEXT,
                'label_block'   => 'block',
                'description'   => __( 'Separate values with comma delimiter', 'woolementor' ),
            ]
        );

        $this->add_control(
            'sale_products_show_hide',
            [
                'label'         => __( "'On Sale' Products Only", 'woolementor' ),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => __( 'Yes', 'woolementor' ),
                'label_off'     => __( 'No', 'woolementor' ),
                'return_value'  => 'yes',
                'default'       => 'no',
            ]
        );

        $this->add_control(
            'out_of_stock',
            [
                'label'         => __( "Hide Stock out products", 'woolementor' ),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => __( 'Yes', 'woolementor' ),
                'label_off'     => __( 'No', 'woolementor' ),
                'return_value'  => 'yes',
                'default'       => '',
            ]
        );

        $this->add_control(
            'offset',
            [
                'label'         => __( 'Offset', 'woolementor' ),
                'type'          => Controls_Manager::NUMBER,
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

		/**
		 * Image controls
		 */
		$this->start_controls_section(
			'section_content_product_image',
			[
				'label' => __( 'Product Image', 'woolementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'image_on_click',
			[
				'label'     => __( 'On Click', 'woolementor' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'none'          => __( 'None', 'woolementor' ),
					'zoom'          => __( 'Zoom', 'woolementor' ),
					'product_page'  => __( 'Product Page', 'woolementor' ),
				],
				'default'   => 'none',
			]
		);

		$this->end_controls_section();

		/**
		 * Sale Ribbon controls
		 */
		$this->start_controls_section(
			'section_content_sale_ribbon',
			[
				'label' => __( 'Sale Ribbon', 'woolementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'sale_ribbon_show_hide',
			[
				'label' 		=> __( 'Show/Hide', 'woolementor' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'Show', 'woolementor' ),
				'label_off' 	=> __( 'Hide', 'woolementor' ),
				'return_value' 	=> 'yes',
				'default' 		=> 'yes',
			]
		);

		$this->add_control(
			'sale_ribbon_text',
			[
				'label' 		=> __( 'On Sale Test', 'woolementor' ),
				'type' 			=> Controls_Manager::TEXT,
				'default' 		=> __( 'Sale', 'woolementor' ),
				'placeholder' 	=> __( 'Type your title here', 'woolementor' ),
			]
		);

		$this->end_controls_section();

		/**
         * Sale Ribbon controls
         */
        $this->start_controls_section(
            'section_content_stock',
            [
                'label' => __( 'Stock text', 'woolementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'stock_show_hide',
            [
                'label'         => __( 'Show/Hide', 'woolementor' ),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => __( 'Show', 'woolementor' ),
                'label_off'     => __( 'Hide', 'woolementor' ),
                'return_value'  => 'yes',
                'default'       => 'yes',
            ]
        );

        $this->add_control(
            'stock_ribbon_text',
            [
                'label'         => __( 'Text', 'woolementor' ),
                'type'          => Controls_Manager::TEXT,
                'default'       => __( 'Out Of Stock', 'woolementor' ),
                'placeholder'   => __( 'Type your text here', 'woolementor' ),
                'condition' => [
                    'stock_show_hide' => 'yes'
                ],
            ]
        );

        $this->end_controls_section();

		/**
		 * Cart controls
		 */
		$this->start_controls_section(
			'section_content_cart',
			[
				'label' => __( 'Cart', 'woolementor' ) . woolementor_pro_text(),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'cart_show_hide',
			[
				'label' 		=> __( 'Show/Hide', 'woolementor' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'Show', 'woolementor' ),
				'label_off' 	=> __( 'Hide', 'woolementor' ),
				'return_value' 	=> 'yes',
				'default' 		=> 'yes',
			]
		);

		$this->end_controls_section();

		/**
		 * Wishlist controls
		 */
		$this->start_controls_section(
			'section_content_wishlist',
			[
				'label' => __( 'Wishlist', 'woolementor' ) . woolementor_pro_text(),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'wishlist_show_hide',
			[
				'label' 		=> __( 'Show/Hide', 'woolementor' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'Show', 'woolementor' ),
				'label_off' 	=> __( 'Hide', 'woolementor' ),
				'return_value' 	=> 'yes',
				'default' 		=> 'yes',
			]
		);

		$this->end_controls_section();

		/**
		 * Product Style controls
		 */
		$this->start_controls_section(
			'style_section_box',
			[
				'label' => __( 'Card', 'woolementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' 		=> 'widget_box_background',
				'label' 	=> __( 'Background', 'plugin-domain' ),
				'types' 	=> [ 'classic', 'gradient' ],
				'selector' 	=> '{{WRAPPER}} .wl-ssl-single-widget',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 		=> 'widget_box_border',
				'label' 	=> __( 'Border', 'woolementor' ),
				'selector' 	=> '{{WRAPPER}} .wl-ssl-single-widget',
				'separator' => 'before'
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' 		=> 'widget_box_shadow',
				'label' 	=> __( 'Box Shadow', 'woolementor' ),
				'selector' 	=> '{{WRAPPER}} .wl-ssl-single-widget',
			]
		);

		$this->add_responsive_control(
			'widget_box_shadow_margin',
			[
				'label' 		=> __( 'Margin', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .wl-ssl-single-product' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

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
                'selector' => '{{WRAPPER}} .wl-gradient-heading',
            ]
        );

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'title_typography',
				'label' 	=> __( 'Typography', 'woolementor' ),
				'scheme' 	=> Typography::TYPOGRAPHY_1,
				'selector' 	=> '{{WRAPPER}} .wl-ssl-product-name a',
			]
		);

		$this->end_controls_section();

		/**
		 * Product Short Dexcription
		 */
		$this->start_controls_section(
			'section_short_description',
			[
				'label' => __( 'Short Description', 'woolementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'short_description_show_hide',
			[
				'label'         => __( 'Show Content', 'woolementor' ),
				'type'          => Controls_Manager::SWITCHER,
				'label_on'      => __( 'Show', 'your-plugin' ),
				'label_off'     => __( 'Hide', 'your-plugin' ),
				'return_value'  => 'yes',
				'default'       => 'yes',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'short_description_typography',
				'label'     => __( 'Typography', 'woolementor' ),
				'scheme'    => Typography::TYPOGRAPHY_1,
				'selector'  => '{{WRAPPER}} .wl-ssl-product-info .wl-ssl-product-desc p',
			]
		); 

		$this->add_control(
			'short_description_color',
			[
				'label'     => __( 'Color', 'woolementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-ssl-product-info .wl-ssl-product-desc p' => 'color: {{VALUE}}',
				],
			]
		);

        $this->add_control(
			'product_desc_words_count',
			[
				'label' 		=> __( 'Words Count', 'woolementor' ),
				'type' 			=> Controls_Manager::NUMBER,
				'default' 		=> 20,
			]
		);

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
				'label'     => __( 'Color', 'woolementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-ssl-info-icons .wl-ssl-price ' => 'color: {{VALUE}}',
					'{{WRAPPER}} .wl-ssl-info-icons .wl-ssl-price ins' => 'color: {{VALUE}}',
					'{{WRAPPER}} .wl-ssl-info-icons .wl-ssl-price h2 > .amount' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'price_size_typography',
				'label' 	=> __( 'Typography', 'woolementor' ),
				'scheme' 	=> Typography::TYPOGRAPHY_1,
				'selector' 	=> '{{WRAPPER}} .wl-ssl-info-icons .wl-ssl-price ins, {{WRAPPER}} .wl-ssl-info-icons .wl-ssl-price h2 > .amount',
			]
		);    

		$this->add_control(
			'sale_price_show_hide',
			[
				'label'			=> __( 'Show Sale Price', 'woolementor' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'Show', 'your-plugin' ),
				'label_off' 	=> __( 'Hide', 'your-plugin' ),
				'return_value' 	=> 'block',
				'default' 		=> 'none',
				'separator' 	=> 'before',
				'selectors' 	=> [
					'{{WRAPPER}} .wl-ssl-info-icons .wl-ssl-price del' => 'display: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'sale_price_color',
			[
				'label'     => __( 'Color', 'woolementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-ssl-info-icons .wl-ssl-price h2 del .amount' => 'color: {{VALUE}}',
				],
				'condition' => [
					'sale_price_show_hide' => 'block'
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'sale_price_size_typography',
				'label' 	=> __( 'Typography', 'woolementor' ),
				'scheme' 	=> Typography::TYPOGRAPHY_1,
				'selector' 	=> '{{WRAPPER}} .wl-ssl-info-icons .wl-ssl-price h2 del',
				'condition' => [
					'sale_price_show_hide' => 'block'
				],
			]
		);

		$this->end_controls_section();

		/**
		 * Product Currency Symbol
		 */
		$this->start_controls_section(
			'section_style_currency',
			[
				'label' => __( 'Currency Symbol', 'woolementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'price_currency',
			[
				'label'     => __( 'Color', 'woolementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce-Price-currencySymbol' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'price_currency_typography',
				'label' 	=> __( 'Typography', 'woolementor' ),
				'scheme' 	=> Typography::TYPOGRAPHY_1,
				'selector' 	=> '{{WRAPPER}} .woocommerce-Price-currencySymbol',
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

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' 		=> 'image_thumbnail',
				'exclude' 	=> [ 'custom' ],
				'include' 	=> [],
				'default' 	=> 'large',
			]
		);

		$this->add_responsive_control(
			'image_width',
			[
				'label' 	=> __( 'Image Width', 'woolementor' ),
				'type' 		=> Controls_Manager::SLIDER,
				'size_units'=> [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .wl-ssl-product-img img' => 'width: {{SIZE}}{{UNIT}}',
				],
				'range' 	=> [
					'px' 	=> [
						'min' 	=> 1,
						'max' 	=> 500
					],
					'em' 	=> [
						'min' 	=> 1,
						'max' 	=> 30
					]
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
					'{{WRAPPER}} .wl-ssl-product-img img' => 'height: {{SIZE}}{{UNIT}}',
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

		$this->add_responsive_control(
			'image_box_height',
			[
				'label' 	=> __( 'Image Box Height', 'woolementor' ),
				'type' 		=> Controls_Manager::SLIDER,
				'size_units'=> [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .wl-ssl-product-img' => 'height: {{SIZE}}{{UNIT}}',
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
				'selector' 	=> '{{WRAPPER}} .wl-ssl-product-img img',
			]
		);

		$this->add_responsive_control(
			'image_border_radius',
			[
				'label' 		=> __( 'Border Radius', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%' ],
				'selectors' 	=> [
					'{{WRAPPER}} .wl-ssl-product-img img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' 		=> 'image_box_shadow',
				'label' 	=> __( 'Box Shadow', 'woolementor' ),
				'selector' 	=> '{{WRAPPER}} .wl-ssl-product-img img',
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
					'{{WRAPPER}} .wl-ssl-product-img img' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' 		=> 'image_css_filters',
				'selector' 	=> '{{WRAPPER}} .wl-ssl-product-img img',
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
					'{{WRAPPER}} .wl-ssl-product-img img:hover' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' 		=> 'image_css_filters_hover',
				'selector' 	=> '{{WRAPPER}} .wl-ssl-product-img img:hover',
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
					'{{WRAPPER}} .wl-ssl-product-img img:hover' => 'transition-duration: {{SIZE}}s',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_sale_ribbon',
			[
				'label' => __( 'Sale Ribbon', 'woolementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'sale_ribbon_offset_toggle',
			[
				'label' 		=> __( 'Offset', 'woolementor' ),
				'type' 			=> Controls_Manager::POPOVER_TOGGLE,
				'label_off' 	=> __( 'None', 'woolementor' ),
				'label_on' 		=> __( 'Custom', 'woolementor' ),
				'return_value' 	=> 'yes',
			]
		);

		$this->start_popover();

		$this->add_responsive_control(
			'media_offset_x',
			[
				'label' 		=> __( 'Offset Left', 'woolementor' ),
				'type' 			=> Controls_Manager::SLIDER,
				'size_units' 	=> ['px', '%'],
				'condition' 	=> [
					'sale_ribbon_offset_toggle' => 'yes'
				],
				'range' 		=> [
					'px' 		=> [
						'min' 	=> -500,
						'max' 	=> 700,
						'step' 	=> 1,
					],
					'%' 		=> [
						'min' 	=> -100,
						'max' 	=> 150,
						'step' 	=> 1,
					],
				],
				'selectors' 	=> [
					'{{WRAPPER}} .wl-ssl-corner-ribbon' => 'left: {{SIZE}}{{UNIT}}'
				],
				'render_type' 	=> 'ui',
			]
		);

		$this->add_responsive_control(
			'media_offset_y',
			[
				'label' 		=> __( 'Offset Top', 'woolementor' ),
				'type' 			=> Controls_Manager::SLIDER,
				'size_units' 	=> ['px', '%'],
				'condition' 	=> [
					'sale_ribbon_offset_toggle' => 'yes'
				],
				'range' 		=> [
					'px' 		=> [
						'min' 	=> -500,
						'max' 	=> 700,
						'step' 	=> 1,
					],
					'%' 		=> [
						'min' 	=> -100,
						'max' 	=> 150,
						'step' 	=> 1,
					],
				],
				'selectors' 	=> [
					'{{WRAPPER}} .wl-ssl-corner-ribbon' => 'top: {{SIZE}}{{UNIT}}'
				]
			]
		);
		$this->end_popover();

		$this->add_responsive_control(
			'sale_ribbon_width',
			[
				'label' 	=> __( 'Width', 'woolementor' ),
				'type' 		=> Controls_Manager::SLIDER,
				'size_units'=> [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .wl-ssl-corner-ribbon' => 'width: {{SIZE}}{{UNIT}}',
				],
				'range' 	=> [
					'px' 	=> [
						'min' 	=> 50,
						'max' 	=> 500
					]
				],
			]
		);

		$this->add_responsive_control(
			'sale_ribbon_transform',
			[
				'label' 	=> __( 'Transform', 'woolementor' ),
				'type' 		=> Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .wl-ssl-corner-ribbon' => '-webkit-transform: rotate({{SIZE}}deg); transform: translate({{media_offset_x.SIZE || 0}}{{UNIT}}, {{media_offset_y.SIZE || 0}}{{UNIT}}) rotate({{SIZE}}deg);',
				],
				'range' 	=> [
					'px' 	=> [
						'min' 	=> 0,
						'max' 	=> 360
					]
				],
			]
		);

		$this->add_control(
			'sale_ribbon_font_color',
			[
				'label'     => __( 'Color', 'woolementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-ssl-corner-ribbon' => 'color: {{VALUE}}',
				],
				'separator' => 'before'
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'content_typography',
				'label' 	=> __( 'Typography', 'woolementor' ),
				'scheme' 	=> Typography::TYPOGRAPHY_1,
				'selector' 	=> '{{WRAPPER}} .wl-ssl-corner-ribbon',
			]
		);

		$this->add_control(
			'sale_ribbon_background',
			[
				'label' 		=> __( 'Background', 'woolementor' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .wl-ssl-corner-ribbon' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'sale_ribbon_padding',
			[
				'label' 		=> __( 'Padding', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .wl-ssl-corner-ribbon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default'       => [
					'top'           => '0',
					'right'         => '12',
					'bottom'        => '0',
					'left'          => '12',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 			=> 'sale_ribbon_border',
				'label' 		=> __( 'Border', 'woolementor' ),
				'selector' 		=> '{{WRAPPER}} .wl-ssl-corner-ribbon',
				'separator' 	=> 'before'
			]
		);

		$this->add_responsive_control(
			'sale_ribbon_border_radius',
			[
				'label' 		=> __( 'Border Radius', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%' ],
				'selectors' 	=> [
					'{{WRAPPER}} .wl-ssl-corner-ribbon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/**
		* Stock Ribbon Styleing 
		*/

		$this->start_controls_section(
		    'section_style_stock_ribbon',
		    [
		        'label' => __( 'Stock Ribbon', 'woolementor' ),
		        'tab'   => Controls_Manager::TAB_STYLE,
		        'condition' => [
		            'stock_show_hide' => 'yes'
		        ],
		    ]
		);

		$this->add_control(
		    'stock_offset_toggle',
		    [
		        'label'         => __( 'Offset', 'woolementor' ),
		        'type'          => Controls_Manager::POPOVER_TOGGLE,
		        'label_off'     => __( 'None', 'woolementor' ),
		        'label_on'      => __( 'Custom', 'woolementor' ),
		        'return_value'  => 'yes',
		    ]
		);

		$this->start_popover();

		$this->add_responsive_control(
		    'stock_media_offset_x',
		    [
		        'label'         => __( 'Offset Left', 'woolementor' ),
		        'type'          => Controls_Manager::SLIDER,
		        'size_units'    => ['px', '%'],
		        'condition'     => [
		            'stock_offset_toggle' => 'yes'
		        ],
		        'range'         => [
		            'px'        => [
		                'min'   => -1000,
		                'max'   => 1000,
		            ],
		            '%'        => [
		                'min'   => 0,
		                'max'   => 100,
		            ],
		        ],
		        'selectors'     => [
		            '{{WRAPPER}} .wl-ssl-stock' => 'left: {{SIZE}}{{UNIT}}'
		        ],
		        'render_type'   => 'ui',
		    ]
		);

		$this->add_responsive_control(
		    'stock_media_offset_y',
		    [
		        'label'         => __( 'Offset Top', 'woolementor' ),
		        'type'          => Controls_Manager::SLIDER,
		        'size_units'    => ['px', '%'],
		        'condition'     => [
		            'stock_offset_toggle' => 'yes'
		        ],
		        'range'         => [
		            'px'        => [
		                'min'   => -1000,
		                'max'   => 1000,
		            ],
		            '%'        => [
		                'min'   => 0,
		                'max'   => 100,
		            ],
		        ],
		        'selectors'     => [
		            '{{WRAPPER}} .wl-ssl-stock' => 'top: {{SIZE}}{{UNIT}}',
		        ],
		    ]
		);
		$this->end_popover();

		$this->add_responsive_control(
		    'stock_ribbon_width',
		    [
		        'label'     => __( 'Width', 'woolementor' ),
		        'type'      => Controls_Manager::SLIDER,
		        'size_units'=> [ 'px', '%', 'em' ],
		        'selectors' => [
		            '{{WRAPPER}} .wl-ssl-stock' => 'width: {{SIZE}}{{UNIT}}',
		        ],
		        'range'     => [
		            'px'    => [
		                'min'   => 50,
		                'max'   => 500
		            ]
		        ],
		    ]
		);

		$this->add_responsive_control(
		    'stock_ribbon_transform',
		    [
		        'label'     => __( 'Transform', 'woolementor' ),
		        'type'      => Controls_Manager::SLIDER,
		        'selectors' => [
		            '{{WRAPPER}} .wl-ssl-stock' => '-webkit-transform: rotate({{SIZE}}deg); transform: rotate({{SIZE}}deg);',
		        ],
		        'range'     => [
		            'px'    => [
		                'min'   => 0,
		                'max'   => 360
		            ]
		        ],
		    ]
		);

		$this->add_control(
		    'stock_ribbon_font_color',
		    [
		        'label'     => __( 'Color', 'woolementor' ),
		        'type'      => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .wl-ssl-stock' => 'color: {{VALUE}}',
		        ],
		        'separator' => 'before'
		    ]
		);

		$this->add_group_control(
		    Group_Control_Typography::get_type(),
		    [
		        'name'      => 'stock_content_typography',
		        'label'     => __( 'Typography', 'woolementor' ),
		        'scheme'    => Typography::TYPOGRAPHY_3,
		        'selector'  => '{{WRAPPER}} .wl-ssl-stock',
		    ]
		);

		$this->add_control(
		    'stock_ribbon_background',
		    [
		        'label'         => __( 'Background', 'woolementor' ),
		        'type'          => Controls_Manager::COLOR,
		        'selectors'     => [
		            '{{WRAPPER}} .wl-ssl-stock' => 'background: {{VALUE}}',
		        ],
		    ]
		);

		$this->add_responsive_control(
		    'stock_ribbon_padding',
		    [
		        'label'         => __( 'Padding', 'woolementor' ),
		        'type'          => Controls_Manager::DIMENSIONS,
		        'size_units'    => [ 'px', '%', 'em' ],
		        'selectors'     => [
		            '{{WRAPPER}} .wl-ssl-stock' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		        'separator' => 'after'
		    ]
		);

		$this->add_group_control(
		    Group_Control_Border::get_type(),
		    [
		        'name'          => 'stock_ribbon_border',
		        'label'         => __( 'Border', 'woolementor' ),
		        'selector'      => '{{WRAPPER}} .wl-ssl-stock',
		    ]
		);

		$this->add_responsive_control(
		    'stock_ribbon_border_radius',
		    [
		        'label'         => __( 'Border Radius', 'woolementor' ),
		        'type'          => Controls_Manager::DIMENSIONS,
		        'size_units'    => [ 'px', '%' ],
		        'selectors'     => [
		            '{{WRAPPER}} .wl-ssl-stock' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

		$this->end_controls_section();

		/**
		 * Cart Button
		 */
		$this->start_controls_section(
			'section_style_cart',
			[
				'label' 	=> __( 'Cart Button', 'woolementor' ),
				'tab'   	=> Controls_Manager::TAB_STYLE,
				'condition'     => [
				    'cart_show_hide' => 'yes'
				],
			]
		);

		$this->add_control(
            'cart_icon',
            [
                'label'         => __( 'Icon', 'woolementor' ),
                'type'          => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'default'       => [
                    'value'     => 'fa fa-shopping-cart',
                    'library'   => 'fa-solid',
                ],
                'recommended'   => [
                    'fa-regular' => [
                        'luggage-cart',
                        'opencart',
                    ],
                    'fa-solid'  => [
                        'shopping-cart',
                        'cart-arrow-down',
                        'cart-plus',
                        'luggage-cart',
                    ]
                ]
            ]
        );

		$this->add_responsive_control(
			'cart_icon_size',
			[
				'label'     => __( 'Icon Size', 'woolementor' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units'=> [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .wl-ssl-product-cart i' => 'font-size: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->start_controls_tabs(
            'cart_normal_separator',
            [
                'separator' => 'before'
            ]
        );

        $this->start_controls_tab(
            'cart_normal',
            [
                'label'     => __( 'Normal', 'woolementor' ),
            ]
        );

		$this->add_control(
			'cart_icon_color',
			[
				'label'     => __( 'Color', 'woolementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-ssl-product-cart i' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'cart_icon_bg',
			[
				'label'     => __( 'Background', 'woolementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-ssl-product-cart i' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'cart_border',
				'label'         => __( 'Border', 'woolementor' ),
				'selector'      => '{{WRAPPER}} .wl-ssl-product-cart i',
			]
		);

        $this->end_controls_tab();

        $this->start_controls_tab(
            'cart_hover',
            [
                'label'     => __( 'Hover', 'woolementor' ),
            ]
        );

		$this->add_control(
			'cart_icon_color_hover',
			[
				'label'     => __( 'Color', 'woolementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-ssl-product-cart i:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'cart_icon_bg_hover',
			[
				'label'     => __( 'Background', 'woolementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-ssl-product-cart i:hover' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'cart_border_hover',
				'label'         => __( 'Border', 'woolementor' ),
				'selector'      => '{{WRAPPER}} .wl-ssl-product-cart i:hover',
			]
		);

        $this->end_controls_tab();

        $this->start_controls_tab(
            'cart_view_cart',
            [
                'label'     => __( 'View Cart', 'woolementor' ),
            ]
        );

        $this->add_control(
            'cart_icon_color_view_cart',
            [
                'label'     => __( 'Color', 'woolementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .added_to_cart.wc-forward::after' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'cart_icon_bg_view_cart',
            [
                'label'     => __( 'Background', 'woolementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .added_to_cart.wc-forward::after' => 'background: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'cart_border_view_cart',
                'label'         => __( 'Border', 'woolementor' ),
                'selector'      => '{{WRAPPER}} .added_to_cart.wc-forward::after',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

		$this->add_responsive_control(
			'cart_area_size',
			[
				'label'     => __( 'Area Size', 'woolementor' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units'=> [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .wl-ssl-product-cart i' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .added_to_cart.wc-forward::after' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'before'
			]
		);

		$this->add_responsive_control(
			'cart_border_radius',
			[
				'label'         => __( 'Border Radius', 'woolementor' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', '%' ],
				'selectors'     => [
					'{{WRAPPER}} .wl-ssl-product-cart i' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .added_to_cart.wc-forward::after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/**
		 * Wishlist Button
		 */
		$this->start_controls_section(
			'section_style_wishlist',
			[
				'label' => __( 'Wishlist Button', 'woolementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' 	=> [
					'wishlist_show_hide' => 'yes'
				],
			]
		);

		$this->add_control(
            'wishlist_icon',
            [
                'label'         => __( 'Icon', 'woolementor' ),
                'type'          => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'default'       => [
                    'value'     => 'fa fa-heart',
                    'library'   => 'fa-solid',
                ],
                'recommended'   => [
                    'fa-regular' => [
                        'heart',
                    ],
                    'fa-solid'  => [
                        'heart',
                        'heart-broken',
                        'heartbeat',
                    ]
                ]
            ]
        );

		$this->add_responsive_control(
			'wishlist_icon_size',
			[
				'label'     => __( 'Icon Size', 'woolementor' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units'=> [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .wl-ssl-product-fav i' => 'font-size: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->start_controls_tabs(
			'wishlist_style_tabs',
			[
				'separator'		=> 'before',
			]
		);

		$this->start_controls_tab(
			'regular_wishlist_color',
			[
				'label' => __( 'Regular', 'woolementor' ),
			]
		);

		$this->add_control(
			'wishlist_icon_regular_color',
			[
				'label'     => __( 'Color', 'woolementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-ssl-product-fav i' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'wishlist_icon_regular_bg',
			[
				'label'     => __( 'Background', 'woolementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-ssl-product-fav i' => 'background: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'active_wishlist_color',
			[
				'label' => __( 'Active', 'woolementor' ),
			]
		);

		$this->add_control(
			'wishlist_icon_active_color',
			[
				'label'     => __( 'Color', 'woolementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ajax_add_to_wish.fav-item' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'wishlist_icon_active_bg',
			[
				'label'     => __( 'Background', 'woolementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ajax_add_to_wish.fav-item' => 'background: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'wishlist_area_size',
			[
				'label'     => __( 'Area Size', 'woolementor' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units'=> [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .wl-ssl-product-fav i' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
				],
				'separator'		=> 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'wishlist_border',
				'label'         => __( 'Border', 'woolementor' ),
				'selector'      => '{{WRAPPER}} .wl-ssl-product-fav i',
			]
		);

		$this->add_responsive_control(
			'wishlist_border_radius',
			[
				'label'         => __( 'Border Radius', 'woolementor' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', '%' ],
				'selectors'     => [
					'{{WRAPPER}} .wl-ssl-product-fav i' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/**
		 * Navigation - Arrow
		 */
		$this->start_controls_section(
            '_section_style_arrow',
            [
                'label' 		=> __( 'Navigation - Arrow', 'woolementor' ),
                'tab'   		=> Controls_Manager::TAB_STYLE,
				'condition' 	=> [
                    'navigation' => array( 'arrow', 'both' ),
                ],
            ]
        );

        $this->add_control(
            'arrow_position_toggle',
            [
                'label' 		=> __( 'Position', 'woolementor' ),
                'type' 			=> Controls_Manager::POPOVER_TOGGLE,
                'label_off' 	=> __( 'None', 'woolementor' ),
                'label_on' 		=> __( 'Custom', 'woolementor' ),
                'return_value' 	=> 'yes',
            ]
        );

        $this->start_popover();

        $this->add_responsive_control(
            'arrow_position_y',
            [
                'label' 		=> __( 'Vertical', 'woolementor' ),
                'type' 			=> Controls_Manager::SLIDER,
                'size_units' 	=> ['px'],
                'condition' 	=> [
                    'arrow_position_toggle' => 'yes'
                ],
                'range' 		=> [
                    'px' 		=> [
                        'min' 	=> 0,
                        'max' 	=> 500,
                    ],
                ],
                'selectors' 	=> [
                    '{{WRAPPER}} .slick-prev, {{WRAPPER}} .slick-next' => 'top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'arrow_position_x',
            [
                'label' 		=> __( 'Horizontal', 'woolementor' ),
                'type' 			=> Controls_Manager::SLIDER,
                'size_units' 	=> ['px'],
                'condition' 	=> [
                    'arrow_position_toggle' => 'yes'
                ],
                'range' 		=> [
                    'px' 		=> [
                        'min' 	=> -100,
                        'max' 	=> 250,
                    ],
                ],
                'selectors' 	=> [
                    '{{WRAPPER}} .slick-prev' => 'left: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .slick-next' => 'right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_popover();

        $this->add_responsive_control(
			'arrow_icon_size',
			[
				'label'     => __( 'Icon Size', 'woolementor' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units'=> [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .wl-ssl-slider .slick-next' => 'font-size: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .wl-ssl-slider .slick-prev' => 'font-size: {{SIZE}}{{UNIT}}',
				],
			]
		);

        $this->add_responsive_control(
			'arrow_area_size',
			[
				'label'     => __( 'Area Size', 'woolementor' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units'=> [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .wl-ssl-slider .slick-next' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .wl-ssl-slider .slick-prev' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' 			=> 'arrow_border',
                'selector' 		=> '{{WRAPPER}} .slick-prev, {{WRAPPER}} .slick-next',
            ]
        );

        $this->add_responsive_control(
            'arrow_border_radius',
            [
                'label' 		=> __( 'Border Radius', 'woolementor' ),
                'type' 			=> Controls_Manager::DIMENSIONS,
                'size_units' 	=> [ 'px', '%' ],
                'selectors' 	=> [
                    '{{WRAPPER}} .slick-prev, {{WRAPPER}} .slick-next' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
                ],
            ]
        );

        $this->start_controls_tabs( '_tabs_arrow' );

        $this->start_controls_tab(
            '_tab_arrow_normal',
            [
                'label' 		=> __( 'Normal', 'woolementor' ),
            ]
        );

        $this->add_control(
            'arrow_color',
            [
                'label' 		=> __( 'Text Color', 'woolementor' ),
                'type' 			=> Controls_Manager::COLOR,
                'default' 		=> '',
                'selectors' 	=> [
                    '{{WRAPPER}} .slick-prev, {{WRAPPER}} .slick-next' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'arrow_bg_color',
            [
                'label' 		=> __( 'Background Color', 'woolementor' ),
                'type' 			=> Controls_Manager::COLOR,
                'selectors' 	=> [
                    '{{WRAPPER}} .slick-prev, {{WRAPPER}} .slick-next' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            '_tab_arrow_hover',
            [
                'label' => __( 'Hover', 'woolementor' ),
            ]
        );

        $this->add_control(
            'arrow_hover_color',
            [
                'label' => __( 'Text Color', 'woolementor' ),
                'type' 	=> Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .slick-prev:hover, {{WRAPPER}} .slick-next:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'arrow_hover_bg_color',
            [
                'label' => __( 'Background Color', 'woolementor' ),
                'type' 	=> Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .slick-prev:hover, {{WRAPPER}} .slick-next:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'arrow_hover_border_color',
            [
                'label' => __( 'Border Color', 'woolementor' ),
                'type' 	=> Controls_Manager::COLOR,
                'condition' => [
                    'arrow_border_border!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .slick-prev:hover, {{WRAPPER}} .slick-next:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
		 * Navigation - Dots
		 */
        $this->start_controls_section(
            '_section_style_dots',
            [
                'label' => __( 'Navigation - Dots', 'woolementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
				'condition' 	=> [
                    'navigation' => array( 'dots', 'both' ),
                ],
            ]
        );

        $this->add_responsive_control(
			'arrow_dots_size',
			[
				'label'     => __( 'Dots Size', 'woolementor' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units'=> [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .wl-ssl-slider .slick-dots li button::before' => 'font-size: {{SIZE}}{{UNIT}}',
				],
			]
		);

        $this->add_responsive_control(
            'dots_nav_position_y',
            [
                'label' => __( 'Vertical Position', 'woolementor' ),
                'type' 	=> Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => -100,
                        'max' => 500,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .slick-dots' => 'bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'dots_nav_spacing',
            [
                'label' => __( 'Spacing', 'woolementor' ),
                'type' 	=> Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .slick-dots li' => 'margin-right: calc({{SIZE}}{{UNIT}} / 2); margin-left: calc({{SIZE}}{{UNIT}} / 2);',
                ],
            ]
        );

        $this->add_responsive_control(
            'dots_nav_align',
            [
                'label' => __( 'Alignment', 'woolementor' ),
                'type' 	=> Controls_Manager::CHOOSE,
                'label_block' => false,
                'options' => [
                    'left' => [
                        'title' => __( 'Left', 'woolementor' ),
                        'icon' 	=> 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'woolementor' ),
                        'icon' 	=> 'eicon-h-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'woolementor' ),
                        'icon' 	=> 'eicon-h-align-right',
                    ],
                ],
                'toggle' 	=> true,
                'selectors' => [
                    '{{WRAPPER}} .slick-dots' => 'text-align: {{VALUE}}'
                ]
            ]
        );

        $this->start_controls_tabs( '_tabs_dots' );
        $this->start_controls_tab(
            '_tab_dots_normal',
            [
                'label' => __( 'Normal', 'woolementor' ),
            ]
        );

        $this->add_control(
            'dots_nav_color',
            [
                'label' => __( 'Color', 'woolementor' ),
                'type' 	=> Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .slick-dots li button:before' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            '_tab_dots_hover',
            [
                'label' => __( 'Hover', 'woolementor' ),
            ]
        );

        $this->add_control(
            'dots_nav_hover_color',
            [
                'label' => __( 'Color', 'woolementor' ),
                'type' 	=> Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .slick-dots li button:hover:before' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            '_tab_dots_active',
            [
                'label' => __( 'Active', 'woolementor' ),
            ]
        );

        $this->add_control(
            'dots_nav_active_color',
            [
                'label' => __( 'Color', 'woolementor' ),
                'type' 	=> Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .slick-dots .slick-active button:before' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();
	}

	protected function render() {

		$settings 	= $this->get_settings_for_display();
		$id 		= $this->get_id();
        extract( $settings );

        $this->render_editing_attributes();
        
        if ( !woolementor_is_pro_activated() && !woolementor_is_preview_mode() && !woolementor_is_edit_mode() ) {
            $wishlist_show_hide = 'no';
        }

        $products = woolementor_query_products( $settings );
        $user_id  = get_current_user_id();
        $wishlist = woolementor_get_wishlist( $user_id );
        ?>

		<div class="wl-ssl-product-style">
			<div class="cx-container">
				<div class="wl-ssl-slider wl-ssl-slick-<?php echo $id; ?>">

					<?php
					if( $products->have_posts()) : 
						while( $products->have_posts()) : $products->the_post();
							$product_id = get_the_ID();
							$product    = wc_get_product( $product_id );
							$thumbnail  = get_the_post_thumbnail_url( $product_id, $image_thumbnail_size );
							$fav_product= in_array( $product_id, $wishlist );

		                    if ( !empty( $fav_product ) ) {
		                        $fav_item = 'fav-item';
		                    }
		                    else{
		                        $fav_item = '';
		                    }
							?>
							   <div class="wl-ssl-single-product <?php echo esc_attr( $alignment ); ?>">
								  <div class="wl-ssl-single-widget">

									 <?php if ( 'yes' == $sale_ribbon_show_hide && $product->is_on_sale() ): ?>
										<div class="wl-ssl-corner-ribbon">
											<?php
											printf( '<span %1$s>%2$s</span>',
												$this->get_render_attribute_string( 'sale_ribbon_text' ),
												esc_html( $settings['sale_ribbon_text' ] )
											);
											?>
										</div>
									 <?php endif; ?>

									<div class="wl-ssl-product-img">

										 <?php if ( 'none' == $image_on_click ): ?>
											 <img src="<?php echo esc_html( $thumbnail ); ?>" alt="<?php echo esc_attr( $product->get_name() ); ?>"/>  
										 <?php elseif ( 'zoom' == $image_on_click ) : ?>
											 <a id="wl-ssl-product-image-zoom" href="<?php echo esc_html( $thumbnail ); ?>"><img src="<?php echo esc_html( $thumbnail ); ?>" alt=""/></a>
										 <?php elseif ( 'product_page' == $image_on_click ) : ?>
											 <a href="<?php the_permalink(); ?>">
												 <img src="<?php echo esc_html( $thumbnail ); ?>" alt="<?php echo esc_attr( $product->get_name() ); ?>"/>                              
											 </a>
										 <?php endif; ?>

									</div>

									<?php if( 'outofstock' == $product->get_stock_status() && 'yes' == $stock_show_hide ): ?>
									    <div class="wl-ssl-stock">
									        <?php echo $stock_ribbon_text; ?>
									    </div>
									<?php endif; ?>

									 <div class="wl-ssl-product-details">

										<?php if ( 'yes' == $wishlist_show_hide ): ?>
											<div class="wl-ssl-product-fav">
												<i class="<?php echo esc_attr( $wishlist_icon['value'] );?> <?php echo esc_attr( $fav_item ); ?> ajax_add_to_wish" data-product_id="<?php echo $product_id; ?>"></i>
											</div>
										<?php endif; ?>

										<div class="wl-ssl-product-info">
										   <div class="wl-ssl-product-name"><a <?php echo $this->get_render_attribute_string( 'title_gradient_color' ); ?> href="<?php the_permalink(); ?>"><?php echo esc_html( $product->get_name() ); ?></a></div>

										   <?php if( 'yes' == $settings['short_description_show_hide'] ): ?>
											   <div class="wl-ssl-product-desc">
												<p><?php echo wp_trim_words( $product->get_short_description(), $product_desc_words_count ); ?></p>
											   </div>
										   <?php endif; ?>

										</div>
										<div class="wl-ssl-info-icons">
											<div class="wl-ssl-price">
												<h2><?php echo $product->get_price_html(); ?></h2>
											</div>

											<?php if ( 'yes' == $cart_show_hide ):
                                                if( 'simple' == $product->get_type() ) : ?>
													<div class="wl-ssl-product-cart">
														<div class="wl-cart-area">
															<a href="?add-to-cart=<?php echo $product_id; ?>" data-quantity="1" class="product_type_<?php echo esc_attr( $product->get_type() ); ?> add_to_cart_button ajax_add_to_cart" data-product_id="<?php echo $product_id; ?>" ><i class="<?php echo esc_attr( $cart_icon['value'] ); ?>"></i></a>
														</div>
													</div>
												<?php else: ?>
													<div class="wl-ssl-product-cart">
														<a href="<?php echo get_permalink( $product_id ); ?>"><i class="<?php echo esc_attr( $cart_icon['value'] ); ?>"></i></a>
													</div>
												<?php endif;
                                            endif; ?>
										</div>
									 </div>
								  </div>
							   </div>

						<?php endwhile; wp_reset_query(); else: 

						echo '<p>' . __( 'No Product Found!', 'woolementor' ) . '</p>';

					endif; ?>
				</div>
			</div>
		</div>

		<?php
		/**
         * Load Script
         */
        $this->render_script();
	}

	private function render_editing_attributes() {
		$this->add_inline_editing_attributes( 'sale_ribbon_text', 'basic' );
		$this->add_render_attribute( 'title_gradient_color', 'class', 'wl-gradient-heading' );
	}

	protected function render_script() {
		$settings 	= $this->get_settings_for_display();
		$id 		= $this->get_id();
		extract( $settings );

		$slick_config = [
        	'autoplay'			=> $autoplay,
        	'autoplay_speed'	=> $autoplay_speed,
        	'animation_speed'	=> $animation_speed,
        	'infinite_loop'		=> $infinite_loop,
        	'navigation'		=> $navigation,
        	'slides_show'		=> $slides_show,
        	'slides_show_mobile'=> $slides_show_mobile,
        	'slides_show_tablet'=> $slides_show_tablet,
        	'slider_alignment'	=> $slider_alignment,
        	'arrow_icon_left'	=> $arrow_icon_left,
        	'arrow_icon_right'	=> $arrow_icon_right,
        ];
		?>
		<script type="text/javascript">
            jQuery(function($){
            	
            	var config 	= <?php echo json_encode( $slick_config ); ?>;
            	var $loop 	= config.infinite_loop ? true : false;
            	var $autoplay 	= config.autoplay ? true : false;
            	var $slider_alignment 	= config.slider_alignment == 'true' ? true : false;

            	if ( 'none' == config.navigation ) {
            		$arrows = false;
            		$dots 	= false;
            	}
            	else if( 'arrow' == config.navigation ) {
            		$arrows = true;
            		$dots 	= false;
            	}
            	else if( 'dots' == config.navigation ) {
            		$arrows = false;
            		$dots 	= true;
            	}
            	else {
            		$arrows = true;
            		$dots 	= true;
            	}

            	if ( config.arrow_icon_left ) {
            		var $prevArrow = '<button type="button" class="slick-prev"><i class="'+ config.arrow_icon_left.value +'"></i></button>'
            	} else {
            		var $prevArrow = false
            	}

            	if ( config.arrow_icon_right ) {
            		var $nextArrow = '<button type="button" class="slick-next"><i class="'+ config.arrow_icon_right.value +'"></i></button>'
            	} else {
            		var $nextArrow = false
            	}

            	$('.wl-ssl-slick-<?php echo $id; ?>' ).slick({
				  	infinite: $loop,
				  	autoplay: $autoplay,
				  	autoplaySpeed: config.autoplay_speed,
				  	speed: config.animation_speed,
				  	slidesToShow: parseInt(config.slides_show),
				  	slidesToScroll: parseInt(config.slides_show),
				  	arrows: $arrows,
				  	dots: $dots,
				  	vertical: $slider_alignment,
                    prevArrow: $prevArrow,
                    nextArrow: $nextArrow,

                    responsive: [
				    {
				      breakpoint: 1024,
				      settings: {
				        slidesToShow: parseInt(config.slides_show),
				        slidesToScroll: parseInt(config.slides_show),
				      }
				    },
				    {
				      breakpoint: 769,
				      settings: {
				        slidesToShow: parseInt(config.slides_show_tablet),
				        slidesToScroll: parseInt(config.slides_show_tablet),
				      }
				    },
				    {
				      breakpoint: 480,
				      settings: {
				      slidesToShow: parseInt(config.slides_show_mobile),
				        slidesToScroll: parseInt(config.slides_show_mobile),
				      }
				    }
				  ]
				});
            })
        </script>
        <?php
	}
}