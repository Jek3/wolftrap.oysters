<?php
namespace codexpert\Woolementor;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Css_Filter;
use codexpert\Woolementor\Controls\Group_Control_Gradient_Text;

class Gallery_Box_Slider extends Widget_Base {

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
		return [ "woolementor-{$this->id}", 'box-slider', 'modernizr' ];
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
		 * Settings controls
		 */
		$this->start_controls_section(
			'_section_settings',
			[
				'label' => __( 'Animation', 'woolementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'animation_effect',
			[
				'label' 	=> __( 'Animation Effect', 'woolementor' ),
				'type' 		=> Controls_Manager::SELECT2,
				'options' 	=> [
					// 'scrollVert3d'  => __( 'Scroll Vertical 3D', 'woolementor' ),
					// 'scrollHorz3d'  => __( 'Scroll Horizontal 3D', 'woolementor' ),
					'tile3d'  		=> __( 'Tile 3D', 'woolementor' ),
					'tile'  		=> __( 'Tile', 'woolementor' ),
					'scrollVert'  	=> __( 'Scroll Vertical', 'woolementor' ),
					'scrollHorz'  	=> __( 'Scroll Horizontal', 'woolementor' ),
					'blindLeft'  	=> __( 'Blind Left', 'woolementor' ),
					'blindDown'  	=> __( 'Blind Down', 'woolementor' ),
					'fade'  		=> __( 'Fade', 'woolementor' ),
				],
				'default' 	=> 'scrollHorz',
			]
		);

		$this->add_control(
			'animation_responsive',
			[
				'label' 		=> __( 'Responsive', 'woolementor' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'On', 'woolementor' ),
				'label_off' 	=> __( 'Off', 'woolementor' ),
				'return_value' 	=> 'yes',
				'default' 		=> 'yes',
			]
		);

		$this->add_control(
			'animation_pauseOnHover',
			[
				'label' 		=> __( 'PauseOnHover', 'woolementor' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'On', 'woolementor' ),
				'label_off' 	=> __( 'Off', 'woolementor' ),
				'return_value' 	=> 'yes',
				'default' 		=> 'yes',
			]
		);

		$this->add_control(
			'animation_autoScroll',
			[
				'label' 		=> __( 'AutoScroll', 'woolementor' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'On', 'woolementor' ),
				'label_off' 	=> __( 'Off', 'woolementor' ),
				'return_value' 	=> 'yes',
				'default' 		=> 'yes',
			]
		);

		$this->add_control(
			'animation_speed',
			[
				'label' 		=> __( 'Speed', 'woolementor' ),
				'type' 			=> Controls_Manager::NUMBER,
				'default' 		=> 800,
			]
		);

		$this->add_control(
			'animation_timeout',
			[
				'label' 		=> __( 'Timeout', 'woolementor' ),
				'type' 			=> Controls_Manager::NUMBER,
				'default' 		=> 500,
			]
		);

		$this->add_control(
			'animation_perspective',
			[
				'label' 		=> __( 'Perspective', 'woolementor' ),
				'type' 			=> Controls_Manager::NUMBER,
				'default' 		=> 1000,
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
				'default' 	=> 'full',
			]
		);

		$this->add_responsive_control(
			'image_height',
			[
				'label' 	=> __( 'Image Height', 'woolementor' ),
				'type' 		=> Controls_Manager::SLIDER,
				'size_units'=> [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} #wl-gbs-box' => 'height: {{SIZE}}{{UNIT}} !important',
					'{{WRAPPER}} .wl-gbs-box > .wl-gbs-slide img' => 'height: {{SIZE}}{{UNIT}} !important',
				],
				'range' 	=> [
					'px' 	=> [
						'min' 	=> 1,
						'max' 	=> 1000
					],
					'em' 	=> [
						'min' 	=> 1,
						'max' 	=> 30
					],
				],
			]
		);

		$this->add_responsive_control(
			'image_width',
			[
				'label' 	=> __( 'Image Width', 'woolementor' ),
				'type' 		=> Controls_Manager::SLIDER,
				'size_units'=> [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} #wl-gbs-box' => 'width: {{SIZE}}{{UNIT}} !important',
				],
				'range' 	=> [
					'px' 	=> [
						'min' 	=> 1,
						'max' 	=> 1000
					],
					'em' 	=> [
						'min' 	=> 1,
						'max' 	=> 30
					],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 		=> 'image_border',
				'label' 	=> __( 'Border', 'woolementor' ),
				'selector' 	=> '{{WRAPPER}} .wl-gbs-slide img',
			]
		);

		$this->add_responsive_control(
			'image_border_radius',
			[
				'label' 		=> __( 'Border Radius', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%' ],
				'selectors' 	=> [
					'{{WRAPPER}} .wl-gbs-slide img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' 		=> 'image_box_shadow',
				'label' 	=> __( 'Box Shadow', 'woolementor' ),
				'selector' 	=> '{{WRAPPER}} .wl-gbs-slide img',
			]
		);

		$this->add_control(
			'image_box_padding',
			[
				'label' => __( 'Padding', 'woolementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .wl-gbs-slide' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .wl-gbs-slide' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .wl-gbs-slide img' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' 		=> 'image_css_filters',
				'selector' 	=> '{{WRAPPER}} .wl-gbs-slide img',
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
					'{{WRAPPER}} .wl-gbs-slide img:hover' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' 		=> 'image_css_filters_hover',
				'selector' 	=> '{{WRAPPER}} .wl-gbs-slide img:hover',
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
					'{{WRAPPER}} .wl-gbs-slide img:hover' => 'transition-duration: {{SIZE}}s',
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

		if( 'custom_selection' == $image_source ) {
			$image_gallery = $image_gallery_custom_selection;
		}
		else{
			$image_gallery = $image_gallery_current_product;
		}

		if ( count( $image_gallery ) > 0 ) :
		?>
		
		<div class="wl-gbs-gallery">
			<section>
				<div id="wl-gbs-viewport">
					<div id="wl-gbs-box" class="wl-gbs-box">

						<?php 
						foreach ( $image_gallery as $image ): 
							$thumbnail 		= wp_get_attachment_image_src( $image['id'], $image_thumbnail_size );

							echo'<div class="wl-gbs-slide">';
							echo '<img src="'. esc_url( $thumbnail[0] ) .'" />';
							echo'</div>';
						endforeach; ?>

					</div>
				</div>
			</section>
		</div>
		
		<?php endif;
		
		/**
		 * Load Script
		 */
		$this->render_script();
	}

	protected function render_script() {
		$settings 	= $this->get_settings_for_display();
		extract( $settings );

		$_config = [
        	'animation_effect'			=> $animation_effect,
        	'animation_responsive'		=> $animation_responsive,
        	'animation_pauseOnHover'	=> $animation_pauseOnHover,
        	'animation_autoScroll'		=> $animation_autoScroll,
        	'animation_speed'			=> $animation_speed,
        	'animation_timeout'			=> $animation_timeout,
        	'animation_perspective'		=> $animation_perspective,
        ];
		?>

		<script>
			$ = new jQuery.noConflict()
			$(function($){
				var config 	= <?php echo json_encode( $_config ); ?>;

				$('.wl-gbs-box').boxSlider({
					effect: config.animation_effect,
					responsive: config.animation_responsive,
					pauseOnHover: config.animation_pauseOnHover,
					autoScroll: config.animation_autoScroll, 
					speed: parseInt(config.animation_speed),
					timeout: parseInt(config.animation_timeout),
					perspective: parseInt(config.animation_perspective),
				});
			})
		</script>
		<?php
	}
}
