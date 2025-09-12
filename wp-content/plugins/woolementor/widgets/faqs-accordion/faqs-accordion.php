<?php
namespace codexpert\Woolementor;

use Elementor\Widget_Base;
use Elementor\Control_Icon;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Background;
use codexpert\Woolementor\Controls\Group_Control_Gradient_Text;

class Faqs_Accordion extends Widget_Base {

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

		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content', 'woolementor' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'open_first_item',
			[
				'label' 		=> __( 'Open First Item by Default', 'woolementor' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'On', 'woolementor' ),
				'label_off' 	=> __( 'Off', 'woolementor' ),
				'return_value' 	=> 'yes',
				'default' 		=> 'yes',
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'faqs_title', [
				'label' => __( 'Title', 'woolementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'New FAQ' , 'woolementor' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'faqs_content', [
				'label' => __( 'Content', 'woolementor' ),
				'type' => Controls_Manager::WYSIWYG,
				'default' => __( 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit nim id est laborum.' , 'woolementor' ),
				'show_label' => false,
			]
		);

		$this->add_control(
			'list',
			[
				'label' => __( 'Repeater List', 'woolementor' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'faqs_title' => __( 'FAQ #1', 'woolementor' ),
						'faqs_content' => __( 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit nim id est laborum.', 'woolementor' ),
					],
					[
						'faqs_title' => __( 'FAQ #2', 'woolementor' ),
						'faqs_content' => __( 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit nim id est laborum.', 'woolementor' ),
					],
					[
						'faqs_title' => __( 'FAQ #3', 'woolementor' ),
						'faqs_content' => __( 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit nim id est laborum.', 'woolementor' ),
					],
					[
						'faqs_title' => __( 'FAQ #4', 'woolementor' ),
						'faqs_content' => __( 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit nim id est laborum.', 'woolementor' ),
					],
				],
				'title_field' => '{{{ faqs_title }}}',
			]
		);

		$this->end_controls_section();

		/**
		 * Accordion
		 */
		$this->start_controls_section(
            'single_accordion',
            [
                'label' => __( 'Accordion', 'woolementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'single_accordion_height',
            [
                'label'     => __( 'Accordion Height', 'woolementor' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units'=> [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .wl-faqa-accordion-title' => 'height: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .wl-faqa-accordion-title span' => 'height: {{SIZE}}{{UNIT}}',
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
			'space',
			[
				'label' => __( 'Space', 'woolementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wl-faqa-single-accordion' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .wl-faqa-single-accordion:last-child' => 'margin-bottom: 0{{UNIT}};',
				],
			]
		);

        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 		=> 'single_accordion_border',
				'label' 	=> __( 'Border', 'woolementor' ),
				'selector' 	=> '{{WRAPPER}} .wl-faqa-single-accordion',
                'separator' => 'before'
			]
		);

		$this->add_control(
			'single_accordion_radius',
			[
				'label' => __( 'Border Radius', 'woolementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .wl-faqa-single-accordion' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .wl-faqa-accordion-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .wl-faqa-accordion-title span' => 'border-radius: 0{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} 0{{UNIT}};',
					'{{WRAPPER}} .wl-faqa-accordion-content' => 'border-radius: 0{{UNIT}} 0{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' 		=> 'single_accordionboc_shadow',
				'label' 	=> __( 'Box Shadow', 'woolementor' ),
				'selector' 	=> '{{WRAPPER}} .wl-faqa-single-accordion',
			]
		);

		$this->end_controls_section();

		/*
		*Title style
		*/
		$this->start_controls_section(
			'title_style',
			[
				'label' => __( 'Title', 'woolementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => __( 'Typography', 'woolementor' ),
				'scheme' => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .wl-faqa-accordion-title h2',
			]
		);

		$this->start_controls_tabs(
			'title_style_separator',
			[
			    'separator' => 'before'
			]
		);

		$this->start_controls_tab(
		    'title_collapse',
		    [
		        'label'     => __( 'Collapse', 'woolementor' ),
		    ]
		);

		$this->add_group_control(
			Group_Control_Gradient_Text::get_type(),
			[
				'name' => 'title_color',
				'selector' => '{{WRAPPER}} .wl-faqa-accordion-title h2',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'title_background',
				'label' => __( 'Background', 'woolementor' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .wl-faqa-accordion-title',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
		    'title_open',
		    [
		        'label'     => __( 'Expand', 'woolementor' ),
		    ]
		);

		$this->add_group_control(
			Group_Control_Gradient_Text::get_type(),
			[
				'name' => 'title_color_open',
				'selector' => '{{WRAPPER}} .wl-faqa-single-accordion.open .wl-faqa-accordion-title h2',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'title_background_open',
				'label' => __( 'Background', 'woolementor' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .wl-faqa-single-accordion.open .wl-faqa-accordion-title',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();

		/*
		*expand icon area
		*/
		$this->start_controls_section(
			'expand_style',
			[
				'label' => __( 'Icon', 'woolementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
            'icon_size',
            [
                'label'     => __( 'Icon Size', 'woolementor' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units'=> [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .wl-faqa-accordion-title span' => 'font-size: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .wl-faqa-single-accordion.open .wl-faqa-accordion-title span:before' => 'font-size: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'expand_border',
				'label' => __( 'Border', 'woolementor' ),
				'selector' => '{{WRAPPER}} .wl-faqa-accordion-title span',
			]
		);

		$this->start_controls_tabs(
			'expand_style_separator',
			[
			    'separator' => 'before'
			]
		);

		$this->start_controls_tab(
		    'collapse',
		    [
		        'label'     => __( 'Collapse', 'woolementor' ),
		    ]
		);

		$this->add_group_control(
			Group_Control_Gradient_Text::get_type(),
			[
				'name' => 'collapse_color',
				'selector' => '{{WRAPPER}} .wl-faqa-accordion-title span:before',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'collapse_background',
				'label' => __( 'Background', 'woolementor' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .wl-faqa-accordion-title span',
			]
		);

		$this->add_control(
			'collapse_border_radius',
			[
				'label' => __( 'Border Radius', 'woolementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .wl-faqa-accordion-title span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
		    'expand_open',
		    [
		        'label'     => __( 'Expand', 'woolementor' ),
		    ]
		);

		$this->add_group_control(
			Group_Control_Gradient_Text::get_type(),
			[
				'name' => 'expand_color',
				'selector' => '{{WRAPPER}} .wl-faqa-single-accordion.open .wl-faqa-accordion-title span:before',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'expand_background',
				'label' => __( 'Background', 'woolementor' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .wl-faqa-single-accordion.open .wl-faqa-accordion-title span',
			]
		);

		$this->add_control(
			'expand_border_radius',
			[
				'label' => __( 'Border Radius', 'woolementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .wl-faqa-single-accordion.open .wl-faqa-accordion-title span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();

		/*
		*Content style
		*/
		$this->start_controls_section(
			'content_style',
			[
				'label' => __( 'Content', 'woolementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography',
				'label' => __( 'Typography', 'woolementor' ),
				'scheme' => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .wl-faqa-accordion-content',
			]
		);

		$this->add_group_control(
			Group_Control_Gradient_Text::get_type(),
			[
				'name' => 'content_color',
				'selector' => '{{WRAPPER}} .wl-faqa-accordion-content',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'content_background',
				'label' => __( 'Background', 'woolementor' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .wl-faqa-accordion-content',
			]
		);

		$this->add_control(
			'content_padding',
			[
				'label' => __( 'Padding', 'woolementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .wl-faqa-accordion-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'content_border',
				'label' => __( 'Border', 'woolementor' ),
				'selector' => '{{WRAPPER}} .wl-faqa-accordion-content',
			]
		);

		$this->add_control(
			'content_border_radius',
			[
				'label' => __( 'Border Radius', 'woolementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .wl-faqa-accordion-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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