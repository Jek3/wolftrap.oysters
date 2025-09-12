<?php
namespace codexpert\Woolementor;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Css_Filter;

class Gallery_Lc_Lightbox extends Widget_Base {

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
		return [ "woolementor-{$this->id}", 'lc_lightbox' ];
	}

	public function get_style_depends() {
		return [ "woolementor-{$this->id}", 'lc_lightbox', 'minimal' ];
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
				'desktop_default' 	=> 6,
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
		 * Animations
		 */
		$this->start_controls_section(
			'section_gallery_animations',
			[
				'label' 		=> __( 'Animation', 'plugin-name' ),
				'tab' 			=> Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'gallery_animations_title',
			[
				'label' 		=> __( 'Title', 'woolementor' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'Show', 'your-plugin' ),
				'label_off' 	=> __( 'Hide', 'your-plugin' ),
				'return_value' 	=> 'yes',
				'default' 		=> 'yes',
			]
		);

		$this->add_control(
			'gallery_animations_descr',
			[
				'label' 		=> __( 'Description', 'woolementor' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'Show', 'your-plugin' ),
				'label_off' 	=> __( 'Hide', 'your-plugin' ),
				'return_value' 	=> 'yes',
				'default' 		=> 'yes',
			]
		);

		$this->add_control(
			'gallery_animations_color',
			[
				'label' 		=> __( 'Overlay Color', 'woolementor' ),
				'type' 			=> Controls_Manager::COLOR,
				'default' 		=> '#111111',
			]
		);

		$this->add_control(
			'gallery_animations_radius',
			[
				'label' 		=> __( 'Border Radius', 'woolementor' ),
				'type' 			=> Controls_Manager::NUMBER,
				'max' 			=> 100,
				'step' 			=> 1,
				'default' 		=> 4,
			]
		);

		$this->add_control(
			'gallery_animations_shadow',
			[
				'label' 		=> __( 'Box Shadow', 'woolementor' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'Yes', 'your-plugin' ),
				'label_off' 	=> __( 'No', 'your-plugin' ),
				'return_value' 	=> 'yes',
				'default' 		=> 'yes',
			]
		);

		$this->add_control(
			'gallery_animations_autoplay',
			[
				'label' 		=> __( 'Autoplay', 'woolementor' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'Yes', 'your-plugin' ),
				'label_off' 	=> __( 'No', 'your-plugin' ),
				'return_value' 	=> 'yes',
				'default' 		=> 'yes',
				'separator' 	=> 'before',
			]
		);

		$this->add_control(
			'gallery_animations_slideshow_time',
			[
				'label' 		=> __( 'Slide Speed', 'woolementor' ),
				'type' 			=> Controls_Manager::NUMBER,
				'min' 			=> 500,
				'step' 			=> 500,
				'default' 		=> 6000,
			]
		);

		$this->add_control(
			'gallery_animations_gallery',
			[
				'label' 		=> __( 'Gallery Mode', 'woolementor' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'Yes', 'your-plugin' ),
				'label_off' 	=> __( 'No', 'your-plugin' ),
				'return_value' 	=> 'yes',
				'default' 		=> 'yes',
			]
		);

		$this->add_control(
			'gallery_animations_thumbs_nav',
			[
				'label' 		=> __( 'Thumbnail Nav', 'woolementor' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'Yes', 'your-plugin' ),
				'label_off' 	=> __( 'No', 'your-plugin' ),
				'return_value' 	=> 'yes',
				'default' 		=> 'yes',
			]
		);

		$this->add_control(
			'gallery_animations_image_width',
			[
				'label' 		=> __( 'Image Width', 'woolementor' ),
				'type' 			=> Controls_Manager::NUMBER,
				'max' 			=> 100,
				'step' 			=> 1,
				'default' 		=> 80,
				'separator' 		=> 'before',
			]
		);

		$this->add_control(
			'gallery_animations_image_height',
			[
				'label' 		=> __( 'Image Height', 'woolementor' ),
				'type' 			=> Controls_Manager::NUMBER,
				'max' 			=> 100,
				'step' 			=> 1,
				'default' 		=> 80,
			]
		);

		$this->add_control(
			'gallery_animations_thumbs_w',
			[
				'label' 		=> __( 'Thumbnail Width', 'woolementor' ),
				'type' 			=> Controls_Manager::NUMBER,
				'max' 			=> 200,
				'step' 			=> 1,
				'default' 		=> 110,
			]
		);

		$this->add_control(
			'gallery_animations_thumbs_h',
			[
				'label' 		=> __( 'Thumbnail Height', 'woolementor' ),
				'type' 			=> Controls_Manager::NUMBER,
				'max' 			=> 200,
				'step' 			=> 1,
				'default' 		=> 110,
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
					'{{WRAPPER}} .wl-gll-single-image img' => 'width: {{SIZE}}{{UNIT}}',
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
					'{{WRAPPER}} .wl-gll-single-image img' => 'height: {{SIZE}}{{UNIT}}',
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
				'name' 			=> 'image_border',
				'label' 		=> __( 'Border', 'woolementor' ),
				'selector' 		=> '{{WRAPPER}} .wl-gll-single-image img',
			]
		);

		$this->add_responsive_control(
			'image_border_radius',
			[
				'label' 		=> __( 'Border Radius', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%' ],
				'selectors' 	=> [
					'{{WRAPPER}} .wl-gll-single-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' 			=> 'image_box_shadow',
				'label' 		=> __( 'Box Shadow', 'woolementor' ),
				'selector' 		=> '{{WRAPPER}} .wl-gll-single-image img',
			]
		);

		$this->add_control(
			'image_box_padding',
			[
				'label' 		=> __( 'Padding', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .wl-gll-single-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' 	=> 'before'
			]
		);

		$this->add_control(
			'image_box_margin',
			[
				'label' 		=> __( 'Margin', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .wl-gll-single-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .wl-gll-single-image img' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' 		=> 'image_css_filters',
				'selector' 	=> '{{WRAPPER}} .wl-gll-single-image img',
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
					'{{WRAPPER}} .wl-gll-single-image img:hover' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' 		=> 'image_css_filters_hover',
				'selector' 	=> '{{WRAPPER}} .wl-gll-single-image img:hover',
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
					'{{WRAPPER}} .wl-gll-single-image img:hover' => 'transition-duration: {{SIZE}}s',
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
		<div class="wl-gll-gallery">
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
						$attachment 	= woolementor_get_attachment( $image['id'] );

						echo'<div class="cx-col-md-'. esc_attr( 12 / $columns ) .' cx-col-sm-'. esc_attr( 12 / $columns_tablet ) .' cx-col-xs-'. esc_attr( 12 / $columns_mobile ) .'">';
						echo'<div class="wl-gll-single-wrapper">';
						
						echo '<span class="wl-gll-single-image" href="'. esc_url( $thumbnail_full[0] ) .'" title="'. esc_attr( wp_get_attachment_caption( $image['id'] ) ) .'" data-lcl-txt="'. esc_attr( $attachment['description'] ) .'">
						    <img src="'. esc_url( $thumbnail[0] ) .'" />
						</span>';

						echo'</div>';
						echo'</div>';
					endforeach; 
				}
				?>

			</div>
		</div>

		<?php
		/**
		 * Load Script
		 */
		$this->render_script();
	}

	protected function render_script() {
		$settings 	= $this->get_settings_for_display();
		extract( $settings );

		$_config = [
	        	'title'				=> $gallery_animations_title,
	        	'descr'				=> $gallery_animations_descr,
	        	'autoplay'			=> $gallery_animations_autoplay,
	        	'gallery'			=> $gallery_animations_gallery,
	        	'thumbs_nav'		=> $gallery_animations_thumbs_nav,
	        	'shadow'			=> $gallery_animations_shadow,
	        	'color'				=> $gallery_animations_color,
	        	'slideshow_time'	=> $gallery_animations_slideshow_time,
	        	'radius'			=> $gallery_animations_radius,
	        	'image_width'		=> $gallery_animations_image_width,
	        	'image_height'		=> $gallery_animations_image_height,
	        	'thumbs_w'			=> $gallery_animations_thumbs_w,
	        	'thumbs_h'			=> $gallery_animations_thumbs_h,
	        ];
		?>

		<script>
			jQuery(function($){
				var config 		= <?php echo json_encode( $_config ); ?>;

				var $title 		= config.title ? true : false;
				var $descr 		= config.descr ? true : false;
				var $autoplay 	= config.autoplay ? true : false;
				var $gallery 	= config.gallery ? true : false;
				var $thumbs_nav = config.thumbs_nav ? true : false;
				var $shadow 	= config.shadow ? true : false;

				lc_lightbox('.wl-gll-single-image', {
					show_title: 	$title, 
					show_descr: 	$descr, 
					autoplay: 		$autoplay, 
					gallery: 		$gallery, 
					thumbs_nav: 	$thumbs_nav, 
					shadow: 		$shadow,
					ol_color: 		config.color,
					slideshow_time: parseInt( config.slideshow_time ),
					radius: 		parseInt( config.radius ),
					max_width:  	parseInt( config.image_width ) + '%',
					max_height:  	parseInt( config.image_height ) + '%',
					thumbs_w: 		parseInt( config.thumbs_w ),
					thumbs_h: 		parseInt( config.thumbs_h ),
				});	
			})
		</script>

		<?php
	}
}
