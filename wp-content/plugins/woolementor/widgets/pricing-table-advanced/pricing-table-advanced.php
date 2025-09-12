<?php
namespace codexpert\Woolementor;

use Elementor\Repeater;
use Elementor\Widget_Base;
use Elementor\Control_Icon;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use codexpert\Woolementor\Controls\Group_Control_Gradient_Text;

class Pricing_Table_Advanced extends Widget_Base {

	public $id;

	public function __construct( $data = [], $args = null ) {
	    parent::__construct( $data, $args );

	    $this->id = woolementor_get_widget_id( __CLASS__ );
	    $this->widget = woolementor_get_widget( $this->id );
        
        // Are we in debug mode?
        $min = defined( 'WOOLEMENTOR_PRO_DEBUG' ) && WOOLEMENTOR_PRO_DEBUG ? '' : '.min';

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
		 * General controls
		 */
        $this->start_controls_section(
            '_section_general',
            [
                'label' 		=> __( 'General', 'woolementor' ),
                'tab' 			=> Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
			'general_is_featured',
			[
				'label' 		=> __( 'Is Featured?', 'woolementor' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'Show', 'woolementor' ),
				'label_off' 	=> __( 'Hide', 'woolementor' ),
				'return_value' 	=> 'yes',
				'default' 		=> 'yes',
			]
		);

        $this->add_control(
            'general_is_featured_badge_text',
            [
                'label'         => __( 'Badge Text', 'woolementor' ),
                'type'          => Controls_Manager::TEXT,
                'default'       => __( 'Featured', 'woolementor' ),
                'placeholder'   => __( 'Type your title here', 'woolementor' ),
                'condition' => [
                    'general_is_featured' => 'yes'
                ],
            ]
        );

        $this->end_controls_section();

		/**
		 * Header controls
		 */
		$this->start_controls_section(
			'_section_header',
			[
				'label' 		=> __( 'Header Section', 'woolementor' ),
				'tab' 			=> Controls_Manager::TAB_CONTENT,
			]
		);

        $this->add_control(
            'pricing_table_title',
            [
                'label' 		=> __( 'Title', 'woolementor' ),
                'type' 			=> Controls_Manager::TEXT,
                'label_block' 	=> true,
                'default' 		=> __( 'Basic', 'woolementor' ),
                'dynamic' 		=> [
                    'active' => true
                ]
            ]
        );

        $this->add_control(
			'pricing_table_icon',
			[
				'label' 		=> __( 'Icon', 'woolementor' ),
				'type' 			=> Controls_Manager::ICONS,
				'default' 		=> [
					'value' 	=> 'fas fa-star',
					'library' 	=> 'solid',
				],
			]
		);

        $this->end_controls_section();

		$this->start_controls_section(
            '_section_pricing',
            [
                'label' 		=> __( 'Price', 'woolementor' ),
                'tab' 			=> Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'pricing_table_currency',
            [
                'label'         => __( 'Currency', 'woolementor' ),
                'type'          => Controls_Manager::TEXT,
                'default'       => '$',
                'dynamic'       => [
                    'active' => true
                ]
            ]
        );

        $this->add_control(
            'pricing_table_currency_alignment',
            [
                'label' => __( 'Currency Alignment', 'woolementor' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __( 'Left', 'woolementor' ),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'woolementor' ),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'default' => 'left',
                'toggle' => true,
                'separator'=> 'after'
            ]
        );

        $this->add_control(
            'pricing_table_price',
            [
                'label' 		=> __( 'Amount', 'woolementor' ),
                'type' 			=> Controls_Manager::TEXT,
                'default' 		=> '9.99',
                'dynamic' 		=> [
                    'active' => true
                ]
            ]
        );

        $this->add_control(
            'pricing_table_period',
            [
                'label' 		=> __( 'Period', 'woolementor' ),
                'type' 			=> Controls_Manager::TEXT,
                'default' 		=> __( '/month', 'woolementor' ),
                'dynamic' 		=> [
                    'active' => true
                ]
            ]
        );$this->add_control(
            'show_saleprice',
            [
                'label' => __( 'Show Sale Price', 'woolementor' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __( 'On', 'woolementor' ),
                'label_off' => __( 'Off', 'woolementor' ),
                'return_value' => 'yes',
                'default' => '',
            ]
        );

        $this->add_control(
            'pricing_table_sale_price',
            [
                'label'         => __( 'Sale Price', 'woolementor' ),
                'type'          => Controls_Manager::TEXT,
                'default'       => '8.99',
                'condition' => [
                    'show_saleprice' => 'yes'
                ],
                'dynamic'       => [
                    'active' => true
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            '_section_features',
            [
                'label'			 => __( 'Features', 'woolementor' ),
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'pricing_table_features_text',
            [
                'label' 		=> __( 'Text', 'woolementor' ),
                'type' 			=> Controls_Manager::TEXT,
                'default' 		=> __( 'Exciting Feature', 'woolementor' ),
                'label_block'   => 'true',
                'dynamic' 		=> [
                    'active' => true
                ]
            ]
        );

        $repeater->add_control(
            'pricing_table_features_icon',
            [
                'label' 		=> __( 'Icon', 'woolementor' ),
                'type' 			=> Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'default' 		=> [
                    'value' 	=> 'fas fa-check',
                    'library' 	=> 'fa-solid',
                ],
                'recommended' 	=> [
                    'fa-regular' => [
                        'check-square',
                        'window-close',
                    ],
                    'fa-solid' 	=> [
                        'check',
                        'times'
                    ]
                ]
            ]
        );

        $this->add_control(
            'pricing_table_features_list',
            [
                'type' 			=> Controls_Manager::REPEATER,
                'fields' 		=> $repeater->get_controls(),
                'show_label' 	=> false,
                'default' 		=> [
                    [
                        'pricing_table_features_text' => __( 'Standard Feature', 'woolementor' ),
                        'pricing_table_features_icon' => 'fas fa-check',
                    ],
                    [
                        'pricing_table_features_text' => __( 'Another Great Feature', 'woolementor' ),
                        'pricing_table_features_icon' => 'fas fa-check',
                    ],
                    [
                        'pricing_table_features_text' => __( 'Obsolete Feature', 'woolementor' ),
                        'pricing_table_features_icon' => 'fas fa-times',
                    ],
                    [
                        'pricing_table_features_text' => __( 'Extended Free Trial', 'woolementor' ),
                        'pricing_table_features_icon' => 'fas fa-check',
                    ],
                ],
                'title_field' 	=> '{{{pricing_table_features_text}}}',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            '_section_footer',
            [
                'label' 		=> __( 'Footer Button', 'woolementor' ),
                'tab' 			=> Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            '_section_footer_switcher',
            [
                'label'         => __( 'Enable/Disable', 'woolementor' ),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => __( 'Yes', 'your-plugin' ),
                'label_off'     => __( 'No', 'your-plugin' ),
                'return_value'  => 'yes',
                'default'       => 'yes',
            ]
        );

        $this->add_control(
            'pricing_table_footer_button_text',
            [
                'label' 		=> __( 'Button Text', 'woolementor' ),
                'type' 			=> Controls_Manager::TEXT,
                'default' 		=> __( 'Buy This', 'woolementor' ),
                'placeholder' 	=> __( 'Type button text here', 'woolementor' ),
                'label_block' 	=> true,
                'dynamic' 		=> [
                    'active' 	=> true
                ],
                'condition' => [
                    '_section_footer_switcher' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'pricing_table_footer_button_link',
            [
                'label' 		=> __( 'Link', 'woolementor' ),
                'type' 			=> Controls_Manager::URL,
                'label_block' 	=> true,
                'placeholder' 	=> 'https://woolementor.com/',
                'dynamic' 		=> [
                    'active' => true,
                ],
                'condition' => [
                    '_section_footer_switcher' => 'yes'
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            '_section_style_card',
            [
                'label' => __( 'Card', 'woolementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs( 'card-style-tab' );

        $this->start_controls_tab( 
            'card-style-tab-normal',
            [
                'label' => __( 'Normal', 'woolementor' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'pricing_table_box_bg',
                'label' => __( 'Background', 'woolementor' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .wl-pt-single-pricing',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'card_border',
                'label' => __( 'Border', 'woolementor' ),
                'selector' => '{{WRAPPER}} .wl-pt-single-pricing',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab( 
            'card-style-tab-hover',
            [
                'label' => __( 'Hover', 'woolementor' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'pricing_table_box_bg_hover',
                'label' => __( 'Background', 'woolementor' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .wl-pt-single-pricing:hover',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'card_border_hover',
                'label' => __( 'Border', 'woolementor' ),
                'selector' => '{{WRAPPER}} .wl-pt-single-pricing:hover',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_responsive_control(
            'pricing_table_box_margin',
            [
                'label'         => __( 'Margin', 'woolementor' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'separator'     => 'before',
                'size_units'    => [ 'px', '%', 'em' ],
                'selectors'     => [
                    '{{WRAPPER}} .wl-pt-pricing-table-area' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'pricing_table_box_padding',
            [
                'label'         => __( 'Padding', 'woolementor' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%', 'em' ],
                'selectors'     => [
                    '{{WRAPPER}} .wl-pt-single-pricing' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            '_section_style_header',
            [
                'label' => __( 'Header Section', 'woolementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'pricing_table_box_position_x',
            [
                'label' => __( 'Box Position X', 'woolementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .wl-pt-pricing-box' => 'top: {{SIZE}}{{UNIT}};',
                ],
                'range'         => [
                    'px'        => [
                        'min'   => -180,
                        'max'   => 180,
                    ],
                ],
            ]
        );

        $this->add_responsive_control(
            'pricing_table_box_position_y',
            [
                'label' => __( 'Box Position Y', 'woolementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .wl-pt-pricing-box' => 'left: {{SIZE}}{{UNIT}};',
                ],
                'range'         => [
                    'px'        => [
                        'min'   => -180,
                        'max'   => 180,
                    ],
                ],
                'separator' => 'after'
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'pricing_table_icon_box_border',
                'label' => __( 'Border', 'woolementor' ),
                'selector' => '{{WRAPPER}} .wl-pt-pricing-box',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'pricing_table_icon_box_shadow',
                'label' => __( 'Box Shadow', 'woolementor' ),
                'selector' => '{{WRAPPER}} .wl-pt-pricing-box',
            ]
        );

        $this->add_responsive_control(
            'pricing_table_icon_box_padding',
            [
                'label'         => __( 'Padding', 'woolementor' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%', 'em' ],
                'selectors'     => [
                    '{{WRAPPER}} .wl-pt-pricing-box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before'
            ]
        );

        $this->add_responsive_control(
            'pricing_table_icon_box_margin',
            [
                'label'         => __( 'Margin', 'woolementor' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%', 'em' ],
                'selectors'     => [
                    '{{WRAPPER}} .wl-pt-pricing-box' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'pricing_table_is_featured_tabs_hr',
            [
                'type' => Controls_Manager::DIVIDER,
                'style' => 'thick',
            ]
        );

        $this->start_controls_tabs( 'pricing_table_is_featured_tabs' );

        $this->start_controls_tab(
            'pricing_table_is_featured_tabs_normal',
            [
                'label' => __( 'Normal', 'woolementor' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'pricing_table_is_featured_background_normal',
                'label' => __( 'Background', 'woolementor' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .wl-pt-pricing-box',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'pricing_table_is_featured_border_normal',
                'label' => __( 'Border', 'woolementor' ),
                'selector' => '{{WRAPPER}} .wl-pt-pricing-box',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'pricing_table_is_featured_tabs_hover',
            [
                'label' => __( 'Hover', 'woolementor' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'pricing_table_is_featured_background_hover',
                'label' => __( 'Background', 'woolementor' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .wl-pt-single-pricing:hover .wl-pt-pricing-box',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'pricing_table_is_featured_border_hover',
                'label' => __( 'Border', 'woolementor' ),
                'selector' => '{{WRAPPER}} .wl-pt-single-pricing:hover .wl-pt-pricing-box',
            ]
        );


        $this->add_control(
            'pricing_table_is_featured_hover_transition',
            [
                'label'     => __( 'Transition Duration', 'woolementor' ),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px'    => [
                        'max'   => 3,
                        'step'  => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wl-pt-single-pricing:hover .wl-pt-pricing-box' => 'transition-duration: {{SIZE}}s',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        $this->start_controls_section(
            'pricing_table_header_icon',
            [
                'label' => __( 'Icon', 'woolementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'pricing_table_icon_size',
            [
                'label' => __( 'Icon Size', 'woolementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .wl-pt-single-pricing .wl-pt-pricing-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
                'range'         => [
                    'px'        => [
                        'min'   => 1,
                        'max'   => 200,
                    ],
                ],
            ]
        );

        $this->add_control(
            'pricing_table_icon_tabs_hr',
            [
                'type' => Controls_Manager::DIVIDER,
                'style' => 'thick',
            ]
        );

        $this->start_controls_tabs( 'pricing_table_icon_tabs' );

        $this->start_controls_tab(
            'pricing_table_icon_normal',
            [
                'label' => __( 'Normal', 'woolementor' ),
            ]
        );

        $this->add_control(
            'pricing_table_icon_color',
            [
                'label' => __( 'Icon Color', 'woolementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wl-pt-single-pricing .wl-pt-pricing-icon' => 'color: {{VALUE}}',
                ],
                'separator' => 'after'
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'pricing_table_icon_hover',
            [
                'label' => __( 'Hover', 'woolementor' ),
            ]
        );

        $this->add_control(
            'pricing_table_icon_color_hover',
            [
                'label' => __( 'Icon Color', 'woolementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wl-pt-single-pricing:hover .wl-pt-pricing-icon' => 'color: {{VALUE}}',
                ],
                'separator' => 'after'
            ]
        );

        $this->add_control(
            'pricing_table_icon_color_hover_transition',
            [
                'label'     => __( 'Transition Duration', 'woolementor' ),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px'    => [
                        'max'   => 3,
                        'step'  => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wl-pt-single-pricing:hover .wl-pt-pricing-icon' => 'transition-duration: {{SIZE}}s',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'pricing_table_header_title',
            [
                'label' => __( 'Title', 'woolementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'pricing_table_header_typography',
                'selector' => '{{WRAPPER}} .wl-pt-single-pricing .wl-pt-pricing-name',
                'scheme' => Typography::TYPOGRAPHY_3,
            ]
        );

        $this->add_control(
            'pricing_table_header_tabs_hr',
            [
                'type' => Controls_Manager::DIVIDER,
                'style' => 'thick',
            ]
        );

        $this->start_controls_tabs( 'pricing_table_header_tabs' );

        $this->start_controls_tab(
            'pricing_table_header_normal',
            [
                'label' => __( 'Normal', 'woolementor' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Gradient_Text::get_type(),
            [
                'name' => 'pricing_table_header_color',
                'selector' => '{{WRAPPER}} .wl-pt-single-pricing .wl-pt-pricing-name',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'pricing_table_header_hover',
            [
                'label' => __( 'Hover', 'woolementor' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Gradient_Text::get_type(),
            [
                'name' => 'pricing_table_header_color_hover',
                'selector' => '{{WRAPPER}} .wl-pt-single-pricing:hover .wl-pt-pricing-name',
            ]
        );

        $this->add_control(
            'pricing_table_header_color_hover_transition',
            [
                'label'     => __( 'Transition Duration', 'woolementor' ),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px'    => [
                        'max'   => 3,
                        'step'  => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wl-pt-single-pricing:hover .wl-pt-pricing-name' => 'transition-duration: {{SIZE}}s',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        $this->start_controls_section(
            '_section_style_pricing',
            [
                'label' => __( 'Price', 'woolementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            '_heading_price',
            [
                'type' => Controls_Manager::HEADING,
                'label' => __( 'Price', 'woolementor' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'pricing_table_price_typography',
                'selector' => '{{WRAPPER}} .wl-pt-pricing-price',
                'scheme' => Typography::TYPOGRAPHY_3,
            ]
        );

        $this->start_controls_tabs( 'pricing_table_price_normal_tabs' );

        $this->start_controls_tab(
            'pricing_table_price_normal',
            [
                'label' => __( 'Normal', 'woolementor' ),
            ]
        );

        
        $this->add_control(
            'pricing_table_price_color',
            [
                'label' => __( 'Font Color', 'woolementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wl-pt-single-pricing .wl-pt-pricing-price' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'pricing_table_price_hover',
            [
                'label' => __( 'Hover', 'woolementor' ),
            ]
        );

        
        $this->add_control(
            'pricing_table_price_color_hover',
            [
                'label' => __( 'Font Color', 'woolementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wl-pt-single-pricing:hover .wl-pt-pricing-price' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'pricing_table_price_color_hover_transition',
            [
                'label'     => __( 'Transition Duration', 'woolementor' ),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px'    => [
                        'max'   => 3,
                        'step'  => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wl-pt-single-pricing:hover .wl-pt-pricing-price' => 'transition-duration: {{SIZE}}s',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_control(
            '_heading_currency',
            [
                'type' => Controls_Manager::HEADING,
                'label' => __( 'Currency', 'woolementor' ),
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'pricing_table_currency_spacing',
            [
                'label' => __( 'Side Spacing', 'woolementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .wl-pt-regular-price sup' => 'margin-right: {{SIZE}}{{UNIT}};',
                ],
                'range'         => [
                    'px'        => [
                        'min'   => -100,
                        'max'   => 100,
                    ],
                ],
            ]
        );

        $this->add_responsive_control(
            'pricing_table_currency_position',
            [
                'label' => __( 'Currency Position', 'woolementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .wl-pt-regular-price sup' => 'top: {{SIZE}}{{UNIT}};',
                ],
                'range'         => [
                    'px'        => [
                        'min'   => -100,
                        'max'   => 100,
                    ],
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'pricing_table_currency_typography',
                'selector' => '{{WRAPPER}} .wl-pt-regular-price sup',
                'scheme' => Typography::TYPOGRAPHY_3,
            ]
        );

        $this->start_controls_tabs( 'pricing_table_currency_tabs' );

        $this->start_controls_tab(
            'pricing_table_currency_normal',
            [
                'label' => __( 'Normal', 'woolementor' ),
            ]
        );

        
        $this->add_control(
            'pricing_table_currency_color',
            [
                'label' => __( 'Icon Color', 'woolementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wl-pt-regular-price sup' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'pricing_table_currency_hover',
            [
                'label' => __( 'Hover', 'woolementor' ),
            ]
        );

        
        $this->add_control(
            'pricing_table_currency_hover_color',
            [
                'label' => __( 'Icon Color', 'woolementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wl-pt-single-pricing:hover .wl-pt-regular-price sup' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'pricing_table_currency_hover_color_transition',
            [
                'label'     => __( 'Transition Duration', 'woolementor' ),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px'    => [
                        'max'   => 3,
                        'step'  => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wl-pt-single-pricing:hover .wl-pt-regular-price sup' => 'transition-duration: {{SIZE}}s',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_control(
            'pricing_table_heading_period',
            [
                'type' => Controls_Manager::HEADING,
                'label' => __( 'Period', 'woolementor' ),
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'pricing_table_period_spacing',
            [
                'label' => __( 'Side Spacing', 'woolementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .wl-pt-regular-price .wl-pt-pricing-period' => 'margin-left: {{SIZE}}{{UNIT}};',
                ],
                'range'         => [
                    'px'        => [
                        'min'   => -100,
                        'max'   => 100,
                    ],
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'pricing_table_period_typography',
                'selector' => '{{WRAPPER}} .wl-pt-regular-price .wl-pt-pricing-period',
                'scheme' => Typography::TYPOGRAPHY_3,
            ]
        );

        $this->start_controls_tabs( 'pricing_table_period_color_tabs' );

        $this->start_controls_tab(
            'pricing_table_period_normal',
            [
                'label' => __( 'Normal', 'woolementor' ),
            ]
        );

        
        $this->add_control(
            'pricing_table_period_color',
            [
                'label' => __( 'Text Color', 'woolementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wl-pt-regular-price .wl-pt-pricing-period' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'pricing_table_period_hover',
            [
                'label' => __( 'Hover', 'woolementor' ),
            ]
        );

        
        $this->add_control(
            'pricing_table_period_color_hover',
            [
                'label' => __( 'Text Color', 'woolementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wl-pt-single-pricing:hover .wl-pt-regular-price .wl-pt-pricing-period' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'pricing_table_period_color_hover_transition',
            [
                'label'     => __( 'Transition Duration', 'woolementor' ),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px'    => [
                        'max'   => 3,
                        'step'  => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wl-pt-single-pricing:hover .wl-pt-regular-price .wl-pt-pricing-period' => 'transition-duration: {{SIZE}}s',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        $this->start_controls_section(
            '_section_style_sale_pricing',
            [
                'label' => __( 'Sale Price', 'woolementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_saleprice' => 'yes'
                ],
            ]
        );

        $this->add_control(
            '_heading_sale_price',
            [
                'type' => Controls_Manager::HEADING,
                'label' => __( 'Price', 'woolementor' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'pricing_table_sale_price_typography',
                'selector' => '{{WRAPPER}} .wl-pt-pricing-sell-price',
                'scheme' => Typography::TYPOGRAPHY_3,
            ]
        );

        $this->add_control(
            'pricing_table_sale_price_space',
            [
                'label' => __( 'Space Between', 'woolementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wl-pt-sale-price-wrap' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'pricing_table_sale_price_normal_tabs' );

        $this->start_controls_tab(
            'pricing_table_sale_price_normal',
            [
                'label' => __( 'Normal', 'woolementor' ),
            ]
        );

        
        $this->add_control(
            'pricing_table_sale_price_color',
            [
                'label' => __( 'Font Color', 'woolementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wl-pt-pricing-sell-price' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'pricing_table_sale_price_hover',
            [
                'label' => __( 'Hover', 'woolementor' ),
            ]
        );

        
        $this->add_control(
            'pricing_table_sale_price_color_hover',
            [
                'label' => __( 'Font Color', 'woolementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wl-pt-single-pricing:hover .wl-pt-pricing-sell-price' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'pricing_table_sale_price_color_hover_transition',
            [
                'label'     => __( 'Transition Duration', 'woolementor' ),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px'    => [
                        'max'   => 3,
                        'step'  => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wl-pt-single-pricing:hover .wl-pt-pricing-sell-price' => 'transition-duration: {{SIZE}}s',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_control(
            '_heading_sale_currency',
            [
                'type' => Controls_Manager::HEADING,
                'label' => __( 'Currency', 'woolementor' ),
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'pricing_table_sale_currency_spacing',
            [
                'label' => __( 'Side Spacing', 'woolementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .wl-pt-sale-price-wrap sup' => 'margin-right: {{SIZE}}{{UNIT}};',
                ],
                'range'         => [
                    'px'        => [
                        'min'   => -100,
                        'max'   => 100,
                    ],
                ],
            ]
        );

        $this->add_responsive_control(
            'pricing_table_sale_currency_position',
            [
                'label' => __( 'Currency Position', 'woolementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .wl-pt-sale-price-wrap sup' => 'top: {{SIZE}}{{UNIT}};',
                ],
                'range'         => [
                    'px'        => [
                        'min'   => -100,
                        'max'   => 100,
                    ],
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'pricing_table_sale_currency_typography',
                'selector' => '{{WRAPPER}} .wl-pt-sale-price-wrap sup',
                'scheme' => Typography::TYPOGRAPHY_3,
            ]
        );

        $this->start_controls_tabs( 'pricing_table_sale_currency_tabs' );

        $this->start_controls_tab(
            'pricing_table_sale_currency_normal',
            [
                'label' => __( 'Normal', 'woolementor' ),
            ]
        );

        
        $this->add_control(
            'pricing_table_sale_currency_color',
            [
                'label' => __( 'Icon Color', 'woolementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wl-pt-sale-price-wrap sup' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'pricing_table_sale_currency_hover',
            [
                'label' => __( 'Hover', 'woolementor' ),
            ]
        );

        
        $this->add_control(
            'pricing_table_sale_currency_hover_color',
            [
                'label' => __( 'Icon Color', 'woolementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wl-pt-single-pricing:hover .wl-pt-sale-price-wrap sup' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'pricing_table_sale_currency_hover_color_transition',
            [
                'label'     => __( 'Transition Duration', 'woolementor' ),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px'    => [
                        'max'   => 3,
                        'step'  => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wl-pt-single-pricing:hover .wl-pt-sale-price-wrap sup' => 'transition-duration: {{SIZE}}s',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_control(
            'pricing_table_heading_sale_period',
            [
                'type' => Controls_Manager::HEADING,
                'label' => __( 'Period', 'woolementor' ),
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'pricing_table_sale_period_spacing',
            [
                'label' => __( 'Side Spacing', 'woolementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .wl-pt-sale-price-wrap .wl-pt-pricing-period' => 'margin-left: {{SIZE}}{{UNIT}};',
                ],
                'range'         => [
                    'px'        => [
                        'min'   => -100,
                        'max'   => 100,
                    ],
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'pricing_table_sale_period_typography',
                'selector' => '{{WRAPPER}} .wl-pt-sale-price-wrap .wl-pt-pricing-period',
                'scheme' => Typography::TYPOGRAPHY_3,
            ]
        );

        $this->start_controls_tabs( 'pricing_table_saleperiod_color_tabs' );

        $this->start_controls_tab(
            'pricing_table_sale_period_normal',
            [
                'label' => __( 'Normal', 'woolementor' ),
            ]
        );

        
        $this->add_control(
            'pricing_table_sale_period_color',
            [
                'label' => __( 'Text Color', 'woolementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wl-pt-sale-price-wrap .wl-pt-pricing-period' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'pricing_table_sale_period_hover',
            [
                'label' => __( 'Hover', 'woolementor' ),
            ]
        );

        
        $this->add_control(
            'pricing_table_sale_period_color_hover',
            [
                'label' => __( 'Text Color', 'woolementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wl-pt-single-pricing:hover .wl-pt-sale-price-wrap .wl-pt-pricing-period' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'pricing_table_sale_period_color_hover_transition',
            [
                'label'     => __( 'Transition Duration', 'woolementor' ),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px'    => [
                        'max'   => 3,
                        'step'  => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wl-pt-single-pricing:hover .wl-pt-sale-price-wrap .wl-pt-pricing-period' => 'transition-duration: {{SIZE}}s',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        $this->start_controls_section(
            '_section_style_features',
            [
                'label' => __( 'Features', 'woolementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'pricing_table_features_content_heading',
            [
                'type' => Controls_Manager::HEADING,
                'label' => __( 'Features Content', 'woolementor' ),
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'pricing_table_features_content_spacing_x',
            [
                'label' => __( 'Content Position X', 'woolementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .wl-pt-pricing-list' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
                'range'         => [
                    'px'        => [
                        'min'   => -180,
                        'max'   => 180,
                    ],
                ],
            ]
        );

        $this->add_responsive_control(
            'pricing_table_features_content_spacing_y',
            [
                'label' => __( 'Content Position Y', 'woolementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .wl-pt-pricing-list' => 'margin-left: {{SIZE}}{{UNIT}};',
                ],
                'range'         => [
                    'px'        => [
                        'min'   => -180,
                        'max'   => 180,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => -20,
                ],
            ]
        );

        $this->add_control(
            'pricing_table_features_content_align',
            [
                'label' => __( 'Alignment', 'woolementor' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __( 'Left', 'woolementor' ),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'woolementor' ),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'woolementor' ),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'default' => 'center',
                'toggle' => false,
                'selectors' => [
                    '{{WRAPPER}} .wl-pt-pricing-list' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'pricing_table_heading_features_list',
            [
                'type' => Controls_Manager::HEADING,
                'label' => __( 'List', 'woolementor' ),
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'pricing_table_features_list_spacing',
            [
                'label' => __( 'Spacing Between', 'woolementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .wl-pt-pricing-list ul li' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'pricing_table_features_list_color',
            [
                'label' => __( 'Text Color', 'woolementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wl-pt-pricing-list ul li' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'pricing_table_features_list_typography',
                'selector' => '{{WRAPPER}} .wl-pt-pricing-list ul li',
                'scheme' => Typography::TYPOGRAPHY_3,
            ]
        );

        $this->add_control(
            'pricing_table_heading_features_icon',
            [
                'type' => Controls_Manager::HEADING,
                'label' => __( 'Icon', 'woolementor' ),
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'pricing_table_features_icon_spacing',
            [
                'label' => __( 'Side Spacing', 'woolementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .wl-pt-pricing-list ul li i' => 'margin-right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'pricing_table_features_icon_size',
            [
                'label' => __( 'Size', 'woolementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .wl-pt-pricing-list ul li i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'pricing_table_features_icon_color',
            [
                'label' => __( 'Color', 'woolementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wl-pt-pricing-list ul li i' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            '_section_style_footer',
            [
                'label' => __( 'Footer Button', 'woolementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    '_section_footer_switcher' => 'yes'
                ],
            ]
        );

        $this->add_control(
            '_heading_button',
            [
                'type' => Controls_Manager::HEADING,
                'label' => __( 'Button', 'woolementor' ),
            ]
        );

        $this->add_responsive_control(
            'pricing_table_button_height',
            [
                'label' => __( 'Height', 'woolementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .wl-pt-single-pricing a.price-btn' => 'height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}}',
                    // '{{WRAPPER}} .wl-pt-single-pricing a.price-btn' => 'line-height: {{SIZE}}{{UNIT}};',
                ],
                'range'         => [
                    'px'        => [
                        'min'   => 1,
                        'max'   => 300,
                    ],
                ],
            ]
        );

        $this->add_responsive_control(
            'pricing_table_button_width',
            [
                'label' => __( 'Width', 'woolementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .wl-pt-single-pricing a.price-btn' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'range'         => [
                    'px'        => [
                        'min'   => 1,
                        'max'   => 500,
                    ],
                ],
            ]
        );

        $this->add_responsive_control(
            'pricing_table_button_positionX',
            [
                'label' => __( 'Position X', 'woolementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .wl-pt-single-pricing a.price-btn' => 'bottom: {{SIZE}}{{UNIT}};',
                ],
                'range'         => [
                    'px'        => [
                        'min'   => -300,
                        'max'   => 300,
                    ],
                ],
            ]
        );

        $this->add_responsive_control(
            'pricing_table_button_positionY',
            [
                'label' => __( 'Position Y', 'woolementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .wl-pt-single-pricing a.price-btn' => 'left: {{SIZE}}{{UNIT}};',
                ],
                'range'         => [
                    'px'        => [
                        'min'   => -500,
                        'max'   => 500,
                    ],
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'pricing_table_button_border',
                'selector' => '{{WRAPPER}} .wl-pt-single-pricing a.price-btn',
            ]
        );

        $this->add_control(
            'pricing_table_button_border_radius',
            [
                'label' => __( 'Border Radius', 'woolementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .wl-pt-single-pricing a.price-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'pricing_table_button_box_shadow',
                'selector' => '{{WRAPPER}} .wl-pt-single-pricing a.price-btn',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'pricing_table_button_typography',
                'selector' => '{{WRAPPER}} .wl-pt-single-pricing a.price-btn',
                'scheme' => Typography::TYPOGRAPHY_4,
            ]
        );

        $this->add_control(
            'pricing_table_hr',
            [
                'type' => Controls_Manager::DIVIDER,
                'style' => 'thick',
            ]
        );

        $this->start_controls_tabs( 'pricing_table_tabs_button' );

        $this->start_controls_tab(
            'pricing_table_tab_button_normal',
            [
                'label' => __( 'Normal', 'woolementor' ),
            ]
        );

        $this->add_control(
            'pricing_table_button_color',
            [
                'label' => __( 'Text Color', 'woolementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wl-pt-single-pricing a.price-btn' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'pricing_table_button_bg_color',
            [
                'label' => __( 'Background Color', 'woolementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wl-pt-single-pricing a.price-btn' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'pricing_table_tab_button_hover',
            [
                'label' => __( 'Hover', 'woolementor' ),
            ]
        );

        $this->add_control(
            'pricing_table_button_hover_color',
            [
                'label' => __( 'Text Color', 'woolementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wl-pt-single-pricing a.price-btn:hover, {{WRAPPER}} .wl-pt-single-pricing a.price-btn:focus' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'pricing_table_button_hover_bg_color',
            [
                'label' => __( 'Background Color', 'woolementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wl-pt-single-pricing a.price-btn:hover, {{WRAPPER}} .wl-pt-single-pricing a.price-btn:focus' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'pricing_table_button_hover_transition',
            [
                'label'     => __( 'Transition Duration', 'woolementor' ),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px'    => [
                        'max'   => 3,
                        'step'  => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wl-pt-single-pricing a.price-btn:hover' => 'transition-duration: {{SIZE}}s',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_badge',
            [
                'label' => __( 'Badge', 'woolementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'general_is_featured' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'badge_offset_toggle',
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
            'media_offset_x',
            [
                'label'         => __( 'Offset Left', 'woolementor' ),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px'],
                'condition'     => [
                    'badge_offset_toggle' => 'yes'
                ],
                'range'         => [
                    'px'        => [
                        'min'   => -100,
                        'max'   => 350,
                    ],
                ],
                'render_type'   => 'ui',
            ]
        );

        $this->add_responsive_control(
            'media_offset_y',
            [
                'label'         => __( 'Offset Top', 'woolementor' ),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px'],
                'condition'     => [
                    'badge_offset_toggle' => 'yes'
                ],
                'range'         => [
                    'px'        => [
                        'min'   => -100,
                        'max'   => 350,
                    ],
                ],
                'selectors'     => [
                    // Media translate styles
                    '(desktop){{WRAPPER}} .wl-pt-featured-badge-text' => '-ms-transform: translate({{media_offset_x.SIZE || 0}}{{UNIT}}, {{media_offset_y.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{media_offset_x.SIZE || 0}}{{UNIT}}, {{media_offset_y.SIZE || 0}}{{UNIT}}); transform: translate({{media_offset_x.SIZE || 0}}{{UNIT}}, {{media_offset_y.SIZE || 0}}{{UNIT}}) rotate({{sale_ribbon_transform.SIZE}}deg);',
                    '(tablet){{WRAPPER}} .wl-pt-featured-badge-text' => '-ms-transform: translate({{media_offset_x_tablet.SIZE || 0}}{{UNIT}}, {{media_offset_y_tablet.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{media_offset_x_tablet.SIZE || 0}}{{UNIT}}, {{media_offset_y_tablet.SIZE || 0}}{{UNIT}}); transform: translate({{media_offset_x_tablet.SIZE || 0}}{{UNIT}}, {{media_offset_y_tablet.SIZE || 0}}{{UNIT}});',
                    '(mobile){{WRAPPER}} .wl-pt-featured-badge-text' => '-ms-transform: translate({{media_offset_x_mobile.SIZE || 0}}{{UNIT}}, {{media_offset_y_mobile.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{media_offset_x_mobile.SIZE || 0}}{{UNIT}}, {{media_offset_y_mobile.SIZE || 0}}{{UNIT}}); transform: translate({{media_offset_x_mobile.SIZE || 0}}{{UNIT}}, {{media_offset_y_mobile.SIZE || 0}}{{UNIT}});',
                ],
            ]
        );
        $this->end_popover();

        $this->add_responsive_control(
            'badge_width',
            [
                'label'     => __( 'Width', 'woolementor' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units'=> [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .wl-pt-featured-badge-text' => 'width: {{SIZE}}{{UNIT}}',
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
            'badge_transform',
            [
                'label'     => __( 'Transform', 'woolementor' ),
                'type'      => Controls_Manager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}} .wl-pt-featured-badge-text' => '-webkit-transform: rotate({{SIZE}}deg); transform: translate({{media_offset_x.SIZE || 0}}{{UNIT}}, {{media_offset_y.SIZE || 0}}{{UNIT}}) rotate({{SIZE}}deg);',
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
            'badge_font_color',
            [
                'label'     => __( 'Color', 'woolementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wl-pt-featured-badge-text' => 'color: {{VALUE}}',
                ],
                'separator' => 'before'
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'badge_content_typography',
                'label'     => __( 'Typography', 'woolementor' ),
                'scheme'    => Typography::TYPOGRAPHY_1,
                'selector'  => '{{WRAPPER}} .wl-pt-featured-badge-text',
            ]
        );

        $this->add_control(
            'badge_background',
            [
                'label'         => __( 'Background', 'woolementor' ),
                'type'          => Controls_Manager::COLOR,
                'selectors'     => [
                    '{{WRAPPER}} .wl-pt-featured-badge-text' => 'background: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'badge_padding',
            [
                'label'         => __( 'Padding', 'woolementor' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%', 'em' ],
                'selectors'     => [
                    '{{WRAPPER}} .wl-pt-featured-badge-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'badge_border',
                'label'         => __( 'Border', 'woolementor' ),
                'selector'      => '{{WRAPPER}} .wl-pt-featured-badge-text',
                'separator'     => 'before'
            ]
        );

        $this->add_responsive_control(
            'badge_border_radius',
            [
                'label'         => __( 'Border Radius', 'woolementor' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%' ],
                'selectors'     => [
                    '{{WRAPPER}} .wl-pt-featured-badge-text' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
        extract( $settings );

        $this->render_editing_attributes();

        $pt_featured = $general_is_featured == 'yes' ? 'pt-featured' : '';
        ?>

		<div class="wl-pt-pricing-table-area">
			<div class="wl-pt-single-pricing <?php echo esc_attr( $pt_featured  ); ?> ">
				<div class="wl-pt-pricing-box">

                    <?php if ( 'yes' == $general_is_featured ): ?>
                        <span class="wl-pt-featured-badge-text"><?php echo esc_html( $general_is_featured_badge_text ); ?></span>
                    <?php endif; ?>
                    
					<div class="wl-pt-pricing-icon"><i class="<?php echo esc_attr( $pricing_table_icon['value'] ); ?>"></i></div>
					<div <?php echo $this->get_render_attribute_string( 'pricing_table_title' ); ?> ><?php echo esc_html( $pricing_table_title ); ?></div>
					<div class="wl-pt-pricing-wrap">

                        <?php if ( 'left' == $pricing_table_currency_alignment ):

                            echo 'yes' == $show_saleprice ? '<del>' : '' ?>
                            <div class="wl-pt-regular-price ">
                                <sup><?php echo esc_html( $pricing_table_currency ); ?></sup><span <?php echo $this->get_render_attribute_string( 'pricing_table_price' ); ?> ><?php echo esc_html( $pricing_table_price ); ?></span><span <?php echo $this->get_render_attribute_string( 'pricing_table_period' ); ?> ><?php echo esc_html( $pricing_table_period ); ?>
                                    
                                </span>
                            </div>
                            <?php echo 'yes' == $show_saleprice ? '</del>' : '';

                            if( 'yes' == $show_saleprice ): ?>
                                <div class="wl-pt-sale-price-wrap">

                                    <sup><?php echo esc_html( $pricing_table_currency ); ?></sup><span <?php echo $this->get_render_attribute_string( 'pricing_table_sale_price' ); ?> ><?php echo esc_html( $pricing_table_sale_price ); ?></span><span <?php echo $this->get_render_attribute_string( 'pricing_table_period' ); ?> ><?php echo esc_html( $pricing_table_period ); ?>
                                </div>
                            <?php endif;
                        endif;

                        if ( 'right' == $pricing_table_currency_alignment ):
                            echo 'yes' == $show_saleprice ? '<del>' : ''; ?>

                            <div class="wl-pt-regular-price">
                                <span <?php echo $this->get_render_attribute_string( 'pricing_table_price' ); ?> ><?php echo esc_html( $pricing_table_price ); ?></span><sup><?php echo esc_html( $pricing_table_currency ); ?></sup><span <?php echo $this->get_render_attribute_string( 'pricing_table_period' ); ?> ><?php echo esc_html( $pricing_table_period ); ?></span>
                            </div>

                            <?php echo 'yes' == $show_saleprice ? '</del>' : '';

                            if( 'yes' == $show_saleprice ): ?>
                                <div class="wl-pt-sale-price-wrap">
                                    <span <?php echo $this->get_render_attribute_string( 'pricing_table_sale_price' ); ?> ><?php echo esc_html( $pricing_table_sale_price ); ?></span><sup><?php echo esc_html( $pricing_table_currency ); ?></sup><span <?php echo $this->get_render_attribute_string( 'pricing_table_period' ); ?> ><?php echo esc_html( $pricing_table_period ); ?>
                                </div>
                            <?php endif;
                        endif; ?>
                        
                    </div>
				</div>
				<div class="wl-pt-pricing-list">
					<ul>
						<?php foreach ( $settings['pricing_table_features_list'] as $feature ): ?>
							<li><i class="<?php echo esc_attr( $feature['pricing_table_features_icon']['value'] ); ?>"></i><span><?php echo $feature['pricing_table_features_text']; ?></span></li>
						<?php endforeach; ?>
					</ul>
				</div>

                <?php 
                if ( 'yes' == $_section_footer_switcher ):

                    printf( '<a %s>%s</a>',
                        $this->get_render_attribute_string( 'pricing_table_footer_button_text' ),
                        esc_html( $pricing_table_footer_button_text )
                    );

                endif; ?>
				
			</div>
		</div>
		<?php
	}

    private function render_editing_attributes() {
        $settings = $this->get_settings_for_display();
        extract( $settings );

        $btn_url    = $pricing_table_footer_button_link['url'] ;
        $target     = $pricing_table_footer_button_link['is_external'] ? '_blank' : '';
        $nofollow   = $pricing_table_footer_button_link['nofollow'] ? 'nofollow' : '';

        $this->add_inline_editing_attributes( 'pricing_table_title', 'basic' );
        $this->add_render_attribute( 'pricing_table_title', 'class', 'wl-pt-pricing-name' );

        $this->add_inline_editing_attributes( 'pricing_table_price', 'basic' );
        $this->add_render_attribute( 'pricing_table_price', 'class', 'wl-pt-pricing-price' );

        $this->add_inline_editing_attributes( 'pricing_table_sale_price', 'basic' );
        $this->add_render_attribute( 'pricing_table_sale_price', 'class', 'wl-pt-pricing-sell-price' );

        $this->add_inline_editing_attributes( 'pricing_table_period', 'basic' );
        $this->add_render_attribute( 'pricing_table_period', 'class', 'wl-pt-pricing-period' );

        $this->add_inline_editing_attributes( 'pricing_table_footer_button_text', 'none' );
        $this->add_render_attribute( 'pricing_table_footer_button_text', 'class', 'price-btn' );

        $this->add_render_attribute( 'pricing_table_footer_button_text', 'href', $btn_url );
        $this->add_render_attribute( 'pricing_table_footer_button_text', 'target', $target );
        $this->add_render_attribute( 'pricing_table_footer_button_text', 'rel', $nofollow );
    }
}