<?php
namespace codexpert\Woolementor;

use Elementor\Repeater;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Color;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use codexpert\Woolementor\Controls\Group_Control_Gradient_Text;

class Product_Tags extends Widget_Base {

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
			'_sectio_tag',
			[
				'label' 		=> __( 'Content', 'woolementor' ),
				'tab' 			=> Controls_Manager::TAB_CONTENT,
			]
		);

        $this->add_control(
			'product_tag_type',
			[
				'label' 		=> __( 'Content Source', 'woolementor' ),
				'type' 			=> Controls_Manager::SELECT2,
				'options' 		=> [
					'current_product'  	=> __( 'Current Product', 'woolementor' ),
					'custom_product'  	=> __( 'Custom Product', 'woolementor' ),
					'custom_tag' 		=> __( 'Custom Text', 'woolementor' ),
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
                    'product_tag_type' => 'custom_product'
                ],
				'label_block' 	=> true,
            ]
        );

        $this->add_control(
            'tag_label',
            [
                'label' 		=> __( 'Label', 'woolementor' ),
                'type' 			=> Controls_Manager::TEXT,
                'default' 		=> 'Tag: ',                
				'label_block' 	=> true,
            ]
        );

        $repeater = new Repeater();

		$repeater->add_control(
			'tag_name', [
				'label' => __( 'Tag Name', 'woolementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'New tag' , 'woolementor' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'tag_link',
			[
				'label' 		=> __( 'Link', 'woolementor' ),
				'type' 			=> Controls_Manager::URL,
				'placeholder' 	=> __( 'https://your-link.com', 'woolementor' ),
				'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => false,
					'nofollow' => false,
				],
			]
		);

		$this->add_control(
			'tags_list',
			[
				'label' => __( 'Tag List', 'woolementor' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'tag_name' => __( 'tag #1', 'woolementor' ),
						'tag_link' => [
							'url' => 'https://woolementor.com',
							'is_external' => false,
							'nofollow' => false,
						],
					],
					[
						'tag_name' => __( 'tag #2', 'woolementor' ),
						'tag_link' => [
							'url' => 'https://woolementor.com',
							'is_external' => false,
							'nofollow' => false,
						],
					],
				],
                'condition' 	=> [
                    'product_tag_type' => 'custom_tag'
                ],
				'title_field' => '{{{ tag_name }}}',
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
                    '{{WRAPPER}} .wl-product-tags' => 'text-align: {{VALUE}};'
                ]
            ]
        );

        $this->end_controls_section();

        /**
		 * Product sku label Style
		 */
		$this->start_controls_section(
			'section_style_tag_lable',
			[
				'label' => __( 'Label', 'woolementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'tag_label_background',
				'label' => __( 'Background', 'woolementor' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .wl-product-tags .tag-label',
			]
		);

		$this->add_control(
			'tag_label_color',
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
					'{{WRAPPER}} .wl-product-tags .tag-label' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'tag_lable_typography',
				'label' 	=> __( 'Typography', 'woolementor' ),
				'scheme' 	=> Typography::TYPOGRAPHY_3,
				'selector' 	=> '{{WRAPPER}} .wl-product-tags .tag-label',
			]
		);

		$this->add_responsive_control(
			'tag_label_border_radius',
			[
				'label' 		=> __( 'Border Radius', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .wl-product-tags .tag-label' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'		=> 'after',
			]
		);

		$this->add_responsive_control(
			'tag_lable_padding',
			[
				'label' 		=> __( 'Padding', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .wl-product-tags .tag-label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'		=> 'before',
			]
		);

		$this->add_responsive_control(
			'tag_lable_margin',
			[
				'label' 		=> __( 'Margin', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .wl-product-tags .tag-label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section(); 

		/**
		 * Product categories Style
		 */
		$this->start_controls_section(
			'section_style_tag',
			[
				'label' => __( 'Tags', 'woolementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'tag_background',
				'label' => __( 'Background', 'woolementor' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .wl-product-tags .tags_wrapper a',
			]
		);

		$this->add_control(
			'tag_color',
			[
				'label' => __( 'Text Color', 'woolementor' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Color::get_type(),
					'value' => Color::COLOR_1,
				],
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .wl-product-tags .tags_wrapper a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'tag_typography',
				'label' 	=> __( 'Typography', 'woolementor' ),
				'scheme' 	=> Typography::TYPOGRAPHY_3,
				'selector' 	=> '{{WRAPPER}} .wl-product-tags .tags_wrapper a',
			]
		);

		$this->add_responsive_control(
			'tag_border_radius',
			[
				'label' 		=> __( 'Border Radius', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .wl-product-tags .tags_wrapper a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'		=> 'after',
			]
		);

		$this->add_responsive_control(
			'tag_padding',
			[
				'label' 		=> __( 'Padding', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .wl-product-tags .tags_wrapper a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'		=> 'before',
			]
		);

		$this->add_responsive_control(
			'tag_margin',
			[
				'label' 		=> __( 'Margin', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .wl-product-tags .tags_wrapper a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

        <div class="wl-product-tags">

        	<?php do_action( 'woolementor_product_tag_start' );
        	
        	 if( $product_tag_type == 'current_product' || $product_tag_type == 'custom_product' ): 
        			if( $product_tag_type == 'current_product' ) {

        				$product_id = get_the_ID();
        				
        				if ( woolementor_is_edit_mode() || woolementor_is_preview_mode() ) {
        					$product_id = woolementor_get_product_id();
        				}
        				$product = wc_get_product( $product_id );
        			}
        			if( $product_tag_type == 'custom_product' ) {
        				$product = $product_id != '' ? wc_get_product( $product_id ) : '';

        				if( $product_id == '' || !$product ) {
        					echo "Input valid Product ID"; return;
        				}
        			}

        			if( $product && is_object( $product ) ){
        				?>
        				<span class="tags_wrapper">
				        	<?php echo wc_get_product_tag_list( $product->get_id(), ', ', '<span class="tagged_as">' . _n( '<span '. $this->get_render_attribute_string( 'tag_label' ) .'>'. esc_html( $tag_label ) .'</span>', '<span '. $this->get_render_attribute_string( 'tag_label' ) .'>'. esc_html( $tag_label ) .'</span>', count( $product->get_tag_ids() ), 'woocommerce' ) . ' ', '</span>' ); ?>
				        </span>
        				<?php
        			}
        		?>

	        <?php elseif( $product_tag_type == 'custom_tag' ): ?>
	        	<span class="tags_wrapper">

	        		<?php 
        			printf( '<span %s>%s</span>',
						$this->get_render_attribute_string( 'tag_label' ),
						esc_html( $tag_label )
					);
        			?>

	        		<span class="tag-items">
	        			<?php 
	        			$last_item = end( $tags_list );
	        			foreach ($tags_list as $key => $tag) {
	        				$separator = isset( $tag['_id'] ) && $tag['_id'] != $last_item['_id'] ? ', ' : '';
	        				$target = isset( $tag['is_external'] ) && $tag['is_external'] ? ' target="_blank"' : '';
    						$nofollow = isset( $tag['nofollow'] ) && $tag['nofollow'] ? ' rel="nofollow"' : '';
	        				echo '<a href="'. $tag['tag_link']['url'] .'" '. $target . $nofollow .' class="tag-item">'.  $tag['tag_name'] . $separator .'</a>';
	        			}
	        			 ?>
	        		</span>
	        	</span>
	        <?php endif; ?>

        	<?php do_action( 'woolementor_product_tag_end' ); ?>

        </div>

        <?php
	}

	private function render_editing_attributes() {
		$this->add_inline_editing_attributes( 'tag_label', 'basic' );
		$this->add_render_attribute( 'tag_label', 'class', 'tag-label' );
	}
}

