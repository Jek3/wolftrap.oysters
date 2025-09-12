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

class category extends Widget_Base {

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
		 * Settings controls
		 */
		$this->start_controls_section(
            '_section_settings',
            [
                'label' => __( 'Layout', 'woolementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

		$this->add_responsive_control(
            'columns',
            [
                'label'     => __( 'Columns', 'woolementor' ),
                'type' 	    => Controls_Manager::SELECT2,
                'options'   => [
                    1 => __( '1 Column', 'woolementor' ),
                    2 => __( '2 Columns', 'woolementor' ),
                    3 => __( '3 Columns', 'woolementor' ),
                    4 => __( '4 Columns', 'woolementor' ),
                    6 => __( '6 Columns', 'woolementor' ),
                ],
                'separator' 		=> 'before',
                'desktop_default' 	=> 3,
                'tablet_default' 	=> 2,
                'mobile_default' 	=> 1,
                'style_transfer' 	=> true,
            ]
        );

        $this->add_control(
			'alignment',
			[
				'label'		=> __( 'Content Layout', 'woolementor' ),
				'type' 		=>Controls_Manager::CHOOSE,
				'options' 	=> [
					'left' 	=> [
						'title' 	=> __( 'Image Left', 'woolementor' ),
						'icon' 		=> 'fa fa-align-left',
					],
					'full' 	=> [
						'title' 	=> __( 'Image Full Width', 'woolementor' ),
						'icon' 		=> 'fa fa-arrows-alt',
					],
                    'right'     => [
                        'title'     => __( 'Image Right', 'woolementor' ),
                        'icon'      => 'fa fa-align-right',
                    ],
				],
				'default' 	=> 'left',
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
                'type'          => Controls_Manager::SELECT2,
                'default'       => 'name',
                'options'       => woolementor_order_options(),
            ]
        );

        $this->add_control(
            'hide_empty',
            [
                'label'         => __( 'Hide empty categories', 'woolementor' ),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => __( 'Show', 'woolementor' ),
                'label_off'     => __( 'Hide', 'woolementor' ),
                'return_value'  => 'yes',
                'default'       => 'yes',
            ]
        );

        $this->add_control(
            'custom_query',
            [
                'label'         => __( 'Custom Query', 'woolementor' ),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => __( 'Show', 'woolementor' ),
                'label_off'     => __( 'Hide', 'woolementor' ),
                'return_value'  => 'yes',
                'default'       => '',
            ]
        );

        $this->start_controls_tabs(
            'custom_query_controlls',
            [
                'condition'     => [
                    'custom_query' => 'yes'
                ],
            ]
        );

        $this->start_controls_tab(
            'custom_query_tab',
            [
                'label'     => __( 'Custom Query', 'woolementor' ),
                
            ]
        );

        $this->add_control(
            'exclude',
            [
                'label'     => __( 'Exclude Category', 'woolementor' ),
                'type'      => Controls_Manager::SELECT2,
                'options'   => woolementor_get_terms(),
                'multiple'  => true,
                'label_block' => true,
            ]
        );

        $this->add_control(
            'child_of',
            [
                'label'     => __( 'Parent ID', 'woolementor' ),
                'description'    => __( 'Select Category for subcategory.', 'woolementor' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => woolementor_get_terms(),
                'multiple'  => true,
                'label_block' => true,
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
			'image_show_hide',
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
		 * Sale Ribbon controls
		 */
		$this->start_controls_section(
            'section_content_product_count',
            [
                'label' => __( 'Product Count', 'woolementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
			'product_count',
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
		 * Category Style controls
		 */
		$this->start_controls_section(
            'style_section_box',
            [
                'label' => __( 'Card', 'woolementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'widget_card_height',
            [
                'label'     => __( 'Card Height', 'woolementor' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units'=> [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .wl-category' => 'height: {{SIZE}}{{UNIT}}',
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
			Group_Control_Box_Shadow::get_type(),
			[
				'name' 		=> 'widget_card_shadow',
				'label' 	=> __( 'Box Shadow', 'woolementor' ),
				'selector' 	=> '{{WRAPPER}} .wl-category',
			]
		);

		$this->add_responsive_control(
			'widget_card_shadow_padding',
			[
				'label' 		=> __( 'Padding', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .wl-category' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_responsive_control(
            'widget_card_shadow_margin',
            [
                'label'         => __( 'Margin', 'woolementor' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%', 'em' ],
                'selectors'     => [
                    '{{WRAPPER}} .wl-category' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs(
            'card_hover_section',
            [
                'separator' => 'before'
            ]
        );

        $this->start_controls_tab( 
            'card_normal',
            [
                'label'     => __( 'Normal', 'woolementor' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'widget_card_background',
                'label'     => __( 'Background', 'woolementor' ),
                'types'     => [ 'classic', 'gradient' ],
                'selector'  => '{{WRAPPER}} .wl-category',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'widget_card_border',
                'label'     => __( 'Border', 'woolementor' ),
                'selector'  => '{{WRAPPER}} .wl-category',
                'separator' => 'before'
            ]
        );

        $this->end_controls_tab();
        $this->start_controls_tab( 
            'card_hover',
            [
                'label'     => __( 'Hover', 'woolementor' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'widget_card_background_hover',
                'label'     => __( 'Background', 'woolementor' ),
                'types'     => [ 'classic', 'gradient' ],
                'selector'  => '{{WRAPPER}} .wl-category:hover',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'widget_card_border_hover',
                'label'     => __( 'Border', 'woolementor' ),
                'selector'  => '{{WRAPPER}} .wl-category:hover',
                'separator' => 'before'
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_responsive_control(
            'card_border_radius',
            [
                'label'         => __( 'Border Radius', 'woolementor' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%', 'em' ],
                'selectors'     => [
                    '{{WRAPPER}} .wl-category' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

		$this->end_controls_section();

        /**
         * Category Image
         */
        $this->start_controls_section(
            'section_style_image',
            [
                'label' => __( 'Image', 'woolementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'widget_image_height',
            [
                'label'     => __( 'Image Height', 'woolementor' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units'=> [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .wl-category .wl-ctgry-img.left img' => 'height: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .wl-category .wl-ctgry-img.right img' => 'height: {{SIZE}}{{UNIT}}',
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
            'image_border_radius',
            [
                'label'         => __( 'Border Radius', 'woolementor' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%', 'em' ],
                'selectors'     => [
                    '{{WRAPPER}} .wl-ctgry-img img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * Category Title
         */
        $this->start_controls_section(
            'section_style_title',
            [
                'label' => __( 'Title', 'woolementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'title_typography',
				'label' 	=> __( 'Typography', 'woolementor' ),
				'scheme' 	=> Typography::TYPOGRAPHY_3,
				'selector' 	=> '{{WRAPPER}} .wl-ctgry-title',
			]
		);
        $this->start_controls_tabs(
            'title_hover_section',
            [
                'separator' => 'before'
            ]
        );

        $this->start_controls_tab( 
            'title_normal',
            [
                'label'     => __( 'Normal', 'woolementor' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Gradient_Text::get_type(),
            [
                'name'      => 'title_color',
                'selector'  => '{{WRAPPER}} .wl-ctgry-title',
            ]
        );

        $this->end_controls_tab();
        $this->start_controls_tab( 
            'title_hover',
            [
                'label'     => __( 'Hover', 'woolementor' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Gradient_Text::get_type(),
            [
                'name'      => 'title_color_hover',
                'selector'  => '{{WRAPPER}} .wl-ctgry-title:hover',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();


        /**
         * Category Description
         */
        $this->start_controls_section(
            'section_style_count',
            [
                'label' => __( 'Product Count', 'woolementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'desc_typography',
                'label'     => __( 'Typography', 'woolementor' ),
                'scheme'    => Typography::TYPOGRAPHY_3,
                'selector'  => '{{WRAPPER}} .wl-ctgry-desc',
            ]
        );
        $this->start_controls_tabs(
            'desc_hover_section',
            [
                'separator' => 'before'
            ]
        );

        $this->start_controls_tab( 
            'desc_normal',
            [
                'label'     => __( 'Normal', 'woolementor' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Gradient_Text::get_type(),
            [
                'name'      => 'desc_color',
                'selector'  => '{{WRAPPER}} .wl-ctgry-desc',
            ]
        );

        $this->end_controls_tab();
        $this->start_controls_tab( 
            'desc_hover',
            [
                'label'     => __( 'Hover', 'woolementor' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Gradient_Text::get_type(),
            [
                'name'      => 'desc_color_hover',
                'selector'  => '{{WRAPPER}} .wl-ctgry-desc:hover',
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