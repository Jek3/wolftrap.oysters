<?php
namespace codexpert\Woolementor;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Color;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Typography;
use codexpert\Woolementor\Controls\Group_Control_Gradient_Text;

class Product_Variations extends Widget_Base {

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
		 * Product Title
		 */
		$this->start_controls_section(
			'_variation_items',
			[
				'label' 		=> __( 'Show Items', 'woolementor' ),
				'tab' 			=> Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
            'content_source',
            [
                'label'         => __( 'Content Source', 'woolementor' ),
                'type'          => Controls_Manager::SELECT2,
                'options'       => [
                    'current_product'   => __( 'Current Product', 'woolementor' ),
                    'custom'            => __( 'Custom', 'woolementor' ),
                ],
                'default'       => 'current_product' ,
                'label_block'   => true,
            ]
        );

		$this->add_control(
		    'main_product_id',
		    [
		        'label'     => __( 'Product ID', 'woolementor' ),
		        'type'      => Controls_Manager::NUMBER,
		        'default'   => get_post_type( get_the_ID() ) == 'product' ? get_the_ID() : '',
		        'description'  => __( 'Input the base product ID', 'woolementor' ),		        
				'separator' 	=> 'after',
                'condition'     => [
                    'content_source' => 'custom'
                ],
		    ]
		);

		$this->add_control(
			'variation_desc_show_hide',
			[
				'label' 	=> __( 'Show Description', 'woolementor' ),
				'type' 		=> Controls_Manager::SWITCHER,
				'label_on' 	=> __( 'Show', 'woolementor' ),
				'label_off' => __( 'Hide', 'woolementor' ),
				'return_value' 	=> 'yes',
				'default' 		=> 'yes',
			]
		);

        $this->add_control(
			'product_desc_words_count',
			[
				'label' 		=> __( 'Words Count', 'woolementor' ),
				'type' 			=> Controls_Manager::NUMBER,
				'default' 		=> 4,
				'separator' 	=> 'after',
				'condition' => [
                    'variation_desc_show_hide' => 'yes'
                ],
			]
		);

		$this->add_control(
			'variation_attr_show_hide',
			[
				'label' 	=> __( 'Show Attributes', 'woolementor' ),
				'type' 		=> Controls_Manager::SWITCHER,
				'label_on' 	=> __( 'Show', 'woolementor' ),
				'label_off' => __( 'Hide', 'woolementor' ),
				'return_value' 	=> 'yes',
				'default' 		=> 'yes',
			]
		);

		$this->add_control(
			'variation_qty_show_hide',
			[
				'label' 	=> __( 'Show Quantity field', 'woolementor' ),
				'type' 		=> Controls_Manager::SWITCHER,
				'label_on' 	=> __( 'Show', 'woolementor' ),
				'label_off' => __( 'Hide', 'woolementor' ),
				'return_value' 	=> 'yes',
				'default' 		=> 'yes',
			]
		);

		$this->add_control(
			'variation_price_show_hide',
			[
				'label' 	=> __( 'Show Price', 'woolementor' ),
				'type' 		=> Controls_Manager::SWITCHER,
				'label_on' 	=> __( 'Show', 'woolementor' ),
				'label_off' => __( 'Hide', 'woolementor' ),
				'return_value' 	=> 'yes',
				'default' 		=> 'yes',
			]
		);

		$this->add_control(
			'variation_old_price_show_hide',
			[
				'label'			=> __( 'Show Sale Price', 'woolementor' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'Show', 'your-plugin' ),
				'label_off' 	=> __( 'Hide', 'your-plugin' ),
				'return_value' 	=> 'block',
				'default' 		=> 'block',
				'separator' 	=> 'after',
				'condition' => [
                    'variation_price_show_hide' => 'yes'
                ],
				'selectors' 	=> [
                    '{{WRAPPER}} .wl-pl-item-total span del' => 'display: {{VALUE}}',
                ],
			]
		);

        $this->end_controls_section();

        /**
		 * card Style
		 */
		$this->start_controls_section(
			'card_style',
			[
				'label' => __( 'Card', 'woolementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'card_bg_color',
                'selector' => '{{WRAPPER}} .wl-pl-pricelist-single',
            ]
        );

		$this->add_responsive_control(
		    'card_border_radius',
		    [
		        'label'         => __( 'Border Raidus', 'woolementor' ),
		        'type'          => Controls_Manager::DIMENSIONS,
		        'size_units'    => [ 'px', '%', 'em' ],
		        'selectors'     => [
		            '{{WRAPPER}} .wl-pl-pricelist-single ' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

		$this->start_controls_tabs('Border Types');

		$this->start_controls_tab(
		    'card_regular_border',
		    [
		        'label' => __( 'Normal', 'woolementor' ),
		    ]
		);

        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'card_border',
				'label' => __( 'Border', 'woolementor' ),
				'selector' => '{{WRAPPER}} .wl-pl-pricelist-single',
			]
		);

		$this->end_controls_tab();
		
		$this->start_controls_tab(
		    'card_checked_border',
		    [
		        'label' => __( 'Checkd', 'woolementor' ),
		    ]
		);

        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'card_border_checked',
				'label' => __( 'Border', 'woolementor' ),
				'selector' => '{{WRAPPER}} .wl-pl-pricelist-single.wl-pl-checked',
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'card_Check_box',
			[
				'label' => __( 'Checkbox', 'woolementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
		    'card_checkbox_margin',
		    [
		        'label'         => __( 'Margin', 'woolementor' ),
		        'type'          => Controls_Manager::DIMENSIONS,
		        'size_units'    => [ 'px', '%', 'em' ],
		        'selectors'     => [
		            '{{WRAPPER}} .checkbox-custom + .wl-pl-checkbox-label::before' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

		$this->add_control(
		    'card_checkbox_padding',
		    [
		        'label'         => __( 'Padding', 'woolementor' ),
		        'type'          => Controls_Manager::DIMENSIONS,
		        'size_units'    => [ 'px', '%', 'em' ],
		        'selectors'     => [
		            '{{WRAPPER}} .checkbox-custom + .wl-pl-checkbox-label::before' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

		$this->add_control(
		    'card_checkbox_border',
		    [
		        'label'         => __( 'Border Radius', 'woolementor' ),
		        'type'          => Controls_Manager::DIMENSIONS,
		        'size_units'    => [ 'px', '%', 'em' ],
		        'selectors'     => [
		            '{{WRAPPER}} .checkbox-custom + .wl-pl-checkbox-label::before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

		$this->add_control(
		    'card_checkbox_border_color',
		    [
		        'label'         => __( 'Border Color', 'woolementor' ),
		        'type'          => Controls_Manager::COLOR,
		        'selectors'     => [
		            '{{WRAPPER}} .checkbox-custom + .wl-pl-checkbox-label::before' => 'border-color: {{VALUE}}',
		        ],
		    ]
		);

		$this->add_control(
		    'card_checkbox_bg_color',
		    [
		        'label'         => __( 'Checked Background Color', 'woolementor' ),
		        'type'          => Controls_Manager::COLOR,
		        'selectors'     => [
		            '{{WRAPPER}} .checkbox-custom:checked + .wl-pl-checkbox-label::before' => 'background-color: {{VALUE}}',
		        ],
		    ]
		);

		$this->add_control(
		    'card_checkbox_color',
		    [
		        'label'         => __( 'Checkd icon Color', 'woolementor' ),
		        'type'          => Controls_Manager::COLOR,
		        'selectors'     => [
		            '{{WRAPPER}} .checkbox-custom:checked + .wl-pl-checkbox-label::before' => 'color: {{VALUE}}',
		        ],
		    ]
		);

		$this->end_controls_section();

		 /**
		 * card title Style
		 */
		$this->start_controls_section(
			'card_title_style',
			[
				'label' => __( 'Title', 'woolementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
		    Group_Control_Typography::get_type(),
		    [
		        'name' => 'card_title_typography',
		        'scheme' => Typography::TYPOGRAPHY_3,
		        'selector' => '{{WRAPPER}} .wl-pl-item-name h4',
		    ]
		);

        $this->add_group_control(
            Group_Control_Gradient_Text::get_type(),
            [
                'name' => 'card_title_color',
                'selector' => '{{WRAPPER}} .wl-pl-item-name h4',
            ]
        );

		$this->end_controls_section();

		 /**
		 * card description Style
		 */
		$this->start_controls_section(
			'card_desc_style',
			[
				'label' => __( 'Description', 'woolementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
                    'variation_desc_show_hide' => 'yes'
                ],
			]
		);

		$this->add_group_control(
		    Group_Control_Typography::get_type(),
		    [
		        'name' => 'card_desc_typography',
		        'scheme' => Typography::TYPOGRAPHY_3,
		        'selector' => '{{WRAPPER}} .wl-pl-item-name .wl-pl-item-desc-text',
		    ]
		);

        $this->add_group_control(
            Group_Control_Gradient_Text::get_type(),
            [
                'name' => 'card_desc_color',
                'selector' => '{{WRAPPER}} .wl-pl-item-name .wl-pl-item-desc-text',
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'card_desc_bg_color',
                'selector' => '{{WRAPPER}} .wl-pl-item-name span',
            ]
        );

		$this->end_controls_section();

		 /**
		 * card attributes Style
		 */
		$this->start_controls_section(
			'card_attributes_style',
			[
				'label' => __( 'Attributes', 'woolementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' =>[
					'variation_attr_show_hide' => 'yes'
				]
			]
		);

		$this->add_group_control(
		    Group_Control_Typography::get_type(),
		    [
		        'name' => 'card_attributes_typography',
		        'scheme' => Typography::TYPOGRAPHY_3,
		        'selector' => '{{WRAPPER}} .wl-pl-item-details',
		    ]
		);

        $this->add_group_control(
            Group_Control_Gradient_Text::get_type(),
            [
                'name' => 'card_attributes_color',
                'selector' => '{{WRAPPER}} .wl-pl-item-details',
            ]
        );

        $this->add_control(
			'card_attributes_separator',
			[
				'label' => __( 'Separator color', 'woolementor' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Color::get_type(),
					'value' => Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .pl-item-attr' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

		 /**
		 * card Price Section Style
		 */
		$this->start_controls_section(
			'card_price_style',
			[
				'label' => __( 'Price Area', 'woolementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' =>[
					'variation_price_show_hide' => 'yes'
				]
			]
		);

		$this->add_group_control(
		    Group_Control_Typography::get_type(),
		    [
		        'name' => 'card_price_typography',
		        'scheme' => Typography::TYPOGRAPHY_3,
		        'selector' => '{{WRAPPER}} .wl-pl-item-total',
		    ]
		);

		$this->add_control(
			'card_price_height',
			[
				'label' => __( 'Height', 'woolementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 34,
				],
				'selectors' => [
					'{{WRAPPER}} .wl-pl-item-total' => 'padding-top: {{SIZE}}{{UNIT}}; padding-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'card_price_width',
			[
				'label' => __( 'Width', 'woolementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 40,
				],
				'selectors' => [
					'{{WRAPPER}} .wl-pl-item-total' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->start_controls_tabs('card price');

		$this->start_controls_tab(
		    'card_price',
		    [
		        'label' => __( 'Normal', 'woolementor' ),
		    ]
		);

        $this->add_group_control(
            Group_Control_Gradient_Text::get_type(),
            [
                'name' => 'card_price_color',
                'selector' => '{{WRAPPER}} .wl-pl-item-total span',
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'card_price_bg_color',
                'selector' => '{{WRAPPER}} .wl-pl-item-total',
            ]
        );

		$this->end_controls_tab();
		
		$this->start_controls_tab(
		    'card_price_cheked',
		    [
		        'label' => __( 'Checked', 'woolementor' ),
		    ]
		);

        $this->add_group_control(
            Group_Control_Gradient_Text::get_type(),
            [
                'name' => 'card_checked_price_color',
                'selector' => '{{WRAPPER}} .wl-pl-item-total.wl-pl-it-checked span',
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'card_checked_price_bg_color',
                'selector' => '{{WRAPPER}} .wl-pl-item-total.wl-pl-it-checked',
            ]
        );
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();

		 /**
		 * card total Style
		 */
		$this->start_controls_section(
			'card_total_price_style',
			[
				'label' => __( 'Total Price', 'woolementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'variation_price_show_hide' => 'yes'
				]
			]
		);

		$this->add_group_control(
		    Group_Control_Typography::get_type(),
		    [
		        'name' => 'card_total_price_typography',
		        'scheme' => Typography::TYPOGRAPHY_3,
		        'selector' => '{{WRAPPER}} .wl-pl-total',
		    ]
		);

        $this->add_group_control(
            Group_Control_Gradient_Text::get_type(),
            [
                'name' => 'card_total_price_color',
                'selector' => '{{WRAPPER}} .wl-pl-total',
            ]
        );
        $this->end_controls_section();

		 /**
		 * add to cart button Style
		 */
		$this->start_controls_section(
			'card_cart_btn_style',
			[
				'label' => __( 'Cart Button', 'woolementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
		    Group_Control_Typography::get_type(),
		    [
		        'name' => 'card_cart_btn_typography',
		        'scheme' => Typography::TYPOGRAPHY_3,
		        'selector' => '{{WRAPPER}} .wl-pl-btn ',
		    ]
		);

		$this->add_control(
			'border_radius',
			[
				'label' => __( 'Border Radius', 'woolementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'separator' => 'after',
				'selectors' => [
					'{{WRAPPER}} .wl-pl-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->start_controls_tabs('cart button');

		$this->start_controls_tab(
		    'card_cart_btn',
		    [
		        'label' => __( 'Normal', 'woolementor' ),
		    ]
		);

		$this->add_group_control(
		    Group_Control_Gradient_Text::get_type(),
		    [
		        'name' => 'card_cart_btn_color',
		        'selector' => '{{WRAPPER}} .wl-pl-btn .wl-pl-btn-text, {{WRAPPER}} .wl-pl-btn a',
		    ]
		);

		$this->add_group_control(
		    Group_Control_Background::get_type(),
		    [
		        'name' => 'card_cart_btn_bg_color',
		        'selector' => '{{WRAPPER}} .wl-pl-btn',
		    ]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'card_cart_btn_border',
				'label' => __( 'Border', 'woolementor' ),
				'selector' => '{{WRAPPER}} .wl-pl-btn',
			]
		);

		$this->end_controls_tab();
		$this->start_controls_tab(
		    'card_cart_btn_hover',
		    [
		        'label' => __( 'Hover', 'woolementor' ),
		    ]
		);

		$this->add_group_control(
		    Group_Control_Gradient_Text::get_type(),
		    [
		        'name' => 'card_cart_btn_hover_color',
		        'selector' => '{{WRAPPER}} .wl-pl-btn:hover .wl-pl-btn-text, {{WRAPPER}} .wl-pl-btn:hover a',
		    ]
		);

		$this->add_group_control(
		    Group_Control_Background::get_type(),
		    [
		        'name' => 'card_cart_btn_hover_bg_color',
		        'selector' => '{{WRAPPER}} .wl-pl-btn:hover',
		    ]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'card_cart_btn_hover_border',
				'label' => __( 'Border', 'woolementor' ),
				'selector' => '{{WRAPPER}} .wl-pl-btn:hover',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
	}

	protected function render() {

		$settings 	= $this->get_settings_for_display();
		extract( $settings );
		$product_id = $main_product_id;
		
		if ( 'current_product' == $content_source ) {
            $product_id = get_the_ID();
            if ( woolementor_is_edit_mode() || woolementor_is_preview_mode() ) {
            	$product_id 	= woolementor_get_product_id();
            }
        }

		if( 'product' != get_post_type( $product_id ) ) {
			echo woolementor_notice( 'This is not a product.' );
			return;
		}

		$currency 	= get_woocommerce_currency_symbol();
		$product 	= wc_get_product( $product_id );
		$variable 	= new \WC_Product_Variable( $product_id );
        $variation_ids = $variable->get_children();

		if ( count( $variation_ids ) < 1 ) {
			echo woolementor_notice( 'No Variation Found. May be this is not a variable product.' );
			return;
		}
		?>

		<div class="wl-pl-pricelist-area">
			<form class="wl-pl-pricelist-form" method="post">
				<input type="hidden" name="action" value="add-variations-to-cart">
				<input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
				<?php 
				wp_nonce_field( 'woolementor' );

				foreach ( $variation_ids as $variation_id ) : 
					$variation 	= new \WC_Product_Variation( $variation_id );
					$attributes = $variation->get_variation_attributes();
					$price 		= $variation->get_price_html();
					$price_int 	= $variation->get_price();
					$stock 		= $variation->get_stock_quantity();
					$description = get_post_meta( $variation_id, '_variation_description', true );
					$extra_attrs = woolementor_attrs_notin_variations( $attributes, $product );
					?>

					<div class="wl-pl-pricelist-single" data-id="<?php echo $variation_id; ?>">
						<input id="variation_<?php echo $variation_id; ?>" class="checkbox-custom" name="variation_checked[<?php echo $variation_id; ?>]" type="checkbox">
						<label for="variation_<?php echo $variation_id; ?>" class="wl-pl-checkbox-label">
							<div class="wl-pl-item-name">
								<h4><?php echo esc_html( $product->get_name() ); ?></h4>
								<?php if ( 'yes' == $variation_desc_show_hide && $description != '' ):?>
									<span class="wl-pl-item-desc"><span class="wl-pl-item-desc-text"><?php echo wp_trim_words( $description, $product_desc_words_count ); ?></span></span>
								<?php endif; ?>
							</div>

							<div class="wl-pl-pricelist-right">

								<?php if( 'yes' == $variation_attr_show_hide ): ?>
									<div class="wl-pl-item-details">

										<?php foreach( $attributes as $attribute ):
											if( $attribute != '' ): ?>
												<span class="pl-item-attr"><?php echo ucfirst( $attribute ); ?></span>
											<?php endif;
										endforeach; ?>

									</div>
								<?php endif; ?>

								<div class="wl-pl-inputes">
									<?php if( count( $extra_attrs ) > 0 ): ?>
										<div class="wl-pl-select">
											<table class="wl-pl-select-tbl">
												<?php foreach( $extra_attrs as $key => $attributes ): 
													$name = str_replace( 'attribute_', '', $key);
													$name = str_replace( 'pa_', '', $name);
													$name = str_replace( '_', ' ', $name);

													if( count( $attributes ) == 1 ){
														$attributes = explode( ',', $attributes[0]);
													}
													?>
													<tr>
														<td>
															<select name="attributes[<?php echo $variation_id; ?>][<?php echo $key; ?>]" class="wl-pl-variation-select" required=true>
																	<option value="<?php _e( 'Not Selected', 'woolementor' ); ?>"><?php _e( 'Select ', 'woolementor' ); echo ucfirst( $name ); ?></option>
																<?php foreach( $attributes as $attribute ): ?>
																	<option value="<?php echo $attribute; ?>"><?php echo $attribute; ?></option>
																<?php endforeach; ?>
															</select>
														</td>
													</tr>
												<?php endforeach; ?>
											</table>
										</div>
									<?php endif; ?>
									<div style="display: <?php echo 'yes' == $variation_qty_show_hide ? '' : 'none'; ?>" class="wl-pl-item-quantity-div">
										<div class="wl-pl-item-quantity">
											<input type="number" name="variation[<?php echo $variation_id; ?>]" min="0" max="<?php echo $stock; ?>" value=1>
										</div>
									</div>								
								</div>
								<?php if( 'yes' == $variation_price_show_hide ): ?>
									<div class="wl-pl-item-total">
										<input type="hidden" name="price[<?php echo $variation_id; ?>]" value="<?php echo $price_int; ?>">
										<span><?php echo $price; ?></span>
									</div>
								<?php endif; ?>
							</div>					
						</label>
					</div><!-- pricelist-single -->
	       		<?php endforeach; ?>

				<!-- pricelist bottom -->
				<div class="wl-pl-pricelist-bottom">
					<?php if( 'yes' == $variation_price_show_hide ): ?>
						<strong class="wl-pl-total"><?php echo esc_html( $currency ); ?> <span class="wl-pl-<?php echo esc_attr( $product_id ); ?>-total-price"><?php _e( '00.00', 'woolementor' ) ?></span></strong>
					<?php endif; ?>
					<button class="wl-pl-btn add-variations-to-cart" type="submit"><span class="wl-pl-btn-text"><?php _e( 'add to cart', 'woolementor' ) ?></span></button>
				</div>
			</form>
	    </div>
	    <script type="text/javascript">
	    	jQuery(function($){
	    		var $prices = {};
	    		$('.wl-pl-item-quantity').hide()
	    		$('.wl-pl-pricelist-single').on('click',function(e){

	    			var $sum 	= 0;
	    			var $par 	= $(this)
	    			var $id 	= $par.data( 'id' );
	    			var $qty 	= $('.wl-pl-item-quantity input', $par).val();
	    			<?php if( 'yes' != $variation_qty_show_hide ): ?>
	    				var $qty = 1;
	    			<?php endif; ?>
	    			var price 	= $('.wl-pl-item-total input', $par).val()

	    			if( $('.checkbox-custom', $par).is(":checked") ) {
	    				$('.wl-pl-item-quantity', $par).show()
	    				$('.wl-pl-item-total', $par).addClass('wl-pl-it-checked')
	    				$par.addClass('wl-pl-checked')
	    				$prices[ $id ] = parseFloat( price ) * parseInt( $qty )
	    			}
	    			else {
	    				$('.wl-pl-item-quantity', $par).hide()
	    				$('.wl-pl-item-total', $par).removeClass('wl-pl-it-checked')
	    				$par.removeClass('wl-pl-checked')
	    				$prices[ $id ] = 0

	    			}

	    			$.each( $prices,function(){ $sum+=parseFloat(this) || 0; } );
    				$('.wl-pl-<?php echo $product_id; ?>-total-price').html( parseFloat($sum).toFixed(2) )
	    		})
	    	})
	    </script>
	<?php
	
	}
}

