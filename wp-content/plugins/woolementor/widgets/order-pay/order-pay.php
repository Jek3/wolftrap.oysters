<?php
namespace codexpert\Woolementor;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use codexpert\Woolementor\Controls\Group_Control_Gradient_Text;

class Order_Pay extends Widget_Base {

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
		return [ "woolementor-{$this->id}", 'wc-checkout' ];
	}

	public function get_style_depends() {
		return [ "woolementor-{$this->id}", 'woocommerce-general', 'woocommerce-layout' ];
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


		$this->start_controls_section(
			'order_notes_title',
			[
				'label' => __( 'Review Section Title', 'woolementor' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
            'order_review_title_show',
            [
                'label'         => __( 'Show/Hide Title', 'woolementor' ),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => __( 'Show', 'woolementor' ),
                'label_off'     => __( 'Hide', 'woolementor' ),
                'return_value'  => 'yes',
                'default'       => 'yes',
            ]
        );
        
		$this->add_control(
		    'order_review_title_text',
		    [
		        'label' 		=> __( 'Text', 'woolementor' ),
		        'type' 			=> Controls_Manager::TEXT,
		        'default' 		=> __( 'Order Review', 'woolementor' ),
                'condition' => [
                    'order_review_title_show' => 'yes'
                ],
		    ]
		);

		$this->add_control(
			'order_review_title_tag',
			[
				'label' 	=> __( 'HTML Tag', 'woolementor' ),
				'type' 		=> Controls_Manager::SELECT,
				'default' 	=> 'h3',
				'options' 	=> [
					'h1'  => __( 'H1', 'woolementor' ),
					'h2'  => __( 'H2', 'woolementor' ),
					'h3'  => __( 'H3', 'woolementor' ),
					'h4'  => __( 'H4', 'woolementor' ),
					'h5'  => __( 'H5', 'woolementor' ),
					'h6'  => __( 'H6', 'woolementor' ),
				],
                'condition' => [
                    'order_review_title_show' => 'yes'
                ],
			]
		);

		$this->add_control(
            'order_review_title_alignment',
            [
                'label' 	   => __( 'Alignment', 'woolementor' ),
                'type' 		   => Controls_Manager::CHOOSE,
                'options' 	   => [
                    'left' 		=> [
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
                'toggle' 	=> true,
                'condition' => [
                    'order_review_title_show' => 'yes'
                ],
                'selectors' => [
                    '{{WRAPPER}} .wl-order-pay-title' => 'text-align: {{VALUE}};',
                ],
            ]
        );

		$this->end_controls_section();

		$this->start_controls_section(
			'order_review_content',
			[
				'label' => __( 'Table Headings', 'woolementor' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
		    'order_review_table_th1',
		    [
		        'label' 		=> __( 'Product Column Heading', 'woolementor' ),
		        'type' 			=> Controls_Manager::TEXT,
		        'default' 		=> __( 'Product', 'woolementor-pro' ),
		        'label_block' 	=> true
		    ]
		);

		$this->add_control(
		    'order_review_table_th2',
		    [
		        'label' 		=> __( 'Price Column Heading', 'woolementor' ),
		        'type' 			=> Controls_Manager::TEXT,
		        'default' 		=> __( 'Subtotal', 'woolementor-pro' ),
		        'label_block' 	=> true
		    ]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'payment_section_title',
			[
				'label' => __( 'Payment Section Title', 'woolementor' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
            'payment_title_show',
            [
                'label'         => __( 'Show/Hide Title', 'woolementor' ),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => __( 'Show', 'woolementor' ),
                'label_off'     => __( 'Hide', 'woolementor' ),
                'return_value'  => 'yes',
                'default'       => 'yes',
            ]
        );

		$this->add_control(
		    'payment_section_title_text',
		    [
		        'label' 		=> __( 'Text', 'woolementor' ),
		        'type' 			=> Controls_Manager::TEXT,
		        'default' 		=> __( 'Payment Methods', 'woolementor' ),
                'condition' => [
                    'payment_title_show' => 'yes'
                ],
		    ]
		);

		$this->add_control(
			'payment_title_tag',
			[
				'label' 	=> __( 'HTML Tag', 'woolementor' ),
				'type' 		=> Controls_Manager::SELECT,
				'default' 	=> 'h3',
				'options' 	=> [
					'h1'  => __( 'H1', 'woolementor' ),
					'h2'  => __( 'H2', 'woolementor' ),
					'h3'  => __( 'H3', 'woolementor' ),
					'h4'  => __( 'H4', 'woolementor' ),
					'h5'  => __( 'H5', 'woolementor' ),
					'h6'  => __( 'H6', 'woolementor' ),
				],
                'condition' => [
                    'payment_title_show' => 'yes'
                ],
			]
		);

		$this->add_control(
            'payment_title_alignment',
            [
                'label' 	   => __( 'Alignment', 'woolementor' ),
                'type' 		   => Controls_Manager::CHOOSE,
                'options' 	   => [
                    'left' 		=> [
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
                'toggle' 	=> true,
                'condition' => [
                    'payment_title_show' => 'yes'
                ],
                'selectors' => [
                    '{{WRAPPER}} .wl-order-pay .wl-op-payments' => 'text-align: {{VALUE}};',
                ],
            ]
        );

		$this->end_controls_section();

		$this->start_controls_section(
			'payment_methods_content',
			[
				'label' => __( 'Order Button', 'woolementor' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		//order_button_text
		$this->add_control(
		    'order_button_text',
		    [
		        'label' 		=> __( 'Button Text', 'woolementor' ),
		        'type' 			=> Controls_Manager::TEXT,
		        'default' 		=> __( 'Pay or orders', 'woolementor' ),
		    ]
		);

		$this->end_controls_section();

		//section title style
		$this->start_controls_section(
			'order_review_title_style',
			[
				'label' => __( 'Review Table Title', 'woolementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'order_review_title_show' => 'yes'
                ],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'order_review_title_typographyrs',
				'label' 	=> __( 'Typography', 'woolementor' ),
				'scheme' 	=> Typography::TYPOGRAPHY_3,
				'selector' 	=> '{{WRAPPER}} .wl-order-pay-title',
			]
		);

		$this->add_group_control(
			Group_Control_Gradient_Text::get_type(),
			[
				'name' => 'order_review_title_color',
				'selector' => '{{WRAPPER}} .wl-order-pay-title',
			]
		);

		$this->end_controls_section();


		/**
		 * Table border controll
		 */
		$this->start_controls_section(
			'order_table_border_style',
			[
				'label' => __( 'Table Sell Border', 'woolementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
		    Group_Control_Border::get_type(),
		    [
		        'name'      => 'table_border_type',
		        'label'     => __( 'Border', 'woolementor' ),
		        'selector'  => '{{WRAPPER}} .wl-order-pay table tr td,
		        				{{WRAPPER}} .wl-order-pay table tr th',
		    ]
		);

		$this->end_controls_section();

		/**
		 * Table Header controll
		 */
		$this->start_controls_section(
			'order_table_header_style',
			[
				'label' => __( 'Table Header', 'woolementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'order_thead_typographyrs',
				'label' 	=> __( 'Typography', 'woolementor' ),
				'scheme' 	=> Typography::TYPOGRAPHY_3,
				'selector' 	=> '{{WRAPPER}} .wl-order-pay thead tr th',
			]
		);


        $this->add_control(
			'order_thead_color',
			[
				'label'     => __( 'Text Color', 'woolementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-order-pay thead tr th' => 'color: {{VALUE}}',
				],
			]
		);

        $this->add_control(
			'order_thead_bg_color',
			[
				'label'     => __( 'Background', 'woolementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-order-pay thead tr th' => 'background-color: {{VALUE}}',
				],
			]
		);


		$this->add_control(
            'order_thead_alignment',
            [
                'label' 	   => __( 'Alignment', 'woolementor' ),
                'type' 		   => Controls_Manager::CHOOSE,
                'options' 	   => [
                    'left' 		=> [
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
                'toggle' 	=> true,
                'selectors' => [
                    '{{WRAPPER}} .wl-order-pay thead tr th' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
        	'order_thead_padding',
        	[
        		'label' => __( 'Padding', 'woolementor' ),
        		'type' => Controls_Manager::DIMENSIONS,
        		'size_units' => [ 'px', '%', 'em' ],
        		'selectors' => [
        			'{{WRAPPER}} .wl-order-pay thead tr th' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        		],
        	]
        );

		$this->end_controls_section();

		/**
		 * Table body controll
		 */
		$this->start_controls_section(
			'order_tbody_style',
			[
				'label' => __( 'Table Body', 'woolementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'order_tbody_typographyrs',
				'label' 	=> __( 'Typography', 'woolementor' ),
				'scheme' 	=> Typography::TYPOGRAPHY_3,
				'selector' 	=> '{{WRAPPER}} .wl-order-pay tbody tr td',
			]
		);


        $this->add_control(
			'order_tbody_color',
			[
				'label'     => __( 'Text Color', 'woolementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-order-pay tbody tr td' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'order_tbody_bg_color',
			[
				'label'     => __( 'Background', 'woolementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-order-pay tbody tr td' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
            'order_tbody_alignment',
            [
                'label' 	   => __( 'Alignment', 'woolementor' ),
                'type' 		   => Controls_Manager::CHOOSE,
                'options' 	   => [
                    'left' 		=> [
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
                'toggle' 	=> true,
                'selectors' => [
                    '{{WRAPPER}} .wl-order-pay tbody tr td' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
        	'order_tbody_padding',
        	[
        		'label' => __( 'Padding', 'woolementor' ),
        		'type' => Controls_Manager::DIMENSIONS,
        		'size_units' => [ 'px', '%', 'em' ],
        		'selectors' => [
        			'{{WRAPPER}} .wl-order-pay table tbody tr td' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        			'{{WRAPPER}} .wl-order-pay table tbody tr td span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        			'{{WRAPPER}} .wl-order-pay table tbody tr td ul' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        		],
        	]
        );

		$this->end_controls_section();


		/**
		 * Table footer controll
		 */
		$this->start_controls_section(
			'order_tfoot_style',
			[
				'label' => __( 'Table Footer', 'woolementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'order_tfoot_typographyrs',
				'label' 	=> __( 'Typography', 'woolementor' ),
				'scheme' 	=> Typography::TYPOGRAPHY_3,
				'selector' 	=> '{{WRAPPER}} .wl-order-pay tfoot tr td,
								{{WRAPPER}} .wl-order-pay tfoot tr th',
			]
		);


        $this->add_control(
			'order_tfoot_color',
			[
				'label'     => __( 'Text Color', 'woolementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-order-pay tfoot tr td,
					 {{WRAPPER}} .wl-order-pay tfoot tr th' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'order_tfoot_bg_color',
			[
				'label'     => __( 'Background', 'woolementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-order-pay tfoot tr td,
					 {{WRAPPER}} .wl-order-pay tfoot tr th' => 'background-color: {{VALUE}}',
				],
			]
		);


		$this->add_control(
            'order_tfoot_alignment',
            [
                'label' 	   => __( 'Alignment', 'woolementor' ),
                'type' 		   => Controls_Manager::CHOOSE,
                'options' 	   => [
                    'left' 		=> [
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
                'toggle' 	=> true,
                'selectors' => [
                    '{{WRAPPER}} .wl-order-pay tfoot tr td,
					 {{WRAPPER}} .wl-order-pay tfoot tr th' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
        	'order_tfoot_padding',
        	[
        		'label' => __( 'Padding', 'woolementor' ),
        		'type' => Controls_Manager::DIMENSIONS,
        		'size_units' => [ 'px', '%', 'em' ],
        		'selectors' => [
        			'{{WRAPPER}} .wl-order-pay tfoot tr td,
					 {{WRAPPER}} .wl-order-pay tfoot tr th' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        		],
        	]
        );

		$this->end_controls_section();

				//section title style
		$this->start_controls_section(
			'payment_title_style',
			[
				'label' => __( 'Payment method Title', 'woolementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'payment_title_show' => 'yes'
                ],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'payment_title_typographyrs',
				'label' 	=> __( 'Typography', 'woolementor' ),
				'scheme' 	=> Typography::TYPOGRAPHY_3,
				'selector' 	=> '{{WRAPPER}} .wl-order-pay .wl-op-payments',
			]
		);

		$this->add_group_control(
			Group_Control_Gradient_Text::get_type(),
			[
				'name' => 'payment_title_color',
				'selector' => '{{WRAPPER}} .wl-order-pay .wl-op-payments',
			]
		);

		$this->add_control(
			'payment_title_margin',
			[
				'label'         => __( 'Margin', 'woolementor' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', '%' ],
				'selectors'     => [
					'{{WRAPPER}} .wl-order-pay .wl-op-payments' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/**
		 * Input Label Color
		 */
		$this->start_controls_section(
			'_pm_footer_style',
			[
				'label' => __( 'Payment Methods', 'woolementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

        $this->add_control(
			'pm_bg_color',
			[
				'label'     => __( 'Section Background Color', 'woolementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-order-pay #payment .wc_payment_methods.payment_methods.methods' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->start_controls_tabs('payement methods');

		$this->start_controls_tab(
		    'pm_titles',
		    [
		        'label' => __( 'Titles', 'woolementor' ),
		    ]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'pm_typographyrs',
				'label' 	=> __( 'Typography', 'woolementor' ),
				'scheme' 	=> Typography::TYPOGRAPHY_3,
				'selector' 	=> '{{WRAPPER}} .wl-order-pay #payment .wc_payment_methods.payment_methods.methods .wc_payment_method label',
			]
		);


        $this->add_control(
			'pm_text_color',
			[
				'label'     => __( 'Text Color', 'woolementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-order-pay #payment .wc_payment_methods.payment_methods.methods .wc_payment_method label' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
		    'pm_contents',
		    [
		        'label' => __( 'Contents', 'woolementor' ),
		    ]
		);


		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'pm_content_typographyrs',
				'label' 	=> __( 'Typography', 'woolementor' ),
				'scheme' 	=> Typography::TYPOGRAPHY_3,
				'selector' 	=> '{{WRAPPER}} .wl-order-pay #payment .wc_payment_methods.payment_methods.methods .wc_payment_method .payment_box',
			]
		);


        $this->add_control(
			'pm_content_color',
			[
				'label'     => __( 'Text Color', 'woolementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-order-pay #payment .wc_payment_methods.payment_methods.methods .wc_payment_method .payment_box' => 'color: {{VALUE}}',
				],
			]
		);

		 $this->add_control(
			'pm_content_bg_color',
			[
				'label'     => __( 'Background Color', 'woolementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-order-pay #payment .wc_payment_methods.payment_methods.methods .wc_payment_method .payment_box' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .wl-order-pay #payment .wc_payment_methods.payment_methods.methods .wc_payment_method .payment_box::before' => 'border-bottom-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();

		//section footer style
		$this->start_controls_section(
			'payment_footer_style',
			[
				'label' => __( 'Footer', 'woolementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'payment_footer_typographyrs',
				'label' 	=> __( 'Typography', 'woolementor' ),
				'scheme' 	=> Typography::TYPOGRAPHY_3,
				'selector' 	=> '{{WRAPPER}} .wl-order-pay .form-row',
			]
		);

		$this->add_control(
			'pm_footer_content_color',
			[
				'label'     => __( 'Background Color', 'woolementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-order-pay .form-row' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'pm_footer_content_text_color',
			[
				'label'     => __( 'Text Color', 'woolementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-order-pay .form-row .woocommerce-terms-and-conditions-wrapper' => 'color: {{VALUE}}',
					'{{WRAPPER}} .wl-order-pay .form-row .woocommerce-terms-and-conditions-wrapper a' => 'color: {{VALUE}}',
					'{{WRAPPER}} .wl-order-pay .form-row .woocommerce-terms-and-conditions-wrapper .woocommerce-terms-and-conditions-link a' => 'color: {{VALUE}}',
					'{{WRAPPER}} .wl-order-pay .form-row .woocommerce-terms-and-conditions-wrapper .woocommerce-privacy-policy-text a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'pm_footer_content_href_color',
			[
				'label'     => __( 'Hyperlink Text Color', 'woolementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-order-pay .form-row .woocommerce-terms-and-conditions-wrapper a' => 'color: {{VALUE}}',
					'{{WRAPPER}} .wl-order-pay .form-row .woocommerce-terms-and-conditions-wrapper .woocommerce-terms-and-conditions-link a' => 'color: {{VALUE}}',
					'{{WRAPPER}} .wl-order-pay .form-row .woocommerce-terms-and-conditions-wrapper .woocommerce-privacy-policy-text a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'payment_btn_style',
			[
				'label' => __( 'Order Button', 'woolementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'payment_btn_typographyrs',
				'label' 	=> __( 'Typography', 'woolementor' ),
				'scheme' 	=> Typography::TYPOGRAPHY_3,
				'selector' 	=> '{{WRAPPER}} .wl-order-pay .form-row .button',
			]
		);

		$this->add_control(
			'pm_btn_padding',
			[
				'label'         => __( 'Padding', 'woolementor' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', '%' ],
				'selectors'     => [
					'{{WRAPPER}} #payment .form-row .button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'pm_btn_border_radius',
			[
				'label'         => __( 'Border Radius', 'woolementor' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', '%' ],
				'selectors'     => [
					'{{WRAPPER}} #payment .form-row .button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs(
			'pm_btn_separator',
			[
				'separator' => 'before'
			]
		);

		$this->start_controls_tab(
			'pm_btn_normal',
			[
				'label'     => __( 'Normal', 'woolementor' ),
			]
		);

		$this->add_control(
			'pm_btn_text_color',
			[
				'label'     => __( 'Color', 'woolementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} #payment .form-row .button' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'pm_btn_color',
			[
				'label'     => __( 'Background', 'woolementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} #payment .form-row .button' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'pm_btn_border',
				'label'         => __( 'Border', 'woolementor' ),
				'selector'      => '{{WRAPPER}} #payment .form-row .button',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'pm_btn_hover',
			[
				'label'     => __( 'Hover', 'woolementor' ),
			]
		);
		
		$this->add_control(
			'pm_btn_text_color_hover',
			[
				'label'     => __( 'Color', 'woolementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} #payment .form-row .button:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'pm_btn_color_hover',
			[
				'label'     => __( 'Background', 'woolementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} #payment .form-row .button:hover' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'pm_btn_border_hover',
				'label'         => __( 'Border', 'woolementor' ),
				'selector'      => '{{WRAPPER}} #payment .form-row .button:hover',
			]
		);

        $this->add_control(
            'pm_btn_border_hover_transition',
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
                    '{{WRAPPER}} #payment .form-row .button:hover' => 'transition-duration: {{SIZE}}s',
                ],
            ]
        );

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
	}

	protected function render() {
        if( !current_user_can( 'edit_pages' ) ) return;

        echo woolementor_notice( sprintf( __( 'This beautiful widget, <strong>%s</strong> is a premium widget. Please upgrade to <strong>%s</strong> or activate your license if you already have upgraded!' ), $this->get_title(), '<a href="https://woolementor.com" target="_blank">Woolementor Pro</a>' ) );

        if( file_exists( dirname( __FILE__ ) . '/assets/img/screenshot.png' ) ) {
            echo "<img src='" . plugins_url( 'assets/img/screenshot.png', __FILE__ ) . "' />";
        }
    }
}

