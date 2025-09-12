<?php
namespace codexpert\Woolementor;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Color;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use codexpert\Woolementor\Controls\Group_Control_Gradient_Text;

class Product_Sku extends Widget_Base {

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
			'_sectio_sku',
			[
				'label' 		=> __( 'Content', 'woolementor' ),
				'tab' 			=> Controls_Manager::TAB_CONTENT,
			]
		);

        $this->add_control(
			'product_sku_type',
			[
				'label' 		=> __( 'Content Source', 'woolementor' ),
				'type' 			=> Controls_Manager::SELECT2,
				'options' 		=> [
					'current_product'  	=> __( 'Current Product', 'woolementor' ),
					'custom_product'  	=> __( 'Custom Product', 'woolementor' ),
					'custom_text' 		=> __( 'Custom Text', 'woolementor' ),
				],
				'default' 		=> 'current_product',
				'label_block' 	=> true,
			]
		);

		$this->add_control(
            'product_id',
            [
                'label' 		=> __( 'Product Id', 'woolementor' ),
                'type' 			=> Controls_Manager::NUMBER,
                'default' 		=> 'Product id',
                'condition' 	=> [
                    'product_sku_type' => 'custom_product'
                ],
				'label_block' 	=> true,
            ]
        );

        $this->add_control(
            'product_custom_sku',
            [
                'label' 		=> __( 'SKU', 'woolementor' ),
                'type' 			=> Controls_Manager::TEXT,
                'default' 		=> 'Custom SKU',
                'condition' 	=> [
                    'product_sku_type' => 'custom_text'
                ],
				'label_block' 	=> true,
            ]
        );

        $this->add_control(
            'sku_label',
            [
                'label' 		=> __( 'Label', 'woolementor' ),
                'type' 			=> Controls_Manager::TEXT,
                'default' 		=> 'SKU: ',
				'label_block' 	=> true,
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
				'separator' 	=> 'before',
                'selectors' 	=> [
                    '{{WRAPPER}} .wl-product-sku' => 'text-align: {{VALUE}};'
                ]
            ]
        );

        $this->end_controls_section();

        /**
		 * Product sku label Style
		 */
		$this->start_controls_section(
			'section_style_sku_lable',
			[
				'label' => __( 'Label', 'woolementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'sku_label_background',
				'label' => __( 'Background', 'woolementor' ),
				'types' => [ 'classic', 'gradient' ],
				'separator' => 'after',
				'selector' => '{{WRAPPER}} .wl-product-sku .sku-label',
			]
		);

        $this->add_control(
        	'sku_label_color',
        	[
        		'label' => __( 'Text Color', 'woolementor' ),
        		'type' => Controls_Manager::COLOR,
        		'scheme' => [
        			'type' => Color::get_type(),
        			'value' => Color::COLOR_1,
        		],
        		'separator' => 'before',
        		'default' => '#000',
        		'selectors' => [
        			'{{WRAPPER}} .wl-product-sku .sku-label' => 'color: {{VALUE}}',
        		],
        	]
        );

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'sku_lable_typography',
				'label' 	=> __( 'Typography', 'woolementor' ),
				'scheme' 	=> Typography::TYPOGRAPHY_3,
				'selector' 	=> '{{WRAPPER}} .wl-product-sku .sku-label',
			]
		);

		$this->add_responsive_control(
			'sku_label_border_radius',
			[
				'label' 		=> __( 'Border Radius', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .wl-product-sku .sku-label' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'		=> 'after',
			]
		);

		$this->add_responsive_control(
			'sku_lable_padding',
			[
				'label' 		=> __( 'Padding', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .wl-product-sku .sku-label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'		=> 'before',
			]
		);

		$this->add_responsive_control(
			'sku_lable_margin',
			[
				'label' 		=> __( 'Margin', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .wl-product-sku .sku-label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section(); 

		/**
		 * Product sku Style
		 */
		$this->start_controls_section(
			'section_style_sku',
			[
				'label' => __( 'SKU', 'woolementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'sku_background',
				'label' => __( 'Background', 'woolementor' ),
				'types' => [ 'classic', 'gradient' ],
				'separator' => 'after',
				'selector' => '{{WRAPPER}} .wl-product-sku .sku',
			]
		);

        $this->add_control(
        	'sku_color',
        	[
        		'label' => __( 'Text Color', 'woolementor' ),
        		'type' => Controls_Manager::COLOR,
        		'scheme' => [
        			'type' => Color::get_type(),
        			'value' => Color::COLOR_1,
        		],
        		'separator' => 'before',
        		'default' => '#551FE8',
        		'selectors' => [
        			'{{WRAPPER}} .wl-product-sku .sku' => 'color: {{VALUE}}',
        		],
        	]
        );

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'sku_typography',
				'label' 	=> __( 'Typography', 'woolementor' ),
				'scheme' 	=> Typography::TYPOGRAPHY_3,
				'selector' 	=> '{{WRAPPER}} .wl-product-sku .sku',
			]
		);

		$this->add_responsive_control(
			'sku_border_radius',
			[
				'label' 		=> __( 'Border Radius', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .wl-product-sku .sku' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'		=> 'after',
			]
		);

		$this->add_responsive_control(
			'sku_padding',
			[
				'label' 		=> __( 'Padding', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .wl-product-sku .sku' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'		=> 'before',
			]
		);

		$this->add_responsive_control(
			'sku_margin',
			[
				'label' 		=> __( 'Margin', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .wl-product-sku .sku' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section(); 
	}

	protected function render() {

		$settings = $this->get_settings_for_display();
        extract( $settings );

        $this->render_editing_attributes();
        ?>

        <div class="wl-product-sku">

        	<?php do_action( 'woolementor_product_SKU_start' );

        	if( $product_sku_type == 'current_product' || $product_sku_type == 'custom_product' ): 
    			if( $product_sku_type == 'current_product' ) {        				
    				$product_id = get_the_ID();
    				if ( woolementor_is_edit_mode() || woolementor_is_preview_mode() ) {
    					$product_id = woolementor_get_product_id();
    				}
    				$product = wc_get_product( $product_id );
    			}

    			if( $product_sku_type == 'custom_product' ) $product = $product_id != '' ? wc_get_product( $product_id ) : '';

    			if ( $product && wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>

        		<p class="sku_wrapper">

        			<?php 
	        			printf( '<span %s>%s</span>',
							$this->get_render_attribute_string( 'sku_label' ),
							esc_html( $sku_label )
						);
        			?>

        			<span class="sku"><?php echo ( $sku = $product->get_sku() ) ? $sku : esc_html__( 'N/A', 'woocommerce' ); ?></span>
        		</p>

	        	<?php endif;

	        elseif( $product_sku_type == 'custom_text' ): ?>
	        	<p class="sku_wrapper">

	        		<?php 
	        			printf( '<span %s>%s</span>',
							$this->get_render_attribute_string( 'sku_label' ),
							esc_html( $sku_label )
						);

	        			printf( '<span %s>%s</span>',
							$this->get_render_attribute_string( 'product_custom_sku' ),
							esc_html( $product_custom_sku )
						);
        			?>
        			
	        	</p>
	        <?php endif;

	        do_action( 'woolementor_product_SKU_end' ); ?>

        </div>
        <?php
	}

	private function render_editing_attributes() {
		$this->add_inline_editing_attributes( 'sku_label', 'basic' );
		$this->add_render_attribute( 'sku_label', 'class', 'sku-label' );

        $this->add_inline_editing_attributes( 'product_custom_sku', 'basic' );
		$this->add_render_attribute( 'product_custom_sku', 'class', 'sku' );
	}
}

