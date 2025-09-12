<?php
namespace codexpert\Woolementor;

use Elementor\Repeater;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;

class Tabs_Classic extends Widget_Base {

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
				'label' 		=> __( 'Title', 'woolementor' ),
				'type' 			=> Controls_Manager::TEXT,
				'default' 		=> __( 'Tab Title' , 'woolementor' ),
				'label_block' 	=> true,
			]
		);

        $repeater->add_control(
			'tab_bg_color',
			[
				'label' 		=> __( 'Color', 'woolementor' ),
				'type' 			=> Controls_Manager::COLOR,
				'separator'		=> 'after',
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
				'default' 		=> __( 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.' , 'woolementor' ),
				'condition' => [
                    'tab_content_source' => 'static_texts'
                ],
				'show_label' 	=> false,
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
						'tab_bg_color' 	=> '#E9345F',
						'tab_content' 	=> __( 'Item content of Tab #1. Click the edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua', 'woolementor' ),
					],
					[
						'tab_name' 		=> __( 'Tab #2', 'woolementor' ),
						'tab_bg_color' 	=> '#4054B2',
						'tab_content' 	=> __( 'Item content of Tab #2. Click the edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua', 'woolementor' ),
					],
					[
						'tab_name' 		=> __( 'Tab #3', 'woolementor' ),
						'tab_bg_color' 	=> '#FF7B00',
						'tab_content' 	=> __( 'Item content of Tab #3. Click the edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua', 'woolementor' ),
					],
				],
				'title_field' => '{{{ tab_name }}}',
			]
		);

		$this->end_controls_section();

		/**
		*Tab items controll
		*/
		$this->start_controls_section(
			'_section_tabs_style',
			[
				'label' => __( 'Tabs', 'woolementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'tabs_title_typography',
				'label' 	=> __( 'Typography', 'woolementor' ),
				'scheme' 	=> Typography::TYPOGRAPHY_1,
				'selector' 	=> '{{WRAPPER}} .wl-tc-tab .wl-tc-tab-title',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'tab_shadow',
				'label' => __( 'Tab Shadow', 'woolementor' ),
				'selector' => '{{WRAPPER}} .wl-tc-tab, {{WRAPPER}} .wl-tc-panels',
			]
		);


		$this->add_control(
			'panel_width',
			[
				'label' => __( 'Width', 'woolementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1500,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 60,
				],
				'selectors' => [
					'{{WRAPPER}} .wl-tc-panels' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'panel_height',
			[
				'label' => __( 'Height', 'woolementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1500,
						'step' => 5,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 200,
				],
				'selectors' => [
					'{{WRAPPER}} .wl-tc-panels' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {

		$settings 	= $this->get_settings_for_display();
        extract( $settings );
        $post_id 	= get_the_ID();
        $style 		= '';
        $section_id = $this->get_raw_data()['id'];
        ?>

        <div class="wl-tc-wrapper wl-<?php echo $section_id; ?>-tc-wrapper">

	        <?php $tab_count = 0; foreach ( $tabs_list as $key => $tab ) : 
	        	$checked = '';
	        	if ( $tab_count == 0 ) {
	        		$checked = 'checked';
	        	}
	        	?>
	        	<input class="wl-tc-radio wl-tc-<?php echo $tab['_id']; ?>-radio" id="<?php echo $tab['_id']; ?>" name="wl_tabs_classic-<?php echo $section_id; ?>" type="radio" data-id="<?php echo $tab['_id']; ?>" <?php echo $checked; ?>>
	        <?php $tab_count++; endforeach; ?>

	        <div class="wl-tc-tabs">
	        	<?php $tab_count = 0; foreach ( $tabs_list as $key => $tab ) : 
	        		$wl_class = '';
	        		if ( $tab_count == 0 ) {
	        			$wl_class = 'wl-tc-tab-active';
	        		}
	        		$style .= "
	        		.wl-tc-{$tab['_id']}-tab{background-color:{$tab['tab_bg_color']}}
	        		.wl-tc-tabs .wl-tc-{$tab['_id']}-tab.wl-tc-tab-active .wl-tc-tab-title{color:{$tab['tab_bg_color']} !important}
	        		.wl-tc-{$tab['_id']}-tab.wl-tc-tab-active{border-color:{$tab['tab_bg_color']} !important}";
	        		?>
	        		<label id="<?php echo $tab['_id']; ?>" style="background: <?php echo $tab['tab_bg_color']; ?>;"
	        		class="wl-tc-tab wl-tc-<?php echo $tab['_id']; ?>-tab <?php echo $wl_class; ?>"  
	        		for="<?php echo $tab['_id']; ?>"><span class="wl-tc-tab-title"><?php echo $tab['tab_name'];?></span></label>
	        	<?php $tab_count++; endforeach; ?>
	        </div>

	        <div class="wl-tc-panels">
	        	<?php $tab_count = 0; foreach ( $tabs_list as $key => $tab ) : 
	        		$wl_class = '';
	        		if ( $tab_count == 0 ) {
	        			$wl_class = 'wl-tc-panel-active';
	        		}
	        		?>
	        		<div class="wl-tc-panel wl-tc-<?php echo $tab['_id']; ?>-panel <?php echo $wl_class; ?>">
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
	        	<?php $tab_count++; endforeach;?>
	        </div>

    	</div>

    	<style>
	    	<?php echo $style; ?>
	    </style>
    		
		<?php
		/**
         * Load Script
         */
        $this->render_script();
	}

	protected function render_script() {
		$settings 	= $this->get_settings_for_display();
        extract( $settings );
        $section_id = $this->get_raw_data()['id'];
		?>
		<script type="text/javascript">
			jQuery(function($){
				$('.wl-<?php echo $section_id; ?>-tc-wrapper .wl-tc-radio').on('click',function(e){
					var $this = $( this );
					var par = $this.closest('.wl-tc-wrapper');
	    			var id = $this.data( 'id' );
	    			if( $(this).is(":checked") ) {
	    				$( '.wl-tc-tab', par ).removeClass('wl-tc-tab-active');
	    				$( '.wl-tc-'+id+'-tab', par ).addClass('wl-tc-tab-active');
	    				$( '.wl-tc-panel', par ).removeClass('wl-tc-panel-active');
	    				$( '.wl-tc-'+id+'-panel', par ).addClass('wl-tc-panel-active');
	    			}
	    		})
			})
		</script>
		<?php
	}
}