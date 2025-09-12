<?php
namespace codexpert\Woolementor;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Css_Filter;

class Gallery_Fancybox extends Widget_Base {

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
				'desktop_default' 	=> 4,
				'tablet_default' 	=> 4,
				'mobile_default' 	=> 2,
				'style_transfer' 	=> true,
			]
		);

		$this->end_controls_section();

		/**
		 * Image Gallery
		 */
		$this->start_controls_section(
			'section_image_gallery',
			[
				'label' 		=> __( 'Gallery', 'plugin-name' ),
				'tab' 			=> Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'image_source',
			[
				'label' => __( 'Image Source', 'woolementor' ),
				'type' => Controls_Manager::SELECT2,
				'options' => [
					'current_product'  => __( 'From Current Product', 'woolementor' ),
					'custom_selection' => __( 'Custom Selection', 'woolementor' ),
				],
				'default' => [ 'current_product' ],
				'label_block' => true,
			]
		);

		$this->add_control(
			'image_gallery_current_product',
			[
				'label' 		=> __( 'Add Images', 'woolementor' ),
				'type' 			=> Controls_Manager::GALLERY,
				'default' 		=> woolementor_product_gallery_images( get_the_ID() ),
                'condition' 	=> [
                    'image_source' => 'current_product'
                ],
			]
		);

		$this->add_control(
			'image_gallery_custom_selection',
			[
				'label' 		=> __( 'Add Images', 'woolementor' ),
				'type' 			=> Controls_Manager::GALLERY,
                'condition' 	=> [
                    'image_source' => 'custom_selection'
                ],
			]
		);

		$this->end_controls_section();

		/**
		 * Image controls
		 */
		$this->start_controls_section(
			'section_style_image',
			[
				'label' => __( 'Image', 'woolementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' 		=> 'image_thumbnail',
				'default' 	=> 'woolementor-thumb',
			]
		);

		$this->add_responsive_control(
			'image_width',
			[
				'label' 	=> __( 'Image Width', 'woolementor' ),
				'type' 		=> Controls_Manager::SLIDER,
				'size_units'=> [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .wl-gf-single-image img' => 'width: {{SIZE}}{{UNIT}}',
				],
				'range' 	=> [
					'px' 	=> [
						'min' 	=> 1,
						'max' 	=> 500
					],
					'em' 	=> [
						'min' 	=> 1,
						'max' 	=> 30
					],
				],
			]
		);

		$this->add_responsive_control(
			'image_height',
			[
				'label' 	=> __( 'Image Height', 'woolementor' ),
				'type' 		=> Controls_Manager::SLIDER,
				'size_units'=> [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .wl-gf-single-image img' => 'height: {{SIZE}}{{UNIT}}',
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
			Group_Control_Border::get_type(),
			[
				'name' 		=> 'image_border',
				'label' 	=> __( 'Border', 'woolementor' ),
				'selector' 	=> '{{WRAPPER}} .wl-gf-single-image img',
			]
		);

		$this->add_responsive_control(
			'image_border_radius',
			[
				'label' 		=> __( 'Border Radius', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%' ],
				'selectors' 	=> [
					'{{WRAPPER}} .wl-gf-single-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' 		=> 'image_box_shadow',
				'label' 	=> __( 'Box Shadow', 'woolementor' ),
				'selector' 	=> '{{WRAPPER}} .wl-gf-single-image img',
			]
		);

		$this->add_control(
			'image_box_padding',
			[
				'label' => __( 'Padding', 'woolementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .wl-gf-single-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before'
			]
		);

		$this->add_control(
			'image_box_margin',
			[
				'label' => __( 'Margin', 'woolementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .wl-gf-single-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs(
			'image_effects',
			[
				'separator' => 'before'
			]
		);

		$this->start_controls_tab(
			'image_effects_normal',
			[
				'label' 	=> __( 'Normal', 'woolementor' ),
			]
		);

		$this->add_control(
			'image_opacity',
			[
				'label' 	=> __( 'Opacity', 'woolementor' ),
				'type' 		=> Controls_Manager::SLIDER,
				'range' 	=> [
					'px' 	=> [
						'max' 	=> 1,
						'min' 	=> 0.10,
						'step' 	=> 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wl-gf-single-image img' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' 		=> 'image_css_filters',
				'selector' 	=> '{{WRAPPER}} .wl-gf-single-image img',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'image_hover',
			[
				'label' 	=> __( 'Hover', 'woolementor' ),
			]
		);

		$this->add_control(
			'image_opacity_hover',
			[
				'label' 	=> __( 'Opacity', 'woolementor' ),
				'type' 		=> Controls_Manager::SLIDER,
				'range' 	=> [
					'px' 	=> [
						'max' 	=> 1,
						'min' 	=> 0.10,
						'step' 	=> 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wl-gf-single-image img:hover' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' 		=> 'image_css_filters_hover',
				'selector' 	=> '{{WRAPPER}} .wl-gf-single-image img:hover',
			]
		);

		$this->add_control(
			'image_hover_transition',
			[
				'label' 	=> __( 'Transition Duration', 'woolementor' ),
				'type' 		=> Controls_Manager::SLIDER,
				'range' 	=> [
					'px' 	=> [
						'max' 	=> 3,
						'step' 	=> 0.1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wl-gf-single-image img:hover' => 'transition-duration: {{SIZE}}s',
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
		$product_id = get_the_ID();
		$product 	= wc_get_product( $product_id );
		?>

		<div class="wl-gf-gallery">
			<div class="cx-container">
				<div class="cx-row">

					<?php 
					if( 'custom_selection' == $image_source ) {
						$image_gallery = $image_gallery_custom_selection;
					}
					else{
						$image_gallery = $image_gallery_current_product;
					}

					if ( count( $image_gallery ) > 0 ) {
					 	foreach ( $image_gallery as $image ): 
					 		$thumbnail 		= wp_get_attachment_image_src( $image['id'], $image_thumbnail_size );
					 		$thumbnail_full = wp_get_attachment_image_src( $image['id'], 'full' );

					 		echo'<div class="cx-col-md-'. esc_attr( 12 / $columns ) .' cx-col-sm-'. esc_attr( 12 / $columns_tablet ) .' cx-col-xs-'. esc_attr( 12 / $columns_mobile ) .'">';
					 		echo'<div class="wl-gf-single-wrapper">';
					 		echo '<span class="wl-gf-single-image" href="'. esc_url( $thumbnail_full[0] ) .'" title="'. esc_html( wp_get_attachment_caption( $image['id'] ) ) .'">
					 		    <img src="'. esc_url( $thumbnail[0] ) .'" />
					 		</span>';
					 		echo'</div>';
					 		echo'</div>';

					 	 endforeach;
					 } 
					 ?>

				</div>
			</div>
		</div>

		<?php
		/**
		 * Load Script
		 */
		$this->render_script();
	}

	protected function render_script() {
		?>
		<script>
			jQuery(function($){
				$(".wl-gf-single-image").fancybox({
	                arrows: true,

				}).attr('data-fancybox', 'gallery');
			})
		</script>
		<?php
	}
}
