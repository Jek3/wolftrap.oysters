<?php
namespace codexpert\Woolementor;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Typography;
use codexpert\Woolementor\Controls\Group_Control_Gradient_Text;

class Product_Title extends Widget_Base {

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
		return [ "woolementor-{$this->id}", 'fancybox' ];
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
		 * Product Title
		 */
		$this->start_controls_section(
			'_sectio_title',
			[
				'label' 		=> __( 'Product Title', 'woolementor' ),
				'tab' 			=> Controls_Manager::TAB_CONTENT,
			]
		);

        $this->add_control(
			'product_title_type',
			[
				'label' 		=> __( 'Content Source', 'woolementor' ),
				'type' 			=> Controls_Manager::SELECT2,
				'options' 		=> [
					'default_title'  	=> __( 'Current Product', 'woolementor' ),
					'custom_text' 		=> __( 'Custom', 'woolementor' ),
				],
				'default' 		=> 'default_title',
				'label_block' 	=> true,
			]
		);

		$this->add_control(
            'product_title',
            [
                'label' 		=> __( 'Title', 'woolementor' ),
                'type' 			=> Controls_Manager::TEXT,
                'default' 		=> 'Your Title',
                'condition' 	=> [
                    'product_title_type' => 'custom_text'
                ],
				'label_block' 	=> true,
            ]
        );

        $this->add_control(
            'title_tag',
            [
                'label' 		=> __( 'Title HTML Tag', 'woolementor' ),
                'type' 			=> Controls_Manager::CHOOSE,
                'options' 		=> [
                    'h1'  		=> [
                        'title' 	=> __( 'H1', 'woolementor' ),
                        'icon' 		=> 'eicon-editor-h1'
                    ],
                    'h2'  		=> [
                        'title' 	=> __( 'H2', 'woolementor' ),
                        'icon' 		=> 'eicon-editor-h2'
                    ],
                    'h3'  		=> [
                        'title' 	=> __( 'H3', 'woolementor' ),
                        'icon' 		=> 'eicon-editor-h3'
                    ],
                    'h4'  		=> [
                        'title' 	=> __( 'H4', 'woolementor' ),
                        'icon' 		=> 'eicon-editor-h4'
                    ],
                    'h5'  		=> [
                        'title' 	=> __( 'H5', 'woolementor' ),
                        'icon' 		=> 'eicon-editor-h5'
                    ],
                    'h6'  		=> [
                        'title' 	=> __( 'H6', 'woolementor' ),
                        'icon' 		=> 'eicon-editor-h6'
                    ]
                ],
                'default' 		=> 'h3',
                'toggle' 		=> false,
            ]
        );

        $this->add_responsive_control(
            'align',
            [
                'label' 		=> __( 'Alignment', 'woolementor' ),
                'type' 			=> Controls_Manager::CHOOSE,
                'options' 		=> [
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
                'toggle' 		=> true,
                'default' 		=> 'left',
                'selectors' 	=> [
                    '{{WRAPPER}} .wl-product-title' => 'text-align: {{VALUE}};'
                ]
            ]
        );

		$this->add_control(
			'link',
			[
				'label' 		=> __( 'Enable Hyperlink', 'woolementor' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'On', 'woolementor' ),
				'label_off' 	=> __( 'Off', 'woolementor' ),
				'return_value' 	=> 'on',
				'default' 		=> 'off',
			]
		);

		$this->add_control(
			'custom_link',
			[
				'label' 		=> __( 'Link', 'woolementor' ),
				'type' 			=> Controls_Manager::URL,
				'placeholder' 	=> __( 'https://your-link.com', 'woolementor' ),
				'show_external' => true,
				'default' 		=> [
					'url' 			=> get_permalink( get_the_ID() ),
					'is_external' 	=> false,
					'nofollow' 		=> false,
				],
                'condition' 	=> [
                    'link' 		=> 'on'
                ],
			]
		);

        $this->end_controls_section();

        /**
		 * Product Title Style
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
                'selector' => '{{WRAPPER}} .wl-product-title, {{WRAPPER}} .wl-product-title a',
            ]
        );

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'title_typography',
				'label' 	=> __( 'Typography', 'woolementor' ),
				'scheme' 	=> Typography::TYPOGRAPHY_3,
				'selector' 	=> '{{WRAPPER}} .wl-product-title',
			]
		);

		$this->add_responsive_control(
			'title_padding',
			[
				'label' 		=> __( 'Padding', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .wl-product-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'		=> 'before',
			]
		);

		$this->add_responsive_control(
			'title_margin',
			[
				'label' 		=> __( 'Margin', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .wl-product-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {

		$settings = $this->get_settings_for_display();

        $this->add_render_attribute( 'product_title', 'class', 'wl-product-title' );

        extract( $settings );
        
		if ( 'default_title' == $product_title_type ) {
			$product_title = get_the_title();
			if ( woolementor_is_edit_mode() || woolementor_is_preview_mode() ) {
				$product_id 	= woolementor_get_product_id();
				$product 		= wc_get_product( $product_id );
				$product_title 	= $product->get_name();
			}
		}
		else{
			$this->add_inline_editing_attributes( 'product_title', 'basic' );
		}

        
        if ( 'on' == $link ) {
        	$target 	= $settings['custom_link']['is_external'] ? ' target="_blank"' : '';
			$nofollow 	= $settings['custom_link']['nofollow'] ? ' rel="nofollow"' : '';

        	printf( '<%1$s %2$s><a href="%4$s" %5$s %6$s>%3$s</a></%1$s>',
	            esc_attr( $title_tag ),
	            $this->get_render_attribute_string( 'product_title' ),
	            esc_html( $product_title ),
	            esc_url( $settings['custom_link']['url'] ),
	            esc_attr( $target ),
	            esc_attr( $nofollow )
	        );
        }
        else {
        	printf( '<%1$s %2$s>%3$s</%1$s>',
	            esc_attr( $title_tag ),
	            $this->get_render_attribute_string( 'product_title' ),
	            esc_html( $product_title ) 
	        );
        }
	}
}

