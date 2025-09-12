<?php
namespace codexpert\Woolementor;

use Elementor\Utils;
use Elementor\Repeater;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use codexpert\Woolementor\Controls\Group_Control_Gradient_Text;

class Customer_Reviews_Standard extends Widget_Base {

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
		 * Components
		 */
		$this->start_controls_section(
			'section_content_components',
			[
				'label' => __( 'Components', 'woolementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

        $this->add_control(
			'review_name_switcher',
			[
				'label' 		=> __( 'Name', 'woolementor' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'Show', 'woolementor' ),
				'label_off' 	=> __( 'Hide', 'woolementor' ),
				'return_value' 	=> 'yes',
				'default' 		=> 'yes',
			]
		);

        $this->add_control(
			'review_description_switcher',
			[
				'label' 		=> __( 'Description', 'woolementor' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'Show', 'woolementor' ),
				'label_off' 	=> __( 'Hide', 'woolementor' ),
				'return_value' 	=> 'yes',
				'default' 		=> 'yes',
			]
		);

        $this->add_control(
			'review_rating_switcher',
			[
				'label' 		=> __( 'Start Rating', 'woolementor' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'Show', 'woolementor' ),
				'label_off' 	=> __( 'Hide', 'woolementor' ),
				'return_value' 	=> 'yes',
				'default' 		=> 'yes',
			]
		);

        $this->add_control(
			'review_comment_switcher',
			[
				'label' 		=> __( 'Comment', 'woolementor' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'Show', 'woolementor' ),
				'label_off' 	=> __( 'Hide', 'woolementor' ),
				'return_value' 	=> 'yes',
				'default' 		=> 'yes',
			]
		);

        $this->add_control(
			'review_date_switcher',
			[
				'label' 		=> __( 'Date', 'woolementor' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'Show', 'woolementor' ),
				'label_off' 	=> __( 'Hide', 'woolementor' ),
				'return_value' 	=> 'yes',
				'default' 		=> 'yes',
			]
		);

        $this->add_control(
			'review_photo_switcher',
			[
				'label' 		=> __( 'Photo', 'woolementor' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'Show', 'woolementor' ),
				'label_off' 	=> __( 'Hide', 'woolementor' ),
				'return_value' 	=> 'yes',
				'default' 		=> 'yes',
			]
		);

        $this->add_control(
			'review_quote_switcher',
			[
				'label' 		=> __( 'Quote', 'woolementor' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'Show', 'woolementor' ),
				'label_off' 	=> __( 'Hide', 'woolementor' ),
				'return_value' 	=> 'yes',
				'default' 		=> 'yes',
			]
		);

		$this->end_controls_section();

		/**
		 * repeater
		 */
		$this->start_controls_section(
			'review_section_repeater',
			[
				'label' 		=> __( 'Reviews', 'woolementor' ),
				'tab' 			=> Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'review_repeater_name', [
				'label' 		=> __( 'Name', 'woolementor' ),
				'type' 			=> Controls_Manager::TEXT,
				'default' 		=> __( 'Jone Doe' , 'woolementor' ),
				'label_block' 	=> true,
			]
		);

		$repeater->add_control(
			'review_repeater_description', [
				'label' 		=> __( 'Description', 'woolementor' ),
				'type' 			=> Controls_Manager::TEXT,
				'default' 		=> __( 'Dhaka, Bangladesh' , 'woolementor' ),
				'label_block' 	=> true,
			]
		);

		$repeater->add_control(
			'review_repeater_rating', [
				'label' 		=> __( 'Rating (Out of 5)', 'woolementor' ),
				'type' 			=> Controls_Manager::NUMBER,
				'min' 			=> 1,
				'max' 			=> 5,
				'default'		=> 4,
			]
		);

		$repeater->add_control(
			'review_repeater_date', [
				'label' 		=> __( 'Date', 'woolementor' ),
				'type' 			=> Controls_Manager::DATE_TIME,
				'picker_options'=> array( 'enableTime' => false, 'dateFormat' => 'j F, Y' ),
				'default'		=> date( 'j F, Y' )
			]
		);

		$repeater->add_control(
			'review_repeater_comment', [
				'label' 		=> __( 'Comment', 'woolementor' ),
				'type' 			=> Controls_Manager::TEXTAREA,
				'default'		=>	__( 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. In libero dicta porro veritatis, dignissimos perferendis harum illum consequatur qui nulla minima reiciendis voluptatibus delectus voluptas quis alias, laboriosam. Optio rerum doloribus similique molestiae obcaecati dolores ipsam laborum perspiciatis voluptatum officia assumenda repellat, magni veniam, quod. Amet quibusdam id dicta corporis corrupti.', 'woolementor' ),
			]
		);

		$repeater->add_control(
			'review_repeater_photo', [
				'label' 		=> __( 'Photo', 'woolementor' ),
				'type' 			=> Controls_Manager::MEDIA,
				'default' 		=> [
					'url' 	=> Utils::get_placeholder_image_src(),
				],
			]
		);


        $repeater->add_control(
			'review_photo_align',
			[
				'label' => __( 'Photo Alignment', 'woolementor' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'wl-left' => [
						'title' => __( 'Left', 'woolementor' ),
						'icon' => 'fa fa-align-left',
					],
					'wl-center' => [
						'title' => __( 'Center', 'woolementor' ),
						'icon' => 'fa fa-align-center',
					],
					'wl-right' => [
						'title' => __( 'Right', 'woolementor' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'default' => 'wl-center',
				'toggle' => true,
				'separator' => 'before'
			]
		);

		$this->add_control(
			'review_repeater_items',
			[
				'label' 		=> __( 'Review List', 'woolementor' ),
				'type' 			=> Controls_Manager::REPEATER,
				'fields' 		=> $repeater->get_controls(),
				'default' 		=> [
					[
						'review_repeater_name' 		=> __( 'John Doe', 'woolementor' ),
						'review_repeater_comment' 	=> __( 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. In libero dicta porro veritatis, dignissimos perferendis harum illum consequatur qui nulla minima reiciendis voluptatibus delectus voluptas quis alias, laboriosam. Optio rerum doloribus similique molestiae obcaecati dolores ipsam laborum perspiciatis voluptatum officia assumenda repellat, magni veniam, quod. Amet quibusdam id dicta corporis corrupti.', 'woolementor' ),
					],
					[
						'review_repeater_name' 		=> __( 'Jane Doe', 'woolementor' ),
						'review_repeater_comment' 	=> __( 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. In libero dicta porro veritatis, dignissimos perferendis harum illum consequatur qui nulla minima reiciendis voluptatibus delectus voluptas quis alias, laboriosam. Optio rerum doloribus similique molestiae obcaecati dolores ipsam laborum perspiciatis voluptatum officia assumenda repellat, magni veniam, quod. Amet quibusdam id dicta corporis corrupti.', 'woolementor' ),
					],
					[
						'review_repeater_name' 		=> __( 'John Roe', 'woolementor' ),
						'review_repeater_comment' 	=> __( 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. In libero dicta porro veritatis, dignissimos perferendis harum illum consequatur qui nulla minima reiciendis voluptatibus delectus voluptas quis alias, laboriosam. Optio rerum doloribus similique molestiae obcaecati dolores ipsam laborum perspiciatis voluptatum officia assumenda repellat, magni veniam, quod. Amet quibusdam id dicta corporis corrupti.', 'woolementor' ),
					],
				],
				'title_field' 	=> '{{{ review_repeater_name }}}',
			]
		);

		$this->end_controls_section();

		/**
		 * Animation
		 */
		$this->start_controls_section(
			'section_content_settings',
			[
				'label' => __( 'Slider Animation', 'woolementor' ),
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
                'default' 		=> 'none',
                'frontend_available' => true,
                'style_transfer' => true,
            ]
        );

        $this->add_control(
			'arrow_icon_left',
			[
				'label' 		=> __( 'Arrow Icon Left', 'woolementor' ),
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
				'label' 		=> __( 'Arrow Icon Right', 'woolementor' ),
				'type' 			=> Controls_Manager::ICONS,
				'default' 		=> [
					'value' 	=> 'fa fa-chevron-right',
					'library' => 'solid',
				],
				'condition' 	=> [
                    'navigation' => array( 'arrow', 'both' ),
                ],
			]
		);

		$this->add_responsive_control(
            'slides_show',
            [
                'label' 			=> __( 'Show at Once', 'woolementor' ),
                'type' 				=> Controls_Manager::NUMBER,
                'max' 				=> 12,
				'desktop_default' 	=> 3,
				'tablet_default' 	=> 2,
				'mobile_default'	=> 1,
                'frontend_available' => true,
            ]
        );

		$this->end_controls_section();

		/**
		 * Style
		 * Card
		 */
		$this->start_controls_section(
            '_section_review_card_style',
            [
                'label' => __( 'Card', 'woolementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

		$this->add_responsive_control(
			'review_card_border_radius',
			[
				'label'         => __( 'Border Radius', 'woolementor' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', '%' ],
				'selectors'     => [
					'{{WRAPPER}} .wl-crvs-review-single' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'review_card_padding',
			[
				'label'         => __( 'Padding', 'woolementor' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', 'em' ],
				'selectors'     => [
					'{{WRAPPER}} .wl-crvs-review-single' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'review_card_margin',
			[
				'label'         => __( 'Margin', 'woolementor' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', 'em' ],
				'selectors'     => [
					'{{WRAPPER}} .wl-crvs-review-single' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
            'review_card_background_tabs_hr',
            [
                'type' => Controls_Manager::DIVIDER,
                'style' => 'thick',
            ]
        );

        $this->add_control(
			'review_card_background_heading',
			[
				'label' => __( 'Background', 'woolementor' ),
				'type' => Controls_Manager::HEADING,
			]
		);

        $this->start_controls_tabs( 'review_card_background_tabs' );

        $this->start_controls_tab(
            'review_card_background_normal',
            [
                'label' => __( 'Normal', 'woolementor' ),
            ]
        );

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'review_card_border_normal',
				'label'         => __( 'Border', 'woolementor' ),
				'selector'      => '{{WRAPPER}} .wl-crvs-review-single',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'review_card_background_normal',
				'label' => __( 'Background', 'woolementor' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .wl-crvs-review-single',
			]
		);

        $this->end_controls_tab();

        $this->start_controls_tab(
            'review_card_background_hover',
            [
                'label' => __( 'Hover', 'woolementor' ),
            ]
        );

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'review_card_border_hover',
				'label'         => __( 'Border', 'woolementor' ),
				'selector'      => '{{WRAPPER}} .wl-crvs-review-single:hover',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'review_card_background_color_hover',
				'label' => __( 'Background', 'woolementor' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .wl-crvs-review-single:hover',
			]
		);

		$this->add_control(
            'review_card_background_hover_transition',
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
                    '{{WRAPPER}} .wl-crvs-review-single:hover' => 'transition-duration: {{SIZE}}s',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

		/**
		 * Name
		 */
		$this->start_controls_section(
			'review_name_full',
			[
				'label' => __( 'Name', 'woolementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'review_name_switcher' => 'yes'
                ],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'review_name_typographyrs',
				'label' 	=> __( 'Typography', 'woolementor' ),
				'scheme' 	=> Typography::TYPOGRAPHY_3,
				'selector' 	=> '{{WRAPPER}} .wl-crvs-review-author h3',
			]
		);

		$this->start_controls_tabs(
            'review_name_tabs',
            [
                'separator' => 'before',
            ]
        );
		$this->start_controls_tab(
            'review_name',
            [
                'label' => __( 'Normal', 'woolementor' ),
            ]
        );  
        
		$this->add_group_control(
            Group_Control_Gradient_Text::get_type(),
            [
                'name' => 'review_name_color',
                'selector' => '{{WRAPPER}} .wl-crvs-review-author h3',
            ]
        );
		 
        $this->end_controls_tab();

		$this->start_controls_tab(
            'review_name_hover',
            [
                'label' => __( 'Hover', 'woolementor' ),
            ]
        ); 

        $this->add_group_control(
            Group_Control_Gradient_Text::get_type(),
            [
                'name' => 'review_name_color_hover',
                'selector' => '{{WRAPPER}} .wl-crvs-review-single:hover .wl-crvs-review-author h3',
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();

		$this->end_controls_section();

		/**
		 * Description
		 */
		$this->start_controls_section(
			'review_description_full',
			[
				'label' => __( 'Description', 'woolementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'review_name_switcher' => 'yes'
                ],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'review_description_typographyrs',
				'label' 	=> __( 'Typography', 'woolementor' ),
				'scheme' 	=> Typography::TYPOGRAPHY_3,
				'selector' 	=> '{{WRAPPER}} .wl-crvs-review-author-details span',
			]
		);

		$this->start_controls_tabs(
            'review_description_tabs',
            [
                'separator' => 'before',
            ]
        );
		$this->start_controls_tab(
            'review_description',
            [
                'label' => __( 'Normal', 'woolementor' ),
            ]
        );  

        $this->add_control(
			'review_description_color',
			[
				'label' => __( 'Text Color', 'woolementor' ),
				'type' => 	Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-crvs-review-author-details span' => 'color: {{VALUE}}',
				],
			]
		);
		 
        $this->end_controls_tab();

		$this->start_controls_tab(
            'review_description_hover',
            [
                'label' => __( 'Hover', 'woolementor' ),
            ]
        ); 

        $this->add_control(
			'review_description_color_hover',
			[
				'label' => __( 'Text Color', 'woolementor' ),
				'type' => 	Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-crvs-review-single:hover .wl-crvs-review-author-details span' => 'color: {{VALUE}}',
				],
			]
		);
        $this->end_controls_tab();
        $this->end_controls_tabs();

		$this->end_controls_section();

		/**
		 * Date
		 */
		$this->start_controls_section(
			'review_date_full',
			[
				'label' => __( 'Date', 'woolementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'review_date_switcher' => 'yes'
                ],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'review_date_typographyrs',
				'label' 	=> __( 'Typography', 'woolementor' ),
				'scheme' 	=> Typography::TYPOGRAPHY_3,
				'selector' 	=> '{{WRAPPER}} .wl-crvs-review-date',
			]
		);

		$this->start_controls_tabs(
            'review_date_tabs',
            [
                'separator' => 'before',
            ]
        );
		$this->start_controls_tab(
            'review_date',
            [
                'label' => __( 'Normal', 'woolementor' ),
            ]
        );        

		$this->add_control(
			'review_date_color',
			[
				'label' => __( 'Text Color', 'woolementor' ),
				'type' => 	Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-crvs-review-date' => 'color: {{VALUE}}',
				],
			]
		);
		 
        $this->end_controls_tab();

		$this->start_controls_tab(
            'review_date_hover',
            [
                'label' => __( 'Hover', 'woolementor' ),
            ]
        );        

		$this->add_control(
			'review_date_color_hover',
			[
				'label' => __( 'Text Color', 'woolementor' ),
				'type' => 	Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-crvs-review-single:hover .wl-crvs-review-date' => 'color: {{VALUE}}',
				],
			]
		);
        $this->end_controls_tab();
        $this->end_controls_tabs();

		$this->end_controls_section();

        /**
         * star_rating
         */
        $this->start_controls_section(
            'review_rating',
            [
                'label' 		=> __( 'Rating', 'woolementor' ),
                'tab'   		=> Controls_Manager::TAB_STYLE,
                'condition'     => [
                    'review_rating_switcher' => 'yes'
                ],
            ]
        );

        $this->add_control(
			'review_rating_blockicon',
			[
				'label' 		=> __( 'Block Icon', 'woolementor' ),
				'type' 			=> Controls_Manager::ICONS,
				'default' 		=> [
					'value' 	=> 'fas fa-star',
					'library' 	=> 'solid',
				],
			]
		);

        $this->add_control(
			'review_rating_half_blockicon',
			[
				'label' 		=> __( 'Half Block Icon', 'woolementor' ),
				'type' 			=> Controls_Manager::ICONS,
				'default' 		=> [
					'value' 	=> 'fas fa-star-half-alt',
					'library' 	=> 'solid',
				],
			]
		);

        $this->add_control(
			'review_rating_empty_icon',
			[
				'label' 		=> __( 'Empty Icon', 'woolementor' ),
				'type' 			=> Controls_Manager::ICONS,
				'default' 		=> [
					'value' 	=> 'far fa-star',
					'library' 	=> 'solid',
				],
			]
		);

        $this->add_responsive_control(
            'review_rating_icon_size',
            [
                'label'     	=> __( 'Icon Size', 'woolementor' ),
                'type'      	=> Controls_Manager::SLIDER,
                'size_units'	=> [ 'px', 'em' ],
                'selectors' 	=> [
                    '{{WRAPPER}} .wl-crvs-review-author-rating' => 'font-size: {{SIZE}}{{UNIT}}',
                ],
            ]
        );        

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'review_rating_box_border',
				'label' => __( 'Border', 'woolementor' ),
				'selector' => '{{WRAPPER}} .wl-crvs-review-author-rating',
				'separator' => 'before'
			]
		);

		$this->add_control(
            'review_rating_box_border_radius',
            [
                'label' => __( 'Border Radius', 'woolementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .wl-crvs-review-author-rating' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );		

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'review_rating_box_shadow',
				'label' => __( 'Box Shadow', 'woolementor' ),
				'selector' => '{{WRAPPER}} .wl-crvs-review-author-rating',
			]
		);

		$this->add_control(
			'review_rating_box_padding',
			[
				'label' => __( 'Padding', 'woolementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .wl-crvs-review-author-rating' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'review_rating_box_margin',
			[
				'label' => __( 'Margin', 'woolementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .wl-crvs-review-author-rating' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs(
            'review_rating_box_tabs',
            [
                'separator' => 'before',
            ]
        );
		$this->start_controls_tab(
            'review_rating_box',
            [
                'label' => __( 'Normal', 'woolementor' ),
            ]
        );

        $this->add_control(
			'review_rating_color',
			[
				'label' => __( 'Icon Color', 'woolementor' ),
				'type' => 	Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-crvs-review-author-rating i' => 'color: {{VALUE}}',
					'{{WRAPPER}} .wl-crvs-review-author-rating span strong' => 'color: {{VALUE}}',
				],
			]
		);	

        $this->add_control(
			'review_rating_box_bg_color',
			[
				'label' => __( 'Icon Background', 'woolementor' ),
				'type' => 	Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-crvs-review-author-rating' => 'background: {{VALUE}}',
				],
			]
		);
		 
        $this->end_controls_tab();

		$this->start_controls_tab(
            'review_rating_box_hover',
            [
                'label' => __( 'Hover', 'woolementor' ),
            ]
        );

        $this->add_control(
			'review_rating_color_hover',
			[
				'label' => __( 'Icon Color', 'woolementor' ),
				'type' => 	Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-crvs-review-single:hover .wl-crvs-review-author-rating i' => 'color: {{VALUE}}',
					'{{WRAPPER}} .wl-crvs-review-single:hover .wl-crvs-review-author-rating span strong' => 'color: {{VALUE}}',
				],
			]
		);	

        $this->add_control(
			'review_rating_box_bg_color_hover',
			[
				'label' => __( 'Icon Background', 'woolementor' ),
				'type' => 	Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-crvs-review-single:hover .wl-crvs-review-author-rating' => 'background: {{VALUE}}',
				],
			]
		);
        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();

		/**
		 * Comment
		 */
		$this->start_controls_section(
			'review_comment_full',
			[
				'label' => __( 'Comment', 'woolementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'review_comment_switcher' => 'yes'
                ],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'review_comment_typographyrs',
				'label' 	=> __( 'Typography', 'woolementor' ),
				'scheme' 	=> Typography::TYPOGRAPHY_3,
				'selector' 	=> '{{WRAPPER}} .wl-crvs-review-details p',
			]
		);

		$this->start_controls_tabs(
            'review_comment_tabs',
            [
                'separator' => 'before',
            ]
        );
		$this->start_controls_tab(
            'review_comment',
            [
                'label' => __( 'Normal', 'woolementor' ),
            ]
        );		

        $this->add_control(
			'review_comment_color',
			[
				'label' => __( 'Text Color', 'woolementor' ),
				'type' => 	Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-crvs-review-details p' => 'color: {{VALUE}}',
				],
			]
		);
		 
        $this->end_controls_tab();

		$this->start_controls_tab(
            'review_comment_hover',
            [
                'label' => __( 'Hover', 'woolementor' ),
            ]
        );

        $this->add_control(
			'review_comment_color_hover',
			[
				'label' => __( 'Text Color', 'woolementor' ),
				'type' => 	Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-crvs-review-single:hover .wl-crvs-review-details p' => 'color: {{VALUE}}',
				],
			]
		);
        $this->end_controls_tab();
        $this->end_controls_tabs();

		$this->end_controls_section();

		/**
		 * User Image controls
		 */
		$this->start_controls_section(
			'review_photo',
			[
				'label' => __( 'Photo', 'woolementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'review_photo_switcher' => 'yes'
                ],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' 		=> 'review_photo_thumbnail',
				'default' 	=> 'thumbnail',
			]
		);

		$this->add_responsive_control(
			'review_photo_width',
			[
				'label' 	=> __( 'Image Width', 'woolementor' ),
				'type' 		=> Controls_Manager::SLIDER,
				'size_units'=> [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .wl-crvs-review-img img' => 'width: {{SIZE}}{{UNIT}}',
				],
				'range' 	=> [
					'px' 	=> [
						'min' 	=> 1,
						'max' 	=> 300
					],
					'em' 	=> [
						'min' 	=> 1,
						'max' 	=> 30
					],
				],
			]
		);

		$this->add_responsive_control(
			'review_photo_height',
			[
				'label' 	=> __( 'Image Height', 'woolementor' ),
				'type' 		=> Controls_Manager::SLIDER,
				'size_units'=> [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .wl-crvs-review-img img' => 'height: {{SIZE}}{{UNIT}}',
				],
                'range'     => [
                    'px'    => [
                        'min'   => 1,
                        'max'   => 300
                    ],
                    'em'    => [
                        'min'   => 1,
                        'max'   => 30
                    ],
                ],
			]
		);

		$this->add_control(
			'review_photo_offset_toggle',
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
			'review_photo_image_transform_x',
			[
				'label' 	=> __( 'Image Transform X', 'woolementor' ),
				'type' 		=> Controls_Manager::SLIDER,
				'size_units'=> [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .wl-crvs-review-img' => 'top: {{SIZE}}{{UNIT}}',
				],
                'range'     => [
                    'px'    => [
                        'min'   => -200,
                        'max'   => 200
                    ],
                ],
				'condition' 	=> [
					'review_photo_offset_toggle' => 'yes'
				],
			]
		);

		$this->add_responsive_control(
			'review_photo_image_transform_Y',
			[
				'label' 	=> __( 'Image Transform Y', 'woolementor' ),
				'type' 		=> Controls_Manager::SLIDER,
				'size_units'=> [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .wl-crvs-review-img' => 'left: {{SIZE}}{{UNIT}}',
				],
                'range'     => [
                    'px'    => [
                        'min'   => -200,
                        'max'   => 200
                    ],
                ],
				'condition' 	=> [
					'review_photo_offset_toggle' => 'yes'
				],
			]
		);

		$this->end_popover();

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 		=> 'review_photo_border',
				'label' 	=> __( 'Border', 'woolementor' ),
				'selector' 	=> '{{WRAPPER}} .wl-crvs-review-img img',
			]
		);

		$this->add_responsive_control(
			'review_photo_border_radius',
			[
				'label' 		=> __( 'Border Radius', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%' ],
				'selectors' 	=> [
					'{{WRAPPER}} .wl-crvs-review-img img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' 		=> 'review_photo_box_shadow',
				'label' 	=> __( 'Box Shadow', 'woolementor' ),
				'selector' 	=> '{{WRAPPER}} .wl-crvs-review-img img',
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
					'{{WRAPPER}} .wl-crvs-review-silder .slick-next' => 'font-size: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .wl-crvs-review-silder .slick-prev' => 'font-size: {{SIZE}}{{UNIT}}',
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
					'{{WRAPPER}} .wl-crvs-review-silder .slick-next' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .wl-crvs-review-silder .slick-prev' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
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
                'label' 		=> __( 'Icon Color', 'woolementor' ),
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
                'label' => __( 'Icon Color', 'woolementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .slick-prev:hover, {{WRAPPER}} .slick-next:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'arrow_hover_bg_color',
            [
                'label' => __( 'Background Color', 'woolementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .slick-prev:hover, {{WRAPPER}} .slick-next:hover' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'arrow_hover_border_color',
            [
                'label' => __( 'Border Color', 'woolementor' ),
                'type' => Controls_Manager::COLOR,
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
					'{{WRAPPER}} .wl-crvs-review-silder .slick-dots li button::before' => 'font-size: {{SIZE}}{{UNIT}}',
				],
			]
		);

        $this->add_responsive_control(
            'dots_nav_position_y',
            [
                'label' => __( 'Vertical Position', 'woolementor' ),
                'type' => Controls_Manager::SLIDER,
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
                'type' => Controls_Manager::SLIDER,
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
                'type' => Controls_Manager::CHOOSE,
                'label_block' => false,
                'options' => [
                    'left' => [
                        'title' => __( 'Left', 'woolementor' ),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'woolementor' ),
                        'icon' => 'eicon-h-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'woolementor' ),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'toggle' => true,
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
                'type' => Controls_Manager::COLOR,
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
                'type' => Controls_Manager::COLOR,
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
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .slick-dots .slick-active button:before' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
		 * Quote
		 */
		$this->start_controls_section(
			'review_quote_full',
			[
				'label' => __( 'Quote', 'woolementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'review_quote_switcher' => 'yes'
                ],
			]
		);

		$this->add_responsive_control(
            'review_quote_size',
            [
                'label' => __( 'Icon Size', 'woolementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .wl-crvs-review-quote' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
			'review_quote_icon_left',
			[
				'label' => __( 'Left Icon', 'woolementor' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-quote-left',
					'library' => 'solid',
				],
			]
		);

        $this->add_control(
			'review_quote_icon_right',
			[
				'label' => __( 'Right Icon', 'woolementor' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-quote-right',
					'library' => 'solid',
				],
			]
		);
		$this->start_controls_tabs(
            'review_quote',
            [
                'separator' => 'before',
            ]
        );
		$this->start_controls_tab(
            'review_card_background',
            [
                'label' => __( 'Normal', 'woolementor' ),
            ]
        );

		$this->add_control(
			'review_quote_color',
			[
				'label' => __( 'Icon Color', 'woolementor' ),
				'type' => 	Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-crvs-review-quote' => 'color: {{VALUE}}',
				],
			]
		);
		 
        $this->end_controls_tab();

		$this->start_controls_tab(
            'review_quote_background_hover',
            [
                'label' => __( 'Hover', 'woolementor' ),
            ]
        );
        $this->add_control(
			'review_quote_color_hover',
			[
				'label' => __( 'Icon Color', 'woolementor' ),
				'type' => 	Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-crvs-review-single:hover .wl-crvs-review-quote' => 'color: {{VALUE}}',
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
