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

class Product_Add_To_Wishlist extends Widget_Base {

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
		return [ 'fancybox' ];
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
		 * Repeater Tabs
		 */
		$this->start_controls_section(
			'add_to_wishlist_section',
			[
				'label' 		=> __( 'Add to wishlist', 'plugin-name' ),
				'tab' 			=> Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'button_type',
			[
				'label' 	=> __( 'Button Type', 'woolementor' ),
				'type' 		=> Controls_Manager::SELECT,
				'options'	=> [
					'text' => __( 'Text', 'woolementor' ),
					'icon' => __( 'Icon', 'woolementor' )
				],
				'default' 		=> 'icon',
			]
		);

		$this->add_control(
			'button_text',
			[
				'label' 		=> __( 'Button Text', 'woolementor' ),
				'type' 			=> Controls_Manager::TEXT,
				'default' 		=> __( 'Add to wishlist', 'woolementor' ),
				'placeholder' 	=> __( 'Type your title here', 'woolementor' ),
                'condition'     => [
                    'button_type' => 'text'
                ],
			]
		);

		$this->add_control(
		    'wishlist_icon',
		    [
		        'label'         => __( 'Icon', 'woolementor' ),
		        'type'          => Controls_Manager::ICONS,
		        'fa4compatibility' => 'icon',
                'condition'     => [
                    'button_type' => 'icon'
                ],
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

		$this->add_control(
		    'alignment',
		    [
		        'label'     	=> __( 'Button Alignment', 'woolementor-pro' ),
		        'type'      	=>Controls_Manager::CHOOSE,
		        'options'   	=> [
		            'left' 	=> [
		                'title'     => __( 'Left', 'woolementor-pro' ),
		                'icon'      => 'fa fa-align-left',
		            ],
		            'center' => [
		                'title'     => __( 'Center', 'woolementor-pro' ),
		                'icon'      => 'fa fa-align-center',
		            ],
		            'right' => [
		                'title'     => __( 'Right', 'woolementor-pro' ),
		                'icon'      => 'fa fa-align-right',
		            ],
		        ],
		        'default'  		=> 'left',		        
		        'selectors' => [
		            '{{WRAPPER}} .wl-add-to-wishlist' => 'text-align: {{VALUE}}',
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
            ]
        );

        $this->add_responsive_control(
            'wishlist_icon_size',
            [
                'label'     => __( 'Icon Size', 'woolementor' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units'=> [ 'px', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .wl-add-to-wishlist .wl-wish-button i' => 'font-size: {{SIZE}}{{UNIT}}',
                ],
                'condition'     => [
                    'button_type' => 'icon'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      	=> 'title_typography',
                'label'     	=> __( 'Typography', 'woolementor-pro' ),
                'scheme'    	=> Typography::TYPOGRAPHY_3,
                'selector'  	=> '{{WRAPPER}} .wl-add-to-wishlist .wl-wish-button',
                'condition'     => [
                    'button_type' => 'text'
                ],
            ]
        );

        $this->add_responsive_control(
            'wishlist_padding',
            [
                'label'         => __( 'Padding', 'woolementor' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%' ],
                'selectors'     => [
                    '{{WRAPPER}} .wl-add-to-wishlist .wl-wish-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'wishlist_border_radius',
            [
                'label'         => __( 'Border Radius', 'woolementor' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%' ],
                'selectors'     => [
                    '{{WRAPPER}} .wl-add-to-wishlist .wl-wish-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs(
            'wishlist_normal_separator',
            [
                'separator' => 'before'
            ]
        );

        $this->start_controls_tab(
            'wishlist_normal',
            [
                'label'     => __( 'Normal', 'woolementor' ),
            ]
        );

        $this->add_control(
            'wishlist_icon_color',
            [
                'label'     => __( 'Color', 'woolementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wl-add-to-wishlist .wl-wish-button' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'wishlist_icon_bg',
            [
                'label'     => __( 'Background', 'woolementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wl-add-to-wishlist .wl-wish-button' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'wishlist_border',
                'label'         => __( 'Border', 'woolementor' ),
                'selector'      => '{{WRAPPER}} .wl-add-to-wishlist .wl-wish-button',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'wishlist_hover',
            [
                'label'     => __( 'Hover', 'woolementor' ),
            ]
        );

        $this->add_control(
            'wishlist_icon_color_hover',
            [
                'label'     => __( 'Color', 'woolementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wl-add-to-wishlist .wl-wish-button:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'wishlist_icon_bg_hover',
            [
                'label'     => __( 'Background', 'woolementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wl-add-to-wishlist .wl-wish-button:hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'wishlist_border_hover',
                'label'         => __( 'Border', 'woolementor' ),
                'selector'      => '{{WRAPPER}} .wl-add-to-wishlist .wl-wish-button:hover',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'wishlist_active',
            [
                'label'     => __( 'Active', 'woolementor' ),
            ]
        );

        $this->add_control(
            'wishlist_icon_color_active',
            [
                'label'     => __( 'Color', 'woolementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wl-add-to-wishlist .wl-wish-button.ajax_add_to_wish.fav-item' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'wishlist_icon_bg_active',
            [
                'label'     => __( 'Background', 'woolementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wl-add-to-wishlist .wl-wish-button.ajax_add_to_wish.fav-item i' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'wishlist_border_active',
                'label'         => __( 'Border', 'woolementor' ),
                'selector'      => '{{WRAPPER}} .wl-add-to-wishlist .wl-wish-button.ajax_add_to_wish.fav-item i',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
	}

	protected function woolementor_get_product_type() {

		$product_id = get_the_ID();
		$product 	= wc_get_product( $product_id );

		if ( $product ) {
			return $product->get_type();
		}

		return false;
			
	}

	protected function render() {

		$settings 	= $this->get_settings_for_display();
		extract( $settings );

		$this->render_editing_attributes();

		$product_id = get_the_ID();
		if ( woolementor_is_edit_mode() || woolementor_is_preview_mode() ) {
			$product_id 	= woolementor_get_product_id();
		}
		$product 	= wc_get_product( $product_id );

		if ( !$product ) {
			_e( 'This is not a product or an invalid ID is provided.', 'woolementor' );
			return;
		}

		if( woolementor_is_live_mode() ) {
			wc_print_notices();
		}

		$user_id  = get_current_user_id();
		$wishlist = woolementor_get_wishlist( $user_id );
		$fav_product = in_array( $product->get_ID(), $wishlist );

		if ( !empty( $fav_product ) ) {
		    $fav_item = 'fav-item';
		}
		else{
		    $fav_item = '';
		}
		if( !apply_filters( 'woolementor-pro_default_wishlist_icon', true, $product ) ) return;

		$title = __( "Add to Wishlist", "woolementor-pro" );
		if ( $button_type == 'icon' ) {
			$button_text = "<i class='{$wishlist_icon["value"]}'></i>";
		}
		echo '<div class="wl-add-to-wishlist"><button class="ajax_add_to_wish wl-wish-button' . $fav_item . '" title="' . $title . '" data-product_id="' . $product->get_ID() . '">
                ' . $button_text . '
            </button></div>';
	}

	private function render_editing_attributes() {
		$this->add_inline_editing_attributes( 'add_to_wishlist_text', 'basic' );
		$this->add_render_attribute( 'add_to_wishlist_text', 'class', 'single_add_to_wishlist_button button al' );
	}
}
