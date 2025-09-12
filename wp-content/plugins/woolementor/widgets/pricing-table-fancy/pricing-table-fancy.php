<?php
namespace codexpert\Woolementor;

use Elementor\Repeater;
use Elementor\Widget_Base;
use Elementor\Control_Icon;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Color;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use codexpert\Woolementor\Controls\Group_Control_Gradient_Text;

class Pricing_Table_Fancy extends Widget_Base {

	public $id;

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

        /**
         * General controls
         */
        $this->start_controls_section(
            '_section_general',
            [
                'label'         => __( 'General', 'woolementor' ),
                'tab'           => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'general_is_featured',
            [
                'label'         => __( 'Is Featured?', 'woolementor' ),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => __( 'Show', 'woolementor' ),
                'label_off'     => __( 'Hide', 'woolementor' ),
                'return_value'  => 'yes',
                'default'       => 'no',
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
        * Pricing Content controll
        */ 

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
                'default' 		=> '11.99',
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
                'default' 		=> __( 'PER MONTH', 'woolementor' ),
                'dynamic' 		=> [
                    'active' => true
                ]
            ]
        );      
        
        $this->add_control(
            'show_sale_price',
            [
                'label' => __( 'Show sale Price', 'woolementor' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __( 'Show', 'woolementor' ),
                'label_off' => __( 'Hide', 'woolementor' ),
                'return_value' => 'yes',
                'default' => '',
            ]
        );

        $this->add_control(
            'pricing_table_sale_price',
            [
                'label'         => __( 'sale Amount', 'woolementor' ),
                'type'          => Controls_Manager::TEXT,
                'default'       => '9.99',
                'condition' => [
                    'show_sale_price' => 'yes'
                ],
                'dynamic'       => [
                    'active' => true
                ]
            ]
        );

        $this->end_controls_section();

        /**
         * Name content controll
         */
        $this->start_controls_section(
            '_section_header',
            [
                'label'         => __( 'Name', 'woolementor' ),
                'tab'           => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'pricing_table_title',
            [
                'label'         => __( 'Title', 'woolementor' ),
                'type'          => Controls_Manager::TEXT,
                'label_block'   => true,
                'default'       => __( 'fancy Plan', 'woolementor' ),
            ]
        );

        $this->end_controls_section();

        /**
        * Featturs content controll
        */

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
                    'value' 	=> 'fas fa-check-circle',
                    'library' 	=> 'fa-solid',
                ],
            ]
        );

        $repeater->add_control(
            'icon_color',
            [
                'label' => __( 'Icon Color', 'woolementor' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Color::get_type(),
                    'value' => Color::COLOR_1,
                ],
                'default' => '#dd2476',
            ]
        );

        $repeater->add_control(
            'icon_hover_color',
            [
                'label' => __( 'Icon Hover Color', 'woolementor' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Color::get_type(),
                    'value' => Color::COLOR_1,
                ],
                'default' => '#fff',
            ]
        );

        $this->add_control(
            'pricing_table_features',
            [
                'type' 			=> Controls_Manager::REPEATER,
                'fields' 		=> $repeater->get_controls(),
                'show_label' 	=> false,
                'default' 		=> [
                    [
                        'pricing_table_features_text' => __( 'Standard Feature', 'woolementor' ),
                        'pricing_table_features_icon' => 'fas fa-check-circle',
                    ],
                    [
                        'pricing_table_features_text' => __( 'Another Great Feature', 'woolementor' ),
                        'pricing_table_features_icon' => 'fas fa-check-circle',
                    ],
                    [
                        'pricing_table_features_text' => __( 'Obsolete Feature', 'woolementor' ),
                        'pricing_table_features_icon' => 'far fa-times-circle',
                    ],
                    [
                        'pricing_table_features_text' => __( 'Extended Free Trial', 'woolementor' ),
                        'pricing_table_features_icon' => 'fas fa-check-circle',
                    ],
                ],
                'title_field' 	=> '{{{pricing_table_features_text}}}',
            ]
        );

        $this->end_controls_section();

        /**
        * Button content controll
        */

        $this->start_controls_section(
            '_section_footer',
            [
                'label' 		=> __( 'Button', 'woolementor' ),
                'tab' 			=> Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'show_purchase_btn',
            [
                'label' => __( 'Show Button', 'woolementor' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __( 'Show', 'woolementor' ),
                'label_off' => __( 'Hide', 'woolementor' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'pricing_table_btn_text',
            [
                'label'         => __( 'Button Text', 'woolementor' ),
                'type'          => Controls_Manager::TEXT,
                'default'       => __( 'Purchase', 'woolementor' ),
                'placeholder'   => __( 'Type button text here', 'woolementor' ),
                'label_block'   => true,
                'dynamic'       => [
                    'active'    => true
                ],
                'condition' => [
                    'show_purchase_btn' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'pricing_table_btn_link',
            [
                'label'         => __( 'Link', 'woolementor' ),
                'type'          => Controls_Manager::URL,
                'label_block'   => true,
                'placeholder'   => 'https://woolementor.com/',
                'dynamic'       => [
                    'active' => true,
                ],
                'condition' => [
                    'show_purchase_btn' => 'yes'
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

        $this->start_controls_tabs( 'pricing_table_card' );

        $this->start_controls_tab(
            'pricing_table_card_normal',
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
                'selector' => '{{WRAPPER}} .wl-pricing-table-fancy',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'pricing_table_card_hover',
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
                'selector' => '{{WRAPPER}} .wl-pricing-table-fancy:hover',
            ]
        );$this->add_control(
            'pricing_table_box_hover_transition',
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
                    '{{WRAPPER}} .wl-pricing-table-fancy:hover' => 'transition-duration: {{SIZE}}s',
                    '{{WRAPPER}} .wl-pricing-table-fancy:hover .wl-ptf-pricing-area' => 'transition-duration: {{SIZE}}s',
                    '{{WRAPPER}} .wl-pricing-table-fancy:hover .wl-ptff-desc' => 'transition-duration: {{SIZE}}s',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'pricing_table_box_border',
                'label' => __( 'Border', 'woolementor' ),
                'separator' => 'before',
                'selector' => '{{WRAPPER}} .wl-pricing-table-fancy',
            ]
        );

        $this->add_responsive_control(
            'pricing_table_box_border_radius',
            [
                'label'         => __( 'Border Radius', 'woolementor' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%', 'em' ],
                'selectors'     => [
                    '{{WRAPPER}} .wl-pricing-table-fancy' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'      => 'pricing_table_box_shadow',
                'label'     => __( 'Box Shadow', 'woolementor' ),
                'selector'  => '{{WRAPPER}} .wl-pricing-table-fancy',
            ]
        );

        $this->add_responsive_control(
            'pricing_table_box_padding',
            [
                'label'         => __( 'Padding', 'woolementor' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%', 'em' ],
                'separator'     => 'before',
                'selectors'     => [
                    '{{WRAPPER}} .wl-pricing-table-fancy' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'pricing_table_box_margin',
            [
                'label'         => __( 'Margin', 'woolementor' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%', 'em' ],
                'selectors'     => [
                    '{{WRAPPER}} .wl-pricing-table-fancy' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        /**
        *Regular Price styling
        */

        $this->start_controls_section(
            '_section_style_price',
            [
                'label' => __( 'Price', 'woolementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'pricing_table_price_box_width',
            [
                'label'     => __( 'Width', 'woolementor' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units'=> [ 'px', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .wl-ptf-pricing-area' => 'width: {{SIZE}}{{UNIT}};',
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
            'pricing_table_price_box_height',
            [
                'label'     => __( 'Height', 'woolementor' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units'=> [ 'px', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .wl-ptf-pricing-area' => 'height: {{SIZE}}{{UNIT}} !important;',
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

        $this->add_control(
            'sale_ribbon_offset_toggle',
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
            'price_box_offset_x',
            [
                'label'         => __( 'Offset Left', 'woolementor' ),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px'],
                'condition'     => [
                    'sale_ribbon_offset_toggle' => 'yes'
                ],
                'range'         => [
                    'px'        => [
                        'min'   => -1000,
                        'max'   => 1000,
                    ],
                ],
                'selectors'     => [
                    '{{WRAPPER}} .wl-ptf-pricing-area' => 'margin-left: {{SIZE}}{{UNIT}}'
                ],
                'render_type'   => 'ui',
            ]
        );

        $this->add_responsive_control(
            'price_box_offset_y',
            [
                'label'         => __( 'Offset Top', 'woolementor' ),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px'],
                'condition'     => [
                    'sale_ribbon_offset_toggle' => 'yes'
                ],
                'range'         => [
                    'px'        => [
                        'min'   => -1000,
                        'max'   => 1000,
                    ],
                ],
                'selectors'     => [
                    '{{WRAPPER}} .wl-ptf-pricing-area' => 'margin-top: {{SIZE}}{{UNIT}}',
                ],
            ]
        );
        $this->end_popover();

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'price_typography',
                'label'     => __( 'Typography', 'woolementor' ),
                'scheme'    => Typography::TYPOGRAPHY_3,
                'selector'  => '{{WRAPPER}} .wl-ptf-fancy-price',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'pricing_table_price_box_border',
                'label' => __( 'Border', 'woolementor' ),
                'separator' => 'before',
                'selector' => '{{WRAPPER}} .wl-ptf-pricing-area',
            ]
        );

        $this->add_responsive_control(
            'pricing_table_price_box_border_radius',
            [
                'label'         => __( 'Border Radius', 'woolementor' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%', 'em' ],
                'selectors'     => [
                    '{{WRAPPER}} .wl-ptf-pricing-area' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'      => 'pricing_table_price_box_shadow',
                'label'     => __( 'Box Shadow', 'woolementor' ),
                'selector'  => '{{WRAPPER}} .wl-ptf-pricing-area',
            ]
        );

        $this->start_controls_tabs( 'pricing_table_price_tab' );

        $this->start_controls_tab(
            'pricing_table_price_normal',
            [
                'label' => __( 'Normal', 'woolementor' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'pricing_table_price_box_bg',
                'label' => __( 'Background', 'woolementor' ),
                'types' => [ 'classic', 'gradient' ],
                'separator' => 'before',
                'selector' => '{{WRAPPER}} .wl-ptf-pricing-area',
            ]
        );

        $this->add_group_control(
            Group_Control_Gradient_Text::get_type(),
            [
                'name' => 'price_gradient_color',
                'selector' => '{{WRAPPER}} .wl-ptf-fancy-price',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'pricing_table_price_hover',
            [
                'label' => __( 'Hover', 'woolementor' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'pricing_table_price_box_bg_hover',
                'label' => __( 'Background', 'woolementor' ),
                'types' => [ 'classic', 'gradient' ],
                'separator' => 'before',
                'selector' => '{{WRAPPER}} .wl-pricing-table-fancy:hover .wl-ptf-pricing-area',
            ]
        );

        $this->add_group_control(
            Group_Control_Gradient_Text::get_type(),
            [
                'name' => 'price_gradient_color_hover',
                'selector' => '{{WRAPPER}} .wl-pricing-table-fancy:hover .wl-ptf-fancy-price',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
        *Sale Price styling
        */

        $this->start_controls_section(
            '_section_style_sale_price',
            [
                'label' => __( 'Sale Price', 'woolementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_sale_price' => 'yes'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'sale_price_typography',
                'label'     => __( 'Typography', 'woolementor' ),
                'scheme'    => Typography::TYPOGRAPHY_3,
                'selector'  => '{{WRAPPER}} .wl-pricing-table-fancy .wl-ptf-sale-price',
            ]
        );

        $this->start_controls_tabs( 'pricing_table_sale_price_tab' );

        $this->start_controls_tab(
            'pricing_table_sale_price_normal',
            [
                'label' => __( 'Normal', 'woolementor' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Gradient_Text::get_type(),
            [
                'name' => 'sale_price_gradient_color',
                'selector' => '{{WRAPPER}} .wl-pricing-table-fancy .wl-ptf-sale-price',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'sale_pricing_table_price_hover',
            [
                'label' => __( 'Hover', 'woolementor' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Gradient_Text::get_type(),
            [
                'name' => 'sale_price_gradient_color_hover',
                'selector' => '{{WRAPPER}} .wl-pricing-table-fancy:hover .wl-ptf-sale-price',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
        *Period Price styling
        */

        $this->start_controls_section(
            '_section_style_period',
            [
                'label' => __( 'Period', 'woolementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'period_typography',
                'label'     => __( 'Typography', 'woolementor' ),
                'scheme'    => Typography::TYPOGRAPHY_3,
                'selector'  => '{{WRAPPER}} .wl-ptf-pricing-period',
            ]
        );

        $this->start_controls_tabs( 'pricing_table_period_tab' );

        $this->start_controls_tab(
            'pricing_table_period_normal',
            [
                'label' => __( 'Normal', 'woolementor' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Gradient_Text::get_type(),
            [
                'name' => 'period_gradient_color',
                'selector' => '{{WRAPPER}} .wl-ptf-pricing-period',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'pricing_table_period_hover',
            [
                'label' => __( 'Hover', 'woolementor' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Gradient_Text::get_type(),
            [
                'name' => 'period_gradient_color_hover',
                'selector' => '{{WRAPPER}} .wl-pricing-table-fancy:hover .wl-ptf-pricing-period',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
        *Title styling
        */

        $this->start_controls_section(
            '_section_style_title',
            [
                'label' => __( 'Title', 'woolementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'title_typography',
                'label'     => __( 'Typography', 'woolementor' ),
                'scheme'    => Typography::TYPOGRAPHY_3,
                'selector'  => '{{WRAPPER}} .wl-pricing-table-fancy .wl-ptf-title',
            ]
        );


        $this->add_control(
            'title_align',
            [
                'label'     => __( 'Alignment', 'woolementor' ),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'left'      => [
                        'title' => __( 'Left', 'woolementor' ),
                        'icon'  => 'fa fa-align-left',
                    ],
                    'center'    => [
                        'title' => __( 'Center', 'woolementor' ),
                        'icon'  => 'fa fa-align-center',
                    ],
                    'right'     => [
                        'title' => __( 'Right', 'woolementor' ),
                        'icon'  => 'fa fa-align-right',
                    ],
                ],
                'default'   => 'center',
                'toggle'    => true,
                'selectors'     => [
                    '{{WRAPPER}} .wl-pricing-table-fancy .wl-ptf-title' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'pricing_table_title_tab' );

        $this->start_controls_tab(
            'pricing_table_title_normal',
            [
                'label' => __( 'Normal', 'woolementor' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Gradient_Text::get_type(),
            [
                'name' => 'title_gradient_color',
                'selector' => '{{WRAPPER}} .wl-pricing-table-fancy .wl-ptf-title',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'pricing_table_title_hover',
            [
                'label' => __( 'Hover', 'woolementor' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Gradient_Text::get_type(),
            [
                'name' => 'title_gradient_color_hover',
                'selector' => '{{WRAPPER}} .wl-pricing-table-fancy:hover .wl-ptf-title',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
        *Feature list styling
        */

        $this->start_controls_section(
            '_section_style_features',
            [
                'label' => __( 'Features', 'woolementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'features_typography',
                'label'     => __( 'Typography', 'woolementor' ),
                'scheme'    => Typography::TYPOGRAPHY_3,
                'selector'  => '{{WRAPPER}} .wl-pricing-table-fancy .wl-ptff-desc',
            ]
        );

        $this->add_control(
            'features_align',
            [
                'label'     => __( 'Alignment', 'woolementor' ),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'left'      => [
                        'title' => __( 'Left', 'woolementor' ),
                        'icon'  => 'fa fa-align-left',
                    ],
                    'center'    => [
                        'title' => __( 'Center', 'woolementor' ),
                        'icon'  => 'fa fa-align-center',
                    ],
                    'right'     => [
                        'title' => __( 'Right', 'woolementor' ),
                        'icon'  => 'fa fa-align-right',
                    ],
                ],
                'default'   => 'center',
                'toggle'    => true,
                'selectors'     => [
                    '{{WRAPPER}} .wl-pricing-table-fancy .wl-ptf-feature-list' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'space_btn_items',
            [
                'label' => __( 'Space Between Features', 'woolementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 300,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wl-pricing-table-fancy .wl-ptf-featute' => 'margin: {{SIZE}}{{UNIT}} 0{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'pricing_table_features_tab' );

        $this->start_controls_tab(
            'pricing_table_features_normal',
            [
                'label' => __( 'Normal', 'woolementor' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Gradient_Text::get_type(),
            [
                'name' => 'features_gradient_color',
                'selector' => '{{WRAPPER}} .wl-pricing-table-fancy .wl-ptff-desc',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'pricing_table_features_hover',
            [
                'label' => __( 'Hover', 'woolementor' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Gradient_Text::get_type(),
            [
                'name' => 'features_gradient_color_hover',
                'selector' => '{{WRAPPER}} .wl-pricing-table-fancy:hover .wl-ptff-desc',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
        *Button styling
        */

        $this->start_controls_section(
            '_section_style_btn',
            [
                'label' => __( 'Button', 'woolementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_purchase_btn' => 'yes'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'btn_typography',
                'label'     => __( 'Typography', 'woolementor' ),
                'scheme'    => Typography::TYPOGRAPHY_3,
                'selector'  => '{{WRAPPER}} .wl-ptf-purchase-btn',
            ]
        );

        $this->add_responsive_control(
            'pricing_table_btn_border_radius',
            [
                'label'         => __( 'Border Radius', 'woolementor' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%', 'em' ],
                'selectors'     => [
                    '{{WRAPPER}} .wl-ptf-purchase-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'pricing_table_btn_tab' );

        $this->start_controls_tab(
            'pricing_table_btn_normal',
            [
                'label' => __( 'Normal', 'woolementor' ),
            ]
        );

         $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'pricing_table_btn_border',
                'label' => __( 'Border', 'woolementor' ),
                'selector' => '{{WRAPPER}} .wl-ptf-purchase-btn',
            ]
        );

        $this->add_group_control(
            Group_Control_Gradient_Text::get_type(),
            [
                'name' => 'btn_gradient_color',
                'selector' => '{{WRAPPER}} .wl-ptf-purchase-btn',
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'pricing_table_btn_bg',
                'label' => __( 'Background', 'woolementor' ),
                'types' => [ 'classic', 'gradient' ],
                'separator' => 'before',
                'selector' => '{{WRAPPER}} .wl-ptf-purchase-btn',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'pricing_table_btn_hover',
            [
                'label' => __( 'Hover', 'woolementor' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'pricing_table_btn_border_hover',
                'label' => __( 'Border', 'woolementor' ),                
                'selector' => '{{WRAPPER}} .wl-pricing-table-fancy:hover .wl-ptf-purchase-btn',
            ]
        );

        $this->add_group_control(
            Group_Control_Gradient_Text::get_type(),
            [
                'name' => 'btn_gradient_color_hover',
                'selector' => '{{WRAPPER}} .wl-pricing-table-fancy:hover .wl-ptf-purchase-btn',
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'pricing_table_btn_bg_hover',
                'label' => __( 'Background', 'woolementor' ),
                'types' => [ 'classic', 'gradient' ],
                'separator' => 'before',
                'selector' => '{{WRAPPER}} .wl-pricing-table-fancy:hover .wl-ptf-purchase-btn',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_responsive_control(
            'pricing_table_btn_padding',
            [
                'label'         => __( 'Padding', 'woolementor' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%', 'em' ],
                'separator' => 'before',
                'selectors'     => [
                    '{{WRAPPER}} .wl-ptf-purchase-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'pricing_table_btn_margin',
            [
                'label'         => __( 'Margin', 'woolementor' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%', 'em' ],
                'selectors'     => [
                    '{{WRAPPER}} .wl-ptf-purchase-btn' => 'Margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

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
                    '(desktop){{WRAPPER}} .wl-ptf-featured-badge-text' => '-ms-transform: translate({{media_offset_x.SIZE || 0}}{{UNIT}}, {{media_offset_y.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{media_offset_x.SIZE || 0}}{{UNIT}}, {{media_offset_y.SIZE || 0}}{{UNIT}}); transform: translate({{media_offset_x.SIZE || 0}}{{UNIT}}, {{media_offset_y.SIZE || 0}}{{UNIT}}) rotate({{sale_ribbon_transform.SIZE}}deg);',
                    '(tablet){{WRAPPER}} .wl-ptf-featured-badge-text' => '-ms-transform: translate({{media_offset_x_tablet.SIZE || 0}}{{UNIT}}, {{media_offset_y_tablet.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{media_offset_x_tablet.SIZE || 0}}{{UNIT}}, {{media_offset_y_tablet.SIZE || 0}}{{UNIT}}); transform: translate({{media_offset_x_tablet.SIZE || 0}}{{UNIT}}, {{media_offset_y_tablet.SIZE || 0}}{{UNIT}});',
                    '(mobile){{WRAPPER}} .wl-ptf-featured-badge-text' => '-ms-transform: translate({{media_offset_x_mobile.SIZE || 0}}{{UNIT}}, {{media_offset_y_mobile.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{media_offset_x_mobile.SIZE || 0}}{{UNIT}}, {{media_offset_y_mobile.SIZE || 0}}{{UNIT}}); transform: translate({{media_offset_x_mobile.SIZE || 0}}{{UNIT}}, {{media_offset_y_mobile.SIZE || 0}}{{UNIT}});',
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
                    '{{WRAPPER}} .wl-ptf-featured-badge-text' => 'width: {{SIZE}}{{UNIT}}',
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
                    '{{WRAPPER}} .wl-ptf-featured-badge-text' => '-webkit-transform: rotate({{SIZE}}deg); transform: translate({{media_offset_x.SIZE || 0}}{{UNIT}}, {{media_offset_y.SIZE || 0}}{{UNIT}}) rotate({{SIZE}}deg);',
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
                    '{{WRAPPER}} .wl-ptf-featured-badge-text' => 'color: {{VALUE}}',
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
                'selector'  => '{{WRAPPER}} .wl-ptf-featured-badge-text',
            ]
        );

        $this->add_control(
            'badge_background',
            [
                'label'         => __( 'Background', 'woolementor' ),
                'type'          => Controls_Manager::COLOR,
                'selectors'     => [
                    '{{WRAPPER}} .wl-ptf-featured-badge-text' => 'background: {{VALUE}}',
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
                    '{{WRAPPER}} .wl-ptf-featured-badge-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'badge_border',
                'label'         => __( 'Border', 'woolementor' ),
                'selector'      => '{{WRAPPER}} .wl-ptf-featured-badge-text',
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
                    '{{WRAPPER}} .wl-ptf-featured-badge-text' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

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