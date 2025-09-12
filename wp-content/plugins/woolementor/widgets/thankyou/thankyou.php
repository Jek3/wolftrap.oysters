<?php
namespace codexpert\Woolementor;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use codexpert\Woolementor\Controls\Group_Control_Gradient_Text;

class Thankyou extends Widget_Base {

	public $id;
	protected $form_close='';

	public function __construct( $data = [], $args = null ) {
	    parent::__construct( $data, $args );

	    $this->id = woolementor_get_widget_id( __CLASS__ );
	    $this->widget = woolementor_get_widget( $this->id );
	}

	public function get_script_depends() {
		return [];
	}

	public function get_style_depends() {
		return [];
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
			'thankyou_notice_content',
			[
				'label' => __( 'Thank You Message', 'woolementor' ),
				'tab' 	=> Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'thankyou_notice_description',
			[
				'label' => __( '', 'woolementor' ),
				'type' 	=> Controls_Manager::TEXTAREA,
				'default' => __( 'Thank you. Your order has been received.', 'woolementor' ),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'thankyou_order_info',
			[
				'label' => __( 'Order Info', 'woolementor' ),
				'tab' 	=> Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'thankyou_order_info_title_show',
			[
				'label' => __( 'Show Title', 'woolementor' ),
				'type' 	=> Controls_Manager::SWITCHER,
				'label_on' 	=> __( 'Show', 'woolementor' ),
				'label_off' => __( 'Hide', 'woolementor' ),
				'return_value' 	=> 'yes',
				'default' 		=> 'yes',
			]
		);

		$this->add_control(
			'order_info_title',
			[
				'label' => __( 'Text', 'woolementor' ),
				'type' 	=> Controls_Manager::TEXT,
                'condition' => [
                    'thankyou_order_info_title_show' => 'yes'
                ],
				'default' => __( 'Order Info', 'woolementor' ),
			]
		);


		$this->add_control(
			'order_info_title_tag',
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
                    'thankyou_order_info_title_show' => 'yes'
                ],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'thankyou_notice',
			[
				'label' => __( 'Thank you', 'woolementor' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);



		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'thankyou_notice_typographyrs',
				'label' 	=> __( 'Typography', 'woolementor' ),
				'scheme' 	=> Typography::TYPOGRAPHY_3,
				'selector' 	=> '{{WRAPPER}} .woolementor-notice',
			]
		);

		$this->add_group_control(
			Group_Control_Gradient_Text::get_type(),
			[
				'name' 		=> 'thankyou_notice_color',
				'selector' 	=> '{{WRAPPER}} .woolementor-notice',
			]
		);

		$this->add_control(
            'thankyou_notice_alignment',
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
                    'justify' 	=> [
                        'title' 	=> __( 'Justify', 'woolementor' ),
                        'icon' 		=> 'fa fa-align-justify',
                    ],
                    'right' 	=> [
                        'title' 	=> __( 'Right', 'woolementor' ),
                        'icon' 		=> 'fa fa-align-right',
                    ],
                ],
                'default' 	=> 'left',
                'toggle' 	=> true,
                'selectors' => [
                    '{{WRAPPER}} .woolementor-notice' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' 		=> 'thankyou_notice_background',
				'label' 	=> __( 'Background', 'woolementor' ),
				'types' 	=> [ 'classic', 'gradient' ],
				'separator' => 'before',
				'selector' 	=> '{{WRAPPER}} .woolementor-notice',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 		=> 'thankyou_notice_border',
				'label' 	=> __( 'Border', 'woolementor' ),
				'separator' => 'before',
				'selector' 	=> '{{WRAPPER}} .woolementor-notice',
			]
		);

		$this->add_control(
			'thankyou_notice_border_radius',
			[
				'label' => __( 'Border Radius', 'woolementor' ),
				'type' 	=> Controls_Manager::DIMENSIONS,
				'separator' 	=> 'after',
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .woolementor-notice' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'thankyou_notice_padding',
			[
				'label' => __( 'Padding', 'woolementor' ),
				'type' 	=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .woolementor-notice' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'order_info_title_style',
			[
				'label' => __( 'Order Info Title', 'woolementor' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
                'condition' => [
                    'thankyou_order_info_title_show' => 'yes'
                ],
			]
		);

		$this->add_control(
            'order_info_title_alignment',
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
                    '{{WRAPPER}} .woolementor-thankyou .thankyou_order_info_title' => 'text-align: {{VALUE}};',
                ],
            ]
        );

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'order_info_title_typographyrs',
				'label' 	=> __( 'Typography', 'woolementor' ),
				'scheme' 	=> Typography::TYPOGRAPHY_3,
				'selector' 	=> '{{WRAPPER}} .thankyou_order_info_title',
			]
		);

		$this->add_group_control(
			Group_Control_Gradient_Text::get_type(),
			[
				'name' 		=> 'order_info_title_color',
				'selector' 	=> '{{WRAPPER}} .thankyou_order_info_title',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'order_info_style',
			[
				'label' => __( 'Order Info', 'woolementor' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
                'condition' => [
                    'thankyou_order_info_title_show' => 'yes'
                ],
			]
		);

		$this->add_control(
			'order_info_column',
			[
				'label' => __( 'Column Width', 'woolementor' ),
				'type' 	=> Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' 	=> 50,
						'max' 	=> 900,
						'step' 	=> 5,
					],
					'%' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 130,
				],
				'selectors' => [
					'{{WRAPPER}} .woolementor-order-overview .wl-tnq-order-col1' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'order_info_typographyrs',
				'label' 	=> __( 'Typography', 'woolementor' ),
				'scheme' 	=> Typography::TYPOGRAPHY_3,
				'selector' 	=> '{{WRAPPER}} .woolementor-order-overview',
			]
		);

		$this->add_control(
			'order_info_color',
			[
				'label'     => __( 'Text Color', 'woolementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woolementor-order-overview li' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'order_info_bg_color1',
			[
				'label'     => __( 'Background Color(Odd row)', 'woolementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woolementor-order-overview li:nth-child(odd)' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'order_info_bg_color2',
			[
				'label'     => __( 'Background Color(Even row)', 'woolementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woolementor-order-overview li:nth-child(even)' => 'background: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'order_details_title_style',
			[
				'label' => __( 'Order Details Title', 'woolementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
            'order_details_title_alignment',
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
                    '{{WRAPPER}} .woolementor-thankyou .woocommerce-order-details .woocommerce-order-details__title' => 'text-align: {{VALUE}};',
                ],
            ]
        );

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'order_details_title_typographyrs',
				'label' 	=> __( 'Typography', 'woolementor' ),
				'scheme' 	=> Typography::TYPOGRAPHY_3,
				'selector' 	=> '{{WRAPPER}} .woocommerce-order-details h2',
			]
		);

		$this->add_group_control(
			Group_Control_Gradient_Text::get_type(),
			[
				'name' 		=> 'order_details_title_color',
				'selector' 	=> '{{WRAPPER}} .woocommerce-order-details h2',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'order_details_table_style',
			[
				'label' => __( 'Order Details Table', 'woolementor' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 		=> 'order_details_table_border',
				'label' 	=> __( 'Border', 'woolementor' ),
				'separator' => 'before',
				'selector' 	=> '{{WRAPPER}} .woocommerce-order-details table tr th,
								{{WRAPPER}} .woocommerce-order-details table tr td',
			]
		);

		$this->start_controls_tabs(
			'order_details_table_style_tab'
		);

		$this->start_controls_tab(
			'order_details_table_header',
			[
				'label' => __( 'Header', 'woolementor' ),
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'order_details_th_typographyrs',
				'label' 	=> __( 'Typography', 'woolementor' ),
				'scheme' 	=> Typography::TYPOGRAPHY_3,
				'selector' 	=> '{{WRAPPER}} .woocommerce-order-details table thead tr th',
			]
		);

		$this->add_control(
			'order_details_th_color',
			[
				'label'     => __( 'Color', 'woolementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce-order-details table thead th' => 'color: {{VALUE}}'
				],
			]
		);

		$this->add_control(
			'order_th_bg_color',
			[
				'label'     => __( 'Background Color', 'woolementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce-order-details table thead th' => 'background: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'order_details_table_body',
			[
				'label' => __( 'Body', 'woolementor' ),
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'order_details_tbody_typographyrs',
				'label' 	=> __( 'Typography', 'woolementor' ),
				'scheme' 	=> Typography::TYPOGRAPHY_3,
				'selector' 	=> '{{WRAPPER}} .woocommerce-order-details table tbody tr td',
			]
		);

		$this->add_control(
			'order_details_tbody_color',
			[
				'label'     => __( 'Color', 'woolementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce-order-details table tbody td' => 'color: {{VALUE}}',
					'{{WRAPPER}} .woocommerce-order-details table tbody td a' => 'color: {{VALUE}}'
				],
			]
		);

		$this->add_control(
			'order_tbody_bg_color',
			[
				'label'     => __( 'Background Color', 'woolementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce-order-details table tbody td' => 'background: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'order_details_table_foot',
			[
				'label' => __( 'Footer', 'woolementor' ),
			]
		);


		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'order_details_tfoot_typographyrs',
				'label' 	=> __( 'Typography', 'woolementor' ),
				'scheme' 	=> Typography::TYPOGRAPHY_3,
				'selector' 	=> '{{WRAPPER}} .woocommerce-order-details table tfoot tr th,
								{{WRAPPER}} .woocommerce-order-details table tfoot tr td',
			]
		);

		$this->add_control(
			'order_details_tfoot_color',
			[
				'label'     => __( 'Color', 'woolementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce-order-details table tfoot th' => 'color: {{VALUE}}',
					'{{WRAPPER}} .woocommerce-order-details table tfoot td' => 'color: {{VALUE}}'
				],
			]
		);

		$this->add_control(
			'order_tfoot_bg_color',
			[
				'label'     => __( 'Background Color', 'woolementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce-order-details table tfoot th,
					{{WRAPPER}} .woocommerce-order-details table tfoot td' => 'background: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();

		$this->start_controls_section(
			'thankyou_addresses',
			[
				'label' => __( 'Addresses', 'woolementor' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' 		=> 'thankyou_addresses_background',
				'label' 	=> __( 'Background', 'woolementor' ),
				'types' 	=> [ 'classic', 'gradient' ],
				'selector' 	=> '{{WRAPPER}} .woocommerce-customer-details',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 	=> 'thankyou_addresses_border',
				'label' => __( 'Border', 'woolementor' ),
				'separator' => 'before',
				'selector' 	=> '{{WRAPPER}} .woocommerce-customer-details',
			]
		);

		$this->add_control(
			'thankyou_addresses_border_radius',
			[
				'label' => __( 'Border Radius', 'woolementor' ),
				'type' 	=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'separator' 	=> 'after',
				'selectors' 	=> [
					'{{WRAPPER}} .woocommerce-customer-details' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'thankyou_addresses_padding',
			[
				'label' => __( 'Padding', 'woolementor' ),
				'type' 	=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .woocommerce-customer-details' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs(
			'thankyou_addresses_style_tab'
		);

		$this->start_controls_tab(
			'thankyou_addresses_title',
			[
				'label' => __( 'Titles', 'woolementor' ),
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'thankyou_addresses_title_typographyrs',
				'label' 	=> __( 'Typography', 'woolementor' ),
				'scheme' 	=> Typography::TYPOGRAPHY_3,
				'selector' 	=> '{{WRAPPER}} .woolementor-thankyou .woocommerce-customer-details h2',
			]
		);

		$this->add_group_control(
			Group_Control_Gradient_Text::get_type(),
			[
				'name' 		=> 'thankyou_addresses_title_color',
				'selector' 	=> '{{WRAPPER}} .woolementor-thankyou .woocommerce-customer-details h2',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'thankyou_addresses_content',
			[
				'label' => __( 'Contents', 'woolementor' ),
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'thankyou_addresses_contents_typographyrs',
				'label' 	=> __( 'Typography', 'woolementor' ),
				'scheme' 	=> Typography::TYPOGRAPHY_3,
				'selector' 	=> '{{WRAPPER}} .woolementor-thankyou .woocommerce-customer-details address',
			]
		);

		$this->add_group_control(
			Group_Control_Gradient_Text::get_type(),
			[
				'name' 		=> 'thankyou_addresses_contents_color',
				'selector' 	=> '{{WRAPPER}} .woolementor-thankyou .woocommerce-customer-details address',
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

