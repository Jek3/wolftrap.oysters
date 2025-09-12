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
use codexpert\Woolementor\Controls\Group_Control_Gradient_Text;

class Filter_Horizontal extends Widget_Base {

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
		return [ "woolementor-{$this->id}", 'jquery-ui' ];
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
			'filter_horizontal_general',
			[
				'label' 		=> __( 'General', 'woolementor' ),
				'tab'   		=> Controls_Manager::TAB_CONTENT,
			]
		);

        $this->add_control(
			'filter_horizontal_switcher',
			[
				'label' 		=> __( 'Filter', 'woolementor' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'Show', 'woolementor' ),
				'label_off' 	=> __( 'Hide', 'woolementor' ),
				'return_value' 	=> 'yes',
				'default' 		=> 'yes',
			]
		);

		$this->add_control(
			'filter_horizontal_title',
			[
				'label' 		=> __( 'Filter Title', 'woolementor' ),
				'type' 			=> Controls_Manager::TEXT,
				'default' 		=> __( 'Filter', 'woolementor' ),
				'placeholder' 	=> __( 'Type your title here', 'woolementor' ),
				'condition' => [
                    'filter_horizontal_switcher' => 'yes'
                ],
			]
		);

		$this->add_responsive_control(
			'filter_horizontal_alignment',
			[
				'label' 		=> __( 'Button Alignment', 'woolementor' ),
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
					'flex-end' 	=> [
						'title' 	=> __( 'Right', 'woolementor' ),
						'icon' 		=> 'fa fa-align-right',
					],
				],
				'default' => 'flex-end',
				'tablet_default' => 'flex-end',
				'mobile_default' => 'center',
				'toggle' => true,
				'selectors' => [
					'{{WRAPPER}} .wl-fh-flter-action-area' => 'justify-content: {{VALUE}}',
				],
                'separator' 		=> 'after',
			]
		);

		$this->add_control(
			'form_action_show',
			[
				'label' 		=> __( 'Custom Form Action', 'woolementor' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'Show', 'woolementor' ),
				'label_off' 	=> __( 'Hide', 'woolementor' ),
				'return_value' 	=> 'yes',
				'default' 		=> 'yes',
			]
		);

        $this->add_control(
            'form_action',
            [
                'label'     => __( 'Action Url', 'woolementor' ),
                'type' 	    => Controls_Manager::TEXT,
                'placeholder' => 'http://example.com/',
				'condition' => [
                    'form_action_show' => 'yes'
                ],
            ]
        );

		$this->add_control(
			'filter_horizontal_price',
			[
				'label' 		=> __( 'Price', 'woolementor' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'Show', 'woolementor' ),
				'label_off' 	=> __( 'Hide', 'woolementor' ),
				'return_value' 	=> 'yes',
				'default' 		=> 'yes',
				'separator' 	=> 'before',
			]
		);

		$this->add_control(
			'fh_price_title',
			[
				'label' 		=> __( 'Price Title', 'woolementor' ),
				'type' 			=> Controls_Manager::TEXT,
				'default' 		=> __( 'Price', 'woolementor' ),
				'placeholder' 	=> __( 'Type your title here', 'woolementor' ),
				'separator' 	=> 'after',
				'condition' => [
                    'filter_horizontal_price' => 'yes'
                ],
			]
		);

        $this->add_control(
			'filter_horizontal_sort',
			[
				'label' 		=> __( 'Sort', 'woolementor' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'Show', 'woolementor' ),
				'label_off' 	=> __( 'Hide', 'woolementor' ),
				'return_value' 	=> 'yes',
				'default' 		=> 'yes',
			]
		);

		$this->add_control(
			'fh_sort_title',
			[
				'label' 		=> __( 'Sort Title', 'woolementor' ),
				'type' 			=> Controls_Manager::TEXT,
				'default' 		=> __( 'Sort', 'woolementor' ),
				'placeholder' 	=> __( 'Type your title here', 'woolementor' ),
				'separator' 	=> 'after',
				'condition' => [
                    'filter_horizontal_sort' => 'yes'
                ],
			]
		);

        $this->add_control(
			'filter_horizontal_order',
			[
				'label' 		=> __( 'Order', 'woolementor' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'Show', 'woolementor' ),
				'label_off' 	=> __( 'Hide', 'woolementor' ),
				'return_value' 	=> 'yes',
				'default' 		=> 'yes',
			]
		);

		$this->add_control(
			'fh_order_title',
			[
				'label' 		=> __( 'Order Title', 'woolementor' ),
				'type' 			=> Controls_Manager::TEXT,
				'default' 		=> __( 'Order', 'woolementor' ),
				'placeholder' 	=> __( 'Type your title here', 'woolementor' ),
				'separator' 	=> 'after',
				'condition' => [
                    'filter_horizontal_order' => 'yes'
                ],
			]
		);

        $this->add_control(
			'filter_horizontal_search',
			[
				'label' 		=> __( 'Search', 'woolementor' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'Show', 'woolementor' ),
				'label_off' 	=> __( 'Hide', 'woolementor' ),
				'return_value' 	=> 'yes',
				'default' 		=> 'yes',
			]
		);

		$this->add_control(
			'fh_search_title',
			[
				'label' 		=> __( 'Search Title', 'woolementor' ),
				'type' 			=> Controls_Manager::TEXT,
				'default' 		=> __( 'Search', 'woolementor' ),
				'placeholder' 	=> __( 'Type your title here', 'woolementor' ),
				'separator' 	=> 'after',
				'condition' => [
                    'filter_horizontal_search' => 'yes'
                ],
			]
		);

        $this->add_control(
			'filter_horizontal_clear',
			[
				'label' 		=> __( 'Clear Button', 'woolementor' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'Show', 'woolementor' ),
				'label_off' 	=> __( 'Hide', 'woolementor' ),
				'return_value' 	=> 'yes',
				'default' 		=> 'yes',
                'separator' 		=> 'before',
			]
		);

		$this->add_control(
			'clear_btn_text',
			[
				'label' 		=> __( 'Clear Button Text', 'woolementor' ),
				'type' 			=> Controls_Manager::TEXT,
				'default' 		=> __( 'Clear All', 'woolementor' ),
				'placeholder' 	=> __( 'Type your text here', 'woolementor' ),
				'condition' => [
                    'filter_horizontal_clear' => 'yes'
                ],
                'separator' 		=> 'after',
			]
		);

        $this->add_control(
			'filter_horizontal_apply',
			[
				'label' 		=> __( 'Apply Button', 'woolementor' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'Show', 'woolementor' ),
				'label_off' 	=> __( 'Hide', 'woolementor' ),
				'return_value' 	=> 'yes',
				'default' 		=> 'yes',
			]
		);

		$this->add_control(
			'apply_btn_text',
			[
				'label' 		=> __( 'Apply Button Text', 'woolementor' ),
				'type' 			=> Controls_Manager::TEXT,
				'default' 		=> __( 'Apply', 'woolementor' ),
				'placeholder' 	=> __( 'Type your text here', 'woolementor' ),
				'condition' => [
                    'filter_horizontal_apply' => 'yes'
                ],
			]
		);

		$this->add_control(
            'filter_horizontal_taxonomies',
            [
                'label'     => __( 'Filter Items', 'woolementor' ),
                'type' 	    => Controls_Manager::SELECT2,
                'options'   => woolementor_get_taxonomies(),
                'separator' 		=> 'before',
                'multiple'          => true,
                'style_transfer' 	=> true,
                'label_block' 		=> true,
            ]
        );

        $repeater = new Repeater();

		$repeater->add_control(
			'min_price', [
				'label' 		=> __( 'Min Price', 'woolementor' ),
				'type' 			=> Controls_Manager::NUMBER,
				'default' 		=> floor( woolementor_price_limit( 'min' ) ),
			]
		);

		$repeater->add_control(
			'max_price', [
				'label' 		=> __( 'Max Price', 'woolementor' ),
				'type' 			=> Controls_Manager::NUMBER,
				'default' 		=> floor( woolementor_price_limit( 'max' ) ),
			]
		);

		$this->add_control(
			'price_list',
			[
				'label' 		=> __( 'Price Range', 'woolementor' ),
				'type' 			=> Controls_Manager::REPEATER,
				'fields' 		=> $repeater->get_controls(),
                'separator' 		=> 'before',
				'default' 		=> [
					[
						'min_price' => floor( woolementor_price_limit( 'min' ) ),
						'max_price' => floor( woolementor_price_limit( 'max' ) ),
					],
				],
				'title_field' 	=> __( 'Price ( {{{ min_price }}} - {{{ max_price }}} )', 'woolementor' ),
			]
		);

		$this->end_controls_section();

		/**
		 * Descriptio style Section
		 */
		$this->start_controls_section(
			'filter_horizontal_header_style',
			[
				'label'			=> __( 'Section Title', 'woolementor' ),
				'tab'   		=> Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'filter_horizontal_ypography',
				'label' => __( 'Typography', 'woolementor' ),
				'scheme' => Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .wl-fh-filter-heading h3',
			]
		);

		$this->add_group_control(
            Group_Control_Gradient_Text::get_type(),
            [
                'name' => 'filter_horizontal_gradient_color',
                'selector' => '{{WRAPPER}} .wl-fh-filter-heading h3',
            ]
        );

		$this->end_controls_section();

		/**
		 * Search Box
		 */
		$this->start_controls_section(
			'filter_horizontal_search_box',
			[
				'label'			=> __( 'Search Box', 'woolementor' ),
				'tab'   		=> Controls_Manager::TAB_STYLE,
                'condition' => [
                    'filter_horizontal_apply' => 'yes'
                ],
			]
		);

        $this->add_control(
			'search_box_text_color',
			[
				'label' 	=> __( 'Text Color', 'woolementor' ),
				'type' 		=> Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-fh-filter-search input' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'search_box_background',
				'label' => __( 'Background', 'woolementor' ),
				'types' => [ 'classic', 'gradient'],
				'selector' => '{{WRAPPER}} .wl-fh-filter-search input',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'search_box_typography',
				'label' => __( 'Typography', 'woolementor' ),
				'scheme' => Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .wl-fh-filter-search input',
			]
		);

		$this->add_control(
			'search_box_icon',
			[
				'label' 	=> __( 'Search Icon', 'text-domain' ),
				'type' 		=> Controls_Manager::ICONS,
				'default' 	=> [
					'value' => 'fa fa-search',
					'library' => 'solid',
				],
				'separator'		=> 'before'
			]
		);

        $this->add_control(
			'search_box_icon_color',
			[
				'label' 	=> __( 'Icon Color', 'woolementor' ),
				'type' 		=> Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-fh-search-button' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'search_box_border',
				'label'         => __( 'Border', 'woolementor' ),
				'selector'      => '{{WRAPPER}} .wl-fh-filter-search input',
				'separator'		=> 'before'
			]
		);

		$this->add_responsive_control(
			'search_box_border_radius',
			[
				'label'         => __( 'Border Radius', 'woolementor' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', '%', 'em' ],
				'selectors'     => [
					'{{WRAPPER}} .wl-fh-filter-search input' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'search_box_padding',
			[
				'label' 		=> __( 'Padding', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .wl-fh-filter-search input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'		=> 'before',
			]
		);

		$this->add_responsive_control(
			'search_box_margin',
			[
				'label' 		=> __( 'Margin', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .wl-fh-filter-search input' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/**
		 * Filter
		 */
		$this->start_controls_section(
			'filter_horizontal_style_section',
			[
				'label'			=> __( 'Filter', 'woolementor' ),
				'tab'   		=> Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'filter_horizontal_dropdown_tabs' );

        $this->start_controls_tab(
            'filter_horizontal_dropdown_title',
            [
                'label' => __( 'Dropdown Title', 'woolementor' ),
            ]
        );

        $this->add_control(
			'filter_horizontal_color',
			[
				'label' 		=> __( 'Text Color', 'woolementor' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .wl-fh-tab-label' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'filter_horizontal_typography',
				'label' => __( 'Typography', 'woolementor' ),
				'scheme' => Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .wl-fh-tab-label',
			]
		);

        $this->end_controls_tab();

        $this->start_controls_tab(
            'filter_horizontal_dropdown_items',
            [
                'label' => __( 'Dropdown Items', 'woolementor' ),
            ]
        );

        $this->add_control(
			'filter_horizontal_item_color',
			[
				'label' 		=> __( 'Text Color', 'woolementor' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .wl-fh-radio-custom-label span' => 'color: {{VALUE}}',
					'{{WRAPPER}} .wl-fh-checkbox-custom-label span' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'filter_horizontal_item_typography',
				'label' => __( 'Typography', 'woolementor' ),
				'scheme' => Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .wl-fh-radio-custom-label span, .wl-fh-checkbox-custom-label span',
			]
		);

		$this->add_responsive_control(
            'filter_horizontal_check_icon_size',
            [
                'label'     	=> __( 'Check Icon Size', 'woolementor' ),
                'type'      	=> Controls_Manager::SLIDER,
                'size_units'	=> [ 'px', 'em' ],
                'selectors' 	=> [
                    '{{WRAPPER}} .wl-fh-checkbox-custom + .wl-fh-checkbox-custom-label::before, .wl-fh-radio-custom + .wl-fh-radio-custom-label::before' => 'width: {{SIZE}}{{UNIT}} !important; height: {{SIZE}}{{UNIT}} !important',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

		$this->add_responsive_control(
			'arrow_icon_size',
			[
				'label' 		=> __( 'Icon Size', 'woolementor' ),
				'type' 			=> Controls_Manager::SLIDER,
				'size_units' 	=> [ 'px' ],
				'selectors' 	=> [
					'{{WRAPPER}} .wl-fh-tab-label::after, .wl-fh-tab-label::before' => 'font-size: {{SIZE}}{{UNIT}}',
				],
				'render_type' 	=> 'ui',
				'separator'		=> 'before'
			]
		);

		$this->add_control(
			'icon_offset_toggle',
			[
				'label' 		=> __( 'Icon Position', 'woolementor' ),
				'type' 			=> Controls_Manager::POPOVER_TOGGLE,
				'label_off' 	=> __( 'None', 'woolementor' ),
				'label_on' 		=> __( 'Custom', 'woolementor' ),
				'return_value' 	=> 'yes',
			]
		);

		$this->start_popover();

		$this->add_responsive_control(
			'icon_offset_left',
			[
				'label' 		=> __( 'Offset Left', 'woolementor' ),
				'type' 			=> Controls_Manager::SLIDER,
				'size_units' 	=> [ 'px' ],
				'selectors' 	=> [
					'{{WRAPPER}} .wl-fh-tab-label::after, .wl-fh-tab-label::before' => 'right: {{SIZE}}{{UNIT}}',
				],
				'range' 		=> [
					'px' 		=> [
						'min' 	=> -500,
						'max' 	=> 500,
					],
				],
				'condition' 	=> [
					'icon_offset_toggle' => 'yes'
				],
				'render_type' 	=> 'ui',
			]
		);

		$this->add_responsive_control(
			'icon_offset_top',
			[
				'label' 		=> __( 'Offset Top', 'woolementor' ),
				'type' 			=> Controls_Manager::SLIDER,
				'size_units' 	=> [ 'px' ],
				'selectors' 	=> [
					'{{WRAPPER}} .wl-fh-tab-label::after, .wl-fh-tab-label::before' => 'top: {{SIZE}}{{UNIT}}',
				],
				'range' 		=> [
					'px' 		=> [
						'min' 	=> -100,
						'max' 	=> 100,
					],
				],
				'condition' 	=> [
					'icon_offset_toggle' => 'yes'
				],
				'render_type' 	=> 'ui',
			]
		);

		$this->end_popover();

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'filter_horizontal_border',
				'label'         => __( 'Border', 'woolementor' ),
				'selector'      => '{{WRAPPER}} .wl-fh-single-filter-wrap',
				'separator'		=> 'before'
			]
		);

		$this->add_responsive_control(
			'filter_horizontal_border_radius',
			[
				'label'         => __( 'Border Radius', 'woolementor' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', '%', 'em' ],
				'selectors'     => [
					'{{WRAPPER}} .wl-fh-single-filter-wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'filter_horizontal_padding',
			[
				'label' 		=> __( 'Padding', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .wl-fh-tab-label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'		=> 'before',
			]
		);

		$this->add_responsive_control(
			'filter_horizontal_margin',
			[
				'label' 		=> __( 'Margin', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .wl-fh-single-filter' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/**
		 * Apply Button
		 */
		$this->start_controls_section(
			'filter_horizontal_apply_button',
			[
				'label'			=> __( 'Apply Button', 'woolementor' ),
				'tab'   		=> Controls_Manager::TAB_STYLE,
                'condition' => [
                    'filter_horizontal_apply' => 'yes'
                ],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'apply_button_typography',
				'label' => __( 'Typography', 'woolementor' ),
				'scheme' => Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .wl-fh-btn-checkout',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'apply_button_box_shadow',
				'label' => __( 'Box Shadow', 'woolementor' ),
				'selector' => '{{WRAPPER}} .wl-fh-btn-checkout',
				'separator'		=> 'before'
			]
		);

		$this->add_responsive_control(
			'apply_button_padding',
			[
				'label' 		=> __( 'Padding', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .wl-fh-btn-checkout' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'		=> 'before',
			]
		);

		$this->add_responsive_control(
			'apply_button_margin',
			[
				'label' 		=> __( 'Margin', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .wl-fh-btn-checkout' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs(
            'apply_normal_separator',
            [
                'separator' => 'before'
            ]
        );
        $this->start_controls_tab(
            'apply_btn_normal',
            [
                'label'     => __( 'Normal', 'woolementor' ),
            ]
        );

        $this->add_control(
			'apply_button_text_color',
			[
				'label' 	=> __( 'Text Color', 'woolementor' ),
				'type' 		=> Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-fh-btn-checkout' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'apply_button_background',
				'label' => __( 'Background', 'woolementor' ),
				'types' => [ 'classic', 'gradient'],
				'selector' => '{{WRAPPER}} .wl-fh-btn-checkout',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'apply_button_border',
				'label'         => __( 'Border', 'woolementor' ),
				'selector'      => '{{WRAPPER}} .wl-fh-btn-checkout',				
			]
		);

		$this->add_responsive_control(
			'apply_button_border_radius',
			[
				'label'         => __( 'Border Radius', 'woolementor' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', '%', 'em' ],
				'selectors'     => [
					'{{WRAPPER}} .wl-fh-btn-checkout' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

        $this->start_controls_tab(
            'apply_btn_hover',
            [
                'label'     => __( 'Hover', 'woolementor' ),
            ]
        );

        $this->add_control(
			'apply_button_text_color_hover',
			[
				'label' 	=> __( 'Text Color', 'woolementor' ),
				'type' 		=> Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-fh-btn-checkout:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'apply_button_background_hover',
				'label' => __( 'Background', 'woolementor' ),
				'types' => [ 'classic', 'gradient'],
				'selector' => '{{WRAPPER}} .wl-fh-btn-checkout:hover',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'apply_button_border_hover',
				'label'         => __( 'Border', 'woolementor' ),
				'selector'      => '{{WRAPPER}} .wl-fh-btn-checkout:hover',				
			]
		);

		$this->add_responsive_control(
			'apply_button_border_radius_hover',
			[
				'label'         => __( 'Border Radius', 'woolementor' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', '%', 'em' ],
				'selectors'     => [
					'{{WRAPPER}} .wl-fh-btn-checkout:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
		$section_id = $this->get_raw_data()['id'];
		$action = $form_action_show == 'yes' ? $form_action : '';

		$this->render_editing_attributes();
		?>
		
		<form method="get" action="<?php echo esc_html( $action ) ?>">
			<div class="wl-fh-filters-area wl-fh-hr">
				<div class="wl-fh-filter-heading-area">
					<div class="wl-fh-filter-heading">

						<?php 
						printf( '<h3 %s>%s</h3>',
				            $this->get_render_attribute_string( 'filter_horizontal_title' ),
				            esc_html( $filter_horizontal_title ) 
				        );
						?>
						
					</div>
					<div class="wl-fh-flter-action-area">
						<?php if ( 'yes' == $filter_horizontal_clear ): ?>
							<div class="wl-fh-flter-action-left">

								<?php 
								global $wp;
								printf( '<a %s href="%s">%s</a>',
				            		$this->get_render_attribute_string( 'clear_btn_text' ),
						            home_url( $wp->request ),
						            esc_html( $clear_btn_text ) 
						        );
								?>

							</div>
						<?php endif;

						if ( 'yes' == $filter_horizontal_apply ): ?>
							<div class="wl-fh-flter-action-right">
								
								<?php 
								printf( '<button %s type="submit">%s</button>',
				            		$this->get_render_attribute_string( 'apply_btn_text' ),
						            esc_html( $apply_btn_text ) 
						        );
								?>

							</div>
						<?php endif; ?>
					</div>
				</div>

				<div class="wl-fh-filters">
					<div class="wl-fh-filters-inner">
						<?php if ( 'yes' == $filter_horizontal_price ): ?>
							<div class="wl-fh-single-filter wl-fh-single-filter-<?php echo $section_id; ?>">
								<div class="wl-fh-single-filter-wrap">
									<div class="wl-fh-accordion-title wl-fh-tab-label wl-fh-item wl-fh-item-<?php echo $section_id; ?>"><?php echo esc_html( $fh_price_title ); ?></div>
									<div class="wl-fh-filter-content wl-fh-item-data wl-fh-item-data-<?php echo $section_id; ?>">
										<?php foreach ( $price_list as $key => $price ): 
											if ( isset( $_GET['filter']['min_price'] ) ) {
												$checked = checked( $price['min_price'], $_GET['filter']['min_price'], false );
											}
											else{
												$checked = '';
											}
											?>
											<div>
												<input id="<?php echo esc_attr( $price['_id'] ); ?>" 
												data-min_price="<?php echo esc_attr( $price['min_price'] ); ?>"
												data-max_price="<?php echo esc_attr( $price['max_price'] ); ?>"
												class="wl-fh-radio-custom wl-fh-price-range" 
												name="filter[price]" type="radio" <?php echo esc_attr( $checked ); ?> >
												<label for="<?php echo esc_attr( $price['_id'] ); ?>" class="wl-fh-radio-custom-label">
													<span><?php echo esc_html( $price['min_price'] ); ?> - <?php echo esc_html( $price['max_price'] ); ?></span>
												</label>
											</div>
										<?php endforeach ?>
										<div class="">
											<?php 
											if ( isset( $_GET['filter']['min_price'] ) && isset( $_GET['filter']['max_price'] ) ) {
												$min_price = $_GET['filter']['min_price'];
												$max_price = $_GET['filter']['max_price'];
											}
											else{
												$min_price = '';
												$max_price = '';
											}
											?>
											<input class="wl-fh-min_price" type="hidden" name="filter[min_price]" value="<?php echo esc_attr( $min_price ); ?>">
											<input class="wl-fh-max_price" type="hidden" name="filter[max_price]" value="<?php echo esc_attr( $max_price ); ?>">
										</div>
									</div>
								</div>
							</div>
						<?php endif; ?>

						<?php if ( 'yes' == $filter_horizontal_sort ): ?>

							<div class="wl-fh-single-filter wl-fh-single-filter-<?php echo $section_id; ?>">
								<div class="wl-fh-single-filter-wrap">
									<div class="wl-fh-accordion-title wl-fh-tab-label wl-fh-item wl-fh-item-<?php echo $section_id; ?>"><?php echo esc_html( $fh_sort_title ); ?></div>
									<div class="wl-fh-filter-content wl-fh-item-data wl-fh-item-data-<?php echo $section_id; ?>">
										<?php 
										$sort_options = woolementor_order_options();
										foreach ( $sort_options as $key => $sort_option ) : 
											if ( isset( $_GET['filter']['orderby'] ) ) {
												$checked = checked( $key, $_GET['filter']['orderby'], false );
											}
											else{
												$checked = '';
											}
											?>
											<div>
												<input id="<?php echo esc_attr( $key ); ?>" 
												class="wl-fh-radio-custom" 
												name="filter[orderby]" type="radio" 
												value="<?php echo esc_attr( $key ); ?>" <?php echo esc_attr( $checked ); ?>>
												<label for="<?php echo esc_attr( $key ); ?>" class="wl-fh-radio-custom-label">
													<span><?php echo esc_html( $sort_option ); ?></span>
												</label>
											</div>
										<?php endforeach ?>

									</div>
								</div>
							</div>
						<?php endif;

						if ( 'yes' == $filter_horizontal_order ): ?>

							<div class="wl-fh-single-filter wl-fh-single-filter-<?php echo $section_id; ?>">
								<div class="wl-fh-single-filter-wrap">
									<div class="wl-fh-accordion-title wl-fh-tab-label wl-fh-item wl-fh-item-<?php echo $section_id; ?>"><?php echo esc_html( $fh_order_title ); ?></div>
									<div class="wl-fh-filter-content wl-fh-item-data wl-fh-item-data-<?php echo $section_id; ?>">
										<?php 
										if(  !empty( $_GET['filter']['order'] ) ) {
											$checked = $_GET['filter']['order'];

											if ( 'ASC' == $checked ) {
												$asc = 'checked';
												$desc = '';
											}
											else{
												$desc = 'checked';
												$asc = '';
											}
										}
										else {
											$asc = '';
											$desc = '';
										}
										?>
										<div>
											<input id="order_asc" class="wl-fh-radio-custom" 
											name="filter[order]" type="radio" <?php echo esc_attr( $asc ); ?> 
											value="<?php _e( 'ASC', 'woolementor' ) ?>">
											<label for="order_asc" class="wl-fh-radio-custom-label">
												<span><?php _e( 'ASC', 'woolementor' ); ?></span>
											</label>
										</div>
										<div>
											<input id="order_desc" class="wl-fh-radio-custom" 
											name="filter[order]" type="radio" <?php echo esc_attr( $desc ); ?> 
											value="<?php _e( 'DESC', 'woolementor' ) ?>">
											<label for="order_desc" class="wl-fh-radio-custom-label">
												<span><?php _e( 'DESC', 'woolementor' ); ?></span>
											</label>
										</div>

									</div>
								</div>
							</div>
						<?php endif;

						if ( !empty( $filter_horizontal_taxonomies ) ): ?>
							<?php foreach ( $filter_horizontal_taxonomies as $taxonomies ): 
								$taxonomy = get_taxonomy( $taxonomies );
								?>

								<div class="wl-fh-single-filter wl-fh-single-filter-<?php echo $section_id; ?>">
									<div class="wl-fh-single-filter-wrap">
										<div class="wl-fh-accordion-title wl-fh-tab-label wl-fh-item wl-fh-item-<?php echo $section_id; ?>"><?php echo esc_html( $taxonomy->labels->singular_name ); ?></div>
										<div class="wl-fh-filter-content wl-fh-item-data wl-fh-item-data-<?php echo $section_id; ?>"> 
											<?php 
											$terms = get_terms( $taxonomies );
											$i=0;
											foreach ( $terms as $term ): 
												$checked = '';
												if ( isset( $_GET['filter']['taxonomies'][ $taxonomy->name ] ) && in_array( $term->slug, $_GET['filter']['taxonomies'][ $taxonomy->name ] ) ) {
													$checked = 'checked';
												}

												?>								
												<div>
													<input id="<?php echo $taxonomies.'_'.$term->slug; ?>" 
													class="wl-fh-checkbox-custom" 
													name="filter[taxonomies][<?php echo $taxonomy->name; ?>][<?php echo $i; ?>]" 
													type="checkbox" <?php echo $checked; ?> 
													value="<?php echo esc_attr( $term->slug ); ?>" >
													<label for="<?php echo $taxonomies.'_'.$term->slug; ?>" class="wl-fh-checkbox-custom-label">
														<span><?php echo esc_html( $term->name ); ?></span>
													</label>
												</div>
											<?php $i++; endforeach; ?>

										</div>
									</div>
								</div>
							<?php endforeach;
						endif; ?>
					</div>

					<?php if ( 'yes' == $filter_horizontal_search ): ?>
						<div class="wl-fh-single-filter-search">
							<div class="wl-fh-filter-search">
								<?php  
								$search = isset( $_GET['q'] ) ? $_GET['q'] : ''; 
								?>
								<input type="search" name="q" value="<?php echo esc_attr( $search ); ?>" placeholder="<?php echo esc_html( $fh_search_title ); ?>">
								<button class="wl-fh-search-button"><i class="<?php echo esc_attr( $search_box_icon['value'] ); ?>"></i></button>
							</div>
						</div>
					<?php endif; ?>  

				</div>
			</form>

		<?php
		/**
		 * Load Script
		 */
		$this->render_script();
	}

	private function render_editing_attributes() {
		$this->add_inline_editing_attributes( 'filter_horizontal_title', 'basic' );
		$this->add_inline_editing_attributes( 'clear_btn_text', 'basic' );

		$this->add_inline_editing_attributes( 'apply_btn_text', 'basic' );
		$this->add_render_attribute( 'apply_btn_text', 'class', 'wl-fh-btn-checkout' );
	}

	protected function render_script() {
		$settings 	= $this->get_settings_for_display();
		extract( $settings );
		$section_id = $this->get_raw_data()['id'];
		?>
		
		<script>
	        jQuery(function($){ 
	     		var Accordion = function(el, multiple) {
	 				this.el = el || {};
	 				this.multiple = multiple || false;
	 
	 				var links = this.el.find('.wl-fh-item-<?php echo $section_id; ?>');
	 				links.on('click', {
	 						el: this.el,
	 						multiple: this.multiple
	 				}, this.dropdown)
	     		}
	     
	     		Accordion.prototype.dropdown = function(e) {
	 				var $el = e.data.el;
	 				$this = $(this),
	 						$next = $this.next();
	 
	 				$next.slideToggle();
	 				$this.parent().toggleClass('open');
	 
	 				if (!e.data.multiple) {
	 						$el.find('.wl-fh-item-data-<?php echo $section_id; ?>').not($next).slideUp().parent().removeClass('open');
	 				};
	     		}
	     		var accordion = new Accordion($('.wl-fh-single-filter-<?php echo $section_id; ?>'), false);
	     
		        /*close all when click outside*/
		        $(document).on('click', function (event) {
		           if (!$(event.target).closest('.wl-fh-single-filter-<?php echo $section_id; ?>').length) {
		         	$this.parent().removeClass('open');
		         	$('.wl-fh-item-data-<?php echo $section_id; ?>').slideUp();
		           }
		        });

	        });
	      	</script> 
		<?php
	}
}