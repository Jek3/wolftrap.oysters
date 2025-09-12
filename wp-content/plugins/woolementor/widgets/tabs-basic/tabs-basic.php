<?php
namespace codexpert\Woolementor;

use Elementor\Repeater;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use codexpert\Woolementor\Controls\Group_Control_Gradient_Text;

class Tabs_Basic extends Widget_Base {

	public $id;

	public function __construct( $data = [], $args = null ) {
	    parent::__construct( $data, $args );

	    $this->id = woolementor_get_widget_id( __CLASS__ );
	    $this->widget = woolementor_get_widget( $this->id );
	    
		// Are we in debug mode?
		$min = defined( 'WOOLEMENTOR_DEBUG' ) && WOOLEMENTOR_DEBUG ? '' : '.min';
		wp_enqueue_script("jquery-ui-tabs");

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
			'_section_settings_tabs',
			[
				'label' => __( 'Tabs', 'woolementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'tab_name', [
				'label' 		=> __( 'Title & Description', 'woolementor' ),
				'type' 			=> Controls_Manager::TEXT,
				'default' 		=> __( 'Tab Title' , 'woolementor' ),
				'label_block' 	=> true,
			]
		);

		$repeater->add_control(
			'tab_content_source',
			[
				'label' 		=> __( 'Content Source', 'woolementor' ),
				'type' 			=> Controls_Manager::SELECT2,
				'options' 		=> [
					'static_texts'	=> __( 'Static Texts', 'woolementor' ),
					'post_meta'  	=> __( 'Post Meta', 'woolementor' ),
				],
				'default' 		=> 'static_texts',
				'label_block' 	=> true,
			]
		);

		$repeater->add_control(
			'tab_content', [
				'label' 		=> __( 'Content', 'woolementor' ),
				'type' 			=> Controls_Manager::WYSIWYG,
				'default' 		=> __( 'Tabs Content' , 'woolementor' ),
				'condition' => [
                    'tab_content_source' => 'static_texts'
                ],
			]
		);

		$repeater->add_control(
			'tab_content_meta',
			[
				'label' 		=> __( 'Meta Key', 'woolementor' ),
				'type' 			=> Controls_Manager::SELECT2,
				'options' 		=> woolementor_get_meta_keys(),
				'condition' 	=> [
                    'tab_content_source' => 'post_meta'
                ],
				'label_block' 	=> true,
			]
		);

		$this->add_control(
			'tabs_list',
			[
				'label' 		=> __( 'Tabs List', 'woolementor' ),
				'type' 			=> Controls_Manager::REPEATER,
				'fields' 		=> $repeater->get_controls(),
				'default' 		=> [
					[
						'tab_name' 		=> __( 'Tab #1', 'woolementor' ),
						'tab_content' 	=> __( 'Item content. Click the edit button to change this text.', 'woolementor' ),
					],
					[
						'tab_name' 		=> __( 'Tab #2', 'woolementor' ),
						'tab_content' 	=> __( 'Item content. Click the edit button to change this text.', 'woolementor' ),
					],
				],
				'title_field' => '{{{ tab_name }}}',
			]
		);

		$this->add_control(
			'tabs_type',
			[
				'label' => __( 'Type', 'woolementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'wl-horizontal',
				'options' => [
					'wl-horizontal'	=> __( 'Horizontal', 'woolementor' ),
					'wl-vertical'	=> __( 'Vertical', 'woolementor' ),
				],
				'separator' => 'before'
			]
		);

		$this->end_controls_section();

		/**
		 * Tabs Style
		 */
		$this->start_controls_section(
			'section_style_tabs',
			[
				'label' => __( 'Tabs', 'woolementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'navigation_width',
			[
				'label' => __( 'Navigation Width', 'woolementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 100,
						'max' => 1000,
						'step' => 5,
					],
					'%' => [
						'min' => 10,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 20,
				],
				'selectors' => [
					'{{WRAPPER}} .wl-pt-navigation-wrapper' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'tabs_type' => 'wl-vertical'
				],
			]
		);

        $this->add_control(
			'tabs_nav_border_color',
			[
				'label' 		=> __( 'Border Color', 'woolementor' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .wl-pt-content-wrapper' => 'border-color: {{VALUE}}',
					'{{WRAPPER}} .wl-pt-navigation-wrapper ul' => 'border-color: {{VALUE}}',
					'{{WRAPPER}} .wl-pt-navigation-wrapper li.ui-tabs-active a' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'tabs_nav_border_size',
			[
				'label' => __( 'Border Size', 'woolementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 10,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 1,
				],
				'selectors' => [
					'{{WRAPPER}} .wl-pt-content-wrapper' => 'border-width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .wl-pt-navigation-wrapper ul' => 'border-width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .wl-pt-navigation-wrapper li.ui-tabs-active a' => 'border-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'tabs_nav_padding',
			[
				'label' 		=> __( 'Padding', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .wl-pt-navigation-wrapper li a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/**
		 * Tabs Title
		 */
		$this->start_controls_section(
			'section_style_tabs_title',
			[
				'label' => __( 'Title', 'woolementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'tabs_title_typography_normal',
				'label' 	=> __( 'Typography', 'woolementor' ),
				'scheme' 	=> Typography::TYPOGRAPHY_3,
				'selector' 	=> '{{WRAPPER}} .wl-pt-navigation-wrapper li a',
			]
		);

		$this->start_controls_tabs(
			'section_style_tabs_tabs',
			[
				'separator' => 'before'
			]
		);

		$this->start_controls_tab(
			'section_style_tabs_normal',
			[
				'label' 	=> __( 'Normal', 'woolementor' ),
			]
		);

		$this->add_group_control(
            Group_Control_Gradient_Text::get_type(),
            [
                'name' => 'tabs_title_color_normal',
                'selector' => '{{WRAPPER}} .wl-pt-navigation-wrapper li a',
            ]
        );

        $this->add_control(
			'tabs_nav_bg_color_normal',
			[
				'label' 		=> __( 'Background', 'woolementor' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .wl-pt-navigation-wrapper li a' => 'background: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'section_style_tabs_active',
			[
				'label' 	=> __( 'Active', 'woolementor' ),
			]
		);

		$this->add_group_control(
            Group_Control_Gradient_Text::get_type(),
            [
                'name' => 'tabs_title_color_active',
                'selector' => '{{WRAPPER}} .wl-pt-navigation-wrapper li.ui-tabs-active a',
            ]
        );

        $this->add_control(
			'tabs_nav_bg_color_active',
			[
				'label' 		=> __( 'Background', 'woolementor' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .wl-pt-navigation-wrapper li.ui-tabs-active a' => 'background: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();

		/**
		 * Tabs Content
		 */
		$this->start_controls_section(
			'section_style_tabs_content',
			[
				'label' => __( 'Content', 'woolementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'tabs_title_typography_content_normal',
				'label' 	=> __( 'Typography', 'woolementor' ),
				'scheme' 	=> Typography::TYPOGRAPHY_3,
				'selector' 	=> '{{WRAPPER}} .wl-pt-content-wrapper',
			]
		);

		$this->add_control(
			'tabs_content_text_color_normal',
			[
				'label' 		=> __( 'Font Color', 'woolementor' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .wl-pt-content-wrapper' => 'color: {{VALUE}}',
				],
			]
		);

        $this->add_control(
			'tabs_content_bg_color_normal',
			[
				'label' 		=> __( 'Background', 'woolementor' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .wl-pt-content-wrapper' => 'background: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {

		$settings 	= $this->get_settings_for_display();
        extract( $settings );
        $post_id 	= get_the_ID();
        ?>

        <div class="wl-product-tabs <?php echo esc_attr( $tabs_type ); ?>">

        	<div class="wl-pt-navigation-wrapper">
	        	<ul>
	        		<?php 
	        		foreach ( $tabs_list as $tab ) {
	        			echo '<li><a href="#tab-'. $tab['_id'] .'">'. esc_html( $tab['tab_name'] ) .'</a></li>';
	        		}
	        		?>
	        	</ul>
        	</div>
			
			<div class="wl-pt-content-wrapper">

        		<?php foreach ( $tabs_list as $tab ): ?>
        			<div id="tab-<?php echo $tab['_id']; ?>">
		        		<?php 
		        		if ( 'static_texts' == $tab['tab_content_source'] ) {
		        			echo wpautop( $tab['tab_content'] ); 
		        		}
		        		else{
		        			$value = get_post_meta( $post_id, $tab['tab_content_meta'], true );
		        			
		        			if ( !is_array( $value ) ) {
		        				echo $value;
		        			}
		        			else{
		        				echo __( 'Array', 'woolementor' );
		        			}
		        		}
		        		?>
		        	</div>
        		<?php endforeach; ?>
	        	
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
		<script type="text/javascript">
			jQuery(function($){
				$( ".wl-product-tabs" ).tabs();
			})
		</script>
		<?php
	}
}